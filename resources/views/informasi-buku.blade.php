<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $buku->judul_buku }} – Perpustakaan SMAIT Al-Uswah</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style-home.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style-home-anggota.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style-informasi-buku.css') }}">
</head>
<body>

    {{-- ===== NAVBAR ===== --}}
    <header class="navbar">
        <div class="navbar-inner">
            <a href="{{ url('/home-anggota') }}" class="nav-brand">
                <img src="{{ asset('assets/logo.png') }}" alt="Logo" class="nav-logo">
                <span class="nav-brand-name">Al-Uswah Library</span>
            </a>

            <nav class="nav-links">
                <a href="{{ url('/home-anggota') }}" class="nav-link {{ request()->is('home-anggota') ? 'active' : '' }}">Home</a>
                <a href="{{ url('/dashboard-anggota') }}" class="nav-link {{ request()->is('dashboard-anggota') ? 'active' : '' }}">Dashboard</a>
                <a href="{{ url('/katalog-anggota') }}" class="nav-link {{ request()->is('katalog-anggota') ? 'active' : '' }}">Katalog</a>
                <a href="{{ url('/tentang-perpustakaan-anggota') }}" class="nav-link {{ request()->is('tentang-perpustakaan-anggota') ? 'active' : '' }}">Tentang</a>
                <a href="{{ url('/riwayat-peminjaman') }}" class="nav-link {{ request()->is('riwayat-peminjaman') ? 'active' : '' }}">Riwayat</a>
                <a href="{{ url('/status-denda') }}" class="nav-link {{ request()->is('status-denda') ? 'active' : '' }}">Denda</a>
            </nav>

            @php
                $namaUser = session('auth_name') ?? 'Anggota';
                $fotoUser = null;
                $inisialUser = strtoupper(substr($namaUser, 0, 1));
                
                if(session('auth_role') === 'anggota' && session('auth_id')) {
                    $anggota = App\Models\Anggota::find(session('auth_id'));
                    if($anggota && $anggota->foto) {
                        $fotoUser = $anggota->foto;
                    }
                }
            @endphp

            <a href="{{ url('/profil-anggota') }}" class="nav-profile">
                <div class="nav-avatar">
                    @if($fotoUser)
                        <img src="{{ asset('storage/' . $fotoUser) }}" alt="Foto Profil" class="avatar-img">
                    @else
                        <div class="avatar-placeholder">{{ $inisialUser }}</div>
                    @endif
                </div>
                <span class="nav-username">{{ $namaUser }}</span>
            </a>
        </div>
    </header>

    {{-- ===== BREADCRUMB + HERO ===== --}}
    <section class="info-hero">
        <div class="info-hero-inner">
            <nav class="breadcrumb">
                <a href="{{ url('/katalog-anggota') }}">Katalog</a>
                <span class="breadcrumb-sep">&rsaquo;</span>
                <span class="breadcrumb-current">Detail Buku</span>
            </nav>

            <div class="info-hero-banner">
                <div class="info-hero-text">
                    <h1 class="info-hero-title">Informasi Detail Buku</h1>
                    <p class="info-hero-sub">Temukan keajaiban dalam setiap halaman...</p>
                </div>
                <div class="info-hero-deco">
                    <svg xmlns="http://www.w3.org/2000/svg" width="56" height="56" viewBox="0 0 24 24" fill="none" stroke="rgba(45,112,118,.25)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>
                </div>
            </div>
        </div>
    </section>

    {{-- ===== DETAIL BUKU ===== --}}
    <section class="info-detail">
        <div class="info-detail-inner">

            {{-- LEFT: cover + tombol --}}
            <div class="info-left">
                <div class="info-cover-wrap">
                    <span class="info-bookmark">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="#8a5a2b" stroke="none"><path d="M19 21l-7-5-7 5V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2z"/></svg>
                    </span>
                    @if($buku->cover)
                        <img src="{{ asset('storage/' . $buku->cover) }}" alt="{{ $buku->judul_buku }}" class="info-cover">
                    @else
                        <img src="{{ asset('assets/default-book.jpg') }}" alt="Default Cover" class="info-cover">
                    @endif
                </div>
            </div>

            {{-- RIGHT: info --}}
            <div class="info-right">
                <span class="info-kategori kategori-{{ strtolower(str_replace(' ', '-', $buku->kategori->nama_kategori ?? 'umum')) }}">
                    {{ $buku->kategori->nama_kategori ?? 'Umum' }}
                </span>
                <h2 class="info-judul">{{ $buku->judul_buku }}</h2>
                <p class="info-penulis">
                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                    {{ $buku->penulis }}
                </p>

                <div class="info-ringkasan">
                    <h3 class="ringkasan-title">Ringkasan Buku</h3>
                    <p class="ringkasan-text">{{ $buku->sinopsis ?? 'Belum ada sinopsis untuk buku ini.' }}</p>
                </div>

                {{-- Stok --}}
                <div class="info-stok">
                    <div class="stok-card stok-total">
                        <span class="stok-label">TOTAL EKSEMPLAR</span>
                        <span class="stok-value">{{ $buku->stok_total }}</span>
                    </div>
                    <div class="stok-card stok-tersedia">
                        <span class="stok-label">TERSEDIA</span>
                        <span class="stok-value">{{ $buku->stok_tersedia }}</span>
                    </div>
                    <div class="stok-card stok-dipinjam">
                        <span class="stok-label">DIPINJAM</span>
                        <span class="stok-value">{{ $buku->stok_total - $buku->stok_tersedia }}</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ===== INFO TAMBAHAN (tab) ===== --}}
    <section class="info-tabs-section">
        <div class="info-tabs-inner">
            <div class="info-tabs-card">

                <div class="tabs-header">
                    <button class="tab-btn active" data-tab="tambahan">Informasi Tambahan</button>
                    <button class="tab-btn" data-tab="lokasi">Lokasi Koleksi</button>
                </div>

                {{-- Tab: Informasi Tambahan --}}
                <div class="tab-content active" id="tab-tambahan">
                    <div class="info-grid">
                        <div class="info-grid-row">
                            <span class="grid-label">Penerbit</span>
                            <span class="grid-value">{{ $buku->penerbit ?? '-' }}</span>
                        </div>
                        <div class="info-grid-row">
                            <span class="grid-label">Tahun Terbit</span>
                            <span class="grid-value">{{ $buku->tahun_terbit ?? '-' }}</span>
                        </div>
                        <div class="info-grid-row">
                            <span class="grid-label">ISBN</span>
                            <span class="grid-value">{{ $buku->isbn ?? '-' }}</span>
                        </div>
                        <div class="info-grid-row">
                            <span class="grid-label">Kategori</span>
                            <span class="grid-value">{{ $buku->kategori->nama_kategori ?? '-' }}</span>
                        </div>
                    </div>

                    <div class="info-notice-box">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#b8742f" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>
                        <p>Buku ini tersedia untuk dipinjam maksimal 7 hari kerja. Pastikan untuk menjaga kebersihan dan keutuhan halaman buku demi kenyamanan bersama.</p>
                    </div>
                </div>

                {{-- Tab: Lokasi Koleksi --}}
                <div class="tab-content" id="tab-lokasi">
                    <div class="info-grid">
                        <div class="info-grid-row">
                            <span class="grid-label">Rak</span>
                            <span class="grid-value">{{ $buku->rak->kode_rak ?? '-' }} {{ $buku->rak->lokasi ?? '' }}</span>
                        </div>
                        <div class="info-grid-row">
                            <span class="grid-label">Nomor Panggil</span>
                            <span class="grid-value">{{ $buku->nomor_panggil ?? '-' }}</span>
                        </div>
                        <div class="info-grid-row">
                            <span class="grid-label">Status Koleksi</span>
                            <span class="grid-value">{{ $buku->stok_tersedia > 0 ? 'Tersedia di Rak' : 'Sedang Dipinjam' }}</span>
                        </div>
                        <div class="info-grid-row">
                            <span class="grid-label">Lantai</span>
                            <span class="grid-value">Lantai 1 — Area Koleksi Umum</span>
                        </div>
                    </div>

                    <div class="info-notice-box">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#2D7076" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                        <p>Tunjukkan Nomor Panggil di atas kepada petugas perpustakaan untuk mempermudah pencarian buku di rak.</p>
                    </div>
                </div>

            </div>
        </div>
    </section>

    {{-- ===== FOOTER (pertahankan asli) ===== --}}
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
    {{-- <script src="{{ asset('js/script-informasi-buku.js') }}"></script> --}}
</body>
</html>