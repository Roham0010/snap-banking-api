<?php

use App\Http\Controllers\API\TransactionController;
use App\Http\Controllers\API\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::post('cards/transfer', [TransactionController::class, 'cardTransfer']);
Route::get('users/top-users', [UserController::class, 'topUsers']);
