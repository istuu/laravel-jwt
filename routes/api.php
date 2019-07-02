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

// Veryfy
Route::group([
    'middleware' => 'api',
    'prefix' => 'v1'
], function () {
    Route::post('transaction', 'TransactionController@transaction');
    Route::get('transaction/check', 'TransactionController@check');
    Route::get('transaction/history', 'TransactionController@history');
});


Route::group([
    'middleware' => 'api',
    'prefix' => 'v1/auth'
], function ($router) {

    Route::post('login', 'AuthController@login')->name('login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');
});
