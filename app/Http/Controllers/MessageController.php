<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Bus;
use App\Driver;
use App\Student;
use App\Message;
use App\Events\SentMessage;
use Illuminate\Support\Facades\DB;

class MessageController extends Controller
{


    // Student Send & Fetch
      public function sendStudentMessages(Request $request)
    {
        $id = Auth::guard('web_student')->id();
        $bus_id = Student::find($id)->bus_id;

        $message = Message::create([
            'sender_id' => $id,
            'bus_id' => $bus_id,
            'student_message' => $request->message
            ]);

         $message->student;

        broadcast(new SentMessage($message))->toOthers();

        return response(['status'=>'Message sent successfully','message'=>$message]);
    }


    public function fetchStudentMessages()
    {
        $id = Auth::guard('web_student')->id();
        $bus_id = Student::find($id)->bus_id;

        $message = Message::where('bus_id', $bus_id)->with('student')->with('driver')->get();

        return response(['message' => $message]);
    }


    // Driver Send & Fetch
      public function sendDriverMessages(Request $request)
    {
        $id = Auth::guard('web_driver')->id();
        $bus_id = Driver::find($id)->bus_id;

        $message = Message::create([
            'sender_id' => $id,
            'bus_id' => $bus_id,
            'driver_message' => $request->message
            ]);

         $message->driver;

        broadcast(new SentMessage($message))->toOthers();

        return response(['status'=>'Message sent successfully','message'=>$message]);
    }


    public function fetchDriverMessages()
    {
        $id = Auth::guard('web_driver')->id();
        $bus_id = Driver::find($id)->bus_id;

        $message = Message::where('bus_id', $bus_id)->with('driver')->with('student')->get();

        return response(['message' => $message]);
    }


}
