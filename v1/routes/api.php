<?php

use Illuminate\Support\Facades\Route;

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

Route::group(['middleware' => 'auth:api'], function () {
    Route::post('logout', 'Auth\LoginController@logout');

    Route::get('/user', 'Auth\UserController@current');

    Route::patch('settings/profile', 'Settings\ProfileController@update');
    
    Route::patch('settings/password', 'Settings\PasswordController@update');
});

Route::group(['middleware' => 'guest:api'], function () {

    Route::post('login', 'Auth\LoginController@login');

    Route::post('register', 'Auth\RegisterController@register');

    Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail');

    Route::post('password/reset', 'Auth\ResetPasswordController@reset');

    Route::post('email/verify/{user}', 'Auth\VerificationController@verify')->name('verification.verify');

    Route::post('email/resend', 'Auth\VerificationController@resend');

    Route::post('oauth/{driver}', 'Auth\OAuthController@redirectToProvider');

    Route::get('oauth/{driver}/callback', 'Auth\OAuthController@handleProviderCallback')->name('oauth.callback');

});


Route::group([

    'prefix' => 'profile'

], function() {

    Route::get('{username}', 'UserModelController@getProfileByUsername');

});

    /**
     *
     * All Routes That Are Related To Getting User Posts From The Applications Back-End
     *
     * */
Route::group([

    'prefix' => 'posts'

], function () {

    Route::get('feed', 'PostModelController@feed');

    Route::get('single/{postId}', 'PostModelController@single');

    Route::get('user/{userId}', 'PostModelController@user');

    Route::get('discover', 'PostModelController@discover');

    Route::get('{id}', 'PostModelController@single');

    Route::get('liked/{userId}', 'PostModelController@liked');

});

/**
 *
 * All Routes That Are Related To Following Users
 *
 * */
Route::group([

    'prefix' => 'follow'

], function (){

    Route::post('followuser/{userId}', 'FollowModelController@followUser');

    Route::get('followers/{userId}', 'FollowModelController@followers');

    Route::get('following/{userId}', 'FollowModelController@follows');

    Route::get('suggests', 'FollowModelController@suggests');

    Route::get('trending/{where}/{limit}', 'FollowModelController@trending');

});


/**
 *
 * All Routes That Are Related To Reacting [ All User Actions In The Application Except Uploading ]
 *
 * */
Route::group([

    'prefix' => 'react'

], function (){

    Route::get('like/{postId}', 'ReactModelController@like');

    Route::get('views/{postId}', 'ReactModelController@views');

    Route::get('block/{userId}', 'ReactModelController@block');

    Route::get('delete/post/{postId}', 'ReactModelController@deletePost');

    Route::get('delete/comment/{commentId}', 'ReactModelController@deleteComment');

    Route::get('view/likers/{postId}', 'ReactModelController@likers');

    Route::get('view/commenters/{postId}', 'ReactModelController@commenters');

});


/**
 *
 * All Routes That Are Related To Retrieving Comments From The Application
 * Back-End
 *
 * */
Route::group([

    'prefix' => 'comments'

], function (){

    Route::get('view', 'CommentModelController@view');

    Route::get('{postId}', 'CommentModelController@viewComments');

    Route::get('single/{commentId}','CommentModelController@single');

});



/**
 *
 * All Related Routes To Uploading/Posting User Media
 *
 * */
Route::group([

    'prefix' => 'upload'

], function (){

    Route::post('post', 'UploadController@post');

    Route::post('share/{postId}', 'UploadController@share');

    Route::post('comment/{postId}', 'UploadController@comment');

    Route::post('profile', 'UploadController@profile');

    Route::post('cover', 'UploadController@cover');

});


/**
 * Getting Notifications
 * */
Route::group([

    'prefix'    => 'notif'

], function (){

    Route::get('notifications', 'NotificationModelController@showNotifications');

});


/**
 *
 * All Routes Related To Small Errands!
 *
 * */
Route::group([

    'prefix'    => 'errands'

], function (){



});