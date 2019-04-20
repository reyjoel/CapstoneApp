<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bus extends Model
{
    protected $fillable = [
        'plate_num', 'reg_num',
    ];

    public function driver()
    {
        return $this->belongsTo(Driver::class, 'bus_id');
    }

    public function student()
    {
        return $this->hasMany(Student::class, 'bus_id');
    }
}
