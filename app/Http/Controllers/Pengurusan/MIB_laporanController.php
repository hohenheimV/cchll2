<?php

namespace App\Http\Controllers\Pengurusan;

use App\Http\Controllers\Controller;
use App\Exports\MIBExport;
use App\Model\MIB;
use App\Model\MIB_laporan;
use Carbon\Carbon;
use Error;
use Illuminate\Http\Request;

class MIB_laporanController extends Controller
{
    // Display the listing of records
    public function index()
    {
        $MIB_laporan = MIB_laporan::latest()->paginate(15);  // Fetch all reports
        return view('pengurusan.MIB_laporan.index', compact('MIB_laporan'));
    }

    // Show the form to create a new record
    public function create($id)
    {
        $MIB = MIB::findOrFail($id);
        // dd($MIB);
        return view('pengurusan.MIB_laporan.create', compact('MIB'));
    }

    // Store a new record
    public function store(Request $request)
    {
        // dd($request->all());
        $requestData = $request->all();

        $filenames = [];
        for ($i = 1; $i <= 4; $i++) {
            $inputField = 'gambar_input_modal_' . $i;
            if ($request->hasFile($inputField)) {
                $file = $request->file($inputField);
                
                if ($file->isValid()) {
                    $folderName = str_replace(' ', '_', $request->input('taman'));
                    $filename = time() . '_' . $i . '.' . $file->extension();
                    $file->storeAs('public/uploads/MIB/' . $folderName, $filename);
                    $filenames[$inputField] = $filename;
                }
                unset($requestData[$inputField]);
            }
        }
        if (!empty($filenames)) {
            $requestData['fail'] = ($filenames);
        }
        // dd($requestData);
        $report = MIB_laporan::create($requestData);  // Save the new record to the database
        $rakanTaman = MIB::findOrFail($report->id_rakan);

        return redirect()->route('pengurusan.MIB.show', [$rakanTaman])->with('successMessage', 'Maklumat telah berjaya disimpan.');
    }

    // Show the form to edit an existing record
    public function edit($id)
    {
        $MIB_laporan = MIB_laporan::findOrFail($id);
        return view('pengurusan.MIB_laporan.edit', compact('MIB_laporan'));
    }

    public function show($id)
    {
        // dd($id);
        $MIB_laporan = MIB_laporan::findOrFail($id);
        return view('pengurusan.MIB_laporan.show', compact('MIB_laporan'));
    }

    // Update the record
    public function update(Request $request, $id)
    {
        $report = MIB_laporan::findOrFail($id);
        $filenames = [];
        $gambar = ($report->fail) ?? '';
        for ($i = 1; $i <= 4; $i++) {
            $inputField = 'gambar_input_modal_' . $i;
            if ($request->hasFile($inputField)) {
                $file = $request->file($inputField);
                
                if ($file->isValid()) {
                    $folderName = str_replace(' ', '_', $request->input('taman'));
                    $filename = time() . '_' . $i . '.' . $file->extension();
                    $file->storeAs('public/uploads/MIB/' . $folderName, $filename);
                    $filenames[$inputField] = $filename;
                }
                unset($request[$inputField]);
            }else{
                if(isset($gambar[$inputField])){
                    $filenames[$inputField] = $gambar[$inputField];
                }
            }
        }
        $request->merge(['fail' => ($filenames)]);

        $requestData = $request->all();
        $report->update($requestData);
        $rakanTaman = MIB::findOrFail($report->id_rakan);

        return redirect()->route('pengurusan.MIB.show', [$rakanTaman])->with('successMessage', 'Maklumat telah berjaya disimpan.');
    }

    // Delete the record
    public function destroy($id)
    {
        $report = MIB_laporan::findOrFail($id);
        $rakanTaman = MIB::findOrFail($report->id_rakan);
        $report->delete();

        return redirect()->route('pengurusan.MIB.show', [$rakanTaman])->with('successMessage', 'Maklumat telah berjaya disimpan.');
    }
}
