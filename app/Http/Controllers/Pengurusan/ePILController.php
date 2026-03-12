<?php

namespace App\Http\Controllers\Pengurusan;

use App\Http\Controllers\Controller;
use App\Model\ePIL;
use App\Model\ePIL_draf;
use App\Model\ePIL_dokumen;
use App\Model\MaklumatPenggunaPbt;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;


class ePILController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware(['role_or_permission:Pentadbir Sistem|epil-list']);
        $this->middleware(['role_or_permission:Pentadbir Sistem|epil-create'], ['only' => ['create', 'store']]);
        $this->middleware(['role_or_permission:Pentadbir Sistem|epil-edit'], ['only' => ['edit', 'update']]);
        $this->middleware(['role_or_permission:Pentadbir Sistem|epil-delete'], ['only' => ['destroy']]);
    }

    public function index()
    {
        
        $userId = auth()->id();
        $user = User::find($userId);
        if($user->hasRole('Pihak Berkuasa Tempatan')){
            $email = $user->bahagian_jln;
            $pbt = MaklumatPenggunaPbt::where('id', '=', $email)->first();
            $totalCount = ePIL::whereRaw('LOWER(nama_pbt) = ?', [strtolower($pbt->pbt_name)])->count();
            $ePIL = ePIL::whereRaw('LOWER(nama_pbt) = ?', [strtolower($pbt->pbt_name)])->orderBy('id_pelan', 'desc')->paginate($totalCount);
            foreach ($ePIL as $key => $value) {
                $ePIL_draf = ePIL_draf::where('id_pelan', $value->id_pelan)->first();
                $value->status = $ePIL_draf->status;
            }
        }else{
            $totalCount = ePIL::count();
            $ePIL = ePIL::orderBy('id_pelan', 'desc')->paginate($totalCount);
        }
        // dd($ePIL);
        $ePIL->getCollection()->transform(function ($PIL) {
            $dokumen = ePIL_dokumen::where('status', 'active')->where('id_pelan', $PIL->id_pelan)->first();
            $PIL->nama_dokumen_pelan = $dokumen ? $PIL->gambar_dokumen_pelan : null;
            $PIL->id_dokumen_pelan = $dokumen ? $dokumen->id_dokumen_pelan : null;
            // dump($dokumen);
    
            return $PIL;
        });
        
        return view('pengurusan.ePIL.index', ['ePIL' => $ePIL]);
    }

    public function create()
    {
        $userId = auth()->id();
        $user = User::find($userId);
        $pbt = null; 
        if($user->hasRole('Pihak Berkuasa Tempatan')){
            $email = $user->bahagian_jln;
            $pbt = MaklumatPenggunaPbt::where('id', '=', $email)->first();
        }
        return view('pengurusan.ePIL.create', compact('pbt'));
    }

    public function store(Request $request)
    {
        $requestData = $request->all();
        // dd($requestData);
        $mediaSosial_pelan = collect($requestData['mediaSosial_pelan'] ?? [])
            ->filter(function($item) {
                return $item !== null;
            })
            ->map(function($item) {
                return $item;
            })
            ->toArray();
        $requestData['mediaSosial_pelan'] = json_encode($mediaSosial_pelan);

        $newRecord = ePIL::create($requestData);
        $id_pelan = $newRecord->id_pelan;

        if(isset($requestData['pelan'])){
            $pelanArr = $requestData['pelan'];
            foreach ($pelanArr as $key => $value) {
                $folderName = str_replace(' ', '_', $id_pelan.' '.$requestData['nama_pelan']); 
                if ((isset($value['gambar']) && $value['gambar'] instanceof \Illuminate\Http\UploadedFile)) {
                    $file = $value['gambar'];
                    if ($file->isValid()) {
                        // $folderName = str_replace(' ', '_', $requestData['nama_pelan']); 
                        $filename = time() . '_' .$file->getClientOriginalName() . '.' . $file->extension();
                        $path = $file->storeAs('public/uploads/ePIL/' . $folderName, $filename);
                        $value['gambar_dokumen_pelan'] = $filename;
                        unset($value['gambar']);
                    }
                    $requestData['gambar_dokumen_pelan'] = $filename;
                    $newRecord->gambar_dokumen_pelan = $requestData['gambar_dokumen_pelan'];
                }
                if(isset($value['large_file_name_new'])){

                    $value['nama_fail'] = $value['nama_fail'];
                    $value['nama_dokumen_pelan'] = $value['large_file_name_new'];
                    $value['keterangan_dokumen_pelan'] = $value['keterangan'];
                    $value['id_pelan'] = $id_pelan;
                    $activeDokumen = ePIL_dokumen::where('status', 'active')->where('id_pelan', $id_pelan)->first();
                    // dd($activeDokumen);
                    if (!$activeDokumen) {
                        $value['status'] = 'active';
                    }
                    $dokumenRecord = ePIL_dokumen::create($value);
                    if($dokumenRecord){
                        $oldPath = storage_path('app/public/uploads/ePIL/temp/'.$value['nama_dokumen_pelan']); // Current file location
                        $newPath = storage_path('app/public/uploads/ePIL/'.$folderName.'/'.$value['nama_dokumen_pelan']); // New location
                        $newFolderPath = storage_path('app/public/uploads/ePIL/'.$folderName); // Folder path where the file will be moved to

                        if (!file_exists($newFolderPath)) {
                            mkdir($newFolderPath, 0777, true);
                        }
                        if (file_exists($oldPath)) {
                            rename($oldPath, $newPath);
                        }
                    }
                    // $requestData['gambar_dokumen_pelan'] = $filename;
                }
            }
            // $newRecord->gambar_dokumen_pelan = $requestData['gambar_dokumen_pelan'];
            $newRecord->save();
        }

        $requestData['id_pelan'] = $id_pelan;
        
        $drafRecord = ePIL_draf::create($requestData);
        if($drafRecord && $newRecord){
            return redirect()->route('pengurusan.ePIL.index')->with('successMessage', 'Maklumat pelan telah berjaya disimpan');
        }else{
            return redirect()->route('pengurusan.ePIL.index')->with('errorMessage', 'Maklumat pelan tidak berjaya disimpan');
        }
    }

    public function show(ePIL $ePIL)
    {
        $ePIL_draf = ePIL_draf::where('id_pelan', $ePIL->id_pelan)->first();
        $ePIL_dokumen = ePIL_dokumen::where('id_pelan', $ePIL->id_pelan)->orderBy('status', 'asc')->orderBy('id_dokumen_pelan', 'desc')->get();
        if($ePIL_dokumen){
            $ePIL_draf->dokumen = $ePIL_dokumen;
        }
        // dd($ePIL_draf);
        // $ePIL_dokumen = ePIL_dokumen::where('id_pelan', $ePIL->id_pelan)->get();
        // $ePIL_draf->dokumen = $ePIL_dokumen;
        $paparan_portal = ePIL::where('id_pelan', $ePIL->id_pelan)->first();

        if ($paparan_portal) {
            $status = $paparan_portal->status;
        }
        $latestAudit = $ePIL_draf->status != 'approved' ? $ePIL_draf->audits()->latest()->take(3)->get() : null;
        // dd($latestAudit);
        return view('pengurusan.ePIL.show', [
            'ePIL' => $ePIL_draf,
            'status' => $status,
            'latestAudit' => $latestAudit,
        ]);
    }

    public function edit(ePIL $ePIL)
    {
        $ePIL_draf = ePIL_draf::where('id_pelan', $ePIL->id_pelan)->first();
        $ePIL_dokumen = ePIL_dokumen::where('id_pelan', $ePIL->id_pelan)->orderBy('status', 'asc')->orderBy('id_dokumen_pelan', 'desc')->get();
        // dd($ePIL_dokumen);
        if($ePIL_dokumen){
            $ePIL_draf->dokumen = $ePIL_dokumen;
        }
        return view('pengurusan.ePIL.edit', [
            'ePIL' => $ePIL_draf,
        ]);
    }

    public function update(Request $request, ePIL_draf $ePIL)
    {
        // dd($request->all());
        $requestData = $request->all();
        // dd($requestData);
        $mediaSosial_pelan = collect($requestData['mediaSosial_pelan'] ?? [])
            ->filter(function($item) {
                return $item !== null;
            })
            ->map(function($item) {
                return $item;
            })
            ->toArray();
        $requestData['mediaSosial_pelan'] = json_encode($mediaSosial_pelan);

        $paparan_portal = isset($requestData['status']) && $requestData['status'] == "on" ? "approved" : "draft";
        
        if ($request->input('action') === 'update') {
            $id_pelan = $ePIL->id_pelan;
            $requestData['status'] = "draft";
            if(isset($requestData['pelan'])){
                $pelanArr = $requestData['pelan'];
                foreach ($pelanArr as $key => $value) {
                    $folderName = str_replace(' ', '_', $id_pelan.' '.$requestData['nama_pelan']); 
                    if ((isset($value['gambar']) && $value['gambar'] instanceof \Illuminate\Http\UploadedFile)) {
                        $file = $value['gambar'];
                        if ($file->isValid()) {
                            // $folderName = str_replace(' ', '_', $requestData['nama_pelan']); 
                            $filename = time() . '_' .$file->getClientOriginalName() . '.' . $file->extension();
                            $path = $file->storeAs('public/uploads/ePIL/' . $folderName, $filename);
                            $value['gambar_dokumen_pelan'] = $filename;
                            unset($value['gambar']);
                        }
                        $requestData['gambar_dokumen_pelan'] = $filename;
                        $ePIL->gambar_dokumen_pelan = $requestData['gambar_dokumen_pelan'];
                    }
                    if(isset($value['large_file_name_new'])){
                        $value['nama_fail'] = $value['nama_fail'];
                        $value['nama_dokumen_pelan'] = $value['large_file_name_new'];
                        $value['keterangan_dokumen_pelan'] = $value['keterangan'];
                        $value['id_pelan'] = $id_pelan;
                        $activeDokumen = ePIL_dokumen::where('status', 'active')->where('id_pelan', $id_pelan)->first();
                        // dd($activeDokumen);
                        if (!$activeDokumen) {
                            $value['status'] = 'active';
                        }
                        $dokumenRecord = ePIL_dokumen::create($value);
                        if($dokumenRecord){
                            $oldPath = storage_path('app/public/uploads/ePIL/temp/'.$value['nama_dokumen_pelan']); // Current file location
                            $newPath = storage_path('app/public/uploads/ePIL/'.$folderName.'/'.$value['nama_dokumen_pelan']); // New location

                            if (file_exists($oldPath)) {
                                rename($oldPath, $newPath);
                            }
                            
                        }
                        // $requestData['gambar_dokumen_pelan'] = $filename;
                    }
                }
                // $ePIL->gambar_dokumen_pelan = $requestData['gambar_dokumen_pelan'];
                $ePIL->save();
            }

            $requestData['id_pelan'] = $id_pelan;
            $wasApproved = $ePIL->status === 'approved';
            $pelanStatus = ePIL::where('id_pelan', $ePIL->id_pelan)->first();
            $statusInit = isset($pelanStatus->status) ? $pelanStatus->status : 'draft';

            $ePIL_update = $ePIL->update($requestData);
            // dd($ePIL);
            if ($ePIL_update) {
                if ($wasApproved || $statusInit == 'draft'){
                    $bahagian_jln = 3;
                    $userArr = []; $user_email = []; $btm_email = [];
                    if ($bahagian_jln) {
                        $userArr = User::where(function ($query) use ($bahagian_jln) {
                            $query->whereHas('roles', function ($query) {
                                $query->where('name', 'Pegawai');
                            })
                            ->where('bahagian_jln', $bahagian_jln);
                        })
                        ->get();
                    }
                    foreach ($userArr as $key => $value) {
                        $user_email[] = ['address' => $value->email, 'name' => $value->name];
                    }

                    $emailBTM = User::where(function ($query) use ($bahagian_jln) {
                        $query->whereHas('roles', function ($query) {
                                $query->where('name', 'Pentadbir Sistem');
                            });
                        })->where('is_active', 1)
                        ->orWhere(function ($query) use ($bahagian_jln) {
                            $query->whereHas('roles', function ($query) {
                                $query->where('name', 'Pegawai');
                            })
                            ->where('bahagian_jln', '7');
                        })->where('is_active', 1)
                        ->get();
                    foreach ($emailBTM as $key => $value) {
                        $btm_email[] = ['address' => $value->email, 'name' => $value->name];
                    }
                    // dd($user_email);
                    if (config('mail.enabled')) {
                        try {
                            $emailData = [
                                "email_to" => $user_email,
                                "email_cc" => $btm_email,
                                "subject" => 'Modul Pelan Induk Landskap (ePIL)',
                            ];
            
                            Mail::send('pengurusan.ePIL.mails.perubahan', ['epil' => $ePIL], function ($message) use ($emailData) {
                                $message->subject($emailData["subject"]);
                                // Loop through to array and add each email
                                foreach ($emailData['email_to'] as $to) {
                                    $message->to($to['address'], $to['name']);
                                }
            
                                // Loop through cc array and add each email
                                foreach ($emailData['email_cc'] as $cc) {
                                    $message->cc($cc['address'], $cc['name']);
                                }
                            });
                        } catch (\Exception $exception) {
                            \Log::error("Error sending registration email: " . $exception->getMessage());
                        //    dd("Error sending registration email: " . $exception->getMessage());
                        }
                        // dd($emailData);
                    }
                }
                return redirect()->route('pengurusan.ePIL.edit', [$id_pelan])->with('successMessage', 'Maklumat pelan telah berjaya dikemaskini');
            }
        } elseif ($request->input('action') === 'approve') {
            $dokumen = ePIL_dokumen::where('status', 'active')->where('id_pelan', $ePIL->id_pelan)->first();
            if ($dokumen) {
                $ePIL->gambar_dokumen_pelan = $dokumen->nama_dokumen_pelan;
            }
            $ePIL->status = $paparan_portal;
            $ePIL->save();
            $ePIL_approve = ePIL::where('id_pelan', $ePIL->id_pelan)->first();
            if ($ePIL_approve) {
                $dataToUpdate = $ePIL->getAttributes();
                $ePIL_approve->update($dataToUpdate);
            }
            return redirect()->route('pengurusan.ePIL.show', [$ePIL->id_pelan])->with('successMessage', 'Maklumat pelan telah berjaya disimpan');
        }
    }

    public function destroy(Request $request, $id)
    {
        $id_pelan = $id;

        $delete_draf = ePIL_draf::where('id_pelan', $id_pelan)->first();
        $delete_main = ePIL::where('id_pelan', $id_pelan)->first();

        if ($delete_main) {
            if ($delete_draf) {
                $delete_draf->delete();
            }
            $delete_main->delete();
        }

        return redirect()->route('pengurusan.ePIL.index')->with('successMessage', 'Maklumat Pelan Induk Landskap telah dihapuskan');
    }
}
