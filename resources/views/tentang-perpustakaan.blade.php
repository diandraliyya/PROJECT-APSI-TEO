<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tentang Perpustakaan – SMAIT Al-Uswah</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style-home.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style-home-anggota.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style-tentang-perpustakaan.css') }}">
</head>
<body>

    {{-- ===== NAVBAR ===== --}}
    <header class="navbar">
        <div class="navbar-inner">
            <a href="{{ url('/home') }}" class="nav-brand">
                <img src="{{ asset('assets/logo.png') }}" alt="Logo" class="nav-logo">
                <span class="nav-brand-name">Al-Uswah Library</span>
            </a>

            <nav class="nav-links">
                <a href="{{ url('/home') }}" class="nav-link">Beranda</a>
                <a href="{{ url('/katalog') }}" class="nav-link">Katalog</a>
                <a href="{{ url('/tentang-perpustakaan') }}" class="nav-link active">Tentang</a>
                <a href="{{ url('/register') }}" class="nav-link">Daftar Anggota</a>
            </nav>

            <a href="{{ url('/log-in') }}" class="btn-nav-cta">Masuk</a>
        </div>
    </header>

    {{-- ===== HERO ===== --}}
    <section class="tentang-hero">
        <div class="tentang-hero-inner">
            <div class="tentang-hero-text">
                <span class="tentang-eyebrow">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>
                    EKSPLORASI ILMU
                </span>
                <h1 class="tentang-title">Tentang<br>Perpustakaan</h1>
                <p class="tentang-desc">
                    Lebih dari sekadar rak buku, kami adalah laboratorium mimpi dan pusat peradaban bagi generasi rabbani di SMAIT Al-Uswah.
                </p>
            </div>

            <div class="tentang-hero-img">
                <div class="hero-img-card">
                    <img src="{{ asset('assets/icon buku.png') }}" alt="Ilustrasi buku" class="tentang-illustration">
                </div>
                <div class="hero-floating-card">
                    <div class="floating-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#2D7076" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2L2 7l10 5 10-5-10-5z"/><path d="M2 17l10 5 10-5"/><path d="M2 12l10 5 10-5"/></svg>
                    </div>
                    <div class="floating-text">
                        <strong>5.000+ Koleksi</strong>
                        <span>Buku &amp; Literatur Digital</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ===== SEJARAH & SPIRIT ===== --}}
    <section class="sejarah-section">
        <div class="sejarah-inner">
            <div class="sejarah-card">
                <h2 class="sejarah-title">Sejarah &amp; Spirit Kami</h2>
                <p class="sejarah-text">
                    Berdiri sebagai jantung akademik di SMAIT Al-Uswah, perpustakaan kami hadir dengan visi menyatukan iman dan ilmu. Sejak awal pendiriannya, kami berkomitmen untuk menyediakan akses tak terbatas bagi setiap santri untuk menjelajahi cakrawala pengetahuan dunia tanpa melupakan akar nilai keislaman.
                </p>
                <p class="sejarah-text">
                    Kami percaya bahwa setiap buku adalah jendela menuju hikmah. Melalui kurasi koleksi yang mendalam dan fasilitas yang modern-retro, kami ingin menciptakan atmosfer di mana membaca bukan lagi sekadar kewajiban, melainkan sebuah gaya hidup yang magis dan penuh petualangan.
                </p>
            </div>
        </div>
    </section>

    {{-- ===== VISI & MISI ===== --}}
    <section class="visi-misi-section">
        <div class="visi-misi-inner">

            {{-- Visi --}}
            <div class="visi-card">
                <span class="quote-mark">&#8220;</span>
                <span class="visi-label">Visi Kami</span>
                <blockquote class="visi-text">
                    "Menjadi pusat literasi unggulan yang mencetak generasi <em>rabbani</em>, cerdas, dan berwawasan global melalui eksplorasi ilmu tanpa batas."
                </blockquote>
                <div class="visi-divider">
                    <span class="divider-dark"></span>
                    <span class="divider-light"></span>
                </div>
            </div>

            {{-- Misi --}}
            <div class="misi-card">
                <h3 class="misi-heading">Misi Perpustakaan</h3>

                <div class="misi-item">
                    <div class="misi-icon" style="background: rgba(144,195,198,.3);">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#2D7076" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c3 3 9 3 12 0v-5"/></svg>
                    </div>
                    <div class="misi-content">
                        <strong>Misi Akademik</strong>
                        <p>Menyediakan sumber referensi berkualitas untuk mendukung kurikulum pendidikan.</p>
                    </div>
                </div>

                <div class="misi-item">
                    <div class="misi-icon" style="background: rgba(255,221,210,.6);">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#2D7076" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                    </div>
                    <div class="misi-content">
                        <strong>Misi Budaya</strong>
                        <p>Menumbuhkan budaya baca yang kreatif dan inovatif bagi seluruh sivitas akademika.</p>
                    </div>
                </div>

                <div class="misi-item">
                    <div class="misi-icon" style="background: rgba(213,197,219,.4);">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#2D7076" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg>
                    </div>
                    <div class="misi-content">
                        <strong>Misi Global</strong>
                        <p>Memfasilitasi akses informasi digital dunia melalui platform teknologi terkini.</p>
                    </div>
                </div>
            </div>

        </div>
    </section>

    {{-- ===== LAYANAN KAMI ===== --}}
    <section class="layanan-section">
        <div class="layanan-inner">
            <div class="layanan-header">
                <h2 class="layanan-title">Layanan Kami</h2>
                <p class="layanan-subtitle">Fasilitas terbaik untuk menunjang eksplorasi literasi Anda.</p>
            </div>

            <div class="layanan-grid">

                <div class="layanan-card">
                    <div class="layanan-icon" style="background: rgba(144,195,198,.3);">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#2D7076" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="3" width="20" height="14" rx="2" ry="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg>
                    </div>
                    <h3 class="layanan-name">Katalog Digital</h3>
                    <p class="layanan-desc">Akses pencarian koleksi buku secara online kapan saja dan di mana saja.</p>
                </div>

                <div class="layanan-card">
                    <div class="layanan-icon" style="background: rgba(144,195,198,.3);">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#2D7076" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="16" rx="2"/><circle cx="9" cy="10" r="2"/><path d="M15 8h2M15 12h2M7 16h10"/></svg>
                    </div>
                    <h3 class="layanan-name">Keanggotaan</h3>
                    <p class="layanan-desc">Proses pendaftaran yang mudah untuk seluruh siswa dan guru SMAIT Al-Uswah.</p>
                </div>

                <div class="layanan-card">
                    <div class="layanan-icon" style="background: rgba(255,221,210,.7);">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#2D7076" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 2v6h-6"/><path d="M3 12a9 9 0 0 1 15-6.7L21 8"/><path d="M3 22v-6h6"/><path d="M21 12a9 9 0 0 1-15 6.7L3 16"/></svg>
                    </div>
                    <h3 class="layanan-name">Peminjaman</h3>
                    <p class="layanan-desc">Sistem sirkulasi buku yang teratur dan berbasis teknologi RFID canggih.</p>
                </div>

                <div class="layanan-card">
                    <div class="layanan-icon" style="background: rgba(144,195,198,.3);">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#2D7076" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>
                    </div>
                    <h3 class="layanan-name">Ruang Baca</h3>
                    <p class="layanan-desc">Area baca yang nyaman, tenang, dan didukung oleh akses internet cepat.</p>
                </div>

            </div>
        </div>
    </section>

    {{-- ===== TATA TERTIB ===== --}}
    <section class="tata-tertib-section">
        <div class="tata-tertib-inner">
            <div class="tata-tertib-header">
                <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="#C0392B" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m16 16 3-8 3 8c-.87.65-1.92 1-3 1s-2.13-.35-3-1Z"/><path d="m2 16 3-8 3 8c-.87.65-1.92 1-3 1s-2.13-.35-3-1Z"/><path d="M7 21h10"/><path d="M12 3v18"/><path d="M3 7h2c2 0 5-1 7-2 2 1 5 2 7 2h2"/></svg>
                <h2 class="tata-tertib-title">Tata Tertib</h2>
            </div>

            <ul class="tata-tertib-list">
                <li class="tata-item">
                    <span class="check-icon"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg></span>
                    Wajib menitipkan tas di loker yang disediakan.
                </li>
                <li class="tata-item">
                    <span class="check-icon"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg></span>
                    Menjaga ketenangan dan tidak membawa makanan/minuman.
                </li>
                <li class="tata-item">
                    <span class="check-icon"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg></span>
                    Setiap peminjaman buku wajib menggunakan Kartu Anggota.
                </li>
                <li class="tata-item">
                    <span class="check-icon"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg></span>
                    Mengembalikan buku tepat waktu sesuai batas peminjaman.
                </li>
                <li class="tata-item">
                    <span class="check-icon"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg></span>
                    Menjaga kebersihan dan merapikan kembali tempat duduk.
                </li>
            </ul>
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

    {{-- Matikan script JS yang mengganggu --}}
    {{-- <script src="{{ asset('js/script-tentang-perpustakaan.js') }}"></script> --}}
</body>
</html>