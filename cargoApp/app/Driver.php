<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    public function supervisor()
    {
        return $this->belongsTo('App\User', 'foreign_key');
    }
}
