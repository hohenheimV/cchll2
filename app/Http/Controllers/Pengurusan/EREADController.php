<?php

namespace App\Http\Controllers\Pengurusan;

use App\Http\Controllers\Controller;
use App\Model\eREAD;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
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
        $ereads = eREAD::with('kategori')->orderBy('created_at', 'desc')->get();
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
        $request->validate([
            'tajuk' => ['required', 'min:3', 'regex:/[0-9a-zA-Z @\/\'`,\(\)\-&]+$/'],
            'keterangan' => ['nullable', 'min:3', 'regex:/[0-9a-zA-Z @\/\'`,\(\)\-&]+$/'],
            'tarikh' => 'required',
            'bahagian_jln' => 'required',
        ], [
            'required' => ':attribute diperlukan.',
            'min' => ':attribute terlalu ringkas, minima 3 aksara.',
            'regex' => ':attribute format tidak sah.',
        ]);

        $largeFileName = $request->input('large_file_name_new');
        $file_size = $request->input('file_size');
        $file_type = $request->input('file_type');
        $file_mime = $request->input('file_mime');

        if (null !== $largeFileName) {
            $oldPath = storage_path('app/public/uploads/eread/temp/' . $largeFileName); // Current file location
            $newPath = storage_path('app/public/uploads/eread/dokumen/' . $largeFileName); // New location

            if (file_exists($oldPath)) {
                $destinationDir = dirname($newPath);
                if (!file_exists($destinationDir)) {
                    if (!mkdir($destinationDir, 0777, true) && !is_dir($destinationDir)) {
                        \Log::error('Failed to create directory: ' . $destinationDir);
                        return redirect()->back()->withErrors(['error' => 'Failed to create directory for file upload.']);
                    }
                }

                if (!rename($oldPath, $newPath)) {
                    \Log::error('Failed to move file from ' . $oldPath . ' to ' . $newPath);
                    return redirect()->back()->withErrors(['error' => 'Failed to move uploaded file.']);
                }
            } else {
                \Log::error('File not found: ' . $oldPath);
                return redirect()->back()->withErrors(['error' => 'Uploaded file not found.']);
            }

            $request->request->add([
                'dokumen' => $largeFileName,
                'extension' => pathinfo($largeFileName, PATHINFO_EXTENSION),
                'mimes' => $file_mime,
                'size' => $file_size,
            ]);
        }

        eread::create($request->all());

        return redirect()->route('pengurusan.eread.index')->with('successMessage', 'Maklumat Berjaya Disimpan');
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
            'public/uploads/eread/' . $eread->dokumen,
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
            'tajuk' => ['required', 'min:3', 'regex:/[0-9a-zA-Z @\/\'`,\(\)\-&]+$/'],
            'keterangan' => ['nullable', 'min:3', 'regex:/[0-9a-zA-Z @\/\'`,\(\)\-&]+$/'],
            'fail_dokumen' => ['nullable','mimes:pdf'],
            'tarikh' => 'required',
            'bahagian_jln' => 'required',
        ], [
            'required' => ':attribute diperlukan.',
            'min' => ':attribute terlalu ringkas, minima 3 aksara.',
            'regex' => ':attribute format tidak sah.',
        ]);

        $largeFileName = $request->input('large_file_name_new');
        $file_size = $request->input('file_size');
        $file_type = $request->input('file_type');
        $file_mime = $request->input('file_mime');

        if (null !== $largeFileName) {
            $oldPath = storage_path('app/public/uploads/eread/temp/' . $largeFileName); // Current file location
            $newPath = storage_path('app/public/uploads/eread/dokumen/' . $largeFileName); // New location

            if (file_exists($oldPath)) {
                $destinationDir = dirname($newPath);
                if (!file_exists($destinationDir)) {
                    if (!mkdir($destinationDir, 0777, true) && !is_dir($destinationDir)) {
                        \Log::error('Failed to create directory: ' . $destinationDir);
                        return redirect()->back()->withErrors(['error' => 'Failed to create directory for file upload.']);
                    }
                }

                if (!rename($oldPath, $newPath)) {
                    \Log::error('Failed to move file from ' . $oldPath . ' to ' . $newPath);
                    return redirect()->back()->withErrors(['error' => 'Failed to move uploaded file.']);
                }
            } else {
                \Log::error('File not found: ' . $oldPath);
                return redirect()->back()->withErrors(['error' => 'Uploaded file not found.']);
            }

            $request->request->add([
                'dokumen' => $largeFileName,
                'extension' => pathinfo($largeFileName, PATHINFO_EXTENSION),
                'mimes' => $file_mime,
                'size' => $file_size,
            ]);
        }

        $eread->update($request->all());

        return redirect()->route('pengurusan.eread.index')->with('successMessage', 'Maklumat Berjaya Dikemaskini');
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
        return redirect()->route('pengurusan.eread.index')->with('successMessage', 'Maklumat Telah Dihapuskan');
    }
    
}
