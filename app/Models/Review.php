<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{

    protected $table = 'reviews';
    public $timestamps = true;
    protected $fillable = array('comment', 'rate', 'restaurant_id', 'client_id');
    protected $with = ['client', 'restaurant'];

    public function restaurant()
    {
        return $this->belongsTo('App\Models\Restaurant');
    }

    public function client()
    {
        return $this->belongsTo('App\Models\Client');
    }

}