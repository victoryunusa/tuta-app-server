<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    protected $guarded = ['id'];

    public function driver()
    {
        return $this->belongsTo('App\Driver');
    }

    public function customer()
    {
        return $this->belongsTo('App\User');
    }
}
