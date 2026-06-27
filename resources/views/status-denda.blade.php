<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Status Denda – Perpustakaan SMAIT Al-Uswah</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style-home.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style-home-anggota.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style-status-denda.css') }}">
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
                <a href="{{ route('riwayat-peminjaman') }}" class="nav-link">Riwayat</a>
                <a href="{{ route('status-denda') }}" class="nav-link active">Denda</a>
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
    <section class="denda-hero">
        <div class="denda-hero-inner">
            <div class="denda-hero-img">
                <img src="{{ asset('assets/icon buku.png') }}" alt="Ilustrasi buku" class="denda-illustration">
            </div>
            <div class="denda-hero-text">
                <h1 class="denda-title">Status Denda</h1>
                <span class="denda-eyebrow">jaga amanah membaca</span>
                <p class="denda-desc">
                    Selesaikan tanggunganmu agar pintu petualangan literasi tetap terbuka lebar untukmu!
                </p>
            </div>
        </div>
    </section>

    {{-- ===== RINGKASAN ===== --}}
    <section class="denda-summary-section">
        <div class="denda-summary-inner">
            <div class="denda-summary-card">
                <div class="summary-deco">
                    <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="rgba(255,255,255,.35)" stroke="none"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                </div>

                <div class="summary-item">
                    <span class="summary-label">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#2D7076" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="5" width="20" height="14" rx="2"/><line x1="2" y1="10" x2="22" y2="10"/></svg>
                        TOTAL DENDA AKTIF
                    </span>
                    <span class="summary-value">Rp 15.000</span>
                </div>

                <div class="summary-divider"></div>

                <div class="summary-item">
                    <span class="summary-label">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#2D7076" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 3v5h5"/><path d="M3.05 13A9 9 0 1 0 6 5.3L3 8"/><polyline points="12 7 12 12 15 15"/></svg>
                        BUKU TERLAMBAT
                    </span>
                    <span class="summary-value">2 Buku</span>
                </div>

                <div class="summary-divider"></div>

                <div class="summary-item">
                    <span class="summary-label">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#2D7076" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                        STATUS KEANGGOTAAN
                    </span>
                    <span class="summary-value">Aktif <span class="status-dot-active"></span></span>
                </div>
            </div>
        </div>
    </section>

    {{-- ===== MAIN GRID ===== --}}
    <section class="denda-main">
        <div class="denda-main-inner">

            {{-- LEFT: Denda Aktif --}}
            <div class="denda-left">
                <h2 class="denda-section-title">
                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#2D7076" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
                    Denda Aktif
                </h2>

                {{-- Denda item 1 --}}
                <div class="denda-item">
                    <img src="{{ asset('assets/Laskar_pelangi_sampul.jpg') }}" alt="Laskar Pelangi" class="denda-cover">
                    <div class="denda-content">
                        <div class="denda-item-head">
                            <span class="denda-badge">Belum Lunas</span>
                            <span class="denda-nominal">Rp 10.000</span>
                        </div>
                        <h3 class="denda-judul">Laskar Pelangi</h3>
                        <div class="denda-detail">
                            <div class="denda-detail-col">
                                <span class="detail-label">KETERLAMBATAN</span>
                                <span class="detail-value">10 Hari</span>
                            </div>
                            <div class="denda-detail-col">
                                <span class="detail-label">TARIF HARIAN</span>
                                <span class="detail-value">Rp 1.000/hari</span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Denda item 2 --}}
                <div class="denda-item">
                    <img src="{{ asset('assets/dunia-sophie-sampul.jpg') }}" alt="Dunia Sophie" class="denda-cover">
                    <div class="denda-content">
                        <div class="denda-item-head">
                            <span class="denda-badge">Belum Lunas</span>
                            <span class="denda-nominal">Rp 5.000</span>
                        </div>
                        <h3 class="denda-judul">Dunia Sophie</h3>
                        <div class="denda-detail">
                            <div class="denda-detail-col">
                                <span class="detail-label">KETERLAMBATAN</span>
                                <span class="detail-value">5 Hari</span>
                            </div>
                            <div class="denda-detail-col">
                                <span class="detail-label">TARIF HARIAN</span>
                                <span class="detail-value">Rp 1.000/hari</span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Info pembayaran offline --}}
                <div class="denda-offline-note">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#2D7076" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>
                    <div>
                        <strong>Pembayaran dilakukan secara langsung (offline)</strong>
                        <p>Silakan temui petugas/admin perpustakaan untuk menyelesaikan pembayaran denda. Status akan diperbarui oleh admin setelah pembayaran diterima.</p>
                    </div>
                </div>
            </div>

            {{-- RIGHT: Riwayat Denda --}}
            <div class="denda-right">
                <div class="riwayat-denda-card">
                    <h3 class="riwayat-denda-title">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#2D7076" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
                        Riwayat Denda
                    </h3>

                    <div class="riwayat-denda-item">
                        <div class="riwayat-denda-info">
                            <span class="rd-judul">Sejarah Peradaban Islam</span>
                            <span class="rd-tanggal">12 Mei 2026</span>
                        </div>
                        <div class="riwayat-denda-right">
                            <span class="rd-nominal">Rp 3.000</span>
                            <span class="rd-status">LUNAS</span>
                        </div>
                    </div>

                    <div class="riwayat-denda-item">
                        <div class="riwayat-denda-info">
                            <span class="rd-judul">The Things You Can See...</span>
                            <span class="rd-tanggal">04 April 2026</span>
                        </div>
                        <div class="riwayat-denda-right">
                            <span class="rd-nominal">Rp 12.000</span>
                            <span class="rd-status">LUNAS</span>
                        </div>
                    </div>

                    <div class="riwayat-denda-item">
                        <div class="riwayat-denda-info">
                            <span class="rd-judul">Laskar Pelangi</span>
                            <span class="rd-tanggal">20 Feb 2026</span>
                        </div>
                        <div class="riwayat-denda-right">
                            <span class="rd-nominal">Rp 5.000</span>
                            <span class="rd-status">LUNAS</span>
                        </div>
                    </div>

                    {{-- Item tambahan, tersembunyi awalnya --}}
                    <div class="riwayat-denda-item rd-extra hidden">
                        <div class="riwayat-denda-info">
                            <span class="rd-judul">Dunia Sophie</span>
                            <span class="rd-tanggal">15 Jan 2026</span>
                        </div>
                        <div class="riwayat-denda-right">
                            <span class="rd-nominal">Rp 4.000</span>
                            <span class="rd-status">LUNAS</span>
                        </div>
                    </div>

                    <div class="riwayat-denda-item rd-extra hidden">
                        <div class="riwayat-denda-info">
                            <span class="rd-judul">Sejarah Peradaban Islam</span>
                            <span class="rd-tanggal">28 Des 2025</span>
                        </div>
                        <div class="riwayat-denda-right">
                            <span class="rd-nominal">Rp 6.000</span>
                            <span class="rd-status">LUNAS</span>
                        </div>
                    </div>

                    <div class="riwayat-denda-item rd-extra hidden">
                        <div class="riwayat-denda-info">
                            <span class="rd-judul">Laskar Pelangi</span>
                            <span class="rd-tanggal">10 Nov 2025</span>
                        </div>
                        <div class="riwayat-denda-right">
                            <span class="rd-nominal">Rp 2.000</span>
                            <span class="rd-status">LUNAS</span>
                        </div>
                    </div>

                    <button class="btn-lihat-riwayat" id="btnLihatRiwayat">
                        <span class="btn-text-show">Lihat Semua Riwayat</span>
                        <span class="btn-text-hide hidden">Sembunyikan</span>
                        <svg class="btn-chevron" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg>
                    </button>
                </div>
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

    <script src="{{ asset('js/script-status-denda.js') }}"></script>
</body>
</html>