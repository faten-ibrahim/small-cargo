<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Cog\Laravel\Ban\Traits\Bannable;
use Cog\Contracts\Ban\Bannable as BannableContract;
use Illuminate\Database\Eloquent\SoftDeletes;

class Driver extends Authenticatable implements JWTSubject,BannableContract
{
    use Notifiable,Bannable,SoftDeletes;
    protected $dates = ['deleted_at'];
    public function supervisor()
    {
        return $this->belongsTo('App\User', 'foreign_key');
    }

    protected $fillable = [
        'name','phone','car_number','car_type','address'
    ];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    // protected $hidden = [
    //     'phone', 'remember_token',
    // ];

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new CompanyResetPassword($token));
    }

     /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];


}
