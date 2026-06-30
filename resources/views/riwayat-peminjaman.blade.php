<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Peminjaman – Perpustakaan SMAIT Al-Uswah</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style-home.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style-home-anggota.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style-riwayat-peminjaman.css') }}">
</head>
<body>

    {{-- ===== NAVBAR ===== --}}
    <header class="navbar">
        <div class="navbar-inner">
            <a href="{{ route('home-anggota') }}" class="nav-brand">
                <img src="{{ asset('assets/logo.png') }}" alt="Logo" class="nav-logo">
                <span class="nav-brand-name">Al-Uswah Library</span>
            </a>

            <nav class="nav-links">
                <a href="{{ route('dashboard-anggota') }}" class="nav-link">Dashboard</a>
                <a href="{{ route('katalog-anggota') }}" class="nav-link">Katalog</a>
                <a href="{{ route('tentang-perpustakaan-anggota') }}" class="nav-link">Tentang</a>
                <a href="{{ route('riwayat-peminjaman') }}" class="nav-link active">Riwayat</a>
                <a href="{{ route('status-denda') }}" class="nav-link">Denda</a>
            </nav>

            <a href="{{ route('profil-anggota') }}" class="nav-profile">
                <div class="nav-avatar">
                    @if(auth()->user()?->foto)
                        <img src="{{ asset('storage/' . auth()->user()->foto) }}" alt="Foto Profil" class="avatar-img">
                    @else
                        <div class="avatar-placeholder">{{ strtoupper(substr(auth()->user()?->nama_lengkap ?? 'A', 0, 1)) }}</div>
                    @endif
                </div>
                <span class="nav-username">{{ auth()->user()?->nama_lengkap ?? 'Anggota' }}</span>
            </a>
        </div>
    </header>

    {{-- ===== HERO ===== --}}
    <section class="riwayat-hero">
        <div class="riwayat-hero-inner">
            <div class="riwayat-hero-img">
                <img src="{{ asset('assets/icon buku.png') }}" alt="Ilustrasi buku" class="riwayat-illustration">
            </div>
            <div class="riwayat-hero-text">
                <span class="riwayat-eyebrow">arsip membacamu</span>
                <h1 class="riwayat-title">Riwayat Peminjaman</h1>
                <p class="riwayat-desc">
                    Catatan setiap petualangan literasimu di SMAIT Al-Uswah. Pastikan untuk mengembalikan tepat waktu agar teman lain bisa ikut membaca!
                </p>
            </div>
        </div>
    </section>

    {{-- ===== TOGGLE KATEGORI ===== --}}
    <section class="riwayat-toggle-section">
        <div class="riwayat-toggle-inner">
            <button class="toggle-btn active" data-kondisi="dipinjam">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>
                Sedang Dipinjam
            </button>
            <button class="toggle-btn" data-kondisi="dikembalikan">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 3v5h5"/><path d="M3.05 13A9 9 0 1 0 6 5.3L3 8"/><polyline points="12 7 12 12 15 15"/></svg>
                Sudah Dikembalikan
            </button>
        </div>
    </section>

    {{-- ===== FILTER BAR ===== --}}
    <section class="riwayat-filter-section">
        <div class="riwayat-filter-inner">
            <div class="filter-bar">
                <div class="filter-field">
                    <label class="filter-label">URUTKAN</label>
                    <div class="select-wrap">
                        <select id="sortSelect" class="filter-select">
                            <option value="terbaru">Terbaru Dipinjam</option>
                            <option value="terlama">Terlama Dipinjam</option>
                            <option value="tempo">Jatuh Tempo Terdekat</option>
                            <option value="az">Judul A – Z</option>
                        </select>
                        <svg class="select-arrow" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#2D7076" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg>
                    </div>
                </div>

                <div class="filter-field">
                    <label class="filter-label">STATUS</label>
    <div class="select-wrap">
                        <select id="statusSelect" class="filter-select">
                            {{-- option diisi otomatis oleh JS sesuai kategori aktif --}}
                        </select>
                        <svg class="select-arrow" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#2D7076" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg>
                    </div>
                </div>

                <div class="filter-field filter-search">
                    <label class="filter-label">CARI BUKU</label>
                    <div class="search-input-wrap">
                        <input type="text" id="searchInput" class="filter-search-input" placeholder="Masukkan judul atau penulis...">
                        <svg class="search-ic" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#2D7076" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ===== LIST RIWAYAT ===== --}}
    <section class="riwayat-list-section">
        <div class="riwayat-list-inner" id="riwayatList">

            {{-- Item: Hampir Jatuh Tempo --}}
            <div class="riwayat-item border-warn" data-judul="Laskar Pelangi" data-penulis="Andrea Hirata" data-status="hampir" data-tanggal="2026-10-12" data-tempo="2026-10-26" data-kondisi="dipinjam">
                <img src="{{ asset('assets/Laskar_pelangi_sampul.jpg') }}" alt="Laskar Pelangi" class="riwayat-cover">
                <div class="riwayat-book">
                    <h3 class="riwayat-judul">Laskar Pelangi</h3>
                    <p class="riwayat-penulis">Andrea Hirata</p>
                </div>
                <div class="riwayat-tanggal">
                    <span class="tgl-label">TANGGAL PINJAM</span>
                    <span class="tgl-value">12 Okt 2026</span>
                </div>
                <div class="riwayat-tanggal">
                    <span class="tgl-label">JATUH TEMPO</span>
                    <span class="tgl-value tempo-warn">26 Okt 2026</span>
                </div>
                <div class="riwayat-status">
                    <span class="status-badge badge-warn">Hampir Jatuh Tempo</span>
                    <span class="status-sub">3 Hari Lagi</span>
                </div>
                <div class="riwayat-icon icon-teal" title="Perpanjang">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 2v6h-6"/><path d="M3 12a9 9 0 0 1 15-6.7L21 8"/><path d="M3 22v-6h6"/><path d="M21 12a9 9 0 0 1-15 6.7L3 16"/></svg>
                </div>
            </div>

            {{-- Item: Aman --}}
            <div class="riwayat-item border-safe" data-judul="Dunia Sophie" data-penulis="Jostein Gaarder" data-status="aman" data-tanggal="2026-10-18" data-tempo="2026-11-01" data-kondisi="dipinjam">
                <img src="{{ asset('assets/dunia-sophie-sampul.jpg') }}" alt="Dunia Sophie" class="riwayat-cover">
                <div class="riwayat-book">
                    <h3 class="riwayat-judul">Dunia Sophie</h3>
                    <p class="riwayat-penulis">Jostein Gaarder</p>
                </div>
                <div class="riwayat-tanggal">
                    <span class="tgl-label">TANGGAL PINJAM</span>
                    <span class="tgl-value">18 Okt 2026</span>
                </div>
                <div class="riwayat-tanggal">
                    <span class="tgl-label">JATUH TEMPO</span>
                    <span class="tgl-value">01 Nov 2026</span>
                </div>
                <div class="riwayat-status">
                    <span class="status-badge badge-safe">Aman</span>
                    <span class="status-sub">9 Hari Lagi</span>
                </div>
                <div class="riwayat-icon icon-mint" title="Detail">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#2D7076" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>
                </div>
            </div>

            {{-- Item: Terlambat --}}
            <div class="riwayat-item border-late" data-judul="Sejarah Peradaban Islam" data-penulis="Badri Yatim" data-status="terlambat" data-tanggal="2026-10-05" data-tempo="2026-10-19" data-kondisi="dipinjam">
                <img src="{{ asset('assets/sejarah-peradaban-silam-sampul.png') }}" alt="Sejarah Peradaban Islam" class="riwayat-cover">
                <div class="riwayat-book">
                    <h3 class="riwayat-judul">Sejarah Peradaban Islam</h3>
                    <p class="riwayat-penulis">Prof. Dr. Badri Yatim, M.A.</p>
                </div>
                <div class="riwayat-tanggal">
                    <span class="tgl-label">TANGGAL PINJAM</span>
                    <span class="tgl-value">05 Okt 2026</span>
                </div>
                <div class="riwayat-tanggal">
                    <span class="tgl-label">JATUH TEMPO</span>
                    <span class="tgl-value tempo-late">19 Okt 2026</span>
                </div>
                <div class="riwayat-status">
                    <span class="status-badge badge-late">Terlambat</span>
                    <span class="status-sub sub-late">Lewat 5 Hari</span>
                </div>
                <div class="riwayat-icon icon-red" title="Bayar Denda">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="5" width="20" height="14" rx="2"/><line x1="2" y1="10" x2="22" y2="10"/></svg>
                </div>
            </div>

            {{-- Item: Sudah Dikembalikan – Tepat Waktu --}}
            <div class="riwayat-item border-returned" data-judul="The Things You Can See Only When You Slow Down" data-penulis="Haemin Sunim" data-status="tepat-waktu" data-tanggal="2026-09-01" data-tempo="2026-09-15" data-kondisi="dikembalikan">
                <img src="{{ asset('assets/slow-down-sampul.jpg') }}" alt="Slow Down" class="riwayat-cover">
                <div class="riwayat-book">
                    <h3 class="riwayat-judul">The Things You Can See Only When You Slow Down</h3>
                    <p class="riwayat-penulis">Haemin Sunim</p>
                </div>
                <div class="riwayat-tanggal">
                    <span class="tgl-label">TANGGAL PINJAM</span>
                    <span class="tgl-value">01 Sep 2026</span>
                </div>
                <div class="riwayat-tanggal">
                    <span class="tgl-label">DIKEMBALIKAN</span>
                    <span class="tgl-value">13 Sep 2026</span>
                </div>
                <div class="riwayat-status">
                    <span class="status-badge badge-returned">Tepat Waktu</span>
                    <span class="status-sub">Selesai</span>
                </div>
                <div class="riwayat-icon icon-mint" title="Detail">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#2D7076" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6 9 17l-5-5"/></svg>
                </div>
            </div>

            {{-- Item: Sudah Dikembalikan – Terlambat (Lunas) --}}
            <div class="riwayat-item border-returned" data-judul="Laskar Pelangi" data-penulis="Andrea Hirata" data-status="lunas" data-tanggal="2026-07-10" data-tempo="2026-07-24" data-kondisi="dikembalikan">
                <img src="{{ asset('assets/Laskar_pelangi_sampul.jpg') }}" alt="Laskar Pelangi" class="riwayat-cover">
                <div class="riwayat-book">
                    <h3 class="riwayat-judul">Laskar Pelangi</h3>
                    <p class="riwayat-penulis">Andrea Hirata</p>
                </div>
                <div class="riwayat-tanggal">
                    <span class="tgl-label">TANGGAL PINJAM</span>
                    <span class="tgl-value">10 Jul 2026</span>
                </div>
                <div class="riwayat-tanggal">
                    <span class="tgl-label">DIKEMBALIKAN</span>
                    <span class="tgl-value">27 Jul 2026</span>
                </div>
                <div class="riwayat-status">
                    <span class="status-badge badge-lunas">Terlambat (Lunas)</span>
                    <span class="status-sub">Denda Dibayar</span>
                </div>
                <div class="riwayat-icon icon-mint" title="Detail">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#2D7076" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6 9 17l-5-5"/></svg>
                </div>
            </div>

            {{-- Empty state --}}
            <div class="riwayat-empty hidden" id="riwayatEmpty">
                <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="#2D7076" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>
                <h3>Tidak ada riwayat ditemukan</h3>
                <p>Coba ubah filter atau kata kunci pencarianmu.</p>
            </div>

        </div>
    </section>

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
                <h4 class="footer-col-title">Layanan</h4>
                <ul>
                    <li><a href="#">Visi &amp; Misi</a></li>
                    <li><a href="#">Kebijakan Layanan</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h4 class="footer-col-title">Dukungan</h4>
                <ul>
                    <li><a href="#">Pusat Bantuan</a></li>
                    <li><a href="#">Donasi Buku</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h4 class="footer-col-title">Kontak</h4>
                <address>
                    Jl. Al-Uswah No. 123, Surabaya<br>
                    perpus@smait-aluswah.sch.id
                </address>
            </div>
        </div>
        <div class="footer-bottom">
            <p>© 2026 Perpustakaan SMAIT Al-Uswah. Menjaga Tradisi, Membangun Literasi.</p>
        </div>
    </footer>

    <script src="{{ asset('js/script-riwayat-peminjaman.js') }}"></script>
</body>
</html>