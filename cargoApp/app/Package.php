<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Package extends Model
{


    protected $fillable = [
        'length','width','height','Weight',
        'pickup_location','pickup_latitude',
        'pickup_longitude','drop_off_location',
        'drop_off_latitude','drop_off_longitude',
        'value','quantity','order_id','photo','distance',
    ];

    public function order()
    {
        return $this->belongsTo('App\Order', 'foreign_key');
    }


}
