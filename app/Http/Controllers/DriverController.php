<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Driver;
class DriverController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:web_driver');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('drivers.home');
    }

    public function linkProfile()
    {
        return view('drivers.profile');
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

        $id = Auth::guard('web_driver')->id();
        return Driver::where('id', $id)
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

        $id = Auth::guard('web_driver')->id();
        return Driver::where('id', $id)
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

        $id = Auth::guard('web_driver')->id();
        return Driver::where('id', $id)
            ->update([
            'password' => bcrypt($data['password']),
        ]);
    }


    public function linkMessage()
    {
        return view('drivers.message');
    }

    public function updateLocation(Request $request)
    {
            $lat = $request->lat;
            $lng = $request->lng;
            $id = Auth::guard('web_driver')->id();

            DB::table('drivers')
            ->where('id', $id)
            ->update(['lat' => $lat, 'lng' => $lng]);

    }

    // Notifications
    public function driverNotifications(){
        return view('drivers.notification');
    }

    public function logout()
    {
        auth()->logout();
        return redirect('/driver/login');
    }
}
