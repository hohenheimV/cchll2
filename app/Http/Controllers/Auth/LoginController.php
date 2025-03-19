<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/pengurusan/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Override the attemptLogin method to include is_active check.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function attemptLogin(Request $request)
    {
        $credentials = $this->credentials($request);

        // Retrieve the user by credentials
        $user = Auth::getProvider()->retrieveByCredentials($credentials);

        // Check if the user exists and is active
        if ($user && $user->is_active) {
            return Auth::attempt($credentials, $request->filled('remember'));
        }

        return false;
    }

    /**
     * Override the sendFailedLoginResponse method to include custom error message.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    protected function sendFailedLoginResponse(Request $request)
    {
        $errors = [$this->username() => trans('auth.failed')];

        // Check if the credentials are correct but user is inactive
        if (Auth::getProvider()->retrieveByCredentials($this->credentials($request))) {
            $errors[$this->username()] = 'Salah emel atau katalaluan.';
        }

        throw \Illuminate\Validation\ValidationException::withMessages($errors);
    }
}
