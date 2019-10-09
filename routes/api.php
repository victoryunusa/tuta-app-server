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

    //Unauthorized
    Route::get('unauthorized', function() {
        return response()->json([
            'status' => 'error',
            'message' => 'Unauthorized'
        ], 401);
    })->name('api.jwt.unauthorized');

    //User Auth
    Route::post('user/login', 'Api\User\Auth\LoginController@login');
    Route::post('user/register', 'Api\User\Auth\RegisterController@register');

    //Admin Auth
    Route::post('driver/login', 'Api\Admin\Auth\LoginController@login');
    Route::post('driver/register', 'Api\Admin\Auth\RegisterController@register');
    Route::post('driver/logout', 'Api\Admin\Auth\LoginController@logout');

    Route::middleware(['auth:drivers'])->group(function () {

        Route::apiResource('drivers', 'DriverController');
        Route::apiResource('vehiclecategories', 'VehicleCategoryController'); 
        Route::apiResource('vehicles', 'VehicleController'); 
        Route::apiResource('trips', 'TripController');
    });

    Route::middleware(['auth:users'])->group(function () {
        //Booking Route
        Route::post('trip/book', 'BookingController@book');
        Route::get('users/{id}/trips', 'User\TripsController@index');

    });


        /* Route::middleware('auth:drivers')->get('/user', function (Request $request) {
            return $request->user();
        }); */
});
