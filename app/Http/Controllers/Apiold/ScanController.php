<?php

namespace App\Http\Controllers\Api;

use Vinkla\Hashids\Facades\Hashids;
use App\Http\Controllers\Api\BaseController;

use App\Model\Hardscape;
use App\Model\Softscape;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class ScanController extends BaseController
{
    public function qrcode(Request $request, $code)
    {
        # code...
        $encrypted = \Hashids::decode($code);

        if ($encrypted) {

            $zon = $encrypted;
            $type = $encrypted[1];
            $variable = $encrypted[2];

            switch ($type) {
                case 4:
                    # code...
                    $data = Hardscape::with('record')->find($variable);
                    $type = 'hardscape';
                    break;
                case 7:
                    # code...
                    $datas = Softscape::select(
                        "objectid",
                        "y_coord",
                        "x_coord",
                        "kod_tag",
                        "label_zon",
                        "nama_zon",
                        "jenis_ka",
                        "nama_botan",
                        "nama_tempa",
                        "nama_kelua",
                        "negara_asa",
                        "sumber_ana",
                        "taman_pers",
                        "gambar_kes",
                        "gambar_bat",
                        "gambar_dau",
                        "gambar_bun",
                        "gambar_bua"
                    )->where('objectid', $variable)->first();
                    $type = 'softscape';
                    // Arr::set($data, 'gambar_kes', 'Calixto');

                    $id = $datas->id;
                    unset($datas->id);
                    if ($datas->gambar_kes) {
                        Arr::set($datas, 'gambar_kes', "http://tpbk.jln.gov.my/storage/assets/softscape/$id/2020/" . $datas->gambar_kes);
                    }
                    if ($datas->gambar_bat) {
                        Arr::set($datas, 'gambar_bat', "http://tpbk.jln.gov.my/storage/assets/softscape/$id/2020/" . $datas->gambar_bat);
                    }
                    if ($datas->gambar_dau) {
                        Arr::set($datas, 'gambar_dau', "http://tpbk.jln.gov.my/storage/assets/softscape/$id/2020/" . $datas->gambar_dau);
                    }
                    if ($datas->gambar_bun) {
                        Arr::set($datas, 'gambar_bun', "http://tpbk.jln.gov.my/storage/assets/softscape/$id/2020/" . $datas->gambar_bun);
                    }
                    if ($datas->gambar_bua) {
                        Arr::set($datas, 'gambar_bua', "http://tpbk.jln.gov.my/storage/assets/softscape/$id/2020/" . $datas->gambar_bua);
                    }
                    $data = array($datas);
                    break;

                default:
                    # code...
                    $data = false;
                    $type = false;
                    break;
            }

            // $zon = $encrypted;
            // $type = $encrypted[1];
            // $variable = $encrypted[2];


            return $this->sendResponse($data, 'Maklumat Qrcode dijumpai.');
        } else {
            return $this->sendError('Data not found.', null);
        }
    }
}
