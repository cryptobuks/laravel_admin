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
//    return view('welcome');
    return redirect('/admin');
});

Auth::routes();

//Route::get('/home', 'HomeController@index')->name('home');

//超级管理员
Route::group(['prefix' => '/admin', 'namespace' => 'Admin', 'middleware' =>	'auth'],function(){

    Route::get('test', 'TestController@index')->name('admin.test');

    Route::get('/', function () {
        return view('admin_template');
    })->name('/');

});