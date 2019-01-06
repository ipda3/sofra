<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model {

	protected $table = 'items';
	public $timestamps = true;
	protected $fillable = array('name', 'description', 'price', 'preparing_time', 'photo','disabled');
    protected $appends = ['photo_url'];

	public function orders()
	{
		return $this->belongsToMany('App\Models\Order');
	}

    public function restaurant()
    {
        return $this->belongsTo('App\Models\Restaurant');
	}

    public function scopeEnabled($q)
    {
        return $q->where('disabled',0);
	}

    public function getPhotoUrlAttribute($value)
    {
        return url($this->photo);
    }

	protected $hidden = ['disabled'];

}