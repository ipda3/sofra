<?php

namespace App\Http\Controllers\Api\Client;

use App\Models\Client;
use App\Models\Guest;
use App\Models\Item;
use App\Models\Order;
use App\Models\Restaurant;
use DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MainController extends Controller
{
    public function addItemToCart(Request $request)
    {
        $validation = validator()->make($request->all(), [
            'item_id'  => 'required|exists:items,id',
            'quantity' => 'required',
        ]);

        if ($validation->fails()) {
            $data = $validation->errors();
            return responseJson(0, $validation->errors()->first(), $data);
        }

        $item = Item::find($request->item_id);
        $readyItem = [
            $item->id => [
                'quantity' => $request->quantity,
                'price'    => $item->price,
                'note'     => $request->note
            ]
        ];
        $request->user()->cart()->attach($readyItem);

        return responseJson(1, 'تم الاضافة');
    }

    public function deleteItemFromCart(Request $request)
    {
        $validation = validator()->make($request->all(), [
            'row_id' => 'required',
        ]);

        if ($validation->fails()) {
            $data = $validation->errors();
            return responseJson(0, $validation->errors()->first(), $data);
        }

//        $request->user()->cart()->detach($request->item_id);
        DB::table('carts')->where('id', $request->row_id)->delete();

        return responseJson(1, 'تم الحذف');
    }

    public function deleteAllCartItems(Request $request)
    {
        $request->user()->cart()->detach();
        return responseJson(1, 'تم الحذف');
    }

    public function updateCartItem(Request $request)
    {
        $validation = validator()->make($request->all(), [
            'row_id'   => 'required',
            'quantity' => 'required',
        ]);

        if ($validation->fails()) {
            $data = $validation->errors();
            return responseJson(0, $validation->errors()->first(), $data);
        }

        if ($request->quantity == 0) {
            DB::table('carts')
              ->where('client_id', $request->user()->id)
              ->where('id', $request->row_id)
              ->delete();
            return responseJson(1, 'تم حذف العنصر');
        }
        DB::table('carts')
          ->where('client_id', $request->user()->id)
          ->where('id', $request->row_id)
          ->update([
                       'quantity' => $request->quantity,
                       'note'     => $request->note,
                   ]);
        return responseJson(1, 'تم التحديث');
    }

    public function cartItems(Request $request)
    {
        $items = $request->user()->cart()->with('restaurant', 'restaurant.delivery_times')->get();
        return responseJson(1, '', $items);
    }

    public function newOrder(Request $request)
    {
//        return $request->all();
        $validation = validator()->make($request->all(), [
            'restaurant_id'     => 'required|exists:restaurants,id',
            'items'             => 'required|array',
            'items.*'           => 'required|exists:items,id',
            'quantities'        => 'required|array',
            'notes'             => 'required|array',
            'address'           => 'required',
            'payment_method_id' => 'required|exists:payment_methods,id',
            //            'need_delivery_at' => 'required|date_format:Y-m-d',// H:i:s
        ]);

        if ($validation->fails()) {
            $data = $validation->errors();
            return responseJson(0, $validation->errors()->first(), $data);
        }

        $restaurant = Restaurant::find($request->restaurant_id);

        // restaurant closed
        if ($restaurant->availability == 'closed') {
            return responseJson(0, 'عذرا المطعم غير متاح في الوقت الحالي');
        }

        // client
        // set defaults
        $order = $request->user()->orders()->create([
                'restaurant_id'     => $request->restaurant_id,
                'note'              => $request->note,
                'state'             => 'pending', // db default
                'address'           => $request->address,
                'payment_method_id' => $request->payment_method_id,
          ]);

        $cost = 0;
        $delivery_cost = $restaurant->delivery_cost;

        if ($request->has('items')) {
            $counter = 0;
            foreach ($request->items as $itemId) {
                $item = Item::find($itemId);
                $order->items()->attach([
                $itemId => [
                    'quantity' => $request->quantities[$counter],
                    'price'    => $item->price,
                    'note'     => $request->notes[$counter],
                ]
               ]);
                $cost += ($item->price * $request->quantities[$counter]);
                $counter++;
            }
        }

        // minimum charge
        if ($cost >= $restaurant->minimum_charger) {
            $total = $cost + $delivery_cost; // 200 SAR
            $commission = settings()->commission * $cost; // 20 SAR  // 10 // 0.1  // $total; edited to remove delivery cost from percent.
            $net = $total - settings()->commission;
            $update = $order->update([
                     'cost'          => $cost,
                     'delivery_cost' => $delivery_cost,
                     'total'         => $total,
                     'commission'    => $commission,
                     'net'           => $net,
                 ]);
            $request->user()->cart()->detach();
            //Notificatios

            $notification = $restaurant->notifications()->create([
                    'title' =>'لديك طلب جديد',
                    'content' =>$request->user()->name .  'لديك طلب جديد من العميل ',
                    'action' =>  'new-order',
                    'order_id' => $order->id,
            ]);
            $tokens = $restaurant->tokens()->where('token', '!=' ,'')->pluck('token')->toArray();
            //info("tokens result: " . json_encode($tokens));
            if(count($tokens))
            {
                public_path();
                $title = $notification->title;
                $content = $notification->content;
                $data =[
                    'order_id' => $order->id,
                    'user_type' => 'restaurant',
                ];
                $send = notifyByFirebase($title , $content , $tokens,$data);
                info("firebase result: " . $send);

            }


            /* notification */
            $data = [
                'order' => $order->fresh()->load('items','restaurant.region','restaurant.categories','client') // $order->fresh()  ->load (lazy eager loading) ->with('items')
            ];
            return responseJson(1, 'تم الطلب بنجاح', $data);
        } else {
            $order->items()->delete();
            $order->delete();
            return responseJson(0, 'الطلب لابد أن لا يكون أقل من ' . $restaurant->minimum_charger . ' ريال');
        }
    }

    public function newOrderByGuest(Request $request)
    {
        $validation = validator()->make($request->all(), [
            'restaurant_id'     => 'required',
            'items.*.item_id'   => 'required',
            'items.*.quantity'  => 'required',
            'payment_method_id' => 'required',
            //            'delivery_time_id' => 'required',
            //            'need_delivery_at' => 'required|date_format:Y-m-d',// H:i:s

            'name'    => 'required',
            'phone'   => 'required',
            'city_id' => 'required',
            'address' => 'required',
        ]);

        if ($validation->fails()) {
            $data = $validation->errors();
            return responseJson(0, $validation->errors()->first(), $data);
        }

        $restaurant = Restaurant::findOrFail($request->restaurant_id);

        if ($restaurant->availability == 'closed') {
            return responseJson(0, 'عذرا المطعم غير متاح في الوقت الحالي');
        }

        $guest = Guest::create($request->only(['name', 'phone', 'address', 'city_id']));
        $order = $guest->orders()->create([
              'restaurant_id'     => $request->restaurant_id,
              'note'              => $request->note,
              'state'             => 'pending',
              'address'           => $request->address,
              'payment_method_id' => $request->payment_method_id,
          ]);

        $cost = 0;
        $delivery_cost = $restaurant->delivery_cost;
        foreach ($request->items as $i) {
            $item = Item::findOrFail($i['item_id']);
            $readyItem = [
                $i['item_id'] => [
                    'quantity' => $i['quantity'],
                    'price'    => $item->price,
                    'note'     => (isset($i['note'])) ? $i['note'] : ''
                ]
            ];
            $order->items()->attach($readyItem);
            $cost += ($item->price * $i['quantity']);
        }
        if ($cost >= $restaurant->minimum_charger) {
            $total = $cost + $delivery_cost;
            $commission = settings()->commission * $cost;  //$total; as client requested.
            $net = $total - settings()->commission;
            $update = $order->update([
                 'cost'          => $cost,
                 'delivery_cost' => $delivery_cost,
                 'total'         => $total,
                 'commission'    => $commission,
                 'net'           => $net,
             ]);

            /* notification */
            $restaurant->notifications()->create([
                 'title'      => 'لديك طلب جديد',
                 'title_en'   => 'You have New order',
                 'content'    => 'لديك طلب جديد من العميل ' . $guest->name,
                 'content_en' => 'You have New order by client ' . $guest->name,
                 'order_id'   => $order->id,
             ]);

            $tokens = $restaurant->tokens()->where('token', '!=', '')->pluck('token')->toArray();
            $audience = ['include_player_ids' => $tokens];
            $contents = [
                'en' => 'You have New order by client ' . $guest->name,
                'ar' => 'لديك طلب جديد من العميل ' . $guest->name,
            ];
            $send = notifyByOneSignal($audience, $contents, [
                'user_type' => 'restaurant',
                'action'    => 'new-order',
                'order_id'  => $order->id,
            ]);
            $send = json_decode($send);
            /* notification */

            $data = [
                'order' => $order->load('items')
            ];
            return responseJson(1, 'تم الطلب بنجاح', $data);
        } else {
            $order->delete();
            return responseJson(0, 'الطلب لابد أن لا يكون أقل من ' . $restaurant->minimum_charger . ' ريال');
        }
    }

    public function myOrders(Request $request)
    {
        $orders = $request->user()->orders()->where(function ($order) use ($request) {
            if ($request->has('state') && $request->state == 'completed') {
                $order->where('state', '!=', 'pending');
            } elseif ($request->has('state') && $request->state == 'current') {
                $order->where('state', '=', 'pending');
            }
        })->with('items','restaurant.region','restaurant.categories','client')->latest()->paginate(20);
        return responseJson(1, 'تم التحميل', $orders);
    }

    public function showOrder(Request $request)
    {
        $order = Order::with('items','restaurant.region','restaurant.categories','client')->find($request->order_id);
        return responseJson(1, 'تم التحميل', $order);
    }

    public function latestOrder(Request $request)
    {
        $order = $request->user()->orders()
                         ->with('restaurant', 'items')
                         ->latest()
                         ->first();
        if ($order) {
            return responseJson(1, 'تم التحميل', $order);
        }
        return responseJson(0, 'لا يوجد');
    }

    public function confirmOrder(Request $request)
    {
        $order = $request->user()->orders()->find($request->order_id);
        //dd($order);
        if (!$order) {
            return responseJson(0, 'لا يمكن الحصول على البيانات');
        }
        if ($order->state != 'accepted') {
            return responseJson(0, 'لا يمكن تأكيد استلام الطلب ، لم يتم قبول الطلب');
        }
        /*if ($order->delivery_confirmed_by_client == 1) {
            return responseJson(1, 'تم تأكيد الاستلام');
        }*/
        $order->update(['state' => 'delivered']);
        $restaurant = $order->restaurant;
        $restaurant->notifications()->create([
                 'title'      => 'تم تأكيد توصيل طلبك من العميل',
                 'title_en'   => 'Your order is delivered to client',
                 'content'    => 'تم تأكيد التوصيل للطلب رقم ' . $request->order_id . ' للعميل',
                 'content_en' => 'Order no. ' . $request->order_id . ' is delivered to client',
                 'order_id'   => $request->order_id,
             ]);

        $tokens = $restaurant->tokens()->where('token', '!=', '')->pluck('token')->toArray();
        $audience = ['include_player_ids' => $tokens];
        $contents = [
            'en' => 'Order no. ' . $request->order_id . ' is delivered to client',
            'ar' => 'تم تأكيد التوصيل للطلب رقم ' . $request->order_id . ' للعميل',
        ];
        $send = notifyByOneSignal($audience, $contents, [
            'user_type' => 'restaurant',
            'action'    => 'confirm-order-delivery',
            'order_id'  => $request->order_id,
        ]);
        $send = json_decode($send);

        return responseJson(1, 'تم تأكيد الاستلام');
    }

    public function declineOrder(Request $request)
    {
        $order = $request->user()->orders()->find($request->order_id);
        if (!$order) {
            return responseJson(0, 'لا يمكن الحصول على البيانات');
        }
        if ($order->state != 'accepted') {
            return responseJson(0, 'لا يمكن رفض استلام الطلب ، لم يتم قبول الطلب');
        }
        if ($order->delivery_confirmed_by_client == -1) {
            return responseJson(1, 'تم رفض استلام الطلب');
        }
        $order->update(['state' => 'declined']);
        $restaurant = $order->restaurant;
        $restaurant->notifications()->create([
             'title'      => 'تم رفض توصيل طلبك من العميل',
             'title_en'   => 'Your order delivery is declined by client',
             'content'    => 'تم رفض التوصيل للطلب رقم ' . $request->order_id . ' للعميل',
             'content_en' => 'Delivery if order no. ' . $request->order_id . ' is declined by client',
             'order_id'   => $request->order_id,
         ]);

        $tokens = $restaurant->tokens()->where('token', '!=', '')->pluck('token')->toArray();
        $audience = ['include_player_ids' => $tokens];
        $contents = [
            'en' => 'Delivery if order no. ' . $request->order_id . ' is declined by client',
            'ar' => 'تم رفض التوصيل للطلب رقم ' . $request->order_id . ' للعميل',
        ];
        $send = notifyByOneSignal($audience, $contents, [
            'user_type' => 'restaurant',
            'action'    => 'decline-order-delivery',
            'order_id'  => $request->order_id,
        ]);
        $send = json_decode($send);

        return responseJson(1, 'تم رفض استلام الطلب');
    }

    public function review(Request $request)
    {
        $validation = validator()->make($request->all(), [
            'rate'          => 'required',
            'comment'       => 'required',
            'restaurant_id' => 'required|exists:restaurants,id',

        ]);
        if ($validation->fails()) {
            return responseJson(0, $validation->errors()->first(), $validation->errors());
        }

        $restaurant = Restaurant::find($request->restaurant_id);
        if (!$restaurant) {
            return responseJson(0, 'لا يمكن الحصول على البيانات');
        }
        $request->merge(['client_id' => $request->user()->id]);
        $clientOrdersCount = $request->user()->orders()
                                     ->where('restaurant_id', $restaurant->id)
                                     ->where('state', 'accepted')
                                     ->count();
        if ($clientOrdersCount == 0) {
            return responseJson(0, 'لا يمكن التقييم الا بعد تنفيذ طلب من المطعم');
        }
        $checkOrder = $request->user()->orders()
                              ->where('restaurant_id', $restaurant)
                              ->where('state', 'accepted')
                              ->count();
        if ($checkOrder > 0) {
            return responseJson(0, 'لا يمكن التقييم الا بعد بيان حالة استلام الطلب');
        }
        $review = $restaurant->reviews()->create($request->all());
        return responseJson(1, 'تم التقييم بنجاح', [
            'review' => $review->load('client','restaurant')
        ]);

    }

    public function notifications(Request $request)
    {
        $notifications = $request->user()->notifications()->with('notifiable.region','order.client.region','order.restaurant.region')->latest()->paginate(20);
        return responseJson(1, 'تم التحميل', $notifications);
    }
}