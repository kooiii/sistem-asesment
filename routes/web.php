<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\TujuanPembelajaranController;
use App\Http\Controllers\NilaiFormatifController;
use App\Http\Controllers\NilaiSumatifController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\MapelController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\PresensiSikapController;

/*
|--------------------------------------------------------------------------
| AUTH
|--------------------------------------------------------------------------
*/

Route::get('/', [AuthController::class, 'showLogin']);
Route::get('/login', [AuthController::class, 'showLogin']);
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| AJAX
|--------------------------------------------------------------------------
*/

use App\Models\Guru;
use App\Models\Siswa;

use App\Http\Controllers\DashboardGuruController;

Route::post(
    '/guru/context',
    [DashboardGuruController::class,'ubahContext'])->name('guru.context');

Route::get('/get-siswa/{kelas}', function ($kelas) {
    $guru = Guru::with('kelas')->find(session('id'));

    if (!$guru) {
        abort(403);
    }

    if (!$guru->kelas->pluck('id')->contains($kelas)) {
        abort(403);
    }

    return Siswa::where('kelas_id',$kelas)
                ->orderBy('nama')
                ->get();

});

Route::post('/ganti-context',[AuthController::class,'gantiContext'])->name('ganti.context');


Route::middleware(['ceklogin','cekrole:admin,guru'])->group(function(){

    Route::get('/dashboard', [AuthController::class,'dashboard'])->name('dashboard');

    
    Route::resource('tujuan-pembelajaran',TujuanPembelajaranController::class);

    Route::resource('nilai-formatif', NilaiFormatifController::class);
    Route::resource('nilai-sumatif', NilaiSumatifController::class)->except(['edit','update']);
    Route::resource('guru', GuruController::class);
    Route::resource('siswa', SiswaController::class);
    Route::resource('kelas', KelasController::class);
    Route::resource('mapel', MapelController::class);
    

    Route::get('/guru/{id}/penugasan',[GuruController::class,'penugasan'])->name('guru.penugasan');
    Route::post('/guru/{id}/penugasan',[GuruController::class,'simpanPenugasan'])->name('guru.penugasan.simpan');
   
    Route::get('/presensi',[PresensiSikapController::class,'index'])->name('presensi.index');
    Route::get('/presensi/create',[PresensiSikapController::class,'create'])->name('presensi.create');
    Route::post('/presensi/store',[PresensiSikapController::class,'store'])->name('presensi.store');

    Route::get('/presensi/{id}/edit',[PresensiSikapController::class,'edit'])->name('presensi.edit');
    Route::put('/presensi/{id}',[PresensiSikapController::class,'update'])->name('presensi.update');
    Route::delete('/presensi/{id}',[PresensiSikapController::class,'destroy'])->name('presensi.destroy');

   
    Route::prefix('laporan')->group(function(){

    Route::get('/',[LaporanController::class,'index'])->name('laporan.index');
    Route::get('/pdf',[LaporanController::class,'exportPdf'])->name('laporan.pdf');});
});