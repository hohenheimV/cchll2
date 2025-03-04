<?php

namespace App\Http\Controllers\Pengurusan;

use App\Http\Controllers\Controller;
use App\Model\eLIND;
use App\User;
use App\Model\MaklumatPenggunaPenggiatIndustri;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

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
                $data = eLIND::latest()->paginate(eLIND::count());
                $view = 'pengurusan.eLIND.index';
                break;

            case 'perunding':
                $data = eLIND::latest()->paginate(10);
                $view = 'pengurusan.eLIND.index';
                break;

            case 'pembekal':
                $data = eLIND::latest()->paginate(10);
                $view = 'pengurusan.eLIND.index';
                break;
            case 'antarabangsa':
                $data = eLIND::latest()->paginate(5);
                $view = 'pengurusan.eLIND.index';
                break;

            case 'ngo':
                $data = eLIND::latest()->paginate(10);
                $view = 'pengurusan.eLIND.index';
                break;

            case 'pendidikan':
                $data = eLIND::latest()->paginate(10);
                $view = 'pengurusan.eLIND.index';
                break;

            default:
                dd($type);
                abort(404); 
        }
        // dd($data);
        return view($view, ['eLIND' => $data]);
    }
     
    public function indexSubmodule()
    {
        // dd('d');
        $eLIND = eLIND::with('roles')->latest()->paginate(10);
        // dd($eLIND);
        return view('pengurusan.eLIND.index', ['eLIND' => $eLIND]);
    }
    public function kontraktor()
    {
        dd('ds');
        $eLIND = eLIND::with('roles')->latest()->paginate(10);
        // dd($eLIND);
        return view('pengurusan.eLIND.index', ['eLIND' => $eLIND]);
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
        // $requestData['no_mof'] = "XTENCION";
        // dd($requestData['email']);
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
        // dd($requestData);
        if(isset($requestData['produk'])){
            $mergedproduk = [];
            $produkArr = $requestData['produk'];
            foreach ($produkArr as $key => $value) {
                for ($i=1; $i <= 2; $i++) { 
                    $idGambar = 'gambar_produk_'.$i.'_'.$key;
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
                // if ($produk_penggiat['name'] !== null) {
                    $mergedproduk[] = $produk_penggiat;
                // }
            }
            $requestData['produk'] = json_encode($mergedproduk);
        }
        // dd($requestData);

        if(isset($requestData['email']) && $requestData['email'] !== null){
            $existingMof = MaklumatPenggunaPenggiatIndustri::where('no_mof', $requestData['no_mof'])->first();
            if ($existingMof) {
                return redirect()->route('pengurusan.eLIND.create',['type' => $type])->with('errorMessage', 'The MOF registration number has already been taken. Please choose another one.');
            }
            $user = User::create([
                'name' => $requestData['name'],
                'email' => $requestData['email'],
                'password' => Hash::make($requestData['no_mof']),
                'is_active' => 1,
            ]);
            $user->assignRole("Penggiat Industri");
            
            $maklumat = MaklumatPenggunaPenggiatIndustri::create([
                'name' => $requestData['name'],
                'email' => $requestData['email'],
                'jenis_industri' => $requestData['jenis_industri'],
                'no_mof' => $requestData['no_mof'],
                'address1' => $requestData['address1'],
                'address2' => $requestData['address2'],
                'postcode' => $requestData['postcode'],
                'locality' => $requestData['locality'],
                'state' => $requestData['state'],
            ]);
        }else{
            return redirect()->route('pengurusan.eLIND.create',['type' => $type])->with('errorMessage', 'Sila masukkan emel.');
        }

        dd($requestData);
    }



    /**
     * Display the specified resource.
     *
     * @param  \App\Model\eLIND  $eLIND
     * @return \Illuminate\Http\Response
     */
    public function show($type, eLIND $id)
    {
        // dd($eLIND);
        // Retrieve the record from the database
        $defaultSpesis = '[{"spesis_pokok":"Pokok Getah Tertua","jumlah_pokok":"RM 2,541.14"}]';

        // Decode the JSON string into a PHP array
        $spesisPokokJumlahPairs = json_decode($defaultSpesis, true); // `true` makes it an array
        // dd($spesisPokokJumlahPairs);

        // Return the data to the view
        return view('pengurusan.eLIND.show', [
            'eLIND' => $id,
            'type' => $type,
            'spesisPokokJumlahPairs' => $spesisPokokJumlahPairs, // Pass the parsed data
        ]);
        return view('pengurusan.eLIND.show'/* , ['eLIND' => $eLIND] */);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\eLIND  $eLIND
     * @return \Illuminate\Http\Response
     */
    public function edit($type, eLIND $id)
    {
        $roles = Role::pluck('name', 'name')->all();
        $userRole = $id->roles->pluck('name', 'name')->all();

        return view('pengurusan.eLIND.edit', ['eLIND' => $id, 'roles' => $roles, 'userRole' => $userRole]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\eLIND  $eLIND
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, eLIND $eLIND)
    {
        $filenames = [];
        $produk = json_decode($eLIND->produk, true);

        if(isset($requestData['produk'])){
            $mergedproduk = [];
            $produkArr = $requestData['produk'];
            foreach ($produkArr as $key => $value) {
                for ($i=1; $i <= 2; $i++) { 
                    $idGambar = 'gambar_produk_'.$i.'_'.$key;
                    if (isset($value[$idGambar]) && $value[$idGambar] instanceof \Illuminate\Http\UploadedFile) {
                        $file = $value[$idGambar];
                        if ($file->isValid()) {
                            $folderName = str_replace(' ', '_', $requestData['name']); 
                            $subfolderName = str_replace(' ', '_', $value['nama']); 
                            $filename = time() . '_' .$file->getClientOriginalName();
                            $path = $file->storeAs('public/uploads/eLIND/' . $folderName . '/' . $subfolderName, $filename);
                            $value[$idGambar] = $filename;
                        }
                    }else{
                        if(isset($produk[$idGambar])){
                            $value[$idGambar] = $produk[$idGambar];
                        }
                    }
                }
                $produk_penggiat = collect($value ?? [])
                ->map(function($item) {
                    return $item;
                })
                ->toArray();
                // if ($produk_penggiat['name'] !== null) {
                    $mergedproduk[] = $produk_penggiat;
                // }
            }
            $requestData['produk'] = json_encode($mergedproduk);
        }

        if ($request->input('action') === 'update') {
            dd($request->input('action'));
            // Handle the update logic
            // For example, saving the changes to the database
        } elseif ($request->input('action') === 'submit') {
            dd($request->all());
            // Handle the submit logic
            // For example, processing the application submission
        }
        // return redirect()->route('pengurusan.eLIND.index',['type' => 'kontraktor'])->with('successMessage', 'Maklumat kempen tanam pokok telah berjaya dikemaskini');
        dd($request->all());
        $request->validate([
            'lat' => ['required'],
            'lng' => ['required'],
            'tajuk' => ['required', 'min:3', 'regex:/[0-9a-zA-Z @\/\'`]+$/'],
            'keterangan' => ['required', 'min:3', 'regex:/[0-9a-zA-Z @\/\'`]+$/'],
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:20480',
        ], [
            'required' => ':attribute diperlukan.',
            'min' => ':attribute terlalu ringkas, minima 3 aksara.',
            'regex' => ':attribute format tidak sah.',
        ], [
            'lat' => 'Latitude',
            'lng' => 'Longitude'
        ]);

        // Check if the image is uploaded
        if ($request->has('gambar')) {
            $filename = 'kempen_tanam_pokok_' . time() . '.' . $request->gambar->extension();
            $request->gambar->storeAs('public/images/shares/eLIND/', $filename);
            $request->merge(['gambar_360' => $filename]);
        }

        $request->merge(['tarikh' => date('Y-m-d')]);

        // Update the existing record
        // $eLIND->update($request->all());

        // Redirect with success message
        return redirect()->route('pengurusan.eLIND.index')->with('successMessage', 'Maklumat kempen tanam pokok telah berjaya dikemaskini');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\eLIND  $eLIND
     * @return \Illuminate\Http\Response
     */
    public function destroy(eLIND $eLIND)
    {
        $eLIND->delete();
        return redirect()->route('pengurusan.eLIND.index')->with('successMessage', 'Maklumat kempen tanam pokok telah dihapuskan');
    }
}
