<?php

namespace App\Http\Controllers\DriverAuth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Auth;

class LoginController extends Controller
{

    use AuthenticatesUsers;

    protected $redirectTo = '/driver/home';

    public function __construct()
    {
        $this->middleware('guest:web_driver')->except('logout');
    }

    public function showLoginForm()
    {
        return view('drivers.auth.login');
    }

    public function login(Request $request)
    {

        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);

        if (Auth::guard('web_driver')->attempt(['email' => $request->email,
        'password' => $request->password], $request->remember))
        {
            return redirect()->intended(route('driver.home'));
        }

        return redirect()->back()->withInput($request->only('email', 'remember'));
    }
}

