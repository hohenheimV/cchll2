<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

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
