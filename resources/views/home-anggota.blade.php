<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beranda – Perpustakaan SMAIT Al-Uswah</title>

    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style-home.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style-home-anggota.css') }}">
</head>
<body>

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

    {{-- ===== NAVBAR ===== --}}
    <header class="navbar">
        <div class="navbar-inner">
            <a href="{{ url('/home-anggota') }}" class="nav-brand">
                <img src="{{ asset('assets/logo.png') }}" alt="Logo" class="nav-logo">
                <span class="nav-brand-name">Al-Uswah Library</span>
            </a>

        <nav class="nav-links">
            <a href="{{ url('/home-anggota') }}" class="nav-link active">Home</a>  {{-- Tambah ini --}}
            <a href="{{ url('/dashboard-anggota') }}" class="nav-link">Dashboard</a>
            <a href="{{ url('/katalog-anggota') }}" class="nav-link">Katalog</a>
            <a href="{{ url('/tentang-perpustakaan-anggota') }}" class="nav-link">Tentang</a>
            <a href="{{ url('/riwayat-peminjaman') }}" class="nav-link">Riwayat</a>
            <a href="{{ url('/status-denda') }}" class="nav-link">Denda</a>
        </nav>

            {{-- Profil anggota --}}
            <a href="{{ url('/profil-anggota') }}" class="nav-profile">
                <div class="nav-avatar">
                    @if($fotoUser)
                        <img src="{{ asset('storage/' . $fotoUser) }}" alt="Foto Profil" class="avatar-img">
                    @else
                        <span class="avatar-placeholder">{{ $inisialUser }}</span>
                    @endif
                </div>
                <span class="nav-username">{{ $namaUser }}</span>
            </a>
        </div>
    </header>

    {{-- ===== HERO ===== --}}
    <section class="hero">
        <div class="hero-inner">
            <div class="hero-text">
                <span class="hero-eyebrow">Ayo Membaca</span>
                <h1 class="hero-title">
                    Jendela Dunia,<br>
                    <em>Pintu Literasi</em>
                </h1>

                <p class="hero-desc">
                    Temukan ribuan koleksi literatur klasik dan modern<br>
                    untuk mendukung perjalanan intelektual Anda di<br>
                    lingkungan yang inspiratif.
                </p>

                <div class="hero-search">
                    <svg class="search-icon" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#484441" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="11" cy="11" r="8"/>
                        <line x1="21" y1="21" x2="16.65" y2="16.65"/>
                    </svg>

                    <input type="text" id="searchInput" placeholder="Cari judul buku, penulis, atau kategori..." class="search-input">
                    <a href="{{ url('/katalog-anggota') }}" class="btn-search" id="btnSearch">Cari</a>
                </div>
            </div>

            <div class="hero-illustration">
                <img src="{{ asset('assets/icon buku.png') }}" alt="Ilustrasi buku" class="hero-img">
            </div>
        </div>
    </section>

    {{-- ===== FEATURE CARDS ===== --}}
    <section class="cards-section">
        <div class="cards-inner">

            <div class="feature-card">
                <div class="card-icon-circle" style="background: rgba(213,197,219,.3);">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#2D7076" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/>
                        <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/>
                    </svg>
                </div>
                <h3 class="card-title">Katalog Buku</h3>
                <p class="card-desc">Jelajahi beragam genre mulai dari Sejarah hingga Sains Modern dalam satu koleksi terpadu.</p>
                <a href="{{ url('/katalog-anggota') }}" class="card-link">Mulai Jelajahi &rarr;</a>
            </div>

            <div class="feature-card">
                <div class="card-icon-circle" style="background: rgba(144,195,198,.3);">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#2D7076" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                        <circle cx="9" cy="7" r="4"/>
                        <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
                        <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                    </svg>
                </div>
                <h3 class="card-title">Riwayat Peminjaman</h3>
                <p class="card-desc">Lihat seluruh riwayat buku yang pernah kamu pinjam dan pantau status pengembaliannya.</p>
                <a href="{{ url('/riwayat-peminjaman') }}" class="card-link">Lihat Riwayat &rarr;</a>
            </div>

            <div class="feature-card">
                <div class="card-icon-circle" style="background: rgba(45,112,118,.12);">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#2D7076" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10"/>
                        <line x1="12" y1="8" x2="12" y2="12"/>
                        <line x1="12" y1="16" x2="12.01" y2="16"/>
                    </svg>
                </div>
                <h3 class="card-title">Tentang Kami</h3>
                <p class="card-desc">Pelajari visi kami dalam membangun ekosistem literasi yang modern bagi generasi masa depan.</p>
                <a href="{{ url('/tentang-perpustakaan-anggota') }}" class="card-link">Pelajari Visi &rarr;</a>
            </div>

        </div>
    </section>

    {{-- ===== KOLEKSI TERPOPULER ===== --}}
    <section class="popular-section">
        <div class="popular-inner">
            <div class="popular-header">
                <div>
                    <h2 class="popular-title">Koleksi Terpopuler</h2>
                    <p class="popular-subtitle">Buku-buku yang paling banyak diminati minggu ini.</p>
                </div>

                <a href="{{ url('/katalog-anggota') }}" class="btn-lihat-semua">
                    Lihat Semua
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="3" width="7" height="7"/>
                        <rect x="14" y="3" width="7" height="7"/>
                        <rect x="14" y="14" width="7" height="7"/>
                        <rect x="3" y="14" width="7" height="7"/>
                    </svg>
                </a>
            </div>

            <div class="book-grid">
                @forelse($bukuPopuler as $buku)
                    <a href="{{ url('/informasi-buku/' . $buku->id) }}" class="book-card-link">
                        <div class="book-card">
                            <div class="book-cover-wrap">
                                <span class="book-badge badge-{{ strtolower(str_replace(' ', '-', $buku->kategori->nama_kategori ?? 'umum')) }}">
                                    {{ $buku->kategori->nama_kategori ?? 'Umum' }}
                                </span>
                                <img src="{{ $buku->cover_url }}" alt="{{ $buku->judul_buku }}" class="book-cover-img">
                            </div>
                            <h4 class="book-title">{{ $buku->judul_buku }}</h4>
                            <p class="book-author">{{ $buku->penulis }}</p>
                            <span class="book-status status-{{ $buku->stok_tersedia > 0 ? 'tersedia' : 'dipinjam' }}">
                                <span class="status-dot"></span> 
                                {{ $buku->stok_tersedia > 0 ? 'Tersedia' : 'Dipinjam' }}
                            </span>
                        </div>
                    </a>
                @empty
                    <div style="text-align:center; padding:40px 0; width:100%;">
                        <p>Belum ada data buku.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    {{-- ===== REKOMENDASI BUKU ===== --}}
    <section class="rekomendasi-section">
        <div class="popular-inner">
            <div class="popular-header">
                <div>
                    <h2 class="popular-title">Rekomendasi untuk Kamu</h2>
                    <p class="popular-subtitle">Pilihan buku berdasarkan minat bacamu.</p>
                </div>

                <a href="{{ url('/katalog-anggota') }}" class="btn-lihat-semua">
                    Lihat Semua &rarr;
                </a>
            </div>

            <div class="book-grid">
                @forelse($rekomendasiBuku as $buku)
                    <a href="{{ url('/informasi-buku/' . $buku->id) }}" class="book-card-link">
                        <div class="book-card">
                            <div class="book-cover-wrap">
                                <span class="book-badge badge-{{ strtolower(str_replace(' ', '-', $buku->kategori->nama_kategori ?? 'umum')) }}">
                                    {{ $buku->kategori->nama_kategori ?? 'Umum' }}
                                </span>
                                <img src="{{ $buku->cover_url }}" alt="{{ $buku->judul_buku }}" class="book-cover-img">
                            </div>
                            <h4 class="book-title">{{ $buku->judul_buku }}</h4>
                            <p class="book-author">{{ $buku->penulis }}</p>
                            <span class="book-status status-{{ $buku->stok_tersedia > 0 ? 'tersedia' : 'dipinjam' }}">
                                <span class="status-dot"></span> 
                                {{ $buku->stok_tersedia > 0 ? 'Tersedia' : 'Dipinjam' }}
                            </span>
                        </div>
                    </a>
                @empty
                    <div style="text-align:center; padding:40px 0; width:100%;">
                        <p>Belum ada rekomendasi buku.</p>
                    </div>
                @endforelse
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

                <p class="footer-tagline">
                    © 2026 SMAIT Al-Uswah Library.<br>
                    Menumbuhkan Literasi,<br>
                    Mengukir Prestasi.
                </p>

                <div class="footer-socials">
                    <a href="#" class="social-btn" aria-label="Instagram">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="2" y="2" width="20" height="20" rx="5" ry="5"/>
                            <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/>
                            <line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/>
                        </svg>
                    </a>

                    <a href="#" class="social-btn" aria-label="Email">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                            <polyline points="22,6 12,12 2,6"/>
                        </svg>
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchInput');
            const btnSearch = document.getElementById('btnSearch');

            function doSearch() {
                const query = searchInput.value.trim();
                if (query) {
                    window.location.href = '{{ url("/katalog-anggota") }}?search=' + encodeURIComponent(query);
                } else {
                    window.location.href = '{{ url("/katalog-anggota") }}';
                }
            }

            if (btnSearch) {
                btnSearch.addEventListener('click', function(e) {
                    e.preventDefault();
                    doSearch();
                });
            }

            if (searchInput) {
                searchInput.addEventListener('keypress', function(e) {
                    if (e.key === 'Enter') {
                        e.preventDefault();
                        doSearch();
                    }
                });
            }
        });
    </script>

    {{-- Matikan script JS yang mengganggu --}}
    {{-- <script src="{{ asset('js/script-home-anggota.js') }}"></script> --}}
</body>
</html>