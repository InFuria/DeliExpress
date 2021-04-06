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

Route::get('test', function (){
    return view('auth.passwords.reset_solicitude');
});

Auth::routes(['verify' => true]);
Route::get('logout', 'Auth\LoginController@logout')->name('direct-logout');
Route::post('password/assign/{user}', 'Auth\ResetPasswordController@assignPassword')->name('password.assign');

Route::group(['namespace' => 'General', 'middleware' => ['auth', 'verified']], function() {

    Route::get('/', 'DashboardController@index')->name('home');


    Route::resource('users', 'UserController');
    Route::get('users/profile','UserController@profile')->name('users.profile'); // solo para ver el perfil propio
    Route::get('users/status/{user}','UserController@status')->name('users.status'); // para cambiar el status de cualquier usuario

    Route::resource('roles', 'RoleController');
    Route::resource('permissions', 'PermissionController');


        /*
        |--------------------------------------
        |Menu Category
        |--------------------------------------
        */
        /*Route::resource('category','CategoryController');
        Route::get('category/delete/{id}','CategoryController@delete');
        Route::get('category/status/{id}','CategoryController@status');*/


        /*
        |--------------------------------------
        |Menu Items
        |--------------------------------------
        */
        /*Route::resource('item','ItemController');
        Route::get('item/delete/{id}','ItemController@delete');
        Route::get('item/status/{id}','ItemController@status');
        Route::post('itemAddon','ItemController@addon');
        Route::get('export','ItemController@export');
        Route::get('import','ItemController@import');
        Route::post('import','ItemController@_import');*/


        /*
        |------------------------------
        |Delivery Staff
        |------------------------------
        */
        /*Route::resource('delivery','DeliveryController');
        Route::get('delivery/delete/{id}','DeliveryController@delete');
        Route::get('delivery/status/{id}','DeliveryController@status');*/

        /*
        |-------------------------------
        |Manage Orders
        |-------------------------------
        */
        /*Route::get('order','OrderController@index');
        Route::get('orderStatus','OrderController@orderStatus');
        Route::get('order/print/{id}','OrderController@printBill');
        Route::post('order/dispatched','OrderController@dispatched');
        Route::get('order/edit/{id}','OrderController@edit');
        Route::post('order/edit/{id}','OrderController@_edit');
        Route::get('orderItem','OrderController@orderItem');
        Route::get('getUnit/{id}','OrderController@getUnit');
        Route::get('order/add','OrderController@add');
        Route::post('order/add','OrderController@_add');
        Route::get('getUser/{id}','OrderController@getUser');*/

    });





