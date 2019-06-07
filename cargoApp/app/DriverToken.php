<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DriverToken extends Model
{
    protected $fillable = [
        'driver_id',
        'token',
    ];
    public function companies()
    {
        return $this->belongsTo('App\Driver');
    }
}
