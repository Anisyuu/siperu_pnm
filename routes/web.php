<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\GoogleController;

// Controller kasubag
// use App\Http\Controllers\Kasubag\{JadwalController, PeminjamanController, UserController};
use App\Http\Controllers\Kasubag\DashboardController as KasubagDashboardController;
use App\Http\Controllers\Kasubag\JadwalController as KasubagJadwalController;
use App\Http\Controllers\Kasubag\PeminjamanController as KasubagPeminjamanController;
use App\Http\Controllers\Kasubag\UserController as KasubagUserController;
use App\Http\Controllers\Kasubag\KelolaRuanganController as KasubagKelolaRuanganController;
use App\Http\Controllers\Kasubag\RiwayatController as KasubagRiwayatController;
use App\Http\Controllers\Kasubag\{
    GedungController,
    JenisRuangController,
    KampusController,
    RuanganController,
    AlurVerifikasiController
};

// Controller sarpras
use App\Http\Controllers\Sarpras\JadwalController as SarprasJadwalController;
use App\Http\Controllers\Sarpras\PeminjamanController as SarprasPeminjamanController;
use App\Http\Controllers\Sarpras\RiwayatController as SarprasRiwayatController;

// Controller pimpinan
use App\Http\Controllers\Pimpinan\JadwalController as PimpinanJadwalController;
use App\Http\Controllers\Pimpinan\RiwayatController as PimpinanRiwayatController;
use App\Http\Controllers\Pimpinan\PeminjamanController as PimpinanPeminjamanController;

// Controller dosen
use App\Http\Controllers\Dosen\DashboardController as DosenDashboardController;
use App\Http\Controllers\Dosen\JadwalController as DosenJadwalController;
use App\Http\Controllers\Dosen\PeminjamanController as DosenPeminjamanController;
use App\Http\Controllers\Dosen\RiwayatController as DosenRiwayatController;

// Controller ormawa
use App\Http\Controllers\Ormawa\DashboardController as OrmawaDashboardController;
use App\Http\Controllers\Ormawa\PeminjamanController as OrmawaPeminjamanController;
use App\Http\Controllers\Ormawa\JadwalController as OrmawaJadwalController;
use App\Http\Controllers\Ormawa\RiwayatController as OrmawaRiwayatController;

// Controller mahasiswa
use App\Http\Controllers\Mahasiswa\DashboardController as MahasiswaDashboardController;
use App\Http\Controllers\Mahasiswa\JadwalController as MahasiswaJadwalController;
use App\Http\Controllers\Mahasiswa\PeminjamanController as MahasiswaPeminjamanController;
use App\Http\Controllers\Mahasiswa\RiwayatController as MahasiswaRiwayatController;

Route::get('/', function () {
    return redirect()->route('login');
});


Route::get('/auth/google/redirect', [GoogleController::class, 'redirect'])->name('google.redirect');
Route::get('/auth/google/callback', [GoogleController::class, 'callback'])->name('google.callback');

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

