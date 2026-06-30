@php
    $adminName = session('auth_name') ?? 'Admin';

    $search = $search ?? request('search');
    $kategori = $kategori ?? request('kategori');
    $sort = $sort ?? request('sort', 'terbaru');

    $kategoris = collect($kategoris ?? []);

    $coverUrl = function ($buku) {
        if (empty($buku->cover)) {
            return asset('assets/icon buku.png');
        }

        if (str_starts_with($buku->cover, 'http://') || str_starts_with($buku->cover, 'https://')) {
            return $buku->cover;
        }

        if (str_starts_with($buku->cover, 'assets/')) {
            return asset($buku->cover);
        }

        return asset('storage/' . $buku->cover);
    };

    $kategoriSlug = function ($namaKategori) {
        return strtolower(str_replace(' ', '-', $namaKategori ?? 'lainnya'));
    };

    $statusLabel = [
        'tersedia' => 'Tersedia',
        'stok_sedikit' => 'Stok Sedikit',
        'tidak_tersedia' => 'Tidak Tersedia',
    ];

    $statusClass = [
        'tersedia' => 'status-tersedia',
        'stok_sedikit' => 'status-tersedia',
        'tidak_tersedia' => 'status-habis',
    ];
@endphp

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Katalog Admin – Perpustakaan SMAIT Al-Uswah</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style-home.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style-home-anggota.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style-home-admin.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style-katalog.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style-katalog-admin.css') }}">
</head>
<body class="admin-page">

    {{-- ===== NAVBAR ===== --}}
    <header class="navbar">
        <div class="navbar-inner">
            <a href="{{ url('/home-admin') }}" class="nav-brand">
                <img src="{{ asset('assets/logo.png') }}" alt="Logo" class="nav-logo">
                <span class="nav-brand-name">Al-Uswah Library</span>
            </a>

            <nav class="nav-links">
                <a href="{{ url('/dashboard-admin') }}" class="nav-link">Dashboard</a>
                <a href="{{ url('/katalog-admin') }}" class="nav-link active">Katalog</a>
                <a href="{{ url('/tentang-perpustakaan-admin') }}" class="nav-link">Tentang</a>
                <a href="{{ url('/kelola-buku') }}" class="nav-link">Buku</a>
                <a href="{{ url('/kelola-anggota') }}" class="nav-link">Anggota</a>
                <a href="{{ url('/riwayat-transaksi') }}" class="nav-link">Transaksi</a>
                <a href="{{ url('/kelola-denda') }}" class="nav-link">Denda</a>
            </nav>

            <a href="{{ url('/setting') }}" class="nav-profile">
                <div class="nav-avatar">
                    <div class="avatar-placeholder admin-avatar">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                    </div>
                </div>
                <div class="nav-profile-info">
                    <span class="nav-username">{{ $adminName }}</span>
                    <span class="nav-role">Administrator</span>
                </div>
            </a>
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
                    <form action="{{ url('/katalog-admin') }}" method="GET" class="hero-search katalog-search">
                        <input type="hidden" name="kategori" value="{{ $kategori }}">
                        <input type="hidden" name="sort" value="{{ $sort }}">

                        <svg class="search-icon" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#484441" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                        <input type="text" id="heroSearch" name="search" value="{{ $search }}" placeholder="Cari judul buku, penulis, atau ISBN..." class="search-input">
                        <button type="submit" class="btn-search" id="btnHeroSearch">Cari &rarr;</button>
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
            <form action="{{ url('/katalog-admin') }}" method="GET" class="filter-categories">
                <input type="hidden" name="search" value="{{ $search }}">
                <input type="hidden" name="sort" value="{{ $sort }}">

                <button type="submit" name="kategori" value="" class="filter-btn {{ empty($kategori) ? 'active' : '' }}" data-kategori="semua">
                    Semua Kategori
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg>
                </button>

                @foreach ($kategoris as $itemKategori)
                    <button type="submit"
                        name="kategori"
                        value="{{ $itemKategori->id }}"
                        class="filter-btn {{ (string) $kategori === (string) $itemKategori->id ? 'active' : '' }}"
                        data-kategori="{{ $kategoriSlug($itemKategori->nama_kategori) }}">
                        {{ $itemKategori->nama_kategori }}
                    </button>
                @endforeach
            </form>

            <div class="filter-sort">
                <label class="sort-label">Urutkan:</label>
                <form action="{{ url('/katalog-admin') }}" method="GET" class="select-wrap sort-wrap">
                    <input type="hidden" name="search" value="{{ $search }}">
                    <input type="hidden" name="kategori" value="{{ $kategori }}">

                    <select id="sortSelect" name="sort" class="sort-select" onchange="this.form.submit()">
                        <option value="terbaru" {{ $sort === 'terbaru' ? 'selected' : '' }}>Terbaru</option>
                        <option value="terlama" {{ $sort === 'terlama' ? 'selected' : '' }}>Terlama</option>
                        <option value="az" {{ $sort === 'az' ? 'selected' : '' }}>A – Z</option>
                        <option value="za" {{ $sort === 'za' ? 'selected' : '' }}>Z – A</option>
                        <option value="tersedia" {{ $sort === 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                    </select>
                    <svg class="select-arrow" xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#2D7076" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg>
                </form>
            </div>
        </div>
    </section>

    {{-- ===== GRID BUKU ===== --}}
    <section class="buku-section">
        <div class="buku-inner">

            {{-- Info hasil --}}
            <div class="hasil-info" id="hasilInfo">
                <span id="hasilText">
                    @if ($bukus->total() > 0)
                        Menampilkan <strong>{{ $bukus->total() }}</strong> buku
                    @else
                        Menampilkan <strong>0</strong> buku
                    @endif
                </span>
            </div>

            <div class="buku-grid" id="bukuGrid">
                @forelse ($bukus as $buku)
                    @php
                        $namaKategori = optional($buku->kategori)->nama_kategori ?? 'Lainnya';
                        $slugKategori = $kategoriSlug($namaKategori);

                        $statusBuku = $buku->status_buku ?? 'tidak_tersedia';
                        $labelStatus = $statusLabel[$statusBuku] ?? ucfirst(str_replace('_', ' ', $statusBuku));
                        $classStatus = $statusClass[$statusBuku] ?? 'status-habis';
                    @endphp

                    <div class="buku-card"
                        data-kategori="{{ $slugKategori }}"
                        data-judul="{{ $buku->judul_buku }}"
                        data-penulis="{{ $buku->penulis }}"
                        data-status="{{ $statusBuku }}"
                        data-tahun="{{ $buku->tahun_terbit ?? '' }}">

                        <div class="buku-cover-wrap">
                            <img src="{{ $coverUrl($buku) }}" alt="{{ $buku->judul_buku }}" class="buku-cover">
                        </div>

                        <div class="buku-info">
                            <div class="buku-meta-top">
                                <span class="buku-kategori kategori-{{ $slugKategori }}">{{ $namaKategori }}</span>
                                <span class="buku-status {{ $classStatus }}">
                                    <span class="status-dot"></span> {{ $labelStatus }}
                                </span>
                            </div>

                            <h3 class="buku-judul">{{ $buku->judul_buku }}</h3>
                            <p class="buku-penulis">{{ $buku->penulis }}</p>

                            <div class="buku-footer">
                                <span class="buku-isbn">ISBN: {{ $buku->isbn ?? '-' }}</span>
                                <a href="{{ url('/informasi-buku-admin/' . $buku->id) }}" class="btn-detail">Lihat Detail</a>
                            </div>
                        </div>
                    </div>
                @empty
                    {{-- kosong, empty state ada di bawah --}}
                @endforelse
            </div>

            {{-- Empty state --}}
            <div class="empty-state {{ $bukus->total() > 0 ? 'hidden' : '' }}" id="emptyState">
                <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="#2D7076" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                <h3>Buku tidak ditemukan</h3>
                <p>Coba kata kunci lain atau ubah filter kategori.</p>
                <a href="{{ url('/katalog-admin') }}" class="btn-reset" id="btnReset">Reset Pencarian</a>
            </div>

            {{-- Pagination --}}
            @if ($bukus->lastPage() > 1)
                <div class="pagination" id="pagination">
                    @if ($bukus->onFirstPage())
                        <button class="page-btn page-prev" id="pagePrev" disabled>
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
                        </button>
                    @else
                        <a href="{{ $bukus->previousPageUrl() }}" class="page-btn page-prev" id="pagePrev">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
                        </a>
                    @endif

                    @for ($i = 1; $i <= $bukus->lastPage(); $i++)
                        @if ($i === $bukus->currentPage())
                            <button class="page-btn active" data-page="{{ $i }}">{{ $i }}</button>
                        @else
                            <a href="{{ $bukus->url($i) }}" class="page-btn" data-page="{{ $i }}">{{ $i }}</a>
                        @endif
                    @endfor

                    @if ($bukus->hasMorePages())
                        <a href="{{ $bukus->nextPageUrl() }}" class="page-btn page-next" id="pageNext">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
                        </a>
                    @else
                        <button class="page-btn page-next" id="pageNext" disabled>
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
                        </button>
                    @endif
                </div>
            @endif

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
                    <li><a href="{{ url('/tentang-perpustakaan-admin') }}">Visi &amp; Misi</a></li>
                    <li><a href="{{ url('/kelola-buku') }}">Kelola Buku</a></li>
                </ul>
            </div>

            <div class="footer-col">
                <h4 class="footer-col-title">Dukungan</h4>
                <ul>
                    <li><a href="#">Pusat Bantuan</a></li>
                    <li><a href="{{ url('/tambah-buku') }}">Tambah Buku</a></li>
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

    {{-- Script lama dummy sengaja tidak dipakai dulu karena filter/search sekarang dari backend --}}
    {{-- <script src="{{ asset('js/script-katalog-admin.js') }}"></script> --}}
</body>
</html>