<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\EditorController;
use App\Http\Controllers\Admin\LoginController;

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
        Route::get('posts/{id}',[PostController::class,'get_post']);
        Route::get('related_posts',[PostController::class,'related_posts']);
        Route::get('comments/{post_id}',[CommentController::class,'get_comments']);
        Route::post('add_comment',[CommentController::class,'add_comment']);
        Route::get('editors/{id}',[EditorController::class,'get_editor']);
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