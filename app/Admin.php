<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    use Notifiable;

    protected $guard = 'web_admin';

    protected $fillable = [
        'fname', 'lname', 'email', 'password',
    ];

     protected $hidden = [
         'password', 'remember_token',
     ];
}
