<?php

namespace App\Http\Controllers\Pengurusan;

use App\Http\Controllers\Controller;
use App\Model\eLAD;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
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
        $request->validate([
            'tajuk' => ['required', 'min:3', 'regex:/[0-9a-zA-Z @\/\'`]+$/'],
            'keterangan' => ['nullable', 'min:3', 'regex:/[0-9a-zA-Z @\/\'`]+$/'],
            'tarikh' => 'required',
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
            $oldPath = storage_path('app/public/uploads/elad/temp/' . $largeFileName); // Current file location
            $newPath = storage_path('app/public/uploads/elad/dokumen/' . $largeFileName); // New location

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

        eLAD::create($request->all());

        return redirect()->route('pengurusan.elad.index')->with('successMessage', 'Maklumat Telah Disimpan');
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
            'public/uploads/elad/' . $elad->dokumen,
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
            'fail_dokumen' => ['nullable','mimes:pdf'],
            'tarikh' => 'required',
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
            $oldPath = storage_path('app/public/uploads/elad/temp/' . $largeFileName); // Current file location
            $newPath = storage_path('app/public/uploads/elad/dokumen/' . $largeFileName); // New location

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

        $elad->update($request->all());

        return redirect()->route('pengurusan.elad.index')->with('successMessage', 'Maklumat Telah Dikemaskini');
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
