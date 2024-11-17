<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController;
use App\Http\Resources\Hardscape as ResourcesHardscape;
use App\Model\Hardscape;
use App\Model\HardscapeRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class HardscapeController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index_public()
    {

        $hardscapes = Hardscape::with('record')->limit(20)->orderBy('objectid', 'DESC')->get();

        return $this->sendResponse(ResourcesHardscape::collection($hardscapes),'Maklumat Hardscape dijumpai.');

    }
    public function index()
    {

        $hardscapes = Hardscape::with('record')->limit(100)->rderBy('objectid', 'DESC')->get();

        return $this->sendResponse(ResourcesHardscape::collection($hardscapes),'Maklumat Hardscape dijumpai.');

    }

    public function store(Request $request)
    {
        // Mula Rule validation
        $rules = [
            'tarikh' => 'required',
            'jenis_komponen' => 'required',
            'nama_struktur' => 'required',
            'keadaan_semasa' => 'required',
            'kos_pembinaan' => 'required',
        ];
        //Selaras bentuk mesej yang sama; attributes berbeza
        $messages = [
            'required' => ':attribute diperlukan.',
            'min' => ':attribute terlalu ringkas.',
            'max' => ':attribute terlalu panjang.',
            'regex' => ':attribute tidak sah.',
        ];
        // Rename field ke perkataan boleh difaham (jika perlu/berlainan)
        $attributes = [
            'tarikh' => 'Tarikh Binaan',
            'jenis_komponen' => 'Jenis Komponen',
            'nama_struktur' => 'Nama Struktur',
            'keadaan_semasa' => 'Keadaan Semasa',
            'kos_pembinaan' => 'Kos Pembinaan',
        ];

        //$validator($rules, $messages, $attributes);
        $validator = Validator::make($request->all(), $rules, $messages, $attributes);

        //if Validator fails return errors()
        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $res = Hardscape::latestZone();
        $input = $request->all();

        $input['kod_tag'] = $res->kod_tag + 1;
        $input = Arr::except($input, ['gambar']);
        // $kod_tag = 'kod_tag';
        // $zon = 'kod_tag';
        // define data field of Model
        $hardscape = Hardscape::create($input);

        $label =[
            'keseluruhan' =>'_K.jpg',
            'baikpulih1' =>'_K1.jpg',
            'baikpulih1' =>'_K2.jpg',
            'baikpulih1' =>'_K3.jpg',
        ];

        $save = [];
        $save['hardscape_id'] = $hardscape->objectid;
        if ($request->gambar) {
            $folder = $hardscape->zon . $hardscape->objectid;
            $path = 'assets/hardscape/' . $hardscape->objectid.'/'.$hardscape->tahun_tanam.'/';
            foreach ($request->gambar as $file) {
                if($file['img']){
                    $name = $folder.$label[$file['label']];
                    $value = $file['img'];//
                    //$value =  str_replace('data:image/jpeg;base64,','',$file['img']);;//data:image/jpeg;base64,
                    $save[$file['label']] = $path.$name;
                    Storage::disk('public')->putFileAs($path,$value,$name);
                }else{
                    $save[$file['label']] = null;
                }
            }
            HardscapeRecord::create($save);
        }

        $hardscapes = Hardscape::with('record')->find($hardscape->objectid);

        return $this->sendResponse($hardscapes, 'Maklumat telah berjaya disimpan');
    }
}
