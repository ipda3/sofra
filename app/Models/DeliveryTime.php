<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class DeliveryTime extends Model {

	protected $table = 'delivery_times';
	public $timestamps = true;
	protected $fillable = array('from','to');

    public function getFromAttribute($value)
    {
        $from = Carbon::createFromFormat('H:i:s',$value);
        $text = $from->format('g:i A');
        $replace = str_replace('AM','ص',$text);
        $replace = str_replace('PM','م',$replace);
        return $replace;
	}

    public function getToAttribute($value)
    {
        $to = Carbon::createFromFormat('H:i:s',$value);
        $text = $to->format('g:i A');
        $replace = str_replace('AM','ص',$text);
        $replace = str_replace('PM','م',$replace);
        return $replace;
    }

}