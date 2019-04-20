<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Driver extends Authenticatable
{
    use Notifiable;

    protected $guard = 'web_driver';

    protected $fillable = [
        'lic_num', 'bus_id', 'fname', 'lname', 'email', 'password', 'lat', 'lng',
    ];

    public function bus()
    {
        return $this->hasOne(Bus::class, 'bus_id');
    }

    public function student()
    {
        return $this->hasMany(Student::class);
    }

    public function guardian()
    {
        return $this->hasMany(Guardian::class);
    }

    public function message()
    {
        return $this->hasMany(Message::class);
    }

     protected $hidden = [
         'password', 'remember_token',
     ];
}
