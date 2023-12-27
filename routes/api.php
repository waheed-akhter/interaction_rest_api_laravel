<?php

use App\Http\Controllers\Api\InteractionController;
use App\Http\Controllers\Api\InteractionStatisticController;
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
 
Route::post('register', [UserController::class, 'register']);
Route::post('login', [UserController::class, 'login']); 
Route::group(['middleware' => 'auth:sanctum'], function () {

    Route::get('/user', function(Request $req){ return $req->user();  });

    // INTERATIONS
    Route::get('/interaction/list', [InteractionController::class, 'index']); 
    Route::get('/interaction/show/{id}', [InteractionController::class, 'show'])->middleware('InteractionMiddleware'); 
    Route::post('/interaction/store', [InteractionController::class, 'store']); 
    Route::post('/interaction/update', [InteractionController::class, 'update']); 
    Route::delete('/interaction/delete/{id}', [InteractionController::class, 'destroy']);  

    // INTERACTION STATISTICS
    Route::get('/interaction/statistic', [InteractionStatisticController::class, 'statistic_info']);  
});
 