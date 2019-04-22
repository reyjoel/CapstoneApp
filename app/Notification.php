<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Notification extends Model
{
    protected $guarded = [];

    function CentralizeNotifications($param, $type){
        $notification = DB::table('notifications AS n')
                            ->join('guardians AS g', 'n.notifier_id', '=', 'g.id')
                            ->join('students AS s', 'g.student_id', '=', 's.stu_id')
                            ->select('n.*', 's.fname AS stu_fname', 's.lname AS stu_lname', 'g.fname AS g_fname', 'g.lname AS g_lname')
                            ->where('notify_to_id', '=', $param)
                            ->where('notifier', '!=', $type)
                            ->get();
        return $notification;
    }
}