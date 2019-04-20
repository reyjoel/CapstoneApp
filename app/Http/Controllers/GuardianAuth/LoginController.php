<?php

namespace App\Http\Controllers\GuardianAuth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Auth;

class LoginController extends Controller
{

    use AuthenticatesUsers;

    protected $redirectTo = '/guardian/home';

    public function __construct()
    {
        $this->middleware('guest:web_guardian')->except('logout');
    }

    public function showLoginForm()
    {
        return view('guardians.auth.login');
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);

        if (Auth::guard('web_guardian')->attempt(['email' => $request->email,
        'password' => $request->password], $request->remember))
        {
            return redirect()->intended(route('guardian.home'));
        }

        return redirect()->back()->withInput($request->only('email', 'remember'));
    }
}
