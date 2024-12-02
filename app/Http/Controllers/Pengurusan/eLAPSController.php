<?php

namespace App\Http\Controllers\Pengurusan;

use App\Http\Controllers\Controller;
use App\Model\eLAPS;  // Updated to the new model
use Illuminate\Http\Request;

class eLAPSController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware(['role_or_permission:Pentadbir Sistem|eLAPS-list']);
        $this->middleware(['role_or_permission:Pentadbir Sistem|eLAPS-create'], ['only' => ['create', 'store']]);
        $this->middleware(['role_or_permission:Pentadbir Sistem|eLAPS-edit'], ['only' => ['edit', 'update']]);
        $this->middleware(['role_or_permission:Pentadbir Sistem|eLAPS-delete'], ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $eLAPS = eLAPS::latest()->paginate(5);

        return view('pengurusan.eLAPS.index', ['eLAPS' => $eLAPS]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pengurusan.eLAPS.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Get the serialized data from the request (this is the JSON string)
        $serializedSpesis = $request->input('serialized_spesis_pokok');

        // $serializedData = explode(';', $request->input('serialized_spesis_pokok'));

        // foreach ($serializedData as $item) {
        //     list($spesis, $jumlah) = explode(',', $item);
        //     // Store or process the spesis and jumlah
        // }
        // $serializedData = json_decode($request->input('serialized_spesis_pokok'), true);

        // // Loop through the serialized data and store it or process it
        // foreach ($serializedData as $item) {
        //     $spesis = $item['spesis'];
        //     $jumlah = $item['jumlah'];
        //     // Store each spesis and jumlah in the database or process as needed
        // }
        dd($request->all());
        // Validate the request
        $validatedData = $request->validate([
            'lat' => ['required'],
            'lng' => ['required'],
            'tajuk' => ['required', 'min:3', 'regex:/[0-9a-zA-Z @\/\'`]+$/'],
            'keterangan' => ['required', 'min:3', 'regex:/[0-9a-zA-Z @\/\'`]+$/'],
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:20480', // Make gambar nullable
            'spesis_pokok' => 'required|array',
            'spesis_pokok.*' => 'required|string|min:3',
            'jumlah_pokok' => 'required|array',
            'jumlah_pokok.*' => 'required|integer|min:1',
        ], [
            'required' => ':attribute diperlukan.',
            'min' => ':attribute terlalu ringkas, minima 3 aksara.',
            'regex' => ':attribute format tidak sah.',
        ], [
            'lat' => 'Latitude',
            'lng' => 'Longitude',
            'spesis_pokok' => 'Spesis Pokok',
            'jumlah_pokok' => 'Jumlah Pokok',
        ]);
        

        // Process the uploaded image if it exists
        if ($request->has('gambar')) {
            $filename = 'kempen_tanam_pokok_' . time() . '.' . $request->gambar->extension();
            $request->gambar->storeAs('public/images/shares/eLAPS/', $filename);
            $validatedData['gambar_360'] = $filename; // Store image name in the validated data
        }

        // Add the current date to the validated data
        $validatedData['tarikh'] = now()->toDateString(); // Use now() for current date

        // Insert the main record (eLAPS) into the database
        $kempen = eLAPS::create($validatedData);

        // Prepare and store species (spesis_pokok) and tree count (jumlah_pokok)
        $spesisPokok = [];
        foreach ($request->spesis_pokok as $key => $spesis) {
            $spesisPokok[] = [
                'spesis' => $spesis,
                'jumlah' => $request->jumlah_pokok[$key],
            ];
        }

        // Assuming you're storing the species and counts as JSON for now
        $kempen->update([
            'spesis_pokok' => json_encode($spesisPokok),
        ]);

        // Redirect back to the list page with a success message
        return redirect()->route('pengurusan.eLAPS.index')
                        ->with('successMessage', 'Maklumat kempen tanam pokok telah berjaya disimpan');
    }



    /**
     * Display the specified resource.
     *
     * @param  \App\Model\eLAPS  $eLAPS
     * @return \Illuminate\Http\Response
     */
    public function show(eLAPS $eLAPS)
    {
        // Retrieve the record from the database
        $defaultSpesis = '[{"spesis_pokok":"Pokok Getah Tertua","jumlah_pokok":"RM 2,541.14"}]';

        // Decode the JSON string into a PHP array
        $spesisPokokJumlahPairs = json_decode($defaultSpesis, true); // `true` makes it an array
        // dd($spesisPokokJumlahPairs);

        // Return the data to the view
        return view('pengurusan.eLAPS.show', [
            'eLAPS' => $eLAPS,
            'spesisPokokJumlahPairs' => $spesisPokokJumlahPairs, // Pass the parsed data
        ]);
        return view('pengurusan.eLAPS.show', ['eLAPS' => $eLAPS]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\eLAPS  $eLAPS
     * @return \Illuminate\Http\Response
     */
    public function edit(eLAPS $eLAPS)
    {
        // // Retrieve the serialized data from the database
        // $serializedSpesis = "A,213;B,null;null,31";

        // // Split the data by ';' to get each species-quantity pair
        // $pairs = explode(';', $serializedSpesis);

        // // Now, separate each species and quantity
        // $spesisPokokJumlahPairs = array_map(function($pair) {
        //     list($spesis, $jumlah) = explode(',', $pair);
        //     return ['spesis' => $spesis, 'jumlah' => $jumlah];
        // }, $pairs);

        // Retrieve the record from the database
        $defaultSpesis = '[{"spesis_pokok":"Pokok Getah Tertua","jumlah_pokok":"RM 2,541.14"}]';

        // Decode the JSON string into a PHP array
        $spesisPokokJumlahPairs = json_decode($defaultSpesis, true); // `true` makes it an array
        // dd($spesisPokokJumlahPairs);

        // Return the data to the view
        return view('pengurusan.eLAPS.edit', [
            'eLAPS' => $eLAPS,
            'spesisPokokJumlahPairs' => $spesisPokokJumlahPairs, // Pass the parsed data
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\eLAPS  $eLAPS
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, eLAPS $eLAPS)
    {
        dd($request->input('serialized_spesis_pokok'));
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
            $request->gambar->storeAs('public/images/shares/eLAPS/', $filename);
            $request->merge(['gambar_360' => $filename]);
        }

        $request->merge(['tarikh' => date('Y-m-d')]);

        // Update the existing record
        // $eLAPS->update($request->all());

        // Redirect with success message
        return redirect()->route('pengurusan.eLAPS.index')->with('successMessage', 'Maklumat kempen tanam pokok telah berjaya dikemaskini');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\eLAPS  $eLAPS
     * @return \Illuminate\Http\Response
     */
    public function destroy(eLAPS $eLAPS)
    {
        $eLAPS->delete();
        return redirect()->route('pengurusan.eLAPS.index')->with('successMessage', 'Maklumat kempen tanam pokok telah dihapuskan');
    }
}
