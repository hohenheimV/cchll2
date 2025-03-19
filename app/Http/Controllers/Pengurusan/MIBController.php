<?php

namespace App\Http\Controllers\Pengurusan;

use App\Http\Controllers\Controller;
use App\Exports\MIBExport;
use App\Model\MIB;
use App\Model\MIB_laporan;
use App\Model\MaklumatPenggunaPbt;
use App\User;
use Carbon\Carbon;
use Error;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\UploadedFile;

class MIBController extends Controller
{
    protected $status;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware(['role_or_permission:Pentadbir Sistem|mib-list']);
        $this->middleware(['role_or_permission:Pentadbir Sistem|mib-create'], ['only' => ['create', 'store']]);
        $this->middleware(['role_or_permission:Pentadbir Sistem|mib-edit'], ['only' => ['edit', 'update']]);
        $this->middleware(['role_or_permission:Pentadbir Sistem|mib-delete'], ['only' => ['destroy']]);
        
        $status = ['Baru', 'Diperakui', 'Diluluskan'];
        $this->statusArr = array_combine($status, $status);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //validate
        if ($request->only('keyword')) {
            $request->validate([
                'keyword' => 'required|min:3|max:255|regex:/(^[A-Za-z0-9\/\-\_\@ ]+$)+/',
            ]);
        }
        // dd(MIB::count());
        $count = MIB::count();
        $MIB = MIB::when($request->keyword, function ($q) use ($request) { //Bila ada keyword
            $q->where(function ($query) use ($request) {
				$query->whereRaw('lower(name) LIKE ? ', ['%' . trim(strtolower($request->keyword)) . '%'])
					->orWhereRaw('lower(status) LIKE ? ', ['%' . trim(strtolower($request->keyword)) . '%'])
                    ->orWhereRaw('lower(ref_num) LIKE ? ', ['%' . trim(strtolower($request->keyword)) . '%']);
            });
        })->latest()->paginate($count);

        $MIB->appends($request->only('keyword'));

