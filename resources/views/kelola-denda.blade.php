<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengelolaan Denda – Perpustakaan SMAIT Al-Uswah</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style-home.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style-home-anggota.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style-home-admin.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style-kelola-denda.css') }}">
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
                <a href="{{ route('riwayat-transaksi') }}" class="nav-link">Transaksi</a>
                <a href="{{ route('kelola-denda') }}" class="nav-link active">Denda</a>
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
    <section class="kd-hero">
        <div class="kd-hero-inner">
            <span class="kd-eyebrow">Pusat Administrasi</span>
            <h1 class="kd-title">
                Pengelolaan Denda
                <span class="kd-title-ic">
                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#b8742f" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                </span>
            </h1>
        </div>
    </section>

    {{-- ===== SUMMARY + TARIF ===== --}}
    <section class="kd-summary-section">
        <div class="kd-summary-inner">

            {{-- Kartu ringkasan --}}
            <div class="kd-summary-card card-aktif">
                <div class="kd-card-head">
                    <div class="kd-card-ic">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                    </div>
                    <span class="kd-card-tag">+12% Bulan Ini</span>
                </div>
                <span class="kd-card-label">Denda Aktif</span>
                <span class="kd-card-value">42 Kasus</span>
                <div class="kd-card-progress"><div class="kd-card-progress-fill" style="width:66%;"></div></div>
                <span class="kd-card-progress-label">66%</span>
            </div>

            <div class="kd-summary-card card-lunas">
                <div class="kd-card-head">
                    <div class="kd-card-ic ic-light">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#2D7076" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="5" width="20" height="14" rx="2"/><line x1="2" y1="10" x2="22" y2="10"/></svg>
                    </div>
                    <span class="kd-card-tag tag-light">Total Mingguan</span>
                </div>
                <span class="kd-card-label dark">Denda Lunas</span>
                <span class="kd-card-value dark">158 Kasus</span>
                <span class="kd-card-note">Apresiasi untuk kedisiplinan siswa!</span>
            </div>

            <div class="kd-summary-card card-total">
                <div class="kd-card-head">
                    <div class="kd-card-ic ic-brown">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 5c-1.5 0-2.8 1.4-3 2-3.5-1.5-11-.3-11 5 0 1.8 0 3 2 4.5V20h4v-2h3v2h4v-4c1-.5 1.7-1 2-2h2v-4h-2c0-1-.5-1.5-1-2V5z"/></svg>
                    </div>
                    <span class="kd-card-tag tag-brown">Tahun 2026</span>
                </div>
                <span class="kd-card-label light">Total Denda Terkumpul</span>
                <span class="kd-card-value light">Rp 1.250.000</span>
                <div class="kd-card-avatars">
                    <span class="kd-avatar a1">AZ</span>
                    <span class="kd-avatar a2">MK</span>
                    <span class="kd-avatar a3">SL</span>
                    <span class="kd-avatar a-more">+5</span>
                </div>
            </div>
        </div>

        {{-- ===== PANEL TARIF DENDA ===== --}}
        <div class="kd-tarif-inner">
            <div class="kd-tarif-panel">
                <div class="kd-tarif-info">
                    <div class="kd-tarif-ic">
                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#2D7076" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M16 8h-6a2 2 0 1 0 0 4h4a2 2 0 1 1 0 4H8"/><line x1="12" y1="6" x2="12" y2="8"/><line x1="12" y1="16" x2="12" y2="18"/></svg>
                    </div>
                    <div>
                        <span class="kd-tarif-label">Tarif Denda Saat Ini</span>
                        <span class="kd-tarif-value" id="tarifDisplay">Rp 1.000 <small>/ hari keterlambatan</small></span>
                    </div>
                </div>

                <form class="kd-tarif-form" id="tarifForm">
                    <div class="kd-tarif-input-wrap">
                        <span class="kd-tarif-prefix">Rp</span>
                        <input type="number" id="tarifInput" value="1000" min="0" step="500">
                        <span class="kd-tarif-suffix">/ hari</span>
                    </div>
                    <button type="submit" class="btn-update-tarif">Update Tarif</button>
                </form>
            </div>
        </div>
    </section>

    {{-- ===== SEARCH & FILTER ===== --}}
    <section class="kd-filter-section">
        <div class="kd-filter-inner">
            <div class="kd-filter-bar">
                <div class="kd-search-wrap">
                    <svg class="kd-search-ic" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#2D7076" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                    <input type="text" id="searchInput" class="kd-search" placeholder="Cari nama anggota atau judul buku...">
                </div>

                <div class="kd-select-wrap">
                    <select id="kelasSelect" class="kd-select">
                        <option value="semua">Semua Kelas</option>
                        <option value="X-A">X-A</option>
                        <option value="XI-B">XI-B</option>
                        <option value="XII-C">XII-C</option>
                    </select>
                    <svg class="kd-select-arrow" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#2D7076" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg>
                </div>

                <div class="kd-select-wrap">
                    <select id="waktuSelect" class="kd-select">
                        <option value="semua">Rentang Waktu</option>
                        <option value="minggu">Minggu Ini</option>
                        <option value="bulan">Bulan Ini</option>
                        <option value="tahun">Tahun Ini</option>
                    </select>
                    <svg class="kd-select-arrow" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#2D7076" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg>
                </div>
            </div>
        </div>
    </section>

    {{-- ===== TABEL DENDA ===== --}}
    <section class="kd-table-section">
        <div class="kd-table-inner">
            <div class="kd-table-card">

                {{-- Tab --}}
                <div class="kd-tabs">
                    <button class="kd-tab active" data-tab="aktif">
                        Denda Aktif <span class="kd-tab-count">42</span>
                    </button>
                    <button class="kd-tab" data-tab="lunas">
                        Denda Lunas <span class="kd-tab-count">158</span>
                    </button>
                </div>

                {{-- Tabel --}}
                <div class="kd-table-wrap">
                    <table class="kd-table">
                        <thead>
                            <tr>
                                <th>Nama Anggota</th>
                                <th>Kelas</th>
                                <th>Judul Buku</th>
                                <th>Hari Terlambat</th>
                                <th>Total Denda</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody id="dendaTbody">
                            {{-- ===== DENDA AKTIF (belum lunas → detail-denda) ===== --}}
                            <tr class="kd-row row-aktif" data-kondisi="aktif" data-nama="Ahmad Hidayat" data-judul="Laskar Pelangi" data-kelas="X-A" onclick="window.location.href='{{ route('detail-denda', ['id' => 1]) }}'">
                                <td>
                                    <div class="kd-anggota">
                                        <span class="kd-avatar-tbl av-teal">AH</span>
                                        <span class="kd-anggota-nama">Ahmad Hidayat</span>
                                    </div>
                                </td>
                                <td>X-A</td>
                                <td>Laskar Pelangi</td>
                                <td><span class="kd-late kd-late-red">5 Hari</span></td>
                                <td><span class="kd-denda">Rp 5.000</span></td>
                                <td><span class="kd-status status-belum"><span class="status-dot"></span> BELUM LUNAS</span></td>
                            </tr>

                            <tr class="kd-row row-aktif" data-kondisi="aktif" data-nama="Siti Pertiwi" data-judul="Dunia Sophie" data-kelas="XII-C" onclick="window.location.href='{{ route('detail-denda', ['id' => 2]) }}'">
                                <td>
                                    <div class="kd-anggota">
                                        <span class="kd-avatar-tbl av-orange">SP</span>
                                        <span class="kd-anggota-nama">Siti Pertiwi</span>
                                    </div>
                                </td>
                                <td>XII-C</td>
                                <td>Dunia Sophie</td>
                                <td><span class="kd-late kd-late-red">12 Hari</span></td>
                                <td><span class="kd-denda">Rp 12.000</span></td>
                                <td><span class="kd-status status-belum"><span class="status-dot"></span> BELUM LUNAS</span></td>
                            </tr>

                            <tr class="kd-row row-aktif" data-kondisi="aktif" data-nama="Bagas Nugroho" data-judul="Sejarah Peradaban Islam" data-kelas="XI-B" onclick="window.location.href='{{ route('detail-denda', ['id' => 3]) }}'">
                                <td>
                                    <div class="kd-anggota">
                                        <span class="kd-avatar-tbl av-purple">BN</span>
                                        <span class="kd-anggota-nama">Bagas Nugroho</span>
                                    </div>
                                </td>
                                <td>XI-B</td>
                                <td>Sejarah Peradaban Islam</td>
                                <td><span class="kd-late kd-late-red">3 Hari</span></td>
                                <td><span class="kd-denda">Rp 3.000</span></td>
                                <td><span class="kd-status status-belum"><span class="status-dot"></span> BELUM LUNAS</span></td>
                            </tr>

                            {{-- ===== DENDA LUNAS (sudah → detail-transaksi) ===== --}}
                            <tr class="kd-row row-lunas hidden" data-kondisi="lunas" data-nama="Rudi Pratama" data-judul="The Things You Can See" data-kelas="XI-B" onclick="window.location.href='{{ route('detail-transaksi', ['id' => 10]) }}'">
                                <td>
                                    <div class="kd-anggota">
                                        <span class="kd-avatar-tbl av-mint">RP</span>
                                        <span class="kd-anggota-nama">Rudi Pratama</span>
                                    </div>
                                </td>
                                <td>XI-B</td>
                                <td>The Things You Can See...</td>
                                <td><span class="kd-late kd-late-grey">0 Hari</span></td>
                                <td><span class="kd-denda kd-denda-zero">Rp 4.000</span></td>
                                <td><span class="kd-status status-lunas"><span class="status-dot"></span> LUNAS</span></td>
                            </tr>

                            <tr class="kd-row row-lunas hidden" data-kondisi="lunas" data-nama="Maya Kusuma" data-judul="Laskar Pelangi" data-kelas="X-A" onclick="window.location.href='{{ route('detail-transaksi', ['id' => 11]) }}'">
                                <td>
                                    <div class="kd-anggota">
                                        <span class="kd-avatar-tbl av-teal">MK</span>
                                        <span class="kd-anggota-nama">Maya Kusuma</span>
                                    </div>
                                </td>
                                <td>X-A</td>
                                <td>Laskar Pelangi</td>
                                <td><span class="kd-late kd-late-grey">0 Hari</span></td>
                                <td><span class="kd-denda">Rp 6.000</span></td>
                                <td><span class="kd-status status-lunas"><span class="status-dot"></span> LUNAS</span></td>
                            </tr>

                            {{-- Empty state --}}
                        </tbody>
                    </table>

                    <div class="kd-empty hidden" id="kdEmpty">
                        <svg xmlns="http://www.w3.org/2000/svg" width="44" height="44" viewBox="0 0 24 24" fill="none" stroke="#2D7076" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                        <p>Tidak ada data denda yang cocok.</p>
                    </div>
                </div>

                {{-- Footer tabel --}}
                <div class="kd-table-footer">
                    <span class="kd-table-info" id="kdInfo">Menampilkan 1–3 dari 42 denda aktif</span>
                    <div class="kd-pagination">
                        <button class="kd-page-btn" aria-label="Sebelumnya">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
                        </button>
                        <button class="kd-page-btn active">1</button>
                        <button class="kd-page-btn">2</button>
                        <button class="kd-page-btn">3</button>
                        <button class="kd-page-btn" aria-label="Berikutnya">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
                        </button>
                    </div>
                </div>

            </div>
        </div>
    </section>

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
                <h4 class="footer-col-title">Kebijakan</h4>
                <ul>
                    <li><a href="#">Aturan Peminjaman</a></li>
                    <li><a href="#">Kebijakan Denda</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h4 class="footer-col-title">Layanan</h4>
                <ul>
                    <li><a href="#">Jam Layanan</a></li>
                    <li><a href="#">Kontak Pustakawan</a></li>
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

    <script src="{{ asset('js/script-kelola-denda.js') }}"></script>
</body>
</html>