<?php

namespace App\Http\Controllers\Pengurusan;

use App\Http\Controllers\Controller;
use App\Model\ePACT;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use App\Model\Kategori;


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
        /**   $kategories = Kategori::where('type', 2)->pluck('name', 'id');*/
        $kategories = Kategori::where('type', 4)->pluck('name', 'id');
        $epact = new ePACT(); // Create a new instance for the form
        return view('pengurusan.epact.create', compact('epact', 'kategories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'tajuk' => ['required', 'min:3', 'regex:/[0-9a-zA-Z @\/\'`,\(\)\-&]+$/'],
            'keterangan' => ['nullable', 'min:3', 'regex:/[0-9a-zA-Z @\/\'`,\(\)\-&]+$/'],
            'tahun' => 'required|integer|min:1950|max:' . now()->year,
            'sumber_type' => 'required|in:jln,selain_jln',
            'sumber' => 'required_if:sumber_type,jln|nullable|integer',
            'subkat' => 'required_if:sumber_type,selain_jln|nullable|string|max:255',
        ], [
            'required' => ':attribute diperlukan.',
            'required_if' => ':attribute diperlukan apabila jenis sumber dipilih.',
            'min' => ':attribute terlalu ringkas, minima 3 aksara.',
            'regex' => ':attribute format tidak sah.',
        ]);

        // Determine the value for 'sumber' and 'subkat'
        $sumber = $request->sumber_type === 'jln' ? $request->sumber : '11'; // '11' for "Selain JLN"
        $subkat = $request->sumber_type === 'selain_jln' ? $request->subkat : null;

        // Add the determined values to the request data
        $request->merge([
            'sumber' => $sumber,
            'subkat' => $subkat,
        ]);

        // Handle file upload if necessary (existing logic)
        $largeFileName = $request->input('large_file_name_new');
        if ($largeFileName) {
            $oldPath = storage_path('app/public/uploads/epact/temp/' . $largeFileName);
            $newPath = storage_path('app/public/uploads/epact/dokumen/' . $largeFileName);

            if (file_exists($oldPath)) {
                $destinationDir = dirname($newPath);
                if (!file_exists($destinationDir)) {
                    mkdir($destinationDir, 0777, true);
                }
                rename($oldPath, $newPath);
            }

            $request->merge([
                'dokumen' => $largeFileName,
                'extension' => pathinfo($largeFileName, PATHINFO_EXTENSION),
                'mimes' => $request->input('file_mime'),
                'size' => $request->input('file_size'),
            ]);
        }

        // Save the data
        ePACT::create($request->all());

        return redirect()->route('pengurusan.epact.index')->with('successMessage', 'Maklumat Berjaya Disimpan');
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
            'public/uploads/epact' . $epact->dokumen,
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
    /**   $kategories = Kategori::where('type', 2)->pluck('name', 'id');*/
       $kategories = Kategori::where('type', 4)->pluck('name', 'id');
        return view('pengurusan.epact.edit', compact('epact', 'kategories'));
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
            'tajuk' => ['required', 'min:3', 'regex:/[0-9a-zA-Z @\/\'`,\(\)\-&]+$/'],
            'keterangan' => ['nullable', 'min:3', 'regex:/[0-9a-zA-Z @\/\'`,\(\)\-&]+$/'],
            'tahun' => 'required|integer|min:1900|max:' . now()->year,
            'sumber_type' => 'required|in:jln,selain_jln',
            'sumber' => 'required_if:sumber_type,jln|nullable|integer',
            'subkat' => 'required_if:sumber_type,selain_jln|nullable|string|max:255',
        ], [
            'required' => ':attribute diperlukan.',
            'required_if' => ':attribute diperlukan apabila jenis sumber dipilih.',
            'min' => ':attribute terlalu ringkas, minima 3 aksara.',
            'regex' => ':attribute format tidak sah.',
        ]);

        // Determine the value for 'sumber' and 'subkat'
        $sumber = $request->sumber_type === 'jln' ? $request->sumber : '11'; // '11' for "Selain JLN"
        $subkat = $request->sumber_type === 'selain_jln' ? $request->subkat : null;

        // Add the determined values to the request data
        $request->merge([
            'sumber' => $sumber,
            'subkat' => $subkat,
        ]);

        // Handle file upload if necessary (existing logic)
        $largeFileName = $request->input('large_file_name_new');
        if ($largeFileName) {
            $oldPath = storage_path('app/public/uploads/epact/temp/' . $largeFileName);
            $newPath = storage_path('app/public/uploads/epact/dokumen/' . $largeFileName);

            if (file_exists($oldPath)) {
                $destinationDir = dirname($newPath);
                if (!file_exists($destinationDir)) {
                    mkdir($destinationDir, 0777, true);
                }
                rename($oldPath, $newPath);
            }

            $request->merge([
                'dokumen' => $largeFileName,
                'extension' => pathinfo($largeFileName, PATHINFO_EXTENSION),
                'mimes' => $request->input('file_mime'),
                'size' => $request->input('file_size'),
            ]);
        }

        // Update the data
        $epact->update($request->all());

        return redirect()->route('pengurusan.epact.index')->with('successMessage', 'Maklumat Berjaya Dikemaskini');
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
        return redirect()->route('pengurusan.epact.index')->with('successMessage', 'Maklumat Telah Dihapuskan');
    }
    
}
