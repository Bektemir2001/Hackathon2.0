<?php

use App\Http\Controllers\Api\PollController;
use App\Http\Controllers\Api\ReportController;
use App\Http\Controllers\Api\TelegramController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::get('/telegram/activity', [TelegramController::class, 'getActivity']);
Route::get('/telegram/set_webhook', [TelegramController::class, 'setWebhook']);
Route::post('/telegram/distribution', [TelegramController::class, 'distribution']);
Route::get('/telegram/get/popular/messages', [TelegramController::class, 'getPopularMessages']);
Route::get('/event/report/{event_id}', [ReportController::class, 'report']);
Route::get('/telegram/most/active/users', [UserController::class, 'getActiveUsers']);
Route::get('/telegram/polls', [PollController::class, 'get']);
