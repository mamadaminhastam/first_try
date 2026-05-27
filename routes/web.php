<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TokenController;
use App\Http\Controllers\SwapController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    Route::get('/swap', [SwapController::class, 'index'])->name('swap.index');
    Route::post('/swap', [SwapController::class, 'swap'])->name('swap.perform');
    Route::get('/swap/history', [SwapController::class, 'history'])->name('swap.history');
});

Route::resource('tokens', TokenController::class)->only(['index', 'show']);
Route::resource('tokens', TokenController::class)->only(['create', 'store', 'edit', 'update', 'destroy'])
                                               ->middleware('auth');