<?php

namespace App\Http\Controllers\Pengurusan;

use App\Http\Controllers\Controller;
use App\Model\eLIND;
use App\User;
use App\Model\MaklumatPenggunaPenggiatIndustri;
use App\Model\MaklumatPenggunaPenggiatIndustri_draf;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon; 
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use App\Model\ePALM;
use App\Model\ePALM_draf;
use App\Model\Negeri;
use App\Model\MIB;
use App\Model\Daerah;
use App\Model\Parlimen;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\eLINDExport;

class eLINDController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware(['role_or_permission:Pentadbir Sistem|elind-list']);
        $this->middleware(['role_or_permission:Pentadbir Sistem|elind-create'], ['only' => ['create', 'store']]);
        $this->middleware(['role_or_permission:Pentadbir Sistem|elind-edit'], ['only' => ['edit', 'update']]);
        $this->middleware(['role_or_permission:Pentadbir Sistem|elind-delete'], ['only' => ['destroy']]);
    }


    public function index($type, Request $request)
    {
        // dd($request->query());
        $types = [
            'kontraktor'    => 'Kontraktor',
            'perunding'     => 'Perunding',
            'pembekal'      => 'Pembekal',
            'antarabangsa'  => 'Pertubuhan Antarabangsa',
            'ngo'           => 'NGO / Badan Ikhtisas',
            'pendidikan'    => 'Institusi Pendidikan',
        ];

        if (!array_key_exists($type, $types)) {
            abort(404, 'Jenis industri tidak sah.');
        }

        $query = MaklumatPenggunaPenggiatIndustri::where('jenis_industri', $types[$type]);

        // Role-based filter
        if (auth()->user()->hasRole('Penggiat Industri')) {
            $user = User::find(auth()->id());
            $id_elind = $user->bahagian_jln;
            $query->where('id_elind', $id_elind);

            $data = $query->latest()->paginate(20);

            if ($data->isEmpty()) {
                dump("Akaun Industri anda tidak wujud. Sila hubungi Pentadbir eLANDSKAP");
                Auth::logout();
                return redirect()->route('register');
            }

            // Load status from draft
            $dataDraf = MaklumatPenggunaPenggiatIndustri_draf::where('id_elind', $id_elind)->first();
            if ($dataDraf && isset($data[0])) {
                $data[0]->status = $dataDraf->status;
            }
        } else {
            // Optional filters
            $keyword = strtolower(trim($request->query('keyword')));
            $negeriKod = $request->query('negeri');
            $kelas_kontraktor = $request->query('kelas_kontraktor');
            $bidang_pembekal = $request->query('bidang_pembekal');

            if ($keyword) {
                $request->validate([
                    'keyword' => 'required|min:3|max:255|regex:/(^[A-Za-z0-9\/\- ]+$)+/',
                ]);

                $query->where(function ($q) use ($keyword) {
                    $q->whereRaw('LOWER(name) LIKE ?', ["%{$keyword}%"])
                        ->orWhereRaw('LOWER(no_ssm) LIKE ?', ["%{$keyword}%"])
                        ->orWhereRaw('LOWER(status) LIKE ?', ["%{$keyword}%"]);
                });
            }

            if ($negeriKod) {
                $query->where('state', $negeriKod);
            }

            if ($kelas_kontraktor) {
                $query->where('kelas_kontraktor', $kelas_kontraktor);
            }
            
            if (!is_null($bidang_pembekal)) {
                if (is_numeric($bidang_pembekal)) {
                    // Static bidang (1, 2, 0)
                    $query->where('bidang_pembekal', $bidang_pembekal);
                } else {
                    // Lain-lain from bidang_lain_pembekal
                    $query->where('bidang_lain_pembekal', $bidang_pembekal);
                }
            }

            $data = $query->orderBy('state', 'ASC')->orderBy('name', 'ASC')
                ->paginate(20)
                ->appends($request->query());

            // Replace state code with name
            foreach ($data as $item) {
                $negeri = Negeri::select('nama_negeri')->where('kod_negeri', $item->state)->first();
                $item->state = $negeri ? ucwords(strtolower($negeri->nama_negeri)) : 'Tiada Maklumat';
            }
        }

        return view('pengurusan.eLIND.index', [
            'eLIND' => $data,
            'type' => $types[$type],
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pengurusan.eLIND.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($type, Request $request)
    {
        // dd($request->all());
        $requestData = $request->all();

        // dd($requestData['mediaSosial_penggiat']['Emel']);
        $requestData['email'] = $requestData['mediaSosial_penggiat']['Emel'];

        $mediaSosial_penggiat = collect($requestData['mediaSosial_penggiat'] ?? [])
            ->filter(function($item) {
                return $item !== null;
            })
            ->map(function($item) {
                return $item;
            })
            ->toArray();
        $requestData['mediaSosial_penggiat'] = json_encode($mediaSosial_penggiat);

        if(isset($requestData['pekerja'])){
            $mergedPekerja = [];
            $pekerjaArr = $requestData['pekerja'];
            foreach ($pekerjaArr as $key => $value) {
                $pekerja_penggiat = collect($value ?? [])
                ->map(function($item) {
                    return $item;
                })
                ->toArray();
                if ($pekerja_penggiat['nama'] !== null) {
                    $mergedPekerja[] = $pekerja_penggiat;
                }
            }
            $requestData['pekerja'] = json_encode($mergedPekerja);
        }

        if(isset($requestData['pengalaman'])){
            $mergedPengalaman = [];
            $pengalamanArr = $requestData['pengalaman'];
            foreach ($pengalamanArr as $key => $value) {
                $pengalaman_penggiat = collect($value ?? [])
                ->map(function($item) {
                    return $item;
                })
                ->toArray();
                if ($pengalaman_penggiat['tajuk'] !== null) {
                    $mergedPengalaman[] = $pengalaman_penggiat;
                }
            }
            $requestData['pengalaman'] = json_encode($mergedPengalaman);
        }
        
        // if(isset($requestData['produk'])){
        //     $mergedproduk = [];
        //     $produkArr = $requestData['produk'];
        //     foreach ($produkArr as $key => $value) {
        //         for ($i=1; $i <= 2; $i++) { 
        //             $idGambar = 'gambar_produk_'.$i;
        //             if (isset($value[$idGambar]) && $value[$idGambar] instanceof \Illuminate\Http\UploadedFile) {
        //                 $file = $value[$idGambar];
        //                 if ($file->isValid()) {
        //                     $folderName = str_replace(' ', '_', $requestData['name']); 
        //                     $subfolderName = str_replace(' ', '_', $value['nama']); 
        //                     $filename = time() . '_' .$file->getClientOriginalName();
        //                     $path = $file->storeAs('public/uploads/eLIND/' . $folderName . '/' . $subfolderName, $filename);
        //                     $value[$idGambar] = $filename;
        //                 }
        //             }
        //         }
        //         $produk_penggiat = collect($value ?? [])
        //         ->map(function($item) {
        //             return $item;
        //         })
        //         ->toArray();
        //         if ($produk_penggiat['nama'] !== null) {
        //             $mergedproduk[] = $produk_penggiat;
        //         }
        //     }
        //     $requestData['produk'] = json_encode($mergedproduk);
        // }
        // dd($requestData);
        if(isset($requestData['no_ssm'])){
            $existingMof = MaklumatPenggunaPenggiatIndustri::where('no_ssm', $requestData['no_ssm'])->first();
            if ($existingMof) {
                return redirect()->route('pengurusan.eLIND.create',['type' => $type])->withInput()->with('errorMessage', 'No. Pendaftaran Syarikat (SSM) telah wujud.');
            }
            // $user = User::create([
            //     'name' => $requestData['name'],
            //     'email' => $requestData['email'],
            //     'password' => Hash::make($requestData['no_mof']),
            //     'is_active' => 0,
            // ]);
            // $user->assignRole("Penggiat Industri");
            
            $maklumatData = [
                'name' => $requestData['name'],
                'email' => $requestData['email'],
                'jenis_industri' => $requestData['jenis_industri'],
                'no_mof' => $requestData['no_mof'],
                'address1' => $requestData['address1'],
                'address2' => $requestData['address2'],
                'postcode' => $requestData['postcode'],
                'locality' => $requestData['locality'],
                'state' => $requestData['state'],
                'no_ssm' => $requestData['no_ssm'],
                'bilPekerja' => $requestData['bilPekerja'],
                'mediaSosial_penggiat' => $requestData['mediaSosial_penggiat'],
            ];
            
            if ($requestData['jenis_industri'] === 'Perunding' || $requestData['jenis_industri'] === 'Kontraktor' || $requestData['jenis_industri'] === 'Pembekal') {
                $maklumatData = array_merge($maklumatData, [
                    'pekerja' => $requestData['pekerja'] ?? null,
                    'pengalaman' => $requestData['pengalaman'] ?? null,
                ]);
            }
            if ($requestData['jenis_industri'] === 'Perunding' || $requestData['jenis_industri'] === 'Kontraktor') {
                $maklumatData = array_merge($maklumatData, [
                    'status_eperunding' => $requestData['status_eperunding'],
                ]);
            }
            if ($requestData['jenis_industri'] === 'Perunding') {
                $maklumatData = array_merge($maklumatData, [
                    'no_ilam' => $requestData['no_ilam'],
                    'tarikh_luput_ilam' => $requestData['tarikh_luput_ilam'],
                ]);
            }
            if ($requestData['jenis_industri'] === 'Kontraktor') {
                $maklumatData = array_merge($maklumatData, [
                    'kelas_kontraktor' => $requestData['kelas_kontraktor'],
                    'no_cidb' => $requestData['no_cidb'],
                    'taraf_bumiputera' => $requestData['taraf_bumiputera'],
                    'bidang_kepakaran' => $requestData['bidang_kepakaran'],
                ]);
            }
            if ($requestData['jenis_industri'] === 'Pembekal') {
                $maklumatData = array_merge($maklumatData, [
                    'bidang_pembekal' => $requestData['bidang_pembekal'],
                    'bidang_lain_pembekal' => $requestData['bidang_lain_pembekal'],
                    'saiz_nurseri' => $requestData['saiz_nurseri'],
                    // 'produk' => $requestData['produk'],
                ]);
            }
            // dd($maklumatData);
            $maklumat = MaklumatPenggunaPenggiatIndustri::create($maklumatData);
            $maklumatData['id_elind'] = $maklumat->id_elind;

            if(isset($requestData['produk'])){
                $mergedproduk = [];
                $produkArr = $requestData['produk'];
                foreach ($produkArr as $key => $value) {
                    for ($i=1; $i <= 2; $i++) { 
                        $idGambar = 'gambar_produk_'.$i;
                        if (isset($value[$idGambar]) && $value[$idGambar] instanceof \Illuminate\Http\UploadedFile) {
                            $file = $value[$idGambar];
                            if ($file->isValid()) {
                                $folderName = str_replace(' ', '_', $maklumat->id_elind.' '.$maklumatData['name']); 
                                $subfolderName = str_replace(' ', '_', $value['nama']); 
                                $filename = time() . '_' .$file->getClientOriginalName();
                                $path = $file->storeAs('public/uploads/eLIND/' . $folderName . '/' . $subfolderName, $filename);
                                $value[$idGambar] = $filename;
                            }
                        }
                    }
                    $produk_penggiat = collect($value ?? [])
                    ->map(function($item) {
                        return $item;
                    })
                    ->toArray();
                    if ($produk_penggiat['nama'] !== null) {
                        $mergedproduk[] = $produk_penggiat;
                    }
                }
                $maklumatData['produk'] = json_encode($mergedproduk);
                $maklumat->update([
                    'produk' => $maklumatData['produk'],
                ]);
            }

            if ($request->hasFile('profil_syarikat')) {
                $file = $request->file('profil_syarikat');
                
                if ($file->isValid()) {
                    $folderName = str_replace(' ', '_', $maklumat->id_elind.' '.$maklumatData['name']);
                    $filename = time() . '_' .$file->getClientOriginalName();
                    $path = $file->storeAs('public/uploads/eLIND/' . $folderName, $filename);
                }
                $maklumatData['profil_syarikat'] = $filename;
                $maklumat->update([
                    'profil_syarikat' => $maklumatData['profil_syarikat'],
                ]);
            }

            $maklumat = MaklumatPenggunaPenggiatIndustri_draf::create($maklumatData);

        }else if($requestData['jenis_industri'] === 'Pertubuhan Antarabangsa' || $requestData['jenis_industri'] === 'NGO / Badan Ikhtisas' || $requestData['jenis_industri'] === 'Institusi Pendidikan'){
            $maklumatData = [
                'name' => $requestData['name'],
                'email' => $requestData['email'],
                'jenis_industri' => $requestData['jenis_industri'],
                'address1' => $requestData['address1'],
                'address2' => $requestData['address2'],
                'postcode' => $requestData['postcode'],
                'locality' => $requestData['locality'],
                'state' => $requestData['state'],
                'mediaSosial_penggiat' => $requestData['mediaSosial_penggiat'],
            ];
            
            if ($requestData['jenis_industri'] === 'Pertubuhan Antarabangsa' || $requestData['jenis_industri'] === 'NGO / Badan Ikhtisas') {
                $maklumatData = array_merge($maklumatData, [
                    'nama_presiden' => $requestData['nama_presiden'],
                ]);
            }
            if ($requestData['jenis_industri'] === 'NGO / Badan Ikhtisas') {
                $maklumatData = array_merge($maklumatData, [
                    'kategori_ngo' => $requestData['kategori_ngo'],
                ]);
            }
            if ($requestData['jenis_industri'] === 'Pertubuhan Antarabangsa') {
                $maklumatData = array_merge($maklumatData, [
                    'wakil_negara' => $requestData['wakil_negara'],
                ]);
            }
            if ($requestData['jenis_industri'] === 'Institusi Pendidikan') {
                $maklumatData = array_merge($maklumatData, [
                    'jenis_institusi' => $requestData['jenis_institusi'],
                ]);
            }
            $maklumat = MaklumatPenggunaPenggiatIndustri::create($maklumatData);
            $maklumatData['id_elind'] = $maklumat->id_elind;

            $maklumat = MaklumatPenggunaPenggiatIndustri_draf::create($maklumatData);

        }else{
            return redirect()->route('pengurusan.eLIND.create',['type' => $type])->with('errorMessage', 'Maklumat '.$requestData['jenis_industri'].' tidak berjaya disimpan.');
        }
        return redirect()->route('pengurusan.eLIND.index',['type' => $type])->with('successMessage', 'Maklumat '.$requestData['jenis_industri'].' telah berjaya disimpan.');
    }



    /**
     * Display the specified resource.
     *
     * @param  \App\Model\eLIND  $eLIND
     * @return \Illuminate\Http\Response
     */
    public function show($type, $id)
    {
        // $eLIND = MaklumatPenggunaPenggiatIndustri_draf::where('id_elind', $id)->first();
        $paparan_portal = '';
        
        if(auth()->user()->hasRole('Penggiat Industri')){
            $user = User::find(auth()->id());
            $id_elind = $user->bahagian_jln;
            $eLIND = MaklumatPenggunaPenggiatIndustri_draf::where('id_elind', $id_elind)->where('id_elind', $id)->first();
            if($eLIND){
                switch ($type) {
                    case 'kontraktor':
                        $data = 'Kontraktor';
                        break;
    
                    case 'perunding':
                        $data = 'Perunding';
                        break;
    
                    case 'pembekal':
                        $data = 'Pembekal';
                        break;
                    case 'antarabangsa':
                        $data = 'Pertubuhan Antarabangsa';
                        break;
    
                    case 'ngo':
                        $data = 'NGO / Badan Ikhtisas';
                        break;
    
                    case 'pendidikan':
                        $data = 'Institusi Pendidikan';
                        break;
    
                    default:
                        abort(404); 
                }
                if ($data !== $eLIND->jenis_industri) {
                    abort(403, 'User does not have any of the necessary access rights. '); 
                }
            }
        }else{
            $eLIND = MaklumatPenggunaPenggiatIndustri_draf::where('id_elind', $id)->first();
            $paparan_portal = MaklumatPenggunaPenggiatIndustri::where('id_elind', $eLIND->id_elind)->first();
        }

        if ($paparan_portal) {
            $status = $paparan_portal->status;
        }else{
            $status = '';
        }
        $latestAudit = $eLIND->status != 'approved' ? $eLIND->audits()->latest()->take(3)->get() : null;
        if($eLIND){
            return view('pengurusan.eLIND.show', [
                'eLIND' => $eLIND,
                'status' => $status,
                'latestAudit' => $latestAudit,
            ]);
        }else{
            abort(403, 'User does not have any of the necessary access rights. '); 
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\eLIND  $eLIND
     * @return \Illuminate\Http\Response
     */
    public function edit($type, $id)
    {
        if(auth()->user()->hasRole('Penggiat Industri')){
            $user = User::find(auth()->id());
            $id_elind = $user->bahagian_jln;
            $eLIND = MaklumatPenggunaPenggiatIndustri_draf::where('id_elind', $id_elind)->where('id_elind', $id)->first();
            if($eLIND){
                switch ($type) {
                    case 'kontraktor':
                        $data = 'Kontraktor';
                        break;
    
                    case 'perunding':
                        $data = 'Perunding';
                        break;
    
                    case 'pembekal':
                        $data = 'Pembekal';
                        break;
                    case 'antarabangsa':
                        $data = 'Pertubuhan Antarabangsa';
                        break;
    
                    case 'ngo':
                        $data = 'NGO / Badan Ikhtisas';
                        break;
    
                    case 'pendidikan':
                        $data = 'Institusi Pendidikan';
                        break;
    
                    default:
                        abort(404); 
                }
                if ($data !== $eLIND->jenis_industri) {
                    abort(403, 'User does not have any of the necessary access rights. '); 
                }
            }
        }else{
            $eLIND = MaklumatPenggunaPenggiatIndustri_draf::where('id_elind', $id)->first();
        }
        // dd($id);
        // return view('pengurusan.eLIND.edit', ['eLIND' => $eLIND]);
        if($eLIND){
            return view('pengurusan.eLIND.edit', [
                'eLIND' => $eLIND,
            ]);
        }else{
            abort(403, 'User does not have any of the necessary access rights. '); 
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\eLIND  $eLIND
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $type, $id)
    {
        $eLIND = MaklumatPenggunaPenggiatIndustri_draf::where('id_elind_draf', $id)->first();
        // $request->request->remove('name');
        $request->request->remove('no_ssm');
        $request->request->remove('jenis_industri');
        $requestData = ($request->all());

        $paparan_portal = isset($requestData['status']) && $requestData['status'] == "on" ? "approved" : "draft";
        $userId = auth()->id();
        // dd($requestData);
        if ($request->input('action') === 'update') {
            $requestData['email'] = $requestData['mediaSosial_penggiat']['Emel'];
            $mediaSosial_penggiat = collect($requestData['mediaSosial_penggiat'] ?? [])
                ->filter(function($item) {
                    return $item !== null;
                })
                ->map(function($item) {
                    return $item;
                })
                ->toArray();
            $requestData['mediaSosial_penggiat'] = json_encode($mediaSosial_penggiat);
            // dd( $requestData['mediaSosial_penggiat']);
            if(isset($requestData['pekerja'])){
                $mergedPekerja = [];
                $pekerjaArr = $requestData['pekerja'];
                foreach ($pekerjaArr as $key => $value) {
                    $pekerja_penggiat = collect($value ?? [])
                    ->map(function($item) {
                        return $item;
                    })
                    ->toArray();
                    if ($pekerja_penggiat['nama'] !== null) {
                        $mergedPekerja[] = $pekerja_penggiat;
                    }
                }
                $requestData['pekerja'] = json_encode($mergedPekerja);
            }

            if(isset($requestData['pengalaman'])){
                $mergedPengalaman = [];
                $pengalamanArr = $requestData['pengalaman'];
                foreach ($pengalamanArr as $key => $value) {
                    $pekerja_penggiat = collect($value ?? [])
                    ->map(function($item) {
                        return $item;
                    })
                    ->toArray();
                    if ($pekerja_penggiat['tajuk'] !== null) {
                        $mergedPengalaman[] = $pekerja_penggiat;
                    }
                }
                $requestData['pengalaman'] = json_encode($mergedPengalaman);
            }

            if(isset($requestData['produk'])){
                $mergedproduk = [];
                $produkArr = $requestData['produk'];
                foreach ($produkArr as $key => $value) {
                    for ($i=1; $i <= 2; $i++) { 
                        $idGambar = 'gambar_produk_'.$i;
                        if (isset($value[$idGambar]) && $value[$idGambar] instanceof \Illuminate\Http\UploadedFile) {
                            $file = $value[$idGambar];
                            if ($file->isValid()) {
                                $folderName = str_replace(' ', '_', $eLIND->id_elind.' '.$eLIND->name); 
                                $subfolderName = str_replace(' ', '_', $value['nama']); 
                                $filename = time() . '_' .$file->getClientOriginalName();
                                $path = $file->storeAs('public/uploads/eLIND/' . $folderName . '/' . $subfolderName, $filename);
                                $value[$idGambar] = $filename;
                            }
                        }else if(isset($value['existing_image'.$i])){
                            $value[$idGambar] = $value['existing_image'.$i];
                            unset($value['existing_image'.$i]);
                        }else{
                            // $value[$idGambar] = null;
                        }
                    }
                    $produk_penggiat = collect($value ?? [])
                    ->map(function($item) {
                        return $item;
                    })
                    ->toArray();
                    if ($produk_penggiat['nama'] !== null) {
                        $mergedproduk[] = $produk_penggiat;
                    }
                }
                $requestData['produk'] = json_encode($mergedproduk);

                // $oldNamaPembekal = str_replace(' ', '_', $eLIND->id_elind.' '.$eLIND->name);
                // $newNamaPembekal = str_replace(' ', '_', $eLIND->id_elind.' '.$requestData['name']);

                // if ($newNamaPembekal && $oldNamaPembekal !== $newNamaPembekal) {
                //     $oldFolder = storage_path("app/public/uploads/eLIND/{$oldNamaPembekal}");
                //     $newFolder = storage_path("app/public/uploads/eLIND/{$newNamaPembekal}");

                //     if (file_exists($oldFolder)) {
                //         // Rename folder
                //         rename($oldFolder, $newFolder);
                //         $rename_eLIND = MaklumatPenggunaPenggiatIndustri::where('id_elind', $eLIND->id_elind)->first();
                //         if ($rename_eLIND) {
                //             $rename_eLIND->update([
                //                 'name' => $requestData['name']
                //             ]);
                //         }
                //     }else{
                //         unset($requestData['name']);
                //     }
                // }
            }

            if ($request->hasFile('profil_syarikat')) {
                $file = $request->file('profil_syarikat');
                
                if ($file->isValid()) {
                    $folderName = str_replace(' ', '_', $eLIND->id_elind.' '.$eLIND->name); 
                    $filename = time() . '_' .$file->getClientOriginalName();
                    $path = $file->storeAs('public/uploads/eLIND/' . $folderName, $filename);
                }
                $requestData['profil_syarikat'] = $filename;
            }

            $oldNamaPembekal = str_replace(' ', '_', $eLIND->id_elind.' '.$eLIND->name);
            $newNamaPembekal = str_replace(' ', '_', $eLIND->id_elind.' '.$requestData['name']);

            if ($newNamaPembekal && $oldNamaPembekal !== $newNamaPembekal) {
                $oldFolder = storage_path("app/public/uploads/eLIND/{$oldNamaPembekal}");
                $newFolder = storage_path("app/public/uploads/eLIND/{$newNamaPembekal}");

                if (file_exists($oldFolder)) {
                    // Rename folder
                    rename($oldFolder, $newFolder);
                    $rename_eLIND = MaklumatPenggunaPenggiatIndustri::where('id_elind', $eLIND->id_elind)->first();
                    if ($rename_eLIND) {
                        $rename_eLIND->update([
                            'name' => $requestData['name']
                        ]);
                    }
                }else{
                    // unset($requestData['name']);
                }
            }

            $wasApproved = $eLIND->status === 'approved';
            $penggiat = MaklumatPenggunaPenggiatIndustri::where('id_elind', $eLIND->id_elind)->first();
            $statusInit = isset($penggiat->status) ? $penggiat->status : 'draft';

            $requestData['status'] = "draft";
            // dd($requestData);
            $eLIND_update = $eLIND->update($requestData);
            // dd($eLIND);
            if ($eLIND_update) {
                if ($wasApproved || $statusInit == 'draft') {
                    $bahagian_jln = 8;
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
                        // ->orWhere(function ($query) use ($bahagian_jln) {
                        //     $query->whereHas('roles', function ($query) {
                        //         $query->where('name', 'Pegawai');
                        //     })
                        //     ->where('bahagian_jln', '7');
                        // })->where('is_active', 1)
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
                                "subject" => 'Modul Pengurusan Maklumat Industri Landskap (eLIND)',
                            ];
            
                            Mail::send('pengurusan.eLIND.mails.perubahan', ['elind' => $eLIND, 'type' => $type, 'jenis' => $eLIND->jenis_industri], function ($message) use ($emailData) {
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
                return redirect()->route('pengurusan.eLIND.edit', ['type' => $type, 'id' => $eLIND->id_elind])->with('successMessage', 'Maklumat '.$eLIND->jenis_industri.' telah berjaya dikemaskini');
            }
        } elseif ($request->input('action') === 'approve') {
            $eLIND->status = $paparan_portal;
            $eLIND->save();
            $eLIND_approve = MaklumatPenggunaPenggiatIndustri::where('id_elind', $eLIND->id_elind)->first();
            if ($eLIND_approve) {
                $dataToUpdate = $eLIND->getAttributes();
                $eLIND_approve->update($dataToUpdate);
            }
            return redirect()->route('pengurusan.eLIND.show', ['type' => $type, 'id' => $eLIND->id_elind])->with('successMessage', 'Maklumat '.$eLIND->jenis_industri.' telah berjaya disimpan');
        } elseif ($request->input('action') === 'prestasi') {
            // $eLIND->prestasi = $requestData['prestasi'];
            // $eLIND->komen = $requestData['komen'];
            $timestamp = now()->format('Y-m-d H:i:s');
            // dd($requestData);
            $index = false;
            if($request->input('elind_id')){
                $index = true;
                $eLIND = MaklumatPenggunaPenggiatIndustri_draf::where('id_elind', $id)->first();
                $requestData['jenis_industri'] = $eLIND->jenis_industri;
            }
            
            $newprestasi = [
                'prestasi' => $requestData['prestasi'],
                'timestamp' => $timestamp,
            ];
            if ($eLIND->prestasi) {
                $prestasiData = json_decode($eLIND->prestasi, true);
            } else {
                $prestasiData = [];
            }
            $prestasiData[] = $newprestasi;
            $eLIND->prestasi = json_encode($prestasiData);


            $newkomen = [
                'komen' => $requestData['komen'],
                'timestamp' => $timestamp,
            ];
            if ($eLIND->komen) {
                $komenData = json_decode($eLIND->komen, true);
            } else {
                $komenData = [];
            }
            $komenData[] = $newkomen;
            $eLIND->komen = json_encode($komenData);


            $newPentaksir = [
                'pentaksir' => $userId,
                'timestamp' => $timestamp,
            ];
            if ($eLIND->pentaksir) {
                $pentaksirData = json_decode($eLIND->pentaksir, true);
            } else {
                $pentaksirData = [];
            }
            $pentaksirData[] = $newPentaksir;
            $eLIND->pentaksir = json_encode($pentaksirData);

            // dd($eLIND->komen);
            $eLIND->save();
            $eLIND_prestasi = MaklumatPenggunaPenggiatIndustri::where('id_elind', $eLIND->id_elind)->first();
            if ($eLIND_prestasi) {
                $eLIND_prestasi->prestasi = $eLIND->prestasi;
                $eLIND_prestasi->komen = $eLIND->komen;
                $eLIND_prestasi->pentaksir = $eLIND->pentaksir;
                $eLIND_prestasi->save();
            }
            // dd($eLIND_prestasi);
            if($index){
                return redirect()->route('pengurusan.eLIND.index', ['type' => $type])->with('successMessage', 'Maklumat Prestasi telah berjaya disimpan');
            }
            return redirect()->route('pengurusan.eLIND.show', ['type' => $type, 'id' => $eLIND->id_elind])->with('successMessage', 'Maklumat '.$eLIND->jenis_industri.' telah berjaya disimpan');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\eLIND  $eLIND
     * @return \Illuminate\Http\Response
     */
    public function destroy($type, $id)
    {
        $delete_draf = MaklumatPenggunaPenggiatIndustri_draf::where('id_elind', $id)->first();
        $delete_main = MaklumatPenggunaPenggiatIndustri::where('id_elind', $id)->first();

        if ($delete_main) {
            if ($delete_draf) {
                $delete_draf->delete();
            }
            $delete_main->delete();
        }
        return redirect()->route('pengurusan.eLIND.index', ['type' => $type])->with('successMessage', 'Maklumat Penggiat Industri Landskap telah dihapuskan');
    }

    public function export($type, Request $request)
    {
        // dd($request->all());
        $format = $request->query('format', 'csv');
        $negeri = $request->query('negeri');

        $types = [
            'kontraktor'    => 'Kontraktor',
            'perunding'     => 'Perunding',
            'pembekal'      => 'Pembekal',
            'antarabangsa'  => 'Pertubuhan Antarabangsa',
            'ngo'           => 'NGO / Badan Ikhtisas',
            'pendidikan'    => 'Institusi Pendidikan',
        ];

        if (!array_key_exists($type, $types)) {
            abort(404, 'Invalid industry type');
        }

        $filename = "Senarai_" . $types[$type];

        $query = MaklumatPenggunaPenggiatIndustri::where('jenis_industri', $types[$type])/* ->limit(10) */;

        $keyword = strtolower(trim($request->query('keyword')));

        if ($negeri) {
            $query->where('state', $negeri);
            $negeriName = Negeri::where('kod_negeri', $negeri)->value('nama_negeri') ?? 'Tiada Maklumat';
            $negeri = str_replace(" ", "_", $negeriName);
            $filename .= "_{$negeri}";
        }

        if ($keyword) {
            $query->where(function ($q) use ($keyword) {
                $q->whereRaw('LOWER(name) LIKE ?', ["%{$keyword}%"])
                ->orWhereRaw('LOWER(no_ssm) LIKE ?', ["%{$keyword}%"])
                ->orWhereRaw('LOWER(status) LIKE ?', ["%{$keyword}%"]);
            });
            $filename .= "_[carian={$keyword}]";
        }

        $data = $query->get();

        if ($format === 'csv') {
            return response()->stream(function () use ($data) {
                $handle = fopen('php://output', 'w');
                fputcsv($handle, ['Bil.', 'Nama', 'Negeri', 'No. Pendaftaran SSM', 'Prestasi']);
                $bil = 1;
                foreach ($data as $item) {
                    $negeriName = Negeri::where('kod_negeri', $item->state)->value('nama_negeri') ?? 'Tiada Maklumat';
                    
                    $prestasiDB = 5;
                    if($item->prestasi != null){
                        $dataprestasi = json_decode($item->prestasi, true);
                        $prestasiDB = end($dataprestasi)['prestasi'] ?? 0;
                    }
                    $prestasi = [
                        '1' => 'Sangat Baik',
                        '2' => 'Baik',
                        '3' => 'Sederhana',
                        '4' => 'Lemah',
                        '5' => 'Tiada Maklumat'
                    ];
                    fputcsv($handle, [
                        $bil++,
                        strtoupper($item->name ?? 'TIADA MAKLUMAT'),
                        strtoupper($negeriName ?? 'TIADA MAKLUMAT'),
                        '="' . ($item->no_ssm ?? 'TIADA MAKLUMAT') . '"',
                        strtoupper($prestasi[$prestasiDB] ?? 'TIADA MAKLUMAT'),
                    ]);
                }

                fclose($handle);
            }, 200, [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename="' . strtoupper($filename) . '.csv"',
            ]);
        }

        if ($format === 'excel') {
            // Optional: create eLINDExport if you want to use Laravel Excel
            return Excel::download(new eLINDExport($data), strtoupper($filename) . '.xlsx');
        }

        return redirect()->route('website.eLIND', ['keyword' => $type]);
    }
}
