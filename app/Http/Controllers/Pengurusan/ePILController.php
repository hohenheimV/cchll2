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


class ePILController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware(['role_or_permission:Pentadbir Sistem|Pegawai|Pihak Berkuasa Tempatan|ePIL-list']);
        $this->middleware(['role_or_permission:Pentadbir Sistem|Pegawai|Pihak Berkuasa Tempatan|ePIL-create'], ['only' => ['create', 'store']]);
        $this->middleware(['role_or_permission:Pentadbir Sistem|Pegawai|Pihak Berkuasa Tempatan|ePIL-edit'], ['only' => ['edit', 'update']]);
        $this->middleware(['role_or_permission:Pentadbir Sistem|Pegawai|Pihak Berkuasa Tempatan|ePIL-delete'], ['only' => ['destroy']]);
    }

    public function index()
    {
        
        $userId = auth()->id();
        $user = User::find($userId);
        if($user->hasRole('Pihak Berkuasa Tempatan')){
            $email = $user->email;
            $pbt = MaklumatPenggunaPbt::where('email', '=', $email)->first();
            $totalCount = ePIL::where('nama_pbt', $pbt->pbt_name)->count();
            $ePIL = ePIL::where('nama_pbt', $pbt->pbt_name)->orderBy('id_pelan', 'desc')->paginate($totalCount);
        }else{
            $totalCount = ePIL::count();
            $ePIL = ePIL::paginate($totalCount);
        }
        $ePIL->getCollection()->transform(function ($PIL) {
            $dokumen = ePIL_dokumen::where('status', 'active')->where('id_pelan', $PIL->id_pelan)->first();
            $PIL->nama_dokumen_pelan = $dokumen ? $dokumen->nama_dokumen_pelan : null;
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
            $email = $user->email;
            $pbt = MaklumatPenggunaPbt::where('email', '=', $email)->first();
        }
        return view('pengurusan.ePIL.create', compact('pbt'));
    }

    public function store(Request $request)
    {
        $requestData = $request->all();
        
        $mediaSosial_pelan = collect($requestData['mediaSosial_pelan'] ?? [])
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
                if ((isset($value['gambar']) && $value['gambar'] instanceof \Illuminate\Http\UploadedFile) || isset($value['large_file_name_new'])) {
                    $file = $value['gambar'];
                    if ($file->isValid()) {
                        $folderName = str_replace(' ', '_', $requestData['nama_pelan']); 
                        $filename = time() . '_' .$file->getClientOriginalName() . '.' . $file->extension();
                        $path = $file->storeAs('public/uploads/ePIL/' . $folderName, $filename);
                        $value['gambar_dokumen_pelan'] = $filename;
                        unset($value['gambar']);
                    }
                    $requestData['gambar_dokumen_pelan'] = $filename;
                    $newRecord->gambar_dokumen_pelan = $requestData['gambar_dokumen_pelan'];

                    $value['nama_fail'] = $value['nama_fail'];
                    $value['nama_dokumen_pelan'] = $value['large_file_name_new'];
                    $value['keterangan_dokumen_pelan'] = $value['keterangan'];
                    $value['id_pelan'] = $id_pelan;
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
        $ePIL_dokumen = ePIL_dokumen::where('id_pelan', $ePIL->id_pelan)->orderBy('id_dokumen_pelan', 'asc')->get();
        if($ePIL_dokumen){
            $ePIL_draf->dokumen = $ePIL_dokumen;
        }
        // dd($ePIL_draf);
        $ePIL_dokumen = ePIL_dokumen::where('id_pelan', $ePIL->id_pelan)->get();
        $ePIL_draf->dokumen = $ePIL_dokumen;
        $paparan_portal = ePIL::where('id_pelan', $ePIL->id_pelan)->first();

        if ($paparan_portal) {
            $status = $paparan_portal->status;
        }
        return view('pengurusan.ePIL.show', [
            'ePIL' => $ePIL_draf,
            'status' => $status,
        ]);
    }

    public function edit(ePIL $ePIL)
    {
        $ePIL_draf = ePIL_draf::where('id_pelan', $ePIL->id_pelan)->first();
        $ePIL_dokumen = ePIL_dokumen::where('id_pelan', $ePIL->id_pelan)->orderBy('id_dokumen_pelan', 'asc')->get();
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

        $mediaSosial_pelan = collect($requestData['mediaSosial_pelan'] ?? [])
            ->map(function($item) {
                return $item;
            })
            ->toArray();
        $requestData['mediaSosial_pelan'] = json_encode($mediaSosial_pelan);

        $paparan_portal = isset($requestData['status']) && $requestData['status'] == "on" ? "approved" : "draft";
        
        if ($request->input('action') === 'update') {
            $id_pelan = $ePIL->id_pelan;

            if(isset($requestData['pelan'])){
                $pelanArr = $requestData['pelan'];
                foreach ($pelanArr as $key => $value) {
                    $folderName = str_replace(' ', '_', $requestData['nama_pelan']); 
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
            $ePIL_update = $ePIL->update($requestData);
            // dump($requestData);
            if ($ePIL_update) {
                return redirect()->route('pengurusan.ePIL.edit', [$id_pelan])->with('successMessage', 'Maklumat pelan telah berjaya dikemaskini');
            }
        } elseif ($request->input('action') === 'approve') {
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

    public function destroy(Request $request,ePIL_draf $ePIL)
    {
        $id_pelan = $ePIL->id_pelan;

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
