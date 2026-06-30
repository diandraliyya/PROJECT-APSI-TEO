<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin – Perpustakaan SMAIT Al-Uswah</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style-home.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style-home-anggota.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style-home-admin.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style-dashboard-admin.css') }}">
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
                <a href="{{ route('dashboard-admin') }}" class="nav-link active">Dashboard</a>
                <a href="{{ route('katalog-admin') }}" class="nav-link">Katalog</a>
                <a href="{{ route('tentang-perpustakaan-admin') }}" class="nav-link">Tentang</a>
                <a href="{{ route('kelola-buku') }}" class="nav-link">Buku</a>
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

    {{-- ===== HERO BANNER ===== --}}
    <section class="admin-hero">
        <div class="admin-hero-inner">
            <div class="admin-hero-banner">
                <div class="admin-hero-text">
                    <span class="admin-hero-eyebrow">semangat bertugas!</span>
                    <h1 class="admin-hero-title">Dashboard Admin<br>Perpustakaan</h1>
                    <p class="admin-hero-desc">
                        Selamat datang kembali di panel literasi digital. Kelola koleksi buku, pantau aktivitas peminjaman, dan pastikan setiap ilmu tersampaikan dengan baik.
                    </p>
                    <div class="admin-hero-actions">
                        <a href="{{ route('tambah-buku') }}" class="btn-hero-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2"/><line x1="12" y1="8" x2="12" y2="16"/><line x1="8" y1="12" x2="16" y2="12"/></svg>
                            Tambah Buku Baru
                        </a>
                        <a href="{{ route('laporan') }}" class="btn-hero-secondary">Lihat Laporan</a>
                    </div>
                </div>
                <div class="admin-hero-img">
                    <img src="{{ asset('assets/icon buku.png') }}" alt="Ilustrasi" class="admin-hero-illustration">
                </div>
            </div>
        </div>
    </section>

    {{-- ===== STAT CARDS ===== --}}
    <section class="admin-stats">
        <div class="admin-stats-inner">

            <div class="admin-stat-card stat-peach">
                <div class="admin-stat-ic">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#2D7076" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>
                </div>
                <span class="admin-stat-label">TOTAL PINJAM HARI INI</span>
                <span class="admin-stat-value">42</span>
                <span class="admin-stat-trend trend-up">
                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/><polyline points="17 6 23 6 23 12"/></svg>
                    +12% dari kemarin
                </span>
            </div>

            <div class="admin-stat-card stat-mint">
                <div class="admin-stat-ic">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#2D7076" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>
                </div>
                <span class="admin-stat-label">BUKU SEDANG DIPINJAM</span>
                <span class="admin-stat-value">156</span>
                <span class="admin-stat-trend">Update otomatis sistem</span>
            </div>

            <div class="admin-stat-card stat-peach">
                <div class="admin-stat-ic">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#c0392b" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/></svg>
                </div>
                <span class="admin-stat-label">KETERLAMBATAN AKTIF</span>
                <span class="admin-stat-value">18</span>
                <span class="admin-stat-trend trend-alert">! Perlu segera ditindak</span>
            </div>

            <div class="admin-stat-card stat-mint">
                <div class="admin-stat-ic">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#2D7076" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="5" width="20" height="14" rx="2"/><line x1="2" y1="10" x2="22" y2="10"/></svg>
                </div>
                <span class="admin-stat-label">DENDA TERKUMPUL</span>
                <span class="admin-stat-value">Rp 450k</span>
                <span class="admin-stat-trend">Bulan ini (Desember)</span>
            </div>

        </div>
    </section>

    {{-- ===== CHARTS ROW ===== --}}
    <section class="admin-charts">
        <div class="admin-charts-inner">

            {{-- Tren Peminjaman --}}
            <div class="admin-panel">
                <div class="panel-head">
                    <div>
                        <h2 class="panel-title">Tren Peminjaman Buku</h2>
                        <p class="panel-sub">Statistik 6 bulan terakhir</p>
                    </div>
                    <div class="year-dropdown">
                        <button type="button" class="panel-badge" id="yearBtn">
                            <span id="yearLabel">Tahun 2026</span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg>
                        </button>
                        <div class="year-menu" id="yearMenu">
                            <button type="button" class="year-opt active" data-year="2026">Tahun 2026</button>
                            <button type="button" class="year-opt" data-year="2025">Tahun 2025</button>
                            <button type="button" class="year-opt" data-year="2024">Tahun 2024</button>
                        </div>
                    </div>
                </div>

                <div class="trend-chart">
                    <div class="trend-bar-col"><div class="trend-bar" style="--h: 38%;"></div><span>Juli</span></div>
                    <div class="trend-bar-col"><div class="trend-bar" style="--h: 58%;"></div><span>Agst</span></div>
                    <div class="trend-bar-col"><div class="trend-bar" style="--h: 48%;"></div><span>Sept</span></div>
                    <div class="trend-bar-col"><div class="trend-bar" style="--h: 78%;"></div><span>Okt</span></div>
                    <div class="trend-bar-col"><div class="trend-bar" style="--h: 62%;"></div><span>Nov</span></div>
                    <div class="trend-bar-col"><div class="trend-bar trend-bar-active" style="--h: 100%;"></div><span class="active-month">Des</span></div>
                </div>
            </div>

            {{-- Distribusi Kategori --}}
            <div class="admin-panel">
                <h2 class="panel-title">Distribusi Kategori</h2>
                <div class="donut-wrap">
                    <div class="donut" style="--fiksi: 65; --sains: 25;">
                        <div class="donut-center">
                            <span class="donut-total">1.240</span>
                            <span class="donut-label">Total Koleksi</span>
                        </div>
                    </div>
                </div>
                <ul class="donut-legend">
                    <li>
                        <span class="legend-dot dot-fiksi"></span>
                        <span class="legend-name">Fiksi</span>
                        <span class="legend-pct">65%</span>
                    </li>
                    <li>
                        <span class="legend-dot dot-sains"></span>
                        <span class="legend-name">Sains &amp; Tech</span>
                        <span class="legend-pct">25%</span>
                    </li>
                    <li>
                        <span class="legend-dot dot-lain"></span>
                        <span class="legend-name">Lainnya</span>
                        <span class="legend-pct">10%</span>
                    </li>
                </ul>
            </div>

        </div>
    </section>

    {{-- ===== POPULER & ANGGOTA ===== --}}
    <section class="admin-lists">
        <div class="admin-lists-inner">

            {{-- Buku Populer --}}
            <div class="admin-panel">
                <div class="panel-head">
                    <h2 class="panel-title">Buku Populer</h2>
                    <button type="button" class="panel-link" id="btnLihatPopuler">Lihat Semua</button>
                </div>

                <div class="popular-list">
                    <div class="popular-item">
                        <div class="popular-info">
                            <span class="popular-judul">Laskar Pelangi - Andrea Hirata</span>
                            <span class="popular-count">88 Pinjam</span>
                        </div>
                        <div class="popular-bar"><div class="popular-bar-fill" style="width: 100%;"></div></div>
                    </div>
                    <div class="popular-item">
                        <div class="popular-info">
                            <span class="popular-judul">Dunia Sophie - Jostein Gaarder</span>
                            <span class="popular-count">72 Pinjam</span>
                        </div>
                        <div class="popular-bar"><div class="popular-bar-fill" style="width: 82%;"></div></div>
                    </div>
                    <div class="popular-item">
                        <div class="popular-info">
                            <span class="popular-judul">Sejarah Peradaban Islam - Badri Yatim</span>
                            <span class="popular-count">54 Pinjam</span>
                        </div>
                        <div class="popular-bar"><div class="popular-bar-fill" style="width: 61%;"></div></div>
                    </div>
                    <div class="popular-item">
                        <div class="popular-info">
                            <span class="popular-judul">The Things You Can See... - Haemin Sunim</span>
                            <span class="popular-count">48 Pinjam</span>
                        </div>
                        <div class="popular-bar"><div class="popular-bar-fill" style="width: 54%;"></div></div>
                    </div>
                </div>
            </div>

            {{-- Anggota Teraktif --}}
            <div class="admin-panel">
                <h2 class="panel-title">Anggota Teraktif</h2>
                <div class="active-members">
                    <div class="member-item">
                        <div class="member-avatar">FM</div>
                        <div class="member-info">
                            <span class="member-name">Fathir Muhammad</span>
                            <span class="member-class">Kelas XII IPA 1</span>
                        </div>
                        <div class="member-pts">
                            <span class="pts-value">124 Pts</span>
                            <span class="pts-badge">Top Reader</span>
                        </div>
                    </div>
                    <div class="member-item">
                        <div class="member-avatar">SA</div>
                        <div class="member-info">
                            <span class="member-name">Siti Aminah</span>
                            <span class="member-class">Kelas XI IPS 2</span>
                        </div>
                        <div class="member-pts">
                            <span class="pts-value">98 Pts</span>
                        </div>
                    </div>
                    <div class="member-item">
                        <div class="member-avatar">RP</div>
                        <div class="member-info">
                            <span class="member-name">Rizky Pratama</span>
                            <span class="member-class">Kelas X-3</span>
                        </div>
                        <div class="member-pts">
                            <span class="pts-value">85 Pts</span>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>

    {{-- ===== STATUS DENDA AKTIF ===== --}}
    <section class="admin-denda">
        <div class="admin-denda-inner">
            <div class="admin-panel">
                <div class="panel-head denda-head">
                    <h2 class="panel-title">Status Denda Aktif</h2>
                    <div class="denda-search-wrap">
                        <input type="text" id="dendaSearch" class="denda-search" placeholder="Cari nama anggota...">
                        <button class="denda-search-btn" aria-label="Cari">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                        </button>
                    </div>
                </div>

                <div class="denda-table-wrap">
                    <table class="denda-table">
                        <thead>
                            <tr>
                                <th>NAMA ANGGOTA</th>
                                <th>JUDUL BUKU</th>
                                <th>TERLAMBAT</th>
                                <th>TOTAL DENDA</th>
                                <th>STATUS</th>
                                <th>AKSI</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <span class="td-name">Ahmad Subarjo</span>
                                    <span class="td-nis">NIS: 2122001</span>
                                </td>
                                <td>Laskar Pelangi</td>
                                <td>5 Hari</td>
                                <td><span class="td-denda">Rp 5.000</span></td>
                                <td><span class="td-status status-belum">Belum Bayar</span></td>
                                <td>
                                    <a href="{{ route('detail-denda', ['id' => 1]) }}" class="td-action" title="Detail Denda">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#2D7076" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="5" width="20" height="14" rx="2"/><line x1="2" y1="10" x2="22" y2="10"/></svg>
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <span class="td-name">Budi Santoso</span>
                                    <span class="td-nis">NIS: 2122045</span>
                                </td>
                                <td>Dunia Sophie</td>
                                <td>12 Hari</td>
                                <td><span class="td-denda">Rp 12.000</span></td>
                                <td><span class="td-status status-belum">Belum Bayar</span></td>
                                <td>
                                    <a href="{{ route('detail-denda', ['id' => 2]) }}" class="td-action" title="Detail Denda">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#2D7076" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="5" width="20" height="14" rx="2"/><line x1="2" y1="10" x2="22" y2="10"/></svg>
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <span class="td-name">Citra Lestari</span>
                                    <span class="td-nis">NIS: 2223012</span>
                                </td>
                                <td>Sejarah Peradaban Islam</td>
                                <td>2 Hari</td>
                                <td><span class="td-denda">Rp 2.000</span></td>
                                <td><span class="td-status status-belum">Belum Bayar</span></td>
                                <td>
                                    <a href="{{ route('detail-denda', ['id' => 3]) }}" class="td-action" title="Detail Denda">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#2D7076" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="5" width="20" height="14" rx="2"/><line x1="2" y1="10" x2="22" y2="10"/></svg>
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <a href="{{ route('kelola-denda') }}" class="denda-lihat-semua">Lihat Semua Data Denda &rarr;</a>
            </div>
        </div>
    </section>

    {{-- ===== MODAL BUKU POPULER ===== --}}
    <div class="popular-modal" id="popularModal">
        <div class="popular-modal-inner">
            <div class="popular-modal-head">
                <h3>Semua Buku Populer</h3>
                <button class="popular-modal-close" id="popularModalClose" aria-label="Tutup">
                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                </button>
            </div>
            <div class="popular-modal-body">
                <div class="popular-item"><div class="popular-info"><span class="popular-judul">Laskar Pelangi - Andrea Hirata</span><span class="popular-count">88 Pinjam</span></div><div class="popular-bar"><div class="popular-bar-fill" style="width:100%;"></div></div></div>
                <div class="popular-item"><div class="popular-info"><span class="popular-judul">Dunia Sophie - Jostein Gaarder</span><span class="popular-count">72 Pinjam</span></div><div class="popular-bar"><div class="popular-bar-fill" style="width:82%;"></div></div></div>
                <div class="popular-item"><div class="popular-info"><span class="popular-judul">Sejarah Peradaban Islam - Badri Yatim</span><span class="popular-count">54 Pinjam</span></div><div class="popular-bar"><div class="popular-bar-fill" style="width:61%;"></div></div></div>
                <div class="popular-item"><div class="popular-info"><span class="popular-judul">The Things You Can See... - Haemin Sunim</span><span class="popular-count">48 Pinjam</span></div><div class="popular-bar"><div class="popular-bar-fill" style="width:54%;"></div></div></div>
                <div class="popular-item"><div class="popular-info"><span class="popular-judul">Bumi Manusia - Pramoedya A. Toer</span><span class="popular-count">41 Pinjam</span></div><div class="popular-bar"><div class="popular-bar-fill" style="width:46%;"></div></div></div>
                <div class="popular-item"><div class="popular-info"><span class="popular-judul">Filosofi Teras - Henry Manampiring</span><span class="popular-count">37 Pinjam</span></div><div class="popular-bar"><div class="popular-bar-fill" style="width:42%;"></div></div></div>
                <div class="popular-item"><div class="popular-info"><span class="popular-judul">Atomic Habits - James Clear</span><span class="popular-count">33 Pinjam</span></div><div class="popular-bar"><div class="popular-bar-fill" style="width:37%;"></div></div></div>
            </div>
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
                    <a href="#" class="social-btn" aria-label="Instagram">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"/><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/></svg>
                    </a>
                    <a href="#" class="social-btn" aria-label="Email">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,12 2,6"/></svg>
                    </a>
                </div>
            </div>
            <div class="footer-col">
                <h4 class="footer-col-title">Menu Navigasi</h4>
                <ul>
                    <li><a href="{{ route('dashboard-admin') }}">Dashboard</a></li>
                    <li><a href="{{ route('katalog-admin') }}">Katalog Buku</a></li>
                    <li><a href="{{ route('kelola-anggota') }}">Database Anggota</a></li>
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
                    Jl. Kejawan Putih Tambak No. 1, Surabaya<br>
                    library@smait-aluswah.sch.id
                </address>
            </div>
        </div>
        <div class="footer-bottom">
            <p>© 2026 Perpustakaan SMAIT Al-Uswah. Menjaga Tradisi, Membangun Literasi.</p>
        </div>
    </footer>

    <script src="{{ asset('js/script-dashboard-admin.js') }}"></script>
</body>
</html>