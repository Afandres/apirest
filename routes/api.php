<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApprenticeController;
use App\Http\Controllers\Api\AuthController;
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
Route::get('/register', [AuthController::class , 'register']);
Route::get('/login', [AuthController::class , 'login']);

Route::middleware('auth:sanctum')->get('/user' , function (Request $request) {

    Route::get('/logout', [AuthController::class , 'logout']);
    Route::resource('/apprentices', ApprenticeController::class)->except([
    'create','edit'
    ]);
    Route::put('/apprentices/{identificacion}', [ApprenticeController::class , 'update']);
});
   



