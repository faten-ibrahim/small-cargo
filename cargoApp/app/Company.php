<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;


class Company extends Authenticatable implements JWTSubject
{
    use Notifiable;
    public function companycontactlists()
    {
        return $this->hasMany('App\CompanyContactList');
    }
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

    protected $fillable = [
        'name', 'email', 'password','address','phone',
    ];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

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



}
