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
Route::prefix('v1')->group(function(){
    Route::middleware('web')->get('login/{provider}', 'Auth\SocialController@redirectToProvider');
    Route::get('login/{provider}/callback','Auth\SocialController@handleProviderCallback');

    //User Auth
    Route::post('user/login', 'Api\User\Auth\LoginController@login');
    Route::post('user/register', 'Api\User\Auth\RegisterController@register');

    //Booking Route
    Route::post('trip/book', 'BookingController@book');

    //Admin Auth
    Route::post('driver/login', 'Api\Admin\Auth\LoginController@login');
    Route::post('driver/register', 'Api\Admin\Auth\RegisterController@register');

    Route::apiResource('drivers', 'DriverController');
    Route::apiResource('vehiclecategories', 'VehicleCategoryController'); 
    Route::apiResource('vehicles', 'VehicleController'); 
    Route::apiResource('trips', 'TripController');

    Route::middleware('auth:drivers')->get('/user', function (Request $request) {
        return $request->user();
    });
});
