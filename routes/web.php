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
    return redirect('/admin/index');
});

Route::get('/home', function () {
    return redirect('/admin/index');
});

Route::get('/admin', function () {
    return redirect('/admin/index');
});

//Auth::routes(); //屏蔽注册路由
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

//超级管理员
Route::group(['prefix' => '/admin', 'namespace' => 'Admin', 'middleware' =>	['auth', 'menu']],function(){

    Route::get('/index', 'IndexController@index')->name('index');

    Route::group(['prefix' => '/account'], function(){
        Route::get('/index', 'AccountController@index')->name('account.index');
        Route::any('/password', 'AccountController@changePassword')->name('account.password');
        Route::any('/create', 'AccountController@create')->name('account.create');
        Route::any('/edit', 'AccountController@edit')->name('account.edit');
        Route::any('/reset', 'AccountController@reset')->name('account.reset');
        Route::any('/del', 'AccountController@del')->name('account.delete');
    });

    Route::group(['prefix' => '/merchant'], function(){
        Route::get('/index', 'MerchantController@index')->name('merchant.index');
        Route::any('/create', 'MerchantController@create')->name('merchant.create');
        Route::post('/key', 'MerchantController@resetKey')->name('merchant.key');
        Route::any('/password', 'MerchantController@resetPassword')->name('merchant.password');
        Route::any('/security', 'MerchantController@resetSecurity')->name('merchant.security');
        Route::any('/del', 'MerchantController@del')->name('merchant.delete');
    });

    Route::group(['prefix' => '/permission'], function(){
        Route::get('/index', 'PermissionController@index')->name('permission.index');
    });

    Route::get('test', 'TestController@index')->name('test');


});