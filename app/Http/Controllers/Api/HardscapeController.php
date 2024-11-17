<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController;
use App\Http\Resources\Hardscape as ResourcesHardscape;
use OwenIt\Auditing\Models\Audit as Audit;
use App\Model\Hardscape;
use App\Model\HardscapeRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class HardscapeController extends BaseController
{

    public function jenis()
    {
        $jenis = [
            'Pilihan',
            "Air pancut/element air",
            "Alat permainan kanak-kanak",
            "Alatan senaman riang",
            "Arca",
            "Bangku & meja taman",
            "Jambatan/jejambat",
            "Lampu taman",
            "Longkang/sum",
            "Pagar",
            "Papan tanda",
            "Pejabat",
            "Pentas/dataran",
            "Pili bomba",
            "Pondok Pengawal",
            "Stesyen pantau sungai",
            "Stor",
            "Tandas",
            "Tangga",
            "Tempat letak basikal",
            "Tolok hujan",
            "Tong sampah",
            "Utiliti (air,gas,elektrik)",
            "Wakaf/pegola"
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
        $query = Hardscape::select(
            "gid",
            "objectid",
            'x',
            'y',
            'kod_tag',
            'zon',
            'jenis',
            'nama_struk',
            'gambar',
            'keadaan',
            'tarikh',
            'kos_bina',
            'baik_pulih',
            'selenggara',
            'catatan',
            'tahun_dibi'
        );


        if ($request->has('keyword')) {

            $data =  $query->whereNotNull('geom')
                ->whereRaw('LOWER(kod_tag) = ?', [strtolower($request->keyword)])->get()
                ->makeHidden(['fullKodTag', 'hardscapeQrcode', 'geom']);

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
                ->makeHidden(['fullKodTag', 'hardscapeQrcode', 'geom']);
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

            $data =  $query->where('zon', 'like', $zone[$request->zon] . '%')
                ->whereNotNull('geom')
                ->orderByRaw('LENGTH(kod_tag) desc')
                ->orderBy('kod_tag', 'desc')
                ->limit(100)->get()->makeHidden(['fullKodTag', 'hardscapeQrcode', 'geom']);

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

             $hardscape = Hardscape::where('gid', $request->gid)->first()
                ->makeHidden(['fullKodTag', 'hardscapeQrcode', 'geom']);

            
            $fileNameGambar = $hardscape->kod_tag . '_' . date('ynj-Hi');

            // $files = $request->file('image');

            $jenis = $request->jenis;

            if($hardscape->{$jenis} && Storage::disk('public')->exists('assets/hardscape/'.$hardscape->{$jenis})){
                Storage::disk('public')->move('assets/hardscape/'.$hardscape->{$jenis}, 'assets/hardscape/'.$hardscape->{$jenis}.'.repl');
            }

            $fileName =  $fileNameGambar . '.' . $request->image->getClientOriginalExtension();

            Storage::disk('public')->putFileAs(
                'assets/hardscape',
                $request->file('image'),
                $fileName
            );

            $hardscape->{$jenis} = $fileName;
            $hardscape->updated_at = now();
            $hardscape->save();

            return $fileName;
        }

        return false;
    }    

    public function gambarhapus(Request $request)
    {
        if ($request->has('jenis') && $request->has('gid')) {

            $hardscape = Hardscape::where('gid', $request->gid)->first()
                ->makeHidden(['fullKodTag', 'hardscapeQrcode', 'geom']);

        
            $jenis = $request->jenis;

            Storage::disk('public')->move('assets/hardscape/'.$hardscape->{$jenis}, 'assets/hardscape/'.$hardscape->{$jenis}.'.del');

        
            $hardscape->{$jenis} = null;
            $hardscape->updated_at = now();
            $hardscape->save();

            return 'berjaya';
        }

        return false;
    }

    public function gambar(Request $request)
    {

        if ($request->has('id')) {

            # code...
            $query = Hardscape::select(
                "gid",
                "gambar"
            );

            $data =  $query->whereNotNull('geom')
                ->where('gid', $request->id)->first()
                ->makeHidden(['fullKodTag', 'hardscapeQrcode', 'geom']);

            if ($data) {

                $index = 0;
                $gambar['gambar'] = null;

                if ($data->gambar && Storage::disk('public')->exists('assets/hardscape/' . $data->gambar)) {
                    $gambar['gambar'] = $data->gambar;
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

        $first = Hardscape::select('gid', 'objectid')->orderBy('gid', 'desc')->first()
            ->makeHidden(['fullKodTag', 'hardscapeQrcode']);

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

        if (!$request->gid) {
            $first = Hardscape::select('gid', 'objectid')->orderBy('gid', 'desc')->first()->makeHidden(['fullKodTag', 'hardscapeQrcode', 'geom']);
            $objectid = $first->gid + 1;
            $kod_tag = 'K' . $objectid;
            $tarikh_mas = date('d-m-Y g:i A');
        } else {
            $objectid = $request->objectid;
            $kod_tag = $request->kod_tag;
            $tarikh_mas = date('d-m-Y g:i A');
        }

        $saved = Hardscape::updateOrCreate(
            ['gid' => $request->gid ?? null],
            [
                'objectid' => $objectid,
                'zon' => $inputZon,
                'kod_tag' => $kod_tag,
                'x' => number_format($request->y_coord, 8, '.', ''),
                'y' => number_format($request->x_coord, 8, '.', ''),
                'jenis' => $request->jenis,
                'nama_struk' => $request->nama_struk,
                'keadaan' => $request->keadaan,
                'catatan' => $request->catatan,
                'tarikh' => $tarikh_mas,
                'geom' => DB::Raw("public.ST_GeomFromText('POINT($request->y_coord $request->x_coord)',4326)"),
            ]
        );

        if (!$saved) {
            $json["error"] = true;
            $json["errmsg"] = "Maklumat gagal di simpan";
            $json["data"] = [];
            return $json;
        }

        $saved =  $saved->makeHidden(['fullKodTag', 'hardscapeQrcode', 'geom']);

        $userId = $this->_getuserId($request->token);

        $userDevice = $this->_getuserDevice($request->token);

        $details = Audit::where('auditable_type', 'App\Model\Hardscape')
            ->where('auditable_id', $saved->gid)
            ->update([
                'tags' => 'Mobile',
                'user_agent' => $userDevice,
                'user_type' => 'App\User',
                'user_id' => $userId
            ]);



        $json["error"] = false;
        $json["errmsg"] = "Maklumat berjaya di simpan";
        // $json["data"] = [$request->gid, $request->kod_tag, $request->objectid];
        $json["data"] = [$saved];
        return $json;
    }
}
