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
// 首頁
Route::get('/', function () {
    return view('welcome');
});

// 首頁
Route::get('/index', [
    'as'   => 'index',
    'uses' => 'HomeController@home'
]);

Route::get('/member_login', [
    'as'   => 'member_login',
    'uses' => 'UserController@login'
]);

Route::get('/member_register', [
    'as'   => 'member_register',
    'uses' => 'UserController@register'
]);

Route::get('/member_edit', [
    'as'   => 'member_edit',
    'uses' => 'UserController@edit'
]);

Route::get('/member_post', [
    'as'   => 'member_post',
    'uses' => 'UserController@post'
]);

Route::get('/forum', [
    'as'   => 'forum',
    'uses' => 'PostController@forum'
]);

Route::get('/forum_add', [
    'as'   => 'forum_add',
    'uses' => 'PostController@addForum'
]);
