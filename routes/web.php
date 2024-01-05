<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DetailSkemaController;
use App\Http\Controllers\SkemaController;
use App\Http\Controllers\Dashboard;
use App\Http\Controllers\Login;
use App\Http\Controllers\CobaController;

Route::get('/', function () {
    return view('login.login');
});

// Route untuk menampilkan halaman dashboard
Route::get('dashboard/home', [Dashboard::class, 'index'])->name('dashboard.home');

// Route untuk mendapatkan data peserta berdasarkan tahun
Route::get('/getDataForYear/{year}', [Dashboard::class, 'getDataForYear'])->name('dashboard.getDataForYear');

Route::get('dashboard/export/excel', [Dashboard::class, 'export_excel'])->name('dashboard.export.excel');
// Tambahkan route untuk menampilkan dashboard prodi
Route::get('/dashboard/prodi/{prodiId}', [Dashboard::class, 'showProdiChart'])->name('dashboard.prodi');

Route::get('/login/login', [Login::class, 'index']);
Route::post('/login/masuk', [Login::class, 'loginPost'])->name('login.masuk');

Route::get('/skema', [SkemaController::class, 'index'])->name('skema.index');
Route::get('/skema/{skm_id}/edit', [SkemaController::class, 'edit'])->name('skema.edit');
Route::put('/skema/{skm_id}/update', [SkemaController::class, 'update'])->name('skema.update');
Route::get('/skema/{skm_id}/details', [SkemaController::class, 'showDetails'])->name('skema.detail');
Route::get('/skema/create', [SkemaController::class, 'create'])->name('skema.create');
Route::post('/skema/store', [SkemaController::class, 'store'])->name('skema.store');
Route::get('/detailskema/edit/{id}', [DetailSkemaController::class, 'edit'])->name('detailskema.edit');
Route::put('/detailskema/{id}',  [DetailSkemaController::class, 'update'])->name('detailskema.update');
