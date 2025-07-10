<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\SerahterimaController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\LoginsController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

//login
Route::get('/', [DashboardController::class, 'index'])->middleware('auth');

//punya barang
Route::get('/barang', [BarangController::class, 'index'])->middleware('auth');
Route::get('/tambah-barang', [BarangController::class, 'tambahBarang'])->middleware('auth');
Route::post('/simpan-barang', [BarangController::class, 'simpan'])->middleware('auth');
Route::get('/edit-barang/{idBrg}', [BarangController::class, 'edit'])->middleware('auth');
Route::post('/update-barang', [BarangController::class, 'update'])->middleware('auth');
Route::get('/hapus-barang/{idBrg}', [BarangController::class, 'delete'])->middleware('auth');

//punya peminjaman
Route::get('/persetujuan-admin', [PeminjamanController::class, 'index'])->middleware('auth');
Route::get('/persetujuan-wadir', [PeminjamanController::class, 'index'])->middleware('auth');
Route::get('/pengambilan-barang', [PeminjamanController::class, 'index'])->middleware('auth');
Route::get('/tambah-peminjaman', [PeminjamanController::class, 'tambahPeminjaman'])->middleware('auth');
Route::post('/simpan-peminjaman', [PeminjamanController::class, 'simpan'])->middleware('auth');
Route::get('/hapus-peminjaman/{idPinjam}', [PeminjamanController::class, 'delete'])->middleware('auth');
Route::get('/update-status-peminjamanA/{idPinjam}', [PeminjamanController::class, 'updateStatusAdm'])->middleware('auth');
Route::get('/update-status-peminjamanW/{idPinjam}', [PeminjamanController::class, 'updateStatusWd'])->middleware('auth');
Route::get('/update-status-peminjamanS/{idPinjam}', [PeminjamanController::class, 'updsateStatusSt'])->middleware('auth');

Route::get('/laporan-peminjaman', [LaporanController::class, 'index'])->middleware('auth');

//punya serah terima
Route::get('/serah-terima', [SerahterimaController::class, 'index'])->middleware('auth');
Route::post('/tambah-serahterima', [SerahterimaController::class, 'simpan'])->name('tambah-serahterima')->middleware('auth');
Route::post('/serah-terima/update/{idSerahterima}', [SerahterimaController::class, 'update'])->name('serah-terima.update')->middleware('auth');

Route::get('/login', [LoginsController::class, 'index'])->name('login')->middleware('guest');
Route::post('/login', [LoginsController::class, 'login']);
Route::get('/logout', [LoginsController::class, 'logout'])->middleware('auth');