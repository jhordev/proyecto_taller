<?php

use App\Http\Controllers\Auth\LoginController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
});

Route::middleware(['auth', 'prevent-back'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    
    Route::resource('empleados', \App\Http\Controllers\EmpleadoController::class);
    Route::resource('proveedores', \App\Http\Controllers\ProveedorController::class);
    Route::resource('clientes', \App\Http\Controllers\ClienteController::class);
Route::resource('categorias', \App\Http\Controllers\CategoriaController::class);
Route::resource('unidades-medida', \App\Http\Controllers\UnidadMedidaController::class)->names('unidades');
Route::resource('productos', \App\Http\Controllers\ProductoController::class);
Route::resource('movimientos-inventario', \App\Http\Controllers\MovimientoInventarioController::class)->names('movimientos');
Route::resource('ventas', \App\Http\Controllers\VentaController::class);

    
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});



