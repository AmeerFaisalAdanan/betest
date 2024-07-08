<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestController;

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


// Route::get('/random-user', [TestControllerstore::class, 'randomUser']);


Route::get('/create-user', [TestController::class, 'createUser']);

Route::get('/daily-record', [TestController::class, 'dailyRecord']);

Route::get('/check-key-exists', [TestController::class, 'checkKeyExists']);
