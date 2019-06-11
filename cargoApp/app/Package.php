<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    public function order()
    {
        return $this->belongsTo('App\Order', 'foreign_key');
    }


}
