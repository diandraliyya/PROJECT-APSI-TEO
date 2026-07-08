<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Katalog – Perpustakaan SMAIT Al-Uswah</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style-home.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style-home-anggota.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style-katalog.css') }}">
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
                <a href="{{ url('/katalog') }}" class="nav-link active">Katalog</a>
                <a href="{{ url('/tentang-perpustakaan') }}" class="nav-link">Tentang</a>
                <a href="{{ url('/register') }}" class="nav-link">Daftar Anggota</a>
            </nav>

            <a href="{{ url('/log-in') }}" class="btn-nav-cta">Masuk</a>
        </div>
    </header>

    {{-- ===== HERO KATALOG ===== --}}
    <section class="katalog-hero">
        <div class="katalog-hero-inner">
            <div class="katalog-hero-text">
                <span class="katalog-badge">
                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>
                    PERPUSTAKAAN DIGITAL
                </span>
                <h1 class="katalog-title">
                    Jelajahi Literasi,<br>
                    <em>Buka Jendela Dunia</em>
                </h1>
                <p class="katalog-desc">
                    Temukan ribuan koleksi buku pilihan mulai dari khazanah<br>
                    klasik hingga literatur modern untuk mendukung<br>
                    petualangan belajarmu.
                </p>

                <div class="katalog-search-wrap">
                    <form action="{{ url('/katalog') }}" method="GET" class="hero-search katalog-search" style="display: flex; width: 100%;">
                        <svg class="search-icon" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#484441" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                        <input type="text" name="search" id="heroSearch" placeholder="Cari judul buku, penulis, atau ISBN..." class="search-input" value="{{ request('search') }}">
                        <button type="submit" class="btn-search">Cari &rarr;</button>
                    </form>
                </div>
            </div>

            <div class="katalog-hero-img">
                <img src="{{ asset('assets/icon buku.png') }}" alt="Ilustrasi buku" class="katalog-illustration">
            </div>
        </div>
    </section>

    {{-- ===== FILTER & SORT ===== --}}
    <section class="filter-section">
        <div class="filter-inner">
            <div class="filter-categories">
                <a href="{{ url('/katalog') }}" class="filter-btn {{ !request('kategori') ? 'active' : '' }}" data-kategori="">
                    Semua Kategori
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg>
                </a>
                @foreach($kategoris as $kat)
                    <a href="{{ url('/katalog?kategori=' . urlencode($kat->nama_kategori) . (request('search') ? '&search=' . urlencode(request('search')) : '')) }}" 
                       class="filter-btn {{ request('kategori') == $kat->nama_kategori ? 'active' : '' }}" 
                       data-kategori="{{ $kat->nama_kategori }}">
                        {{ $kat->nama_kategori }}
                    </a>
                @endforeach
            </div>

            <div class="filter-sort">
                <label class="sort-label">Urutkan:</label>
                <div class="select-wrap sort-wrap">
                    <select id="sortSelect" class="sort-select" onchange="window.location.href=this.value">
                        <option value="{{ url('/katalog?sort=terbaru' . (request('search') ? '&search=' . urlencode(request('search')) : '') . (request('kategori') ? '&kategori=' . urlencode(request('kategori')) : '')) }}" {{ request('sort') == 'terbaru' || !request('sort') ? 'selected' : '' }}>Terbaru</option>
                        <option value="{{ url('/katalog?sort=terlama' . (request('search') ? '&search=' . urlencode(request('search')) : '') . (request('kategori') ? '&kategori=' . urlencode(request('kategori')) : '')) }}" {{ request('sort') == 'terlama' ? 'selected' : '' }}>Terlama</option>
                        <option value="{{ url('/katalog?sort=az' . (request('search') ? '&search=' . urlencode(request('search')) : '') . (request('kategori') ? '&kategori=' . urlencode(request('kategori')) : '')) }}" {{ request('sort') == 'az' ? 'selected' : '' }}>A – Z</option>
                        <option value="{{ url('/katalog?sort=za' . (request('search') ? '&search=' . urlencode(request('search')) : '') . (request('kategori') ? '&kategori=' . urlencode(request('kategori')) : '')) }}" {{ request('sort') == 'za' ? 'selected' : '' }}>Z – A</option>
                        <option value="{{ url('/katalog?sort=tersedia' . (request('search') ? '&search=' . urlencode(request('search')) : '') . (request('kategori') ? '&kategori=' . urlencode(request('kategori')) : '')) }}" {{ request('sort') == 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                    </select>
                    <svg class="select-arrow" xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#2D7076" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg>
                </div>
            </div>
        </div>
    </section>

    {{-- ===== GRID BUKU ===== --}}
    <section class="buku-section">
        <div class="buku-inner">

            {{-- Info hasil --}}
            <div class="hasil-info" id="hasilInfo">
                <span id="hasilText">Menampilkan <strong>{{ $bukus->total() }}</strong> buku</span>
            </div>

            <div class="buku-grid" id="bukuGrid">
                @forelse($bukus as $buku)
                    <div class="buku-card" data-kategori="{{ $buku->kategori->nama_kategori ?? '' }}" data-judul="{{ $buku->judul_buku }}" data-penulis="{{ $buku->penulis }}" data-status="{{ $buku->stok_tersedia > 0 ? 'tersedia' : 'tidak_tersedia' }}" data-tahun="{{ $buku->tahun_terbit ?? '' }}">
                        <div class="buku-cover-wrap">
                            <img src="{{ $buku->cover_url }}" alt="{{ $buku->judul_buku }}" class="buku-cover">
                        </div>
                        <div class="buku-info">
                            <div class="buku-meta-top">
                                <span class="buku-kategori kategori-{{ strtolower(str_replace(' ', '-', $buku->kategori->nama_kategori ?? 'umum')) }}">
                                    {{ $buku->kategori->nama_kategori ?? 'Umum' }}
                                </span>
                                <span class="buku-status status-{{ $buku->stok_tersedia > 0 ? 'tersedia' : 'tidak_tersedia' }}">
                                    <span class="status-dot"></span> 
                                    {{ $buku->stok_tersedia > 0 ? 'Tersedia' : 'Tidak Tersedia' }}
                                </span>
                            </div>
                            <h3 class="buku-judul">{{ $buku->judul_buku }}</h3>
                            <p class="buku-penulis">{{ $buku->penulis }}</p>
                            <div class="buku-footer">
                                <span class="buku-isbn">ISBN: {{ $buku->isbn ?? '-' }}</span>
                                @if(session('auth_role'))
                                    <a href="{{ url('/informasi-buku/' . $buku->id) }}" class="btn-detail">Lihat Detail</a>
                                @else
                                    <button type="button" class="btn-detail" onclick="showLoginPrompt()">Lihat Detail</button>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="empty-state" id="emptyState">
                        <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="#2D7076" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                        <h3>Buku tidak ditemukan</h3>
                        <p>Coba kata kunci lain atau ubah filter kategori.</p>
                        <a href="{{ url('/katalog') }}" class="btn-reset" id="btnReset">Reset Pencarian</a>
                    </div>
                @endforelse
            </div>

            {{-- Pagination --}}
            <div class="pagination" id="pagination">
                {{ $bukus->appends(request()->query())->links() }}
            </div>

        </div>
    </section>

    {{-- Modal: harus login dulu --}}
    <div class="modal-overlay" id="loginPromptModal">
        <div class="modal-box">
            <div class="modal-icon-wrap">
                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="#2D7076" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
            </div>
            <h3 class="modal-title">Masuk untuk Melanjutkan</h3>
            <p class="modal-body">Kamu perlu masuk atau mendaftar sebagai anggota untuk melihat informasi detail buku dan melakukan peminjaman.</p>
            <div class="modal-btns">
                <a href="{{ url('/log-in') }}" class="btn-modal">Masuk Sekarang</a>
                <button class="btn-modal-outline" onclick="closeLoginPrompt()">Nanti Saja</button>
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
        // Fungsi untuk modal login
        function showLoginPrompt() {
            document.getElementById('loginPromptModal').classList.add('active');
        }

        function closeLoginPrompt() {
            document.getElementById('loginPromptModal').classList.remove('active');
        }

        // Tutup modal dengan klik di luar
        document.addEventListener('click', function(e) {
            const modal = document.getElementById('loginPromptModal');
            if (e.target === modal) {
                closeLoginPrompt();
            }
        });
    </script>

    {{-- Matikan script JS yang mengganggu --}}
    {{-- <script src="{{ asset('js/script-katalog.js') }}"></script> --}}
</body>
</html>