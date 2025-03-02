<?php

namespace App\Http\Controllers\Pengurusan;

use App\Http\Controllers\Controller;
use App\Model\eLAD;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Model\Kategori;


class ELADController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware(['role_or_permission:Pentadbir Sistem|elad-list']);
        $this->middleware(['role_or_permission:Pentadbir Sistem|elad-create'], ['only' => ['create', 'store']]);
        $this->middleware(['role_or_permission:Pentadbir Sistem|elad-edit'], ['only' => ['edit', 'update']]);
        $this->middleware(['role_or_permission:Pentadbir Sistem|elad-delete'], ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) 
    {
        $eladsLembut = eLAD::with('kategori')->where('kate', 157)->orderBy('created_at', 'desc')->paginate(10, ['*'], 'lembut');

        $eladsKejur = eLAD::with('kategori')->where('kate', 123)->orderBy('created_at', 'desc')->paginate(10, ['*'], 'kejur');

        return view('pengurusan.elad.index', compact('eladsLembut', 'eladsKejur'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $kategories = Kategori::where('type', 3)->pluck('name', 'id');
        $elad = new eLAD(); // Create a new instance for the form
        return view('pengurusan.elad.create', compact('elad', 'kategories'));
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
            'fail_dokumen' => 'required|mimes:pdf|max:20480', // PDF
            'fail_imej' => 'nullable|image|max:20480',//image
            'tarikh' => 'required',
        ], [
            'required' => ':attribute diperlukan.',
            'min' => ':attribute terlalu ringkas, minima 3 aksara.',
            'regex' => ':attribute format tidak sah.',
        ]);

        //Semak sekiranya wujud input fail_dokumen
        // Handle file upload for dokumen
        $dokumenData = [];
        if ($request->hasFile('fail_dokumen')) {
            $dokumenFile = $request->file('fail_dokumen');
            $dokumenName = 'elad_' . time() . '.' . $dokumenFile->getClientOriginalExtension();

            $dokumenData = [
                'dokumen' => $dokumenName,
                'extension' => $dokumenFile->getClientOriginalExtension(),
                'mimes' => $dokumenFile->getMimeType(),
                'size' => $dokumenFile->getSize(),
            ];

            // Store file
            $dokumenFile->storeAs('public/images/shares/elad/dokumen', $dokumenName);
        }

        // Handle file upload for imej
        $imejData = [];
        if ($request->hasFile('fail_imej')) {
            $imejFile = $request->file('fail_imej');
            $imejName = 'elad_' . time() . '.' . $imejFile->getClientOriginalExtension();

            $imejData = ['imej' => $imejName];

            // Store file
            $imejFile->storeAs('public/images/shares/elad/images', $imejName);
        }

        // Merge additional data for database insertion
        $requestData = array_merge($request->all(), $dokumenData, $imejData, [
            'tarikh' => date('Y-m-d', strtotime($request->tarikh)),
        ]);

        // Debugging: Log data before saving
        \Log::info('Data to be stored:', $requestData);

        // Store data in database
        eLAD::create($requestData);

        // Redirect with success message
        return redirect()->route('pengurusan.elad.index')->with('success', 'Data telah berjaya disimpan.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\eLAD  $elad
     * @return \Illuminate\Http\Response
     */
    public function show(eLAD $elad)
    {
        return view('pengurusan.elad.show', ['elad' => $elad]);
    }

    /**
     * Download the specified resource.
     *
     * @param  \App\Model\eLAD  $elad
     * @return \Illuminate\Http\Response
     */
    public function download(eLAD $elad)
    {
        return Storage::download(
            'public/images/shares/elad/' . $elad->dokumen,
            Str::slug(Str::lower($elad->tajuk), '-') . '.' . $elad->extension,
            [
                'Content-Description' => $elad->tajuk,
                'Content-Type' => $elad->mimes,
            ]
        );
    }

    

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\eLAD  $elad
     * @return \Illuminate\Http\Response
     */
    public function edit(eLAD $elad)
    {
        $kategories = Kategori::where('type', 3)->pluck('name', 'id');
        return view('pengurusan.elad.edit', compact('elad', 'kategories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\eLAD  $elad
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, eLAD $elad)
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
            $filename = 'elad_' . time() . '.' . $request->fail_dokumen->extension();
            $filenameMime = $request->fail_dokumen->getClientMimeType();
            $filenameExtension = $request->fail_dokumen->extension();
            $filenameSize = $request->fail_dokumen->getSize();

            //storage/app/images
            $request->fail_dokumen->storeAs('public/images/shares/elad/dokumen', $filename);
            $request->request->add(['dokumen' => $filename, 'extension' => $filenameExtension, 'mimes' => $filenameMime, 'size' => $filenameSize]);
        }
            //Semak sekiranya wujud input fail_imej
            if ($request->hasFile('fail_imej')) {
            $filename = 'elad' . time() . '.' . $request->fail_imej->extension();

            //storage/app/images
            $request->fail_imej->storeAs('public/images/shares/elad/images', $filename);

            $request->request->add(['imej' => $filename]);
        }
        $request->merge(['tarikh' => date('Y-m-d', strtotime($request->tarikh))]);

        //define data field of Model
        $elad->update($request->all());
        //$request->merge(['keterangan' =>'null']);

        //redirect to 'user.designations'
         return response()->json(['success'=>'You have successfully update file.']);
        //return redirect()->route('pengurusan.elad.index')->with('successMessage', 'Maklumat elad telah berjaya disimpan');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\eLAD  $elad
     * @return \Illuminate\Http\Response
     */
    public function destroy(eLAD $elad)
    {
        $elad->delete();
        return redirect()->route('pengurusan.elad.index')->with('successMessage', 'Maklumat elad telah dihapuskan');
    }

}