        return view('pengurusan.MIB.index', ['MIB' => $MIB]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pengurusan.MIB.create', ['status' => $this->statusArr]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        // Mula Rule validation
        $rules = [
            'name'   => 'required',
            'email'   => 'required|email',
            'message'  => 'required',
        ];

        //Selaras bentuk mesej yang sama; attributes berbeza
        $messages = [
            'required'  => ':attribute diperlukan.',
            'email'  => ':attribute tidak sah.'
        ];

        // Rename field ke perkataan boleh difaham (jika perlu/berlainan)
        $attributes = [];

        $validator = Validator::make($request->all(), $rules, $messages, $attributes)->validate();

        $ref = Carbon::now()->timestamp;
        $data = $request->all();
        $data['ref_num'] = "F$ref";
        $data['MIB_at'] = Carbon::now()->format('Y-m-d H:i:s');

        // define data field of Model
        $MIB = MIB::create($data);

        // redirect to
        return redirect()->route('pengurusan.MIB.index')->with('successMessage', 'Maklumat telah berjaya disimpan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\MIB  $MIB
     * @return \Illuminate\Http\Response
     */
    public function show(MIB $MIB)
    {
        // dd($MIB->id);
        $count = MIB_laporan::count();
        $MIB_laporan = MIB_laporan::where('id_rakan', $MIB->id)->latest()->paginate($count);
        return view('pengurusan.MIB.show', ['MIB' => $MIB, 'status' => $this->statusArr, 'MIB_laporan' => $MIB_laporan]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\MIB  $MIB
     * @return \Illuminate\Http\Response
     */
    public function edit(MIB $MIB)
    {
        // $MIB->message = json_decode($MIB->message, true);
        // dd($message);
        return view('pengurusan.MIB.edit', ['MIB' => $MIB, 'status' => $this->statusArr]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\MIB  $MIB
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MIB $MIB)
    {
        // Mula Rule validation
        $rules = [
            'name'   => 'required|min:3',
            'email'   => 'required|email',
            'jawatankuasa' => 'required|min:3',
        ];
        //Selaras bentuk mesej yang sama; attributes berbeza
        $messages = [
            'required' => ':attribute diperlukan.',
            'min' => ':attribute terlalu ringkas.',
            'max' => ':attribute terlalu panjang.',
            'regex' => ':attribute tidak sah.',
        ];
        // Rename field ke perkataan boleh difaham (jika perlu/berlainan)
        $data = $request->all();
        // dd($data);

        if (strtolower($request->action) == 'approve') {
            if (strtolower($request->status) == 'diperakui') {
                $data['responsed_by'] = Auth::user()->name;
                $data['responsed_at'] = Carbon::now()->format('Y-m-d H:i:s');
                $data['form_attachment'] = $data['notes'];
                $data['notes'] = null;
                $MIB->update($data);
                // send email to JLN Promosi
                if(config('mail.enabled')){
                    $this->sendmailtoadmin($MIB);
                }
                return redirect()->route('pengurusan.MIB.index')->with('successMessage', 'Maklumat telah berjaya disimpan');
            }
            if (strtolower($request->status) == 'diluluskan') {
                $data['approved_by'] = Auth::user()->name;
                $data['approved_at'] = Carbon::now()->format('Y-m-d H:i:s');
                $data['officer'] = $data['notes'];
                $data['notes'] = null;
                $MIB->update($data);
                // send email to PBT
                if(config('mail.enabled')){
                    $this->sendmailtopemohon($MIB);
                }
                return redirect()->route('pengurusan.MIB.index')->with('successMessage', 'Maklumat telah berjaya disimpan');
            }
        }

        $keysToCheck = [
            'pengerusi_nama', 'pengerusi_tel_bimbit', 'pengerusi_email',
            'timbalan_pengerusi_nama', 'timbalan_pengerusi_tel_bimbit', 'timbalan_pengerusi_email',
            'setiausaha_nama', 'setiausaha_tel_bimbit', 'setiausaha_email',
            'bendahari_nama', 'bendahari_tel_bimbit', 'bendahari_email',
            'ajk1_nama', 'ajk1_tel_bimbit', 'ajk1_email',
            'ajk2_nama', 'ajk2_tel_bimbit', 'ajk2_email',
            'ajk3_nama', 'ajk3_tel_bimbit', 'ajk3_email',
            'ajk4_nama', 'ajk4_tel_bimbit', 'ajk4_email',
            'ajk5_nama', 'ajk5_tel_bimbit', 'ajk5_email',
            'ajk6_nama', 'ajk6_tel_bimbit', 'ajk6_email'
        ];

        // Group the data by 3
        $data = $request->all();//$request->only($keysToCheck);
        $groupedData = [];
        for ($i = 0; $i < count($keysToCheck); $i += 3) {
            if(isset($data[$keysToCheck[$i]]) || isset($data[$keysToCheck[$i + 1]]) || isset($data[$keysToCheck[$i + 2]])){    
                $group = [
                    $keysToCheck[$i] => $data[$keysToCheck[$i]] ?? null,
                    $keysToCheck[$i + 1] => $data[$keysToCheck[$i + 1]] ?? null,
                    $keysToCheck[$i + 2] => $data[$keysToCheck[$i + 2]] ?? null,
                ];
                $groupedData[] = $group;
                // dump($keysToCheck[$i]);
                // dump($keysToCheck[$i + 1]);
                // dump($keysToCheck[$i + 2]);
            }
        }
        // $jsonData = json_encode($groupedData, JSON_PRETTY_PRINT);
        $data['jawatankuasa'] = $groupedData;
        // $data['taman'] = "Taman 2";

        if(isset($data['kawasan'])){
            $mergedkawasan = [];
            $kawasanArr = $data['kawasan'];
            foreach ($kawasanArr as $key => $value) {
                $kawasan = collect($value ?? [])
                ->map(function($item) {
                    return $item;
                })
                ->toArray();
                if ($kawasan['nama'] !== null) {
                    $mergedkawasan[] = $kawasan;
                }
            }
            $data['kawasan'] = ($mergedkawasan);
        }

        if (isset($data['fail'])) {
            $mergedfail = [];
            $failArr = $data['fail'];
            foreach ($failArr as $key => $value) {
                if ($value instanceof UploadedFile && $value->isValid()) {
                    $folderName = str_replace(' ', '_', $data['taman']);
                    $filename = time() . '_' . $value->getClientOriginalName();
                    $path = $value->storeAs('public/uploads/MIB/' . $folderName, $filename);
                    $mergedfail[$key] = $filename;
                } else {
                    $mergedfail[$key] = $MIB->fail[$key];
                }
            }
            $data['fail'] = ($mergedfail);
        }  
        // dd($data);
        $attributes = [];

        $validator = Validator::make($data, $rules, $messages, $attributes)->validate();
        if ($validator instanceof \Illuminate\Http\RedirectResponse) {
            return $validator;
        }

		// if (strtolower($request->status) == 'diperakui') {
        //     $data['responsed_by'] = Auth::user()->name;
        //     $data['responsed_at'] = Carbon::now()->format('Y-m-d H:i:s');
        //     $data['form_attachment'] = $data['notes'];
        // }
        // if (strtolower($request->status) == 'diluluskan') {
        //     $data['approved_by'] = Auth::user()->name;
        //     $data['approved_at'] = Carbon::now()->format('Y-m-d H:i:s');
        //     $data['officer'] = $data['notes'];
        // }
        // $data['notes'] = null;

        $MIB->update($data);

        if (strtolower($request->status) == 'diperakui') {
            // send email to JLN Promosi
        }
        if (strtolower($request->status) == 'diluluskan') {
            // send email to PBT
        }
        // dd($MIB);
        // redirect to
        return redirect()->route('pengurusan.MIB.index')->with('successMessage', 'Maklumat telah berjaya disimpan');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\MIB  $MIB
     * @return \Illuminate\Http\Response
     */
    public function destroy(MIB $MIB)
    {
        if ($MIB->delete()) {
            return redirect()->route('pengurusan.MIB.index')->with('successMessage', 'Maklumat telah berjaya dihapuskan');
        }
        return redirect()->route('pengurusan.MIB.index')->with('errorMessage', 'Maklumat telah gagal dihapuskan');
    }

    public function download(MIB $MIB)
    {
        $path = 'files/MIB/' . $MIB->id . '/';

        if(Storage::disk('public')->exists($path . $MIB->form_attachment)){
            return Storage::disk('public')->download($path . $MIB->form_attachment);
        }
        return redirect()->route('pengurusan.MIB.index')->with('errorMessage', 'Fail tidak wujud, sila cuba lagi.');

    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function export_all(Request $request)
    {

        if ($request->isMethod('post')) {

            $MIB = MIB::limit(110)
                ->when($request->response_at, function ($q) use ($request) {
                    $q->where(function ($qry) use ($request) {
                        $qry->where('MIB_at', date('Y-m-d', strtotime($request->MIB_at)));
                    });
                })
                ->when($request->response_at, function ($q) use ($request) {
                    $q->where(function ($qry) use ($request) {
                        $qry->where('response_at', date('Y-m-d', strtotime($request->response_at)));
                    });
                })
                ->when($request->status, function ($q) use ($request) {
                    $q->where(function ($qry) use ($request) {
                        $qry->where('status', $request->status);
                    });
                })
                ->get();

            if (count($MIB) > 0) {
                return (new MIBExport($MIB))->download('MIB-collection-' . time() . '.xlsx', \Maatwebsite\Excel\Excel::XLSX);
            }

            return redirect()->route('pengurusan.exports.MIB.all')->with('warningMessage', 'Carian tidak dijumpai');
        }

        $status = $this->statusArr;
        $status = array_combine($status, $status);


        return view('pengurusan.MIB.export', compact('status'));
    }

    private function sendmailtopemohon($MIB)
    {
        $PBT = MaklumatPenggunaPbt::where('pbt_name', '=', $MIB->pbt)->first();
        $PBTArr = ($PBT) !== null ? $PBT : [];
        $PBTid = $PBTArr->id ?? '';
        $PBTuser = User::where('bahagian_jln', '=', $PBTid)->where('is_active', 1)->get();
        $PBTemail = [];
        foreach ($PBTuser as $key => $value) {
            $PBTemail[] = ['address' => $value->email, 'name' => $value->name];
        }
        // dd($PBTemail);
        $data["email"] = $MIB->email;
        $data["client_name"] = $MIB->name;
        $data["subject"] = "Permohonan Pendaftaran Rakan Taman (No Ruj: $MIB->ref_num)";

        try {

            Mail::send('pengurusan.MIB.mails.salinan', ['MIB' => $MIB], function ($message) use ($data, $PBTemail) {
                $message->subject($data["subject"]);
                foreach ($PBTemail as $recipient) {
                    $message->to($recipient['address'], $recipient['name']);
                }
                $message->cc($data['email'], $data['client_name']);
            });
        } catch (Error $exception) {
            
             $exception->getMessage();
        }

       
        return true;
        // return redirect()->route('website.activities.index')->with($this->statuscode, $this->statusdesc);
    }

    private function sendmailtoadmin($MIB)
    {
        $bahagian_jln = 8;  //Bahagian Promosi
        $user_email = [];

        $emailArr = User::where(function ($query) use ($bahagian_jln) {
            $query->whereHas('roles', function ($query) {
                    $query->where('name', 'Pentadbir Sistem');
                });
            })
            ->orWhere(function ($query) use ($bahagian_jln) {
                $query->whereHas('roles', function ($query) {
                    $query->where('name', 'Pegawai');
                })
                ->where('bahagian_jln', '7');
            })
            ->orWhere(function ($query) use ($bahagian_jln) {
                $query->whereHas('roles', function ($query) {
                    $query->where('name', 'Pegawai');
                })
                ->where('bahagian_jln', $bahagian_jln);
            })
            ->get();
        foreach ($emailArr as $key => $value) {
            $user_email[] = ['address' => $value->email, 'name' => $value->name];
        }
        // dd($user_email);

        $data["email"] = config('mail.from.address'); //'kpjln@jln.gov.my';
        $data["client_name"] = config('mail.from.name'); //'KP JLN';
        $data["subject"] = "Permohonan Pendaftaran Rakan Taman (No Ruj: $MIB->ref_num)";

        try {

            Mail::send('pengurusan.MIB.mails.permohonan', ['MIB' => $MIB], function ($message) use ($data, $user_email) {
                $message->subject($data["subject"]);
                foreach ($user_email as $recipient) {
                    // $message->to($recipient['address'], $recipient['name']);
                }
                $message->cc($data['email'], $data['client_name']);
            });
        } catch (Error $exception) {
             $exception->getMessage();
        }
        
        return true;
        // return redirect()->route('website.activities.index')->with($this->statuscode, $this->statusdesc);
    }

}

