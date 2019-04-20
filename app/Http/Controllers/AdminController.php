<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Student;
use App\Driver;
use App\Guardian;
use App\Bus;
use App\Admin;

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:web_admin');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('admins.home');
    }

    public function linkProfile()
    {
        return view('admins.profile');
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

        $id = Auth::guard('web_admin')->id();
        return Admin::where('id', $id)
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

        $id = Auth::guard('web_admin')->id();
        return Admin::where('id', $id)
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

        $id = Auth::guard('web_admin')->id();
        return Admin::where('id', $id)
            ->update([
            'password' => bcrypt($data['password']),
        ]);
    }



    public function studentTable()
    {
        return view('admins.student-table');
    }

    public function driverTable()
    {
        return view('admins.driver-table');
    }

    public function guardianTable()
    {
        return view('admins.guardian-table');
    }

    public function busTable()
    {
        return view('admins.bus-table');
    }

    // Student

    public function showStudentTable()
    {
        $students = Student::all();

        return response(['students'=>$students]);
    }

    public function addStudentTable(Request $request)
    {
        $stu_id = $request->add_stu_id;
        $bus_id = $request->add_bus_id;
        $fname = $request->add_fname;
        $lname = $request->add_lname;
        $email = $request->add_email;
        $password = $request->add_password;

        Student::create([
        'stu_id' => $stu_id,
        'bus_id' => $bus_id,
        'fname' => $fname,
        'lname' => $lname,
        'email' => $email,
        'password' => Hash::make($password)
        ]);

    }

    public function updateStudentTable(Request $request)
    {
        $stu_id = $request->stu_id;
        $bus_id = $request->bus_id;
        $fname = $request->fname;
        $lname = $request->lname;
        $email = $request->email;

        Student::where('fname', $fname)
            ->update([
            'stu_id' => $stu_id
            ]);

        Student::where('stu_id', $stu_id)
            ->update([
            'bus_id' => $bus_id,
            'fname' => $fname,
            'lname' => $lname,
            'email' => $email
            ]);

    }

    public function deleteStudentTable(Request $request)
    {
        $stu_id = $request->stu_id;

        DB::table('students')
        ->where('stu_id', $stu_id)
        ->delete();
    }

    // Driver

    public function showDriverTable()
    {
        $drivers = Driver::all();

        return response(['drivers'=>$drivers]);
    }

    public function addDriverTable(Request $request)
    {
        $lic_num = $request->add_lic_num;
        $bus_id = $request->add_bus_id;
        $fname = $request->add_fname;
        $lname = $request->add_lname;
        $email = $request->add_email;
        $password = $request->add_password;

        Driver::create([
        'lic_num' => $lic_num,
        'bus_id' => $bus_id,
        'fname' => $fname,
        'lname' => $lname,
        'email' => $email,
        'password' => Hash::make($password)
        ]);

    }

    public function updateDriverTable(Request $request)
    {
        $lic_num = $request->lic_num;
        $bus_id = $request->bus_id;
        $fname = $request->fname;
        $lname = $request->lname;
        $email = $request->email;

        Driver::where('fname', $fname)
            ->update([
            'lic_num' => $lic_num
            ]);

        Driver::where('lic_num', $lic_num)
            ->update([
            'lic_num' => $lic_num,
            'bus_id' => $bus_id,
            'fname' => $fname,
            'lname' => $lname,
            'email' => $email
            ]);

    }

    public function deleteDriverTable(Request $request)
    {
        $lic_num = $request->lic_num;

        DB::table('drivers')
        ->where('lic_num', $lic_num)
        ->delete();
    }

    // Guardian

    public function showGuardianTable()
    {
        $guardians = Guardian::all();

        return response(['guardians'=>$guardians]);
    }

    public function addGuardianTable(Request $request)
    {
        $student_id = $request->add_student_id;
        $fname = $request->add_fname;
        $lname = $request->add_lname;
        $email = $request->add_email;
        $password = $request->add_password;

        Guardian::create([
        'student_id' => $student_id,
        'fname' => $fname,
        'lname' => $lname,
        'email' => $email,
        'password' => Hash::make($password)
        ]);

    }

    public function updateGuardianTable(Request $request)
    {
        $student_id = $request->student_id;
        $fname = $request->fname;
        $lname = $request->lname;
        $email = $request->email;

        Guardian::where('fname', $fname)
            ->update([
            'student_id' => $student_id
            ]);

        Guardian::where('student_id', $student_id)
            ->update([
            'fname' => $fname,
            'lname' => $lname,
            'email' => $email
            ]);

    }

    public function deleteGuardianTable(Request $request)
    {
        $student_id = $request->student_id;

        DB::table('guardians')
        ->where('student_id', $student_id)
        ->delete();
    }

    // Bus

    public function showBusTable()
    {
        $buses = Bus::all();

        return response(['buses'=>$buses]);
    }

    public function addBusTable(Request $request)
    {
        $plate_num = $request->add_plate_num;
        $reg_num = $request->add_reg_num;

        Bus::create([
        'plate_num' => $plate_num,
        'reg_num' => $reg_num,
        ]);

    }

    public function updateBusTable(Request $request)
    {
        $plate_num = $request->plate_num;
        $reg_num = $request->reg_num;

        Bus::where('plate_num', $plate_num)
            ->update([
            'reg_num' => $reg_num
            ]);

        Bus::where('reg_num', $reg_num)
            ->update([
            'plate_num' => $plate_num
            ]);

    }

    public function deleteBusTable(Request $request)
    {
        $plate_num = $request->plate_num;

        DB::table('buses')
        ->where('plate_num', $plate_num)
        ->delete();
    }


    public function logout()
    {
        auth()->logout();
        return redirect('/admin/login');
    }
}


