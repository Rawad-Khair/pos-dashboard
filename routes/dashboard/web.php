<?php 


Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]
    ], function(){ 

    Route::prefix('dashboard')->name('dashboard.')->middleware('auth')->group(function () {
        Route::get('/','DashboardController@index')->name('index');
        // Users Routes
        Route::resource('users','UserController');
        Route::post('users/{user}/change_roles','UserController@change_roles')->name('users_change_roles');
        Route::post('users/{user}/block','UserController@block')->name('users_block');
        // Categories Routes
        Route::resource('categories','CategoryController');
        // Products Routes
        Route::resource('products','ProductController');
        Route::post('products/{product}/approve','ProductController@approve')->name('products.approve');
         // clients Routes
         Route::resource('clients','ClientController');
         Route::resource('clients/{client}/order','Clients\ClientOrderController');
         // Orders Routes
         Route::resource('orders', 'OrderController');
         Route::get('order/{order}/products','OrderController@show_order_products')->name('order.products');
    });

});
