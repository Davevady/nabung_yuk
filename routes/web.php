<?php

use App\Http\Controllers\CashInController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\JenisInController;
use App\Http\Controllers\JenisOutController;
use App\Http\Controllers\CashOutController;
use App\Http\Controllers\KeuanganController;
use App\Http\Controllers\TargetController;

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

Route::get('/', [DashboardController::class, 'landing'])->name('landing');
Route::get('/login', [UserController::class, 'login'])->name('login');
Route::post('/login', [UserController::class, 'authLogin'])->name('auth.login');
Route::get('/register', [UserController::class, 'register'])->name('register');
Route::post('/register', [UserController::class, 'authRegister'])->name('auth.register');
Route::get('/logout', [UserController::class, 'logout'])->name('logout');

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('auth')->name('dashboard');

Route::resource('jenis_in', JenisInController::class)->middleware('auth');
Route::post('jenis_in', [JenisInController::class, 'store'])->middleware('auth')->name('jenis_in.store');

Route::resource('jenis_out', JenisOutController::class)->middleware('auth');
Route::post('jenis_out', [JenisOutController::class, 'store'])->middleware('auth')->name('jenis_out.store');

Route::resource('cash_in', CashInController::class)->middleware('auth');
Route::post('cash_in', [CashInController::class, 'store'])->middleware('auth')->name('cash_in.store');
Route::put('cash_in/{cashIn}/update_media', [CashInController::class, 'updateMedia'])->middleware('auth')->name('cash_in.update_media');
Route::delete('cash_in/{cashIn}/destroy_media', [CashInController::class, 'destroyMedia'])->middleware('auth')->name('cash_in.destroy_media');

Route::resource('cash_out', CashOutController::class)->middleware('auth');
Route::post('cash_out', [CashOutController::class, 'store'])->middleware('auth')->name('cash_out.store');
Route::put('cash_out/{cashOut}/update_media', [CashOutController::class, 'updateMedia'])->middleware('auth')->name('cash_out.update_media');
Route::delete('cash_out/{cashOut}/destroy_media', [CashOutController::class, 'destroyMedia'])->middleware('auth')->name('cash_out.destroy_media');

Route::resource('tujuan', TargetController::class)->middleware('auth');
Route::put('tujuan/{target}/update_media', [TargetController::class, 'updateMedia'])->middleware('auth')->name('tujuan.update_media');

Route::resource('keuangan', KeuanganController::class)->middleware('auth');
Route::put('keuangan/{target}/verifikasi_target', [KeuanganController::class, 'verifikasiTarget'])->middleware('auth')->name('keuangan.verifikasi_target');
