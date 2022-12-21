<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\UserController;
use App\Http\Controllers\Api\V1\PostController;
use App\Http\Controllers\Api\V1\CommentController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/v1/users', [UserController::class, 'store']);
Route::patch('/v1/users/{user}', [UserController::class, 'update']);
Route::get('/v1/users/{user}', [UserController::class, 'show']);

Route::get('v1/{user}/posts', [PostController::class, 'index']);
Route::post('v1/{user}/posts', [PostController::class, 'store']);
Route::patch('v1/{id}/posts/{post}', [PostController::class, 'update']);
Route::delete('v1/{id}/posts/{post}', [PostController::class, 'destroy']);

Route::post('/v1/{post}/comments', [CommentController::class, 'store']);