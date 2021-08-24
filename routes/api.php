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

Route::post('/login', 'Api\AuthController@login');

Route::middleware('auth:api')->group(function(){
    Route::get('user', 'Api\AuthController@user');
    Route::post('companies', 'Api\CompanyController@store');
    Route::put('companies/{id}', 'Api\CompanyController@update');
    Route::delete('companies/{id}', 'Api\CompanyController@destroy');

    Route::post('invoices', 'Api\InvoiceController@store');
    Route::put('invoices/{id}', 'Api\InvoiceController@update');
});
