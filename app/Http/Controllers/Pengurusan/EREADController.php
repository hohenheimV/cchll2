<?php

namespace App\Http\Controllers\Pengurusan;

use App\Http\Controllers\Controller;
use App\Model\eREAD;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Model\Kategori;


class EREADController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware(['role_or_permission:Pentadbir Sistem|eread-list']);
        $this->middleware(['role_or_permission:Pentadbir Sistem|eread-create'], ['only' => ['create', 'store']]);
        $this->middleware(['role_or_permission:Pentadbir Sistem|eread-edit'], ['only' => ['edit', 'update']]);
        $this->middleware(['role_or_permission:Pentadbir Sistem|eread-delete'], ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) 
    {
        $ereads = eREAD::with('kategori')->paginate(10);
        return view('pengurusan.eread.index', compact('ereads'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $kategories = Kategori::where('type', 1)->pluck('name', 'id');
        $eread = new eREAD(); // Create a new instance for the form
        return view('pengurusan.eread.create', compact('eread', 'kategories'));
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
            'fail_dokumen' => 'required|mimes:pdf|max:51200', // 50MB in KB , PDF
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
            $dokumenName = 'eread_' . time() . '.' . $dokumenFile->getClientOriginalExtension();

            $dokumenData = [
                'dokumen' => $dokumenName,
                'extension' => $dokumenFile->getClientOriginalExtension(),
                'mimes' => $dokumenFile->getMimeType(),
                'size' => $dokumenFile->getSize(),
            ];

            // Store file
            $dokumenFile->storeAs('public/images/shares/eread/dokumen', $dokumenName);
        }

        // Merge additional data for database insertion
        $requestData = array_merge($request->all(), $dokumenData, [
            'tarikh' => date('Y-m-d', strtotime($request->tarikh)),
        ]);

        // Debugging: Log data before saving
        \Log::info('Data to be stored:', $requestData);

        // Store data in database
        eREAD::create($requestData);

        // Redirect with success message
        return redirect()->route('pengurusan.eread.index')->with('success', 'Data telah berjaya disimpan.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\eREAD  $eread
     * @return \Illuminate\Http\Response
     */
    public function show(eREAD $eread)
    {
        return view('pengurusan.eread.show', ['eread' => $eread]);
    }

    /**
     * Download the specified resource.
     *
     * @param  \App\Model\eREAD  $eread
     * @return \Illuminate\Http\Response
     */
    public function download(eREAD $eread)
    {
        return Storage::download(
            'public/images/shares/eread/' . $eread->dokumen,
            Str::slug(Str::lower($eread->tajuk), '-') . '.' . $eread->extension,
            [
                'Content-Description' => $eread->tajuk,
                'Content-Type' => $eread->mimes,
            ]
        );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\eREAD  $eread
     * @return \Illuminate\Http\Response
     */
    public function edit(eREAD $eread)
    {
        $kategories = Kategori::where('type', 1)->pluck('name', 'id');
        return view('pengurusan.eread.edit', compact('eread', 'kategories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\eREAD  $eread
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, eREAD $eread)
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
            $filename = 'eread_' . time() . '.' . $request->fail_dokumen->extension();
            $filenameMime = $request->fail_dokumen->getClientMimeType();
            $filenameExtension = $request->fail_dokumen->extension();
            $filenameSize = $request->fail_dokumen->getSize();

            //storage/app/images
            $request->fail_dokumen->storeAs('public/images/shares/eread/dokumen', $filename);
            $request->request->add(['dokumen' => $filename, 'extension' => $filenameExtension, 'mimes' => $filenameMime, 'size' => $filenameSize]);
        }
            //Semak sekiranya wujud input fail_imej
            if ($request->hasFile('fail_imej')) {
            $filename = 'eread' . time() . '.' . $request->fail_imej->extension();

            //storage/app/images
            $request->fail_imej->storeAs('public/images/shares/eread/images', $filename);

            $request->request->add(['imej' => $filename]);
        }
        $request->merge(['tarikh' => date('Y-m-d', strtotime($request->tarikh))]);

        //define data field of Model
        $eread->update($request->all());
        //$request->merge(['keterangan' =>'null']);

        //redirect to 'user.designations'
         return response()->json(['success'=>'You have successfully update file.']);
        //return redirect()->route('pengurusan.eread.index')->with('successMessage', 'Maklumat eread telah berjaya disimpan');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\eREAD  $eread
     * @return \Illuminate\Http\Response
     */
    public function destroy(eREAD $eread)
    {
        $eread->delete();
        return redirect()->route('pengurusan.eread.index')->with('successMessage', 'Maklumat eread telah dihapuskan');
    }
    
}
