<?php

namespace App\Http\Controllers\StudentAuth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Auth;

class LoginController extends Controller
{

    use AuthenticatesUsers;

    protected $redirectTo = '/student/home';

    public function __construct()
    {
        $this->middleware('guest:web_student')->except('logout');
    }

    public function showLoginForm()
    {
        return view('students.auth.login');
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);

        if (Auth::guard('web_student')->attempt(['email' => $request->email,
        'password' => $request->password], $request->remember))
        {
            return redirect()->intended(route('student.home'));
        }

        return redirect()->back()->withInput($request->only('email', 'remember'));
    }
}
