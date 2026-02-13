<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\KategoriProdukController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\KasirController;
use App\Http\Controllers\TransaksiController;

Route::prefix('auth')->group(function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:api');
    Route::post('refresh', [AuthController::class, 'refresh'])->middleware('auth:api');
    Route::post('me', [AuthController::class, 'me'])->middleware('auth:api');
});


Route::middleware('auth:api')->group(function () {

    // Kategori Produk
    Route::apiResource('kategori', KategoriProdukController::class);

    // Restok Produk
    Route::post('/produk/{produk}/restok', [ProdukController::class, 'restok']);
    // Produk
    Route::apiResource('produk', ProdukController::class);

    // Kasir
    Route::apiResource('kasir', KasirController::class)->only(['index', 'store']);

    // Transaksi
    Route::apiResource('/transaksi', TransaksiController::class)->only(['index', 'store','show']);

});
