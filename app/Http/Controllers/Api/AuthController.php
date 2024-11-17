<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController;
use App\Model\Audit;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class AuthController extends BaseController
{
    //use ThrottlesLogins;
    public function __construct()
    {
        $this->middleware('throttle:20,1')->only('login');
    }


    public function login(Request $request)
    {

        # code...
        if (Auth::attempt(['email' => $request->username, 'password' => $request->password])) {
            # code...
            $user = Auth::user();

            $encodeToken = $this->_encodeToken($user->id);

            $encryptString = $this->_encryptString($encodeToken);

            $now = now();
            User::updateOrCreate(
                ['id' => $user->id],
                ['token_encrypted' => $encryptString, 'token_created_at' => $now, 'device' => $request->device]
            );

            Audit::where('tags', 'LIKE','Mobile')
                ->where('user_id', $user->id)
                ->where('created_at', $user->token_created_at ?? $now)
                ->update(['user_agent' => $request->device]);

            $user = [
                'name' => $user->name,
                'email' => $user->email,
                'token' => $encryptString,
            ];
            // Authentication passed...

            $data =  $user;
            $json["error"] = false;
            $json["msg"] = "Log Masuk Berjaya ";
            $json["data"] = $data;

            return $json;
        } else {
            $json["error"] = true;
            $json["msg"] = "Id pengguna / Kata laluan tidak padan";
            $json["data"] = [];
            return $json;
            // return $this->sendError('unauthorised.', ['error' => 'Invalid username/password'], 403);
        }
    }

    public function logout(Request $request)
    {

        $request->user()->token()->revoke();
        return $this->sendResponse(null, 'Log Keluar Berjaya');
    }

    /**
     * Get the authenticated User
     *
     * @return [json] user object
     */
    public function verify(Request $request)
    {

        if ($request->has('token')) {

            $user = User::where('token_encrypted', 'LIKE', $request->token)->first();


            if ($user) {
                $decryptString = $this->_decryptString($user->token_encrypted);

                $decodeToken = $this->_decodeToken($decryptString);

                $verifyTime = $this->_verifyTime($decodeToken[1]);

                if ($verifyTime) {

                    $user->token_created_at = now();
                    //$user->device = $request->device;

                    $user->save();

                    $json["error"] = false;
                    $json["msg"] = "Token dah";
                    return $json;
                }

                $json["error"] = true;
                $json["msg"] = "Token tamat";
                return $json;
            }

            $json["error"] = true;
            $json["msg"] = "Token tidak sah";
            return $json;
        }

        $json["error"] = true;
        $json["msg"] = "Tokan ralat";
        return $json;
    }
}
