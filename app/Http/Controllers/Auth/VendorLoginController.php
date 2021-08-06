<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Vendor;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;
use Illuminate\Validation\ValidationException;

class VendorLoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = '/vendor/dashboard';

    /**
     * Max login attempts allowed.
     */
    public $maxAttempts = 5;

    /**
     * Number of minutes to lock the login.
     */
    public $decayMinutes = 3;

    public function __construct()
    {
        $this->middleware('guest:vendor')->except('logout');
    }

    public function guard()
    {
        return Auth::guard('vendor');
    }


    public function showLoginForm()
    {
        return view('auth-vendor.login');
    }

    public function welcome()
    {
        return view('vendor.welcome');
    }

    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function logout(Request $request) {
        $this->guard()->logout();
        $request->session()->invalidate();

        $request->session()->regenerateToken();

        if ($response = $this->loggedOut($request)) {
            return $response;
        }

        return $request->wantsJson()
            ? new JsonResponse([], 204):redirect('/vendor/login');
    }

    protected function credentials(Request $request)
    {
        return [
            'email' => $request->input('email'),
            'password' => $request->input('password'),
        ];
    }

    protected function validateLogin(Request $request)
    {
        $request->validate([
            'email' => 'email|required|string',
            'password' => 'required|string',
        ]);

        $user = Vendor::where('email', '=', $request->input('email'))->first();
        if ($user && !$user->approved) {
           // throw ValidationException::withMessages(['status' => __('Your account requires approval before you can login, Our client service will contact you soon !')]);
        }

    }

}
