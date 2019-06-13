<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Order extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'shipment_type','car_number','truck_type','pickup_date'
    ];

    public function  companies()
    {
        return $this->belongsToMany('App\Company')
                    ->using('App\CompanyOrder')
                    ->withPivot([
                        'receiver_name',
                        'saved',
                        'created_by',
                        'updated_by',
                    ]);
    }

    public function package()
    {
        return $this->hasOne('App\Package');
    }


}
