<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CompanyContactList extends Model
{
    protected $fillable = [
        'company_id',
        'receiver_name',
        'conatct_name',
        'contact_phone',
        'contact_address',
        'address_latitude',
        'address_longitude',
    ];
    public function companies()
    {
        return $this->belongsTo('App\Company');
    }
}
