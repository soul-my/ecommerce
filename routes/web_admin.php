<?php

    Route::prefix('admin')->name('admin.')->group(function(){

        Route::get('/login', 'Admin\Auth\LoginController@showLoginForm')->name('login');
        Route::post('login' , 'Admin\Auth\LoginController@login');

        // Route::get('/register', 'Admin\Auth\RegisterController@showRegistrationForm');
        // Route::post('/register', 'Admin\Auth\RegisterController@register')->name('register');

        Route::group(['middleware' => 'admin'], function(){
            Route::get('/', function(){
                return redirect()->route('admin.dashboard');
            });

            Route::any('/logout', 'Admin\Auth\LoginController@logout')->middleware('admin')->name('logout');
            Route::get('dashboard', 'Admin\Dashboard\DashboardController@index')->middleware('admin')->name('dashboard');
            Route::resource('test', 'Admin\Dashboard\DashboardController');

            Route::prefix('categories')->name('categories.')->group(function(){
                Route::get('listing/{category_id?}', 'Admin\Category\CategoriesController@listing')->name('listing');

                Route::get('add/{category_id?}', 'Admin\Category\CategoriesController@create')->name('add');
                Route::post('add', 'Admin\Category\CategoriesController@storeParent')->name('add.submit');
                Route::post('add/{category_id}', 'Admin\Category\CategoriesController@storeChild')->name('add.child.submit');

                Route::get('/edit/{parent_category}/{child_category?}', 'Admin\Category\CategoriesController@show')->name('show');
                Route::post('/update/parent/{parent_category}', 'Admin\Category\CategoriesController@updateParent')->name('update.parent');
                Route::post('/update/child/{child_category}', 'Admin\Category\CategoriesController@updateChild')->name('update.child');

                Route::get('activate/{cat_id}/{type}', 'Admin\Category\CategoriesController@activate')->name('activate');
                Route::get('deactivate/{cat_id}/{type}', 'Admin\Category\CategoriesController@deactivate')->name('deactivate');
            });

            Route::prefix('products')->name('products.')->group(function(){
                Route::get('add', 'Admin\Product\ProductController@create')->name('add');
                Route::post('add', 'Admin\Product\ProductController@store')->name('add.submit');

                Route::get('{id}/edit', 'Admin\Product\ProductController@edit')->name('edit');
                Route::put('{id}', 'Admin\Product\ProductController@update')->name('edit.submit');

                Route::get('listing', 'Admin\Product\ProductController@listing')->name('listing');

                Route::get('activate/{pro_id}/', 'Admin\Product\ProductController@activate')->name('activate');
                Route::get('deactivate/{pro_id}/', 'Admin\Product\ProductController@deactivate')->name('deactivate');
            });

            Route::prefix('orders')->name('orders.')->group(function(){

                Route::get('listing', 'Admin\Order\OrderController@listing')->name('listing');
                Route::get('/tracker-modal/{parent_id}', 'Admin\Order\OrderController@trackerModal')->name('tracker.show');
                Route::post('/tracker-modal', 'Admin\Order\OrderController@trackerSubmit')->name('tracker.submit');

                Route::get('/shipping-modal/{shipping_id}', 'Admin\Order\OrderController@shippingDetail')->name('shipping.show');

                Route::get('refund/{order_id}', 'Admin\Order\OrderController@refund')->name('perform.refund');
            });
        });
    });

    Route::prefix('payment-gateway')->name('gateway.')->group(function(){
        Route::post('send-order', 'Admin\SenangPay\SenangpayController@prepareRequest')->name('send');
        Route::get('return-result' , 'Admin\Senangpay\SenangpayController@backend')->name('backend');
    });
