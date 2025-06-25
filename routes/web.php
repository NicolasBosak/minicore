<?php

use App\Http\Controllers\ComisionController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('comisiones.index');
});

// Rutas para el sistema de comisiones
Route::get('/comisiones', [ComisionController::class, 'index'])->name('comisiones.index');
Route::post('/comisiones/calcular', [ComisionController::class, 'calcular'])->name('comisiones.calcular');

