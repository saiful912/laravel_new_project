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
});



