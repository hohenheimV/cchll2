<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController;
use App\Http\Resources\Softscape as ResourcesSoftscape;
use OwenIt\Auditing\Models\Audit as Audit;
use App\Model\Softscape;
use App\Model\SoftscapesGambar;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class SoftscapeController extends BaseController
{

    //DB::Raw("public.ST_GeomFromText('POINT(101.64181709 3.15721543)',4326) as geom")
    public function demo()
    {
        $res = Softscape::select(
            DB::Raw("public.ST_GeomFromText('POINT(101.64181709 3.15721543)',4326) as geom")
        )->limit(5)->get();

        return $res;
    }

    public function jenis()
    {
        $jenis = [
            'Pilihan',
            'Ameniti',
            'Buluh',
            'Renek',
            'Palma',
        ];
        return $jenis;
    }

    public function zon()
    {
        $zon = [
            'Pilihan',
            'Zon Rekreasi Keluarga',
            'Zon Pentadbiran & Garden Centre',
            'Zon Arboretum Tropika Khatulistiwa',
            'Zon Riparian / Konservasi Hidrologi',
            'Zon Biodiversiti',
            'Zon Arboretum Bernilai Tinggi',
        ];
        return $zon;
    }

    public function all(Request $request)
    {
        # code...
        $query = Softscape::select(
            "gid",
            "objectid",
            "y_coord",
            "x_coord",
            "kod_tag",
            "zon",
            "jenis_kate",
            "nama_bot",
            "nama_temp",
            "nama_kel",
            "negara_asa",
            "sumber_ana",
            "taman_pers",
            "saiz_kanop",
            "tarikh_mas",
            "diamater_b",
            "tinggi_btg",
            "bentuk_btg",
            "lebar_sila",
            "gambar_p",
            "gambar_b",
            "gambar_d",
            "gambar_bg",
            "gambar_bh",
            "keadaan",
            "catatan"
        );

        if ($request->has('keyword')) {

            // $data =  $query->whereRaw('LOWER(kod_tag) = '.strtolower($request->keyword))->get()->makeHidden(['fullKodTag', 'softscapeQrcode']);
            $data =  $query->whereNotNull('geom')
                ->whereRaw('LOWER(kod_tag) = ?', [strtolower($request->keyword)])->get()
                ->makeHidden(['fullKodTag', 'softscapeQrcode', 'geom']);

            if (!$data->isEmpty()) {
                $json["error"] = false;
                $json["errmsg"] = "Maklumat '" . $request->keyword . "' dijumpai";
                $json["data"] = $data;
                return $json;
            }

            $json["error"] = true;
            $json["errmsg"] = "Maklumat '" . $request->keyword . "' tidak dijumpai";
            $json["data"] = [];
            return $json;
        }

        if ($request->has('id')) {

            $data =  $query->whereNotNull('geom')
                ->where('gid', $request->id)->get()
                ->makeHidden(['fullKodTag', 'softscapeQrcode', 'geom']);
            // ->where('objectid', $request->id)->get()

            if (!$data->isEmpty()) {
                $json["error"] = false;
                $json["errmsg"] = "Maklumat dijumpai";
                $json["data"] = $data;
                return $json;
            }

            $json["error"] = true;
            $json["errmsg"] = "Maklumat tidak dijumpai";
            $json["data"] = [];
            return $json;
        }

        if ($request->has('zon')) {

            $zone = [
                1 => 'A',
                2 => 'B',
                3 => 'C',
                4 => 'D',
                5 => 'E',
                6 => 'F',
            ];

            $zonArr = $this->zon();
            $labelZone = $zone[$request->zon] . " : " . $zonArr[$request->zon];

            $data =  $query->whereNotNull('geom')
                ->where('zon', 'like', $zone[$request->zon] . '%')
                ->orderByRaw('LENGTH(kod_tag) desc')
                ->orderBy('kod_tag', 'desc')
                ->limit(100)->get()->makeHidden(['fullKodTag', 'softscapeQrcode', 'geom']);

            if (!$data->isEmpty()) {
                $json["error"] = false;
                $json["errmsg"] = "Maklumat dijumpai";
                $json["zon"] = $labelZone;
                $json["data"] = $data;
                return $json;
            }

            $json["error"] = true;
            $json["errmsg"] = "Maklumat tidak dijumpai";
            $json["data"] = [];
            return $json;
        }


        $json["error"] = true;
        $json["errmsg"] = "Tiada Maklumat";
        $json["data"] = [];

        return $json;
    }

    public function gambarsimpan(Request $request)
    {
        if ($request->has('image') && $request->has('gid')) {

            $softscape = Softscape::where('gid', $request->gid)->first()
                ->makeHidden(['fullKodTag', 'softscapeQrcode', 'geom']);



            $fileNameGambar = [
                'gambar_p' => $softscape->kod_tag . '_P_' . date('ynj-Hi'),
                'gambar_b' => $softscape->kod_tag . '_B_' . date('ynj-Hi'),
                'gambar_d' => $softscape->kod_tag . '_D_' . date('ynj-Hi'),
                'gambar_bg' => $softscape->kod_tag . '_BG_' . date('ynj-Hi'),
                'gambar_bh' => $softscape->kod_tag . '_BH_' . date('ynj-Hi'),
            ];

            // $files = $request->file('image');

            $jenis = $request->jenis;

            if($softscape->{$jenis} && Storage::disk('public')->exists('assets/softscape/'.$softscape->{$jenis})){
               Storage::disk('public')->move('assets/softscape/'.$softscape->{$jenis}, 'assets/softscape/'.$softscape->{$jenis}.'.repl');

               //If double replace within 1 minit
               if(Storage::disk('public')->exists('assets/softscape/'.$softscape->{$jenis}.'.repl')){
                    Storage::disk('public')->move('assets/softscape/'.$softscape->{$jenis}.'.repl', 'assets/softscape/'.$softscape->{$jenis}.'.repl');
               } 
            }

            
            $fileName =  $fileNameGambar[$jenis] . '.' . $request->image->getClientOriginalExtension();

            Storage::disk('public')->putFileAs(
                'assets/softscape',
                $request->file('image'),
                $fileName
            );

          
            $softscape->{$jenis} = $fileName;
            $softscape->updated_at = now();
            $softscape->save();

            return $fileName;
        }

        return false;
    }

    public function gambarhapus(Request $request)
    {
        if ($request->has('jenis') && $request->has('gid')) {

            $softscape = Softscape::where('gid', $request->gid)->first()
                ->makeHidden(['fullKodTag', 'softscapeQrcode', 'geom']);

        
            $jenis = $request->jenis;

            Storage::disk('public')->move('assets/softscape/'.$softscape->{$jenis}, 'assets/softscape/'.$softscape->{$jenis}.'.del');

        
            $softscape->{$jenis} = null;
            $softscape->updated_at = now();
            $softscape->save();

            return 'berjaya';
        }

        return false;
    }

    public function gambar(Request $request)
    {

        if ($request->has('id')) {

            # code...
            $query = Softscape::select(
                "gid",
                "gambar_p",
                "gambar_b",
                "gambar_d",
                "gambar_bg",
                "gambar_bh"
            );

            $data =  $query->whereNotNull('geom')
                ->where('gid', $request->id)->first()
                ->makeHidden(['fullKodTag', 'softscapeQrcode', 'geom']);

            if ($data) {

                $index = 0;
                $gambar['gambar_p'] = null;
                $gambar['gambar_b'] = null;
                $gambar['gambar_d'] = null;
                $gambar['gambar_bg'] = null;
                $gambar['gambar_bh'] = null;

                if ($data->gambar_p && Storage::disk('public')->exists('assets/softscape/' . $data->gambar_p)) {
                    $gambar['gambar_p'] = $data->gambar_p;
                    $index++;
                }
                if ($data->gambar_b && Storage::disk('public')->exists('assets/softscape/' . $data->gambar_b)) {
                    $gambar['gambar_b'] = $data->gambar_b;
                    $index++;
                }
                if ($data->gambar_d && Storage::disk('public')->exists('assets/softscape/' . $data->gambar_d)) {
                    $gambar['gambar_d'] = $data->gambar_d;
                    $index++;
                }
                if ($data->gambar_bg && Storage::disk('public')->exists('assets/softscape/' . $data->gambar_bg)) {
                    $gambar['gambar_bg'] = $data->gambar_bg;
                    $index++;
                }
                if ($data->gambar_bh && Storage::disk('public')->exists('assets/softscape/' . $data->gambar_bh)) {
                    $gambar['gambar_bh'] = $data->gambar_bh;
                    $index++;
                }

                $gambar['gid'] = $data->gid;
                $gambar['jumlah'] = $index;

                if ($index == 0) {
                    $json["error"] = true;
                    $json["errmsg"] = "Maklumat tidak dijumpai";
                    $json["data"] = [$gambar];
                    return $json;
                }


                $json["error"] = false;
                $json["errmsg"] = "Maklumat dijumpai";
                $json["data"] = [$gambar];
                return $json;
            }

            $json["error"] = true;
            $json["errmsg"] = "Maklumat tidak dijumpai";
            $json["data"] = [];
            return $json;
        }

        $json["error"] = true;
        $json["errmsg"] = "Tiada Maklumat";
        $json["data"] = [];

        return $json;
    }

    public function save(Request $request)
    {

        # code...
        $json["error"] = false;
        $json["errmsg"] = "";
        $json["data"] = [];



        $zone = [
            'A' => 'Zon Rekreasi Keluarga',
            'B' => 'Zon Pentadbiran & Garden Centre',
            'C' => 'Zon Arboretum Tropika Khatulistiwa',
            'D' => 'Zon Riparian / Konservasi Hidrologi',
            'E' => 'Zon Biodiversiti',
            'F' => 'Zon Arboretum Bernilai Tinggi'
        ];

        $inputZon = $request->zon;

        $res = array_filter($zone, function ($v, $k) use ($inputZon) {
            return $v == $inputZon;
        }, ARRAY_FILTER_USE_BOTH);

        $inputZon =   key($res) . ' / ' . $res[key($res)]; //'A / Zon Rekreasi Keluarga';
        $kodZon = key($res);

        if (!$request->gid && !$request->kod_tag) {
            $first = Softscape::select('gid', 'objectid')->orderBy('gid', 'desc')->first()->makeHidden(['fullKodTag', 'softscapeQrcode']);
            $objectid = $first->gid + 1;
            $kod_tag = $kodZon . $objectid;
            $tarikh_mas = date('d-m-Y g:i A');
        } else {
            $objectid = $request->objectid;
            $kod_tag = $request->kod_tag;
            $tarikh_mas = date('d-m-Y g:i A');
        }

        $saved = Softscape::updateOrCreate(
            ['gid' => $request->gid ?? null],
            [
                'objectid' => $objectid,
                'zon' => $inputZon,
                'kod_tag' => $kod_tag,
                'x_coord' => number_format($request->y_coord, 8, '.', ''),
                'y_coord' => number_format($request->x_coord, 8, '.', ''),
                'gambar_p' => $request->gambar_p,
                'gambar_b' => $request->gambar_b,
                'gambar_d' => $request->gambar_d,
                'gambar_bg' => $request->gambar_bg,
                'gambar_bh' => $request->gambar_bh,
                'jenis_kate' => $request->jenis_kate,
                'nama_bot' => $request->nama_bot,
                'nama_temp' => $request->nama_temp,
                'nama_kel' => $request->nama_kel,
                'diamater_b' => $request->diamater_b,
                'saiz_kanop' => $request->saiz_kanop,
                'tinggi_btg' => $request->tinggi_btg,
                'bentuk_btg' => $request->bentuk_btg?? null,
                'lebar_sila' => $request->lebar_sila?? null,
                'catatan' => $request->catatan,
                'keadaan' => $request->keadaan,
                'taman_pers' => 'Taman Persekutuan Bukit Kiara',
                'tarikh_mas' => $tarikh_mas,
                'geom' => DB::Raw("public.ST_GeomFromText('POINT($request->y_coord $request->x_coord)',4326)"),
            ]
        );


        if (!$saved) {
            $json["error"] = true;
            $json["errmsg"] = "Maklumat gagal di simpan";
            $json["data"] = [];
            return $json;
        }

        $saved =  $saved->makeHidden(['fullKodTag', 'softscapeQrcode', 'geom']);

        $userId = $this->_getuserId($request->token);

        $userDevice = $this->_getuserDevice($request->token);

        $details = Audit::where('auditable_type', 'App\Model\Softscape')
            ->where('auditable_id', $saved->gid)
            ->update([
                'tags' => 'Mobile',
                'user_agent' => $userDevice,
                'user_type' => 'App\User',
                'user_id' => $userId]);


        $json["error"] = false;
        $json["errmsg"] = "Maklumat berjaya di simpan";
        $json["data"] = [$saved];
        return $json;
    }

}
