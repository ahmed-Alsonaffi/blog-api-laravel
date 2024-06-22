<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\EditorController;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\NotificationController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'blog'], function () {
        Route::get('categories',[CategoryController::class,'index']);
        Route::get('categories/{id}',[CategoryController::class,'show']);
        Route::get('posts',[PostController::class,'index']);
        Route::get('latestposts',[PostController::class,'latestPosts']);
        Route::get('posts/{id}',[PostController::class,'get_post']);
        Route::get('related_posts',[PostController::class,'related_posts']);
        Route::get('highlights',[PostController::class,'highlights']);
        Route::get('search',[PostController::class,'search']);
        Route::get('increaseviews/{post_id}',[PostController::class,'addWatch']);
        Route::get('comments/{post_id}',[CommentController::class,'get_comments']);
        Route::post('add_comment',[CommentController::class,'add_comment']);
        Route::get('editors/{id}',[EditorController::class,'get_editor']);
        Route::get('banners',[BannerController::class,'index']);
    });
    Route::group(['prefix' => 'categories'], function () {
        Route::get('posts/{category_id}',[CategoryController::class,'get_posts']);
    });
    Route::group(['prefix' => 'editors'], function () {
        Route::get('posts/{editor_id}',[EditorController::class,'get_posts']);
    });
    Route::group(['prefix' => 'auth'], function () {
        Route::post('login',[LoginController::class,'login']);
        // return "Admin";
    });
    Route::group(['prefix' => 'admin'], function () {
        Route::get('info/{id}',[AdminController::class,'adminInfo']);
        Route::get('posts',[PostController::class,'index']);
        Route::get('categories',[AdminController::class,'categories']);
        Route::get('editors',[AdminController::class,'editors']);
        Route::get('fetcheditors',[AdminController::class,'fetchEditors']);
        Route::post('addpost',[AdminController::class,'addPost']);
        Route::post('addeditor',[AdminController::class,'addEditor']);
        Route::get('banners',[AdminController::class,'banners']);
        Route::post('addbanner',[AdminController::class,'addBanner']);
        Route::post('deletebanner',[AdminController::class,'deleteBanner']);
        Route::post('sendNotification',[NotificationController::class,'store']);
    });