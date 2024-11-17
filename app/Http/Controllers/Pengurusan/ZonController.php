<?php

namespace App\Http\Controllers\Pengurusan;

use App\Http\Controllers\Controller;
use App\Model\Zon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


class ZonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware(['role_or_permission:Pentadbir Sistem|zon-list']);
        $this->middleware(['role_or_permission:Pentadbir Sistem|zon-create'], ['only' => ['create', 'store']]);
        $this->middleware(['role_or_permission:Pentadbir Sistem|zon-edit'], ['only' => ['edit', 'update']]);
        $this->middleware(['role_or_permission:Pentadbir Sistem|zon-delete'], ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $zone = Zon::latest()->paginate();

        return view('pengurusan.zon.index', ['zone' => $zone]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pengurusan.zon.create');
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
            'tajuk' => ['required', 'min:3', 'regex:/[0-9a-zA-Z @\/\'`]+$/'],
            'lokasi' => ['nullable', 'min:3', 'regex:/[0-9a-zA-Z @\/\'`]+$/'],
            //'fail_dokumen' => 'required|image|max:20480',
            'tarikh' => 'required',
        ], [
            'required' => ':attribute diperlukan.',
            'min' => ':attribute terlalu ringkas, minima 3 aksara.',
            'regex' => ':attribute format tidak sah.',
        ]);

        //Semak sekiranya wujud input fail_dokumen
        // if ($request->hasFile('fail_dokumen')) {
        //     //nama baru bagi fail yg di upload
        //     //akan disimpan ke dalm fields imej
        //     $filename = 'zon_' . time() . '.' . $request->fail_dokumen->extension();
        //     $filenameMime = $request->fail_dokumen->getClientMimeType();
        //     $filenameExtension = $request->fail_dokumen->extension();
        //     $filenameSize = $request->fail_dokumen->getSize();

        //     //Store Image in Storage Folder
        //     //storage/app/images/file.png
        //     $request->fail_dokumen->storeAs('public/images/shares/zon/', $filename);

        //     $request->request->add(['dokumen' => $filename, 'extension' => $filenameExtension, 'mimes' => $filenameMime, 'size' => $filenameSize]);
        // }
        // $request->merge(['tarikh' => date('Y-m-d', strtotime($request->tarikh))]);

         //define data field of Model
         Zon::create($request->all());

        // //redirect to 'user.designations'
          return response()->json(['success'=>'Maklumat Lokasi Ditambah.']);
        //return redirect()->route('pengurusan.zon.index')->with('successMessage', 'Maklumat zon telah berjaya disimpan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Zon  $zon
     * @return \Illuminate\Http\Response
     */
    public function show(Zon $zon)
    {
        return view('pengurusan.zon.show', ['zon' => $zon]);
    }

    /**
     * Download the specified resource.
     *
     * @param  \App\Model\Zon  $zon
     * @return \Illuminate\Http\Response
     */
    // public function download(Zon $zon)
    // {
    //     return Storage::download(
    //         'public/images/shares/zon/' . $zon->dokumen,
    //         Str::slug(Str::lower($zon->tajuk), '-') . '.' . $zon->extension,
    //         [
    //             'Content-Description' => $zon->tajuk,
    //             'Content-Type' => $zon->mimes,
    //         ]
    //     );
    // }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Zon  $zon
     * @return \Illuminate\Http\Response
     */
    public function edit(Zon $zon)
    {
        return view('pengurusan.zon.edit', ['zon' => $zon]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Zon  $zon
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Zon $zon)
    {

        $request->validate([
            'tajuk' => ['required', 'min:3', 'regex:/[0-9a-zA-Z @\/\'`]+$/'],
            'lokasi' => ['nullable', 'min:3', 'regex:/[0-9a-zA-Z @\/\'`]+$/'],
            //'fail_dokumen' => 'nullable|image|max:20480',
            'tarikh' => 'required',
        ], [
            'required' => ':attribute diperlukan.',
            'min' => ':attribute terlalu ringkas, minima 3 aksara.',
            'regex' => ':attribute format tidak sah.',
        ]);

        //Semak sekiranya wujud input fail_dokumen
        // if ($request->hasFile('fail_dokumen')) {
        //     //nama baru bagi fail yg di upload
        //     //akan disimpan ke dalm fields imej
        //     $filename = 'zon_' . time() . '.' . $request->fail_dokumen->extension();
        //     $filenameMime = $request->fail_dokumen->getClientMimeType();
        //     $filenameExtension = $request->fail_dokumen->extension();
        //     $filenameSize = $request->fail_dokumen->getSize();

        //     //Store Image in Storage Folder
        //     //storage/app/images/file.png
        //     $request->fail_dokumen->storeAs('public/images/shares/zon/', $filename);

        //     $request->request->add(['dokumen' => $filename, 'extension' => $filenameExtension, 'mimes' => $filenameMime, 'size' => $filenameSize]);
        // }
        // $request->merge(['tarikh' => date('Y-m-d', strtotime($request->tarikh))]);

         //define data field of Model
         $zon->update($request->all());

        // //redirect to 'user.designations'
          return response()->json(['success'=>'Maklumat Lokasi Dikemaskini']);
        // //return redirect()->route('pengurusan.zon.index')->with('successMessage', 'Maklumat zon telah berjaya disimpan');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Zon  $zon
     * @return \Illuminate\Http\Response
     */
    public function destroy(Zon $zon)
    {
        $zon->delete();
        return redirect()->route('pengurusan.zon.index')->with('successMessage', 'Maklumat zon telah dihapuskan');
    }

    public function gambar(Request $request, Zon $zon)
    {

        request()->validate([
            'lokasi' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:20480',
        ], [
            'image.required' => ':attribute diperlukan.',
            'image.max' => 'Saiz fail :attribute hendaklah kurang dari 20480.'
        ], ['image' => 'Gambar']);


        if ($request->has('image')) {

            $fileNameGambar = [
                'gambar_1' => $zon->lokasi . '_1_' . date('ynj-Hi'),
                'gambar_2' => $zon->lokasi . '_2_' . date('ynj-Hi'),
                'gambar_3' => $zon->lokasi . '_3_' . date('ynj-Hi'),
                'gambar_4' => $zon->lokasi . '_4_' . date('ynj-Hi'),
                'gambar_5' => $zon->lokasi . '_5_' . date('ynj-Hi'),
            ];

            $files = $request->file('image');

            $lokasi = $request->lokasi;
            $fileName =  $fileNameGambar[$lokasi] . '.' . $request->image->getClientOriginalExtension();
            // $request->image->storeAs('image', $fileName);

            Storage::disk('public')->putFileAs(
                'public/images/shares/zon/',
                $request->file('image'),
                $fileName
            );

            $zon->{$lokasi} = $fileName;
            $zon->save();

            return Response()->json([
                "image" => $zon->{$lokasi}
            ], Response::HTTP_OK);
        }
    }
}
