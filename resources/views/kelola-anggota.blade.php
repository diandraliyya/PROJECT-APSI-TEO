<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengelolaan Anggota – Perpustakaan SMAIT Al-Uswah</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style-home.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style-home-anggota.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style-home-admin.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style-kelola-anggota.css') }}">
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
                <a href="{{ route('kelola-buku') }}" class="nav-link">Buku</a>
                <a href="{{ route('kelola-anggota') }}" class="nav-link active">Anggota</a>
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
    <section class="ka-hero">
        <div class="ka-hero-inner">
            <div class="ka-hero-left">
                <span class="ka-eyebrow">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#b8742f" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                    Panel Admin
                </span>
                <h1 class="ka-title">Pengelolaan Anggota</h1>
                <p class="ka-desc">Kelola data keanggotaan santri dan guru dengan mudah.</p>
            </div>
            <div class="ka-hero-right">
                <div class="ka-hero-ic">
                    <svg xmlns="http://www.w3.org/2000/svg" width="52" height="52" viewBox="0 0 24 24" fill="none" stroke="rgba(45,112,118,.2)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 7V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v2"/><line x1="12" y1="12" x2="12" y2="16"/><line x1="10" y1="14" x2="14" y2="14"/></svg>
                </div>
                <a href="{{ route('tambah-anggota') }}" class="btn-tambah-anggota">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="8.5" cy="7" r="4"/><line x1="20" y1="8" x2="20" y2="14"/><line x1="23" y1="11" x2="17" y2="11"/></svg>
                    Tambah Anggota
                </a>
            </div>
        </div>
    </section>

    {{-- ===== FILTER ===== --}}
    <section class="ka-filter-section">
        <div class="ka-filter-inner">
            <div class="ka-filter-bar">

                {{-- Search --}}
                <div class="ka-search-wrap">
                    <svg class="ka-search-ic" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#2D7076" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                    <input type="text" id="searchInput" class="ka-search" placeholder="Cari NIS atau Nama...">
                </div>

                {{-- Filter Kelas --}}
                <div class="ka-select-wrap">
                    <svg class="ka-select-ic" xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#2D7076" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 10v6M2 10l10-5 10 5-10 5z"/></svg>
                    <select id="kelasSelect" class="ka-select">
                        <option value="semua">Semua Kelas</option>
                        <option value="X-MIPA-1">X-MIPA 1</option>
                        <option value="X-MIPA-2">X-MIPA 2</option>
                        <option value="X-IPS-1">X-IPS 1</option>
                        <option value="X-IPS-2">X-IPS 2</option>
                        <option value="X-IPS-3">X-IPS 3</option>
                        <option value="XI-MIPA-1">XI-MIPA 1</option>
                        <option value="XI-MIPA-2">XI-MIPA 2</option>
                        <option value="XI-IPS-1">XI-IPS 1</option>
                        <option value="XII-MIPA-1">XII-MIPA 1</option>
                        <option value="XII-IPS-1">XII-IPS 1</option>
                        <option value="Guru">Guru</option>
                    </select>
                    <svg class="ka-select-arrow" xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#2D7076" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg>
                </div>

                {{-- Filter Status --}}
                <div class="ka-select-wrap">
                    <svg class="ka-select-ic" xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#2D7076" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                    <select id="statusSelect" class="ka-select">
                        <option value="semua">Semua Status</option>
                        <option value="aktif">Aktif</option>
                        <option value="nonaktif">Nonaktif</option>
                    </select>
                    <svg class="ka-select-arrow" xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#2D7076" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg>
                </div>

                {{-- Filter Tanggal --}}
                <div class="ka-date-wrap">
                    <svg class="ka-select-ic" xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#2D7076" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                    <input type="date" id="tglFilter" class="ka-date">
                </div>

                {{-- Sort --}}
                <button class="btn-sort" id="btnSort" title="Urutkan">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#2D7076" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="8" y1="6" x2="21" y2="6"/><line x1="8" y1="12" x2="16" y2="12"/><line x1="8" y1="18" x2="11" y2="18"/></svg>
                </button>

            </div>
        </div>
    </section>

    {{-- ===== TABEL ANGGOTA ===== --}}
    <section class="ka-table-section">
        <div class="ka-table-inner">
            <div class="ka-table-card">

                <div class="ka-table-head">
                    <h2 class="ka-table-title">Daftar Anggota Aktif</h2>
                    <div class="ka-table-actions">
                        <button class="ka-action-btn" id="btnExport" title="Unduh data">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                        </button>
                        <button class="ka-action-btn" id="btnPrint" title="Cetak">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 6 2 18 2 18 9"/><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><rect x="6" y="14" width="12" height="8"/></svg>
                        </button>
                    </div>
                </div>

                <div class="ka-table-wrap">
                    <table class="ka-table">
                        <thead>
                            <tr>
                                <th>FOTO</th>
                                <th class="sortable" data-col="nis">NIS / NIP <span class="sort-ic">↕</span></th>
                                <th class="sortable" data-col="nama">NAMA LENGKAP <span class="sort-ic">↕</span></th>
                                <th>KELAS</th>
                                <th>EMAIL</th>
                                <th>STATUS</th>
                                <th class="sortable" data-col="tgl">TERDAFTAR <span class="sort-ic">↕</span></th>
                                <th>AKSI</th>
                            </tr>
                        </thead>
                        <tbody id="anggotaTbody">

                            <tr class="ka-row"
                                data-nis="20210045" data-nama="ahmad fathoni"
                                data-kelas="XI-MIPA-1" data-status="aktif"
                                data-tgl="2024-01-12">
                                <td>
                                    <div class="ka-avatar av-teal">AF</div>
                                </td>
                                <td class="ka-nis">20210045</td>
                                <td class="ka-nama">Ahmad Fathoni</td>
                                <td>XI-MIPA 1</td>
                                <td class="ka-email">ahmad.f@uswah.sch.id</td>
                                <td><span class="ka-status st-aktif">Aktif</span></td>
                                <td class="ka-tgl">12 Jan 2024</td>
                                <td>
                                    <div class="ka-aksi">
                                    <button class="ka-btn-aksi btn-lihat" data-id="1" title="Lihat Detail">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                    </button>
                                        
                                        <button class="ka-btn-aksi btn-nonaktif" data-id="1" data-nama="Ahmad Fathoni" data-status="aktif" title="Nonaktifkan">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="4.93" y1="4.93" x2="19.07" y2="19.07"/></svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>

                            <tr class="ka-row"
                                data-nis="19880412" data-nama="siti aminah"
                                data-kelas="Guru" data-status="aktif"
                                data-tgl="2023-02-05">
                                <td>
                                    <div class="ka-avatar av-orange">SA</div>
                                </td>
                                <td class="ka-nis">19880412</td>
                                <td class="ka-nama">Siti Aminah, M.Pd</td>
                                <td>Guru</td>
                                <td class="ka-email">siti.aminah@uswah.sch.id</td>
                                <td><span class="ka-status st-aktif">Aktif</span></td>
                                <td class="ka-tgl">05 Feb 2023</td>
                                <td>
                                    <div class="ka-aksi">
                                    <button class="ka-btn-aksi btn-lihat" data-id="2" title="Lihat Detail">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                    </button>
                                        
                                        <button class="ka-btn-aksi btn-nonaktif" data-id="2" data-nama="Siti Aminah, M.Pd" data-status="aktif" title="Nonaktifkan">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="4.93" y1="4.93" x2="19.07" y2="19.07"/></svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>

                            <tr class="ka-row"
                                data-nis="20220192" data-nama="rara anindia"
                                data-kelas="X-IPS-3" data-status="nonaktif"
                                data-tgl="2024-08-20">
                                <td>
                                    <div class="ka-avatar av-purple">RA</div>
                                </td>
                                <td class="ka-nis">20220192</td>
                                <td class="ka-nama">Rara Anindia</td>
                                <td>X-IPS 3</td>
                                <td class="ka-email">rara.an@uswah.sch.id</td>
                                <td><span class="ka-status st-nonaktif">Nonaktif</span></td>
                                <td class="ka-tgl">20 Agu 2024</td>
                                <td>
                                    <div class="ka-aksi">
                                    <button class="ka-btn-aksi btn-lihat" data-id="3" title="Lihat Detail">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                    </button>
                                        
                                        <button class="ka-btn-aksi btn-aktifkan" data-id="3" data-nama="Rara Anindia" data-status="nonaktif" title="Aktifkan">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>

                            <tr class="ka-row"
                                data-nis="20230087" data-nama="budi santoso"
                                data-kelas="XII-MIPA-1" data-status="aktif"
                                data-tgl="2023-07-10">
                                <td>
                                    <div class="ka-avatar av-teal">BS</div>
                                </td>
                                <td class="ka-nis">20230087</td>
                                <td class="ka-nama">Budi Santoso</td>
                                <td>XII-MIPA 1</td>
                                <td class="ka-email">budi.s@uswah.sch.id</td>
                                <td><span class="ka-status st-aktif">Aktif</span></td>
                                <td class="ka-tgl">10 Jul 2023</td>
                                <td>
                                    <div class="ka-aksi">
                                    <button class="ka-btn-aksi btn-lihat" data-id="4" title="Lihat Detail">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                    </button>
                                        
                                        <button class="ka-btn-aksi btn-nonaktif" data-id="4" data-nama="Budi Santoso" data-status="aktif" title="Nonaktifkan">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="4.93" y1="4.93" x2="19.07" y2="19.07"/></svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>

                            <tr class="ka-row"
                                data-nis="20210156" data-nama="citra lestari"
                                data-kelas="XI-IPS-1" data-status="nonaktif"
                                data-tgl="2024-03-01">
                                <td>
                                    <div class="ka-avatar av-mint">CL</div>
                                </td>
                                <td class="ka-nis">20210156</td>
                                <td class="ka-nama">Citra Lestari</td>
                                <td>XI-IPS 1</td>
                                <td class="ka-email">citra.l@uswah.sch.id</td>
                                <td><span class="ka-status st-nonaktif">Nonaktif</span></td>
                                <td class="ka-tgl">01 Mar 2024</td>
                                <td>
                                    <div class="ka-aksi">
                                    <button class="ka-btn-aksi btn-lihat" data-id="5" title="Lihat Detail">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                    </button>
                                        
                                        <button class="ka-btn-aksi btn-aktifkan" data-id="5" data-nama="Citra Lestari" data-status="nonaktif" title="Aktifkan">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>

                        </tbody>
                    </table>
                </div>

                <div class="ka-empty" id="kaEmpty" style="display:none;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="#2D7076" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
                    <p>Tidak ada anggota yang cocok.</p>
                </div>

                <div class="ka-table-footer">
                    <span class="ka-info" id="kaInfo">Menampilkan 1–5 dari 1.240 anggota</span>
                    <div class="ka-pagination">
                        <button class="ka-page-btn" id="kaPrev">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
                        </button>
                        <button class="ka-page-btn active" data-page="1">1</button>
                        <button class="ka-page-btn" data-page="2">2</button>
                        <button class="ka-page-btn" data-page="3">3</button>
                        <span class="ka-page-ellipsis">...</span>
                        <button class="ka-page-btn" data-page="124">124</button>
                        <button class="ka-page-btn" id="kaNext">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
                        </button>
                    </div>
                </div>

            </div>
        </div>
    </section>

    {{-- ===== MODAL DETAIL ANGGOTA ===== --}}
    <div class="da-modal" id="daModal">
        <div class="da-modal-inner">

            {{-- Header --}}
            <div class="da-modal-head">
                <h3 class="da-modal-title">Detail Anggota</h3>
                <button class="da-modal-close" id="daModalClose" aria-label="Tutup">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                </button>
            </div>

            {{-- Profil --}}
            <div class="da-profil">
                <div class="da-profil-avatar" id="daAvatar">AF</div>
                <div class="da-profil-info">
                    <h4 class="da-profil-nama" id="daNama">Ahmad Fathoni</h4>
                    <span class="da-profil-nis" id="daNis">NIS: 20210045</span>
                    <span class="da-profil-kelas" id="daKelas">XI-MIPA 1</span>
                    <span class="da-profil-email" id="daEmail">ahmad.f@uswah.sch.id</span>
                </div>
                <span class="da-profil-status" id="daStatus">Aktif</span>
            </div>

            {{-- Stats ringkasan --}}
            <div class="da-stats">
                <div class="da-stat">
                    <span class="da-stat-val" id="daTotalPinjam">3</span>
                    <span class="da-stat-lbl">Total Pinjam</span>
                </div>
                <div class="da-stat">
                    <span class="da-stat-val" id="daAktifPinjam">1</span>
                    <span class="da-stat-lbl">Sedang Dipinjam</span>
                </div>
                <div class="da-stat">
                    <span class="da-stat-val denda-val" id="daTotalDenda">Rp 0</span>
                    <span class="da-stat-lbl">Total Denda</span>
                </div>
            </div>

            {{-- Tab --}}
            <div class="da-tabs">
                <button class="da-tab active" data-tab="pinjam">Riwayat Pinjam</button>
                <button class="da-tab" data-tab="denda">Riwayat Denda</button>
            </div>

            {{-- Tab Pinjam --}}
            <div class="da-tab-body" id="tabPinjam">
                <ul class="da-pinjam-list" id="daPinjamList"></ul>
            </div>

            {{-- Tab Denda --}}
            <div class="da-tab-body hidden" id="tabDenda">
                <ul class="da-denda-list" id="daDendaList"></ul>
            </div>

        </div>
    </div>

    {{-- ===== MODAL STATUS ===== --}}
    <div class="ka-modal" id="kaModal">
        <div class="ka-modal-inner">
            <div class="ka-modal-ic" id="kaModalIc"></div>
            <h3 class="ka-modal-title" id="kaModalTitle"></h3>
            <p class="ka-modal-desc" id="kaModalDesc"></p>
            <div class="ka-modal-btns">
                <button class="btn-ka-konfirm" id="btnKaKonfirm"></button>
                <button class="btn-ka-batal" id="btnKaBatal">Batal</button>
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
                <h4 class="footer-col-title">Quick Links</h4>
                <ul>
                    <li><a href="{{ route('dashboard-admin') }}">Dashboard Admin</a></li>
                    <li><a href="#">Peraturan Perpustakaan</a></li>
                    <li><a href="#">Panduan Anggota</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h4 class="footer-col-title">Kontak</h4>
                <ul>
                    <li>library@uswah.sch.id</li>
                    <li>+62 31 123 4567</li>
                </ul>
            </div>
            <div class="footer-col">
                <h4 class="footer-col-title">Jam Operasional</h4>
                <address>Senin – Jumat: 07:00–16:00<br>Sabtu: 08:00–12:00</address>
            </div>
        </div>
        <div class="footer-bottom"><p>© 2026 Perpustakaan SMAIT Al-Uswah. Menjaga Tradisi, Membangun Literasi.</p></div>
    </footer>

    <script src="{{ asset('js/script-kelola-anggota.js') }}"></script>
</body>
</html>