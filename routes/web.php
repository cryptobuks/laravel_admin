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
Route::get('/home', function () {
    return redirect('/admin');
});

//超级管理员
Route::group(['prefix' => '/admin', 'namespace' => 'Admin', 'middleware' =>	['auth', 'menu']],function(){

    Route::get('/index', 'IndexController@index');

    Route::group(['prefix'	=>	'/account'], function(){
        Route::get('/list', 'AccountController@list');
        Route::any('/create', 'AccountController@create')->name('account.create');
        Route::any('/edit', 'AccountController@edit')->name('account.edit');
        Route::any('/reset', 'AccountController@reset')->name('account.reset');
        Route::any('/password', 'AccountController@changePassword')->name('account.password');
        Route::post('/del', 'AccountController@postDel');
        Route::post('/detach', 'AccountController@postDetach');
    });

    Route::get('test', 'TestController@index')->name('admin.test');

    Route::get('/', function () {
        return view('admin_template');
    })->name('/');

});

Route::get('/test1', function () {
    echo "test1";
});

Route::get('/test2', function () {
    echo "test2";
});