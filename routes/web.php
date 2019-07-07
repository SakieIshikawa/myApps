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
Route::group(['prefix' => 'admin', 'middleware' => 'auth'], function() {
Route::get('post/create', 'Admin\PostController@add');
Route::post('post/create', 'Admin\PostController@create');
Route::get('post', 'Admin\PostController@index')->middleware('auth');
Route::get('post/edit', 'Admin\PostController@edit')->middleware('auth');
Route::post('post/edit', 'Admin\PostController@update')->middleware('auth');
Route::get('post/delete', 'Admin\PostController@delete')->middleware('auth');
});

//通常のページの表示にはgetを受け取り、フォームを送信したときに受け取る場合にはpostを受け取るように指定
//->middleware('auth') 未ログインで管理画面にアクセスしようとしたらログイン画面にリダイレクトイレクト

Route::get('admin/profile/create', 'Admin\ProfileController@add')->middleware('auth');
Route::post('admin/profile/create', 'Admin\ProfileController@create')->middleware('auth');
Route::get('admin/profile/edit', 'Admin\ProfileController@edit')->middleware('auth');
Route::post('admin/profile/edit', 'Admin\ProfileController@update')->middleware('auth');
Route::get('admin/profile', 'Admin\ProfileController@index')->middleware('auth');  //profileの確認用
Route::get('admin/profile/edit', 'Admin\ProfileController@edit')->middleware('auth');
Route::post('admin/profile/edit', 'Admin\ProfileController@update')->middleware('auth');
Route::get('admin/profile/delete', 'Admin\ProfileController@delete')->middleware('auth');


Auth::routes();

//Route::get('/home', 'HomeController@index')->name('home');
Route::get('/', 'PostController@index');