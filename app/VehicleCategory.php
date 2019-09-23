<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VehicleCategory extends Model
{
    protected $guarded = ['id'];

    public function vehicle()
    {
        return $this->hasMany('App\Vehicle');
    }
}
