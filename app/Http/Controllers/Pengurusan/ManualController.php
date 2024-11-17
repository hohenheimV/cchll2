<?php

namespace App\Http\Controllers\Pengurusan;

use App\Http\Controllers\Controller;
use App\Model\Manual;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


class ManualController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware(['role_or_permission:Pentadbir Sistem|manual-list']);
        $this->middleware(['role_or_permission:Pentadbir Sistem|manual-create'], ['only' => ['create', 'store']]);
        $this->middleware(['role_or_permission:Pentadbir Sistem|manual-edit'], ['only' => ['edit', 'update']]);
        $this->middleware(['role_or_permission:Pentadbir Sistem|manual-delete'], ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $manuals = Manual::latest()->paginate();

        return view('pengurusan.manual.index', ['manuals' => $manuals]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pengurusan.manual.create');
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
            'fail_dokumen' => 'required|max:20480',
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
            $filename = 'manual_' . time() . '.' . $request->fail_dokumen->extension();
            $filenameMime = $request->fail_dokumen->getClientMimeType();
            $filenameExtension = $request->fail_dokumen->extension();
            $filenameSize = $request->fail_dokumen->getSize();

            //Store Image in Storage Folder
            //storage/app/images/file.png
            $request->fail_dokumen->storeAs('public/images/shares/manual/', $filename);

            $request->request->add(['dokumen' => $filename, 'extension' => $filenameExtension, 'mimes' => $filenameMime, 'size' => $filenameSize]);
        }
        $request->merge(['tarikh' => date('Y-m-d', strtotime($request->tarikh))]);
        $request->merge(['keterangan' =>'null']);

        //define data field of Model
        Manual::create($request->all());

        //redirect to 'user.designations'
         return response()->json(['success'=>'You have successfully upload file.']);
        //return redirect()->route('pengurusan.manual.index')->with('successMessage', 'Maklumat manual telah berjaya disimpan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Manual  $manual
     * @return \Illuminate\Http\Response
     */
    public function show(Manual $manual)
    {
        return view('pengurusan.manual.show', ['manual' => $manual]);
    }

    /**
     * Download the specified resource.
     *
     * @param  \App\Model\Manual  $manual
     * @return \Illuminate\Http\Response
     */
    public function download(Manual $manual)
    {
        return Storage::download(
            'public/images/shares/manual/' . $manual->dokumen,
            Str::slug(Str::lower($manual->tajuk), '-') . '.' . $manual->extension,
            [
                'Content-Description' => $manual->tajuk,
                'Content-Type' => $manual->mimes,
            ]
        );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Manual  $manual
     * @return \Illuminate\Http\Response
     */
    public function edit(Manual $manual)
    {
        return view('pengurusan.manual.edit', ['manual' => $manual]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Manual  $manual
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Manual $manual)
    {

        $request->validate([
            'tajuk' => ['required', 'min:3', 'regex:/[0-9a-zA-Z @\/\'`]+$/'],
            'keterangan' => ['nullable', 'min:3', 'regex:/[0-9a-zA-Z @\/\'`]+$/'],
            'fail_dokumen' => 'nullable|max:20480',
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
            $filename = 'manual_' . time() . '.' . $request->fail_dokumen->extension();
            $filenameMime = $request->fail_dokumen->getClientMimeType();
            $filenameExtension = $request->fail_dokumen->extension();
            $filenameSize = $request->fail_dokumen->getSize();

            //Store Image in Storage Folder
            //storage/app/images/file.png
            $request->fail_dokumen->storeAs('public/images/shares/manual/', $filename);

            $request->request->add(['dokumen' => $filename, 'extension' => $filenameExtension, 'mimes' => $filenameMime, 'size' => $filenameSize]);
        }
        $request->merge(['tarikh' => date('Y-m-d', strtotime($request->tarikh))]);

        //define data field of Model
        $manual->update($request->all());
        $request->merge(['keterangan' =>'null']);

        //redirect to 'user.designations'
         return response()->json(['success'=>'You have successfully upload file.']);
        //return redirect()->route('pengurusan.manual.index')->with('successMessage', 'Maklumat manual telah berjaya disimpan');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Manual  $manual
     * @return \Illuminate\Http\Response
     */
    public function destroy(Manual $manual)
    {
        $manual->delete();
        return redirect()->route('pengurusan.manual.index')->with('successMessage', 'Maklumat manual telah dihapuskan');
    }
}
