<?php
namespace App\Http\Controllers\Pengurusan;

use App\Http\Controllers\Controller;
use App\Model\ePIL;
use App\Model\ePIL_draf;
use App\Model\ePIL_dokumen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ePIL_dokumenController extends Controller
{
    public function __construct()
    {
        $this->middleware(['role_or_permission:Pentadbir Sistem|Pegawai|Pihak Berkuasa Tempatan|ePIL-list']);
        $this->middleware(['role_or_permission:Pentadbir Sistem|Pegawai|Pihak Berkuasa Tempatan|ePIL-create'], ['only' => ['create', 'store']]);
        $this->middleware(['role_or_permission:Pentadbir Sistem|Pegawai|Pihak Berkuasa Tempatan|ePIL-edit'], ['only' => ['edit', 'update']]);
        $this->middleware(['role_or_permission:Pentadbir Sistem|Pegawai|Pihak Berkuasa Tempatan|ePIL-delete'], ['only' => ['destroy']]);
    }

    // Show the edit form for a specific document
    public function edit($id)
    {
        $dokumen = ePIL_dokumen::findOrFail($id);
        $ePIL = ePIL::where('id_pelan', $dokumen->id_pelan)->first();
        $dataToUpdate_komponen = $ePIL->getAttributes();
        $dokumen->folder = str_replace(' ', '_', $dataToUpdate_komponen['nama_pelan']);
        // dd($dokumen);
        return view('pengurusan.ePIL.edit_dokumen', compact('dokumen'));
    }

    // Handle the update request for a specific document
    public function update(Request $request, $id)
    {
        // dd($request->all());
        $dokumen = ePIL_dokumen::findOrFail($id);
        $folderName = $request->folder;
        // Update the document's fields
        $dokumen->nama_fail = $request->nama_fail;
        $dokumen->keterangan_dokumen_pelan = $request->keterangan_dokumen_pelan;
        $dokumen->status = $request->status;

        // Handle image update
        if ($request->hasFile('gambar_dokumen_pelan')) {
            $file = $request->file('gambar_dokumen_pelan');
            $filename = time() . '_' .$file->getClientOriginalName() . '.' . $file->extension();
            $path = $file->storeAs('public/uploads/ePIL/' . $folderName, $filename);
            $dokumen->gambar_dokumen_pelan = $filename;
            $filePath = storage_path('app/public/uploads/ePIL/' . $folderName . '/' . $request->gambar_dokumen_pelan_db);
            unlink($filePath);
        }

        if(isset($request->large_file_name_new)){
            $dokumen->nama_dokumen_pelan = $request->large_file_name_new;
            $filePath = storage_path('app/public/uploads/ePIL/' . $folderName . '/' . $request->nama_dokumen_pelan_db);
            unlink($filePath);
        }

        // Save the changes
        $dokumen->save();

        // Redirect back with a success message
        return redirect()->route('pengurusan.ePIL_dokumen.edit', [$dokumen])->with('successMessage', 'Document updated successfully!');
    }

    public function destroy(Request $request, $id)
    {
        $dokumen = ePIL_dokumen::findOrFail($id);
        $dokumen->delete();
        return redirect(url()->previous())->with('successMessage', 'Maklumat fail pelan telah dihapuskan');
    }
}
