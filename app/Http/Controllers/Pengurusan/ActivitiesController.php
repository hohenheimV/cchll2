<?php

namespace App\Http\Controllers\Pengurusan;

use App\Http\Controllers\Controller;
use App\Exports\ActivitiesExport;
use App\Model\Activity;
use App\User;
use Spatie\Permission\Models\Role;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

use Error;

class ActivitiesController extends Controller
{
    protected $statusArr;

    protected $flow;
    protected $action;
    protected $status;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware(['role_or_permission:Pentadbir Sistem|activity-list']);
        $this->middleware(['role_or_permission:Pentadbir Sistem|activity-create'], ['only' => ['create', 'store']]);
        $this->middleware(['role_or_permission:Pentadbir Sistem|activity-edit'], ['only' => ['edit', 'update']]);
        $this->middleware(['role_or_permission:Pentadbir Sistem|activity-delete'], ['only' => ['destroy']]);

        $status = ['Permohonan Baru', 'Dalam Tindakan', 'Pengesahan Sokongan', 'Pengesahan Kelulusan', 'Lulus', 'Tidak Lulus'];
        $this->status = $status;
        $this->statusArr = array_combine($status, $status);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $status = '';// by default

        $statusArr = $this->status;

        $statusArr = array_combine($statusArr, $statusArr);


        if (Auth::user()->hasRole('Pengurus Taman')) {
            $status = 'permohonan_baru';
        } else if (Auth::user()->hasRole('Pengarah Taman')) {
            $status = 'pengesahan_sokongan';
        } else if (Auth::user()->hasRole('KP/ TKP JLN')) {
            $status = 'pengesahan_kelulusan';
        } else if (Auth::user()->hasRole('Penggiat Industri')) {
            $status = 'lulus';
        }

        // dump($action);
        //validate
        if ($request->only('keyword')) {
            $request->validate([
                'keyword' => 'nullable|min:3|max:255|regex:/(^[A-Za-z0-9\/\-\_\@ ]+$)+/',
            ]);
        }
        //validate
        if ($request->only('status')) {
            $status = $request->status;
        }

        $activities = Activity::when($request->keyword, function ($q) use ($request) { //Bila ada keyword
            $q->where(function ($query) use ($request) {
                $query->whereRaw('lower(name) LIKE ? ', ['%' . trim(strtolower($request->keyword)) . '%'])
                    ->orWhereRaw('lower(status) LIKE ? ', ['%' . trim(strtolower($request->keyword)) . '%'])
                    ->orWhereRaw('lower(ref_num) LIKE ? ', ['%' . trim(strtolower($request->keyword)) . '%']);
            });
        })->when($status, function ($q) use ($status) { //Bila ada keyword
            $q->whereRaw('lower(status) = lower(?)', [str_replace("_", " ", filter_var($status, FILTER_SANITIZE_SPECIAL_CHARS))]);
        })->latest()->paginate();

        $activities->appends($request->only('page'));