Route::middleware(['auth'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])
            ->name('logout');
    Route::get('/kasubag', [KasubagDashboardController::class, 'dashboard'])->name('kasubag.dashboard');
    Route::get('/pimpinan', fn () => view('layouts.pimpinan.dashboard'))->name('pimpinan.dashboard');
    Route::get('/sarpras', fn () => view('layouts.sarpras.dashboard'))->name('sarpras.dashboard');
    Route::get('/ormawa', [OrmawaDashboardController::class, 'dashboard'])->name('ormawa.dashboard');
    Route::get('/dosen', [DosenDashboardController::class, 'dashboard'])->name('dosen.dashboard');
    // Route::get('/karyawan', fn () => view('layouts.karyawan.dashboard'))->name('karyawan.dashboard');
    Route::get('/mahasiswa', [MahasiswaDashboardController::class, 'dashboard'])->name('mahasiswa.dashboard');
});

    // Kasubag
    Route::middleware(['auth', 'role:kasubag'])
    ->prefix('kasubag')
    ->name('kasubag.')
    ->group(function () {

        Route::get('/dashboard', [KasubagDashboardController::class, 'dashboard'])
            ->name('dashboard');

        Route::get('/list-user', [KasubagUserController::class, 'listUser'])
            ->name('list-user');

        Route::get('/detail-user/{nomor_induk}', [KasubagUserController::class, 'detailUser'])
            ->name('detail-user');

        Route::get('/tambah-user', [KasubagUserController::class, 'tambahUser'])
            ->name('tambah-user');

        Route::post('/simpan-user', [KasubagUserController::class, 'simpanUser'])
            ->name('simpan-user');

        Route::get('/edit-user/{nomor_induk}', [KasubagUserController::class, 'editUser'])
            ->name('edit-user');

        Route::put('/update-user/{nomor_induk}', [KasubagUserController::class, 'updateUser'])
            ->name('update-user');

        Route::get('/jadwal-ruangan', [KasubagJadwalController::class, 'jadwalRuangan'])
            ->name('jadwal-ruangan');

        Route::get('/verifikasi-peminjaman', [KasubagPeminjamanController::class, 'verifikasiPeminjaman'])
            ->name('verifikasi-peminjaman');

        Route::get('/riwayat-verifikasi', [App\Http\Controllers\Kasubag\PeminjamanController::class, 'riwayatVerifikasi'])
            ->name('riwayat-verifikasi');

        Route::get('/riwayat-peminjaman', [App\Http\Controllers\Kasubag\PeminjamanController::class, 'riwayatPeminjaman'])
            ->name('riwayat-peminjaman');

        Route::prefix('kampus')->name('kampus.')->group(function () {
            Route::get('/',                        [KampusController::class, 'index'])->name('index');
            Route::post('/',                       [KampusController::class, 'store'])->name('store');
            Route::put('/{kampus}',                [KampusController::class, 'update'])->name('update');
            Route::delete('/{kampus}',             [KampusController::class, 'destroy'])->name('destroy');
        });

        Route::prefix('gedung')->name('gedung.')->group(function () {
            Route::get('/{slug}', [GedungController::class, 'index'])
                ->name('index');
            Route::post('/',                       [GedungController::class, 'store'])->name('store');
            Route::put('/{gedung}',                [GedungController::class, 'update'])->name('update');
            Route::delete('/{gedung}',             [GedungController::class, 'destroy'])->name('destroy');
        });

        Route::prefix('ruangan')->name('ruangan.')->group(function () {
            Route::get('/gedung/{slug}/lantai/{lantai}', [RuanganController::class, 'index'])->name('index');
            Route::post('/',                       [RuanganController::class, 'store'])->name('store');
            Route::put('/{ruangan}',               [RuanganController::class, 'update'])->name('update');
            Route::delete('/{ruangan}',            [RuanganController::class, 'destroy'])->name('destroy');
        });

        Route::prefix('jenis-ruang')->name('jenis-ruang.')->group(function () {
            Route::get('/',                        [JenisRuangController::class, 'index'])->name('index');
            Route::post('/',                       [JenisRuangController::class, 'store'])->name('store');
            Route::put('/{jenisRuang}',            [JenisRuangController::class, 'update'])->name('update');
            Route::delete('/{jenisRuang}',         [JenisRuangController::class, 'destroy'])->name('destroy');
        });

        Route::prefix('alur-verifikasi')->name('alur-verifikasi.')->group(function () {
            Route::get('/',                        [AlurVerifikasiController::class, 'index'])->name('index');
            Route::post('/',                       [AlurVerifikasiController::class, 'store'])->name('store');
            Route::delete('/{id}',                [AlurVerifikasiController::class, 'destroy'])->name('destroy');
            Route::get('/{jenis}',                [AlurVerifikasiController::class, 'show'])->name('show');
        });

           // Daftar peminjaman yang perlu diverifikasi
        Route::get('/verifikasi', [App\Http\Controllers\Kasubag\VerifikasiController::class, 'index'])
            ->name('verifikasi.index');

        // Approve satu langkah
        Route::patch('/verifikasi/{peminjaman}/approve', [App\Http\Controllers\Kasubag\VerifikasiController::class, 'approve'])
            ->name('peminjaman.approve');

        // Reject (selesaikan semua langkah)
        Route::patch('/verifikasi/{peminjaman}/reject', [App\Http\Controllers\Kasubag\VerifikasiController::class, 'reject'])
            ->name('peminjaman.reject');

    });

    // Sarpras
    Route::middleware(['auth', 'role:sarpras'])
    ->prefix('sarpras')
    ->name('sarpras.')
    ->group(function () {

        Route::get('/dashboard', fn () => view('layouts.sarpras.dashboard'))
            ->name('dashboard');

        Route::get('/verifikasi-peminjaman', [SarprasPeminjamanController::class, 'verifikasiPeminjaman'])
            ->name('verifikasi-peminjaman');

        Route::get('/riwayat-verifikasi', [SarprasPeminjamanController::class, 'riwayatVerifikasi'])
            ->name('riwayat-verifikasi');

        Route::get('kelola-jadwal', [SarprasJadwalController::class, 'kelolaJadwal'])
            ->name('kelola-jadwal');

        Route::get('/tambah-jadwal', [SarprasJadwalController::class, 'tambahJadwal'])
            ->name('tambah-jadwal');

        Route::post('/simpan-jadwal', [SarprasJadwalController::class, 'simpanJadwal'])
            ->name('simpan-jadwal');

        Route::get('/edit-jadwal/{id}', [SarprasJadwalController::class, 'editJadwal'])
            ->name('edit-jadwal');

        Route::put('/update-jadwal/{id}', [SarprasJadwalController::class, 'updateJadwal'])
            ->name('update-jadwal');

        Route::delete('/hapus-jadwal/{id}', [SarprasJadwalController::class, 'hapusJadwal'])
            ->name('hapus-jadwal');

                // Daftar peminjaman yang perlu diverifikasi
        Route::get('/verifikasi', [App\Http\Controllers\Sarpras\VerifikasiController::class, 'index'])
            ->name('verifikasi.index');

        // Approve satu langkah
        Route::patch('/verifikasi/{peminjaman}/approve', [App\Http\Controllers\Sarpras\VerifikasiController::class, 'approve'])
            ->name('peminjaman.approve');

        // Reject (selesaikan semua langkah)
        Route::patch('/verifikasi/{peminjaman}/reject', [App\Http\Controllers\Sarpras\VerifikasiController::class, 'reject'])
            ->name('peminjaman.reject');
    });

    // Pimpinan
    Route::middleware(['auth', 'role:pimpinan'])
    ->prefix('pimpinan')
    ->name('pimpinan.')
    ->group(function () {

        Route::get('/dashboard', fn () => view('layouts.pimpinan.dashboard'))
            ->name('dashboard');

        Route::get('/jadwal-ruangan', [PimpinanJadwalController::class, 'jadwalRuangan'])
            ->name('jadwal-ruangan');

        Route::get('/verifikasi-peminjaman', [PimpinanPeminjamanController::class, 'verifikasiPeminjaman'])
            ->name('verifikasi-peminjaman');

        Route::get('/riwayat-verifikasi', [PimpinanPeminjamanController::class, 'riwayatVerifikasi'])
            ->name('riwayat-verifikasi');


        // Daftar peminjaman yang perlu diverifikasi
        Route::get('/verifikasi', [App\Http\Controllers\Pimpinan\VerifikasiController::class, 'index'])
            ->name('verifikasi.index');

        // Approve satu langkah
        Route::patch('/verifikasi/{peminjaman}/approve', [App\Http\Controllers\Pimpinan\VerifikasiController::class, 'approve'])
            ->name('peminjaman.approve');

        // Reject (selesaikan semua langkah)
        Route::patch('/verifikasi/{peminjaman}/reject', [App\Http\Controllers\Pimpinan\VerifikasiController::class, 'reject'])
            ->name('peminjaman.reject');

    });

    // Dosen
    Route::middleware(['auth', 'role:dosen'])
    ->prefix('dosen')
    ->name('dosen.')
    ->group(function () {

        Route::get('/dashboard', [DosenDashboardController::class, 'dashboard'])
            ->name('dashboard');

        Route::get('/jadwal-ruangan', [DosenJadwalController::class, 'jadwalRuangan'])
            ->name('jadwal-ruangan');

        Route::get('/list-peminjaman', [DosenPeminjamanController::class, 'listPeminjaman'])
            ->name('list-peminjaman');

        Route::get('/ajukan-peminjaman', [DosenPeminjamanController::class, 'ajukanPeminjaman'])
            ->name('ajukan-peminjaman');

        Route::post('/simpan-peminjaman', [DosenPeminjamanController::class, 'store'])
            ->name('simpan-peminjaman');

        Route::get('/detail-peminjaman/{id}', [DosenPeminjamanController::class, 'detailPeminjaman'])
            ->name('detail-peminjaman');

        Route::delete('/batalkan-peminjaman/{id}', [DosenPeminjamanController::class, 'batalkanPeminjaman'])
            ->name('batalkan-peminjaman');

        Route::get('/riwayat-peminjaman', [DosenRiwayatController::class, 'riwayatPeminjaman'])
            ->name('riwayat-peminjaman');
    });

    // Ormawa
    Route::middleware(['auth', 'role:ormawa'])
    ->prefix('ormawa')
    ->name('ormawa.')
    ->group(function () {

        Route::get('/dashboard', [OrmawaDashboardController::class, 'dashboard'])
            ->name('dashboard');

        Route::get('/jadwal-ruangan', [OrmawaJadwalController::class, 'jadwalRuangan'])
            ->name('jadwal-ruangan');

        Route::get('/list-peminjaman', [OrmawaPeminjamanController::class, 'listPeminjaman'])
            ->name('list-peminjaman');

        Route::get('/ajukan-peminjaman', [OrmawaPeminjamanController::class, 'ajukanPeminjaman'])
            ->name('ajukan-peminjaman');

        Route::post('/simpan-peminjaman', [OrmawaPeminjamanController::class, 'store'])
            ->name('simpan-peminjaman');

        Route::get('/detail-peminjaman/{id}', [OrmawaPeminjamanController::class, 'detailPeminjaman'])
            ->name('detail-peminjaman');

        Route::delete('/batalkan-peminjaman/{id}', [OrmawaPeminjamanController::class, 'batalkanPeminjaman'])
            ->name('batalkan-peminjaman');

        Route::get('/riwayat-peminjaman', [OrmawaPeminjamanController::class, 'riwayatPeminjaman'])
            ->name('riwayat-peminjaman');
    });

    // Mahasiswa
    Route::middleware(['auth', 'role:mahasiswa'])
    ->prefix('mahasiswa')
    ->name('mahasiswa.')
    ->group(function () {

        Route::get('/dashboard', [MahasiswaDashboardController::class, 'dashboard'])
            ->name('dashboard');

        Route::get('/jadwal-ruangan', [MahasiswaJadwalController::class, 'jadwalRuangan'])
            ->name('jadwal-ruangan');

        Route::get('/list-peminjaman', [MahasiswaPeminjamanController::class, 'listPeminjaman'])
            ->name('list-peminjaman');

        Route::get('/ajukan-peminjaman', [MahasiswaPeminjamanController::class, 'ajukanPeminjaman'])
            ->name('ajukan-peminjaman');

        Route::post('/simpan-peminjaman', [MahasiswaPeminjamanController::class, 'store'])
            ->name('simpan-peminjaman');

        Route::get('/detail-peminjaman/{id}', [MahasiswaPeminjamanController::class, 'detailPeminjaman'])
            ->name('detail-peminjaman');

        Route::delete('/batalkan-peminjaman/{id}', [MahasiswaPeminjamanController::class, 'batalkanPeminjaman'])
            ->name('batalkan-peminjaman');

        Route::get('/riwayat-peminjaman', [MahasiswaPeminjamanController::class, 'riwayatPeminjaman'])
            ->name('riwayat-peminjaman');
    });
// Contoh Pengelompoka route auth sesuai role
// Route::middleware(['auth', 'role:pimpinan'])->group(function () {
//     Route::get('/pimpinan', ...);
// });
