<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// REDIRECCION
Route::get('verify/{tipo}/{token}','AdminController@verify');

// ADMINISTRACION
Route::get('/correos/{token}', 'AdminController@index');
Route::get('/edit/{id}', 'AdminController@edit');
Route::post('correos/store', 'AdminController@store');
Route::get('correos/edit/{id}', 'AdminController@editCorreo');
Route::get('correosPDF/{id}/{idioma}', 'AdminController@donwloadPDF');

// ADMINISTRACION CUPONES
Route::get('cupones/{token}', 'CouponController@index');
Route::post('cupones/store', 'CouponController@store');
Route::get('cupones/edit/{id}', 'CouponController@edit');
Route::get('cupones/delete/{id}', 'CouponController@destroy');

// ADMINISTRACION PAGOS
Route::get('pagos/{token}', 'PaymentController@index');
Route::post('pagos/store', 'PaymentController@store');
Route::get('pagos/edit/{id}', 'PaymentController@edit');

// PRUEBAS
Route::get('email', 'EmailController@sendEmail');
