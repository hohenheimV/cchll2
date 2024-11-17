<?php

namespace App\Http\Controllers\Api;

use App\User;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class BaseController extends Controller
{

    private $dayExpired = 7;

    /**
     * success response method.
     *
     * @return Illuminate\Http\Response
     */
    public function sendResponse($result, $message)
    {
        # code...
        $response = [
            'status' => true,
            'data' => $result,
            'message' => $message
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
            'status' => false,
            'message' => $error
        ];

        if (!empty($errorMessage)) {
            $response['data'] = $errorMessage;
        }

        return response()->json($response, $code);
    }

    public function _encodeToken($id)
    {
        $encryptedValue = \Hashids::encode($id,Carbon::now()->addDays($this->dayExpired)->timestamp);

        return $encryptedValue;
    }

    public function _decodeToken($token)
    {
        $encryptedValue = \Hashids::decode($token);

        return $encryptedValue;
    }

    public function _encryptString($encryptedValue)
    {
        return encrypt($encryptedValue);
    }

    public function _decryptString($encryptedValue)
    {
        return decrypt($encryptedValue);
    }


    public function _verifyTime($time)
    {
        $expired_login = new Carbon($time);

        //less then dayExpired day
        if (Carbon::now()->diffInDays($expired_login) <= $this->dayExpired) {
            return true;
        }
        return false;
    }

    public function _getuserId($token)
    {
        $decryptString = $this->_decryptString($token);

        $decodeToken = $this->_decodeToken($decryptString);

        return $decodeToken[0];
    }
    

    public function _getuserDevice($token)
    {
        $decryptString = $this->_decryptString($token);

        $decodeToken = $this->_decodeToken($decryptString);

        $user = User::find($decodeToken[0]);

        return $user->device;
    }
}
