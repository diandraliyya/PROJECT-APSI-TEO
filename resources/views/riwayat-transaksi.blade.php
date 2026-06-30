<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Transaksi – Perpustakaan SMAIT Al-Uswah</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style-home.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style-home-anggota.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style-home-admin.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style-riwayat-transaksi.css') }}">
</head>
<body class="admin-page">

    {{-- ===== NAVBAR ADMIN ===== --}}
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
                <a href="{{ route('kelola-buku') }}" class="nav-link">Buku</a>
                <a href="{{ route('kelola-anggota') }}" class="nav-link">Anggota</a>
                <a href="{{ route('riwayat-transaksi') }}" class="nav-link active">Transaksi</a>
                <a href="{{ route('kelola-denda') }}" class="nav-link">Denda</a>
            </nav>
            <a href="{{ route('setting') }}" class="nav-profile">
                <div class="nav-avatar">
                    <div class="avatar-placeholder admin-avatar">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                    </div>
                </div>
                <div class="nav-profile-info">
                    <span class="nav-username">{{ auth()->user()?->nama_lengkap ?? 'Admin' }}</span>
                    <span class="nav-role">Administrator</span>
                </div>
            </a>
        </div>
    </header>

    {{-- ===== HERO ===== --}}
    <section class="rt-hero">
        <div class="rt-hero-inner">
            <div class="rt-hero-left">
                <div class="rt-hero-icons">
                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#2D7076" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#b8742f" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>
                </div>
                <h1 class="rt-title">Riwayat Transaksi</h1>
                <p class="rt-desc">Pantau dan kelola seluruh alur sirkulasi buku perpustakaan secara terorganisir dan efisien.</p>
            </div>
            <a href="{{ route('input-peminjaman') }}" class="btn-input-pinjam">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                Input Peminjaman Baru
            </a>
        </div>
    </section>

    {{-- ===== MODE TOGGLE: Cari by Buku / by Anggota ===== --}}
    <section class="rt-mode-section">
        <div class="rt-mode-inner">
            <div class="rt-mode-label">Lihat riwayat berdasarkan:</div>
            <div class="rt-mode-toggle">
                <button class="rt-mode-btn active" id="btnModeAnggota" data-mode="anggota">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                    Per Anggota
                </button>
                <button class="rt-mode-btn" id="btnModeBuku" data-mode="buku">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>
                    Per Buku
                </button>
            </div>
        </div>
    </section>

    {{-- ===== FILTER ===== --}}
    <section class="rt-filter-section">
        <div class="rt-filter-inner">
            <div class="rt-filter-bar">

                {{-- Filter tanggal --}}
                <div class="rt-filter-field">
                    <label>Rentang Tanggal</label>
                    <div class="rt-date-wrap">
                        <svg class="rt-date-ic" xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#2D7076" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                        <input type="date" id="tglAwal" class="rt-date" placeholder="Dari">
                        <span class="rt-date-sep">–</span>
                        <input type="date" id="tglAkhir" class="rt-date" placeholder="Sampai">
                    </div>
                </div>

                {{-- Filter status --}}
                <div class="rt-filter-field">
                    <label>Status Transaksi</label>
                    <div class="rt-select-wrap">
                        <select id="statusSelect" class="rt-select">
                            <option value="semua">Semua Status</option>
                            <option value="dipinjam">Dipinjam</option>
                            <option value="terlambat">Terlambat</option>
                            <option value="dikembalikan">Dikembalikan</option>
                        </select>
                        <svg class="rt-select-arrow" xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#2D7076" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg>
                    </div>
                </div>

                {{-- Filter kelas --}}
                <div class="rt-filter-field">
                    <label>Kelas</label>
                    <div class="rt-select-wrap">
                        <select id="kelasSelect" class="rt-select">
                            <option value="semua">Semua Kelas</option>
                            <option value="X-MIPA-1">X-MIPA 1</option>
                            <option value="X-IPS-3">X-IPS 3</option>
                            <option value="XI-MIPA-1">XI-MIPA 1</option>
                            <option value="XI-IPS-1">XI-IPS 1</option>
                            <option value="XII-MIPA-1">XII-MIPA 1</option>
                            <option value="XII-IPS-1">XII-IPS 1</option>
                            <option value="Guru">Guru</option>
                        </select>
                        <svg class="rt-select-arrow" xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#2D7076" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg>
                    </div>
                </div>

                {{-- Search nama anggota --}}
                <div class="rt-filter-field" id="fieldNama">
                    <label>Nama Anggota</label>
                    <div class="rt-search-wrap">
                        <input type="text" id="searchNama" class="rt-search" placeholder="Cari Nama...">
                    </div>
                </div>

                {{-- Search judul buku --}}
                <div class="rt-filter-field" id="fieldBuku">
                    <label>Judul Buku</label>
                    <div class="rt-search-wrap rt-search-has-ic">
                        <input type="text" id="searchBuku" class="rt-search" placeholder="Judul Buku...">
                        <svg class="rt-search-ic" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#2D7076" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                    </div>
                </div>

            </div>
        </div>
    </section>

    {{-- ===== TABEL ===== --}}
    <section class="rt-table-section">
        <div class="rt-table-inner">
            <div class="rt-table-card">
                <div class="rt-table-wrap">
                    <table class="rt-table">
                        <thead id="rtThead">
                            <tr>
                                <th>ID Transaksi</th>
                                <th>Nama Anggota</th>
                                <th>Jumlah Buku</th>
                                <th>Tanggal Pinjam</th>
                                <th>Jatuh Tempo</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="rtTbody">

                            <tr class="rt-row"
                                data-id="TRX-8821"
                                data-nama="ahmad syahrul" data-kelas="XI-MIPA-1"
                                data-buku="laskar pelangi dunia sophie"
                                data-status="dipinjam"
                                data-tgl-pinjam="2026-10-12" data-tgl-tempo="2026-10-19"
                                data-trx-id="10">
                                <td class="rt-id">#TRX-8821</td>
                                <td>
                                    <div class="rt-anggota">
                                        <div class="rt-avatar av-teal">AS</div>
                                        <div>
                                            <span class="rt-anggota-nama">Ahmad Syahrul</span>
                                            <span class="rt-anggota-kelas">XI-MIPA 1</span>
                                        </div>
                                    </div>
                                </td>
                                <td>2 Buku</td>
                                <td>12 Okt 2026</td>
                                <td>19 Okt 2026</td>
                                <td><span class="rt-status st-dipinjam">Dipinjam</span></td>
                                <td>
                                    <button class="btn-rt-detail" data-id="TRX-8821" title="Lihat Detail">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                    </button>
                                </td>
                            </tr>

                            <tr class="rt-row"
                                data-id="TRX-8819"
                                data-nama="nadia rahma" data-kelas="X-IPS-3"
                                data-buku="the things you can see only when you slow down"
                                data-status="terlambat"
                                data-tgl-pinjam="2026-10-05" data-tgl-tempo="2026-10-12"
                                data-trx-id="10">
                                <td class="rt-id">#TRX-8819</td>
                                <td>
                                    <div class="rt-anggota">
                                        <div class="rt-avatar av-orange">NR</div>
                                        <div>
                                            <span class="rt-anggota-nama">Nadia Rahma</span>
                                            <span class="rt-anggota-kelas">X-IPS 3</span>
                                        </div>
                                    </div>
                                </td>
                                <td>1 Buku</td>
                                <td>05 Okt 2026</td>
                                <td class="rt-tgl-terlambat">12 Okt 2026</td>
                                <td><span class="rt-status st-terlambat">Terlambat</span></td>
                                <td>
                                    <button class="btn-rt-detail" data-id="TRX-8819" title="Lihat Detail">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                    </button>
                                </td>
                            </tr>

                            <tr class="rt-row"
                                data-id="TRX-8815"
                                data-nama="farel kurniawan" data-kelas="XII-MIPA-1"
                                data-buku="laskar pelangi sejarah peradaban islam dunia sophie"
                                data-status="dikembalikan"
                                data-tgl-pinjam="2026-10-01" data-tgl-tempo="2026-10-08"
                                data-trx-id="11">
                                <td class="rt-id">#TRX-8815</td>
                                <td>
                                    <div class="rt-anggota">
                                        <div class="rt-avatar av-purple">FK</div>
                                        <div>
                                            <span class="rt-anggota-nama">Farel Kurniawan</span>
                                            <span class="rt-anggota-kelas">XII-MIPA 1</span>
                                        </div>
                                    </div>
                                </td>
                                <td>3 Buku</td>
                                <td>01 Okt 2026</td>
                                <td>08 Okt 2026</td>
                                <td><span class="rt-status st-dikembalikan">Dikembalikan</span></td>
                                <td>
                                    <button class="btn-rt-detail" data-id="TRX-8815" title="Lihat Detail">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                    </button>
                                </td>
                            </tr>

                            <tr class="rt-row"
                                data-id="TRX-8810"
                                data-nama="siti aminah" data-kelas="Guru"
                                data-buku="sejarah peradaban islam"
                                data-status="dikembalikan"
                                data-tgl-pinjam="2026-09-20" data-tgl-tempo="2026-10-04"
                                data-trx-id="11">
                                <td class="rt-id">#TRX-8810</td>
                                <td>
                                    <div class="rt-anggota">
                                        <div class="rt-avatar av-mint">SA</div>
                                        <div>
                                            <span class="rt-anggota-nama">Siti Aminah, M.Pd</span>
                                            <span class="rt-anggota-kelas">Guru</span>
                                        </div>
                                    </div>
                                </td>
                                <td>1 Buku</td>
                                <td>20 Sep 2026</td>
                                <td>04 Okt 2026</td>
                                <td><span class="rt-status st-dikembalikan">Dikembalikan</span></td>
                                <td>
                                    <button class="btn-rt-detail" data-id="TRX-8810" title="Lihat Detail">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                    </button>
                                </td>
                            </tr>

                        </tbody>
                    </table>
                </div>

                <div class="rt-empty" id="rtEmpty" style="display:none;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="#2D7076" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                    <p>Tidak ada transaksi yang cocok.</p>
                </div>

                <div class="rt-table-footer">
                    <span class="rt-info" id="rtInfo">Menampilkan 1–4 dari 124 transaksi</span>
                    <div class="rt-pagination">
                        <button class="rt-page-btn" id="rtPrev">
                            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
                        </button>
                        <button class="rt-page-btn active" data-page="1">1</button>
                        <button class="rt-page-btn" data-page="2">2</button>
                        <button class="rt-page-btn" data-page="3">3</button>
                        <button class="rt-page-btn" id="rtNext">
                            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
                        </button>
                    </div>
                </div>

            </div>
        </div>
    </section>


    {{-- ===== MODE PER BUKU ===== --}}
    <section class="rt-table-section" id="modeBukuSection" style="display:none;">
        <div class="rt-table-inner">

            {{-- Search buku --}}
            <div class="rt-buku-search-wrap">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#2D7076" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                <input type="text" id="searchBukuGrid" placeholder="Cari judul buku...">
            </div>

            {{-- Grid buku --}}
            <div class="rt-buku-grid" id="rtBukuGrid">

                <div class="rt-buku-card" data-judul="laskar pelangi" data-buku-id="1">
                    <img src="{{ asset('assets/Laskar_pelangi_sampul.jpg') }}" alt="Laskar Pelangi" class="rt-buku-cover">
                    <div class="rt-buku-meta">
                        <span class="rt-buku-judul">Laskar Pelangi</span>
                        <span class="rt-buku-penulis">Andrea Hirata</span>
                        <span class="rt-buku-stat">
                            <span class="rt-buku-stat-item st-dipinjam-dot">2 dipinjam</span>
                            <span class="rt-buku-stat-item">86 total</span>
                        </span>
                    </div>
                </div>

                <div class="rt-buku-card" data-judul="dunia sophie" data-buku-id="2">
                    <img src="{{ asset('assets/dunia-sophie-sampul.jpg') }}" alt="Dunia Sophie" class="rt-buku-cover">
                    <div class="rt-buku-meta">
                        <span class="rt-buku-judul">Dunia Sophie</span>
                        <span class="rt-buku-penulis">Jostein Gaarder</span>
                        <span class="rt-buku-stat">
                            <span class="rt-buku-stat-item">0 dipinjam</span>
                            <span class="rt-buku-stat-item">72 total</span>
                        </span>
                    </div>
                </div>

                <div class="rt-buku-card" data-judul="sejarah peradaban islam" data-buku-id="3">
                    <img src="{{ asset('assets/sejarah-peradaban-silam-sampul.png') }}" alt="Sejarah Peradaban Islam" class="rt-buku-cover">
                    <div class="rt-buku-meta">
                        <span class="rt-buku-judul">Sejarah Peradaban Islam</span>
                        <span class="rt-buku-penulis">Prof. Dr. Badri Yatim, M.A.</span>
                        <span class="rt-buku-stat">
                            <span class="rt-buku-stat-item">0 dipinjam</span>
                            <span class="rt-buku-stat-item">54 total</span>
                        </span>
                    </div>
                </div>

                <div class="rt-buku-card" data-judul="the things you can see only when you slow down" data-buku-id="4">
                    <img src="{{ asset('assets/slow-down-sampul.jpg') }}" alt="Slow Down" class="rt-buku-cover">
                    <div class="rt-buku-meta">
                        <span class="rt-buku-judul">The Things You Can See Only When You Slow Down</span>
                        <span class="rt-buku-penulis">Haemin Sunim</span>
                        <span class="rt-buku-stat">
                            <span class="rt-buku-stat-item st-terlambat-dot">1 terlambat</span>
                            <span class="rt-buku-stat-item">48 total</span>
                        </span>
                    </div>
                </div>

            </div>

            <div class="rt-buku-empty" id="rtBukuEmpty" style="display:none;">
                <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="#2D7076" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>
                <p>Tidak ada buku yang cocok.</p>
            </div>

        </div>
    </section>

    {{-- ===== MODAL PEMINJAM BUKU ===== --}}
    <div class="rt-modal" id="rtBukuModal">
        <div class="rt-modal-inner">
            <div class="rt-modal-head">
                <div class="rt-buku-modal-head-info">
                    <img id="bukuModalCover" src="" alt="" class="rt-buku-modal-cover">
                    <div>
                        <span class="rt-modal-kode" id="bukuModalJudul"></span>
                        <span class="rt-buku-modal-penulis" id="bukuModalPenulis"></span>
                    </div>
                </div>
                <button class="rt-modal-close" id="rtBukuModalClose" aria-label="Tutup">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                </button>
            </div>

            <div class="rt-buku-modal-stats" id="bukuModalStats"></div>

            <div class="rt-modal-books-head">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#2D7076" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                Riwayat Peminjam
            </div>
            <ul class="rt-modal-book-list" id="bukuModalPeminjamList"></ul>
        </div>
    </div>

    {{-- ===== MODAL DETAIL TRANSAKSI ===== --}}
    <div class="rt-modal" id="rtModal">
        <div class="rt-modal-inner">

            <div class="rt-modal-head">
                <div>
                    <span class="rt-modal-kode" id="modalKode">#TRX-8821</span>
                    <span class="rt-modal-status" id="modalStatus"></span>
                </div>
                <button class="rt-modal-close" id="rtModalClose" aria-label="Tutup">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                </button>
            </div>

            {{-- Info Anggota --}}
            <div class="rt-modal-anggota" id="modalAnggota">
                <div class="rt-modal-avatar" id="modalAvatar">AS</div>
                <div class="rt-modal-anggota-info">
                    <span class="rt-modal-nama" id="modalNama">Ahmad Syahrul</span>
                    <span class="rt-modal-kelas" id="modalKelas">XI-MIPA 1</span>
                    <span class="rt-modal-email" id="modalEmail">ahmad.s@uswah.sch.id</span>
                </div>
            </div>

            {{-- Ringkasan --}}
            <div class="rt-modal-ring">
                <div class="rt-modal-ring-item">
                    <span class="rt-ring-label">Tanggal Pinjam</span>
                    <span class="rt-ring-val" id="modalTglPinjam">12 Okt 2026</span>
                </div>
                <div class="rt-modal-ring-item">
                    <span class="rt-ring-label">Jatuh Tempo</span>
                    <span class="rt-ring-val" id="modalJatuhTempo">19 Okt 2026</span>
                </div>
                <div class="rt-modal-ring-item">
                    <span class="rt-ring-label">Tanggal Kembali</span>
                    <span class="rt-ring-val" id="modalTglKembali">–</span>
                </div>
                <div class="rt-modal-ring-item">
                    <span class="rt-ring-label">Petugas</span>
                    <span class="rt-ring-val">Admin Utama</span>
                </div>
            </div>

            {{-- Daftar Buku --}}
            <div class="rt-modal-books-head">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#2D7076" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>
                Buku yang Dipinjam
            </div>
            <ul class="rt-modal-book-list" id="modalBookList"></ul>

        </div>
    </div>

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
                <ul><li><a href="{{ route('dashboard-admin') }}">Dashboard</a></li><li><a href="{{ route('kelola-buku') }}">Kelola Buku</a></li><li><a href="{{ route('kelola-anggota') }}">Kelola Anggota</a></li></ul>
            </div>
            <div class="footer-col">
                <h4 class="footer-col-title">Dukungan</h4>
                <ul><li><a href="#">SOP Peminjaman</a></li><li><a href="#">Pusat Bantuan</a></li></ul>
            </div>
            <div class="footer-col">
                <h4 class="footer-col-title">Hubungi Kami</h4>
                <address>library@smait-aluswah.sch.id<br>Surabaya, Jawa Timur</address>
            </div>
        </div>
        <div class="footer-bottom"><p>© 2026 Perpustakaan SMAIT Al-Uswah. Menjaga Tradisi, Membangun Literasi.</p></div>
    </footer>

    <script src="{{ asset('js/script-riwayat-transaksi.js') }}"></script>
</body>
</html>