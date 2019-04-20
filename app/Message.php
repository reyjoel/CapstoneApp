<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $guarded = [];

    public function student()
    {
        return $this->belongsTo(Student::class, 'sender_id');
    }

    public function driver()
    {
        return $this->belongsTo(Driver::class, 'sender_id');
    }
}
