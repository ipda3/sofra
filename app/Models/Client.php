<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Client extends Authenticatable {

	protected $table = 'clients';
	public $timestamps = true;
	protected $fillable = array('name', 'email', 'phone', 'address', 'password', 'region_id', 'api_token', 'code', 'profile_image');
	protected $appends = ['profile_path'];
	public function orders() {
		return $this->hasMany('App\Models\Order');
	}

	public function cart() {
		return $this->belongsToMany('App\Models\Item', 'carts')->withPivot('price', 'quantity', 'note', 'id');
	}

	public function region() {
		return $this->belongsTo('App\Models\Region');
	}

	public function tokens() {
		return $this->morphMany('App\Models\Token', 'accountable');
	}

	public function notifications() {
		return $this->morphMany('App\Models\Notification', 'notifiable');
	}

	function getProfilePathAttribute() {
		return asset($this->profile_image);
	}

	public static function boot() {
		parent::boot();
		static::deleted(function ($model) {
			if (file_exists($model->profile_image)) {
				unlink($model->profile_image);
			}

		});
	}

	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	protected $hidden = [
		'password', 'api_token', 'code',
	];

}