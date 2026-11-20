
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
use App\Http\Controllers\RaporController;
use App\Http\Controllers\DashboardGuruController;
use App\Models\Guru;
use App\Models\Siswa;

/*
|--------------------------------------------------------------------------
| AUTH
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');

Route::post('/login', [AuthController::class, 'login'])->name('login.post');

Route::get('/logout', [AuthController::class, 'logout'])->name('logout');


/*
|--------------------------------------------------------------------------
| DASHBOARD ADMIN DAN GURU
|--------------------------------------------------------------------------
*/

Route::middleware(['ceklogin', 'cekrole:admin,guru'])->group(function () {

    // Dashboard Admin dan Guru
    Route::get('/dashboard', [AuthController::class, 'dashboard'])
        ->name('dashboard');

    // Rekap Nilai Admin dan Guru
    Route::prefix('laporan')->group(function () {

        Route::get('/', [LaporanController::class, 'index'])
            ->name('laporan.index');

        Route::get('/pdf', [LaporanController::class, 'exportPdf'])
            ->name('laporan.pdf');

    });

});


/*
|--------------------------------------------------------------------------
| AKSES KHUSUS ADMIN
|--------------------------------------------------------------------------
| Admin dapat mengelola data master dan memantau rekap nilai.
| Admin tidak mendapatkan route untuk menginput atau mengubah nilai.
|--------------------------------------------------------------------------
*/

Route::middleware(['ceklogin', 'cekrole:admin'])->group(function () {

    // Pengelolaan data master
    Route::resource('guru', GuruController::class);
    Route::resource('siswa', SiswaController::class);
    Route::resource('kelas', KelasController::class);
    Route::resource('mapel', MapelController::class);

    // Penugasan guru
    Route::get('/guru/{id}/penugasan', [GuruController::class, 'penugasan'])
        ->name('guru.penugasan');

    Route::post('/guru/{id}/penugasan', [GuruController::class, 'simpanPenugasan'])
        ->name('guru.penugasan.simpan');

});


/*
|--------------------------------------------------------------------------
| AKSES KHUSUS GURU
|--------------------------------------------------------------------------
| Guru dapat mengelola penilaian sesuai penugasan dan konteksnya.
|--------------------------------------------------------------------------
*/

Route::middleware(['ceklogin', 'cekrole:guru'])->group(function () {

    // Ubah konteks kelas dan mata pelajaran
    Route::post('/guru/context', [DashboardGuruController::class, 'ubahContext'])
        ->name('guru.context');

    Route::post('/ganti-context', [AuthController::class, 'gantiContext'])
        ->name('ganti.context');

    // Mengambil data siswa berdasarkan kelas yang diampu
    Route::get('/get-siswa/{kelas}', function ($kelas) {

        $guru = Guru::with('kelas')->find(session('id'));

        if (!$guru) {
            abort(403);
        }

        if (!$guru->kelas->pluck('id')->contains((int) $kelas)) {
            abort(403);
        }

        return Siswa::where('kelas_id', $kelas)
            ->orderBy('nama')
            ->get();

    })->name('guru.get-siswa');


    // Tujuan Pembelajaran
    Route::resource('tujuan-pembelajaran', TujuanPembelajaranController::class);

    // Penilaian Formatif
    Route::resource('nilai-formatif', NilaiFormatifController::class)
        ->only(['index', 'create', 'store']);

    // Penilaian Sumatif
    Route::resource('nilai-sumatif', NilaiSumatifController::class)
        ->except(['edit', 'update']);

    // Presensi dan Sikap
    Route::get('/presensi', [PresensiSikapController::class, 'index'])
        ->name('presensi.index');

    Route::get('/presensi/create', [PresensiSikapController::class, 'create'])
        ->name('presensi.create');

    Route::post('/presensi/store', [PresensiSikapController::class, 'store'])
        ->name('presensi.store');

    Route::get('/presensi/{id}/edit', [PresensiSikapController::class, 'edit'])
        ->name('presensi.edit');

    Route::put('/presensi/{id}', [PresensiSikapController::class, 'update'])
        ->name('presensi.update');

    Route::delete('/presensi/{id}', [PresensiSikapController::class, 'destroy'])
        ->name('presensi.destroy');

    // Rapor Guru
    Route::resource('rapor', RaporController::class)
        ->only(['index', 'show']);

    Route::get('/rapor/{id}/pdf', [RaporController::class, 'pdf'])
        ->name('rapor.pdf');


});
