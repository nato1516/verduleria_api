<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductoController;


Route::get('/test-cloudinary', function(){

    return config('cloudinary.cloud_url');

});
Route::post('/login', [UserController::class, 'login']);
Route::get('/products',[ProductoController::class, 'mostrarProductos']);
Route::middleware(['auth:sanctum', 'admin'])->group(function () {
    Route::resource('usuarios', UserController::class);
        Route::get('/productos/inactivo', [ProductoController::class, 'inactivo']);

    Route::resource('productos', ProductoController::class);
    Route::get('/totalUser', [UserController::class, 'contarUsuarios']);
    Route::post('/registrar', [UserController::class, 'Registrar']);
});
