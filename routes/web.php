<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes();
Route::get('logs', [\Rap2hpoutre\LaravelLogViewer\LogViewerController::class, 'index']);

Route::get('/', [App\Http\Controllers\HomeController::class, 'index']);
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::prefix("transaksi")->group(function () {
    AdvancedRoute::controllers([
        "barang-masuk"  => App\Http\Controllers\Transaksi\BarangMasukController::class,
        "barang-keluar" => App\Http\Controllers\Transaksi\BarangKeluarController::class,
    ]);
});
Route::prefix("laporan")->group(function () {
    AdvancedRoute::controllers([
        "saldo-barang" => App\Http\Controllers\Laporan\SaldoBarangController::class,
        "arus-barang"  => App\Http\Controllers\Laporan\ArusBarangController::class,
    ]);
});