        return view('pengurusan.activities.index', ['status' => $status, 'activities' => $activities, 'statusArr' => $statusArr]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $status = $this->statusArr;
        return view('pengurusan.activities.create', ['status ' => $status]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd($request->all());
        // Mula Rule validation
        $rules = [
            'borang' => 'nullable|file|mimes:jpeg,bmp,png,pdf,zip|max:5048',
            'surat' => 'nullable|file|mimes:jpeg,bmp,png,pdf,zip|max:5048',
            'jadual' => 'nullable|file|mimes:jpeg,bmp,png,pdf,zip|max:5048',
            'attachment' => 'nullable|file|mimes:jpeg,bmp,png,pdf,zip|max:5048',
            'organizer' => 'required|min:3|max:255',
            'title' => 'required|min:3|max:255',
            'description' => 'required|min:3',
            'email' => 'required|email',
            'name' => 'required|min:3|max:255',
            'phone' => 'required|regex:/^(\+?6?0?1)[0-9]{7,8}$/',
            //'fax' => 'required|regex:/^(\+?6?0)[0-9]{6,9}$/',
        ];
        //Selaras bentuk mesej yang sama; attributes berbeza
        $messages = [
            'required' => ':attribute diperlukan.',
            'min' => ':attribute terlalu ringkas.',
            'max' => ':attribute terlalu panjang.',
            'regex' => ':attribute tidak sah.',
        ];
        // Rename field ke perkataan boleh difaham (jika perlu/berlainan)
        $attributes = [
            'borang' => 'Borang Permohonan Yang Telah Lengkap Diisi',
            'surat' => 'Surat Permohonan Rasmi',
            'jadual' => 'Jadual Program/Aktiviti',
        ];

        $validator = Validator::make($request->all(), $rules, $messages, $attributes)->validate();



        $ref = Carbon::now()->timestamp;
        $data = $request->all();
        //dd($request->all());
        $data['apply_at'] = Carbon::now()->format('Y-m-d H:i:s');
        $data['start_at'] = Carbon::parse($request->start_at)->format('Y-m-d H:i:s');
        $data['end_at'] = Carbon::parse($request->end_at)->format('Y-m-d H:i:s');
        //$data['tempoh_id'] = $request->slot_radio;
        $data['ref_num'] = "JLN$ref";
        if ($request->has('attachment')) {
            $attachmentName = "JLN$ref" . '_' . Carbon::now()->format('Ymdhis') . '.' . $request->file('attachment')->extension();
            $data['approved_attachment'] = $attachmentName;
        } else {
            $data['approved_attachment'] = null;
        }
        if ($request->has('borang')) {
            $data['form_attachment'] = "borang-$ref" . '.' . $request->file('borang')->extension();
        } else {
            $data['form_attachment'] = null;
        }
        if ($request->has('surat')) {
            $data['form_surat'] = "surat-$ref" . '.' . $request->file('surat')->extension();
        } else {
            $data['form_surat'] = null;
        }
        if ($request->has('jadual')) {
            $data['form_jadual'] = "jadual-$ref" . '.' . $request->file('jadual')->extension();
        } else {
            $data['form_jadual'] = null;
        }

        // $data = Arr::except($data, ['attachment', 'form_attachment', 'form_surat', 'form_jadual']);
        // define data field of Model
        $activity = Activity::create($data);

        if ($request->has('attachment')) {
            Storage::disk('public')->putFileAs(
                'files/activity/' . $activity->id,
                $request->file('attachment'),
                $activity->approved_attachment
            );
        }
        if ($request->has('borang')) {
            Storage::disk('public')->putFileAs(
                'files/activity/' . $activity->id,
                $request->file('borang'),
                $activity->form_attachment
            );
        }
        if ($request->has('surat')) {
            Storage::disk('public')->putFileAs(
                'files/activity/' . $activity->id,
                $request->file('surat'),
                $activity->form_surat
            );
        }
        if ($request->has('jadual')) {
            Storage::disk('public')->putFileAs(
                'files/activity/' . $activity->id,
                $request->file('jadual'),
                $activity->form_jadual
            );
        }

       // $this->sendmailtopendaftaran($activity);

        // redirect to
        return redirect()->route('pengurusan.activities.index')->with('successMessage', 'Maklumat telah berjaya dihantar');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Activity  $activity
     * @return \Illuminate\Http\Response
     */
    public function show(Activity $activity)
    {

        return view('pengurusan.activities.show', ['activity' => $activity]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Activity  $activity
     * @return \Illuminate\Http\Response
     */
    public function edit(Activity $activity)
    {

        $peranan = ['Pemohon'];

        $flow = 1;
        $action = 1;
        $status = $this->status;
        if (Auth::user()->hasRole('Pengurus Taman')) {
            $peranan = ['Pengarah Taman', 'Pemohon'];
            $status = ['Permohonan Baru', 'Dalam Tindakan', 'Pengesahan Sokongan', 'Tidak Lulus'];
        } else if (Auth::user()->hasRole('Pengarah Taman')) {
            $peranan = ['KP/ TKP JLN', 'Pemohon'];
            $status = ['Pengesahan Sokongan', 'Pengesahan Kelulusan', 'Tidak Lulus'];
        } else if (Auth::user()->hasRole('KP/ TKP JLN')) {
            $peranan = ['Pemohon'];
            $status = ['Pengesahan Kelulusan', 'Lulus', 'Tidak Lulus'];
        }

        $status = array_combine($status, $status);

        return view('pengurusan.activities.edit', ['activity' => $activity, 'status' => $status]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Activity  $activity
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Activity $activity)
    {
        // dd($request->all());
        // Mula Rule validation
        $rules = [
            'borang' => 'nullable|file|mimes:jpeg,bmp,png,pdf,zip|max:5048',
            'surat' => 'nullable|file|mimes:jpeg,bmp,png,pdf,zip|max:5048',
            'jadual' => 'nullable|file|mimes:jpeg,bmp,png,pdf,zip|max:5048',
            'attachment' => 'nullable|file|mimes:jpeg,bmp,png,pdf,zip|max:5048',
            'organizer' => 'required|min:3|max:255',
            'title' => 'required|min:3|max:255',
            'description' => 'required|min:3',
            'email' => 'required|email',
            'name' => 'required|min:3|max:255',
            'phone' => 'required|regex:/^(\+?6?0?1)[0-9]{7,8}$/',
            //'fax' => 'required|regex:/^(\+?6?0)[0-9]{6,9}$/',
            'approved_at'=>'required_if:status,Lulus'
        ];
        //Selaras bentuk mesej yang sama; attributes berbeza
        $messages = [
            'required' => ':attribute diperlukan.',
            'min' => ':attribute terlalu ringkas.',
            'max' => ':attribute terlalu panjang.',
            'regex' => ':attribute tidak sah.',
        ];
        // Rename field ke perkataan boleh difaham (jika perlu/berlainan)
        $attributes = [
            'borang' => 'Borang Permohonan Yang Telah Lengkap Diisi',
            'surat' => 'Surat Permohonan Rasmi',
            'jadual' => 'Jadual Program/Aktiviti',
            'approved_at'=>'Tarikh Kelulusan'
        ];

        $validator = Validator::make($request->all(), $rules, $messages, $attributes)->validate();

        $data = $request->all();


        if (Auth::user()->hasAnyRole(['Pentadbir Sistem', 'Pengurus Taman']) && $request->status == 'Pengesahan Sokongan') { //F2,A1

            $data['action'] = 1;
            $data['flow'] = 2;
            $data['note_officer_lvl_1'] = $request->note_officer_lvl_1;
        } else if (Auth::user()->hasAnyRole(['Pentadbir Sistem', 'Pengarah Taman']) && $request->status == 'Pengesahan Kelulusan') { //F3,A2

            $data['action'] = 2;
            $data['flow'] = 3;
            $data['note_officer_lvl_2'] = $request->note_officer_lvl_2;
        } else if (Auth::user()->hasAnyRole(['Pentadbir Sistem', 'KP/ TKP JLN'])) { //F4,A3

            $data['action'] = 3;
            $data['flow'] = 4;
            $data['note_officer_lvl_3'] = $request->note_officer_lvl_3;
        }

        $ref = Carbon::now()->timestamp;

        //dd($request->all());
        $data['apply_at'] = Carbon::now()->format('Y-m-d H:i:s');
        $data['start_at'] = Carbon::parse($request->start_at)->format('Y-m-d H:i:s');
        $data['end_at'] = Carbon::parse($request->end_at)->format('Y-m-d H:i:s');
        $data['ref_num'] = "JLN$ref";
        if ($request->has('attachment')) {
            $attachmentName = $activity->ref_num . '_' . Carbon::now()->format('Ymdhis') . '.' . $request->file('attachment')->extension();
            $data['approved_attachment'] = $attachmentName;
        } else {
            $data['approved_attachment'] = $activity->approved_attachment;
        }
        if ($request->has('borang')) {
            $data['form_attachment'] = "borang-$ref" . '.' . $request->file('borang')->extension();
        } else {
            $data['form_attachment'] = $activity->form_attachment;
        }
        if ($request->has('surat')) {
            $data['form_surat'] = "surat-$ref" . '.' . $request->file('surat')->extension();
        } else {
            $data['form_surat'] = $activity->form_surat;
        }
        if ($request->has('jadual')) {
            $data['form_jadual'] = "jadual-$ref" . '.' . $request->file('jadual')->extension();
        } else {
            $data['form_jadual'] = $activity->form_jadual;
        }

        $data['officer'] = Auth::user()->name;

        if (strtolower($request->status) == 'lulus') {
            $data['approved_at'] = Carbon::now()->format('Y-m-d H:i:s');
        }


        // define data field of Model
        $activity->update($data);

        if ($request->has('attachment')) {
            Storage::disk('public')->putFileAs(
                'files/activity/' . $activity->id,
                $request->file('attachment'),
                $activity->approved_attachment
            );
        }

        if ($request->has('borang')) {
            Storage::disk('public')->putFileAs(
                'files/activity/' . $activity->id,
                $request->file('borang'),
                $activity->form_attachment
            );
        }
        if ($request->has('surat')) {
            Storage::disk('public')->putFileAs(
                'files/activity/' . $activity->id,
                $request->file('surat'),
                $activity->form_surat
            );
        }
        if ($request->has('jadual')) {
            Storage::disk('public')->putFileAs(
                'files/activity/' . $activity->id,
                $request->file('jadual'),
                $activity->form_jadual
            );
        }

        if (
            Auth::user()->hasAnyRole(['Pentadbir Sistem', 'Pengurus Taman'])
            && $request->status == 'Pengesahan Sokongan'
        ) { //F2,A1

            if ($emailto = $this->perananTaman('Pengarah Taman')) {
                $this->sendmailtopentadbir($activity, 'Sokongan', $emailto);
            } else if ($request->status == 'Tidak Lulus') {
                $this->sendmailtopemohon($activity, 'Tidak');
            }
        } else if (
            Auth::user()->hasAnyRole(['Pentadbir Sistem', 'Pengarah Taman'])
            && $request->status == 'Pengesahan Kelulusan'
        ) { //F3,A2

            if ($emailto = $this->perananTaman('KP/ TKP JLN')) {
                $this->sendmailtopentadbir($activity, 'Kelulusan',  $emailto);
            } else if ($request->status == 'Tidak Lulus') {
                $this->sendmailtopemohon($activity, 'Tidak');
            }
        } else if (Auth::user()->hasAnyRole(['Pentadbir Sistem', 'KP/ TKP JLN'])) { //F4,A3

            if ($request->status == 'Lulus') {
                $this->sendmailtopemohon($activity, 'Lulus');
            } else if ($request->status == 'Tidak Lulus') {
                $this->sendmailtopemohon($activity, 'Tidak');
            }
        }

        // redirect to
        return redirect()->route('pengurusan.activities.index')->with('successMessage', 'Maklumat telah berjaya dikemaskini');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Activity  $activity
     * @return \Illuminate\Http\Response
     */
    public function destroy(Activity $activity)
    {
        if ($activity->delete()) {
            return redirect()->route('pengurusan.activities.index')->with('successMessage', 'Maklumat telah berjaya dihapuskan');
        }
        return redirect()->route('pengurusan.activities.index')->with('errorMessage', 'Maklumat telah gagal dihapuskan');
    }


    public function download($type = null, Activity $activity)
    {

        $path = 'files/activity/' . $activity->id . '/';
        if ($type == 'kelulusan') {
            if (Storage::disk('public')->exists($path . $activity->approved_attachment)) {
                return Storage::disk('public')->download($path . $activity->approved_attachment);
            }
            return redirect()->route('pengurusan.activities.index')->with('errorMessage', 'Fail tidak wujud, sila cuba lagi.');
        } else if ($type == 'borang') {
            if (Storage::disk('public')->exists($path . $activity->form_attachment)) {
                return Storage::disk('public')->download($path . $activity->form_attachment);
            }
            return redirect()->route('pengurusan.activities.index')->with('errorMessage', 'Fail tidak wujud, sila cuba lagi.');
        } else if ($type == 'surat') {
            if (Storage::disk('public')->exists($path . $activity->form_surat)) {
                return Storage::disk('public')->download($path . $activity->form_surat);
            }
            return redirect()->route('pengurusan.activities.index')->with('errorMessage', 'Fail tidak wujud, sila cuba lagi.');
        } else if ($type == 'jadual') {
            if (Storage::disk('public')->exists($path . $activity->form_jadual)) {
                return Storage::disk('public')->download($path . $activity->form_jadual);
            }
            return redirect()->route('pengurusan.activities.index')->with('errorMessage', 'Fail tidak wujud, sila cuba lagi.');
        }
        // else {
        //     if (Storage::disk('public')->exists($path . $activity->approved_attachment)) {
        //         return Storage::disk('public')->download($path . $activity->approved_attachment);
        //     }
        //     return redirect()->route('pengurusan.activities.index')->with('errorMessage', 'Fail tidak wujud, sila cuba lagi.');
        // }
        return redirect()->route('pengurusan.activities.index')->with('errorMessage', 'Fail tidak wujud, sila cuba lagi.');
    }


    /**
     * @return \Illuminate\Support\Collection
     */
    public function export_all(Request $request)
    {

        if ($request->isMethod('post')) {

            $activities = Activity::limit(110)
                ->when($request->apply_at, function ($q) use ($request) {
                    $q->where(function ($qry) use ($request) {
                        $qry->where('apply_at', date('Y-m-d', strtotime($request->apply_at)));
                    });
                })
                ->when($request->start_at, function ($q) use ($request) {
                    $q->where(function ($qry) use ($request) {
                        $qry->where('start_at', date('Y-m-d', strtotime($request->start_at)));
                    });
                })
                ->when($request->end_at, function ($q) use ($request) {
                    $q->where(function ($qry) use ($request) {
                        $qry->where('end_at', date('Y-m-d', strtotime($request->end_at)));
                    });
                })
                ->when($request->status, function ($q) use ($request) {
                    $q->where(function ($qry) use ($request) {
                        $qry->where('status', $request->status);
                    });
                })
                ->get();

            if (count($activities) > 0) {
                return (new ActivitiesExport($activities))->download('activities-collection-' . time() . '.xlsx', \Maatwebsite\Excel\Excel::XLSX);
            }

            return redirect()->route('pengurusan.exports.activities.all')->with('warningMessage', 'Carian tidak dijumpai');
        }

        $status = $this->statusArr;
        $status = array_combine($status, $status);


        return view('pengurusan.activities.export', compact('status'));
    }

    /**
     * Email pemakluman kepada pemohon
     * 1. LULUS
     * 2. GAGAL
     * 
     */ 
    private function sendmailtopemohon($activity, $status = null)
    {
        if(config('mail.enabled')){//MAIL ACTIVE, fungsi email enable
            dump($activity->email);
            $data["email_to_address"] = $activity->email;//'azlina@spatialsynergy.com.my';//unkomen utk test
            $data["email_to_name"] = 'Azlina';
            //$data["email_to_address"] = $activity->email;//komen utk test
            //$data["email_to_name"] = $activity->name;

            $data["email_cc_address"] = 'norazlinatumiran@gmail.com';//unkomen utk test
            //$data["email_cc_address"] = config('mail.cc.address');//komen utk test
            $data["email_cc_name"] = 'TPBK'; //'TPBK';

            $data["subject"] = 'STATUS PERMOHONAN PENGGUNAAN TAMAN PERSEKUTUAN BUKIT KIARA';

            $data["status"] = $status;

            try {

                Mail::send('pengurusan.activities.mails.keputusan', ['activity' => $activity, 'status' => $status], function ($message) use ($data) {
                    $message->subject($data["subject"])
                        ->to($data["email_to_address"], $data["email_to_name"])
                        ->cc($data["email_cc_address"], $data["email_cc_name"])
                        // ->bcc('frenemies.888@gmail.com')
                        ->subject($data["subject"]);
                });
            } catch (Error $exception) {
                $this->serverstatuscode = "0";
                $this->serverstatusdes = $exception->getMessage();
            }
            if (Mail::failures()) {
                $this->statusdesc  =   "Error sending mail";
                $this->statuscode  =   "warningMessage";
            } else {
                $this->statusdesc  =   "Message sent Succesfully";
                $this->statuscode  =   "successMessage";
            }
            return redirect()->route('pengurusan.activities.index')->with($this->statuscode, $this->statusdesc);
        }
        return true;
    }

    /**
     * Hantar email kepada
     * 1. KP JKN
     * 2. Admin TPBK
     * 3. Pegawai Pengurus Taman (optional)
     */
    private function sendmailtopendaftaran($activity)
    {
    if(config('mail.enabled')){//MAIL ACTIVE, fungsi email enable
            //located config/mail.php OR .env
            //$data["email_to_address"] = '<email_dummy_utk_test>';//unkomen utk test
            $data["email_to_address"] = config('mail.from.address');//komen utk test
            $data["email_to_name"] = config('mail.from.name'); //'KP JLN';

            //$data["email_cc_address"] = '<email_dummy_utk_test>';//unkomen utk test
            $data["email_cc_address"] = config('mail.cc.address'); //komen utk test
            $data["email_cc_name"] = config('mail.cc.name'); //'TPBK';

            $data["subject"] = 'PERMOHONAN BAHARU PENGGUNAAN TAMAN PERSEKUTUAN BUKIT KIARA';

            $data["form_attachment"] = Storage::disk('public')
                ->path('files/activity/' . $activity->id . '/' . $activity->form_attachment);
            $data["form_surat"] = Storage::disk('public')
                ->path('files/activity/' . $activity->id . '/' . $activity->form_surat);
            $data["form_jadual"] = Storage::disk('public')
                ->path('files/activity/' . $activity->id . '/' . $activity->form_jadual);

            try {

                Mail::send('pengurusan.activities.mails.pendaftaran', ['activity' => $activity], function ($message) use ($data) {
                    $message->subject($data["subject"])
                        ->to($data["email_to_address"], $data["email_to_name"])
                        //cc bahagian taman
                        ->cc($data["email_cc_address"], $data["email_cc_name"])
                        ->bcc('frenemies.888@gmail.com')
                        ->attach($data["form_attachment"])
                        ->attach($data["form_surat"])
                        ->attach($data["form_jadual"]);
                });
            } catch (Error $exception) {
                $this->serverstatuscode = "0";
                $this->serverstatusdes = $exception->getMessage();
            }
            if (Mail::failures()) {
                $this->statusdesc  =   "Error sending mail";
                $this->statuscode  =   "warningMessage";
            } else {
                $this->statusdesc  =   "Message sent Succesfully";
                $this->statuscode  =   "successMessage";
            }
            return redirect()->route('website.activities.index')->with($this->statuscode, $this->statusdesc);
        }
        return true;
    }

    /**
     * Fungsi senaraikan pegawai mengikut peranan
     * Jenis Peranan
     * 1. Pengurus Taman
     * 2. Pengarah Taman
     * 3. KP/ TKP JLN
     * 
     */
    private function perananTaman($role)
    {
        // unkomen utk testing
        //$user = Role::where('name', '=', $role)->first()->users()->selectRaw("name, 'email_test@gmail.com' as email")->get();
        
        // komen utk testing
        $user = Role::where('name', '=', $role)->first()->users()->select('name', 'email')->get();
        if ($user) {
            return $user;
        }
        return null;
    }

    /**
     * Hantar email kepada
     * Sokongan     : Pengarah Taman
     * Kelulusan    : KP/ TKP JLN
     * Lulus/Gagal  : Pemohon & KP JLN & Admin TPBK
     */
    private function sendmailtopentadbir($activity, $status = null, $emailto)
    {
        if(config('mail.enabled')){//MAIL ACTIVE, fungsi email enable
            $subject = '';

            switch ($status) {
                case 'Sokongan':
                    // code...
                    $subject = 'Tindakan E-mel kepada Pengesahan Sokongan (Pengarah Taman)';
                    break;

                case 'Kelulusan':
                    // code...
                    $subject = 'Tindakan E-mel kepada Pengesahan Kelulusan (KP/ TKP JLN)';
                    break;

                case 'Lulus':
                    // code...
                    $subject = 'E-mel Permohonan berjaya kepada Pemohon';
                    break;

                case 'Tidak Lulus':
                    // code...
                    $subject = 'E-mel Permohonan tidak berjaya kepada Pemohon';
                    break;
            }

            //send email by each officer 
            foreach ($emailto as $email) {
                $data["email_to_address"] = $email['email'];
                $data["email_to_name"] = $email['name'];
				

                $data["subject"] = $subject; //'PERMOHONAN BAHARU PENGGUNAAN TAMAN PERSEKUTUAN BUKIT KIARA';

                try {

                    Mail::send('pengurusan.activities.mails.pentadbiran', ['activity' => $activity,'status' => $status], function ($message) use ($data) {
                        $message->subject($data["subject"])
                            ->to($data["email_to_address"], $data["email_to_name"]);
                    });
                } catch (Error $exception) {
                    $this->serverstatuscode = "0";
                    $this->serverstatusdes = $exception->getMessage();
                }
            }
            if (Mail::failures()) {
                $this->statusdesc  =   "Error sending mail";
                $this->statuscode  =   "warningMessage";
            } else {
                $this->statusdesc  =   "Message sent Succesfully";
                $this->statuscode  =   "successMessage";
            }
            return redirect()->route('pengurusan.activities.index')->with($this->statuscode, $this->statusdesc);
        }
        return true;
    }
}
