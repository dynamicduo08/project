<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DailyRate extends Model
{
    //

    public function user_info()
    {
        return $this->belongsTo(User::class,'created_by','id');
    }
}
