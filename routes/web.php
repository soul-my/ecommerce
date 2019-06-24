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

Route::get('/', function () {
    return redirect()->route('store.index');
});


Route::get('/home', 'HomeController@index')->name('user.home');

Route::prefix('store')->name('store.')->group(function(){

    Route::get('/', 'User\Store\StoreController@index')->name('index');
    Route::get('/detail/{id}', 'User\Store\StoreController@show')->name('detail');
    Route::get('/terms-of-service', 'User\Store\StoreController@tos')->name('tos');

    Route::get('/login', 'User\Auth\LoginController@showLoginForm')->name('user.login');
    Route::post('login' , 'User\Auth\LoginController@login');
    Route::any('/logout', 'User\Auth\LoginController@logout')->name('user.logout');

    Route::get('/register', 'User\Auth\RegisterController@showRegistrationForm');
    Route::post('/register', 'User\Auth\RegisterController@register')->name('user.register');


    Route::prefix('cart')->name('cart.')->group(function(){

        Route::get('/{identifier}', 'User\Store\StoreController@showCart')->middleware('auth')->name('show');
        Route::post('/add-to-cart', 'User\Store\StoreController@addToCart')->middleware('auth')->name('add');
        Route::get('/remove-from-cart/{pro_id}', 'User\Store\StoreController@removeFromCart')->middleware('auth')->name('remove');

        Route::get('update/{product_id}/{quantity}', 'User\Store\StoreController@updateQuantity')->middleware('auth')->name('update');
    });

    Route::prefix('orders')->name('orders.')->group(function(){
        Route::get('/', 'User\Store\StoreController@myorders')->name('show');
        Route::get('cancel/{order_id}', 'User\Store\StoreController@cancelorder')->name('cancel');
        Route::get('complete/{order_id}', 'User\Store\StoreController@completeorder')->name('complete');

    });

    Route::prefix('invoice')->name('invoice.')->group(function(){
        Route::get('/{order_id}', 'User\Store\InvoiceController@invoice')->name('show');
    });

});