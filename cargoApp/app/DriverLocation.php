<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DriverLocation extends Model
{
    protected $fillable = [
        'driver_id',
        'driver_latitude',
        'driver_longitude',
    ];
    public function driver()
    {
        return $this->belongsTo('App\Driver');
    }
}
