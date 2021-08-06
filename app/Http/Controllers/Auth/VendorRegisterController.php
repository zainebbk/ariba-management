<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Vendor;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Notifications\VerifyEmailNotification;

class VendorRegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $messages = [
            'birthday.before' => 'You must have at least 18 years old !',
            'agree.required' => 'You have to agree the Terms and policy !'
        ];
        return Validator::make($data, [
            'firstname' => ['required', 'string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255'],
            'display_name' => ['required', 'string', 'max:255','unique:oc_vendor'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:oc_vendor'],
            'telephone' => ['required', 'string', 'max:255','unique:oc_vendor'],
            'birthday' => ['required', 'date', 'before:-18 years'],
            'password' => ['required', 'string', 'min:8'],
            'agree' => ['required'],
        ],$messages);

    }

    /**
     * Create a new user instance after a valid registration.
     *
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function createVendor(Request $request)
    {
        $this->validator($request->all())->validate();
        $salt = Str::random(9);

        $password=sha1($salt.sha1($salt.sha1($request['password'])));

        $vendor=Vendor::create([
            'firstname' => $request['firstname'],
            'lastname' => $request['lastname'],
            'display_name' => $request['display_name'],
            'email' => $request['email'],
            'telephone' => $request['telephone'],
            'birthday' => $request['birthday'],
            'salt' =>   $salt,
            'password' =>   $password,
            'type' => $request['type'],
            'company' =>$request['company'] ?? null,
            'company_president' => $request['company_president'] ?? null,
        ]);

        DB::table('oc_vendor_description')->insert([
            'vendor_id'=>$vendor->vendor_id,
            'language_id' => 1,
            'name' => null,
            'description' => null,
            'shipping_policy' => null,
            'return_policy' => null,
        ]);
    
        DB::table('oc_vendor_description')->insert([
            'vendor_id'=>$vendor->vendor_id,
            'language_id' => 4,
            'name' => null,
            'description' => null,
            'shipping_policy' =>null,
            'return_policy' => null,
        ]);
    
        DB::table('oc_vendor_description')->insert([
            'vendor_id'=>$vendor->vendor_id,
            'language_id' => 2,
            'name' => null,
            'description' => null,
            'shipping_policy' => null,
            'return_policy' => null,
        ]);
        return redirect()->intended('vendor/login');
    }

    protected function registered(Request $request, $user) {
        $this->notify(new VerifyEmailNotification);
    }

    public function showRegistrationForm() {
        return view('auth-vendor.register');
    }
}
