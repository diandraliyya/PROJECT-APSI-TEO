<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengelolaan Buku – Perpustakaan SMAIT Al-Uswah</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style-home.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style-home-anggota.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style-home-admin.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style-kelola-buku.css') }}">
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
                <a href="{{ route('kelola-buku') }}" class="nav-link active">Buku</a>
                <a href="{{ route('kelola-anggota') }}" class="nav-link">Anggota</a>
                <a href="{{ route('riwayat-transaksi') }}" class="nav-link">Transaksi</a>
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
    <section class="kb-hero">
        <div class="kb-hero-inner">
            <div class="kb-hero-left">
                <span class="kb-eyebrow">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="#b8742f" stroke="none"><path d="M12 2l1.5 5.5L19 9l-5.5 1.5L12 16l-1.5-5.5L5 9l5.5-1.5z"/></svg>
                    ADMIN DASHBOARD
                </span>
                <h1 class="kb-title">Pengelolaan Buku</h1>
                <p class="kb-desc">Kelola dan awasi koleksi literasimu dengan penuh ketelitian.</p>
            </div>
            <div class="kb-hero-right">
                <div class="kb-hero-deco">
                    <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" viewBox="0 0 24 24" fill="none" stroke="rgba(45,112,118,.15)" stroke-width="1" stroke-linecap="round" stroke-linejoin="round"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>
                </div>
                <a href="{{ route('tambah-buku') }}" class="btn-tambah-buku">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                    Tambah Buku Baru
                </a>
            </div>
        </div>
    </section>

    {{-- ===== FILTER ===== --}}
    <section class="kb-filter-section">
        <div class="kb-filter-inner">
            <div class="kb-filter-bar">
                <div class="kb-search-wrap">
                    <svg class="kb-search-ic" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#2D7076" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                    <input type="text" id="searchInput" class="kb-search" placeholder="Cari judul, ISBN, atau penulis...">
                </div>

                <div class="kb-select-wrap">
                    <select id="kategoriSelect" class="kb-select">
                        <option value="semua">Semua Kategori</option>
                        <option value="fiksi">Fiksi</option>
                        <option value="sejarah">Sejarah</option>
                        <option value="sains">Sains</option>
                        <option value="agama">Agama</option>
                        <option value="filsafat">Filsafat</option>
                        <option value="motivasi">Motivasi</option>
                    </select>
                    <svg class="kb-select-arrow" xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#2D7076" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg>
                </div>

                <div class="kb-select-wrap">
                    <select id="statusSelect" class="kb-select">
                        <option value="semua">Semua Status</option>
                        <option value="tersedia">Tersedia</option>
                        <option value="sedikit">Stok Sedikit</option>
                        <option value="habis">Tidak Tersedia</option>
                    </select>
                    <svg class="kb-select-arrow" xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#2D7076" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg>
                </div>
            </div>
        </div>
    </section>

    {{-- ===== TABEL BUKU ===== --}}
    <section class="kb-table-section">
        <div class="kb-table-inner">
            <div class="kb-table-card">
                <table class="kb-table">
                    <thead>
                        <tr>
                            <th>Cover</th>
                            <th>Info Buku</th>
                            <th>ISBN</th>
                            <th>Kategori</th>
                            <th>Stok</th>
                            <th>Rak</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="bukuTbody">

                        <tr class="kb-row" data-id="1"
                            data-judul="Laskar Pelangi" data-penulis="Andrea Hirata"
                            data-isbn="979-3062-79-7" data-kategori="fiksi"
                            data-stok="8" data-status="tersedia">
                            <td><img src="{{ asset('assets/Laskar_pelangi_sampul.jpg') }}" alt="Cover" class="kb-cover"></td>
                            <td>
                                <span class="kb-judul">Laskar Pelangi</span>
                                <span class="kb-penulis">Andrea Hirata</span>
                            </td>
                            <td class="kb-isbn">979-3062-79-7</td>
                            <td><span class="kb-kat kat-fiksi">FIKSI</span></td>
                            <td class="kb-stok">8</td>
                            <td class="kb-rak">F-001</td>
                            <td><span class="kb-status st-tersedia"><span class="st-dot"></span> Tersedia</span></td>
                            <td>
                                <div class="kb-aksi">
                                    <a href="{{ route('informasi-buku-admin', ['id' => 1]) }}" class="kb-btn-aksi btn-lihat" title="Lihat Detail">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                    </a>
                                    <a href="{{ route('edit-buku', ['id' => 1]) }}" class="kb-btn-aksi btn-edit" title="Edit Buku">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                    </a>
                                    <button class="kb-btn-aksi btn-hapus" data-id="1" data-judul="Laskar Pelangi" title="Hapus Buku">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>

                        <tr class="kb-row" data-id="2"
                            data-judul="Dunia Sophie" data-penulis="Jostein Gaarder"
                            data-isbn="978-602-441-020-9" data-kategori="filsafat"
                            data-stok="5" data-status="tersedia">
                            <td><img src="{{ asset('assets/dunia-sophie-sampul.jpg') }}" alt="Cover" class="kb-cover"></td>
                            <td>
                                <span class="kb-judul">Dunia Sophie</span>
                                <span class="kb-penulis">Jostein Gaarder</span>
                            </td>
                            <td class="kb-isbn">978-602-441-020-9</td>
                            <td><span class="kb-kat kat-filsafat">FILSAFAT</span></td>
                            <td class="kb-stok">5</td>
                            <td class="kb-rak">F-010</td>
                            <td><span class="kb-status st-tersedia"><span class="st-dot"></span> Tersedia</span></td>
                            <td>
                                <div class="kb-aksi">
                                    <a href="{{ route('informasi-buku-admin', ['id' => 2]) }}" class="kb-btn-aksi btn-lihat" title="Lihat Detail">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                    </a>
                                    <a href="{{ route('edit-buku', ['id' => 2]) }}" class="kb-btn-aksi btn-edit" title="Edit Buku">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                    </a>
                                    <button class="kb-btn-aksi btn-hapus" data-id="2" data-judul="Dunia Sophie" title="Hapus Buku">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>

                        <tr class="kb-row" data-id="3"
                            data-judul="Sejarah Peradaban Islam" data-penulis="Badri Yatim"
                            data-isbn="979-421-337-3" data-kategori="sejarah"
                            data-stok="2" data-status="sedikit">
                            <td><img src="{{ asset('assets/sejarah-peradaban-silam-sampul.png') }}" alt="Cover" class="kb-cover"></td>
                            <td>
                                <span class="kb-judul">Sejarah Peradaban Islam</span>
                                <span class="kb-penulis">Prof. Dr. Badri Yatim, M.A.</span>
                            </td>
                            <td class="kb-isbn">979-421-337-3</td>
                            <td><span class="kb-kat kat-sejarah">SEJARAH</span></td>
                            <td class="kb-stok stok-sedikit">2</td>
                            <td class="kb-rak">S-105</td>
                            <td><span class="kb-status st-sedikit"><span class="st-dot"></span> Stok Sedikit</span></td>
                            <td>
                                <div class="kb-aksi">
                                    <a href="{{ route('informasi-buku-admin', ['id' => 3]) }}" class="kb-btn-aksi btn-lihat" title="Lihat Detail">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                    </a>
                                    <a href="{{ route('edit-buku', ['id' => 3]) }}" class="kb-btn-aksi btn-edit" title="Edit Buku">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                    </a>
                                    <button class="kb-btn-aksi btn-hapus" data-id="3" data-judul="Sejarah Peradaban Islam" title="Hapus Buku">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>

                        <tr class="kb-row" data-id="4"
                            data-judul="The Things You Can See Only When You Slow Down" data-penulis="Haemin Sunim"
                            data-isbn="978-602-481-365-9" data-kategori="motivasi"
                            data-stok="0" data-status="habis">
                            <td><img src="{{ asset('assets/slow-down-sampul.jpg') }}" alt="Cover" class="kb-cover"></td>
                            <td>
                                <span class="kb-judul">The Things You Can See Only When You Slow Down</span>
                                <span class="kb-penulis">Haemin Sunim</span>
                            </td>
                            <td class="kb-isbn">978-602-481-365-9</td>
                            <td><span class="kb-kat kat-motivasi">MOTIVASI</span></td>
                            <td class="kb-stok stok-habis">0</td>
                            <td class="kb-rak">M-022</td>
                            <td><span class="kb-status st-habis"><span class="st-dot"></span> Tidak Tersedia</span></td>
                            <td>
                                <div class="kb-aksi">
                                    <a href="{{ route('informasi-buku-admin', ['id' => 4]) }}" class="kb-btn-aksi btn-lihat" title="Lihat Detail">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                    </a>
                                    <a href="{{ route('edit-buku', ['id' => 4]) }}" class="kb-btn-aksi btn-edit" title="Edit Buku">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                    </a>
                                    <button class="kb-btn-aksi btn-hapus" data-id="4" data-judul="The Things You Can See..." title="Hapus Buku">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>

                    </tbody>
                </table>

                <div class="kb-empty hidden" id="kbEmpty">
                    <svg xmlns="http://www.w3.org/2000/svg" width="44" height="44" viewBox="0 0 24 24" fill="none" stroke="#2D7076" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>
                    <p>Tidak ada buku yang cocok dengan filter ini.</p>
                </div>

                <div class="kb-table-footer">
                    <span class="kb-info" id="kbInfo">Menampilkan 1–4 dari 450 buku</span>
                    <div class="kb-pagination">
                        <button class="kb-page-btn" id="kbPrev">Sebelumnya</button>
                        <button class="kb-page-btn active" data-page="1">1</button>
                        <button class="kb-page-btn" data-page="2">2</button>
                        <button class="kb-page-btn" data-page="3">3</button>
                        <button class="kb-page-btn" id="kbNext">Berikutnya</button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ===== MANAJEMEN KATEGORI & RAK ===== --}}
    <section class="kb-manajemen-section">
        <div class="kb-manajemen-inner">
            <h2 class="kb-manajemen-title">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#2D7076" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/></svg>
                Manajemen Koleksi
            </h2>
            <p class="kb-manajemen-sub">Atur kategori dan lokasi rak untuk memudahkan pengelolaan koleksi perpustakaan.</p>

            <div class="kb-manajemen-cards">
                <a href="{{ route('kategori-rak') }}" class="kb-mana-card">
                    <div class="kb-mana-ic ic-teal">
                        <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="8" y1="6" x2="21" y2="6"/><line x1="8" y1="12" x2="21" y2="12"/><line x1="8" y1="18" x2="21" y2="18"/><line x1="3" y1="6" x2="3.01" y2="6"/><line x1="3" y1="12" x2="3.01" y2="12"/><line x1="3" y1="18" x2="3.01" y2="18"/></svg>
                    </div>
                    <div class="kb-mana-info">
                        <span class="kb-mana-label">Manajemen Kategori</span>
                        <span class="kb-mana-desc">Tambah, edit, dan atur kategori buku</span>
                    </div>
                    <svg class="kb-mana-arrow" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#2D7076" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
                </a>

                <a href="{{ route('kategori-rak') }}" class="kb-mana-card">
                    <div class="kb-mana-ic ic-orange">
                        <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="3" width="20" height="5" rx="1"/><rect x="2" y="10" width="20" height="5" rx="1"/><rect x="2" y="17" width="20" height="5" rx="1"/></svg>
                    </div>
                    <div class="kb-mana-info">
                        <span class="kb-mana-label">Manajemen Rak</span>
                        <span class="kb-mana-desc">Atur posisi dan kode rak koleksi</span>
                    </div>
                    <svg class="kb-mana-arrow" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#b8742f" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
                </a>
            </div>
        </div>
    </section>

    {{-- ===== MODAL KONFIRMASI HAPUS ===== --}}
    <div class="hapus-modal" id="hapusModal">
        <div class="hapus-modal-inner">
            <div class="hapus-modal-ic">
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#c0392b" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/><line x1="10" y1="11" x2="10" y2="17"/><line x1="14" y1="11" x2="14" y2="17"/></svg>
            </div>
            <h3 class="hapus-modal-title">Hapus Buku?</h3>
            <p class="hapus-modal-desc">Kamu yakin ingin menghapus buku <strong id="hapusJudul">"Laskar Pelangi"</strong>? Tindakan ini tidak bisa dibatalkan.</p>
            <div class="hapus-modal-btns">
                <button class="btn-hapus-konfirm" id="btnHapusKonfirm">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                    Ya, Hapus
                </button>
                <button class="btn-hapus-batal" id="btnHapusBatal">Batal</button>
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
                    <a href="#" class="social-btn" aria-label="Instagram">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"/><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/></svg>
                    </a>
                    <a href="#" class="social-btn" aria-label="Email">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,12 2,6"/></svg>
                    </a>
                </div>
            </div>
            <div class="footer-col">
                <h4 class="footer-col-title">Navigasi</h4>
                <ul>
                    <li><a href="{{ route('dashboard-admin') }}">Dashboard</a></li>
                    <li><a href="{{ route('tambah-buku') }}">Tambah Buku</a></li>
                    <li><a href="{{ route('kategori-rak') }}">Kategori &amp; Rak</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h4 class="footer-col-title">Dukungan</h4>
                <ul>
                    <li><a href="#">Pusat Bantuan</a></li>
                    <li><a href="#">SOP Peminjaman</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h4 class="footer-col-title">Hubungi Kami</h4>
                <address>
                    Jl. Al-Uswah No. 123, Surabaya<br>
                    library@smait-aluswah.sch.id
                </address>
            </div>
        </div>
        <div class="footer-bottom">
            <p>© 2026 Perpustakaan SMAIT Al-Uswah. Menjaga Tradisi, Membangun Literasi.</p>
        </div>
    </footer>

    <script src="{{ asset('js/script-kelola-buku.js') }}"></script>
</body>
</html>