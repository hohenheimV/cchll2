<?php

namespace App\Http\Controllers\Api;

use Vinkla\Hashids\Facades\Hashids;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class BaseController extends Controller
{

    /**
     * success response method.
     *
     * @return Illuminate\Http\Response
     */
    public function sendResponse($result, $message)
    {
        # code...
        $response = [
            'status'=>true,
            'data'=>$result,
            'message'=>$message
        ];

        return response()->json($response, 200);
    }

    /**
     * success response method.
     *
     * @return Illuminate\Http\Response
     */
    public function sendError($error, $errorMessage = [], $code = 404)
    {
        # code...
        $response = [
            'status'=>false,
            'message'=>$error
        ];

        if(!empty($errorMessage)){
            $response['data'] = $errorMessage;
        }

        return response()->json($response, $code);
    }
}
