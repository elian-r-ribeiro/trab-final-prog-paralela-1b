<?php

use App\Http\Controllers\Api\UserController;
use App\Jobs\TesteFila;
use App\Models\User;
use Illuminate\Support\Facades\Route;

Route::get('/teste-fila', function () {
    TesteFila::dispatch();
    return 'Job enviado para a fila!';
});

/*
Route::post('/users', [UserController::class, 'store']);
Route::get('/users', [UserController::class, 'index']);
Route::put('/users/{id}', [UserController::class, 'update']);
Route::delete('/users/{id}', [UserController::class, 'destroy']);
Route::get('/users/{id}', [UserController::class, 'show']);
*/

Route::post('/login', [UserController::class, 'login']);
Route::get('/users/export/csv', [UserController::class, 'exportCsv']);
Route::get('/users/export/pdf', [UserController::class, 'exportPdf']);
Route::apiResource('/users', UserController::class);

Route::middleware(['auth:sanctum', 'user.type:admin'])->group(function () {

    
});
