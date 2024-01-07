<?php

use App\Http\Controllers\CutiController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\IzinController;
use App\Http\Controllers\JenisCutiController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\LamaranController;
use App\Http\Controllers\LokasiKerjaController;
use App\Http\Controllers\LowonganController;
use App\Http\Controllers\PhkController;
use App\Http\Controllers\PresensiController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return redirect()->route('career.index');
});


// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/career', [LowonganController::class, 'career'])->name('career.index');
Route::get('/career/{career}/detail', [LowonganController::class, 'detailCareer'])->name('career.detail');
Route::get('/career/{career}/kirim-lamaran', [LamaranController::class, 'create'])->name('career.kirim-lamaran');
Route::post('/career/kirim-lamaran', [LamaranController::class, 'store'])->name('career.store');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    //dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

    //lowongan
    Route::get('/lowongan', [LowonganController::class, 'index'])->name('lowongan.index');
    Route::get('/lowongan/create', [LowonganController::class, 'create'])->name('lowongan.create');
    Route::get('/lowongan/{lowongan}/edit', [LowonganController::class, 'edit'])->name('lowongan.edit');
    Route::post('/lowongan', [LowonganController::class, 'store'])->name('lowongan.store');
    Route::patch('/lowongan/{lowongan}/update', [LowonganController::class, 'update'])->name('lowongan.update');
    Route::delete('/lowongan/{lowongan}/delete', [LowonganController::class, 'destroy'])->name('lowongan.destroy');

    //lamaran
    Route::get('/lamaran', [LamaranController::class, 'index'])->name('lamaran.index');
    Route::delete('/lamaran/{lamaran}/delete', [LamaranController::class, 'destroy'])->name('lamaran.destroy');

    //karyawan
    Route::get('/karyawan', [KaryawanController::class, 'index'])->name('karyawan.index');
    Route::get('/karyawan/create', [KaryawanController::class, 'create'])->name('karyawan.create');
    Route::get('/karyawan/{karyawan}/edit', [KaryawanController::class, 'edit'])->name('karyawan.edit');
    Route::post('/karyawan', [KaryawanController::class, 'store'])->name('karyawan.store');
    Route::patch('/karyawan/{karyawan}/update', [KaryawanController::class, 'update'])->name('karyawan.update');
    Route::delete('/karyawan/{karyawan}/delete', [KaryawanController::class, 'destroy'])->name('karyawan.destroy');


    //presensi
    Route::get('/presensi', [PresensiController::class, 'index'])->name('presensi.index');
    Route::get('/presensi/data/karyawan', [PresensiController::class, 'dataPresensi'])->name('presensi.data');
    Route::post('/presensi/store', [PresensiController::class, 'store'])->name('presensi.store');
    Route::patch('/presensi/{presensi}/update', [PresensiController::class, 'update'])->name('presensi.update');
    Route::get('/presensi/cetak/{bulan}', [PresensiController::class, 'cetak'])->name('presensi.cetak');

    //jenis cuti
    Route::get('/jenis-cuti', [JenisCutiController::class, 'index'])->name('jenis-cuti.index');
    Route::post('/jenis-cuti', [JenisCutiController::class, 'store'])->name('jenis-cuti.store');
    Route::patch('/jenis-cuti/{jenisCuti}/update', [JenisCutiController::class, 'update'])->name('jenis-cuti.update');
    Route::delete('/jenis-cuti/{jenisCuti}/delete', [JenisCutiController::class, 'destroy'])->name('jenis-cuti.destroy');

    //cuti
    Route::get('/cuti', [CutiController::class, 'index'])->name('cuti.index');
    Route::post('/cuti', [CutiController::class, 'store'])->name('cuti.store');
    Route::patch('/cuti/{cuti}/update', [CutiController::class, 'update'])->name('cuti.update');
    Route::delete('/cuti/{cuti}/delete', [CutiController::class, 'destroy'])->name('cuti.destroy');
    Route::get('/data/cuti/karyawan', [CutiController::class, 'getDatabyUser'])->name('cuti.data');

    //izin
    Route::get('/izin', [IzinController::class, 'index'])->name('izin.index');
    Route::get('/izin/data/karyawan', [IzinController::class, 'getDatabyUser'])->name('izin.data');
    Route::post('/izin', [IzinController::class, 'store'])->name('izin.store');
    Route::patch('/izin/{izin}/update', [IzinController::class, 'update'])->name('izin.update');
    Route::delete('/izin/{izin}/delete', [IzinController::class, 'destroy'])->name('izin.destroy');

    //phk
    Route::get('/phk', [PhkController::class, 'index'])->name('phk.index');
    Route::post('/phk', [PhkController::class, 'store'])->name('phk.store');
    Route::patch('/phk/{phk}/update', [PhkController::class, 'update'])->name('phk.update');
    Route::delete('/phk/{phk}/delete', [PhkController::class, 'destroy'])->name('phk.destroy');

    //lokasi
    Route::get('/lokasi', [LokasiKerjaController::class, 'index'])->name('lokasi.index');
    Route::post('/lokasi', [LokasiKerjaController::class, 'store'])->name('lokasi.store');
    Route::patch('/lokasi/{lokasiKerja}/update', [LokasiKerjaController::class, 'update'])->name('lokasi.update');
    Route::delete('/lokasi/{lokasiKerja}/delete', [LokasiKerjaController::class, 'destroy'])->name('lokasi.destroy');
});

require __DIR__ . '/auth.php';
