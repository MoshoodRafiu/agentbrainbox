<?php

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'auth'], function (){
    Route::post('/register','AuthController@register');
    Route::post('/login','AuthController@login');
    Route::post('/logout','AuthController@logout');
});

Route::group(['prefix' => 'categories'], function (){
    Route::get('/','CategoryController@index');
    Route::post('/','CategoryController@store');
    Route::get('/{category}','CategoryController@show');
    Route::put('/{category}','CategoryController@update');
    Route::delete('/{category}','CategoryController@destroy');
});

Route::group(['prefix' => 'merchants'], function (){
    Route::get('/','MerchantController@index');
    Route::post('/','MerchantController@store');
    Route::get('/{merchant}','MerchantController@show');
    Route::put('/{merchant}','MerchantController@update');
    Route::delete('/{merchant}','MerchantController@destroy');
});

Route::group(['prefix' => 'products'], function (){
    Route::get('/','ProductController@index');
    Route::post('/','ProductController@store');
    Route::get('/{product}','ProductController@show');
    Route::put('/{product}','ProductController@update');
    Route::put('/{product}/media','ProductController@updateMedia');
    Route::delete('/{product}','ProductController@destroy');
});
