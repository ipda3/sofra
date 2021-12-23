<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');

Route::group(['prefix' =>'v1'],function(){
    // general
    Route::get('categories','Api\MainController@categories');
    Route::get('cities','Api\MainController@cities');
    Route::get('regions','Api\MainController@regions');
    Route::get('cities-not-paginated','Api\MainController@citiesNotPaginated');
    Route::get('regions-not-paginated','Api\MainController@regionsNotPaginated');
    Route::get('regions_ajax','Api\MainController@ajax_region');
    Route::get('delivery-methods','Api\MainController@deliveryMethods');
    Route::get('delivery-times','Api\MainController@deliveryTimes');
    Route::get('payment-methods','Api\MainController@paymentMethods');

    Route::get('restaurants','Api\MainController@restaurants');
    Route::get('restaurant','Api\MainController@restaurant');
    Route::get('items','Api\MainController@items');
    Route::get('restaurant/reviews','Api\MainController@reviews');
    Route::get('offers','Api\MainController@offers');
    Route::get('offer','Api\MainController@offer');
    Route::post('contact','Api\MainController@contact');

    Route::get('settings','Api\MainController@settings');

    // test notification
    Route::post('test-notification','Api\MainController@testNotification');
    Route::post('test-pusher','Api\MainController@testPusher');

    Route::post('guest/new-order','Api\Client\MainController@newOrderByGuest');

    Route::group(['prefix' =>'client','namespace' => 'Api\Client'],function(){
        Route::post('register', 'AuthController@register');
        Route::post('login', 'AuthController@login');
        Route::post('profile', 'AuthController@profile');
        Route::post('reset-password', 'AuthController@reset');
        Route::post('new-password', 'AuthController@password');

        Route::group(['middleware'=>'auth:client'],function(){
            // $request->user()
            Route::post('profile', 'AuthController@profile');
            Route::post('register-token', 'AuthController@registerToken');
            Route::post('remove-token', 'AuthController@removeToken');
//            Route::post('add-item-to-cart','MainController@addItemToCart');
//            Route::post('delete-item-from-cart','MainController@deleteItemFromCart');
//            Route::post('delete-all-cart-items','MainController@deleteAllCartItems');
//            Route::post('update-cart-item','MainController@updateCartItem');
//            Route::get('get-cart-items','MainController@cartItems');
            Route::post('new-order','MainController@newOrder');
            Route::get('my-orders','MainController@myOrders');
            Route::get('show-order','MainController@showOrder');
//            Route::get('latest-order','MainController@latestOrder');
            Route::post('confirm-order','MainController@confirmOrder');
            Route::post('decline-order','MainController@declineOrder');

            Route::post('restaurant/review','Api\Client\MainController@review');
            Route::get('notifications','Api\Client\MainController@notifications');
        });
    });

    Route::group(['prefix' =>'restaurant','namespace' => 'Api\Restaurant'],function(){

        Route::post('register', 'AuthController@register');
        Route::post('login', 'AuthController@login');
        Route::post('profile', 'AuthController@profile');
        Route::post('reset-password', 'AuthController@reset');
        Route::post('new-password', 'AuthController@password');

        Route::group(['middleware'=>'auth:restaurant'],function(){
            Route::post('profile', 'AuthController@profile')->middleware('check-commissions');
            Route::post('register-token', 'AuthController@registerToken');
            Route::post('remove-token', 'AuthController@removeToken');

            Route::get('my-items','MainController@myItems');
            Route::post('new-item','MainController@newItem')->middleware('check-commissions');
            Route::post('update-item','MainController@updateItem')->middleware('check-commissions');
            Route::post('delete-item','MainController@deleteItem')->middleware('check-commissions');

            Route::get('my-offers','MainController@myOffers');
            Route::post('new-offer','MainController@newOffer')->middleware('check-commissions');
            Route::post('update-offer','MainController@updateOffer')->middleware('check-commissions');
            Route::post('delete-offer','MainController@deleteOffer')->middleware('check-commissions');

            Route::get('my-orders','MainController@myOrders');
            Route::get('show-order','MainController@showOrder');
            Route::post('confirm-order','MainController@confirmOrder')->middleware('check-commissions');
            Route::post('accept-order','MainController@acceptOrder')->middleware('check-commissions');
            Route::post('reject-order','MainController@rejectOrder')->middleware('check-commissions');
            Route::get('notifications','MainController@notifications');
            Route::post('change-state','MainController@changeState')->middleware('check-commissions');
            
            Route::get('commissions','MainController@commissions');
        });
    });
});
