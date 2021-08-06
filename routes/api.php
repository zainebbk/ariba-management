<?php

use App\Courier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::prefix('v1/courier')->group(function () {

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('show', 'API\Admin\CourierController@show');
        Route::get('logout', 'API\Admin\CourierController@logout');
        Route::get('orders', 'API\Admin\CourierController@orders');
        Route::get('orders/new', 'API\Admin\CourierController@orders_new');
        Route::get('orders/active', 'API\Admin\CourierController@orders_active');
        Route::get('orders/history', 'API\Admin\CourierController@orders_history');
        Route::get('orders/completed', 'API\Admin\CourierController@orders_completed');
        Route::get('orders/{orderID}/set_active', 'API\Admin\CourierController@set_active');
        Route::get('orders/{orderID}/set_completed', 'API\Admin\CourierController@set_completed');
        Route::get('tours', 'API\Admin\CourierController@tours');
    });
    
    Route::post('login', 'API\Admin\CourierController@login');
    // Route::post('courier/forgotPassword', 'API\Admin\CourierController@forgotPassword');
    Route::post('resetPassword', 'API\Admin\CourierController@resetPassword');
});
