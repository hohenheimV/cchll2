<?php

namespace App\Http\Controllers\Pengurusan;

use App\Http\Controllers\Controller;
use App\Model\KTP;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class KTPController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware(['role_or_permission:Pentadbir Sistem|ktp-list']);
        $this->middleware(['role_or_permission:Pentadbir Sistem|ktp-create'], ['only' => ['create', 'store']]);
        $this->middleware(['role_or_permission:Pentadbir Sistem|ktp-edit'], ['only' => ['edit', 'update']]);
        $this->middleware(['role_or_permission:Pentadbir Sistem|ktp-delete'], ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ktps = KTP::latest()->paginate(10);
        return view('pengurusan.ktp.index', compact('ktps'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pengurusan.ktp.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate the request
        $validatedData = $request->validate([
            'tajuk' => ['required', 'min:3'],
            'lokasi' => ['required', 'min:3', 'regex:/^[a-zA-Z0-9\s,.-]+$/'],
            'pbt' => ['required'],
            'jumlah_pokok' => ['required', 'integer', 'min:1'],
            'spesis_pokok' => 'required|array',
            'spesis_pokok.*' => 'required|string|min:3',
            'bilangan_pokok' => 'required|array',
            'bilangan_pokok.*' => 'required|integer|min:1',
            'tinggi_pokok' => 'required|array',
            'tinggi_pokok.*' => 'required|integer|min:1',
            'diameter_pokok' => 'required|array',
            'diameter_pokok.*' => 'required|integer|min:1',
        ], [
            'required' => ':attribute diperlukan.',
            'min' => ':attribute terlalu ringkas, minima 3 aksara.',
            'regex' => ':attribute format tidak sah.',
        ], [
            'tajuk' => 'Nama Program',
            'lokasi' => 'Lokasi',
            'pbt' => 'PBT/Agensi',
            'jumlah_pokok' => 'Jumlah Keseluruhan Pokok',
            'spesis_pokok' => 'Spesis Pokok',
            'bilangan_pokok' => 'Bilangan Pokok',
            'tinggi_pokok' => 'Tinggi Pokok',
            'diameter_pokok' => 'Diameter Pokok',
        ]);

        // Prepare and store species (spesis_pokok), tree count (bilangan_pokok), height (tinggi_pokok), and diameter (diameter_pokok)
        $spesisPokok = [];
        foreach ($request->spesis_pokok as $key => $spesis) {
            $spesisPokok[] = [
                'spesis' => $spesis,
                'bilangan' => $request->bilangan_pokok[$key],
                'tinggi' => $request->tinggi_pokok[$key],
                'diameter' => $request->diameter_pokok[$key],
            ];
        }

        // Insert the main record (KTP) into the database
        $kempen = KTP::create([
            'tajuk' => $validatedData['tajuk'],
            'lokasi' => $validatedData['lokasi'],
            'pbt' => $validatedData['pbt'],
            'jumlah_pokok' => $validatedData['jumlah_pokok'],
            'spesis_pokok' => json_encode($spesisPokok)
        ]);

        // Redirect back to the list page with a success message
        return redirect()->route('pengurusan.ktp.index')
                        ->with('successMessage', 'Maklumat Program Telah Berjaya Disimpan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\KTP  $ktp
     * @return \Illuminate\Http\Response
     */
    public function show(KTP $ktp)
    {
        // Decode the JSON string from the database into a PHP array
        $spesisPokokJumlahPairs = json_decode($ktp->spesis_pokok, true); // `true` makes it an array

        // Return the data to the view
        return view('pengurusan.ktp.show', [
            'ktp' => $ktp,
            'spesisPokokJumlahPairs' => $spesisPokokJumlahPairs, // Pass the parsed data
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\KTP  $ktp
     * @return \Illuminate\Http\Response
     */
    public function edit(KTP $ktp)
    {
        // Decode the JSON string from the database into a PHP array
        $spesisPokokJumlahPairs = json_decode($ktp->spesis_pokok, true); // `true` makes it an array

        // Return the data to the view
        return view('pengurusan.ktp.edit', [
            'ktp' => $ktp,
            'spesisPokokJumlahPairs' => $spesisPokokJumlahPairs, // Pass the parsed data
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\KTP  $ktp
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, KTP $ktp)
    {
        // Validate the request
        $validatedData = $request->validate([
            'tajuk' => ['required', 'min:3'],
            'lokasi' => ['required', 'min:3', 'regex:/^[a-zA-Z0-9\s,.-]+$/'],
            'pbt' => ['required'],
            'jumlah_pokok' => ['required', 'integer', 'min:1'],
            'spesis_pokok' => 'required|array',
            'spesis_pokok.*' => 'required|string|min:3',
            'bilangan_pokok' => 'required|array',
            'bilangan_pokok.*' => 'required|integer|min:1',
            'tinggi_pokok' => 'required|array',
            'tinggi_pokok.*' => 'required|integer|min:1',
            'diameter_pokok' => 'required|array',
            'diameter_pokok.*' => 'required|integer|min:1',
        ], [
            'required' => ':attribute diperlukan.',
            'min' => ':attribute terlalu ringkas, minima 3 aksara.',
            'regex' => ':attribute format tidak sah.',
        ], [
            'tajuk' => 'Nama Program',
            'lokasi' => 'Lokasi',
            'pbt' => 'PBT/Agensi',
            'jumlah_pokok' => 'Jumlah Keseluruhan Pokok',
            'spesis_pokok' => 'Spesis Pokok',
            'bilangan_pokok' => 'Bilangan Pokok',
            'tinggi_pokok' => 'Tinggi Pokok',
            'diameter_pokok' => 'Diameter Pokok',
        ]);

        // Prepare and store species (spesis_pokok), tree count (bilangan_pokok), height (tinggi_pokok), and diameter (diameter_pokok)
        $spesisPokok = [];
        foreach ($request->spesis_pokok as $key => $spesis) {
            $spesisPokok[] = [
                'spesis' => $spesis,
                'bilangan' => $request->bilangan_pokok[$key],
                'tinggi' => $request->tinggi_pokok[$key],
                'diameter' => $request->diameter_pokok[$key],
            ];
        }

        // Update the existing record
        $ktp->update([
            'tajuk' => $validatedData['tajuk'],
            'lokasi' => $validatedData['lokasi'],
            'pbt' => $validatedData['pbt'],
            'jumlah_pokok' => $validatedData['jumlah_pokok'],
            'spesis_pokok' => json_encode($spesisPokok)
        ]);

        // Redirect with success message
        return redirect()->route('pengurusan.ktp.index')->with('successMessage', 'Maklumat Program Telah Berjaya Dikemaskini');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\KTP  $ktp
     * @return \Illuminate\Http\Response
     */
    public function destroy(KTP $ktp)
    {
        $ktp->delete();
        return redirect()->route('pengurusan.ktp.index')->with('successMessage', 'Maklumat Program Telah Dihapuskan');
    }
}
