<?php

use App\Models\Cliente;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClienteController;

Route::apiResource('cliente', ClienteController::class)->only(['index', 'store']);
Route::get('cliente/{id}', [ClienteController::class, 'show'])->name('cliente.show');
Route::put('cliente/{id}', [ClienteController::class, 'update'])->name('cliente.update');
Route::delete('cliente/{id}', [ClienteController::class, 'destroy'])->name('cliente.destroy');
Route::get('consulta/final-placa/{numero}', [ClienteController::class, 'all_final_placa'])->name('consulta.final-placa')->where('numero', '[0-9]');