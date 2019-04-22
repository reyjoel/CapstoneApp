<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Events\Location;
use App\Student;
use App\Driver;

class StudentController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:web_student');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('students.home');
    }

    public function linkProfile()
    {
        return view('students.profile');
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
            'fname' => 'required|max:15',
            'lname' => 'required|max:15'
        ]);
    }

    protected function updateInformation(array $data)
    {

        $id = Auth::guard('web_student')->id();
        return Student::where('stu_id', $id)
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

        $id = Auth::guard('web_student')->id();
        return Student::where('stu_id', $id)
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

        $id = Auth::guard('web_student')->id();
        return Student::where('stu_id', $id)
            ->update([
            'password' => bcrypt($data['password']),
        ]);
    }

    public function linkMessage()
    {
        return view('students.message');
    }

    public function linkDriver()
    {
        return view('students.my_driver');
    }


    public function showDriverInfo()
    {
        $id = Auth::guard('web_student')->id();
        $bus_id = Student::find($id)->bus_id;
        $driver = Driver::where('bus_id', $bus_id)->get();

        return response()->json(array('driver' => $driver));
    }

    public function updateLocation(Request $request)
    {
            $lat = $request->lat;
            $lng = $request->lng;
            $id = Auth::guard('web_student')->id();

            $student = Student::find($id);
            $bus_id = Student::find($id)->bus_id;
            $driver = Driver::where('bus_id', $bus_id)->get();

            DB::table('students')
            ->where('stu_id', $id)
            ->update(['lat' => $lat, 'lng' => $lng]);


            broadcast(new Location($student, $driver));
    }

    public function showInformation()
    {
        $id = Auth::guard('web_student')->id();

        $student = Student::where('stu_id', $id)->select('fname')->get();

        return response()->json(array('students' => $student));
    }

    public function showLocation()
    {
        $id = Auth::guard('web_student')->id();
        $bus_id = Student::find($id)->bus_id;
        $driver = Driver::where('bus_id', $bus_id)->get();
        $student = Student::find($id);

        broadcast(new Location($student, $driver));

        return response(['driver' => $driver, 'student' => $student]);
    }

    // Notifications
    public function studentNotifications(){
        return view('students.notifications');
    }

    public function logout()
    {
        auth()->logout();
        return redirect('/student/login');
    }
}
