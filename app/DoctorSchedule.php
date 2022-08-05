<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DoctorSchedule extends Model
{
    //

    public function doctor_infor(){
        return $this->belongsTo('App\DoctorDetail','doctor_id','user_id');
    }
    
}
