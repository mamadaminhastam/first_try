<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SwapController;
use App\Http\Controllers\LiquidityPoolController;

Route::get('/', function () {
    return view('welcome');
});
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/tokens', [\App\Http\Controllers\Admin\TokenController::class, 'index'])->name('tokens.index');
    Route::delete('/tokens/{token}', [\App\Http\Controllers\Admin\TokenController::class, 'destroy'])->name('tokens.destroy');
});
Route::middleware('auth')->group(function () {
    // Swap routes
    Route::get('/swap', [SwapController::class, 'index'])->name('swap.index');
    Route::post('/swap', [SwapController::class, 'swap'])->name('swap.perform');
    Route::get('/swap/history', [SwapController::class, 'history'])->name('swap.history');

    // Liquidity Pool routes
    Route::get('/pools', [LiquidityPoolController::class, 'index'])->name('pools.index');
    Route::get('/pools/create', [LiquidityPoolController::class, 'create'])->name('pools.create');
    Route::post('/pools', [LiquidityPoolController::class, 'store'])->name('pools.store');
    Route::get('/pools/{pool}', [LiquidityPoolController::class, 'show'])->name('pools.show');
    Route::get('/pools/{pool}/add-liquidity', [LiquidityPoolController::class, 'addLiquidityForm'])->name('pools.addLiquidity');
    Route::post('/pools/{pool}/add-liquidity', [LiquidityPoolController::class, 'addLiquidity'])->name('pools.addLiquidity.store');
});
Route::middleware(['auth', 'admin'])->group(function () {
    Route::delete('/pools/{pool}', [LiquidityPoolController::class, 'destroy'])->name('pools.destroy');
});

require __DIR__.'/auth.php';
