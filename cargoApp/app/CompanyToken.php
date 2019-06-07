<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CompanyToken extends Model
{
    protected $fillable = [
        'company_id',
        'token',
    ];
    public function companies()
    {
        return $this->belongsTo('App\Company');
    }
}
