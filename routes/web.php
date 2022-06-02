<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MahasiswaController;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::resource('mahasiswa', MahasiswaController::class);

Route::get('/mahasiswa/cetakpdf/{mahasiswa}', [MahasiswaController::class, 'cetak_pdf'])->name('pdf');
Route::get('/search-mahasiswa', [MahasiswaController::class, 'cari'])->name('cari');
Route::get('mahasiswa/nilai/{id_mahasiswa}', [MahasiswaController::class, 'nilai'])->name('nilai');