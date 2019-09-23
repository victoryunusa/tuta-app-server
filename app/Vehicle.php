<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    protected $guarded = ['id'];


    public function driver()
    {
        return $this->belongsTo('App\Driver');
    }

    public function category()
    {
       return $this->belongsTo('App\VehicleCategory');
    }
}
