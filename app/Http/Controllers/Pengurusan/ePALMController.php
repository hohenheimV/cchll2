<?php

namespace App\Http\Controllers\Pengurusan;

use App\Http\Controllers\Controller;
use App\Model\ePALM;
use App\Model\ePALM_draf;
use Illuminate\Http\Request;
use App\Model\MaklumatPenggunaPbt;
use App\User;
use Illuminate\Support\Facades\Mail;

class ePALMController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware(['role_or_permission:Pentadbir Sistem|epalm-list']);
        $this->middleware(['role_or_permission:Pentadbir Sistem|epalm-create'], ['only' => ['create', 'store']]);
        $this->middleware(['role_or_permission:Pentadbir Sistem|epalm-edit'], ['only' => ['edit', 'update']]);
        $this->middleware(['role_or_permission:Pentadbir Sistem|epalm-delete'], ['only' => ['destroy']]);
    }

    public function index()
    {
        $ePALM = ePALM::where('is_komponen', null)->latest()->paginate(10);
        $userId = auth()->id();
        $user = User::find($userId);
        if($user->hasRole('Pihak Berkuasa Tempatan')){
            $email = $user->bahagian_jln;
            $pbt = MaklumatPenggunaPbt::where('id', '=', $email)->first();
            $totalCount = ePALM::where('nama_pbt', $pbt->pbt_name)->count();
            $ePALM = ePALM::where('nama_pbt', $pbt->pbt_name)->where('is_komponen', null)->orderBy('id_taman', 'desc')->paginate($totalCount);
            foreach ($ePALM as $key => $value) {
                $ePALM_draf = ePALM_draf::where('id_taman', $value->id_taman)->first();
                $value->status = $ePALM_draf->status;
            }
        }else{
            $totalCount = ePALM::count();
            $ePALM = ePALM::where('is_komponen', null)->latest()->paginate($totalCount);
        }
        return view('pengurusan.ePALM.index', ['ePALM' => $ePALM]);
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
        return view('pengurusan.ePALM.create', compact('pbt'));
    }

    public function store(Request $request)
    {
        $requestData = $request->all();
        if($request->input('jenis') == "komponen"){
            $requestData['nama_pbt'] = "Landskap Perbandaran";
            
            $filenames = [];

            if($request->input('update') == "komponen"){
                $requestData['nama_taman'] = $requestData['nama_komponenX'];
                $requestData['keterangan_taman'] = $requestData['keterangan_tamanX'];
                $requestData['kategori_taman'] = $requestData['nama_komponenX'];
                $requestData['is_komponen'] = $requestData['id_tamanX'];

                // $gambar_taman = json_decode($requestData['gambar_taman'], true);
                // for ($i = 1; $i <= 4; $i++) {
                //     $inputField = 'GIM_' . $i;
                //     $inputField2 = 'gambar_input_modal_' . $i;
                //     $updateField = 'GUM_' . $i;
                //     if ($request->hasFile($updateField)) {
                //         $file = $request->file($updateField);
                        
                //         if ($file->isValid()) {
                //             $folderName = str_replace(' ', '_', $requestData['is_komponen'].' '.$request->input('nama_taman'));
                //             $subFolderName = str_replace(' ', '_', $requestData['nama_komponenX']);
                //             $filename = time() . '_' . $i . '.' . $file->extension();
                //             $file->storeAs('public/uploads/ePALM/' . $folderName.'/'.$subFolderName, $filename);
                //             $filenames[$inputField] = $filename;
                //         }
                //         unset($requestData[$inputField]);
                //     }else{
                //         if(isset($gambar_taman[$inputField])){
                //             $filenames[$inputField] = $gambar_taman[$inputField];
                //         }elseif(isset($gambar_taman[$inputField2])){
                //             $filenames[$inputField] = $gambar_taman[$inputField2];
                //         }
                //     }
                // }
            }else if($request->input('delete') == "komponen"){
                // $ePALMdelete = ePALM_draf::where('id_taman', $requestData['id_tamanD']);
                // $ePALMdelete->delete();
                $ePALMdelete = ePALM_draf::where('id_taman', $requestData['id_tamanD'])->get();
                foreach ($ePALMdelete as $item) {
                    $item->delete();
                }
                return response()->json(['success' => true, 'message' => 'Data deleted!']);
            }else{
                $requestData['nama_taman'] = $requestData['nama_komponen'];
                $requestData['keterangan_taman'] = $requestData['keterangan_taman'];
                $requestData['kategori_taman'] = $requestData['nama_komponen'];
                $requestData['is_komponen'] = $requestData['id_taman'];
                for ($i = 1; $i <= 6; $i++) {
                    $inputField = 'GIM_' . $i;
                    if ($request->hasFile($inputField)) {
                        $file = $request->file($inputField);
                        
                        if ($file->isValid()) {
                            $folderName = str_replace(' ', '_', $requestData['is_komponen'].' '.$request->input('nama_taman'));
                            $subFolderName = str_replace(' ', '_', $requestData['nama_komponen']);
                            $filename = time() . '_' . $i . '.' . $file->extension();
                            $file->storeAs('public/uploads/ePALM/' . $folderName.'/'.$subFolderName, $filename);
                            $filenames[$inputField] = $filename;
                        }
                        unset($requestData[$inputField]);
                    }
                }
                $requestData['gambar_taman'] = json_encode($filenames);
            }
            // $requestData['gambar_taman'] = json_encode($filenames);

            if($request->input('update') == "komponen"){  
                // // dd($requestData['gambar_taman']);
                // ePALM_draf::where('id_taman', $requestData['is_komponen'])->update([
                //     // 'nama_taman' => $requestData['nama_taman'],
                //     // 'kategori_taman' => $requestData['kategori_taman'],
                //     'keterangan_taman' => $requestData['keterangan_taman'],
                //     'gambar_taman' => $requestData['gambar_taman'],
                // ]);
                $komponen = ePALM_draf::where('id_taman', $requestData['is_komponen'])->first();
                if ($komponen) {
                    $gambar_taman = json_decode($requestData['gambar_taman'], true);
                    for ($i = 1; $i <= 4; $i++) {
                        $inputField = 'GIM_' . $i;
                        $inputField2 = 'gambar_input_modal_' . $i;
                        $updateField = 'GUM_' . $i;
                        if ($request->hasFile($updateField)) {
                            $file = $request->file($updateField);
                            
                            if ($file->isValid()) {
                                $folderName = str_replace(' ', '_', $komponen->is_komponen.' '.$request->input('nama_taman'));
                                $subFolderName = str_replace(' ', '_', $requestData['nama_komponenX']);
                                $filename = time() . '_' . $i . '.' . $file->extension();
                                $file->storeAs('public/uploads/ePALM/' . $folderName.'/'.$subFolderName, $filename);
                                $filenames[$inputField] = $filename;
                            }
                            unset($requestData[$inputField]);
                        }else{
                            if(isset($gambar_taman[$inputField])){
                                $filenames[$inputField] = $gambar_taman[$inputField];
                            }elseif(isset($gambar_taman[$inputField2])){
                                $filenames[$inputField] = $gambar_taman[$inputField2];
                            }
                        }
                    }
                    $requestData['gambar_taman'] = json_encode($filenames);
                    $komponen->keterangan_taman = $requestData['keterangan_taman'];
                    $komponen->gambar_taman = $requestData['gambar_taman'];
                    $komponen->save();
                }                 
            }else{
                $newRecord = ePALM::create($requestData);
                $id_taman = $newRecord->id_taman;
                $requestData['id_taman'] = $id_taman;
                $drafRecord = ePALM_draf::create($requestData);
            }
            return response()->json(['success' => true, 'message' => 'Data saved successfully!']);
        }else{
            $fasiliti = collect($requestData['fasiliti'] ?? [])
                ->map(function($item) {
                    return $item;
                })
                ->toArray();
            $requestData['fasiliti'] = json_encode($fasiliti);

            $mediaSosial_taman = collect($requestData['mediaSosial_taman'] ?? [])
                ->map(function($item) {
                    return $item;
                })
                ->toArray();
            $requestData['mediaSosial_taman'] = json_encode($mediaSosial_taman);
            
            // $filenames = [];
            // for ($i = 1; $i <= 6; $i++) {
            //     $inputField = 'XGIM_' . $i;
            //     if ($request->hasFile($inputField)) {
            //         $file = $request->file($inputField);
                    
            //         if ($file->isValid()) {
            //             $folderName = str_replace(' ', '_', $request->input('nama_taman'));
            //             $filename = time() . '_' . $i . '.' . $file->extension();
            //             $file->storeAs('public/uploads/ePALM/' . $folderName, $filename);
            //             $filenames[$inputField] = $filename;
            //         }
            //         unset($requestData[$inputField]);
            //     }
            // }
            // if (!empty($filenames)) {
            //     $requestData['gambar_taman'] = json_encode($filenames);
            // }

            // if ($request->hasFile('fail_konsep')) {
            //     $file = $request->file('fail_konsep');
                
            //     if ($file->isValid()) {
            //         $folderName = str_replace(' ', '_', $request->input('nama_taman'));
            //         $filename = time() . '.' . $file->extension();
            //         $file->storeAs('public/uploads/ePALM/' . $folderName, $filename);
            //     }
            //     $requestData['fail_konsep'] = $filename;
            // }
            $newRecord = ePALM::create($requestData);
            $id_taman = $newRecord->id_taman;
            $requestData['id_taman'] = $id_taman;
            $drafRecord = ePALM_draf::create($requestData);
            if($drafRecord && $newRecord){
                $filenames = [];
                for ($i = 1; $i <= 6; $i++) {
                    $inputField = 'XGIM_' . $i;
                    if ($request->hasFile($inputField)) {
                        $file = $request->file($inputField);
                        
                        if ($file->isValid()) {
                            $folderName = str_replace(' ', '_', $id_taman.' '.$request->input('nama_taman'));
                            $filename = time() . '_' . $i . '.' . $file->extension();
                            $file->storeAs('public/uploads/ePALM/' . $folderName, $filename);
                            $filenames[$inputField] = $filename;
                        }
                        unset($requestData[$inputField]);
                    }
                }
                if (!empty($filenames)) {
                    $requestData['gambar_taman'] = json_encode($filenames);
                    $gambarJson = json_encode($filenames);
                    $newRecord->gambar_taman = $gambarJson;
                    $drafRecord->gambar_taman = $gambarJson;
                }

                if ($request->hasFile('fail_konsep')) {
                    $file = $request->file('fail_konsep');
                    
                    if ($file->isValid()) {
                        $folderName = str_replace(' ', '_', $id_taman.' '.$request->input('nama_taman'));
                        $filename = time() . '.' . $file->extension();
                        $file->storeAs('public/uploads/ePALM/' . $folderName, $filename);
                    }
                    $requestData['fail_konsep'] = $filename;
                    $newRecord->fail_konsep = $filename;
                    $drafRecord->fail_konsep = $filename;
                }
                $newRecord->save();
                $drafRecord->save();
                if($requestData['kategori_taman'] == "Landskap Perbandaran"){
                    return redirect()->route('pengurusan.ePALM.edit', [$drafRecord])->with('successMessage', 'Maklumat taman telah berjaya disimpan');
                }
                return redirect()->route('pengurusan.ePALM.index')->with('successMessage', 'Maklumat taman telah berjaya disimpan');
            }
        }
        return redirect()->route('pengurusan.ePALM.index')->with('errorMessage', 'Maklumat taman tidak berjaya disimpan');
    }

    public function show(ePALM_draf $ePALM)
    {
        if ($ePALM->kategori_taman == "Landskap Perbandaran" || 1) {
            $ePALM_komponen = ePALM_draf::select([
                'id_taman_draf',
                'id_taman',
                'nama_taman',
                'nama_pbt',
                'kategori_taman',
                'keterangan_taman',
                'gambar_taman',
                'is_komponen',
                'id_permohonan',
                'status',
            ])->where('is_komponen', $ePALM->id_taman)->get();
            $ePALM->komponen = $ePALM_komponen;
        }

        if ($ePALM->nama_pbt == "Landskap Perbandaran") {
            $ePALM_induk = ePALM_draf::select([
                'nama_taman',
            ])->where('id_taman', $ePALM->is_komponen)->first();
            // dd($ePALM_induk);
            $ePALM->nama_pbt = $ePALM_induk->nama_taman;
        }

        $paparan_portal = ePALM::where('id_taman', $ePALM->id_taman)->first();
        if ($paparan_portal) {
            $status = $paparan_portal->status;
        }
        $latestAudit = $ePALM->status != 'approved' ? $ePALM->audits()->latest()->take(1)->get() : null;
        // $latestAudit = $ePALM->audits()->latest()->first();
        // dd($latestAudit);
        return view('pengurusan.ePALM.show', [
            'ePALM' => $ePALM,
            'status' => $status,
            'latestAudit' => $latestAudit,
        ]);
    }

    public function edit(ePALM_draf $ePALM)
    {
        if ($ePALM->kategori_taman == "Landskap Perbandaran" || 1) {
            $ePALM_komponen = ePALM_draf::where('is_komponen', $ePALM->id_taman)->get();
            $ePALM->komponen = $ePALM_komponen;
        }
        if ($ePALM->nama_pbt == "Landskap Perbandaran") {
            $ePALM_induk = ePALM_draf::select([
                'nama_taman',
            ])->where('id_taman', $ePALM->is_komponen)->first();
            // dd($ePALM_induk);
            $ePALM->nama_pbt = $ePALM_induk->nama_taman;
            abort(404);
        }
        return view('pengurusan.ePALM.edit', [
            'ePALM' => $ePALM,
        ]);
    }

    public function update(Request $request, ePALM_draf $ePALM)
    {
        // dd($request->all());
        $fasiliti = collect($request['fasiliti'] ?? [])
            ->filter(function($item) {
                return $item !== "0";
            })
            ->map(function($item) {
                return $item;
            })
            ->toArray();
        $request['fasiliti'] = json_encode($fasiliti);
        
        $mediaSosial_taman = collect($request['mediaSosial_taman'] ?? [])
            ->filter(function($item) {
                return $item !== null;
            })
            ->map(function($item) {
                return $item;
            })
            ->toArray();
        $request['mediaSosial_taman'] = json_encode($mediaSosial_taman);

        // dd($request->all());

        $filenames = [];
        $gambar_taman = json_decode($ePALM->gambar_taman, true);
        for ($i = 1; $i <= 6; $i++) {
            $inputField = 'XGIM_' . $i;
            $inputField2 = 'Xgambar_input_modal_' . $i;
            if ($request->hasFile($inputField)) {
                $file = $request->file($inputField);
                
                if ($file->isValid()) {
                    $folderName = str_replace(' ', '_', $ePALM->id_taman.' '.$request->input('nama_taman'));
                    $filename = time() . '_' . $i . '.' . $file->extension();
                    $file->storeAs('public/uploads/ePALM/' . $folderName, $filename);
                    $filenames[$inputField] = $filename;
                }
                unset($request[$inputField]);
            }else{
                if(isset($gambar_taman[$inputField])){
                    $filenames[$inputField] = $gambar_taman[$inputField];
                }elseif(isset($gambar_taman[$inputField2])){
                    $filenames[$inputField] = $gambar_taman[$inputField2];
                }
            }
        }
        foreach ($request->input('delete_images', []) as $deletedField) {
            unset($filenames[$deletedField]);
        }        
        $request->merge(['gambar_taman' => json_encode($filenames)]);
        // dd($request->all());
        $requestData = $request->all();
        if ($request->hasFile('fail_konsep')) {
            $file = $request->file('fail_konsep');
            
            if ($file->isValid()) {
                $folderName = str_replace(' ', '_', $ePALM->id_taman.' '.$request->input('nama_taman'));
                $filename = time() . '.' . $file->extension();
                $file->storeAs('public/uploads/ePALM/' . $folderName, $filename);
            }
            $requestData['fail_konsep'] = $filename;
        }

        $paparan_portal = isset($requestData['status']) && $requestData['status'] == "on" ? "approved" : "draft";

        if ($request->input('action') === 'update') {
            $requestData['status'] = "draft";
            $ePALM_draf = ePALM_draf::where('id_taman', $ePALM->id_taman)->first();
            if ($ePALM_draf) {
                $updateDraf = $ePALM_draf->update($requestData);
            }
            // dd($ePALM_draf);
            if ($updateDraf) {
                $kategori = ($ePALM_draf->kategori_taman);
                
                $kategoriToBahagian = [
                    'Taman Awam' => 2,
                    'Landskap Perbandaran' => 3,
                    'Persekitaran Kehidupan' => 4,
                    'Taman Botani' => 5,
                    'Pemuliharaan Dan Penyelidikan Landskap' => 5,
                ];
                $bahagian_jln = $kategoriToBahagian[$kategori] ?? null;
                if ($bahagian_jln) {
                    $userArr = User::where(function ($query) use ($bahagian_jln) {
                        $query->whereHas('roles', function ($query) {
                            $query->where('name', 'Pegawai');
                        })
                        ->where('bahagian_jln', $bahagian_jln);
                    })
                    ->get();
                } else {
                    $userArr = [];
                }

                $user_email = [];
                foreach ($userArr as $key => $value) {
                    $user_email[] = ['address' => $value->email, 'name' => $value->name];
                }

                $emailBTM = User::where(function ($query) use ($bahagian_jln) {
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
                    ->get();
                $btm_email = [];
                foreach ($emailBTM as $key => $value) {
                    $btm_email[] = ['address' => $value->email, 'name' => $value->name];
                }
                // dd($btm_email);
                $nama_pemohon = isset($PBTArr->pbt_name) ? $PBTArr->pbt_name : 'Jabatan Landskap Negara';
                if (config('mail.enabled')) {
                    try {
                        $emailData = [
                            "email_to" => $user_email,
                            "email_cc" => $btm_email,
                            "subject" => 'Modul Pengurusan Taman & Landskap (ePALM)',
                        ];
        
                        Mail::send('pengurusan.ePALM.mails.perubahan', ['epalm' => $ePALM_draf], function ($message) use ($emailData) {
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
                return redirect()->route('pengurusan.ePALM.edit', [$ePALM_draf])->with('successMessage', 'Maklumat taman telah berjaya dikemaskini');
            }
        } elseif ($request->input('action') === 'approve') {
            $ePALM_approve_draf = ePALM_draf::where('id_taman', $ePALM->id_taman)->first();
            $ePALM_approve_draf->status = $paparan_portal;
            $ePALM_approve_draf->save();

            $ePALM_approve = ePALM::where('id_taman', $ePALM->id_taman)->first();
            if ($ePALM_approve->kategori_taman == "Landskap Perbandaran") {
                $ePALM_komponen = ePALM::where('is_komponen', $ePALM_approve->id_taman)->get();
                foreach ($ePALM_komponen as $item) {
                    $ePALM_approve_komponen_draf = ePALM_draf::where('id_taman', $item->id_taman)->first();
                    
                    $ePALM_approve_komponen_draf->negeri_taman = $ePALM_approve->negeri_taman;
                    $ePALM_approve_komponen_draf->daerah_taman = $ePALM_approve->daerah_taman;
                    $ePALM_approve_komponen_draf->mukim_taman = $ePALM_approve->mukim_taman;
                    $ePALM_approve_komponen_draf->parlimen_taman = $ePALM_approve->parlimen_taman;
                    $ePALM_approve_komponen_draf->dun_taman = $ePALM_approve->dun_taman;
                    $ePALM_approve_komponen_draf->status = $paparan_portal;
                    // $ePALM_approve_komponen_draf->save();
                    if($ePALM_approve_komponen_draf->save()){

                        $ePALM_approve_komponen = ePALM::where('id_taman', $item->id_taman)->first();
                        $dataToUpdate_komponen = $ePALM_approve_komponen_draf->getAttributes();
                        $ePALM_approve_komponen->update($dataToUpdate_komponen);
                    }
                }
            }
            if ($ePALM_approve) {
                if (is_string($ePALM_approve_draf->fasiliti)) {
                    $ePALM_approve_draf->fasiliti = json_decode($ePALM_approve_draf->fasiliti, true);
                }
                $dataToUpdate = $ePALM_approve_draf->getAttributes();
                $ePALM_approve->update($dataToUpdate);
            }
            // dd($ePALM_approve_draf->audits()->latest()->take(1)->get());
            return redirect()->route('pengurusan.ePALM.index')->with('successMessage', 'Maklumat taman telah berjaya disahkan');
        }
        return redirect()->route('pengurusan.ePALM.index')->with('errorMessage', 'Maklumat taman tidak berjaya dikemaskini');
    }

    public function destroy(Request $request,ePALM_draf $ePALM)
    {
        // dd($ePALM->id_taman);
        $id_taman = $ePALM->id_taman;

        $delete_draf = ePALM_draf::where('id_taman', $id_taman)->first();
        $delete_main = ePALM::where('id_taman', $id_taman)->first();

        if ($delete_main) {
            if ($delete_main->kategori_taman == "Landskap Perbandaran") {
                $ePALM_komponen = ePALM::where('is_komponen', $delete_main->id_taman)->get();
                foreach ($ePALM_komponen as $item) {

                    $delete_draf_komponen = ePALM_draf::where('id_taman', $item->id_taman)->first();
                    if ($delete_draf_komponen) {
                        $delete_draf_komponen->delete();
                    }

                    $delete_main_komponen = ePALM::where('id_taman', $item->id_taman)->first();
                    if ($delete_main_komponen) {
                        $delete_main_komponen->delete();
                    }
                }
            }
            if ($delete_draf) {
                $delete_draf->delete();
            }
            $delete_main->delete();
        }

        return redirect()->route('pengurusan.ePALM.index')->with('successMessage', 'Maklumat taman telah dihapuskan');
    }
}
