<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['namespace' => 'api'], function () {
    // 取得討論主題部分資料
    Route::get('posts', 'PostController@getPost');
});

Route::group(['namespace' => 'api\user'], function () {
    // 以userId取得部分討論主題
    Route::get('users/{userId}/posts', 'PostController@getPostByUserId');
    // 以postId取得單一討論主題
    Route::get('posts/{postId}', 'PostController@getPostById');
    // 新增單一討論主題
    Route::post('posts', 'PostController@addPost');
    // 修改單一討論主題
    // 批量刪除討論主題
});
