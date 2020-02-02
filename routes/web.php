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

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/empty', function (){
    return view('shared._empty');
})->name('empty');

// 接受 浏览器端发来的 get 请求, 路由为 '/' 映射到  StaticPagesController 控制器下的 home 方法
Route::get('/', 'StaticPagesController@home')->name('home');
Route::get('/help', 'StaticPagesController@help')->name('help');
Route::get('/about', 'StaticPagesController@about')->name('about');

// user

// 用户注册
Route::get('/signup', 'UsersController@create')->name('signup');
Route::resource('users', 'UsersController');
Route::get('/signup/confirm/{token}', 'UsersController@confirmEmail')->name('confirm_email');
Route::get('/users/{user}/followers', 'UsersController@followers')->name('users.followers');
Route::get('/users/{user}/followings', 'UsersController@followings')->name('users.followings');


// Route::resource('users', 'UsersController'); 等于下面 ：
//Route::get('/users', 'UsersController@index')->name('users.index');
//Route::get('/users/create', 'UsersController@create')->name('users.create');
//Route::get('/users/{user}', 'UsersController@show')->name('users.show');
//Route::post('/users', 'UsersController@store')->name('users.store');
//Route::get('/users/{user}/edit', 'UsersController@edit')->name('users.edit');
//Route::patch('/users/{user}', 'UsersController@update')->name('users.update');
//Route::delete('/users/{user}', 'UsersController@destroy')->name('users.destroy');


// 用户登陆
// get登陆页面
Route::get('/login', 'SessionsController@create')->name('login');
// post登陆信息
Route::post('/login', 'SessionsController@store')->name('login');
// 登出 , 相当于删除此次 Session资源
Route::delete('/logout','SessionsController@delete')->name('logout');


// 修改密码
Route::get('/password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('/password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('/password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');


// 微博 RESTful 接口, 仅支持新增和删除操作
Route::resource('blogs', 'BlogsController', ['only'=>['store', 'destroy']]);
