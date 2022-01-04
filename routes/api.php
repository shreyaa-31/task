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



Route::post('register', 'API\RegistrationController@register');
Route::get('details', 'API\RegistrationController@details');
Route::post('verify_api_otp', 'API\RegistrationController@verify_otp');
Route::post('login', 'API\RegistrationController@login');

Route::post('forget-password', 'API\RegistrationController@email_verify');
Route::post('reset-password', 'API\RegistrationController@reset_password');

Route::middleware('auth:api')->group(function () {
    

    Route::get('listing', 'API\ProductController@index');

    Route::post('store', 'API\ProductController@store');
    Route::delete('delete/{id}', 'API\ProductController@destroy');

    Route::delete('delete-user/{id}', 'API\RegistrationController@delete');
    Route::get('get-user/{id}', 'API\RegistrationController@show');
    Route::post('update-user', 'API\RegistrationController@update');
    Route::post('update', 'API\ProductController@update');

    // Route::get('get-user-data/{id}', 'API\RegistrationController@edit');
});
