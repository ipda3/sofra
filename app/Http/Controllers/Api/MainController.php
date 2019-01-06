<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Addon;
use App\Models\Category;
use App\Models\City;
use App\Models\Contact;
use App\Models\DeliveryMethod;
use App\Models\DeliveryTime;
use App\Models\Item;
use App\Models\Offer;
use App\Models\Order;
use App\Models\PaymentMethod;
use App\Models\Region;
use App\Models\Restaurant;
use App\Models\Section;
use DB;
use Illuminate\Http\Request;
use Log;

class MainController extends Controller
{
    public function cities(Request $request)
    {
        $cities = City::where(function($q) use($request){
            if ($request->has('name')){
                $q->where('name','LIKE','%'.$request->name.'%');
            }
        })->paginate(10);
        return responseJson(1,'تم التحميل',$cities);
    }

    public function regions(Request $request)
    {
        $regions = Region::where(function($q) use($request){
            if ($request->has('name')){
                $q->where('name','LIKE','%'.$request->name.'%');
            }
        })->where('city_id',$request->city_id)->paginate(10);
        return responseJson(1,'تم التحميل',$regions);
    }

    public function citiesNotPaginated(Request $request)
    {
        $cities = City::where(function($q) use($request){
            if ($request->has('name')){
                $q->where('name','LIKE','%'.$request->name.'%');
            }
        })->get();
        return responseJson(1,'تم التحميل',$cities);
    }

    public function regionsNotPaginated(Request $request)
    {
        $regions = Region::where(function($q) use($request){
            if ($request->has('name')){
                $q->where('name','LIKE','%'.$request->name.'%');
            }
        })->where('city_id',$request->city_id)->get();
        return responseJson(1,'تم التحميل',$regions);
    }

    public function ajax_region(Request $request)
    {
        $regions = Region::where('city_id',$request->city_id)->get();
        return responseJson(1,'تم التحميل',$regions);
    }
    
    public function categories()
    {
        $categories = Category::all();
        return responseJson(1,'تم التحميل',$categories);
    }

    public function paymentMethods()
    {
        $methods = PaymentMethod::all();
        return responseJson(1,'تم التحميل',$methods);
    }

    /**
     * @param Request $request
     * @return mixed
     * @todo filter by nearest using location sent from user
     *
     *
     */
    public function restaurants(Request $request)
    {
        $restaurants = Restaurant::where(function($q) use($request) {
            if ($request->has('keyword'))
            {
                $q->where(function($q2) use($request){
                    $q2->where('name','LIKE','%'.$request->keyword.'%');
                });
            }

            if ($request->has('region_id'))
            {
                $q->where('region_id',$request->region_id);
            }

            if ($request->has('categories'))
            {
                $q->whereHas('categories',function($q2) use($request){
                    $q2->whereIn('categories.id',$request->categories);
                });
            }

            if ($request->has('availability'))
            {
                $q->where('availability',$request->availability);
            }


        })->has('items')->with('region', 'categories')->activated()->paginate(10);
        return responseJson(1,'تم التحميل',$restaurants);
        /*
         *->orderByRating()
         * ->sortByDesc(function ($restaurant) {
            return $restaurant->reviews->sum('rate');
        })
         * */

    }

    public function restaurant(Request $request)
    {
        $restaurant = Restaurant::with('region','categories')->activated()->findOrFail($request->restaurant_id);

        return responseJson(1,'تم التحميل',$restaurant);

    }

    public function items(Request $request)
    {
        $items = Item::where('restaurant_id',$request->restaurant_id)->enabled()->paginate(20);
        return responseJson(1,'تم التحميل',$items);
    }

    public function offers(Request $request)
    {
        $offers = Offer::where(function($offer) use($request){
            if($request->has('restaurant_id'))
            {
                $offer->where('restaurant_id',$request->restaurant_id);
            }
        })->has('restaurant')->with('restaurant')->latest()->paginate(20);
        return responseJson(1,'',$offers);
    }

    public function offer(Request $request)
    {
        $offer = Offer::with('restaurant')->find($request->offer_id);
        if (!$offer)
        {
            return responseJson(0,'no data');
        }
        return responseJson(1,'',$offer);
    }
    

    public function reviews(Request $request)
    {
        $restuarant = Restaurant::find($request->restaurant_id);
        if (!$restuarant)
        {
            return responseJson(0,'no data');
        }
        $reviews = $restuarant->reviews()->paginate(10);
        return responseJson(1,'',$reviews);
        
    }

    public function notifications(Request $request)
    {
        $notifications = $request->user()->notifications()->with('order')->latest()->paginate(20);
        return responseJson(1,'',$notifications);
    }

    public function testNotification(Request $request)
    {
//        $audience = ['included_segments' => array('All')];
//        if ($request->has('ids'))
//        {
//            $audience = ['include_player_ids' => (array)$request->ids];
//        }
//        $contents = ['en' => $request->title];
//        Log::info('test notification');
//        Log::info(json_encode($audience));
//        $send = notifyByOneSignal($audience , $contents , $request->data);
//        Log::info($send);

        /*
        firebase
        */
        $tokens = $request->ids;
        $title = $request->title;
        $body = $request->body;
        $data = Order::first();
        $send = notifyByFirebase($title, $body, $tokens, $data, true);
        info("firebase result: " . $send);

        return response()->json([
            'status' => 1,
            'msg' => 'تم الارسال بنجاح',
            'send' => json_decode($send)
        ]);
    }

    public function testPusher(Request $request)
    {
        $data = 'طلب جديد ';
        $data .= '#'.$request->order_id.' ';
        $data .= 'من مطعم ';
        $data .= 'همذان';
        return pusher('dashboard_channel','new_order',$data);
    }

    public function contact(Request $request)
    {
        $validation = validator()->make($request->all(), [
            'type' => 'required|in:complaint,suggestion,inquiry',
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'content' => 'required'
        ]);

        if ($validation->fails()) {
            $data = $validation->errors();
            return responseJson(0,$validation->errors()->first(),$data);
        }

        Contact::create($request->all());

        return responseJson(1,'تم الارسال بنجاح');
    }

    public function settings()
    {
        return responseJson(1,'',settings());
    }
}