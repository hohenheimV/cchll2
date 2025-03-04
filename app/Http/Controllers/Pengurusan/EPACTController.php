<?php

namespace App\Http\Controllers\Pengurusan;

use App\Http\Controllers\Controller;
use App\Model\ePACT;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Model\Kategori;
use App\Model\Subkategori;


class EPACTController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware(['role_or_permission:Pentadbir Sistem|epact-list']);
        $this->middleware(['role_or_permission:Pentadbir Sistem|epact-create'], ['only' => ['create', 'store']]);
        $this->middleware(['role_or_permission:Pentadbir Sistem|epact-edit'], ['only' => ['edit', 'update']]);
        $this->middleware(['role_or_permission:Pentadbir Sistem|epact-delete'], ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) 
    {
        $epacts = ePACT::with('kategori')->orderBy('created_at', 'desc')->paginate(10);
        return view('pengurusan.epact.index', compact('epacts'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $kategories = Kategori::where('type', 2)->pluck('name', 'id');
        $epact = new ePACT(); // Create a new instance for the form
        $subkat = $epact->kate 
            ? Subkategori::where('kategori_id', $epact->kate)->pluck('name', 'id') 
            : [];
        return view('pengurusan.epact.create', compact('epact', 'kategories', 'subkat'));
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
            $dokumenName = 'epact_' . time() . '.' . $dokumenFile->getClientOriginalExtension();

            $dokumenData = [
                'dokumen' => $dokumenName,
                'extension' => $dokumenFile->getClientOriginalExtension(),
                'mimes' => $dokumenFile->getMimeType(),
                'size' => $dokumenFile->getSize(),
            ];

            // Store file
            $dokumenFile->storeAs('public/images/shares/epact/dokumen', $dokumenName);
        }

        // Handle file upload for imej
        $imejData = [];
        if ($request->hasFile('fail_imej')) {
            $imejFile = $request->file('fail_imej');
            $imejName = 'epact_' . time() . '.' . $imejFile->getClientOriginalExtension();

            $imejData = ['imej' => $imejName];

            // Store file
            $imejFile->storeAs('public/images/shares/epact/images', $imejName);
        }

        // Merge additional data for database insertion
        $requestData = array_merge($request->all(), $dokumenData, $imejData, [
            'tarikh' => date('Y-m-d', strtotime($request->tarikh)),
        ]);

        // Debugging: Log data before saving
        \Log::info('Data to be stored:', $requestData);

        // Store data in database
        ePACT::create($requestData);

        // Redirect with success message
        return redirect()->route('pengurusan.epact.index')->with('success', 'Data telah berjaya disimpan.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\ePACT  $epact
     * @return \Illuminate\Http\Response
     */
    public function show(ePACT $epact)
    {
        return view('pengurusan.epact.show', ['epact' => $epact]);
    }

    /**
     * Download the specified resource.
     *
     * @param  \App\Model\ePACT  $epact
     * @return \Illuminate\Http\Response
     */
    public function download(ePACT $epact)
    {
        return Storage::download(
            'public/images/shares/epact/' . $epact->dokumen,
            Str::slug(Str::lower($epact->tajuk), '-') . '.' . $epact->extension,
            [
                'Content-Description' => $epact->tajuk,
                'Content-Type' => $epact->mimes,
            ]
        );
    }

    

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\ePACT  $epact
     * @return \Illuminate\Http\Response
     */
    public function edit(ePACT $epact)
    {
       $kategories = Kategori::where('type', 2)->pluck('name', 'id');
        $subkat = Subkategori::where('kategori_id', $epact->kate)->pluck('name', 'id');
        return view('pengurusan.epact.edit', compact('epact', 'kategories', 'subkat'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\ePACT  $epact
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ePACT $epact)
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
            $filename = 'epact_' . time() . '.' . $request->fail_dokumen->extension();
            $filenameMime = $request->fail_dokumen->getClientMimeType();
            $filenameExtension = $request->fail_dokumen->extension();
            $filenameSize = $request->fail_dokumen->getSize();

            //storage/app/images
            $request->fail_dokumen->storeAs('public/images/shares/epact/dokumen', $filename);
            $request->request->add(['dokumen' => $filename, 'extension' => $filenameExtension, 'mimes' => $filenameMime, 'size' => $filenameSize]);
        }
            //Semak sekiranya wujud input fail_imej
            if ($request->hasFile('fail_imej')) {
            $filename = 'epact' . time() . '.' . $request->fail_imej->extension();

            //storage/app/images
            $request->fail_imej->storeAs('public/images/shares/epact/images', $filename);

            $request->request->add(['imej' => $filename]);
        }
        $request->merge(['tarikh' => date('Y-m-d', strtotime($request->tarikh))]);

        //define data field of Model
        $epact->update($request->all());
        //$request->merge(['keterangan' =>'null']);

        //redirect to 'user.designations'
         return response()->json(['success'=>'You have successfully update file.']);
        //return redirect()->route('pengurusan.epact.index')->with('successMessage', 'Maklumat epact telah berjaya disimpan');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\ePACT  $epact
     * @return \Illuminate\Http\Response
     */
    public function destroy(ePACT $epact)
    {
        $epact->delete();
        return redirect()->route('pengurusan.epact.index')->with('successMessage', 'Maklumat epact telah dihapuskan');
    }

    public function getSubkategori($kategoriId)
    {
        $subcategories = Subkategori::where('kategori_id', $kategoriId)->get(['id', 'name']);
        return response()->json($subcategories);
    }


    
}
