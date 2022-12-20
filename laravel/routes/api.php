<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\FileController;
use App\Http\Controllers\Api\TokenController;
use App\Http\Controllers\Api\PostController;

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


Route::get('user', [TokenController::class, 'user'])->middleware('auth:sanctum');
Route::post('logout', [TokenController::class, 'logout'])->middleware('auth:sanctum');
Route::post('login', [TokenController::class, 'login']);
Route::post('register', [TokenController::class, 'register']);


Route::apiResource('files', FileController::class);

Route::apiResource('post', PostController::class);  



