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

Auth::routes(['verify' => true]);
Route::get('email/resend/{id}', 'Auth\VerificationController@resend')->name('verification.resend.id');

Route::get('logout', 'Auth\LoginController@logout')->name('direct-logout');
Route::post('password/assign/{user}', 'Auth\ResetPasswordController@assignPassword')->name('password.assign');

Route::group(['namespace' => 'General', 'middleware' => ['auth', 'verified']], function() {

    // Rutas para breadcrumb
    Route::get('/', 'DashboardController@index')->name('home');
    Route::get('home', 'DashboardController@index');

    Route::get('users/profile','UserController@profile')->name('users.profile');
    Route::resource('users', 'UserController')->except(['create', 'edit']);
    Route::get('users/status/{user}','UserController@status')->name('users.status');

    Route::resource('roles', 'RoleController');
    Route::resource('permissions', 'PermissionController');

    Route::resource('categories/products', 'ProductCategoryController', ['as' => 'categories'])->only(['store', 'update', 'destroy']);

    // No aplicar resource, los nombres no se ajustan bien
    Route::get('categories/products/sub/{productCategory}', 'SubCategoryController@listWithProducts')->name('sub.categories.withProducts');
    Route::post('categories/products/sub/{subCategory}', 'SubCategoryController@store')->name('sub.categories.store');
    Route::patch('categories/products/sub/{subCategory}', 'SubCategoryController@update')->name('sub.categories.update');
    Route::delete('categories/products/sub/{subCategory}', 'SubCategoryController@destroy')->name('sub.categories.destroy');

    Route::resource('stores', 'StoreController')->except(['create', 'edit']);

    Route::resource('coupons', 'CouponController')->except(['create', 'edit']);
    Route::post('coupons/status/{coupon}', 'CouponController@status')->name('coupons.status');

    Route::resource('clients', 'ClientController')->except(['create', 'edit', 'destroy']);
    Route::post('clients/status/{client}', 'ClientController@status')->name('clients.status');

    Route::resource('products', 'ProductController')->except(['create', 'edit']);
    Route::get('products/bySubCategory/{subCategory}', 'ProductController@bySubCategory')->name('products.by.sub.categories');

    Route::resource('orders', 'OrderController');

    Route::resource('delivery', 'DeliveryController');

});
