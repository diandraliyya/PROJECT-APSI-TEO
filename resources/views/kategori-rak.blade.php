<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Kategori & Rak – Perpustakaan SMAIT Al-Uswah</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style-home.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style-home-anggota.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style-home-admin.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style-kategori-rak.css') }}">
</head>
<body class="admin-page">

    {{-- ===== NAVBAR ===== --}}
    <header class="navbar">
        <div class="navbar-inner">
            <a href="{{ route('home-admin') }}" class="nav-brand">
                <img src="{{ asset('assets/logo.png') }}" alt="Logo" class="nav-logo">
                <span class="nav-brand-name">Al-Uswah Library</span>
            </a>
            <nav class="nav-links">
                <a href="{{ route('dashboard-admin') }}" class="nav-link">Dashboard</a>
                <a href="{{ route('katalog-admin') }}" class="nav-link">Katalog</a>
                <a href="{{ route('tentang-perpustakaan-admin') }}" class="nav-link">Tentang</a>
                <a href="{{ route('kelola-buku') }}" class="nav-link active">Buku</a>
                <a href="{{ route('kelola-anggota') }}" class="nav-link">Anggota</a>
                <a href="{{ route('riwayat-transaksi') }}" class="nav-link">Transaksi</a>
                <a href="{{ route('kelola-denda') }}" class="nav-link">Denda</a>
            </nav>
            <a href="{{ route('setting') }}" class="nav-profile">
                <div class="nav-avatar"><div class="avatar-placeholder admin-avatar">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                </div></div>
                <div class="nav-profile-info">
                    <span class="nav-username">{{ auth()->user()?->nama_lengkap ?? 'Admin' }}</span>
                    <span class="nav-role">Administrator</span>
                </div>
            </a>
        </div>
    </header>

    {{-- ===== HERO ===== --}}
    <section class="kr-hero">
        <div class="kr-hero-inner">
            <div>
                <h1 class="kr-title">Manajemen Kategori &amp; Rak</h1>
                <p class="kr-desc">Kelola pengelompokan buku dan tata letak perpustakaan agar lebih terorganisir.</p>
            </div>
            <div class="kr-hero-deco">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="#b8742f" stroke="none"><path d="M12 2l2.4 7.4H22l-6.2 4.5 2.4 7.4L12 17l-6.2 4.3 2.4-7.4L2 9.4h7.6z"/></svg>
                <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 24 24" fill="#90C3C6" stroke="none"><path d="M12 2l2.4 7.4H22l-6.2 4.5 2.4 7.4L12 17l-6.2 4.3 2.4-7.4L2 9.4h7.6z"/></svg>
            </div>
        </div>
    </section>

    {{-- ===== MODE TOGGLE ===== --}}
    <section class="kr-toggle-section">
        <div class="kr-toggle-inner">
            <div class="kr-toggle">
                <button class="kr-toggle-btn active" id="btnModeKategori" data-mode="kategori">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/></svg>
                    Manajemen Kategori
                </button>
                <button class="kr-toggle-btn" id="btnModeRak" data-mode="rak">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="3" width="20" height="5" rx="1"/><rect x="2" y="10" width="20" height="5" rx="1"/><rect x="2" y="17" width="20" height="5" rx="1"/></svg>
                    Manajemen Rak
                </button>
            </div>
        </div>
    </section>

    {{-- ===== MODE KATEGORI ===== --}}
    <div id="modeKategori">
        <section class="kr-main-section">
            <div class="kr-main-inner">

                {{-- Form Tambah Kategori --}}
                <div class="kr-form-card">
                    <div class="kr-card-head">
                        <div class="kr-card-ic ic-teal">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/></svg>
                        </div>
                        <h2 class="kr-card-title">Tambah Kategori</h2>
                    </div>

                    <form id="formTambahKategori" novalidate>
                        <div class="kr-form-group">
                            <label for="namaKategori">Nama Kategori <span class="kr-req">*</span></label>
                            <input type="text" id="namaKategori" placeholder="Contoh: Fiksi Populer">
                            <span class="kr-err" id="err-namaKategori"></span>
                        </div>
                        <div class="kr-form-group">
                            <label for="deskripsiKategori">Deskripsi</label>
                            <textarea id="deskripsiKategori" rows="3" placeholder="Penjelasan singkat mengenai kategori..."></textarea>
                        </div>
                        <button type="submit" class="btn-kr-submit">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                            Tambah Kategori
                        </button>
                    </form>
                </div>

                {{-- Daftar Kategori --}}
                <div class="kr-list-card">
                    <div class="kr-list-head">
                        <h2 class="kr-list-title">Daftar Kategori</h2>
                        <span class="kr-list-count" id="kategoriCount">6 Kategori</span>
                    </div>

                    {{-- Search buku dalam kategori --}}
                    <div class="kr-search-wrap">
                        <svg class="kr-search-ic" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#2D7076" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                        <input type="text" id="searchBukuKategori" class="kr-search" placeholder="Cari buku dalam kategori...">
                    </div>

                    <ul class="kr-list" id="listKategori">

                        <li class="kr-item" data-id="kat-1">
                            <div class="kr-item-main">
                                <div class="kr-item-ic ic-fiksi">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>
                                </div>
                                <div class="kr-item-info">
                                    <span class="kr-item-nama">Fiksi</span>
                                    <span class="kr-item-sub">Novel, Cerpen, Komik</span>
                                </div>
                                <div class="kr-item-actions">
                                    <button type="button" class="kr-btn-expand" data-target="kat-1" title="Lihat buku">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg>
                                    </button>
                                    <button type="button" class="kr-btn-hapus" data-id="kat-1" data-nama="Fiksi" title="Hapus">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                                    </button>
                                </div>
                            </div>
                            <div class="kr-item-books" id="books-kat-1">
                                <div class="kr-books-search-wrap">
                                    <input type="text" class="kr-books-search" placeholder="Cari di Fiksi..." data-target="kat-1">
                                </div>
                                <ul class="kr-book-list">
                                    <li class="kr-book-item" data-judul="laskar pelangi" data-penulis="andrea hirata">
                                        <img src="{{ asset('assets/Laskar_pelangi_sampul.jpg') }}" alt="Cover" class="kr-book-cover">
                                        <div class="kr-book-info">
                                            <span class="kr-book-judul">Laskar Pelangi</span>
                                            <span class="kr-book-penulis">Andrea Hirata</span>
                                        </div>
                                        <span class="kr-book-stok stok-ok">Stok: 8</span>
                                        <a href="{{ route('informasi-buku-admin', ['id' => 1]) }}" class="kr-book-link" title="Detail">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#2D7076" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>

                        <li class="kr-item" data-id="kat-2">
                            <div class="kr-item-main">
                                <div class="kr-item-ic ic-sejarah">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                </div>
                                <div class="kr-item-info">
                                    <span class="kr-item-nama">Sejarah</span>
                                    <span class="kr-item-sub">Peradaban, Biografi, Dokumenter</span>
                                </div>
                                <div class="kr-item-actions">
                                    <button type="button" class="kr-btn-expand" data-target="kat-2" title="Lihat buku">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg>
                                    </button>
                                    <button type="button" class="kr-btn-hapus" data-id="kat-2" data-nama="Sejarah" title="Hapus">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                                    </button>
                                </div>
                            </div>
                            <div class="kr-item-books" id="books-kat-2">
                                <div class="kr-books-search-wrap">
                                    <input type="text" class="kr-books-search" placeholder="Cari di Sejarah..." data-target="kat-2">
                                </div>
                                <ul class="kr-book-list">
                                    <li class="kr-book-item" data-judul="sejarah peradaban islam" data-penulis="badri yatim">
                                        <img src="{{ asset('assets/sejarah-peradaban-silam-sampul.png') }}" alt="Cover" class="kr-book-cover">
                                        <div class="kr-book-info">
                                            <span class="kr-book-judul">Sejarah Peradaban Islam</span>
                                            <span class="kr-book-penulis">Prof. Dr. Badri Yatim, M.A.</span>
                                        </div>
                                        <span class="kr-book-stok stok-warn">Stok: 2</span>
                                        <a href="{{ route('informasi-buku-admin', ['id' => 3]) }}" class="kr-book-link" title="Detail">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#2D7076" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>

                        <li class="kr-item" data-id="kat-3">
                            <div class="kr-item-main">
                                <div class="kr-item-ic ic-sains">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 3H5a2 2 0 0 0-2 2v4m6-6h10a2 2 0 0 1 2 2v4M9 3v18m0 0h10a2 2 0 0 0 2-2v-4M9 21H5a2 2 0 0 1-2-2v-4m0 0h18"/></svg>
                                </div>
                                <div class="kr-item-info">
                                    <span class="kr-item-nama">Sains</span>
                                    <span class="kr-item-sub">Fisika, Kimia, Biologi, Matematika</span>
                                </div>
                                <div class="kr-item-actions">
                                    <button type="button" class="kr-btn-expand" data-target="kat-3" title="Lihat buku">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg>
                                    </button>
                                    <button type="button" class="kr-btn-hapus" data-id="kat-3" data-nama="Sains" title="Hapus">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                                    </button>
                                </div>
                            </div>
                            <div class="kr-item-books" id="books-kat-3">
                                <div class="kr-books-search-wrap">
                                    <input type="text" class="kr-books-search" placeholder="Cari di Sains..." data-target="kat-3">
                                </div>
                                <ul class="kr-book-list"><li class="kr-no-book">Belum ada buku di kategori ini.</li></ul>
                            </div>
                        </li>

                        <li class="kr-item" data-id="kat-4">
                            <div class="kr-item-main">
                                <div class="kr-item-ic ic-agama">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c3 3 9 3 12 0v-5"/></svg>
                                </div>
                                <div class="kr-item-info">
                                    <span class="kr-item-nama">Agama</span>
                                    <span class="kr-item-sub">Fiqih, Akidah, Al-Quran, Hadis</span>
                                </div>
                                <div class="kr-item-actions">
                                    <button type="button" class="kr-btn-expand" data-target="kat-4" title="Lihat buku">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg>
                                    </button>
                                    <button type="button" class="kr-btn-hapus" data-id="kat-4" data-nama="Agama" title="Hapus">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                                    </button>
                                </div>
                            </div>
                            <div class="kr-item-books" id="books-kat-4">
                                <div class="kr-books-search-wrap">
                                    <input type="text" class="kr-books-search" placeholder="Cari di Agama..." data-target="kat-4">
                                </div>
                                <ul class="kr-book-list"><li class="kr-no-book">Belum ada buku di kategori ini.</li></ul>
                            </div>
                        </li>

                        <li class="kr-item" data-id="kat-5">
                            <div class="kr-item-main">
                                <div class="kr-item-ic ic-filsafat">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg>
                                </div>
                                <div class="kr-item-info">
                                    <span class="kr-item-nama">Filsafat</span>
                                    <span class="kr-item-sub">Logika, Etika, Metafisika</span>
                                </div>
                                <div class="kr-item-actions">
                                    <button type="button" class="kr-btn-expand" data-target="kat-5" title="Lihat buku">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg>
                                    </button>
                                    <button type="button" class="kr-btn-hapus" data-id="kat-5" data-nama="Filsafat" title="Hapus">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                                    </button>
                                </div>
                            </div>
                            <div class="kr-item-books" id="books-kat-5">
                                <div class="kr-books-search-wrap">
                                    <input type="text" class="kr-books-search" placeholder="Cari di Filsafat..." data-target="kat-5">
                                </div>
                                <ul class="kr-book-list">
                                    <li class="kr-book-item" data-judul="dunia sophie" data-penulis="jostein gaarder">
                                        <img src="{{ asset('assets/dunia-sophie-sampul.jpg') }}" alt="Cover" class="kr-book-cover">
                                        <div class="kr-book-info">
                                            <span class="kr-book-judul">Dunia Sophie</span>
                                            <span class="kr-book-penulis">Jostein Gaarder</span>
                                        </div>
                                        <span class="kr-book-stok stok-ok">Stok: 5</span>
                                        <a href="{{ route('informasi-buku-admin', ['id' => 2]) }}" class="kr-book-link" title="Detail">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#2D7076" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>

                        <li class="kr-item" data-id="kat-6">
                            <div class="kr-item-main">
                                <div class="kr-item-ic ic-motivasi">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                                </div>
                                <div class="kr-item-info">
                                    <span class="kr-item-nama">Motivasi</span>
                                    <span class="kr-item-sub">Self-help, Pengembangan Diri</span>
                                </div>
                                <div class="kr-item-actions">
                                    <button type="button" class="kr-btn-expand" data-target="kat-6" title="Lihat buku">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg>
                                    </button>
                                    <button type="button" class="kr-btn-hapus" data-id="kat-6" data-nama="Motivasi" title="Hapus">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                                    </button>
                                </div>
                            </div>
                            <div class="kr-item-books" id="books-kat-6">
                                <div class="kr-books-search-wrap">
                                    <input type="text" class="kr-books-search" placeholder="Cari di Motivasi..." data-target="kat-6">
                                </div>
                                <ul class="kr-book-list">
                                    <li class="kr-book-item" data-judul="the things you can see only when you slow down" data-penulis="haemin sunim">
                                        <img src="{{ asset('assets/slow-down-sampul.jpg') }}" alt="Cover" class="kr-book-cover">
                                        <div class="kr-book-info">
                                            <span class="kr-book-judul">The Things You Can See Only When You Slow Down</span>
                                            <span class="kr-book-penulis">Haemin Sunim</span>
                                        </div>
                                        <span class="kr-book-stok stok-empty">Stok: 0</span>
                                        <a href="{{ route('informasi-buku-admin', ['id' => 4]) }}" class="kr-book-link" title="Detail">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#2D7076" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>

                    </ul>
                </div>

            </div>
        </section>
    </div>

    {{-- ===== MODE RAK ===== --}}
    <div id="modeRak" style="display:none;">
        <section class="kr-main-section">
            <div class="kr-main-inner">

                {{-- Form Tambah Rak --}}
                <div class="kr-form-card">
                    <div class="kr-card-head">
                        <div class="kr-card-ic ic-orange">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="3" width="20" height="5" rx="1"/><rect x="2" y="10" width="20" height="5" rx="1"/><rect x="2" y="17" width="20" height="5" rx="1"/></svg>
                        </div>
                        <h2 class="kr-card-title">Tambah Rak Buku</h2>
                    </div>

                    <form id="formTambahRak" novalidate>
                        <div class="kr-form-row">
                            <div class="kr-form-group">
                                <label for="kodeRak">Kode Rak <span class="kr-req">*</span></label>
                                <input type="text" id="kodeRak" placeholder="Contoh: F-001">
                                <span class="kr-err" id="err-kodeRak"></span>
                            </div>
                            <div class="kr-form-group">
                                <label for="lokasiRak">Lokasi <span class="kr-req">*</span></label>
                                <input type="text" id="lokasiRak" placeholder="Contoh: Lantai 1 Sayap Kiri">
                                <span class="kr-err" id="err-lokasiRak"></span>
                            </div>
                        </div>
                        <div class="kr-form-group">
                            <label for="keteranganRak">Keterangan</label>
                            <textarea id="keteranganRak" rows="2" placeholder="Misal: Sayap Kanan dekat Jendela..."></textarea>
                        </div>
                        <button type="submit" class="btn-kr-submit btn-rak">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                            Daftarkan Rak
                        </button>
                    </form>
                </div>

                {{-- Daftar Rak --}}
                <div class="kr-list-card">
                    <div class="kr-list-head">
                        <h2 class="kr-list-title">Daftar Rak Aktif</h2>
                        <span class="kr-list-count rak-count" id="rakCount">6 Rak</span>
                    </div>

                    <div class="kr-search-wrap">
                        <svg class="kr-search-ic" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#2D7076" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                        <input type="text" id="searchBukuRak" class="kr-search" placeholder="Cari buku dalam rak...">
                    </div>

                    <ul class="kr-list" id="listRak">

                        <li class="kr-item" data-id="rak-F">
                            <div class="kr-item-main">
                                <div class="kr-item-kode">F</div>
                                <div class="kr-item-info">
                                    <span class="kr-item-nama">Rak F – Fiksi <span class="kr-rak-lokasi">· Lantai 1 Sayap Kiri</span></span>
                                    <span class="kr-item-sub">Area utama, dekat pintu masuk</span>
                                </div>
                                <div class="kr-item-actions">
                                    <button type="button" class="kr-btn-expand" data-target="rak-F" title="Lihat buku">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg>
                                    </button>
                                    <button type="button" class="kr-btn-hapus" data-id="rak-F" data-nama="Rak F – Fiksi" title="Hapus">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                                    </button>
                                </div>
                            </div>
                            <div class="kr-item-books" id="books-rak-F">
                                <div class="kr-books-search-wrap">
                                    <input type="text" class="kr-books-search" placeholder="Cari di Rak F..." data-target="rak-F">
                                </div>
                                <ul class="kr-book-list">
                                    <li class="kr-book-item" data-judul="laskar pelangi" data-penulis="andrea hirata">
                                        <img src="{{ asset('assets/Laskar_pelangi_sampul.jpg') }}" alt="" class="kr-book-cover">
                                        <div class="kr-book-info"><span class="kr-book-judul">Laskar Pelangi</span><span class="kr-book-penulis">Andrea Hirata · F-001</span></div>
                                        <span class="kr-book-stok stok-ok">Stok: 8</span>
                                        <a href="{{ route('informasi-buku-admin', ['id' => 1]) }}" class="kr-book-link" title="Detail"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#2D7076" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg></a>
                                    </li>
                                </ul>
                            </div>
                        </li>

                        <li class="kr-item" data-id="rak-S">
                            <div class="kr-item-main">
                                <div class="kr-item-kode">S</div>
                                <div class="kr-item-info">
                                    <span class="kr-item-nama">Rak S – Sejarah <span class="kr-rak-lokasi">· Lantai 1 Sayap Kanan</span></span>
                                    <span class="kr-item-sub">Dekat area baca utama, pencahayaan alami</span>
                                </div>
                                <div class="kr-item-actions">
                                    <button type="button" class="kr-btn-expand" data-target="rak-S" title="Lihat buku">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg>
                                    </button>
                                    <button type="button" class="kr-btn-hapus" data-id="rak-S" data-nama="Rak S – Sejarah" title="Hapus">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                                    </button>
                                </div>
                            </div>
                            <div class="kr-item-books" id="books-rak-S">
                                <div class="kr-books-search-wrap">
                                    <input type="text" class="kr-books-search" placeholder="Cari di Rak S..." data-target="rak-S">
                                </div>
                                <ul class="kr-book-list">
                                    <li class="kr-book-item" data-judul="sejarah peradaban islam" data-penulis="badri yatim">
                                        <img src="{{ asset('assets/sejarah-peradaban-silam-sampul.png') }}" alt="" class="kr-book-cover">
                                        <div class="kr-book-info"><span class="kr-book-judul">Sejarah Peradaban Islam</span><span class="kr-book-penulis">Badri Yatim · S-105</span></div>
                                        <span class="kr-book-stok stok-warn">Stok: 2</span>
                                        <a href="{{ route('informasi-buku-admin', ['id' => 3]) }}" class="kr-book-link" title="Detail"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#2D7076" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg></a>
                                    </li>
                                </ul>
                            </div>
                        </li>

                        <li class="kr-item" data-id="rak-FL">
                            <div class="kr-item-main">
                                <div class="kr-item-kode">FL</div>
                                <div class="kr-item-info">
                                    <span class="kr-item-nama">Rak FL – Filsafat <span class="kr-rak-lokasi">· Lantai 2 Mezzanine</span></span>
                                    <span class="kr-item-sub">Area khusus koleksi referensi dan jurnal</span>
                                </div>
                                <div class="kr-item-actions">
                                    <button type="button" class="kr-btn-expand" data-target="rak-FL" title="Lihat buku">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg>
                                    </button>
                                    <button type="button" class="kr-btn-hapus" data-id="rak-FL" data-nama="Rak FL – Filsafat" title="Hapus">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                                    </button>
                                </div>
                            </div>
                            <div class="kr-item-books" id="books-rak-FL">
                                <div class="kr-books-search-wrap">
                                    <input type="text" class="kr-books-search" placeholder="Cari di Rak FL..." data-target="rak-FL">
                                </div>
                                <ul class="kr-book-list">
                                    <li class="kr-book-item" data-judul="dunia sophie" data-penulis="jostein gaarder">
                                        <img src="{{ asset('assets/dunia-sophie-sampul.jpg') }}" alt="" class="kr-book-cover">
                                        <div class="kr-book-info"><span class="kr-book-judul">Dunia Sophie</span><span class="kr-book-penulis">Jostein Gaarder · F-010</span></div>
                                        <span class="kr-book-stok stok-ok">Stok: 5</span>
                                        <a href="{{ route('informasi-buku-admin', ['id' => 2]) }}" class="kr-book-link" title="Detail"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#2D7076" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg></a>
                                    </li>
                                </ul>
                            </div>
                        </li>

                        <li class="kr-item" data-id="rak-M">
                            <div class="kr-item-main">
                                <div class="kr-item-kode">M</div>
                                <div class="kr-item-info">
                                    <span class="kr-item-nama">Rak M – Motivasi <span class="kr-rak-lokasi">· Lantai 1 Tengah</span></span>
                                    <span class="kr-item-sub">Dekat meja diskusi kelompok</span>
                                </div>
                                <div class="kr-item-actions">
                                    <button type="button" class="kr-btn-expand" data-target="rak-M" title="Lihat buku">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg>
                                    </button>
                                    <button type="button" class="kr-btn-hapus" data-id="rak-M" data-nama="Rak M – Motivasi" title="Hapus">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                                    </button>
                                </div>
                            </div>
                            <div class="kr-item-books" id="books-rak-M">
                                <div class="kr-books-search-wrap">
                                    <input type="text" class="kr-books-search" placeholder="Cari di Rak M..." data-target="rak-M">
                                </div>
                                <ul class="kr-book-list">
                                    <li class="kr-book-item" data-judul="the things you can see" data-penulis="haemin sunim">
                                        <img src="{{ asset('assets/slow-down-sampul.jpg') }}" alt="" class="kr-book-cover">
                                        <div class="kr-book-info"><span class="kr-book-judul">The Things You Can See Only When You Slow Down</span><span class="kr-book-penulis">Haemin Sunim · M-022</span></div>
                                        <span class="kr-book-stok stok-empty">Stok: 0</span>
                                        <a href="{{ route('informasi-buku-admin', ['id' => 4]) }}" class="kr-book-link" title="Detail"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#2D7076" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg></a>
                                    </li>
                                </ul>
                            </div>
                        </li>

                    </ul>
                </div>

            </div>
        </section>
    </div>

    {{-- ===== MODAL HAPUS ===== --}}
    <div class="kr-modal" id="krModal">
        <div class="kr-modal-inner">
            <div class="kr-modal-ic">
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#c0392b" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
            </div>
            <h3 class="kr-modal-title">Hapus <span id="krModalNama"></span>?</h3>
            <p class="kr-modal-desc">Tindakan ini tidak bisa dibatalkan. Kategori/rak yang dihapus tidak dapat dipulihkan.</p>
            <div class="kr-modal-btns">
                <button class="btn-kr-konfirm" id="btnKrKonfirm">Ya, Hapus</button>
                <button class="btn-kr-batal" id="btnKrBatal">Batal</button>
            </div>
        </div>
    </div>

    {{-- ===== TOAST ===== --}}
    <div class="toast" id="toast"></div>

    {{-- ===== FOOTER ===== --}}
    <footer class="site-footer">
        <div class="footer-inner">
            <div class="footer-brand">
                <div class="footer-brand-top">
                    <img src="{{ asset('assets/logo.png') }}" alt="Logo" class="footer-logo">
                    <span class="footer-brand-name">Al-Uswah Library</span>
                </div>
                <p class="footer-tagline">© 2026 SMAIT Al-Uswah Library.<br>Menumbuhkan Literasi,<br>Mengukir Prestasi.</p>
                <div class="footer-socials">
                    <a href="#" class="social-btn" aria-label="Instagram"><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"/><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/></svg></a>
                    <a href="#" class="social-btn" aria-label="Email"><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,12 2,6"/></svg></a>
                </div>
            </div>
            <div class="footer-col">
                <h4 class="footer-col-title">Navigasi</h4>
                <ul><li><a href="{{ route('kelola-buku') }}">Kelola Buku</a></li><li><a href="{{ route('tambah-buku') }}">Tambah Buku</a></li></ul>
            </div>
            <div class="footer-col">
                <h4 class="footer-col-title">Kebijakan</h4>
                <ul><li><a href="#">Privacy Policy</a></li><li><a href="#">Terms of Service</a></li></ul>
            </div>
            <div class="footer-col">
                <h4 class="footer-col-title">Hubungi Kami</h4>
                <address>library@smait-aluswah.sch.id<br>Surabaya, Jawa Timur</address>
            </div>
        </div>
        <div class="footer-bottom"><p>© 2026 Perpustakaan SMAIT Al-Uswah. Menjaga Tradisi, Membangun Literasi.</p></div>
    </footer>

    <script src="{{ asset('js/script-kategori-rak.js') }}"></script>
</body>
</html>