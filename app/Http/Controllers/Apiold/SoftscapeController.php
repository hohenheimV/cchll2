<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController;
use App\Http\Resources\Softscape as ResourcesSoftscape;
use App\Model\Softscape;
use App\Model\SoftscapesGambar;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class SoftscapeController extends BaseController
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index_public()
    {
        $softscapes = Softscape::with('record', 'gambar')->limit(20)->orderBy('objectid', 'DESC')->get();
        return $this->sendResponse(ResourcesSoftscape::collection($softscapes), 'Softscape retrieved successfully');
    }

    public function index()
    {
        $softscapes = Softscape::with('record', 'gambar')->limit(100)->orderBy('objectid', 'DESC')->get();
        return $this->sendResponse(ResourcesSoftscape::collection($softscapes), 'Softscape retrieved successfully');
    }

    public function store(Request $request)
    {
        // Mula Rule validation
        $rules = [
            'lat' => 'required',
            'lng' => 'required',
            'jenis' => 'required',
            'nama_botani' => 'required',
            'nama_tempatan' => 'required',
            'nama_keluarga' => 'required',
            'tarikh' => 'required',
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
            'lat' => 'Lokasi/Koordinat',
            'lng' => 'Lokasi/Koordinat',
            'jenis' => 'Jenis/Kategori',
            'nama_botani' => 'Nama Botani',
            'nama_tempatan' => 'Nama Tempatan',
            'nama_keluarga' => 'Nama Keluarga/Asal',
            'tarikh' => 'Tarikh Ditanam',
        ];

        //$validator($rules, $messages, $attributes);
        $validator = Validator::make($request->all(), $rules, $messages, $attributes);

        //if Validator fails return errors()
        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $input = $request->all();
        $res = Softscape::latestZone($input['zon']);


        if ($input['objectid'] == null) {

            $input = Arr::except($input, ['gambar']);
            $input['tag'] = $res['tag'] + 1;
            $input['kod'] = $input['zon'];

            $softscape = Softscape::create($input);
        } else {
            $softscape = Softscape::find($input['objectid']);
            $softscape->update($input);
        }




        $softscapes = Softscape::with('record', 'gambar')->find($softscape->objectid);

        return $this->sendResponse($softscapes, 'Maklumat telah berjaya disimpan');
    }

    public function picture(Request $request)
    {
        $input = $request->all();
        $softscape_id = $input['softscape_id'];
        $label = $input['label'];
        $image = $input['image'];

        $softscape = Softscape::find($softscape_id);

        // $softscape = Softscape::find($softscape_id);

        $imgLabel = [
            'keseluruhan' => '_P.jpg',
            'batang' => '_B.jpg',
            'daun' => '_D.jpg',
            'bunga' => '_BH.jpg',
            'buah' => '_BG.jpg'
        ];

        $save = [];
        $save['softscape_id'] = $softscape->objectid;
        $folder = $softscape->zon . $softscape->objectid;
        $path = 'assets/softscape/' . $softscape->objectid . '/' . $softscape->tahun_tanam . '/';

        if ($image) {
            $name = $folder . $imgLabel[$label];
            $value = $image; //
            //$value =  str_replace('data:image/jpeg;base64,','',$file['img']);;//data:image/jpeg;base64,
            $save[$label] = $name;
            Storage::disk('public')->putFileAs($path, $value, $name);
        }
        SoftscapesGambar::create($save);
        $softscapes = Softscape::with('record', 'gambar')->find($softscape_id);

        return $this->sendResponse($softscapes->gambar[$label], 'Gambat telah berjaya disimpan');
    }



    public function show($softscape)
    {
        # code...
        $softscape = Softscape::with('record', 'gambar')->find($softscape);

        if ($softscape) {
            return $this->sendResponse($softscape, 'Maklumat telah berjaya disimpan');
        }
        return $this->sendError('Invalid data.', null);
    }
}
