<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\TujuanPembelajaranController;
use App\Http\Controllers\NilaiFormatifController;
use App\Http\Controllers\NilaiSumatifController;
use App\Http\Controllers\NilaiController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\MapelController;
use App\http\Controllers\LaporanController;
use App\http\Controllers\PhPengetahuanController;
use App\Http\Controllers\PhKeterampilanController;
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

    Route::get('/ph-pengetahuan',[PhPengetahuanController::class,'index'])->name('ph.pengetahuan.index');
    Route::get('/ph-pengetahuan/create',[PhPengetahuanController::class,'create'])->name('ph.pengetahuan.create');
    Route::post('/ph-pengetahuan/store',[PhPengetahuanController::class,'store'])->name('ph.pengetahuan.store');

    Route::get('/ph-pengetahuan/{id}/edit',[PhPengetahuanController::class,'edit'])->name('ph.pengetahuan.edit');
    Route::put('/ph-pengetahuan/{id}',[PhPengetahuanController::class,'update'])->name('ph.pengetahuan.update');
    Route::delete('/ph-pengetahuan/{id}',[PhPengetahuanController::class,'destroy'])->name('ph.pengetahuan.destroy');

    Route::get('/ph-keterampilan',[PhKeterampilanController::class,'index'])->name('ph.keterampilan.index');
    Route::get('/ph-keterampilan/create',[PhKeterampilanController::class,'create'])->name('ph.keterampilan.create');
    Route::post('/ph-keterampilan/store',[PhKeterampilanController::class,'store'])->name('ph.keterampilan.store');

    Route::get('/ph-keterampilan/{id}/edit',[PhKeterampilanController::class,'edit'])->name('ph.keterampilan.edit');
    Route::put('/ph-keterampilan/{id}',[PhKeterampilanController::class,'update'])->name('ph.keterampilan.update');
    Route::delete('/ph-keterampilan/{id}',[PhKeterampilanController::class,'destroy'])->name('ph.keterampilan.destroy');

   
    Route::get('/presensi',[PresensiSikapController::class,'index'])->name('presensi.index');
    Route::get('/presensi/create',[PresensiSikapController::class,'create'])->name('presensi.create');
    Route::post('/presensi/store',[PresensiSikapController::class,'store'])->name('presensi.store');

    Route::get('/presensi/{id}/edit',[PresensiSikapController::class,'edit'])->name('presensi.edit');
    Route::put('/presensi/{id}',[PresensiSikapController::class,'update'])->name('presensi.update');
    Route::delete('/presensi/{id}',[PresensiSikapController::class,'destroy'])->name('presensi.destroy');

   
    Route::get('/laporan', [LaporanController::class,'index'])->name('laporan');
    Route::get('/laporan/pdf', [LaporanController::class,'exportPdf'])->name('laporan.pdf');
});