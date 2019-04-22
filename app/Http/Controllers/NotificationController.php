<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Bus;
use App\Driver;
use App\Student;
use App\Guardian;
use App\Notification;
use App\Events\Notifications;
use Illuminate\Support\Facades\DB;

class NotificationController extends Controller
{
    function guardianNotifications(){
        $this->middleware('auth:web_guardian');

        $guardian_id = Auth::guard('web_guardian')->id();
        $student_id = Guardian::find($guardian_id)->student_id;
        $bus_id = Student::find($student_id)->bus_id;
        $notification = new Notification();
        $res = $notification->CentralizeNotifications($bus_id, 'guardian');

        return response(['notification' => $res]);
    }

    function driverNotifications(){
        $this->middleware('auth:web_driver');

        $driver_id = Auth::guard('web_driver')->id();
        $bus_id = Driver::find($driver_id)->bus_id;

        $notification = new Notification();
        $res = $notification->CentralizeNotifications($bus_id, 'driver');

        return response(['notification' => $res]);
    }

    function studentNotifications(){
        $this->middleware('auth:web_student');

        $student_id = Auth::guard('web_student')->id();
        $bus_id = Student::find($student_id)->bus_id;

        $notification = new Notification();
        $res = $notification->CentralizeNotifications($bus_id, 'guardian');

        return response(['notification' => $res]);
    }

    public function notifyDriver(Request $request){
        $this->middleware('auth:web_guardian');

        $id = Auth::guard('web_guardian')->id();
        $notifier_id = Guardian::find($id)->student_id;
        $notify_to_id = Student::find($notifier_id)->bus_id;

        $message = Notification::create([
            'notifier_id' => $id,
            'notifier' => 'guardian',
            'notify_to' => 'bus',
            'notify_to_id' => $notify_to_id
            ]);

        broadcast(new Notifications($message))->toOthers();

        return response(['status'=>'Message sent successfully','message'=>$message]);
    }

    public function notifyAll(Request $request){
        $this->middleware('auth:web_driver');

        $id = Auth::guard('web_driver')->id();
        $bus_id = Driver::find($id)->bus_id;

        $message = Notification::create([
            'notifier_id' => $id,
            'notifier' => 'driver',
            'notify_to' => 'bus',
            'notify_to_id' => $bus_id
            ]);

        broadcast(new Notifications($message))->toOthers();

        return response(['status'=>'Message sent successfully','message'=>$message]);
    }
}
