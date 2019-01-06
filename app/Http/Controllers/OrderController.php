<?php namespace App\Http\Controllers;

use App\Models\Order;
use App\User;
use Illuminate\Http\Request;
use App\Http\Requests;

class OrderController extends Controller {
    public function index(Request $request)
    {
        $order = Order::where(function($q) use($request){
            if ($request->has('order_id'))
            {
                $q->where('id',$request->order_id);
            }

            if ($request->has('restaurant_id'))
            {
                $q->where('restaurant_id',$request->restaurant_id);
            }

            if ($request->has('state'))
            {
                $q->where('state',$request->state);
            }

            if ($request->has('from') && $request->has('to'))
            {
                $q->whereDate('created_at' , '>=' , $request->from);
                $q->whereDate('created_at' , '<=' , $request->to);
            }

        })->with('restaurant')->latest()->paginate(20);
        return view('admin.orders.index',compact('order'));
    }

    public function show($id)
    {
        $order = Order::with('restaurant','items','client')->findOrFail($id);

        return view('admin.orders.show',compact('order'));
    }

    public function print_invoice($id){
        $order = Order::with('address','restaurant','items','reviews','qualities','user','options')->findOrFail($id);
        return view('layouts.print',compact('order'));
    }

    public function change()
    {

    }
    public function update(Request $request,$id)
    {
        $order = Order::findOrFail($id);
        $update = $order->update($request->all());

        $user = $order->user;

        if( $update ){
            if ($request->state == 'accepted')
            {
                $notificationData = [
                    'title' => 'تم تأكيد طلبك رقم '.$order->id,
                    'title_en' => 'Your Order #'.$order->id.' has been  accepted !',
                    'order_id' => $order->id
                ];
                $user->notifications()->create($notificationData);

                $audience = ['include_player_ids' => $user->tokens()->pluck('token')->toArray()];
                $contents = [
                    'en' => 'Your Order #'.$order->id.' has been  accepted !',
                    'ar' => 'تم تأكيد طلبك رقم '.$order->id,
                ];
                $data = ['order_id' => $order->id];
                notifyByOneSignal($audience,$contents,$data);
            }elseif($request->state == 'rejected'){
                $notificationData = [
                    'title' => 'تم رفض طلبك رقم '.$order->id,
                    'title_en' => 'Your Order #'.$order->id.' has been  rejected !',
                    'order_id' => $order->id
                ];
                $user->notifications()->create($notificationData);

                $audience = ['include_player_ids' => $user->tokens()->pluck('token')->toArray()];
                $contents = [
                    'en' => 'Your Order #'.$order->id.' has been  rejected !',
                    'ar' => 'تم رفض طلبك رقم '.$order->id,
                ];
                $data = ['order_id' => $order->id];
                notifyByOneSignal($audience,$contents,$data);
            }elseif ($request->state == 'canceled'){
                $notificationData = [
                    'title' => 'تم إلغاء طلبك رقم '.$order->id,
                    'title_en' => 'Your Order #'.$order->id.' has been canceled !',
                    'order_id' => $order->id
                ];
                $user->notifications()->create($notificationData);

                $audience = ['include_player_ids' =>$user->tokens()->pluck('token')->toArray()];
                $contents = [
                    'en' => 'Your Order #'.$order->id.' has been canceled !',
                    'ar' => 'تم إلغاء طلبك رقم '.$order->id,
                ];
                $data = ['order_id' => $order->id];
                notifyByOneSignal($audience,$contents,$data);
            }
            flash()->success('تم تعديل الحالة  بنجاح');
            return redirect('admin/order/'.$id);
        }
        return redirect('admin/order/'.$id);
    }

}



