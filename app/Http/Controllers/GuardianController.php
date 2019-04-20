<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Events\Location;
use App\Guardian;
use App\Student;
use App\Driver;
use Illuminate\Contracts\Auth\Guard;

class GuardianController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:web_guardian');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('guardians.home');
    }

    public function linkProfile()
    {
        return view('guardians.profile');
    }


    // INFORMATION
    public function updateInfo(Request $request)
    {
        $this->validatorInformation($request->all())->validate();

        $this->updateInformation($request->all());

    }

    protected function validatorInformation(array $data)
    {
        return Validator::make($data, [
            'fname' => 'required|max:10',
            'lname' => 'required|max:10'
        ]);
    }

    protected function updateInformation(array $data)
    {

        $id = Auth::guard('web_guardian')->id();
        return Guardian::where('id', $id)
            ->update([
                'fname' => $data['fname'],
                'lname' => $data['lname']
        ]);
    }


    // Email
    public function updateEmail(Request $request)
    {
        $this->validatorEmailAddress($request->all())->validate();

        $this->updateEmailAddress($request->all());

    }

    protected function validatorEmailAddress(array $data)
    {
        return Validator::make($data, [
            'email' => 'required|email|max:255|unique:admins'
        ]);
    }

    protected function updateEmailAddress(array $data)
    {

        $id = Auth::guard('web_guardian')->id();
        return Guardian::where('id', $id)
            ->update([
                'email' => $data['email'],
        ]);
    }


    // PASSWORD
    public function updatePassword(Request $request)
    {
        $this->validatorPass($request->all())->validate();

        $this->updatePass($request->all());
    }

    protected function validatorPass(array $data)
    {
        return Validator::make($data, [
            'password' => 'required|min:6|confirmed',
        ]);
    }

    protected function updatePass(array $data)
    {

        $id = Auth::guard('web_guardian')->id();
        return Guardian::where('id', $id)
            ->update([
            'password' => bcrypt($data['password']),
        ]);
    }

    public function showProfileInfo()
    {
        $id = Auth::guard('web_guardian')->id();
        $student_id = Guardian::find($id)->student_id;
        $student = Student::find($student_id);

        return response(['student'=> $student]);
    }


    public function showLocation()
    {
        $id = Auth::guard('web_guardian')->id();
        $student_id = Guardian::find($id)->student_id;
        $bus_id = Student::find($student_id)->bus_id;
        $student = Student::find($student_id);
        $driver = Driver::where('bus_id', $bus_id)->get();

        broadcast(new Location($student, $driver));

        return response()->json(array('student' => $student, 'driver' => $driver));
     }



    public function logout()
    {
        auth()->logout();
        return redirect('/guardian/login');
    }
}
