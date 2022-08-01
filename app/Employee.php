<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Attendance;
use App\Employee;

class Employee extends Model
{
    protected $fillable = ['user_id','daily_rate'];

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function attendance(){
        return $this->hasMany('App\Attendance','employee_id');
    }
}
