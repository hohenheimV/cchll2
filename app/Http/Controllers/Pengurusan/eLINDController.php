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

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    

    // public function index($type, Request $request)
    // {
    //     $keyword = null;
    //     if ($request->filled('keyword')) {
    //         $request->validate([
    //             'keyword' => 'required|min:3|max:255|regex:/(^[A-Za-z0-9\/\- ]+$)+/',
    //         ]);
    //         $keyword = strtolower(trim($request->keyword));
    //     }
    //     // dd($keyword);
    //     if(auth()->user()->hasRole('Penggiat Industri')){
    //         $user = User::find(auth()->id());
    //         $id_elind = $user->bahagian_jln;
    //         // $data = MaklumatPenggunaPenggiatIndustri::where('id_elind', $id_elind)->where('jenis_industri', 'Kontraktor')->first();
    //         // dd($data->jenis_industri);
    //         switch ($type) {
    //             case 'kontraktor':
    //                 $data = MaklumatPenggunaPenggiatIndustri::where('id_elind', $id_elind)->where('jenis_industri', 'Kontraktor')->latest()->paginate(15);
    //                 $view = 'pengurusan.eLIND.index';
    //                 // dd($data);
    //                 break;

    //             case 'perunding':
    //                 $data = MaklumatPenggunaPenggiatIndustri::where('id_elind', $id_elind)->where('jenis_industri', 'Perunding')->latest()->paginate(15);
    //                 $view = 'pengurusan.eLIND.index';
    //                 break;

    //             case 'pembekal':
    //                 $data = MaklumatPenggunaPenggiatIndustri::where('id_elind', $id_elind)->where('jenis_industri', 'Pembekal')->latest()->paginate(15);
    //                 $view = 'pengurusan.eLIND.index';
    //                 break;
    //             case 'antarabangsa':
    //                 $data = MaklumatPenggunaPenggiatIndustri::where('id_elind', $id_elind)->where('jenis_industri', 'Pertubuhan Antarabangsa')->latest()->paginate(15);
    //                 $view = 'pengurusan.eLIND.index';
    //                 break;

    //             case 'ngo':
    //                 $data = MaklumatPenggunaPenggiatIndustri::where('id_elind', $id_elind)->where('jenis_industri', 'NGO / Badan Ikhtisas')->latest()->paginate(15);
    //                 $view = 'pengurusan.eLIND.index';
    //                 break;

    //             case 'pendidikan':
    //                 $data = MaklumatPenggunaPenggiatIndustri::where('id_elind', $id_elind)->where('jenis_industri', 'Institusi Pendidikan')->latest()->paginate(15);
    //                 $view = 'pengurusan.eLIND.index';
    //                 break;

    //             default:
    //                 dd($type);
    //                 abort(404); 
    //         }
    //         if($data->isEmpty()){
    //             dump("Akaun Industri anda tidak wujud. Sila hubungi Pentadbir eLANDSKAP");
    //             Auth::logout();
    //             return redirect()->route('register');
    //         }else{
    //             $dataDraf = MaklumatPenggunaPenggiatIndustri_draf::where('id_elind', $id_elind)->first();
    //             $data[0]->status = $dataDraf->status;
    //         }
    //         // dd($data[0]);
    //         // dd($dataDraf);
    //         // dd($data[0]->status);
    //     }else{
    //         switch ($type) {
    //             case 'kontraktor':
    //                 $data = MaklumatPenggunaPenggiatIndustri::where('jenis_industri', 'Kontraktor')
    //                         ->when($request->filled('keyword'), function ($query) use ($keyword) {
    //                             $query->where(function ($q) use ($keyword) {
    //                                 $q->whereRaw('LOWER(name) LIKE ?', ["%{$keyword}%"])
    //                                 ->orWhereRaw('LOWER(no_ssm) LIKE ?', ["%{$keyword}%"])
    //                                 // ->orWhereRaw('LOWER(kategori_taman) LIKE ?', ["%{$keyword}%"])
    //                                 ->orWhereRaw('LOWER(status) LIKE ?', ["%{$keyword}%"]);
    //                             });
    //                         })
    //                         ->orderBy('state', 'ASC')->orderBy('name', 'ASC')->paginate(15);
    //                 $view = 'pengurusan.eLIND.index';
    //                 break;

    //             case 'perunding':
    //                 $data = MaklumatPenggunaPenggiatIndustri::where('jenis_industri', 'Perunding')
    //                         ->when($request->filled('keyword'), function ($query) use ($keyword) {
    //                             $query->where(function ($q) use ($keyword) {
    //                                 $q->whereRaw('LOWER(name) LIKE ?', ["%{$keyword}%"])
    //                                 ->orWhereRaw('LOWER(no_ssm) LIKE ?', ["%{$keyword}%"])
    //                                 // ->orWhereRaw('LOWER(kategori_taman) LIKE ?', ["%{$keyword}%"])
    //                                 ->orWhereRaw('LOWER(status) LIKE ?', ["%{$keyword}%"]);
    //                             });
    //                         })
    //                         ->orderBy('state', 'ASC')->orderBy('name', 'ASC')->paginate(15);
    //                 $view = 'pengurusan.eLIND.index';
    //                 break;

    //             case 'pembekal':
    //                 $data = MaklumatPenggunaPenggiatIndustri::where('jenis_industri', 'Pembekal')
    //                         ->when($request->filled('keyword'), function ($query) use ($keyword) {
    //                             $query->where(function ($q) use ($keyword) {
    //                                 $q->whereRaw('LOWER(name) LIKE ?', ["%{$keyword}%"])
    //                                 ->orWhereRaw('LOWER(no_ssm) LIKE ?', ["%{$keyword}%"])
    //                                 // ->orWhereRaw('LOWER(kategori_taman) LIKE ?', ["%{$keyword}%"])
    //                                 ->orWhereRaw('LOWER(status) LIKE ?', ["%{$keyword}%"]);
    //                             });
    //                         })
    //                         ->orderBy('state', 'ASC')->orderBy('name', 'ASC')->paginate(15);
    //                 $view = 'pengurusan.eLIND.index';
    //                 break;
    //             case 'antarabangsa':
    //                 $data = MaklumatPenggunaPenggiatIndustri::where('jenis_industri', 'Pertubuhan Antarabangsa')
    //                         ->when($request->filled('keyword'), function ($query) use ($keyword) {
    //                             $query->where(function ($q) use ($keyword) {
    //                                 $q->whereRaw('LOWER(name) LIKE ?', ["%{$keyword}%"])
    //                                 ->orWhereRaw('LOWER(no_ssm) LIKE ?', ["%{$keyword}%"])
    //                                 // ->orWhereRaw('LOWER(kategori_taman) LIKE ?', ["%{$keyword}%"])
    //                                 ->orWhereRaw('LOWER(status) LIKE ?', ["%{$keyword}%"]);
    //                             });
    //                         })
    //                         ->orderBy('state', 'ASC')->orderBy('name', 'ASC')->paginate(15);
    //                 $view = 'pengurusan.eLIND.index';
    //                 break;

    //             case 'ngo':
    //                 $data = MaklumatPenggunaPenggiatIndustri::where('jenis_industri', 'NGO / Badan Ikhtisas')
    //                         ->when($request->filled('keyword'), function ($query) use ($keyword) {
    //                             $query->where(function ($q) use ($keyword) {
    //                                 $q->whereRaw('LOWER(name) LIKE ?', ["%{$keyword}%"])
    //                                 ->orWhereRaw('LOWER(no_ssm) LIKE ?', ["%{$keyword}%"])
    //                                 // ->orWhereRaw('LOWER(kategori_taman) LIKE ?', ["%{$keyword}%"])
    //                                 ->orWhereRaw('LOWER(status) LIKE ?', ["%{$keyword}%"]);
    //                             });
    //                         })
    //                         ->orderBy('state', 'ASC')->orderBy('name', 'ASC')->paginate(15);
    //                 $view = 'pengurusan.eLIND.index';
    //                 break;

    //             case 'pendidikan':
    //                 $data = MaklumatPenggunaPenggiatIndustri::where('jenis_industri', 'Institusi Pendidikan')
    //                         ->when($request->filled('keyword'), function ($query) use ($keyword) {
    //                             $query->where(function ($q) use ($keyword) {
    //                                 $q->whereRaw('LOWER(name) LIKE ?', ["%{$keyword}%"])
    //                                 ->orWhereRaw('LOWER(no_ssm) LIKE ?', ["%{$keyword}%"])
    //                                 // ->orWhereRaw('LOWER(kategori_taman) LIKE ?', ["%{$keyword}%"])
    //                                 ->orWhereRaw('LOWER(status) LIKE ?', ["%{$keyword}%"]);
    //                             });
    //                         })
    //                         ->orderBy('state', 'ASC')->orderBy('name', 'ASC')->paginate(15);
    //                 $view = 'pengurusan.eLIND.index';
    //                 break;

    //             default:
    //                 dd($type);
    //                 abort(404); 
    //         }
    //     }
    //     // dd($data);
    //     return view($view, ['eLIND' => $data]);
    // }

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

            $data = $query->latest()->paginate(15);

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

            $data = $query->orderBy('state', 'ASC')->orderBy('name', 'ASC')
                ->paginate(15)
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
                    unset($requestData['name']);
                }
            }

            $requestData['status'] = "draft";
            // dd($requestData);
            $eLIND_update = $eLIND->update($requestData);
            // dd($eLIND);
            if ($eLIND_update) {
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

    //ePALM
    /* public function import(Request $request)
    {
        ini_set('memory_limit', '2048M');
        ini_set('max_execution_time', 3000);
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls,csv|max:2048',
        ]);

        $file = $request->file('file');
        // $spreadsheet = IOFactory::load($file->getPathname());

        $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReaderForFile($file->getPathname());
        $reader->setReadDataOnly(true);
        $spreadsheet = $reader->load($file->getPathname());

        $sheets = $spreadsheet->getAllSheets(); // Get all sheets
        $sheetCount = count($sheets);
        $result = [];
        $sheetNames = $spreadsheet->getSheetNames();

        // dd($sheets);
        $negeriMap = Negeri::all()->keyBy(function($item) {
            return strtolower($item->nama_negeri);
        });
        
        // $daerahMap = Daerah::all();
        // $parlimenMap = Parlimen::all();
        $daerahMap = Daerah::all()->groupBy(function ($item) {
            return $item->kod_negeri;
        });

        $parlimenMap = Parlimen::all()->groupBy(function ($item) {
            return $item->kod_negeri;
        });

        // dd($daerahMap);
        foreach ($sheets as $sheetIndex => $sheet) {
            // dd($sheetIndex);
            if($sheetIndex != 0 && $sheetIndex <= 6){
                $sheetName = $sheet->getTitle();
                $startRow = 4;
                $startCol = 'B';
                $endCol = 'J';
                // dd(trim(str_replace("JLN-", "",$sheetName)));
                // Get the actual last row of data in the worksheet
                $lastRow = $sheet->getHighestRow(); // e.g. 16000

                // Build dynamic range string like 'B4:J16000'
                $range = $startCol . $startRow . ':' . $endCol . $lastRow;

                // Now safely load the data from that range
                $sheetData = $sheet->rangeToArray($range, null, false, false, true);

                // $range = 'B4:J16';
                // $sheetData = $sheet->rangeToArray($range, null, false, false, true);
                $startIndex = 0;
                foreach ($sheetData as $index => $row) {
                    // dump($row);
                    if($row["B"] != ""){
                        $kod_negeri = str_replace(".", "", strtolower($row["C"]));
                        $kod_negeri = $negeriMap[$kod_negeri]->kod_negeri ?? "00";
                        
                        // $kod_daerah_input = strtolower(str_replace(".", "", trim($row["D"])));

                        // $matchedDaerah = $daerahMap->first(function ($item) use ($kod_daerah_input) {
                        //     return Str::startsWith(strtolower($item->nama_daerah), $kod_daerah_input);
                        // });

                        // $kod_daerah = $matchedDaerah ? $matchedDaerah->kod_daerah : "00";

                        // $kod_parlimen_input = str_replace(".", "", $row["E"]); // "P044 Permatang Pauh"
                        // $parlimenKod = str_replace("P", "", explode(' ', preg_replace('/^P\./i', '', $kod_parlimen_input))[0]); // "044"
                        // $searchKod = "P." . $parlimenKod; // "P.044"

                        // $matchedParlimen = $parlimenMap->first(function ($item) use ($searchKod) {
                        //     return Str::startsWith(strtolower($item->kod_parlimen), strtolower($searchKod));
                        // });

                        // $kod_parlimen = $matchedParlimen ? $matchedParlimen->kod_parlimen : "P.000";

                        $kod_daerah_input = strtolower(preg_replace('/\s+/', '', str_replace(".", "", $row["D"])));

                        $matchedDaerah = collect($daerahMap[$kod_negeri] ?? [])->first(function ($item) use ($kod_daerah_input) {
                            return Str::startsWith(strtolower(preg_replace('/\s+/', '', $item->nama_daerah)), $kod_daerah_input);
                        });

                        $kod_daerah = $matchedDaerah ? $matchedDaerah->kod_daerah : "00";

                        $kod_parlimen_input = str_replace(".", "", $row["E"]);
                        $parlimenKod = str_replace("P", "", explode(' ', preg_replace('/^P\./i', '', $kod_parlimen_input))[0]);
                        $searchKod = "P." . $parlimenKod;

                        $matchedParlimen = collect($parlimenMap[$kod_negeri] ?? [])->first(function ($item) use ($searchKod) {
                            return Str::startsWith(strtolower($item->kod_parlimen), strtolower($searchKod));
                        });

                        $kod_parlimen = $matchedParlimen ? $matchedParlimen->kod_parlimen : "P.000";

                        $requestData = [
                            "nama_taman" => strtoupper($this->sanitize_text($row['B'])),                         
                            "kategori_taman" => strtoupper(trim(str_replace("JLN-", "",$sheetName))),                  
                            "negeri_taman" => $kod_negeri, 
                            "daerah_taman" => $kod_daerah, 
                            "mukim_taman" => null,                             
                            "parlimen_taman" => $kod_parlimen,                      
                            "dun_taman" => null,
                            "keterangan_taman" => trim(str_replace("JLN-", "",$sheetName))." - ".$row["J"],
                            "nama_pbt" => $row["F"],                       
                            "lat" => $row["G"],                             
                            "lng" => $row["H"],                                    
                            "keluasan_taman" => $row["I"],                      
                            "keluasan_unit" => "ekar",                              
                        ];
                        $result[] = $requestData;
                    }
                }
                // foreach ($result as $key => $value) {
                //     dump($value);
                // }
                // dd($requestData);
                // for ($i = $startIndex; $i < count($sheetData); $i++) {
                //     $row = $sheetData[$i];
                //     if (!empty($row['A'])) {
                //         $data = [
                //             'negeri'        => 'ZZ',
                //             'region'        => strtoupper($row['C'] ?? ''),
                //             'sexyen'        => strtoupper($row['D'] ?? ''),
                //             'daerah'        => strtoupper($row['E'] ?? ''),
                //             'mukim'         => $this->expMukim(strtoupper($row['G'] ?? '')),
                //             'pekan_bandar'  => strtoupper($row['I'] ?? ''),
                //             'no_lot'        => $row['K'] ?? '',
                //             'no_hakmilik'   => $row['L'] ?? '',
                //             'pa'            => $row['M'] ?? '',
                //             'luas_asal'     => $row['N'] ?? '',
                //             'luas_ambil'    => $row['O'] ?? '',
                //             'luas_baki'     => $row['P'] ?? '',
                //             'unit_ukuran'   => $row['Q'] ?? '',
                //             'nolotBaru'     => $row['R'] ?? '',
                //             'catatanBaru'   => $row['S'] ?? '',
                //         ];

                //         // Example insert or store
                //         // DB::table('your_table')->insert($data);

                //         $result[] = $data;
                //     }
                // }
            }
        }
        // dd($result);
        foreach (array_chunk($result, 500) as $chunk) {
            foreach ($chunk as $requestData) {
                $newRecord = ePALM::create($requestData);
                $requestData['id_taman'] = $newRecord->id_taman;
                ePALM_draf::create($requestData);
            }
            // dd($chunk);
        }
        dd('Excel processed. Total rows: ' . count($result));
        // Optionally return or log $result
        return back()->with('successMessage', 'Excel processed. Total rows: ' . count($result));
    } */

    // MIB
    /* public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls,csv|max:2048',
        ]);

        $file = $request->file('file');
        // $spreadsheet = IOFactory::load($file->getPathname());

        $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReaderForFile($file->getPathname());
        $reader->setReadDataOnly(true);
        $spreadsheet = $reader->load($file->getPathname());

        $sheets = $spreadsheet->getAllSheets(); // Get all sheets
        $sheetCount = count($sheets);
        $result = [];
        $sheetNames = $spreadsheet->getSheetNames();

        // dd($sheets);
        $negeriMap = Negeri::all()->keyBy(function($item) {
            return strtolower($item->nama_negeri);
        });
        // dd($negeriMap);
        foreach ($sheets as $sheetIndex => $sheet) {
            // dd($sheetIndex);
            if($sheetIndex <= 20){
                $sheetName = $sheet->getTitle();
                $startRow = 2;
                $startCol = 'A';
                $endCol = 'F';
                // $lastRow = $sheet->getHighestRow();
                $lastRow = min($sheet->getHighestRow(), 1500);
                $range = $startCol . $startRow . ':' . $endCol . $lastRow;
                $sheetData = $sheet->rangeToArray($range, null, false, false, true);
                $startIndex = 0;
                $inserted = 0;

                foreach ($sheetData as $index => $row) {
                    $dataController = new \App\Http\Controllers\DataController();
                    $pbtName = $dataController->findFullPbtName($row["B"]);
                    // dd($row);
                    if($row["B"] != ""){
                        if($row["D"] != ''){
                            $kod_negeri = str_replace("wilayah persekutuan", "wp", strtolower($row["A"]));
                            $kod_negeri = str_replace("p.", "pulau", strtolower($kod_negeri));
                            $kod_negeri = str_replace("n.", "negeri ", strtolower($kod_negeri));
                            $kod_negeri = $negeriMap[$kod_negeri]->kod_negeri ?? "00";

                            // $requestData = [
                            //     'ref_num' => $ref_num,
                            //     'no_siri' => $no_siri,
                            //     'taman' => strtoupper($row["D"]),
                            //     'pbt' => $pbtName,
                            //     'negeri' => $kod_negeri,
                            //     'status' => "Diluluskan",
                            //     'status_keahlian' => $row["F"],
                            //     'approved_by' => "eLANDSKAP",
                            //     'approved_at' => timestamp of year $row["E"], //maybe 1-1-$row["E"] 00:00:00
                            // ];

                            // Generate unique reference number using timestamp
                            $ref = Carbon::now()->timestamp . rand(100, 999);
                            $ref_num = "RT$ref";

                            // Get the year from the spreadsheet row (e.g., 2023)
                            $currentYear = $row["E"];

                            // Count existing records created in that year (assuming MIB is your model)
                            $recordCount = MIB::whereYear('approved_at', $currentYear)->count();
                            $no_siri = "JLN-RT/{$currentYear}/" . ($recordCount + 1);
                            $status_keahlian = $row["F"] == "1" ? "Aktif" : "Tidak Aktif";

                            // Build the data array
                            $requestData = [
                                'ref_num' => $ref_num,
                                'no_siri' => $no_siri,
                                'taman' => strtoupper($row["D"]),
                                'pbt' => $pbtName,
                                'negeri' => $kod_negeri,
                                'status' => "Diluluskan",
                                'status_keahlian' => $status_keahlian,
                                'approved_by' => "eLANDSKAP",
                                'approved_at' => Carbon::createFromDate($currentYear, 1, 1)->startOfDay(), // 1 Jan $row["E"] 00:00:00
                            ];
                            $maklumat = MIB::create($requestData);
                            if($maklumat){
                                $inserted++;
                            }
                            // dump($requestData);
                            // $result[] = $requestData;
                        }
                    }
                }
            }
        }
        return back()->with('successMessage', 'Excel processed. Total rows: ' . count($result));
    } */

    // eLIND
    /* public function import(Request $request)
    {
        ini_set('memory_limit', '2048M');
        ini_set('max_execution_time', 3000);
        $request->validate([
            'fileMultiple' => 'required',
            'fileMultiple.*' => 'file|mimes:xlsx,xls,csv|max:12048',
        ]);

        $files = $request->file('fileMultiple'); // This will now be an array of files
        $result = [];

        $negeriMap = Negeri::all()->keyBy(function($item) {
            return strtolower($item->nama_negeri);
        });

        foreach ($files as $file) {
            $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReaderForFile($file->getPathname());
            $reader->setReadDataOnly(true);
            $spreadsheet = $reader->load($file->getPathname());
            $sheets = $spreadsheet->getAllSheets();

            foreach ($sheets as $sheetIndex => $sheet) {
                if ($sheetIndex <= 20) {
                    $startRow = 2;
                    $startCol = 'B';
                    $endCol = 'E';
                    $lastRow = min($sheet->getHighestRow(), 1500);
                    $range = $startCol . $startRow . ':' . $endCol . $lastRow;
                    $sheetData = $sheet->rangeToArray($range, null, false, false, true);

                    foreach ($sheetData as $row) {
                        if (!empty($row["B"])) {
                            $string = preg_replace("/\r\n|\r/", "\n", $row["B"]);
                            $parts = explode("\n", trim($string));
                            $name = strtoupper($this->sanitize_text(trim($parts[0] ?? '')));
                            if (isset($parts[1])) {
                                $row["E"] = $parts[1];
                            }

                            // $string = str_replace(" ", "", $row["E"]);
                            $string = preg_replace('/\xC2\xA0|\s+/u', '', $row["E"]);
                            $parts = explode('(', $string);
                            $serial = $parts[0];

                            if ($serial != '') {
                                $kod_negeri = str_replace("wilayah persekutuan", "wp", strtolower($row["D"]));
                                $kod_negeri = $negeriMap[$kod_negeri]->kod_negeri ?? "00";

                                $requestData = [
                                    'name' => trim($name),
                                    'kelas_kontraktor' => trim($row['C']),
                                    'jenis_industri' => "Kontraktor",
                                    'state' => trim($kod_negeri),
                                    'no_ssm' => trim($serial),
                                ];
                                $result[] = $requestData;
                            }
                        }
                    }
                }
            }
        }

        // Insert to DB (avoiding duplicates)
        $inserted = 0;
        foreach (array_chunk($result, 500) as $chunk) {
            foreach ($chunk as $requestData) {
                if (MaklumatPenggunaPenggiatIndustri::where('no_ssm', $requestData['no_ssm'])->exists()) {
                    // $inserted--;
                    continue;
                }else{
                    $maklumat = MaklumatPenggunaPenggiatIndustri::create($requestData);
                    $requestData['id_elind'] = $maklumat->id_elind;
                    MaklumatPenggunaPenggiatIndustri_draf::create($requestData);
                    $inserted++;
                }
            }
        }

        return back()->with('successMessage', "Excel processed. Inserted: {$inserted} rows.");
    } */

    protected function expMukim($text)
    {
        // Example transformation
        return $text;
    }

    public function sanitize_text($text) {
        // Convert to UTF-8
        $text = mb_convert_encoding($text, 'UTF-8', 'UTF-8');

        // Replace common smart punctuation
        $replace = [
            '‘' => "'", '’' => "'",
            '“' => '"', '”' => '"',
            '–' => '-', '—' => '-',
            '…' => '...',
            '•' => '-',
        ];
        
        return strtr($text, $replace);
    }

    public function importForm()
    {
        // return view('pengurusan.eLIND.import');
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
