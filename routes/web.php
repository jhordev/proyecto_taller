<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmpleadoController;
use App\Http\Controllers\ProveedorController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\UnidadMedidaController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\MovimientoInventarioController;
use App\Http\Controllers\VentaController;

// Página de bienvenida
Route::get('/', fn() => view('welcome'));

// Rutas públicas: solo accesibles si no hay sesión activa
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
});

// Rutas protegidas: requieren sesión autenticada y prevención de historial
Route::middleware(['auth', 'prevent-back'])->group(function () {

    // Panel principal
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    // Módulo Personas
    Route::resource('empleados', EmpleadoController::class);
    Route::resource('proveedores', ProveedorController::class);
    Route::resource('clientes', ClienteController::class);

    // Módulo Almacén
    Route::resource('categorias', CategoriaController::class);
    Route::resource('unidades-medida', UnidadMedidaController::class)->names('unidades');
    Route::resource('productos', ProductoController::class);
    Route::resource('movimientos-inventario', MovimientoInventarioController::class)->names('movimientos');

    // Módulo Ventas
    Route::resource('ventas', VentaController::class);
});
