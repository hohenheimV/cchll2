<?php

namespace App\Http\Controllers\Pengurusan;

use App\Http\Controllers\Controller;
use App\Model\ePALM;
use App\Model\ePALM_draf;
use Illuminate\Http\Request;
use App\Model\MaklumatPenggunaPbt;
use App\User;
use App\Model\Negeri;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ePALMExport;
use Illuminate\Support\Facades\Storage;

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

    public function index(Request $request)
    {
        $keyword = null;
        if ($request->filled('keyword')) {
            $request->validate([
                'keyword' => 'required|min:3|max:255|regex:/(^[A-Za-z0-9\/\- ]+$)+/',
            ]);
            $keyword = strtolower(trim($request->keyword));
        }

        $negeri = $request->query('negeri') ?? null;
        $kategori = $request->query('kategori') ?? null;
        $nama_pbt = $request->query('nama_pbt') ?? null;

        $userId = auth()->id();
        $user = User::find($userId);

        $totalCount = 20; // default pagination count
        $parkSort = "
            CASE
                WHEN kategori_taman = 'Taman Tempatan' THEN 1
                WHEN kategori_taman = 'Taman Bandaran' THEN 2
                WHEN kategori_taman = 'Taman Wilayah' THEN 3
                WHEN kategori_taman = 'Padang Kejiranan' THEN 4
                WHEN kategori_taman = 'Padang Permainan' THEN 5
                WHEN kategori_taman = 'Lot Permainan' THEN 6
                ELSE 99
            END
        ";

        if ($user->hasRole('Pihak Berkuasa Tempatan')) {
            $email = $user->bahagian_jln;
            $pbt = MaklumatPenggunaPbt::where('id', '=', $email)->first();

            $query = ePALM::whereRaw('LOWER(nama_pbt) = ?', [strtolower($pbt->pbt_name)])
                ->where('is_komponen', null);

            if ($keyword) {
                $query->where(function ($q) use ($keyword) {
                    $q->whereRaw('LOWER(nama_taman) LIKE ?', ["%{$keyword}%"])
                    ->orWhereRaw('LOWER(nama_pbt) LIKE ?', ["%{$keyword}%"])
                    ->orWhereRaw('LOWER(kategori_taman) LIKE ?', ["%{$keyword}%"])
                    ->orWhereRaw('LOWER(status) LIKE ?', ["%{$keyword}%"]);
                });
            }

            if ($kategori) {
                if (strtolower($kategori) === 'taman awam') {
                    $kategoriList = [
                        'Taman Awam',
                        // 'Taman Wilayah',
                        // 'Taman Bandaran',
                        // 'Taman Tempatan',
                        // 'Padang Kejiranan',
                        // 'Padang Permainan',
                        // 'Lot Permainan'
                        'Taman Nasional/ Taman Negara',
                        'Taman Persekutuan',
                        'Taman Persekutuan/ Taman Wilayah/ Taman Negeri',
                        'Taman Bandaran/ Taman Tempatan',
                        'Taman Kejiranan',
                        'Taman Permainan/ Laman Permainan',
                        'Naik Taraf Taman Awam'
                    ];

                    $query->where(function ($q) use ($kategoriList) {
                        foreach ($kategoriList as $k) {
                            $q->orWhere('kategori_taman', 'ilike', ["%{$k}%"]); // case-insensitive if using PostgreSQL
                        }
                    });
                } else {
                    $query->where('kategori_taman', 'ilike', ["%{$kategori}%"]); // or 'like' for MySQL
                }
            }

            if ($negeri && !$nama_pbt) {
                $query->where('negeri_taman', $negeri);
            }

            if ($nama_pbt) {
                $query->whereRaw('LOWER(nama_pbt) = ?', [strtolower($nama_pbt)]);
            }

            $ePALM = $query->orderBy('status', 'ASC')->orderBy('negeri_taman', 'ASC')
                ->orderBy('nama_pbt', 'ASC')
                ->orderByRaw($parkSort)
                ->paginate($totalCount);

            // Add draft status to each item
            foreach ($ePALM as $value) {
                $ePALM_draf = ePALM_draf::where('id_taman', $value->id_taman)->first();
                $value->status = $ePALM_draf->status ?? $value->status;
            }
        } else {
            $query = ePALM::whereNull('is_komponen');

            if ($keyword) {
                $query->where(function ($q) use ($keyword) {
                    $q->whereRaw('LOWER(nama_taman) LIKE ?', ["%{$keyword}%"])
                    ->orWhereRaw('LOWER(nama_pbt) LIKE ?', ["%{$keyword}%"])
                    ->orWhereRaw('LOWER(kategori_taman) LIKE ?', ["%{$keyword}%"])
                    ->orWhereRaw('LOWER(status) LIKE ?', ["%{$keyword}%"]);
                });
            }

            if ($kategori) {
                if (strtolower($kategori) === 'taman awam') {
                    $kategoriList = [
                        'Taman Awam',
                        // 'Taman Wilayah',
                        // 'Taman Bandaran',
                        // 'Taman Tempatan',
                        // 'Padang Kejiranan',
                        // 'Padang Permainan',
                        // 'Lot Permainan'
                        'Taman Nasional/ Taman Negara',
                        'Taman Persekutuan',
                        'Taman Persekutuan/ Taman Wilayah/ Taman Negeri',
                        'Taman Bandaran/ Taman Tempatan',
                        'Taman Kejiranan',
                        'Taman Permainan/ Laman Permainan',
                        'Naik Taraf Taman Awam'
                    ];

                    $query->where(function ($q) use ($kategoriList) {
                        foreach ($kategoriList as $k) {
                            $q->orWhere('kategori_taman', 'ilike', ["%{$k}%"]); // case-insensitive if using PostgreSQL
                        }
                    });
                } else {
                    $query->where('kategori_taman', 'ilike', ["%{$kategori}%"]); // or 'like' for MySQL
                }
            }

            if ($negeri && !$nama_pbt) {
                $query->where('negeri_taman', $negeri);
            }

            if ($nama_pbt) {
                $query->whereRaw('LOWER(nama_pbt) = ?', [strtolower($nama_pbt)]);
            }

            $ePALM = $query->orderBy('status', 'ASC')->orderBy('negeri_taman', 'ASC')
                ->orderBy('nama_pbt', 'ASC')->orderByRaw($parkSort)
                ->paginate($totalCount);
        }
        $namaPbtArray = ePALM::whereNull('is_komponen')
            ->orderBy('negeri_taman')
            ->orderBy('nama_pbt')
            ->pluck('nama_pbt')
            ->unique()
            ->values()
            ->mapWithKeys(function ($item) {
                return [$item => $item];
            })
            ->toArray();

        return view('pengurusan.ePALM.index', [
            'ePALM' => $ePALM,
            'selectedKeyword' => $keyword,
            'selectedNegeri' => $negeri,
            'selectedKategori' => $kategori,
            'namaPbtArray' => $namaPbtArray,
        ]);
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
                for ($i = 1; $i <= 4; $i++) {
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
                for ($i = 1; $i <= 10; $i++) {
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

    public function show($id)
    // public function show(ePALM_draf $ePALM)
    {
        $ePALM = ePALM_draf::where('id_taman', $id)->first();
        if (!$ePALM) {
            $ePALM = ePALM_draf::where('id_taman_draf', $id)->first();
        }

        if (!$ePALM) {
            return redirect()->route('pengurusan.ePALM.index')->with('errorMessage', 'Maklumat taman tidak dapat ditemui');
        }

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

    public function edit($id)
    // public function edit(ePALM_draf $ePALM)
    {
        $ePALM = ePALM_draf::where('id_taman', $id)->first();
        // dd($ePALM);
        if (!$ePALM) {
            $ePALM = ePALM_draf::where('id_taman_draf', $id)->first();
        }

        if (!$ePALM) {
            return redirect()->route('pengurusan.ePALM.index')->with('errorMessage', 'Maklumat taman tidak dapat ditemui');
        }

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
        for ($i = 1; $i <= 10; $i++) {
            $inputField = 'XGIM_' . $i;
            $inputField2 = 'Xgambar_input_modal_' . $i;
            if ($request->hasFile($inputField)) {
                $file = $request->file($inputField);
                
                if ($file->isValid()) {
                    $folderName = str_replace(' ', '_', $ePALM->id_taman.' '.$ePALM->nama_taman);
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
                $folderName = str_replace(' ', '_', $ePALM->id_taman.' '.$ePALM->nama_taman);
                $filename = time() . '.' . $file->extension();
                $file->storeAs('public/uploads/ePALM/' . $folderName, $filename);
            }
            $requestData['fail_konsep'] = $filename;
        }

        $paparan_portal = isset($requestData['status']) && $requestData['status'] == "on" ? "approved" : "draft";

        if ($request->input('action') === 'update') {
            $requestData['status'] = "draft";
            $ePALM_draf = ePALM_draf::where('id_taman', $ePALM->id_taman)->first();

            $oldNamaTaman = str_replace(' ', '_', $ePALM->id_taman.' '.$ePALM->nama_taman);
            $newNamaTaman = str_replace(' ', '_', $ePALM->id_taman.' '.$requestData['nama_taman']);

            if ($newNamaTaman && $oldNamaTaman !== $newNamaTaman) {
                $oldFolder = storage_path("app/public/uploads/ePALM/{$oldNamaTaman}");
                $newFolder = storage_path("app/public/uploads/ePALM/{$newNamaTaman}");

                if (file_exists($oldFolder)) {
                    // Rename folder
                    rename($oldFolder, $newFolder);
                    $rename_ePALM = ePALM::where('id_taman', $ePALM->id_taman)->first();
                    if ($rename_ePALM) {
                        $rename_ePALM->update([
                            'nama_taman' => $requestData['nama_taman']
                        ]);
                    }
                }else{
                    // unset($requestData['nama_taman']);
                }
            }
            $wasApproved = $ePALM_draf->status === 'approved';
            $tamanStatus = ePALM::where('id_taman', $ePALM_draf->id_taman)->first();
            $statusInit = isset($tamanStatus->status) ? $tamanStatus->status : 'draft';

            if ($ePALM_draf) {
                $updateDraf = $ePALM_draf->update($requestData);
            }
            
            // dd($ePALM_draf);
            if ($updateDraf) {
                if ($wasApproved || $statusInit == 'draft'){
                    $kategori = ($ePALM_draf->kategori_taman);
                    
                    $kategoriToBahagian = [
                        'Taman Awam' => 2,
                        // 'Taman Wilayah' => 2,
                        // 'Taman Bandaran' => 2,
                        // 'Taman Tempatan' => 2,
                        // 'Padang Kejiranan' => 2,
                        // 'Padang Permainan' => 2,
                        // 'Lot Permainan' => 2,
                        'Landskap Perbandaran' => 3,
                        'Persekitaran Kehidupan' => 4,
                        'Taman Botani' => 5,
                        'Pemuliharaan Dan Penyelidikan Landskap' => 5,
                        'Taman Nasional/ Taman Negara' => 2,
                        'Taman Persekutuan' => 2,
                        'Taman Persekutuan/ Taman Wilayah/ Taman Negeri' => 2,
                        'Taman Bandaran/ Taman Tempatan' => 2,
                        'Taman Kejiranan' => 2,
                        'Taman Permainan/ Laman Permainan' => 2,
                        'Naik Taraf Taman Awam' => 1, 
                    ];
                    $bahagian_jln = $kategoriToBahagian[$kategori] ?? 2;
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
                        })->where('is_active', 1)
                        // ->orWhere(function ($query) use ($bahagian_jln) {
                        //     $query->whereHas('roles', function ($query) {
                        //         $query->where('name', 'Pegawai');
                        //     })
                        //     ->where('bahagian_jln', '7');
                        // })->where('is_active', 1)
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

    public function destroy(Request $request, $id)
    // public function destroy(Request $request,ePALM_draf $ePALM)
    {
        // dd($ePALM->id_taman);
        $id_taman = $id;
        // $id_taman = $ePALM->id_taman;

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
        } else {
            return redirect()->route('pengurusan.ePALM.index')->with('errorMessage', 'Maklumat taman tidak dapat dihapuskan');
        }

        return redirect()->route('pengurusan.ePALM.index')->with('successMessage', 'Maklumat taman telah dihapuskan');
    }

    public function export(Request $request)
    {
        $format = $request->query('format');
        $keyword = $request->query('keyword');
        $negeri = $request->query('negeri');
        $kategori = $request->query('kategori');
        $nama_pbt = $request->query('nama_pbt');
        // dd($request->query());

        $filename = "Senarai_ePALM";
        $query = ePALM::whereNull('is_komponen');

        if ($kategori) {
            $query->whereRaw('LOWER(kategori_taman) LIKE ?', [strtolower($kategori)]);
            $kategori = str_replace(" ", "_", $kategori);
            $filename .= "_{$kategori}";
        }

        if ($negeri && !$nama_pbt) {
            $query->where('negeri_taman', $negeri);
            $negeriName = Negeri::where('kod_negeri', $negeri)->value('nama_negeri') ?? 'Tiada Maklumat';
            $negeri = str_replace(" ", "_", $negeriName);
            $filename .= "_{$negeri}";
        }

        if ($nama_pbt) {
            $query->whereRaw('LOWER(nama_pbt) LIKE ?', [strtolower($nama_pbt)]);
            $nama_pbt = str_replace(" ", "_", $nama_pbt);
            $filename .= "_{$nama_pbt}";
        }

        if ($keyword) {
            $keyword = strtolower($keyword);
            $query->where(function ($q) use ($keyword) {
                $q->whereRaw('LOWER(nama_taman) LIKE ?', ["%{$keyword}%"])
                ->orWhereRaw('LOWER(nama_pbt) LIKE ?', ["%{$keyword}%"])
                ->orWhereRaw('LOWER(kategori_taman) LIKE ?', ["%{$keyword}%"])
                ->orWhereRaw('LOWER(status) LIKE ?', ["%{$keyword}%"]);
            });
            $filename .= "_[carian={$keyword}]";
        }

        $ePALM = $query->get();

        if ($format === 'csv') {
            // Return the data as a CSV
            return response()->stream(function () use ($ePALM) {
                $handle = fopen('php://output', 'w');
                fputcsv($handle, ['Bil.', 'Nama Taman', 'Nama PBT', 'Kategori Taman', 'Negeri']);
                $bil = 1;
                foreach ($ePALM as $item) {
                    $negeriName = Negeri::where('kod_negeri', $item->negeri_taman)->value('nama_negeri') ?? 'Tiada Maklumat';
                    fputcsv($handle, [
                            $bil++,
                            strtoupper($item->nama_taman ?? 'TIADA MAKLUMAT'),
                            strtoupper($item->nama_pbt ?? 'TIADA MAKLUMAT'),
                            strtoupper($item->kategori_taman ?? 'TIADA MAKLUMAT'),
                            strtoupper($negeriName ?? 'TIADA MAKLUMAT')
                        ]);
                }
                fclose($handle);
            }, 200, [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename="' . strtoupper($filename) . '.csv"',
            ]);
        } elseif ($format === 'excel') {
            return Excel::download(new ePALMExport($ePALM), strtoupper($filename) . '.xlsx');
        }

        return redirect()->route('pengurusan.ePALM.index');
    }

    public function sync(){
        $pbtJson = ["MAJLIS BANDARAYA JOHOR BAHRU","MAJLIS BANDARAYA ISKANDAR PUTERI","MAJLIS PERBANDARAN KULAI","MAJLIS PERBANDARAN MUAR","MAJLIS DAERAH TANGKAK","MAJLIS PERBANDARAN BATU PAHAT","MAJLIS DAERAH YONG PENG","MAJLIS PERBANDARAN SEGAMAT","MAJLIS DAERAH LABIS","MAJLIS PERBANDARAN KLUANG","MAJLIS DAERAH SIMPANG RENGGAM","MAJLIS PERBANDARAN PONTIAN","MAJLIS DAERAH KOTA TINGGI","MAJLIS DAERAH MERSING","MAJLIS BANDARAYA PASIR GUDANG","MAJLIS PERBANDARAN PENGERANG","MAJLIS BANDARAYA ALOR SETAR","MAJLIS PERBANDARAN SUNGAI PETANI","MAJLIS PERBANDARAN KULIM","MAJLIS DAERAH BALING","MAJLIS PERBANDARAN KUBANG PASU","MAJLIS DAERAH YAN","MAJLIS DAERAH SIK","MAJLIS DAERAH PENDANG","MAJLIS DAERAH PADANG TERAP","MAJLIS DAERAH BANDAR BAHARU","MAJLIS PERBANDARAN LANGKAWI BANDARAYA PELANCONGAN","MAJLIS PERBANDARAN KOTA BHARU - BANDAR RAYA ISLAM","MAJLIS DAERAH BACHOK BANDAR PELANCONGAN ISLAM","MAJLIS DAERAH GUA MUSANG","MAJLIS DAERAH JELI","MAJLIS DAERAH KETEREH - PERBANDARAN ISLAM","MAJLIS DAERAH DABONG","MAJLIS DAERAH KUALA KRAI","MAJLIS DAERAH MACHANG","MAJLIS DAERAH PASIR MAS","MAJLIS DAERAH PASIR PUTEH","MAJLIS DAERAH TANAH MERAH","MAJLIS DAERAH TUMPAT","MAJLIS BANDARAYA MELAKA BERSEJARAH","MAJLIS PERBANDARAN ALOR GAJAH","MAJLIS PERBANDARAN JASIN","MAJLIS PERBANDARAN HANG TUAH JAYA","MAJLIS BANDARAYA SEREMBAN","MAJLIS DAERAH KUALA PILAH","MAJLIS DAERAH TAMPIN","MAJLIS PERBANDARAN PORT DICKSON","MAJLIS DAERAH JELEBU","MAJLIS DAERAH REMBAU","MAJLIS PERBANDARAN JEMPOL","MAJLIS BANDARAYA KUANTAN","MAJLIS PERBANDARAN TEMERLOH","MAJLIS PERBANDARAN BENTONG","MAJLIS PERBANDARAN PEKAN BANDAR DIRAJA","MAJLIS DAERAH LIPIS","MAJLIS DAERAH CAMERON HIGHLANDS","MAJLIS DAERAH RAUB","MAJLIS DAERAH BERA","MAJLIS DAERAH MARAN","MAJLIS DAERAH ROMPIN","MAJLIS DAERAH JERANTUT","MAJLIS BANDARAYA PULAU PINANG","MAJLIS BANDARAYA SEBERANG PERAI","MAJLIS BANDARAYA IPOH","MAJLIS PERBANDARAN TAIPING","MAJLIS PERBANDARAN MANJUNG","MAJLIS DAERAH PERAK TENGAH","MAJLIS PERBANDARAN KUALA KANGSAR","MAJLIS DAERAH SELAMA","MAJLIS DAERAH BATU GAJAH","MAJLIS DAERAH KAMPAR","MAJLIS DAERAH GERIK","MAJLIS DAERAH LENGGONG","MAJLIS DAERAH PENGKALAN HULU","MAJLIS DAERAH TAPAH","MAJLIS DAERAH TANJONG MALIM","MAJLIS PERBANDARAN TELUK INTAN","MAJLIS DAERAH KERIAN","MAJLIS PERBANDARAN KANGAR","MAJLIS BANDARAYA SHAH ALAM","MAJLIS BANDARAYA PETALING JAYA","MAJLIS BANDARAYA DIRAJA KLANG","MAJLIS PERBANDARAN AMPANG JAYA","MAJLIS BANDARAYA SUBANG JAYA","MAJLIS PERBANDARAN SELAYANG","MAJLIS PERBANDARAN KAJANG","MAJLIS PERBANDARAN KUALA SELANGOR","MAJLIS PERBANDARAN KUALA LANGAT","MAJLIS PERBANDARAN HULU SELANGOR","MAJLIS DAERAH SABAK BERNAM","MAJLIS PERBANDARAN SEPANG","MAJLIS BANDARAYA KUALA TERENGGANU","MAJLIS DAERAH BESUT","MAJLIS DAERAH SETIU","MAJLIS PERBANDARAN DUNGUN","MAJLIS DAERAH HULU TERENGGANU","MAJLIS PERBANDARAN KEMAMAN","MAJLIS DAERAH MARANG","DEWAN BANDARAYA KOTA KINABALU","MAJLIS PERBANDARAN SANDAKAN","MAJLIS PERBANDARAN TAWAU","LEMBAGA BANDARAN KUDAT","MAJLIS DAERAH BEAUFORT","MAJLIS DAERAH BELURAN","MAJLIS DAERAH KENINGAU","MAJLIS DAERAH KINABATANGAN","MAJLIS DAERAH KOTA BELUD","MAJLIS DAERAH KOTA MARUDU","MAJLIS DAERAH KUALA PENYU","MAJLIS DAERAH KUNAK","MAJLIS DAERAH LAHAD DATU","MAJLIS DAERAH NABAWAN","MAJLIS DAERAH PAPAR","MAJLIS PERBANDARAN PENAMPANG","MAJLIS DAERAH RANAU","MAJLIS DAERAH SEMPORNA","MAJLIS DAERAH SIPITANG","MAJLIS DAERAH TAMBUNAN","MAJLIS DAERAH TENOM","MAJLIS DAERAH TUARAN","MAJLIS DAERAH PUTATAN","MAJLIS DAERAH PITAS","MAJLIS DAERAH TONGOD","MAJLIS DAERAH TELUPID","LEMBAGA KEMAJUAN BINTULU","DEWAN BANDARAYA KUCHING UTARA","MAJLIS BANDARAYA KUCHING SELATAN","MAJLIS PERBANDARAN PADAWAN","MAJLIS PERBANDARAN SIBU","MAJLIS BANDARAYA MIRI","MAJLIS DAERAH BAU","MAJLIS DAERAH BETONG","MAJLIS DAERAH DALAT & MUKAH","MAJLIS DAERAH KANOWIT","MAJLIS DAERAH KAPIT","MAJLIS DAERAH LAWAS","MAJLIS DAERAH LIMBANG","MAJLIS DAERAH LUBOK ANTU","MAJLIS DAERAH LUNDU","MAJLIS DAERAH MARADONG & JULAU","MAJLIS DAERAH MARUDI","MAJLIS DAERAH MATU & DARO","MAJLIS DAERAH SARATOK","MAJLIS PERBANDARAN KOTA SAMARAHAN","MAJLIS DAERAH SERIAN","MAJLIS DAERAH SARIKEI","MAJLIS DAERAH SIMUNJAN","MAJLIS DAERAH SRI AMAN","MAJLIS DAERAH SUBIS","MAJLIS DAERAH LUAR BANDAR SIBU","MAJLIS DAERAH GEDONG","PBT TAMAN PERINDUSTRIAN HI-TECH KULIM","LEMBAGA PEMBANGUNAN TIOMAN","PERBADANAN LABUAN","PERBADANAN PUTRAJAYA","DEWAN BANDARAYA KUALA LUMPUR"];
        $latestPbtList = "d";//json_decode($pbtJson, true);
        
        $query = ePALM::whereNull('is_komponen')
            ->select('nama_pbt', 'negeri_taman')
            // ->orderBy('negeri_taman', 'ASC')
            ->orderBy('nama_pbt', 'ASC')
            ->distinct()
            ->get();
        $namaPbtList = $query->pluck('nama_pbt')->toArray();
        // $collection = collect($staticPbtList);
        foreach ($pbtJson as $record) {
            $parts = explode(' ', strtoupper($record));

            if (count($parts) < 3){
                $result[] = $record;
            }else{
                $district = implode(' ', array_slice($parts, 2));
                $result[] = $district;
            }
        }
        sort($result);
        dd($result);

    }
}
