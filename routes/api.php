<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Route::post('/register', [\App\Http\Controllers\AuthController::class, 'register']);

Route::post('/login', [\App\Http\Controllers\AuthController::class, 'login'])->name('login');





// crud tasks
Route::middleware('auth:sanctum')->group(function(){

    Route::post('/categorie/create', [\App\Http\Controllers\CategorieController::class, 'create']);
    Route::post('/categorie/list', [\App\Http\Controllers\CategorieController::class, 'list']);

    Route::get('/task/list', [\App\Http\Controllers\TaskController::class, 'list']);
    Route::post('/task/create', [\App\Http\Controllers\TaskController::class, 'create']);
    Route::post('/task/update', [\App\Http\Controllers\TaskController::class, 'update']);
    Route::post('/task/delete', [\App\Http\Controllers\TaskController::class, 'delete']);

    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::get('/tasks',[\App\Http\Controllers\TaskController::class, 'get']);

});