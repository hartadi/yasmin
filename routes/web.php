<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes(["register" => false]);
Route::get('logs', [\Rap2hpoutre\LaravelLogViewer\LogViewerController::class, 'index']);

Route::get('/', [App\Http\Controllers\HomeController::class, 'index']);
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::prefix("master")->middleware("auth")->group(function () {
    AdvancedRoute::controllers([
        "satuan"     => App\Http\Controllers\Master\SatuanController::class,
        "barang"     => App\Http\Controllers\Master\BarangController::class,
        "gudang"     => App\Http\Controllers\Master\GudangController::class,
        "departemen" => App\Http\Controllers\Master\DepartemenController::class,
    ]);
});
Route::prefix("transaksi")->middleware("auth")->group(function () {
    AdvancedRoute::controllers([
        "barang-masuk"  => App\Http\Controllers\Transaksi\BarangMasukController::class,
        "barang-keluar" => App\Http\Controllers\Transaksi\BarangKeluarController::class,
    ]);
});
Route::prefix("laporan")->middleware("auth")->group(function () {
    AdvancedRoute::controllers([
        "saldo-barang" => App\Http\Controllers\Laporan\SaldoBarangController::class,
        "arus-barang"  => App\Http\Controllers\Laporan\ArusBarangController::class,
    ]);
});
