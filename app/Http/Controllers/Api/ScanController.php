<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController;

use App\Model\Hardscape;
use App\Model\Softscape;
use Illuminate\Http\Request;

class ScanController extends BaseController
{
    public function qrcode(Request $request)
    {
        // $code = 'Q5LMo8WgDbkAxjUXIRj6wmdKqYla7G';//
        $code = $request->code ?? null;

        # code...
        $encrypted = \Hashids::decode($code);


        if ($encrypted) {

            // $type = $encrypted[1] == 7 ? 'softscape' : 'hardscape';
            $variable = $encrypted[2];
            if ($encrypted[1] == 7) { //softscape
                $type = 'softscape';
                $soft = Softscape::select('gid', 'objectid')->where('objectid', $variable)->first();
                $variable = $soft->gid;
                $error = false;
            } else if ($encrypted[1] == 4) { //hardscape
                $type = 'hardscape';
                $hard = Hardscape::select('gid', 'objectid')->where('objectid', $variable)->first();
                $variable = $hard->gid;
                $error = false;
            } else {
                $variable = null;
                $type = 'none';
                $error = true;
            }
            return [
                'error' => $error,
                'errmsg' => $error ? "Maklumat dijumpai" : "Maklumat tidak dijumpa",
                'id' => $variable * 1, 'type' => $type
            ];
        }

        return [
            'error' => true,
            'errmsg' => "Maklumat tidak dijumpai",
            'id' => null, 'type' => 'none'
        ];
    }
}
