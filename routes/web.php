<?php

use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DendaController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KategoriRakController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\TransaksiController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// =============================================
// REDIRECT ROOT
// =============================================
Route::get('/', function () {
    return redirect('/home');
});

// =============================================
// ROUTE PUBLIC (TANPA LOGIN)
// =============================================

// Auth
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.store');
Route::get('/log-in', [AuthController::class, 'showLogin'])->name('log-in');
Route::post('/log-in', [AuthController::class, 'login'])->name('login.process');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/forced-logout', [AuthController::class, 'logout']);

// Halaman Public
Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::view('/tentang-perpustakaan', 'tentang-perpustakaan')->name('tentang-perpustakaan');

// Katalog Public
Route::get('/katalog', [BukuController::class, 'katalog'])->name('katalog');
Route::get('/informasi-buku/{buku}', [BukuController::class, 'show']);


// =============================================
// ROUTE ANGGOTA (LOGIN REQUIRED)
// =============================================
Route::middleware(['auth', 'role:anggota'])->group(function () {

    // Halaman
    Route::get('/home-anggota', [DashboardController::class, 'homeAnggota'])->name('home-anggota');
    Route::get('/dashboard-anggota', [DashboardController::class, 'anggota'])->name('dashboard-anggota');
    Route::get('/katalog-anggota', [BukuController::class, 'katalogAnggota'])->name('katalog-anggota');
    Route::view('/tentang-perpustakaan-anggota', 'tentang-perpustakaan-anggota')->name('tentang-perpustakaan-anggota');

    // Profil Anggota
    Route::get('/profil-anggota', [AnggotaController::class, 'profil'])->name('profil-anggota');
    Route::patch('/profil-anggota', [AnggotaController::class, 'updateProfil'])->name('profil-anggota.update');
    Route::patch('/profil-anggota/password', [AnggotaController::class, 'updatePassword'])->name('profil-anggota.password');

    // Riwayat & Denda Anggota
    Route::get('/riwayat-peminjaman', [TransaksiController::class, 'riwayatAnggota'])->name('riwayat-peminjaman');
    Route::get('/status-denda', [DendaController::class, 'statusAnggota'])->name('status-denda');

});


// =============================================
// ROUTE ADMIN (LOGIN REQUIRED)
// =============================================
Route::middleware(['auth', 'role:admin'])->group(function () {

    // Halaman
    Route::get('/home-admin', [DashboardController::class, 'homeAdmin'])->name('home-admin');
    Route::get('/dashboard-admin', [DashboardController::class, 'admin'])->name('dashboard.admin');
    Route::get('/katalog-admin', [BukuController::class, 'katalogAdmin'])->name('katalog-admin');
    Route::view('/tentang-perpustakaan-admin', 'tentang-perpustakaan-admin')->name('tentang-perpustakaan-admin');

    // Setting & Laporan
    Route::get('/setting', [SettingController::class, 'index'])->name('setting');
    Route::patch('/setting/perpustakaan', [SettingController::class, 'updatePerpustakaan'])->name('setting.perpustakaan.update');
    Route::patch('/setting/admin', [SettingController::class, 'updateAdmin'])->name('setting.admin.update');
    Route::patch('/setting/password', [SettingController::class, 'updatePassword'])->name('setting.password.update');

    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan');
    Route::post('/laporan/cetak', [LaporanController::class, 'cetak'])->name('laporan.cetak');

    // Manajemen Buku
    Route::get('/kelola-buku', [BukuController::class, 'indexAdmin'])->name('buku.index');
    Route::get('/tambah-buku', [BukuController::class, 'create'])->name('buku.create');
    Route::post('/tambah-buku', [BukuController::class, 'store'])->name('buku.store');
    Route::get('/edit-buku/{buku}', [BukuController::class, 'edit'])->name('buku.edit');
    Route::put('/edit-buku/{buku}', [BukuController::class, 'update'])->name('buku.update');
    Route::delete('/buku/{buku}', [BukuController::class, 'destroy'])->name('buku.destroy');
    Route::get('/informasi-buku-admin/{buku}', [BukuController::class, 'showAdmin'])->name('buku.show.admin');

    // Manajemen Kategori & Rak
    Route::get('/kategori-rak', [KategoriRakController::class, 'index'])->name('kategori-rak');
    Route::post('/kategori-rak/kategori', [KategoriRakController::class, 'storeKategori'])->name('kategori-rak.kategori.store');
    Route::post('/kategori-rak/rak', [KategoriRakController::class, 'storeRak'])->name('kategori-rak.rak.store');
    Route::delete('/kategori-rak/kategori/{kategori}', [KategoriRakController::class, 'destroyKategori'])->name('kategori-rak.kategori.destroy');
    Route::delete('/kategori-rak/rak/{rak}', [KategoriRakController::class, 'destroyRak'])->name('kategori-rak.rak.destroy');

    // Manajemen Anggota
    Route::get('/kelola-anggota', [AnggotaController::class, 'index'])->name('kelola-anggota');
    Route::get('/tambah-anggota', [AnggotaController::class, 'create'])->name('tambah-anggota');
    Route::post('/tambah-anggota', [AnggotaController::class, 'store'])->name('anggota.store');
    Route::patch('/anggota/{anggota}/approve', [AnggotaController::class, 'approve'])->name('anggota.approve');
    Route::patch('/anggota/{anggota}/reject', [AnggotaController::class, 'reject'])->name('anggota.reject');
    Route::patch('/anggota/{anggota}/activate', [AnggotaController::class, 'activate'])->name('anggota.activate');
    Route::patch('/anggota/{anggota}/deactivate', [AnggotaController::class, 'deactivate'])->name('anggota.deactivate');
    Route::delete('/anggota/{anggota}', [AnggotaController::class, 'destroy'])->name('anggota.destroy');

    // Manajemen Transaksi
    Route::get('/riwayat-transaksi', [TransaksiController::class, 'index'])->name('riwayat-transaksi');
    Route::get('/input-peminjaman', [TransaksiController::class, 'create'])->name('input-peminjaman');
    Route::post('/input-peminjaman', [TransaksiController::class, 'store'])->name('transaksi.store');
    Route::get('/detail-transaksi/{transaksi}', [TransaksiController::class, 'show'])->name('detail-transaksi');
    Route::patch('/pengembalian/{detailTransaksi}', [TransaksiController::class, 'returnBook'])->name('transaksi.return');

    // Manajemen Denda
    Route::get('/kelola-denda', [DendaController::class, 'index'])->name('kelola-denda');
    Route::get('/detail-denda/{denda}', [DendaController::class, 'show'])->name('denda.show');
    Route::post('/denda/{denda}/pembayaran', [DendaController::class, 'storePembayaran'])->name('denda.pembayaran.store');
    Route::patch('/pembayaran-denda/{pembayaranDenda}/validasi', [DendaController::class, 'validasiPembayaran'])->name('pembayaran-denda.validasi');
    Route::patch('/pembayaran-denda/{pembayaranDenda}/tolak', [DendaController::class, 'tolakPembayaran'])->name('pembayaran-denda.tolak');
    Route::patch('/denda/{denda}/lunasi', [DendaController::class, 'lunasiManual'])->name('denda.lunasi');

});

// Route fallback untuk link dummy (tetap di luar middleware)
Route::get('/detail-denda', function () {
    return redirect()->route('kelola-denda');
})->name('detail-denda');