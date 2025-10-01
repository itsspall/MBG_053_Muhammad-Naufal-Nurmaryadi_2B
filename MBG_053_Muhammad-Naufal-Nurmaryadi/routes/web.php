<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BahanBakuController;
use App\Http\Controllers\PermintaanDapurController;
use App\Http\Controllers\PermintaanGudangController;


Route::get('login', [AuthController::class, 'index'])->name('login')->middleware('guest');
Route::post('login', [AuthController::class, 'authenticate']);
Route::post('logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

Route::get('/', function () {
    if (auth()->user()->role == 'gudang') {
        return redirect()->route('gudang.permintaan.index');
    } elseif (auth()->user()->role == 'dapur') {
        return redirect()->route('dapur.permintaan.index');
    }
    return redirect('/login');
})->middleware('auth');


Route::middleware(['auth'])->group(function () {
    Route::middleware(['cekrole:gudang'])->prefix('gudang')->name('gudang.')->group(function () {
        Route::get('/permintaan', [PermintaanGudangController::class, 'index'])->name('permintaan.index');
        Route::post('/permintaan/{permintaan}/proses', [PermintaanGudangController::class, 'proses'])->name('permintaan.proses');
        Route::resource('bahan-baku', BahanBakuController::class);

    });

    Route::middleware(['cekrole:dapur'])->prefix('dapur')->name('dapur.')->group(function () {
        Route::get('/permintaan', [PermintaanDapurController::class, 'index'])->name('permintaan.index');
        Route::get('/permintaan/create', [PermintaanDapurController::class, 'create'])->name('permintaan.create');
        Route::post('/permintaan', [PermintaanDapurController::class, 'store'])->name('permintaan.store');
    });
});