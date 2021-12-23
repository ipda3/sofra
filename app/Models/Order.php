<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{

    protected $table = 'orders';
    public $timestamps = true;
    protected $dates = ['need_delivery_at'];
    protected $fillable = array(
        'note', 'address', 'payment_method_id', 'cost', 'delivery_cost', 'total', 'commission','net', 'need_delivery_at',
        'delivery_time_id','restaurant_id', 'delivered_at', 'state','client_id'
    );

    public function delivery_time()
    {
        return $this->belongsTo('App\Models\DeliveryTime');
    }

    public function client()
    {
        return $this->belongsTo('App\Models\Client');
    }

    public function items()
{
    return $this->belongsToMany('App\Models\Item')->withPivot('price', 'quantity', 'note');
}

    public function restaurant()
    {
        return $this->belongsTo('App\Models\Restaurant');
    }

    public function payment_method()
    {
        return $this->belongsTo('App\Models\PaymentMethod');
    }

    public function getNeedDeliveryAtAttribute($value)
    {
        $datetime = Carbon::parse($value);
        if (count($this->delivery_time))
        {
            return $datetime->format('Y-m-d').' '.$this->delivery_time->from;
        }
        return $datetime->format('Y-m-d');
    }

    public function getStateTextAttribute($value)
    {
        $states = [
            'pending' => 'قيد التنفيذ',
            'accepted' => 'تم تأكيد الطلب',
            'rejected' => ' تم رفض الطلب',
        ];

        if (isset($states[$this->state])) {
            return $states[$this->state];
        }
        return "";
    }

}