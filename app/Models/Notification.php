<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $table = 'notifications';
    public $timestamps = true;
    protected $fillable = array('title','content','title_en','content_en','order_id');

    public function order()
    {
        return $this->belongsTo('App\Models\Order');
    }

    public function notifiable()
    {
        return $this->morphTo();
    }
    
}
