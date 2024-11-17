<?php

namespace App\Http\Controllers\Pengurusan;

use App\Http\Controllers\Controller;
use App\Model\Analisa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


class AnalisaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware(['role_or_permission:Pentadbir Sistem|analisa-list']);
        $this->middleware(['role_or_permission:Pentadbir Sistem|analisa-create'], ['only' => ['create', 'store']]);
        $this->middleware(['role_or_permission:Pentadbir Sistem|analisa-edit'], ['only' => ['edit', 'update']]);
        $this->middleware(['role_or_permission:Pentadbir Sistem|analisa-delete'], ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $analisis = Analisa::latest()->paginate();

        return view('pengurusan.analisa.index', ['analisis' => $analisis]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pengurusan.analisa.create');
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
            'keterangan' => ['nullable', 'min:3', 'regex:/[0-9a-zA-Z @\/\'`]+$/'],
            'fail_dokumen' => 'required|image|max:20480',
            'tarikh' => 'required',
        ], [
            'required' => ':attribute diperlukan.',
            'min' => ':attribute terlalu ringkas, minima 3 aksara.',
            'regex' => ':attribute format tidak sah.',
        ]);

        //Semak sekiranya wujud input fail_dokumen
        if ($request->hasFile('fail_dokumen')) {
            //nama baru bagi fail yg di upload
            //akan disimpan ke dalm fields imej
            $filename = 'analisa_' . time() . '.' . $request->fail_dokumen->extension();
            $filenameMime = $request->fail_dokumen->getClientMimeType();
            $filenameExtension = $request->fail_dokumen->extension();
            $filenameSize = $request->fail_dokumen->getSize();

            //Store Image in Storage Folder
            //storage/app/images/file.png
            $request->fail_dokumen->storeAs('public/images/shares/analisa/', $filename);

            $request->request->add(['dokumen' => $filename, 'extension' => $filenameExtension, 'mimes' => $filenameMime, 'size' => $filenameSize]);
        }
        $request->merge(['tarikh' => date('Y-m-d', strtotime($request->tarikh))]);
        $request->merge(['keterangan' =>'null']);

        //define data field of Model
        Analisa::create($request->all());

        //redirect to 'user.designations'
         return response()->json(['success'=>'You have successfully upload file.']);
        //return redirect()->route('pengurusan.analisa.index')->with('successMessage', 'Maklumat analisa telah berjaya disimpan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Analisa  $analisa
     * @return \Illuminate\Http\Response
     */
    public function show(Analisa $analisa)
    {
        return view('pengurusan.analisa.show', ['analisa' => $analisa]);
    }

    /**
     * Download the specified resource.
     *
     * @param  \App\Model\Analisa  $analisa
     * @return \Illuminate\Http\Response
     */
    public function download(Analisa $analisa)
    {
        return Storage::download(
            'public/images/shares/analisa/' . $analisa->dokumen,
            Str::slug(Str::lower($analisa->tajuk), '-') . '.' . $analisa->extension,
            [
                'Content-Description' => $analisa->tajuk,
                'Content-Type' => $analisa->mimes,
            ]
        );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Analisa  $analisa
     * @return \Illuminate\Http\Response
     */
    public function edit(Analisa $analisa)
    {
        return view('pengurusan.analisa.edit', ['analisa' => $analisa]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Analisa  $analisa
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Analisa $analisa)
    {

        $request->validate([
            'tajuk' => ['required', 'min:3', 'regex:/[0-9a-zA-Z @\/\'`]+$/'],
            'keterangan' => ['nullable', 'min:3', 'regex:/[0-9a-zA-Z @\/\'`]+$/'],
            'fail_dokumen' => 'nullable|image|max:20480',
            'tarikh' => 'required',
        ], [
            'required' => ':attribute diperlukan.',
            'min' => ':attribute terlalu ringkas, minima 3 aksara.',
            'regex' => ':attribute format tidak sah.',
        ]);

        //Semak sekiranya wujud input fail_dokumen
        if ($request->hasFile('fail_dokumen')) {
            //nama baru bagi fail yg di upload
            //akan disimpan ke dalm fields imej
            $filename = 'analisa_' . time() . '.' . $request->fail_dokumen->extension();
            $filenameMime = $request->fail_dokumen->getClientMimeType();
            $filenameExtension = $request->fail_dokumen->extension();
            $filenameSize = $request->fail_dokumen->getSize();

            //Store Image in Storage Folder
            //storage/app/images/file.png
            $request->fail_dokumen->storeAs('public/images/shares/analisa/', $filename);

            $request->request->add(['dokumen' => $filename, 'extension' => $filenameExtension, 'mimes' => $filenameMime, 'size' => $filenameSize]);
        }
        $request->merge(['tarikh' => date('Y-m-d', strtotime($request->tarikh))]);
        $request->merge(['keterangan' =>'null']);

        //define data field of Model
        $analisa->update($request->all());

        //redirect to 'user.designations'
         return response()->json(['success'=>'You have successfully upload file.']);
        //return redirect()->route('pengurusan.analisa.index')->with('successMessage', 'Maklumat analisa telah berjaya disimpan');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Analisa  $analisa
     * @return \Illuminate\Http\Response
     */
    public function destroy(Analisa $analisa)
    {
        $analisa->delete();
        return redirect()->route('pengurusan.analisa.index')->with('successMessage', 'Maklumat analisa telah dihapuskan');
    }
}
