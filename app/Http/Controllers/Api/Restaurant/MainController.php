<?php

namespace App\Http\Controllers\Api\Restaurant;

use App\Models\Client;
use App\Models\Item;
use App\Models\Offer;
use App\Models\Order;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MainController extends Controller
{
    public function myItems(Request $request)
    {
        $item = $request->user()->items()->enabled()->latest()->paginate(20);
        return responseJson(1,'تم التحميل',$item);
    }

    public function newItem(Request $request)
    {
        $validation = validator()->make($request->all(), [
            'name' => 'required',
            'price' => 'required|numeric',
            'preparing_time' => 'required',
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif,bmp,svg|max:2048',
        ]);

        if ($validation->fails()) {
            $data = $validation->errors();
            return responseJson(0,$validation->errors()->first(),$data);
        }

        $item = $request->user()->items()->create($request->all());
        if ($request->hasFile('photo')) {
            $path = public_path();
            $destinationPath = $path . '/uploads/items/'; // upload path
            $photo = $request->file('photo');
            $extension = $photo->getClientOriginalExtension(); // getting image extension
            $name = time() . '' . rand(11111, 99999) . '.' . $extension; // renameing image
            $photo->move($destinationPath, $name); // uploading file to given path
            $item->update(['photo' => 'uploads/items/' . $name]);
        }

        return responseJson(1,'تم الاضافة بنجاح',$item);
    }

    public function updateItem(Request $request)
    {
        $validation = validator()->make($request->all(), [
            'name' => 'required',
            'price' => 'required|numeric',
            'preparing_time' => 'required',
        ]);

        if ($validation->fails()) {
            $data = $validation->errors();
            return responseJson(0,$validation->errors()->first(),$data);
        }

        $item = $request->user()->items()->find($request->item_id);
        if (!$item)
        {
            return responseJson(0,'لا يمكن الحصول على البيانات');
        }
        $item->update($request->all());
        if ($request->hasFile('photo')) {
            $path = public_path();
            $destinationPath = $path . '/uploads/items/'; // upload path
            $photo = $request->file('photo');
            $extension = $photo->getClientOriginalExtension(); // getting image extension
            $name = time() . '' . rand(11111, 99999) . '.' . $extension; // renameing image
            $photo->move($destinationPath, $name); // uploading file to given path
            $item->update(['photo' => 'uploads/items/' . $name]);
        }

        return responseJson(1,'تم التعديل بنجاح',$item);
    }

    public function deleteItem(Request $request)
    {
        $item = $request->user()->items()->find($request->item_id);
        if (!$item)
        {
            return responseJson(0,'لا يمكن الحصول على البيانات');
        }
        if (count($item->orders) > 0)
        {
            $item->update(['disabled' => 1]);
            return responseJson(1,'تم الحذف بنجاح');
//            return responseJson(0,'لا يمكن مسح الصنف ، يوجد طلبات مرتبطة به');
        }

        $item->delete();
        return responseJson(1,'تم الحذف بنجاح');
    }

    public function myOrders(Request $request)
    {
        $orders = $request->user()->orders()->where(function($order) use($request){
            if ($request->has('state') && $request->state == 'completed')
            {
                $order->where('state' , '!=' , 'pending');
            }elseif ($request->has('state') && $request->state == 'current')
            {
                $order->where('state' , '=' , 'accepted');
            }elseif ($request->has('state') && $request->state == 'pending')
            {
                $order->where('state' , '=' , 'pending');
            }
        })->with('client','items','restaurant')->latest()->paginate(20);
        return responseJson(1,'تم التحميل',$orders);
    }

    public function showOrder(Request $request)
    {
        $order= Order::with('items','client','restaurant')->find($request->order_id);
        return responseJson(1,'تم التحميل',$order);
    }

    public function acceptOrder(Request $request)
    {
        $order= $request->user()->orders()->find($request->order_id);
        if (!$order)
        {
            return responseJson(0,'لا يمكن الحصول على بيانات الطلب');
        }
        if ($order->state == 'accepted')
        {
            return responseJson(1,'تم قبول الطلب');
        }
        $order->update(['state' => 'accepted']);
        $client = $order->client;
        $client->notifications()->create([
            'title' => 'تم قبول طلبك',
            'title_en' => 'Your order is accepted',
            'content' => 'تم قبول الطلب رقم '.$request->order_id,
            'content_en' => 'Order no. '.$request->order_id.' is accepted',
            'order_id' => $request->order_id,
        ]);

        $tokens = $client->tokens()->where('token','!=','')->pluck('token')->toArray();
        $audience = ['include_player_ids' => $tokens];
        $contents = [
            'en' => 'Order no. '.$request->order_id.' is accepted',
            'ar' => 'تم قبول الطلب رقم '.$request->order_id,
        ];
        $send = notifyByOneSignal($audience , $contents , [
            'user_type' => 'client',
            'action' => 'accept-order',
            'order_id' => $request->order_id,
            'restaurant_id' => $request->user()->id,
        ]);
        $send = json_decode($send);
        return responseJson(1,'تم قبول الطلب');
    }

    public function rejectOrder(Request $request)
    {
        $order= $request->user()->orders()->find($request->order_id);
        if (!$order)
        {
            return responseJson(0,'لا يمكن الحصول على بيانات الطلب');
        }
        if ($order->state == 'rejected')
        {
            return responseJson(1,'تم رفض الطلب');
        }
        $order->update(['state' => 'rejected']);
        $client = $order->client;
        $client->notifications()->create([
            'title' => 'تم رفض طلبك',
            'title_en' => 'Your order is rejected',
            'content' => 'تم رفض الطلب رقم '.$request->order_id,
            'content_en' => 'Order no. '.$request->order_id.' is rejected',
            'order_id' => $request->order_id,
        ]);

        $tokens = $client->tokens()->where('token','!=','')->pluck('token')->toArray();
        $audience = ['include_player_ids' => $tokens];
        $contents = [
            'en' => 'Order no. '.$request->order_id.' is rejected',
            'ar' => 'تم رفض الطلب رقم '.$request->order_id,
        ];
        $send = notifyByOneSignal($audience , $contents , [
            'user_type' => 'client',
            'action' => 'reject-order',
            'order_id' => $request->order_id,
            'restaurant_id' => $request->user()->id,
        ]);
        $send = json_decode($send);
        return responseJson(1,'تم رفض الطلب');
    }

    public function confirmOrder(Request $request)
    {
        $order = $request->user()->orders()->find($request->order_id);
        if (!$order)
        {
            return responseJson(0,'لا يمكن الحصول على بيانات الطلب');
        }
        if ($order->state != 'accepted')
        {
            return responseJson(0,'لا يمكن تأكيد الطلب ، لم يتم قبول الطلب');
        }
        $order->update(['state' => 'delivered']);
        $client = $order->client;
        $client->notifications()->create([
            'title' => 'تم تأكيد توصيل طلبك',
            'title_en' => 'Your order is delivered',
            'content' => 'تم تأكيد التوصيل للطلب رقم '.$request->order_id,
            'content_en' => 'Order no. '.$request->order_id.' is delivered to you',
            'order_id' => $request->order_id,
        ]);

        $tokens = $client->tokens()->where('token','!=','')->pluck('token')->toArray();
        $audience = ['include_player_ids' => $tokens];
        $contents = [
            'en' => 'Order no. '.$request->order_id.' is delivered to you',
            'ar' => 'تم تأكيد التوصيل للطلب رقم '.$request->order_id,
        ];
        $send = notifyByOneSignal($audience , $contents , [
            'user_type' => 'client',
            'action' => 'confirm-order-delivery',
            'order_id' => $request->order_id,
            'restaurant_id' => $request->user()->id,
        ]);
        $send = json_decode($send);
        return responseJson(1,'تم تأكيد الاستلام');
    }

    public function myOffers(Request $request)
    {
        $offers = $request->user()->offers()->with('restaurant')->latest()->paginate(20);
        return responseJson(1,'',$offers);
    }

    public function newoffer(Request $request)
    {
        $validation = validator()->make($request->all(), [
            'name' => 'required',
            'price' => 'required|numeric',
            'starting_at' => 'required|date_format:Y-m-d',
            'ending_at' => 'required|date_format:Y-m-d',
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif,bmp,svg|max:2048',
        ]);

        if ($validation->fails()) {
            $data = $validation->errors();
            return responseJson(0,$validation->errors()->first(),$data);
        }

        $offer = $request->user()->offers()->create($request->all());
        if ($request->hasFile('photo')) {
            $path = public_path();
            $destinationPath = $path . '/uploads/offes/'; // upload path
            $photo = $request->file('photo');
            $extension = $photo->getClientOriginalExtension(); // getting image extension
            $name = time() . '' . rand(11111, 99999) . '.' . $extension; // renameing image
            $photo->move($destinationPath, $name); // uploading file to given path
            $offer->update(['photo' => 'uploads/offes/' . $name]);
        }

        return responseJson(1,'تم الاضافة بنجاح',$offer);
    }

    public function updateOffer(Request $request)
    {
        $validation = validator()->make($request->all(), [
            'name' => 'required',
            'price' => 'required|numeric',
            'starting_at' => 'required|date_format:Y-m-d',
            'ending_at' => 'required|date_format:Y-m-d',
        ]);

        if ($validation->fails()) {
            $data = $validation->errors();
            return responseJson(0,$validation->errors()->first(),$data);
        }

        $offer = $request->user()->offers()->find($request->offer_id);
        if (!$offer)
        {
            return responseJson(0,'لا يمكن الحصول على البيانات');
        }
        $offer->update($request->all());
        if ($request->hasFile('photo')) {
            $path = public_path();
            $destinationPath = $path . '/uploads/offers/'; // upload path
            $photo = $request->file('photo');
            $extension = $photo->getClientOriginalExtension(); // getting image extension
            $name = time() . '' . rand(11111, 99999) . '.' . $extension; // renameing image
            $photo->move($destinationPath, $name); // uploading file to given path
            $offer->update(['photo' => 'uploads/offers/' . $name]);
        }

        return responseJson(1,'تم التعديل بنجاح',$offer);
    }

    public function deleteOffer(Request $request)
    {
        $offer = $request->user()->offers()->find($request->offer_id);
        if (!$offer)
        {
            return responseJson(0,'لا يمكن الحصول على البيانات');
        }
        $offer->delete();
        return responseJson(1,'تم الحذف بنجاح');
    }

    public function notifications(Request $request)
    {
        $notifications = $request->user()->notifications()->latest()->paginate(20);
        return responseJson(1,'تم التحميل',$notifications);
    }

    public function changeState(Request $request)
    {
        $validation = validator()->make($request->all(), [
            'state' => 'required|in:open,closed'
        ]);

        if ($validation->fails()) {
            $data = $validation->errors();
            return responseJson(0,$validation->errors()->first(),$data);
        }

        $request->user()->update(['availability' => $request->state]);

        return responseJson(1,'',$request->user());

    }

    public function commissions(Request $request)
    {
        $count = $request->user()->orders()->where('state','accepted')->where(function($q){
            $q->where('state','delivered');
        })->count();

        $total = $request->user()->orders()->where('state','accepted')->where(function($q){
            $q->where('state','delivered');
        })->sum('total');

        $commissions = $request->user()->orders()->where('state','accepted')->where(function($q){
            $q->where('state','delivered');
        })->sum('commission');

        $payments = $request->user()->transactions()->sum('amount');

        $net_commissions = $commissions - $payments;

        $commission = settings()->commission;

        return responseJson(1,'',compact('count','total','commissions','payments','net_commissions','commission'));
    }
}
