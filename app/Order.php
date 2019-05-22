<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
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
