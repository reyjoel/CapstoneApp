<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Guardian extends Authenticatable
{
    use Notifiable;

    protected $guard = 'web_guardian';

    protected $fillable = [
        'fname', 'lname', 'student_id', 'email', 'password',
    ];

    public function student()
    {
        return $this->hasMany(Student::class, 'student_id');
    }

     protected $hidden = [
         'password', 'remember_token',
     ];
}
