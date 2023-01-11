<?php


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\itemController;
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



Route::prefix('/tasks')->group( function(){
    Route::get('/', [itemController::class , 'index']);
    Route::post('/',[itemController::class , 'store']);
    Route::put('/{id}',[itemController::class , 'update']);
    Route::delete('/{id}',[itemController::class , 'destroy']);
});
