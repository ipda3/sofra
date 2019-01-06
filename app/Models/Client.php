<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Client extends Authenticatable
{

    protected $table = 'clients';
    public $timestamps = true;
    protected $fillable = array('name', 'email', 'phone', 'address', 'password', 'region_id', 'api_token', 'code');

    public function orders()
    {
        return $this->hasMany('App\Models\Order');
    }

    public function cart()
    {
        return $this->belongsToMany('App\Models\Item','carts')->withPivot('price', 'quantity', 'note','id');
    }

    public function region()
    {
        return $this->belongsTo('App\Models\Region');
    }

    public function tokens()
    {
        return $this->morphMany('App\Models\Token', 'accountable');
    }

    public function notifications()
    {
        return $this->morphMany('App\Models\Notification', 'notifiable');
    }

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'api_token', 'code'
    ];

}