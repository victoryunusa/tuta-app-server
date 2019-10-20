<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'src_lat', 'src_long', 'dest_lat', 'dest_long', 'user_id', 'fare',
    ]; 


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
