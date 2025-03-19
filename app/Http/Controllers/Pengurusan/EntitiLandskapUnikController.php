<?php

namespace App\Http\Controllers\Pengurusan;

use App\Http\Controllers\Controller;
use App\Model\EntitiLandskapUnik;  // Updated to the new model
use Illuminate\Http\Request;

class EntitiLandskapUnikController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware(['role_or_permission:Pentadbir Sistem|entiti-list']);
        $this->middleware(['role_or_permission:Pentadbir Sistem|entiti-create'], ['only' => ['create', 'store']]);
        $this->middleware(['role_or_permission:Pentadbir Sistem|entiti-edit'], ['only' => ['edit', 'update']]);
        $this->middleware(['role_or_permission:Pentadbir Sistem|entiti-delete'], ['only' => ['destroy']]);
    }

    public function index()
    {
        $entitiLandskapUnik = EntitiLandskapUnik::latest()->paginate(5);

        return view('pengurusan.entiti-landskap-unik.index', ['entitiLandskapUnik' => $entitiLandskapUnik]);
    }

    public function create()
    {
        return view('pengurusan.entiti-landskap-unik.create');
    }

    public function store(Request $request)
    {
        $requestData = $request->all();

        $filenames = [];
        for ($i = 1; $i <= 4; $i++) {
            $inputField = 'gambar_input_modal_' . $i;
            if ($request->hasFile($inputField)) {
                $file = $request->file($inputField);
                
                if ($file->isValid()) {
                    $folderName = str_replace(' ', '_', $request->input('nama_entiti'));
                    $filename = time() . '_' . $i . '.' . $file->extension();
                    $file->storeAs('public/uploads/entiti_landskap/' . $folderName, $filename);
                    $filenames[$inputField] = $filename;
                }
                unset($requestData[$inputField]);
            }
        }
        if (!empty($filenames)) {
            $requestData['gambar'] = json_encode($filenames);
        }

        $newRecord = EntitiLandskapUnik::create($requestData);
        // $newRecord->save();
        
        if($newRecord){
            return redirect()->route('pengurusan.entiti-landskap-unik.index')->with('successMessage', 'Maklumat Entiti Landskap telah berjaya disimpan');
        }else{
            return redirect()->route('pengurusan.entiti-landskap-unik.index')->with('errorMessage', 'Maklumat Entiti Landskap tidak berjaya disimpan');
        }
    }

    public function show(EntitiLandskapUnik $entitiLandskapUnik)
    {
        return view('pengurusan.entiti-landskap-unik.show', ['entitiLandskapUnik' => $entitiLandskapUnik]);
    }

    public function edit(EntitiLandskapUnik $entitiLandskapUnik)
    {
        return view('pengurusan.entiti-landskap-unik.edit', [
            'entitiLandskapUnik' => $entitiLandskapUnik,
        ]);
    }

    public function update(Request $request, EntitiLandskapUnik $entitiLandskapUnik)
    {
        $filenames = [];
        $gambar = json_decode($entitiLandskapUnik->gambar, true) ?? '';
        for ($i = 1; $i <= 4; $i++) {
            $inputField = 'gambar_input_modal_' . $i;
            if ($request->hasFile($inputField)) {
                $file = $request->file($inputField);
                
                if ($file->isValid()) {
                    $folderName = str_replace(' ', '_', $request->input('nama_entiti'));
                    $filename = time() . '_' . $i . '.' . $file->extension();
                    $file->storeAs('public/uploads/entiti_landskap/' . $folderName, $filename);
                    $filenames[$inputField] = $filename;
                }
                unset($request[$inputField]);
            }else{
                if(isset($gambar[$inputField])){
                    $filenames[$inputField] = $gambar[$inputField];
                }
            }
        }
        $request->merge(['gambar' => json_encode($filenames)]);
        $requestData = $request->all();
        // dd($requestData);
        $updateEntiti = $entitiLandskapUnik->update($requestData);
        if($updateEntiti){
            return redirect()->route('pengurusan.entiti-landskap-unik.edit', [$entitiLandskapUnik])->with('successMessage', 'Maklumat Entiti Landskap telah berjaya disimpan');
        }else{
            return redirect()->route('pengurusan.entiti-landskap-unik.edit', [$entitiLandskapUnik])->with('errorMessage', 'Maklumat Entiti Landskap tidak berjaya disimpan');
        }
    }

    public function destroy(EntitiLandskapUnik $entitiLandskapUnik)
    {
        $entitiLandskapUnik->delete();
        return redirect()->route('pengurusan.entiti-landskap-unik.index')->with('successMessage', 'Maklumat Entiti Landskap telah dihapuskan');
    }
}
