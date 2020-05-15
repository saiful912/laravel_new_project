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

Route::get('/','IndexController@index')->name('home');
Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');

//category listing page
Route::get('/products/category/{id}', 'ProductsController@show')->name('categories.show');
Route::get('/products/{url}', 'ProductsController@products');
//product detail page
Route::get('/product/{id}','ProductsController@product_view');
//get product attribute price
Route::get('/get-product-price','ProductsController@getProductPrice');
//add to cart
Route::match(['get','post'],'/add_cart','ProductsController@add_to_cart');
//cart route
Route::match(['get','post'],'/cart','ProductsController@cart_page');
Route::get('/cart/update-quantity/{id}/{quantity}','ProductsController@updateCartProduct');
Route::get('/cart/delete-product/{id}','ProductsController@deleteCartProduct');
//apply coupon
Route::post('/cart/apply-coupon','ProductsController@applyCoupon');

//login register route
Route::match(['get','post'],'/login-register','UsersController@register');
////user register form submit
Route::post('/user-register','UsersController@register');
////user login page
Route::get('/login-user','UsersController@userLoginregister');
Route::post('/user-login','UsersController@login');
//user account
//all route after login

Route::group(['middleware'=>['frontlogin']],function (){
    Route::match(['get','post'],'/account','UsersController@account');
    //check current password
    Route::get('/check-user-pwd','UsersController@check_password')->name('check_user_pwd');
    Route::post('/update-user-pwd','UsersController@update_password');
    Route::match(['get','post'],'/cart','ProductsController@cart_page');
    Route::get('/cart/update-quantity/{id}/{quantity}','ProductsController@updateCartProduct');
    Route::get('/cart/delete-product/{id}','ProductsController@deleteCartProduct');
    //checkout Route
    Route::match(['get','post'],'/checkout','ProductsController@checkout');


});

//user logout
Route::get('/user-logout','UsersController@logout');
//check if user already exists
Route::match(['get','post'],'/check-email','UsersController@checkEmail');
//admin route
Route::match(['get','post'],'/admin','AdminController@login');
Route::get('/logout', 'AdminController@logout')->name('logout');
Route::group(['middleware'=>['auth']],function (){
    Route::get('/admin/dashboard','AdminController@dashboard');
    Route::get('/admin/setting','AdminController@setting')->name('setting');
    Route::get('/admin/check_pwd','AdminController@check_password')->name('check_password');
    Route::match(['get','post'],'/admin/update_pwd','AdminController@update_password');

    //category Route
    Route::get('/admin/view_categories','CategoryController@view_category');
    Route::match(['get','post'],'/admin/add_category','CategoryController@addCategory');
    Route::match(['get','post'],'/admin/update_category/{id}','CategoryController@update_category');
    Route::match(['get','post'],'/admin/delete_category/{id}','CategoryController@delete_category');

    //product route
    Route::get('/admin/view_product','ProductsController@view_product');
    Route::match(['get','post'],'/admin/add_product','ProductsController@addProduct');
    Route::match(['get','post'],'/admin/edit_product/{id}','ProductsController@edit_product');
    Route::post('/admin/delete_product/{id}','ProductsController@delete_product');
    Route::get('/admin/delete_product_image/{id}','ProductsController@delete_product_image');
    //attribute route
    Route::match(['get','post'],'/admin/add_attribute/{id}','ProductsController@add_attribute');
    Route::match(['get','post'],'/admin/edit_attribute/{id}','ProductsController@edit_attribute');
    Route::post('/admin/delete_attribute/{id}','ProductsController@delete_attribute');
    Route::match(['get','post'],'/admin/add_image/{id}','ProductsController@addImage');
    Route::post('/admin/delete_image/{id}','ProductsController@deleteImage');
    //coupons Route
    Route::match(['get','post'],'/admin/add-coupon','CouponsController@add_coupon');
    Route::get('/admin/view_coupon','CouponsController@view_coupon');
    Route::get('/admin/delete_coupon/{id}','CouponsController@coupon_delete');
    Route::match(['get','post'],'/admin/edit-coupon/{id}','CouponsController@edit_coupon');
    //coupons Route
    Route::match(['get','post'],'/admin/add-banner','BannersController@add_banner');
    Route::get('/admin/view_banner','BannersController@view_banner');
    Route::get('/admin/delete_banner/{id}','BannersController@banner_delete');
    Route::match(['get','post'],'/admin/edit-banner/{id}','BannersController@edit_banner');
});



