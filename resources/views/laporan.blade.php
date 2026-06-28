<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Perpustakaan – SMAIT Al-Uswah</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style-home.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style-home-anggota.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style-home-admin.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style-laporan.css') }}">
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
    <section class="lap-hero">
        <div class="lap-hero-inner">
            <div class="lap-hero-text">
                <span class="lap-eyebrow">Literasi Masa Depan</span>
                <h1 class="lap-title">Laporan Perpustakaan</h1>
                <p class="lap-desc">Pantau pertumbuhan literasi dan aktivitas perpustakaan dengan data yang akurat untuk menciptakan generasi pembelajaran yang unggul.</p>
            </div>
            <div class="lap-period-badge">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                <div>
                    <span class="period-label">Periode Saat Ini</span>
                    <span class="period-value" id="periodLabel">Oktober 2026</span>
                </div>
            </div>
        </div>
    </section>

    {{-- ===== FILTER ===== --}}
    <section class="lap-filter-section">
        <div class="lap-filter-inner">
            <div class="lap-filter-card">
                <div class="lap-filter-title">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#2D7076" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="8" y1="6" x2="21" y2="6"/><line x1="8" y1="12" x2="21" y2="12"/><line x1="8" y1="18" x2="21" y2="18"/><line x1="3" y1="6" x2="3.01" y2="6"/><line x1="3" y1="12" x2="3.01" y2="12"/><line x1="3" y1="18" x2="3.01" y2="18"/></svg>
                    Filter Data Laporan
                </div>
                <div class="lap-filter-row">
                    <div class="lap-filter-field">
                        <label>Jenis Laporan</label>
                        <div class="lap-select-wrap">
                            <select id="jenisLaporan">
                                <option value="pinjam-bulan">Peminjaman per Bulan</option>
                                <option value="pinjam-buku">Buku Terpopuler</option>
                                <option value="denda">Rekap Denda</option>
                                <option value="anggota">Aktivitas Anggota</option>
                            </select>
                            <svg class="lap-select-arrow" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#2D7076" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg>
                        </div>
                    </div>
                    <div class="lap-filter-field">
                        <label>Tanggal Awal</label>
                        <input type="date" id="tglAwal" class="lap-date-input">
                    </div>
                    <div class="lap-filter-field">
                        <label>Tanggal Akhir</label>
                        <input type="date" id="tglAkhir" class="lap-date-input">
                    </div>
                    <button class="btn-tampilkan" id="btnTampilkan">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                        Tampilkan Laporan
                    </button>
                </div>
                <span class="lap-filter-err hidden" id="filterErr">Tanggal awal tidak boleh lebih besar dari tanggal akhir.</span>
            </div>
        </div>
    </section>

    {{-- ===== STATS + CHART ===== --}}
    <section class="lap-stats-section">
        <div class="lap-stats-inner">

            {{-- Grafik Statistik --}}
            <div class="lap-chart-card">
                <div class="lap-chart-head">
                    <h2 class="lap-chart-title" id="chartTitle">Statistik Peminjaman</h2>
                    <div class="lap-chart-legend">
                        <span class="legend-dot dot-fiksi"></span> Fiksi
                        <span class="legend-dot dot-nonfiksi"></span> Non-Fiksi
                    </div>
                </div>
                <div class="lap-bar-chart" id="lapBarChart">
                    <div class="lap-bar-col">
                        <div class="lap-bar-group">
                            <div class="lap-bar b-fiksi" style="--h:60%;"></div>
                            <div class="lap-bar b-nonfiksi" style="--h:40%;"></div>
                        </div>
                        <span>Jan</span>
                    </div>
                    <div class="lap-bar-col">
                        <div class="lap-bar-group">
                            <div class="lap-bar b-fiksi" style="--h:75%;"></div>
                            <div class="lap-bar b-nonfiksi" style="--h:55%;"></div>
                        </div>
                        <span>Feb</span>
                    </div>
                    <div class="lap-bar-col">
                        <div class="lap-bar-group">
                            <div class="lap-bar b-fiksi" style="--h:55%;"></div>
                            <div class="lap-bar b-nonfiksi" style="--h:35%;"></div>
                        </div>
                        <span>Mar</span>
                    </div>
                    <div class="lap-bar-col">
                        <div class="lap-bar-group">
                            <div class="lap-bar b-fiksi" style="--h:80%;"></div>
                            <div class="lap-bar b-nonfiksi" style="--h:60%;"></div>
                        </div>
                        <span>Apr</span>
                    </div>
                    <div class="lap-bar-col">
                        <div class="lap-bar-group">
                            <div class="lap-bar b-fiksi" style="--h:70%;"></div>
                            <div class="lap-bar b-nonfiksi" style="--h:50%;"></div>
                        </div>
                        <span>Mei</span>
                    </div>
                    <div class="lap-bar-col">
                        <div class="lap-bar-group">
                            <div class="lap-bar b-fiksi" style="--h:90%;"></div>
                            <div class="lap-bar b-nonfiksi" style="--h:65%;"></div>
                        </div>
                        <span>Jun</span>
                    </div>
                </div>
            </div>

            {{-- Summary Cards --}}
            <div class="lap-summary-col">
                <div class="lap-sum-card sum-teal">
                    <div class="lap-sum-head">
                        <span class="lap-sum-label">Total Peminjaman</span>
                        <div class="lap-sum-ic">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="rgba(255,255,255,.6)" stroke-width="2"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>
                        </div>
                    </div>
                    <span class="lap-sum-value">1.240</span>
                    <span class="lap-sum-trend">
                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/><polyline points="17 6 23 6 23 12"/></svg>
                        12% dari bulan lalu
                    </span>
                </div>

                <div class="lap-sum-card sum-mint">
                    <div class="lap-sum-head">
                        <span class="lap-sum-label">Buku Baru</span>
                        <div class="lap-sum-ic ic-mint">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#2D7076" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2"/><line x1="12" y1="8" x2="12" y2="16"/><line x1="8" y1="12" x2="16" y2="12"/></svg>
                        </div>
                    </div>
                    <span class="lap-sum-value sum-val-dark">45</span>
                    <span class="lap-sum-trend trend-dark">Koleksi Terkini</span>
                </div>

                <div class="lap-sum-card sum-peach">
                    <div class="lap-sum-head">
                        <span class="lap-sum-label sum-label-dark">Total Denda</span>
                        <div class="lap-sum-ic ic-peach">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#b8742f" stroke-width="2"><rect x="2" y="5" width="20" height="14" rx="2"/><line x1="2" y1="10" x2="22" y2="10"/></svg>
                        </div>
                    </div>
                    <span class="lap-sum-value sum-val-brown">Rp 245rb</span>
                    <span class="lap-sum-trend trend-dark">Bulan Oktober</span>
                </div>
            </div>

        </div>
    </section>

    {{-- ===== TABEL DATA LAPORAN ===== --}}
    <section class="lap-table-section">
        <div class="lap-table-inner">
            <div class="lap-table-card">
                <div class="lap-table-head">
                    <div>
                        <h2 class="lap-table-title">Data Detail Laporan</h2>
                        <p class="lap-table-sub" id="tableInfo">Menampilkan 3 dari 150 data buku terpopuler</p>
                    </div>
                    <div class="lap-export-btns">
                        <button class="btn-export btn-pdf" id="btnExportPdf">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                            Export PDF
                        </button>
                        <button class="btn-export btn-excel" id="btnExportExcel">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2"/><line x1="3" y1="9" x2="21" y2="9"/><line x1="3" y1="15" x2="21" y2="15"/><line x1="9" y1="3" x2="9" y2="21"/><line x1="15" y1="3" x2="15" y2="21"/></svg>
                            Export Excel
                        </button>
                    </div>
                </div>

                <div class="lap-table-wrap">
                    <table class="lap-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Kategori / Judul Buku</th>
                                <th>Jumlah Pinjam</th>
                                <th>Ketersediaan</th>
                                <th>Status Trend</th>
                            </tr>
                        </thead>
                        <tbody id="lapTbody">
                            <tr>
                                <td class="td-no">01</td>
                                <td>
                                    <div class="lap-book">
                                        <img src="{{ asset('assets/Laskar_pelangi_sampul.jpg') }}" alt="Laskar Pelangi" class="lap-book-cover">
                                        <div>
                                            <span class="lap-book-judul">Laskar Pelangi</span>
                                            <span class="lap-book-meta">Andrea Hirata · Fiksi</span>
                                        </div>
                                    </div>
                                </td>
                                <td><span class="lap-pinjam">88</span></td>
                                <td><span class="lap-avail avail-green">Tersedia: 4</span></td>
                                <td><span class="lap-trend trend-up">↑ Meningkat</span></td>
                            </tr>
                            <tr>
                                <td class="td-no">02</td>
                                <td>
                                    <div class="lap-book">
                                        <img src="{{ asset('assets/sejarah-peradaban-silam-sampul.png') }}" alt="Sejarah Peradaban Islam" class="lap-book-cover">
                                        <div>
                                            <span class="lap-book-judul">Sejarah Peradaban Islam</span>
                                            <span class="lap-book-meta">Badri Yatim · Non-Fiksi</span>
                                        </div>
                                    </div>
                                </td>
                                <td><span class="lap-pinjam">72</span></td>
                                <td><span class="lap-avail avail-red">Habis</span></td>
                                <td><span class="lap-trend trend-stable">– Stabil</span></td>
                            </tr>
                            <tr>
                                <td class="td-no">03</td>
                                <td>
                                    <div class="lap-book">
                                        <img src="{{ asset('assets/dunia-sophie-sampul.jpg') }}" alt="Dunia Sophie" class="lap-book-cover">
                                        <div>
                                            <span class="lap-book-judul">Dunia Sophie</span>
                                            <span class="lap-book-meta">Jostein Gaarder · Filsafat</span>
                                        </div>
                                    </div>
                                </td>
                                <td><span class="lap-pinjam">56</span></td>
                                <td><span class="lap-avail avail-green">Tersedia: 5</span></td>
                                <td><span class="lap-trend trend-down">↓ Menurun</span></td>
                            </tr>
                            <tr>
                                <td class="td-no">04</td>
                                <td>
                                    <div class="lap-book">
                                        <img src="{{ asset('assets/slow-down-sampul.jpg') }}" alt="Slow Down" class="lap-book-cover">
                                        <div>
                                            <span class="lap-book-judul">The Things You Can See Only When You Slow Down</span>
                                            <span class="lap-book-meta">Haemin Sunim · Motivasi</span>
                                        </div>
                                    </div>
                                </td>
                                <td><span class="lap-pinjam">48</span></td>
                                <td><span class="lap-avail avail-green">Tersedia: 8</span></td>
                                <td><span class="lap-trend trend-up">↑ Meningkat</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                <div class="lap-pagination">
                    <button class="lap-page-btn" id="pagePrev" aria-label="Sebelumnya">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
                    </button>
                    <button class="lap-page-btn active" data-page="1">1</button>
                    <button class="lap-page-btn" data-page="2">2</button>
                    <button class="lap-page-btn" data-page="3">3</button>
                    <span class="lap-page-ellipsis">...</span>
                    <button class="lap-page-btn" data-page="15">15</button>
                    <button class="lap-page-btn" id="pageNext" aria-label="Berikutnya">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
                    </button>
                </div>
            </div>
        </div>
    </section>

    {{-- ===== QUOTE SECTION ===== --}}
    <section class="lap-quote-section">
        <div class="lap-quote-inner">
            <h2 class="lap-quote-text">Membaca adalah<br>Jendela Dunia</h2>
            <div class="lap-quote-img">
                <img src="{{ asset('assets/icon buku.png') }}" alt="Ilustrasi buku" class="lap-quote-illustration">
            </div>
        </div>
    </section>

    {{-- ===== MODAL KONFIRMASI EXPORT ===== --}}
    <div class="export-modal" id="exportModal">
        <div class="export-modal-inner">
            <div class="export-modal-ic" id="exportModalIc"></div>
            <h3 class="export-modal-title" id="exportModalTitle">Konfirmasi Export</h3>
            <p class="export-modal-desc" id="exportModalDesc">Apakah kamu yakin ingin mengunduh laporan ini?</p>
            <div class="export-modal-btns">
                <button class="btn-modal-confirm" id="btnModalConfirm">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                    Ya, Unduh
                </button>
                <button class="btn-modal-cancel" id="btnModalCancel">Batal</button>
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
                <h4 class="footer-col-title">Kebijakan</h4>
                <ul><li><a href="#">Kebijakan Privasi</a></li><li><a href="#">Syarat &amp; Ketentuan</a></li></ul>
            </div>
            <div class="footer-col">
                <h4 class="footer-col-title">Bantuan</h4>
                <ul><li><a href="#">Pusat Bantuan</a></li><li><a href="#">Kontak Admin</a></li></ul>
            </div>
            <div class="footer-col">
                <h4 class="footer-col-title">Hubungi Kami</h4>
                <address>Jl. Al-Uswah No. 123, Surabaya<br>library@smait-aluswah.sch.id</address>
            </div>
        </div>
        <div class="footer-bottom">
            <p>© 2026 Perpustakaan SMAIT Al-Uswah. Dibuat dengan cinta untuk masa depan pendidikan.</p>
        </div>
    </footer>

    {{-- CDN: jsPDF + SheetJS untuk export beneran --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.8.2/jspdf.plugin.autotable.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
    <script src="{{ asset('js/script-laporan.js') }}"></script>
</body>
</html>