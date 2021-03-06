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

Route::group(['namespace' => 'api\auth'], function () {
    Route::post('auth/login', 'AuthController@login');
    Route::post('auth/logout', 'AuthController@logout');
});

Route::group(['namespace' => 'api\user'], function () {
    // 取得目前使用者
    Route::get('user/info', 'UserController@getUser');
    // 修改目前使用者資訊
    Route::patch('user/info', 'UserController@userModify');
});

Route::group(['namespace' => 'api\admin'], function () {
    // 取得所有使用者清單
    Route::get('admin/users', 'UserController@getUsers');
    // 新增使用者
    Route::post('admin/users', 'UserController@createUser');
    // 修改使用者資訊
    Route::patch('admin/users/{user_id}/info', 'UserController@userModify');
    // 批量刪除使用者
    Route::delete('admin/users', 'UserController@deleteUsers');
});

Route::group(['namespace' => 'api'], function () {
    // 使用者註冊
    Route::post('registered', 'UserController@userRegistered');
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
    Route::patch('posts/{postId}', 'PostController@modifyPost');
    // 批量刪除討論主題
    Route::delete('posts/postIds', 'PostController@deletePosts');
    // 更新喜歡單一討論主題
    Route::patch('posts/{postId}/like', 'PostController@updateLikesForPost');

    // 以messageId取得單一留言
    Route::get('messages/{messageId}', 'MessageController@getMessageById');
    // 新增單一留言
    Route::post('messages', 'MessageController@addMessage');
    // 修改單一討論留言
    Route::patch('messages/{messageId}', 'MessageController@modifyMessage');
});
