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
    return redirect('/admin/index');
});

Auth::routes();

//Route::get('/home', 'HomeController@index')->name('home');
Route::get('/home', function () {
    return redirect('/admin/index');
});

//超级管理员
Route::group(['prefix' => '/admin', 'namespace' => 'Admin', 'middleware' =>	['auth', 'menu']],function(){

    Route::get('/', function () {
//        return view('admin.index.main');
        return redirect('/admin/index');
    });

    Route::get('/index', 'IndexController@index')->name('index');

    Route::group(['prefix'	=>	'/account'], function(){
        Route::get('/list', 'AccountController@list');
        Route::any('/password', 'AccountController@changePassword')->name('account.password');
        Route::any('/create', 'AccountController@create')->name('account.create');
        Route::any('/edit', 'AccountController@edit')->name('account.edit');
        Route::any('/reset', 'AccountController@reset')->name('account.reset');
        Route::any('/del', 'AccountController@del')->name('account.delete');
    });

    Route::group(['prefix'	=>	'/merchant'], function(){
        Route::get('/list', 'MerchantController@list');
        Route::any('/create', 'MerchantController@create')->name('merchant.create');
        Route::any('/key', 'MerchantController@resetKey')->name('merchant.key');
        Route::any('/password', 'MerchantController@changePassword')->name('merchant.password');
        Route::any('/security_password', 'MerchantController@changeSecurityPassword')->name('merchant.security_password');
        Route::any('/del', 'MerchantController@del')->name('merchant.delete');
    });

    Route::get('test', 'TestController@index')->name('test');


});

Route::get('/test1', function () {
    echo "test1";
});

Route::get('/test2', function () {
    echo "test2";
});