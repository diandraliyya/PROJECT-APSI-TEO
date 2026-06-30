<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/home');
});

// Public pages
Route::view('/register', 'register')->name('register');
Route::view('/log-in', 'log-in')->name('log-in');
Route::view('/home', 'home')->name('home');
Route::view('/katalog', 'katalog')->name('katalog');
Route::view('/informasi-buku', 'informasi-buku')->name('informasi-buku');
Route::view('/tentang-perpustakaan', 'tentang-perpustakaan')->name('tentang-perpustakaan');

// Anggota pages
Route::view('/home-anggota', 'home-anggota')->name('home-anggota');
Route::view('/katalog-anggota', 'katalog-anggota')->name('katalog-anggota');
Route::view('/tentang-perpustakaan-anggota', 'tentang-perpustakaan-anggota')->name('tentang-perpustakaan-anggota');
Route::view('/dashboard-anggota', 'dashboard-anggota')->name('dashboard-anggota');
Route::view('/riwayat-peminjaman', 'riwayat-peminjaman')->name('riwayat-peminjaman');
Route::view('/status-denda', 'status-denda')->name('status-denda');
Route::view('/profil-anggota', 'profil-anggota')->name('profil-anggota');

// Admin pages
Route::view('/home-admin', 'home-admin')->name('home-admin');
Route::view('/katalog-admin', 'katalog-admin')->name('katalog-admin');
Route::view('/tentang-perpustakaan-admin', 'tentang-perpustakaan-admin')->name('tentang-perpustakaan-admin');
Route::view('/dashboard-admin', 'dashboard-admin')->name('dashboard-admin');
Route::view('/kelola-buku', 'kelola-buku')->name('kelola-buku');
Route::view('/tambah-buku', 'tambah-buku')->name('tambah-buku');
Route::view('/edit-buku', 'edit-buku')->name('edit-buku');
Route::view('/kelola-anggota', 'kelola-anggota')->name('kelola-anggota');
Route::view('/tambah-anggota', 'tambah-anggota')->name('tambah-anggota');
Route::view('/riwayat-transaksi', 'riwayat-transaksi')->name('riwayat-transaksi');
Route::view('/input-peminjaman', 'input-peminjaman')->name('input-peminjaman');
Route::view('/detail-transaksi', 'detail-transaksi')->name('detail-transaksi');
Route::view('/kelola-denda', 'kelola-denda')->name('kelola-denda');
Route::view('/detail-denda', 'detail-denda')->name('detail-denda');
Route::view('/laporan', 'laporan')->name('laporan');
Route::view('/setting', 'setting')->name('setting');
Route::view('/kategori-rak', 'kategori-rak')->name('kategori-rak');