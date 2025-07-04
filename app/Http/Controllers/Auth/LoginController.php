<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Mews\Captcha\Facades\Captcha;

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
    protected $redirectTo = '/menu/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    public function reload(Request $request)
    {
        try {
            $captcha = Captcha::img('math');
            return response()->json([
                'success' => true,
                'message' => 'Captcha reloaded successfully',
                'data' => $captcha,
            ], 200);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json([
                'success' => false,
                'message' => 'Captcha reload failed',
                'errors' => [
                    'Failed to reload captcha. Please try again later. Error ' . $th->getMessage(),
                ],
            ], 500);
        }
    }
    protected function validateLogin(Request $request)
    {
        $request->validate([
            $this->username() => 'required|string|email',
            'password'        => 'required|string',
            'captcha'         => 'required|captcha',
        ], [
            $this->username() . '.required' => 'Please enter your email address.',
            $this->username() . '.email'    => 'The email must be a valid email address.',
            'password.required'             => 'Please enter your password.',
            'captcha.required'              => 'Please enter the captcha code.',
            'captcha.captcha'               => 'The captcha code is incorrect. Please try again.',
        ]);
    }
    protected function decayMinutes()
    {
        return 1;
    }
    protected function maxAttempts()
    {
        return 30;
    }
}
