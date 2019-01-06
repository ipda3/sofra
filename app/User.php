<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Zizaco\Entrust\Traits\EntrustUserTrait;

class User extends Authenticatable
{
    use EntrustUserTrait;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','phone','api_token','date_of_birth','gender','region_id'
    ];
    
    protected $appends = ['is_admin'];


    public function orders()
    {
        return $this->hasMany('App\Models\Order');
    }

    public function getRolesListAttribute()
    {
        return $this->roles()->pluck('id')->toArray();
    }
    
    public function addresses()
    {
        return $this->hasMany('App\Models\Address');
    }

    public function getIsAdminAttribute($value)
    {
        return $this->hasRole('admin');
    }

    public function notifications()
    {
        return $this->hasMany('App\Models\Notification');
    }

    public function tokens()
    {
        return $this->hasMany('App\Models\Token');
    }

    public function restaurants()
    {
        return $this->hasMany('App\Models\Restaurant');
    }

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
}
