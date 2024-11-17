<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController;
use App\User;
use DateTime;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Laravel\Passport\Exceptions\OAuthServerException;

class AuthController extends BaseController
{
    //use ThrottlesLogins;

    public function __construct()
    {
        $this->middleware('throttle:20,1')->only('login');
    }

    public function login(Request $request)
    {

        return $this->sendResponse($request->all(), 'User login successfully');
        // Mula Rule validation
        $rules = [
            'email'   => 'required',
            'password'  => 'required',
        ];

        //Selaras bentuk mesej yang sama; attributes berbeza
        $messages = [
            'required'  => ':attribute diperlukan.'
        ];
        // Rename field ke perkataan boleh difaham (jika perlu/berlainan)
        $attributes = [];

        //$validator($rules, $messages, $attributes);
        $validator = Validator::make($request->all(), $rules, $messages, $attributes);

        //if Validator fails return errors()
        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        //Only username & password
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $user['token'] = $user->createToken('AppTpbk')->accessToken;

            // Authentication passed...
            return $this->sendResponse($user, 'User login successfully');
        } else {
            return $this->sendError('unauthorised.', ['error' => 'Invalid username/password'], 403);
        }
    }

    public function logout(Request $request)
    {

        $request->user()->token()->revoke();
        return $this->sendResponse(null, 'Successfully logged out');
    }

    /**
     * Get the authenticated User
     *
     * @return [json] user object
     */
    public function user(Request $request)
    {
        $user = $request->user();

        if (!empty($user)) {
            return $this->sendResponse($user, 'User login successfully');
        }

        return $this->sendError('unauthorised.', ['error' => 'Unauthorised']);
    }
}
