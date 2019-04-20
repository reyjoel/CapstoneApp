<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Student extends Authenticatable
{
    use Notifiable;

    protected $guard = 'web_student';

    protected $primaryKey = 'stu_id';

    public $incrementing = false;

    protected $fillable = [
        'stu_id', 'bus_id', 'fname', 'lname', 'email', 'password', 'lat', 'lng',
    ];

    public function bus()
    {
        return $this->belongsTo(Bus::class, 'bus_id');
    }

    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }

    public function message()
    {
        return $this->hasMany(Message::class);
    }

    public function guardian()
    {
        return $this->belongsTo(Guardian::class, 'stu_id');
    }

     protected $hidden = [
         'password', 'remember_token',
     ];
}
