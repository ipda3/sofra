<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Restaurant extends Authenticatable
{

    protected $table = 'restaurants';
    public $timestamps = true;
    protected $fillable = array(
        'region_id', 'name', 'email', 'password','delivery_cost', 'minimum_charger',
        'phone','whatsapp', 'photo', 'availability', 'api_token','code','activated'
    );
    protected $appends = ['rate','photo_url'];

    public function items()
    {
        return $this->hasMany('App\Models\Item');
    }

    public function categories()
    {
        return $this->belongsToMany('App\Models\Category');
    }

    public function region()
    {
        return $this->belongsTo('App\Models\Region');
    }

    public function orders()
    {
        return $this->hasMany('App\Models\Order');
    }

    public function offers()
    {
        return $this->hasMany('App\Models\Offer');
    }

    public function reviews()
    {
        return $this->hasMany('App\Models\Review');
    }
    public function transactions()
    {
        return $this->hasMany('App\Models\Transaction');
    }

    public function tokens()
    {
        return $this->morphMany('App\Models\Token', 'accountable');
    }

    public function notifications()
    {
        return $this->morphMany('App\Models\Notification', 'notifiable');
    }

    public function getRestaurantDetailsAttribute()
    {
        $cityName = count($this->city) ? $this->city->name.':' : '';
        return $cityName.$this->name.' : '.$this->phone;
    }

    public function getRateAttribute($value)
    {
        $sumRating = $this->reviews()->sum('rate');
        $countRating = $this->reviews()->count();
        $avgRating = 0;
        if ($countRating > 0)
        {
            $avgRating = round($sumRating/$countRating,1);
        }
        return number_format($this->reviews()->avg('rate'), 0, '.', '');
    }

    public function scopeOrderByRating($query, $order = 'desc')
    {
        return $query->leftJoin('reviews', 'reviews.restaurant_id', '=', 'restaurants.id')
            ->groupBy('restaurants.id')
            ->addSelect(['*', \DB::raw('sum(rate) as sumRating')])
            ->orderBy('sumRating', $order);
    }

    public function scopeActivated($query)
    {
        return $query->where('activated',1);
    }

    public function getTotalOrdersAmountAttribute($value)
    {
        $commissions = $this->orders()->where('state','delivered')->sum('total');

        return $commissions;
    }

    public function getTotalCommissionsAttribute($value)
    {
        $commissions = $this->orders()->where('state','delivered')->sum('commission');

        return $commissions;
    }

    public function getTotalPaymentsAttribute($value)
    {
        $payments = $this->transactions()->sum('amount');

        return $payments;
    }

    public function getPhotoUrlAttribute($value)
    {
        return url($this->photo);
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