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

class eLINDController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware(['role_or_permission:Pentadbir Sistem|Penggiat Industri|eLIND-list']);
        $this->middleware(['role_or_permission:Pentadbir Sistem|Penggiat Industri|eLIND-create'], ['only' => ['create', 'store']]);
        $this->middleware(['role_or_permission:Pentadbir Sistem|Penggiat Industri|eLIND-edit'], ['only' => ['edit', 'update']]);
        $this->middleware(['role_or_permission:Pentadbir Sistem|Penggiat Industri|eLIND-delete'], ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    

    public function index($type)
    {
        // dd($type);
        switch ($type) {
            case 'kontraktor':
                $data = MaklumatPenggunaPenggiatIndustri::where('jenis_industri', 'Kontraktor')->latest()->paginate(MaklumatPenggunaPenggiatIndustri::where('jenis_industri', 'Kontraktor')->count());
                $view = 'pengurusan.eLIND.index';
                break;

            case 'perunding':
                $data = MaklumatPenggunaPenggiatIndustri::where('jenis_industri', 'Perunding')->latest()->paginate(10);
                $view = 'pengurusan.eLIND.index';
                break;

            case 'pembekal':
                $data = MaklumatPenggunaPenggiatIndustri::where('jenis_industri', 'Pembekal')->latest()->paginate(10);
                $view = 'pengurusan.eLIND.index';
                break;
            case 'antarabangsa':
                $data = MaklumatPenggunaPenggiatIndustri::where('jenis_industri', 'Pertubuhan Antarabangsa')->latest()->paginate(5);
                $view = 'pengurusan.eLIND.index';
                break;

            case 'ngo':
                $data = MaklumatPenggunaPenggiatIndustri::where('jenis_industri', 'NGO / Badan Ikhtisas')->latest()->paginate(10);
                $view = 'pengurusan.eLIND.index';
                break;

            case 'pendidikan':
                $data = MaklumatPenggunaPenggiatIndustri::where('jenis_industri', 'Institusi Pendidikan')->latest()->paginate(10);
                $view = 'pengurusan.eLIND.index';
                break;

            default:
                dd($type);
                abort(404); 
        }
        // dd($data);
        return view($view, ['eLIND' => $data]);
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
        
        if(isset($requestData['produk'])){
            $mergedproduk = [];
            $produkArr = $requestData['produk'];
            foreach ($produkArr as $key => $value) {
                for ($i=1; $i <= 2; $i++) { 
                    $idGambar = 'gambar_produk_'.$i;
                    if (isset($value[$idGambar]) && $value[$idGambar] instanceof \Illuminate\Http\UploadedFile) {
                        $file = $value[$idGambar];
                        if ($file->isValid()) {
                            $folderName = str_replace(' ', '_', $requestData['name']); 
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
            $requestData['produk'] = json_encode($mergedproduk);
        }
        // dd($requestData);
        if(isset($requestData['email']) && $requestData['email'] !== null && isset($requestData['no_mof'])){
            $existingMof = MaklumatPenggunaPenggiatIndustri::where('no_mof', $requestData['no_mof'])->first();
            if ($existingMof) {
                return redirect()->route('pengurusan.eLIND.create',['type' => $type])->with('errorMessage', 'The MOF registration number has already been taken. Please choose another one.');
            }
            $user = User::create([
                'name' => $requestData['name'],
                'email' => $requestData['email'],
                'password' => Hash::make($requestData['no_mof']),
                'is_active' => 0,
            ]);
            $user->assignRole("Penggiat Industri");
            
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
                    'pekerja' => $requestData['pekerja'],
                ]);
            }
            if ($requestData['jenis_industri'] === 'Perunding' || $requestData['jenis_industri'] === 'Kontraktor') {
                $maklumatData = array_merge($maklumatData, [
                    'status_eperunding' => $requestData['status_eperunding'],
                    'pengalaman' => $requestData['pengalaman'],
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
                    'produk' => $requestData['produk'],
                ]);
            }
            
            $maklumat = MaklumatPenggunaPenggiatIndustri::create($maklumatData);
            $maklumatData['id_elind'] = $maklumat->id_elind;

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
        $eLIND = MaklumatPenggunaPenggiatIndustri_draf::where('id_elind', $id)->first();
        $paparan_portal = MaklumatPenggunaPenggiatIndustri::where('id_elind', $eLIND->id_elind)->first();

        if ($paparan_portal) {
            $status = $paparan_portal->status;
        }
        return view('pengurusan.eLIND.show', [
            'eLIND' => $eLIND,
            'status' => $status,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\eLIND  $eLIND
     * @return \Illuminate\Http\Response
     */
    public function edit($type, $id)
    {
        $eLIND = MaklumatPenggunaPenggiatIndustri_draf::where('id_elind', $id)->first();
        // dd($eLIND);
        return view('pengurusan.eLIND.edit', ['eLIND' => $eLIND]);
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
        $requestData = ($request->all());

        $paparan_portal = isset($requestData['status']) && $requestData['status'] == "on" ? "approved" : "draft";
        $userId = auth()->id();
        // dd($requestData);
        if ($request->input('action') === 'update') {

            $mediaSosial_penggiat = collect($requestData['mediaSosial_penggiat'] ?? [])
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
                                $folderName = str_replace(' ', '_', $requestData['name']); 
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
            }
            // dd($requestData);
            $eLIND_update = $eLIND->update($requestData);
            // dd($eLIND);
            if ($eLIND_update) {
                return redirect()->route('pengurusan.eLIND.edit', ['type' => $type, 'id' => $eLIND->id_elind])->with('successMessage', 'Maklumat '.$requestData['jenis_industri'].' telah berjaya dikemaskini');
            }
        } elseif ($request->input('action') === 'approve') {
            $eLIND->status = $paparan_portal;
            $eLIND->save();
            $eLIND_approve = MaklumatPenggunaPenggiatIndustri::where('id_elind', $eLIND->id_elind)->first();
            if ($eLIND_approve) {
                $dataToUpdate = $eLIND->getAttributes();
                $eLIND_approve->update($dataToUpdate);
            }
            return redirect()->route('pengurusan.eLIND.show', ['type' => $type, 'id' => $eLIND->id_elind])->with('successMessage', 'Maklumat '.$requestData['jenis_industri'].' telah berjaya disimpan');
        } elseif ($request->input('action') === 'prestasi') {
            // $eLIND->prestasi = $requestData['prestasi'];
            // $eLIND->komen = $requestData['komen'];
            $timestamp = now()->format('Y-m-d H:i:s');
            // dd($requestData);
            $index = false;
            if($eLIND == null){
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

            $eLIND->save();

            $eLIND_prestasi = MaklumatPenggunaPenggiatIndustri::where('id_elind', $eLIND->id_elind)->first();
            if ($eLIND_prestasi) {
                $eLIND_prestasi->prestasi = $eLIND->prestasi;
                $eLIND_prestasi->komen = $eLIND->komen;
                $eLIND_prestasi->pentaksir = $eLIND->pentaksir;
                $eLIND_prestasi->save();
            }
            if($index){
                return redirect()->route('pengurusan.eLIND.index', ['type' => $type])->with('successMessage', 'Maklumat Prestasi telah berjaya disimpan');
            }
            return redirect()->route('pengurusan.eLIND.show', ['type' => $type, 'id' => $eLIND->id_elind])->with('successMessage', 'Maklumat '.$requestData['jenis_industri'].' telah berjaya disimpan');
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
}
