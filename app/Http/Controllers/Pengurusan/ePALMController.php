<?php

namespace App\Http\Controllers\Pengurusan;

use App\Http\Controllers\Controller;
use App\Model\ePALM;
use App\Model\ePALM_draf;
use Illuminate\Http\Request;
use App\Model\MaklumatPenggunaPbt;
use App\User;

class ePALMController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware(['role_or_permission:Pentadbir Sistem|Pegawai|Pihak Berkuasa Tempatan|ePALM-list']);
        $this->middleware(['role_or_permission:Pentadbir Sistem|Pegawai|Pihak Berkuasa Tempatan|ePALM-create'], ['only' => ['create', 'store']]);
        $this->middleware(['role_or_permission:Pentadbir Sistem|Pegawai|Pihak Berkuasa Tempatan|ePALM-edit'], ['only' => ['edit', 'update']]);
        $this->middleware(['role_or_permission:Pentadbir Sistem|Pegawai|Pihak Berkuasa Tempatan|ePALM-delete'], ['only' => ['destroy']]);
    }

    public function index()
    {
        $ePALM = ePALM::where('is_komponen', null)->latest()->paginate(10);
        $userId = auth()->id();
        $user = User::find($userId);
        if($user->hasRole('Pihak Berkuasa Tempatan')){
            $email = $user->email;
            $pbt = MaklumatPenggunaPbt::where('email', '=', $email)->first();
            $totalCount = ePALM::where('nama_pbt', $pbt->pbt_name)->count();
            $ePALM = ePALM::where('nama_pbt', $pbt->pbt_name)->where('is_komponen', null)->orderBy('id_taman', 'desc')->paginate($totalCount);
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
            $email = $user->email;
            $pbt = MaklumatPenggunaPbt::where('email', '=', $email)->first();
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

                $gambar_taman = json_decode($requestData['gambar_taman'], true);
                for ($i = 1; $i <= 4; $i++) {
                    $inputField = 'gambar_input_modal_' . $i;
                    $updateField = 'gambar_update_modal_' . $i;
                    if ($request->hasFile($updateField)) {
                        $file = $request->file($updateField);
                        
                        if ($file->isValid()) {
                            $folderName = str_replace(' ', '_', $request->input('nama_taman'));
                            $subFolderName = str_replace(' ', '_', $requestData['nama_komponenX']);
                            $filename = time() . '_' . $i . '.' . $file->extension();
                            $file->storeAs('public/uploads/ePALM/' . $folderName.'/'.$subFolderName, $filename);
                            $filenames[$inputField] = $filename;
                        }
                        unset($requestData[$inputField]);
                    }else{
                        if(isset($gambar_taman[$inputField])){
                            $filenames[$inputField] = $gambar_taman[$inputField];
                        }
                    }
                }
            }else if($request->input('delete') == "komponen"){
                $ePALMdelete = ePALM_draf::where('id_taman', $requestData['id_tamanD']);
                $ePALMdelete->delete();
                return response()->json(['success' => true, 'message' => 'Data deleted!']);
            }else{
                $requestData['nama_taman'] = $requestData['nama_komponen'];
                $requestData['keterangan_taman'] = $requestData['keterangan_taman'];
                $requestData['kategori_taman'] = $requestData['nama_komponen'];
                $requestData['is_komponen'] = $requestData['id_taman'];
                for ($i = 1; $i <= 4; $i++) {
                    $inputField = 'gambar_input_modal_' . $i;
                    if ($request->hasFile($inputField)) {
                        $file = $request->file($inputField);
                        
                        if ($file->isValid()) {
                            $folderName = str_replace(' ', '_', $request->input('nama_taman'));
                            $subFolderName = str_replace(' ', '_', $requestData['nama_komponen']);
                            $filename = time() . '_' . $i . '.' . $file->extension();
                            $file->storeAs('public/uploads/ePALM/' . $folderName.'/'.$subFolderName, $filename);
                            $filenames[$inputField] = $filename;
                        }
                        unset($requestData[$inputField]);
                    }
                }
            }
            $requestData['gambar_taman'] = json_encode($filenames);

            if($request->input('update') == "komponen"){  
                ePALM_draf::where('id_taman', $requestData['is_komponen'])->update([
                    // 'nama_taman' => $requestData['nama_taman'],
                    // 'kategori_taman' => $requestData['kategori_taman'],
                    'keterangan_taman' => $requestData['keterangan_taman'],
                    'gambar_taman' => $requestData['gambar_taman'],
                ]);                 

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
            
            $filenames = [];
            for ($i = 1; $i <= 4; $i++) {
                $inputField = 'Xgambar_input_modal_' . $i;
                if ($request->hasFile($inputField)) {
                    $file = $request->file($inputField);
                    
                    if ($file->isValid()) {
                        $folderName = str_replace(' ', '_', $request->input('nama_taman'));
                        $filename = time() . '_' . $i . '.' . $file->extension();
                        $file->storeAs('public/uploads/ePALM/' . $folderName, $filename);
                        $filenames[$inputField] = $filename;
                    }
                    unset($requestData[$inputField]);
                }
            }
            if (!empty($filenames)) {
                $requestData['gambar_taman'] = json_encode($filenames);
            }

            if ($request->hasFile('fail_konsep')) {
                $file = $request->file('fail_konsep');
                
                if ($file->isValid()) {
                    $folderName = str_replace(' ', '_', $request->input('nama_taman'));
                    $filename = time() . '.' . $file->extension();
                    $file->storeAs('public/uploads/ePALM/' . $folderName, $filename);
                }
                $requestData['fail_konsep'] = $filename;
            }
            $newRecord = ePALM::create($requestData);
            $id_taman = $newRecord->id_taman;
            $requestData['id_taman'] = $id_taman;
            $drafRecord = ePALM_draf::create($requestData);
            if($drafRecord && $newRecord){
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
        if ($ePALM->kategori_taman == "Landskap Perbandaran") {
            $ePALM_komponen = ePALM_draf::where('is_komponen', $ePALM->id_taman)->get();
            $ePALM->komponen = $ePALM_komponen;
        }
        $paparan_portal = ePALM::where('id_taman', $ePALM->id_taman)->first();

        if ($paparan_portal) {
            $status = $paparan_portal->status;
        }
        return view('pengurusan.ePALM.show', [
            'ePALM' => $ePALM,
            'status' => $status,
        ]);
    }

    public function edit(ePALM_draf $ePALM)
    {
        if ($ePALM->kategori_taman == "Landskap Perbandaran") {
            $ePALM_komponen = ePALM_draf::where('is_komponen', $ePALM->id_taman)->get();
            $ePALM->komponen = $ePALM_komponen;
        }
        return view('pengurusan.ePALM.edit', [
            'ePALM' => $ePALM,
        ]);
    }

    public function update(Request $request, ePALM_draf $ePALM)
    {
        // dd($request->all());
        $fasiliti = collect($request['fasiliti'] ?? [])
            ->map(function($item) {
                return $item;
            })
            ->toArray();
        $request['fasiliti'] = json_encode($fasiliti);
        
        $mediaSosial_taman = collect($request['mediaSosial_taman'] ?? [])
            ->map(function($item) {
                return $item;
            })
            ->toArray();
        $request['mediaSosial_taman'] = json_encode($mediaSosial_taman);

        $filenames = [];
        $gambar_taman = json_decode($ePALM->gambar_taman, true);
        for ($i = 1; $i <= 4; $i++) {
            $inputField = 'Xgambar_input_modal_' . $i;
            if ($request->hasFile($inputField)) {
                $file = $request->file($inputField);
                
                if ($file->isValid()) {
                    $folderName = str_replace(' ', '_', $request->input('nama_taman'));
                    $filename = time() . '_' . $i . '.' . $file->extension();
                    $file->storeAs('public/uploads/ePALM/' . $folderName, $filename);
                    $filenames[$inputField] = $filename;
                }
                unset($request[$inputField]);
            }else{
                if(isset($gambar_taman[$inputField])){
                    $filenames[$inputField] = $gambar_taman[$inputField];
                }
            }
        }
        $request->merge(['gambar_taman' => json_encode($filenames)]);

        $requestData = $request->all();

        $paparan_portal = isset($requestData['status']) && $requestData['status'] == "on" ? "approved" : "draft";

        if ($request->input('action') === 'update') {
            $requestData['status'] = "draft";
            $ePALM_draf = ePALM_draf::where('id_taman', $ePALM->id_taman)->first();
            if ($ePALM_draf) {
                $updateDraf = $ePALM_draf->update($requestData);
            }
            if ($updateDraf) {
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
            return redirect()->route('pengurusan.ePALM.index')->with('successMessage', 'Maklumat taman telah berjaya dikemaskini');
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
