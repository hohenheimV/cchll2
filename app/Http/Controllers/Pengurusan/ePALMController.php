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

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ePALM = ePALM::where('is_komponen', null)->latest()->paginate(10);
        $userId = auth()->id();
        $user = User::find($userId);
        if($user->hasRole('Pihak Berkuasa Tempatan')){
            $email = $user->email;
            // $pbt = MaklumatPenggunaPbt::where('email', '=', $email)->first();
            $pbt = MaklumatPenggunaPbt::where('email', '=', '5netsparker@example.com')->first();
            $totalCount = ePALM::where('nama_pbt', $pbt->pbt_name)->count();
            $ePALM = ePALM::where('nama_pbt', $pbt->pbt_name)->where('is_komponen', null)->orderBy('id_taman', 'desc')->paginate($totalCount);
        }else{
            $totalCount = ePALM::count();
            $ePALM = ePALM::where('is_komponen', null)->latest()->paginate($totalCount);
        }
        return view('pengurusan.ePALM.index', ['ePALM' => $ePALM]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pengurusan.ePALM.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        
        // ePALM::create($request->all());
        $requestData = $request->all();
        // dd($requestData);
        if($request->input('jenis') == "komponen"){
            $requestData['nama_pbt'] = "Landskap Perbandaran";
            
            $filenames = [];

            if($request->input('update') == "komponen"){
                $requestData['nama_taman'] = $requestData['nama_komponenX'];
                $requestData['keterangan_taman'] = $requestData['keterangan_tamanX'];
                $requestData['kategori_taman'] = $requestData['nama_komponenX'];
                $requestData['is_komponen'] = $requestData['id_tamanX'];
                $gambar_taman = json_decode($requestData['gambar_taman'], true);
                // dd($gambar_taman);
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
                // dd($requestData);
            }else if($request->input('delete') == "komponen"){
                $ePALMdelete = ePALM_draf::where('id_taman', $requestData['id_tamanD']);
                $ePALMdelete->delete();
                return response()->json(['success' => true, 'message' => 'Data deleted!']);
                dd($ePALMdelete);
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
            // $requestData['folder'] = 'public/uploads/ePALM/' . $folderName.'/'.$subFolderName;

            // dd($requestData);
            // ePALM::create($requestData);
            // ePALM_draf::create($requestData);
            if($request->input('update') == "komponen"){
                // ePALM::where('id_taman', $requestData['is_komponen'])->update([
                //     'nama_taman' => $requestData['nama_taman'],
                //     'kategori_taman' => $requestData['kategori_taman'],
                //     'keterangan_taman' => $requestData['keterangan_taman'],
                //     'gambar_taman' => $requestData['gambar_taman'],
                // ]);    
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

            $newRecord = ePALM::create($requestData);
            $id_taman = $newRecord->id_taman;
            $requestData['id_taman'] = $id_taman;
            $drafRecord = ePALM_draf::create($requestData);
            if($drafRecord && $newRecord){return redirect()->route('pengurusan.ePALM.index')->with('successMessage', 'Maklumat taman telah berjaya disimpan');}
        }

        // Redirect back to the list page with a success message
        return redirect()->route('pengurusan.ePALM.index')
                        ->with('successMessage', 'Maklumat kempen tanam pokok telah berjaya disimpan');
    }



    /**
     * Display the specified resource.
     *
     * @param  \App\Model\ePALM  $ePALM
     * @return \Illuminate\Http\Response
     */
    public function show(ePALM_draf $ePALM)
    {
        if ($ePALM->kategori_taman == "Landskap Perbandaran") {
            // Query the ePALM_draf table where is_komponen equals to id_taman
            $ePALM_komponen = ePALM_draf::where('is_komponen', $ePALM->id_taman)->get();
            
            // Attach the result to the ePALM model. You can do this by adding it as a new attribute or merging it.
            // If you want to add it as a new attribute
            $ePALM->komponen = $ePALM_komponen; // Adding the komponen to the ePALM object
            
            // Alternatively, you can merge it with an array (if you prefer to work with arrays)
            // $ePALM = $ePALM->toArray();  // Convert the ePALM model to an array
            // $ePALM = array_merge($ePALM, ['komponen' => $ePALM_komponen]); // Merge it
        }
        // Retrieve the record from the database
        $defaultSpesis = '[{"spesis_pokok":"Pokok Getah Tertua","jumlah_pokok":"RM 2,541.14"}]';

        // Decode the JSON string into a PHP array
        $spesisPokokJumlahPairs = json_decode($defaultSpesis, true); // `true` makes it an array
        // dd($spesisPokokJumlahPairs);

        // Return the data to the view
        return view('pengurusan.ePALM.show', [
            'ePALM' => $ePALM,
            'spesisPokokJumlahPairs' => $spesisPokokJumlahPairs, // Pass the parsed data
        ]);
        return view('pengurusan.ePALM.show'/* , ['ePALM' => $ePALM] */);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\ePALM  $ePALM
     * @return \Illuminate\Http\Response
     */
    public function edit(ePALM_draf $ePALM)
    {   
        // Check if the kategori_taman is "Landskap Perbandaran"
        if ($ePALM->kategori_taman == "Landskap Perbandaran") {
            // Query the ePALM_draf table where is_komponen equals to id_taman
            $ePALM_komponen = ePALM_draf::where('is_komponen', $ePALM->id_taman)->get();
            
            // Attach the result to the ePALM model. You can do this by adding it as a new attribute or merging it.
            // If you want to add it as a new attribute
            $ePALM->komponen = $ePALM_komponen; // Adding the komponen to the ePALM object
            
            // Alternatively, you can merge it with an array (if you prefer to work with arrays)
            // $ePALM = $ePALM->toArray();  // Convert the ePALM model to an array
            // $ePALM = array_merge($ePALM, ['komponen' => $ePALM_komponen]); // Merge it
        }
        // dd($ePALM);
        // Return the data to the view
        return view('pengurusan.ePALM.edit', [
            'ePALM' => $ePALM, // Return the merged data to the view
        ]);
    }

    // public function fetchComponents(Request $request)
    // {
    //     // Assuming you're fetching ePALM components related to a particular taman
    //     $ePALM = ePALM_draf::find($request->id_taman); // or pass the ID from the request if needed
    //     if ($ePALM && $ePALM->kategori_taman == "Landskap Perbandaran") {
    //         $ePALM_komponen = ePALM_draf::where('is_komponen', $ePALM->id_taman)->get();
    //         $ePALM->komponen = $ePALM_komponen;

    //         // If you want to send back the necessary data to display in the front-end
    //         $imagePaths = [];
    //         foreach ($ePALM_komponen as $komponen) {
    //             $imagePaths[] = [
    //                 'is_komponen' => $komponen->is_komponen,
    //                 'images' => $this->getImagePaths($komponen) // Make sure you have this helper function for the images
    //             ];
    //         }

    //         return response()->json(['success' => true, 'data' => $imagePaths]);
    //     }

    //     return response()->json(['success' => false, 'message' => 'No data found']);
    // }

    // // Helper function to get image paths
    // public function getImagePaths($komponen)
    // {
    //     $gambar_tamanData = json_decode($komponen->gambar_taman, true);
    //     $folderName = str_replace(' ', '_', $komponen->nama_taman);
    //     $subfolderName = str_replace(' ', '_', $komponen->nama_taman);

    //     $gambar_input_modal_1 = isset($gambar_tamanData['gambar_input_modal_1']) ? $folderName.'/'.$subfolderName.'/'.$gambar_tamanData['gambar_input_modal_1'] : null;
    //     $gambar_input_modal_2 = isset($gambar_tamanData['gambar_input_modal_2']) ? $folderName.'/'.$subfolderName.'/'.$gambar_tamanData['gambar_input_modal_2'] : null;
    //     $gambar_input_modal_3 = isset($gambar_tamanData['gambar_input_modal_3']) ? $folderName.'/'.$subfolderName.'/'.$gambar_tamanData['gambar_input_modal_3'] : null;
    //     $gambar_input_modal_4 = isset($gambar_tamanData['gambar_input_modal_4']) ? $folderName.'/'.$subfolderName.'/'.$gambar_tamanData['gambar_input_modal_4'] : null;

    //     return [
    //         asset('storage/uploads/ePALM/' . $gambar_input_modal_1),
    //         asset('storage/uploads/ePALM/' . $gambar_input_modal_2),
    //         asset('storage/uploads/ePALM/' . $gambar_input_modal_3),
    //         asset('storage/uploads/ePALM/' . $gambar_input_modal_4)
    //     ];
    // }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\ePALM  $ePALM
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ePALM_draf $ePALM)
    {
        // if($request->input('jenis') == "komponen"){
        //     $ePALM->update(['nama_taman' => now()]);
        // }
        // dd($request->all());
        $fasiliti = collect($request['fasiliti'] ?? [])
            ->map(function($item) {
                return $item;
            })
            ->toArray();
        $request['fasiliti'] = ($fasiliti);
        // dd($request['fasiliti']);
        $mediaSosial_taman = collect($request['mediaSosial_taman'] ?? [])
            ->map(function($item) {
                return $item;
            })
            ->toArray();
        $request['mediaSosial_taman'] = json_encode($mediaSosial_taman);

        $filenames = [];
        $gambar_taman = json_decode($ePALM->gambar_taman, true);
        // dd($gambar_taman);
        for ($i = 1; $i <= 4; $i++) {
            $inputField = 'Xgambar_input_modal_' . $i;
            if ($request->hasFile($inputField)) {
                $file = $request->file($inputField);
                
                if ($file->isValid()) {
                    $folderName = str_replace(' ', '_', $request->input('nama_taman'));
                    $filename = time() . '_' . $i . '.' . $file->extension();
                    $file->storeAs('public/uploads/ePALM/' . $folderName, $filename);
                    $filenames[$inputField] = $filename;
                    // dump($filename);
                }
                unset($request[$inputField]);
            }else{
                if(isset($gambar_taman[$inputField])){
                    $filenames[$inputField] = $gambar_taman[$inputField];
                }
            }
            // dump($inputField);
        }

        // for ($i = 1; $i <= 4; $i++) {
        //     $inputField = 'Xgambar_input_modal_' . $i;
        //     if ($request->hasFile($inputField)) {
        //         $file = $request->file($inputField);
                
        //         if ($file->isValid()) {
        //             $folderName = str_replace(' ', '_', $request->input('nama_taman'));
        //             $filename = time() . '_' . $i . '.' . $file->extension();
        //             $file->storeAs('public/uploads/ePALM/' . $folderName, $filename);
        //             $filenames[$inputField] = $filename;
        //         }
        //     }
        // }
        $test = json_encode($filenames);
        $request->merge(['gambar_taman' => json_encode($filenames)]);

        $requestData = $request->all();
        // dd(($request->all()));
        if($request->input('jenis') == "komponen"){
            $requestData['nama_pbt'] = $request->input('nama_taman');
            $requestData['kategori_taman'] = "Landskap Perbandaran";
            // ePALM::create($requestData);
            // ePALM_draf::create($requestData);
            return response()->json(['success' => true, 'message' => 'Data saved successfully!']);
        }else{
            if ($request->input('action') === 'update') {
                // $ePALM->update($requestData);
                // dd($ePALM);
                $ePALM_approve = ePALM_draf::where('id_taman', $ePALM->id_taman)->first();
                // dd($ePALM_approve);
                if ($ePALM_approve) {
                    $ePALM_approve->update($requestData);
                }
                // dd($ePALM_approve);
                return redirect()->route('pengurusan.ePALM.edit', [$ePALM_approve])->with('successMessage', 'Maklumat taman telah berjaya dikemaskini');
                // Handle the update logic
                // For example, saving the changes to the database
            } elseif ($request->input('action') === 'submit') {
                dd($request->all());
                // Handle the submit logic
                // For example, processing the application submission
            } elseif ($request->input('action') === 'approve') {
                // dd($ePALM->id_taman);
                $ePALM_approve_draf = ePALM_draf::where('id_taman', $ePALM->id_taman)->first();
                $ePALM_approve_draf->status = "approved";
                // if (is_string($ePALM_approve_draf->fasiliti)) {
                //     $ePALM_approve_draf->fasiliti = json_decode($ePALM_approve_draf->fasiliti, true);
                // }
                $ePALM_approve = ePALM::where('id_taman', $ePALM->id_taman)->first();
                // dd($ePALM_approve_draf);
                if ($ePALM_approve->kategori_taman == "Landskap Perbandaran") {
                    $ePALM_komponen = ePALM::where('is_komponen', $ePALM_approve->id_taman)->get();
                    foreach ($ePALM_komponen as $item) {
                        $ePALM_approve_komponen_draf = ePALM_draf::where('id_taman', $item->id_taman)->first();
                        
                        if($ePALM_approve_komponen_draf){
                            $ePALM_approve_komponen_draf->status = "approved";

                            $ePALM_approve_komponen = ePALM::where('id_taman', $item->id_taman)->first();
                            $dataToUpdate_komponen = $ePALM_approve_komponen_draf->getAttributes();
                            $ePALM_approve_komponen->update($dataToUpdate_komponen);
                            dump($item);
                        }
                    }
                    // dd($ePALM_komponen);
                }
                if ($ePALM_approve) {
                    if (is_string($ePALM_approve_draf->fasiliti)) {
                        $ePALM_approve_draf->fasiliti = json_decode($ePALM_approve_draf->fasiliti, true);
                    }else{
                        // $ePALM_approve_draf->fasiliti = json_encode($ePALM_approve_draf->fasiliti);
                    }
                    // dd($ePALM_approve_draf->fasiliti);
                    $dataToUpdate = $ePALM_approve_draf->getAttributes();
                    // dd($dataToUpdate['fasiliti']);
                    $ePALM_approve->update($dataToUpdate);
                }
                // dd($ePALM_approve);
                // Handle the update logic
                // For example, saving the changes to the database
                return redirect()->route('pengurusan.ePALM.index')->with('successMessage', 'Maklumat taman telah berjaya disimpan');
            }

            // $newRecord = ePALM::create($requestData);
            // $id_taman = $newRecord->id_taman;
            // $requestData['id_taman'] = $id_taman;
            // $drafRecord = ePALM_draf::create($requestData);
            // if($drafRecord && $newRecord){return redirect()->route('pengurusan.ePALM.index')->with('successMessage', 'Maklumat taman telah berjaya disimpan');}
        }

        // dd($request->all());
        if ($request->input('action') === 'update') {
            $ePALM->update($request->all());
            dd($request->input('action'));
            // Handle the update logic
            // For example, saving the changes to the database
        } elseif ($request->input('action') === 'submit') {
            dd($request->all());
            // Handle the submit logic
            // For example, processing the application submission
        }
        // dd($request->all());
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
            $request->gambar->storeAs('public/images/shares/ePALM/', $filename);
            $request->merge(['gambar_360' => $filename]);
        }

        $request->merge(['tarikh' => date('Y-m-d')]);

        // Update the existing record
        // $ePALM->update($request->all());

        // Redirect with success message
        return redirect()->route('pengurusan.ePALM.index')->with('successMessage', 'Maklumat kempen tanam pokok telah berjaya dikemaskini');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\ePALM  $ePALM
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,ePALM_draf $ePALM)
    {
        // dd($request->all());
        // $ePALM->delete();
        if($request->input('komponen') == "delete"){
            return response()->json(['success' => true, 'message' => 'Data saved successfully!']);
        }
        return redirect()->route('pengurusan.ePALM.index')->with('successMessage', 'Maklumat kempen tanam pokok telah dihapuskan');
    }
}
