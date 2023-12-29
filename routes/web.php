<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LamaranController;
use App\Http\Controllers\LowonganController;
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
});

require __DIR__ . '/auth.php';
