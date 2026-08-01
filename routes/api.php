<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductoController;

Route::post('/login', [UserController::class, 'login']);
Route::middleware(['auth:sanctum', 'admin'])->group(function () {
    Route::resource('usuarios', UserController::class);
    Route::resource('productos', ProductoController::class);
    Route::get('/totalUser', [UserController::class, 'contarUsuarios']);
    Route::post('/registrar', [UserController::class, 'Registrar']);
});
