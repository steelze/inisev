<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\SubscribeController;
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

Route::post('websites/{website}/posts', [PostController::class, 'store']);
Route::post('websites/{website}/subscribe', [SubscribeController::class, 'store']);
