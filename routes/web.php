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
    return view('welcome');
});
Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');

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
});



