<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'type', 'capacity', 'driver_id', 'category_id',
    ];


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
