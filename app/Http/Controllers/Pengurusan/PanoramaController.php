<?php

namespace App\Http\Controllers\Pengurusan;

use App\Http\Controllers\Controller;
use App\Model\Panorama;
use Illuminate\Http\Request;

class PanoramaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware(['role_or_permission:Pentadbir Sistem|panorama-list']);
        $this->middleware(['role_or_permission:Pentadbir Sistem|panorama-create'], ['only' => ['create', 'store']]);
        $this->middleware(['role_or_permission:Pentadbir Sistem|panorama-edit'], ['only' => ['edit', 'update']]);
        $this->middleware(['role_or_permission:Pentadbir Sistem|panorama-delete'], ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $panoramas = Panorama::latest()->paginate();

        return view('pengurusan.panorama.index', ['panoramas' => $panoramas]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pengurusan.panorama.create');
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

        $request->validate([
            'lat' => ['required'],
            'lng' => ['required'],
            // 'lat' => ['required','regex:/^(\+|-)?(?:90(?:(?:\.0{1,6})?)|(?:[0-9]|[1-8][0-9])(?:(?:\.[0-9]{1,6})?))$/'],
            // 'lng' => ['required', 'regex:/^(\+|-)?(?:180(?:(?:\.0{1,6})?)|(?:[0-9]|[1-9][0-9]|1[0-7][0-9])(?:(?:\.[0-9]{1,6})?))$/'],
            'tajuk' => ['required', 'min:3', 'regex:/[0-9a-zA-Z @\/\'`]+$/'],
            'keterangan' => ['required', 'min:3', 'regex:/[0-9a-zA-Z @\/\'`]+$/'],
            'gambar' => 'required|image|mimes:jpeg,png,jpg|max:20480',
        ], [
            'required' => ':attribute diperlukan.',
            'min' => ':attribute terlalu ringkas, minima 3 aksara.',
            'regex' => ':attribute format tidak sah.',
        ], [
            'lat' => 'Latitude',
            'lng' => 'Longitude'
        ]);

        //Semak sekiranya wujud input gambar
        if ($request->has('gambar')) {
            //nama baru bagi fail yg di upload
            //akan disimpan ke dalm fields imej
            $filename = 'panorama_' . time() . '.' . $request->gambar->extension();

            //Store Image in Storage Folder
            //storage/app/images/file.png
            $request->gambar->storeAs('public/images/shares/panorama/', $filename);

            $request->merge(['gambar_360' => $filename]);
        }
        $request->merge(['tarikh' => date('Y-m-d')]);

        //define data field of Model
        Panorama::create($request->all());

        //redirect to 'user.designations'
        return redirect()->route('pengurusan.panorama.index')->with('successMessage', 'Maklumat panorama telah berjaya disimpan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Panorama  $panorama
     * @return \Illuminate\Http\Response
     */
    public function show(Panorama $panorama)
    {
        return view('pengurusan.panorama.show', ['panorama' => $panorama]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Panorama  $panorama
     * @return \Illuminate\Http\Response
     */
    public function edit(Panorama $panorama)
    {
        return view('pengurusan.panorama.edit', ['panorama' => $panorama]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Panorama  $panorama
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Panorama $panorama)
    {

        $request->validate([
            'lat' => ['required'],
            'lng' => ['required'],
            // 'lat' => ['required','regex:/^(\+|-)?(?:90(?:(?:\.0{1,6})?)|(?:[0-9]|[1-8][0-9])(?:(?:\.[0-9]{1,6})?))$/'],
            // 'lng' => ['required', 'regex:/^(\+|-)?(?:180(?:(?:\.0{1,6})?)|(?:[0-9]|[1-9][0-9]|1[0-7][0-9])(?:(?:\.[0-9]{1,6})?))$/'],
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

        //Semak sekiranya wujud input gambar
        if ($request->has('gambar')) {
            //nama baru bagi fail yg di upload
            //akan disimpan ke dalm fields imej
            $filename = 'panorama_' . time() . '.' . $request->gambar->extension();

            //Store Image in Storage Folder
            //storage/app/images/file.png
            $request->gambar->storeAs('public/images/shares/panorama/', $filename);

            $request->merge(['gambar_360' => $filename]);
        }
        $request->merge(['tarikh' => date('Y-m-d')]);

        //define data field of Model
        $panorama->update($request->all());

        //redirect to 'user.designations'
        return redirect()->route('pengurusan.panorama.index')->with('successMessage', 'Maklumat panorama telah berjaya disimpan');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Panorama  $panorama
     * @return \Illuminate\Http\Response
     */
    public function destroy(Panorama $panorama)
    {
        $panorama->delete();
        return redirect()->route('pengurusan.panorama.index')->with('successMessage', 'Maklumat panorama telah dihapuskan');
    }
}
