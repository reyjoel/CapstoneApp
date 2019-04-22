<?php

namespace App\Events;

use App\Notification;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Support\Facades\DB;

class Notifications implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $notifications;

    /**
     * Create a new event instance.
     *
     * @return void
     */

    public function __construct(Notification $notifications)
    {
        $notification = DB::table('notifications AS n')
                            ->join('guardians AS g', 'n.notifier_id', '=', 'g.id')
                            ->join('students AS s', 'g.student_id', '=', 's.stu_id')
                            ->select('n.*', 's.fname AS stu_fname', 's.lname AS stu_lname', 'g.fname AS g_fname', 'g.lname AS g_lname')
                            ->where('notify_to_id', '=', $notifications->notify_to_id)
                            ->latest()
                            ->first();

        $this->notifications=$notification;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('notification-sent.'.$this->notifications->notify_to_id);
    }
}