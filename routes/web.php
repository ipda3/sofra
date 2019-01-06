<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

// front end routes
//Route::get('/', 'FrontController@index');

Route::get('/',function(){
    return redirect()->to('/admin');
});

Auth::routes();

Route::get('/run', 'MainController@index');
Route::get('/home', 'HomeController@index');

// admin routes
Route::group(['middleware'=>'auth' , 'prefix' => 'admin'],function(){
    Route::get('/','HomeController@index');
    Route::resource('city', 'CityController');
    Route::resource('region', 'RegionController');
    Route::resource('category', 'CategoryController');
    Route::resource('offer', 'OfferController');
    Route::get('restaurant/{id}/activate', 'RestaurantController@activate');
    Route::get('restaurant/{id}/de-activate', 'RestaurantController@deActivate');
    Route::resource('restaurant','RestaurantController');
    Route::resource('{restaurant}/item', 'ItemController');
    Route::resource('order','OrderController');
    Route::resource('transaction','TransactionController');
//    Route::resource('page','PageController');
    Route::resource('payment-method','PaymentMethodController');
    Route::resource('delivery-method','DeliveryMethodController');
    Route::resource('contact','ContactController');
    Route::resource('client','ClientController');

    Route::get('settings','SettingsController@view');
    Route::post('settings','SettingsController@update');
    
    // user reset
    Route::get('user/change-password','UserController@changePassword');
    Route::post('user/change-password','UserController@changePasswordSave');
//    Route::resource('user','UserController');
//    Route::resource('role','RoleController');
});
