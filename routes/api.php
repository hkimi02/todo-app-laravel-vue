<?php

use App\Http\Controllers\API\subTaskController;
use App\Http\Controllers\API\CategoriesController;
use App\Http\Controllers\API\CategoriesTaskController;
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

Route::prefix('/categories')->group( function(){
    Route::get('/', [CategoriesController::class , 'index']);
    Route::get('/{id}', [CategoriesController::class , 'show']);
    Route::post('/',[CategoriesController::class , 'store']);
    Route::put('/{id}',[CategoriesController::class , 'update']);
    Route::delete('/{id}',[CategoriesController::class , 'destroy']);
});

Route::prefix('/tasks/subtasks')->group( function(){
    Route::get('/', [subTaskController::class , 'index']);
    Route::post('/{id_task}',[subTaskController::class , 'store']);
    Route::put('/done/{id}',[subTaskController::class , 'makeDone']);
    Route::put('/{id}',[subTaskController::class , 'update']);
    Route::delete('/{id}',[subTaskController::class , 'destroy']);
});

Route::prefix('/tasks')->group( function(){
    Route::get('/search', [itemController::class , 'searchByName']);
    Route::get('/{id}',[itemController::class , 'gettaskbyid']);
    Route::get('/', [itemController::class , 'index']);
    Route::post('/',[itemController::class , 'store']);
    Route::post('/addcategory',[CategoriesTaskController::class , 'store']);
    Route::delete('/deletecategory/{id}',[CategoriesTaskController::class , 'destroy']);
    Route::put('/updatestatus/{id}',[itemController::class , 'update']);
    Route::put('/{id}',[itemController::class , 'edit']);
    Route::delete('/{id}',[itemController::class , 'destroy']);
});


