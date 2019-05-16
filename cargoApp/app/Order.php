<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public function companies()
    {
        return $this->hasMany('App\Company');
    }

    public function package()
    {
        return $this->hasOne('App\Package');
    }


}
