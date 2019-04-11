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

    //首页
    Route::get('/index', 'IndexController@index')->name('index');

    //管理员
    Route::group(['prefix' => '/account'], function(){
        Route::get('/index', 'AccountController@index')->name('account.index');
        Route::any('/password', 'AccountController@changePassword')->name('account.password');
        Route::any('/create', 'AccountController@create')->name('account.create');
        Route::any('/edit', 'AccountController@edit')->name('account.edit');
        Route::any('/reset', 'AccountController@reset')->name('account.reset');
        Route::any('/del', 'AccountController@del')->name('account.delete');
    });

    //角色
    Route::group(['prefix' => '/role'], function(){
        Route::get('/index', 'RoleController@index')->name('role.index');
        Route::any('/create', 'RoleController@create')->name('role.create');
        Route::any('/edit', 'RoleController@edit')->name('role.edit');
        Route::any('/set', 'RoleController@set')->name('role.set');
        Route::any('/del', 'RoleController@del')->name('role.delete');
    });

    //权限
    Route::group(['prefix' => '/permission'], function(){
        Route::get('/index', 'PermissionController@index')->name('permission.index');
        Route::post('/clear', 'PermissionController@clear')->name('permission.clear');
        Route::post('/restore', 'PermissionController@restore')->name('permission.restore');
        Route::any('/edit', 'PermissionController@edit')->name('permission.edit');
        Route::any('/del', 'PermissionController@del')->name('permission.delete');
    });

    //菜单
    Route::group(['prefix' => '/menu'], function(){
        Route::get('/index', 'MenuController@index')->name('menu.index');
        Route::any('/create', 'MenuController@create')->name('menu.create');
        Route::any('/edit', 'MenuController@edit')->name('menu.edit');
        Route::any('/del', 'MenuController@del')->name('menu.delete');
    });

    //商户
    Route::group(['prefix' => '/merchant'], function(){
        Route::get('/index', 'MerchantController@index')->name('merchant.index');
        Route::any('/create', 'MerchantController@create')->name('merchant.create');
        Route::post('/key', 'MerchantController@resetKey')->name('merchant.key');
        Route::any('/password', 'MerchantController@resetPassword')->name('merchant.password');
        Route::any('/security', 'MerchantController@resetSecurity')->name('merchant.security');
        Route::any('/del', 'MerchantController@del')->name('merchant.delete');
    });

    //支付通道
    Route::group(['prefix' => '/payType'], function(){
        Route::get('/index', 'PayTypeController@index')->name('payType.index');
        Route::any('/create', 'PayTypeController@create')->name('payType.create');
        Route::any('/edit', 'PayTypeController@edit')->name('payType.edit');
        Route::any('/lock/{id}/{status}', 'PayTypeController@lock')->name('payType.lock');
        Route::any('/del', 'PayTypeController@del')->name('payType.delete');
    });

});