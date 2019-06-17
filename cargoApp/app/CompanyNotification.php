<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CompanyNotification extends Model
{
    
    public function companies()
    {
        return $this->belongsTo('App\Company');
    }

    protected $fillable = [
        'sender_id','receiver_id','title','body','shipment_type','pickup_date','car_number','truck_type','length','width','height','pickup_location','pickup_latitude','pickup_longitude','drop_off_location','drop_off_latitude','drop_off_longitude','value','Weight','quantity','order_id','status'

    ];
}
