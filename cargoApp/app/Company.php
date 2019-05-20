<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    public function orders()
    {
        return $this->hasMany('App\Order');
                    // ->using('App\CompanyOrder');
                    // ->withPivot([
                    //     'receiver_name',
                    //     'saved',
                    //     'created_by',
                    //     'updated_by',
                    // ]);
    }


}
