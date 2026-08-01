<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductoController;

Route::post('/login', [UserController::class, 'login']);
Route::post('/registrar', [UserController::class, 'Registrar']);
Route::middleware(['auth:sanctum', 'admin'])->group(function () {

    Route::resource('productos', ProductoController::class);

});
