<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TodoListController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

Route::get('/list', [TodoListController::class, 'index']);
Route::get('/listById/{id}', [TodoListController::class, 'show']);
Route::get('/listByName/{name}', [TodoListController::class, 'showByName']);
Route::post('/list', [TodoListController::class, 'store']);
Route::put('/list/{id}', [TodoListController::class, 'update']);
Route::delete('/list/{id}', [TodoListController::class, 'destroy']);
