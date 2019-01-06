<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{

    protected $table = 'offers';
    public $timestamps = true;
    protected $fillable = array('name', 'description', 'price', 'starting_at', 'ending_at', 'photo', 'restaurant_id');
    protected $dates = ['starting_at','ending_at'];
    protected $appends = ['available','photo_url'];

    public function restaurant()
    {
        return $this->belongsTo('App\Models\Restaurant');
    }

    public function getAvailableAttribute($value)
    {
        $today = Carbon::now()->startOfDay();
        if ($this->starting_at->startOfDay() <= $today && $this->ending_at->endOfDay() >= $today)
        {
            return true;
        }
        return false;
    }

    public function getPhotoUrlAttribute($value)
    {
        return url($this->photo);
    }

}