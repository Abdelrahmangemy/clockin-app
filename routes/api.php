<?php

use App\Http\Controllers\WorkerController;
use Illuminate\Http\Request;
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
Route::post('/worker/clock-in', [WorkerController::class, 'clockIn']);
Route::get('/worker/clock-ins', [WorkerController::class, 'getClockIns']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
