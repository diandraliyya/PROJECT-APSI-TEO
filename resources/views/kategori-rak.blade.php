@php
    $adminName = session('auth_name') ?? 'Admin';

    $kategoris = collect($kategoris ?? []);
    $raks = collect($raks ?? []);

    $kategoriIconClasses = [
        'ic-fiksi',
        'ic-sejarah',
        'ic-sains',
        'ic-agama',
        'ic-filsafat',
        'ic-motivasi',
    ];
@endphp

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Kategori & Rak – Perpustakaan SMAIT Al-Uswah</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style-home.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style-home-anggota.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style-home-admin.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style-kategori-rak.css') }}">
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
            <a href="{{ url('/home-admin') }}" class="nav-link {{ request()->is('home-admin') ? 'active' : '' }}">Home</a>
            <a href="{{ url('/dashboard-admin') }}" class="nav-link {{ request()->is('dashboard-admin') ? 'active' : '' }}">Dashboard</a>
            <a href="{{ url('/katalog-admin') }}" class="nav-link {{ request()->is('katalog-admin') ? 'active' : '' }}">Katalog</a>
            <a href="{{ url('/tentang-perpustakaan-admin') }}" class="nav-link {{ request()->is('tentang-perpustakaan-admin') ? 'active' : '' }}">Tentang</a>
            <a href="{{ url('/kelola-buku') }}" class="nav-link {{ request()->is('kelola-buku') ? 'active' : '' }}">Buku</a>
            <a href="{{ url('/kelola-anggota') }}" class="nav-link {{ request()->is('kelola-anggota') ? 'active' : '' }}">Anggota</a>
            <a href="{{ url('/riwayat-transaksi') }}" class="nav-link {{ request()->is('riwayat-transaksi') ? 'active' : '' }}">Transaksi</a>
            <a href="{{ url('/kelola-denda') }}" class="nav-link {{ request()->is('kelola-denda') ? 'active' : '' }}">Denda</a>
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

    {{-- ===== HERO ===== --}}
    <section class="kr-hero">
        <div class="kr-hero-inner">
            <div>
                <h1 class="kr-title">Manajemen Kategori &amp; Rak</h1>
                <p class="kr-desc">Kelola pengelompokan buku dan tata letak perpustakaan agar lebih terorganisir.</p>
            </div>
            <div class="kr-hero-deco">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="#b8742f" stroke="none"><path d="M12 2l2.4 7.4H22l-6.2 4.5 2.4 7.4L12 17l-6.2 4.3 2.4-7.4L2 9.4h7.6z"/></svg>
                <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 24 24" fill="#90C3C6" stroke="none"><path d="M12 2l2.4 7.4H22l-6.2 4.5 2.4 7.4L12 17l-6.2 4.3 2.4-7.4L2 9.4h7.6z"/></svg>
            </div>
        </div>
    </section>

    {{-- ===== MODE TOGGLE ===== --}}
    <section class="kr-toggle-section">
        <div class="kr-toggle-inner">
            <div class="kr-toggle">
                <button class="kr-toggle-btn active" id="btnModeKategori" data-mode="kategori">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/></svg>
                    Manajemen Kategori
                </button>
                <button class="kr-toggle-btn" id="btnModeRak" data-mode="rak">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="3" width="20" height="5" rx="1"/><rect x="2" y="10" width="20" height="5" rx="1"/><rect x="2" y="17" width="20" height="5" rx="1"/></svg>
                    Manajemen Rak
                </button>
            </div>
        </div>
    </section>

    {{-- ===== MODE KATEGORI ===== --}}
    <div id="modeKategori">
        <section class="kr-main-section">
            <div class="kr-main-inner">

                {{-- Form Tambah Kategori --}}
                <div class="kr-form-card">
                    <div class="kr-card-head">
                        <div class="kr-card-ic ic-teal">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/></svg>
                        </div>
                        <h2 class="kr-card-title">Tambah Kategori</h2>
                    </div>

                    <form id="formTambahKategori" action="{{ url('/kategori-rak/kategori') }}" method="POST" novalidate>
                        @csrf

                        <div class="kr-form-group">
                            <label for="namaKategori">Nama Kategori <span class="kr-req">*</span></label>
                            <input type="text" id="namaKategori" name="nama_kategori" placeholder="Contoh: Fiksi Populer" value="{{ old('nama_kategori') }}">
                            <span class="kr-err" id="err-namaKategori">
                                @error('nama_kategori')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>

                        <div class="kr-form-group">
                            <label for="deskripsiKategori">Deskripsi</label>
                            <textarea id="deskripsiKategori" name="deskripsi" rows="3" placeholder="Penjelasan singkat mengenai kategori...">{{ old('deskripsi') }}</textarea>
                            <span class="kr-err">
                                @error('deskripsi')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>

                        <button type="submit" class="btn-kr-submit" onclick="event.stopImmediatePropagation(); this.closest('form').submit(); return false;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                            Tambah Kategori
                        </button>
                    </form>
                </div>

                {{-- Daftar Kategori --}}
                <div class="kr-list-card">
                    <div class="kr-list-head">
                        <h2 class="kr-list-title">Daftar Kategori</h2>
                        <span class="kr-list-count" id="kategoriCount">{{ $kategoris->count() }} Kategori</span>
                    </div>

                    <div class="kr-search-wrap">
                        <svg class="kr-search-ic" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#2D7076" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                        <input type="text" id="searchBukuKategori" class="kr-search" placeholder="Cari buku dalam kategori...">
                    </div>

                    <ul class="kr-list" id="listKategori">
                        @forelse ($kategoris as $kategori)
                            @php
                                $targetId = 'kat-' . $kategori->id;
                                $iconClass = $kategoriIconClasses[$loop->index % count($kategoriIconClasses)];
                                $deskripsiKategori = $kategori->deskripsi ?: ($kategori->bukus_count . ' buku dalam kategori ini');
                            @endphp

                            <li class="kr-item" data-id="{{ $targetId }}">
                                <div class="kr-item-main">
                                    <div class="kr-item-ic {{ $iconClass }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>
                                    </div>

                                    <div class="kr-item-info">
                                        <span class="kr-item-nama">{{ $kategori->nama_kategori }}</span>
                                        <span class="kr-item-sub">{{ $deskripsiKategori }}</span>
                                    </div>

                                    <div class="kr-item-actions">
                                        <button type="button" class="kr-btn-expand" data-target="{{ $targetId }}" title="Lihat buku">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg>
                                        </button>

                                        <form action="{{ url('/kategori-rak/kategori/' . $kategori->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit" class="kr-btn-hapus" data-id="{{ $targetId }}" data-nama="{{ $kategori->nama_kategori }}" title="Hapus" onclick="event.stopImmediatePropagation(); return confirm('Hapus kategori {{ $kategori->nama_kategori }}?');">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                                            </button>
                                        </form>
                                    </div>
                                </div>

                                <div class="kr-item-books" id="books-{{ $targetId }}">
                                    <div class="kr-books-search-wrap">
                                        <input type="text" class="kr-books-search" placeholder="Cari di {{ $kategori->nama_kategori }}..." data-target="{{ $targetId }}">
                                    </div>

                                    <ul class="kr-book-list">
                                        @forelse ($kategori->bukus as $buku)
                                            @php
                                                $stokClass = $buku->stok_tersedia <= 0 ? 'stok-empty' : ($buku->stok_tersedia <= 2 ? 'stok-warn' : 'stok-ok');

                                                $coverUrl = asset('assets/icon buku.png');

                                                if (!empty($buku->cover)) {
                                                    if (str_starts_with($buku->cover, 'http://') || str_starts_with($buku->cover, 'https://')) {
                                                        $coverUrl = $buku->cover;
                                                    } elseif (str_starts_with($buku->cover, 'assets/')) {
                                                        $coverUrl = asset($buku->cover);
                                                    } else {
                                                        $coverUrl = asset('storage/' . $buku->cover);
                                                    }
                                                }
                                            @endphp

                                            <li class="kr-book-item" data-judul="{{ strtolower($buku->judul_buku) }}" data-penulis="{{ strtolower($buku->penulis) }}">
                                                <img src="{{ $coverUrl }}" alt="Cover" class="kr-book-cover">

                                                <div class="kr-book-info">
                                                    <span class="kr-book-judul">{{ $buku->judul_buku }}</span>
                                                    <span class="kr-book-penulis">{{ $buku->penulis }}</span>
                                                </div>

                                                <span class="kr-book-stok {{ $stokClass }}">Stok: {{ $buku->stok_tersedia }}</span>

                                                <a href="{{ url('/informasi-buku/' . $buku->id) }}" class="kr-book-link" title="Detail">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#2D7076" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                                </a>
                                            </li>
                                        @empty
                                            <li class="kr-no-book">Belum ada buku di kategori ini.</li>
                                        @endforelse
                                    </ul>
                                </div>
                            </li>
                        @empty
                            <li class="kr-item">
                                <div class="kr-item-main">
                                    <div class="kr-item-ic ic-fiksi">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>
                                    </div>
                                    <div class="kr-item-info">
                                        <span class="kr-item-nama">Belum ada kategori</span>
                                        <span class="kr-item-sub">Tambahkan kategori baru melalui form di sebelah kiri.</span>
                                    </div>
                                </div>
                            </li>
                        @endforelse
                    </ul>
                </div>

            </div>
        </section>
    </div>

    {{-- ===== MODE RAK ===== --}}
    <div id="modeRak" style="display:none;">
        <section class="kr-main-section">
            <div class="kr-main-inner">

                {{-- Form Tambah Rak --}}
                <div class="kr-form-card">
                    <div class="kr-card-head">
                        <div class="kr-card-ic ic-orange">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="3" width="20" height="5" rx="1"/><rect x="2" y="10" width="20" height="5" rx="1"/><rect x="2" y="17" width="20" height="5" rx="1"/></svg>
                        </div>
                        <h2 class="kr-card-title">Tambah Rak Buku</h2>
                    </div>

                    <form id="formTambahRak" action="{{ url('/kategori-rak/rak') }}" method="POST" novalidate>
                        @csrf

                        <div class="kr-form-row">
                            <div class="kr-form-group">
                                <label for="kodeRak">Kode Rak <span class="kr-req">*</span></label>
                                <input type="text" id="kodeRak" name="kode_rak" placeholder="Contoh: F-001" value="{{ old('kode_rak') }}">
                                <span class="kr-err" id="err-kodeRak">
                                    @error('kode_rak')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>

                            <div class="kr-form-group">
                                <label for="lokasiRak">Lokasi <span class="kr-req">*</span></label>
                                <input type="text" id="lokasiRak" name="lokasi" placeholder="Contoh: Lantai 1 Sayap Kiri" value="{{ old('lokasi') }}">
                                <span class="kr-err" id="err-lokasiRak">
                                    @error('lokasi')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>
                        </div>

                        <div class="kr-form-group">
                            <label for="keteranganRak">Keterangan</label>
                            <textarea id="keteranganRak" name="deskripsi" rows="2" placeholder="Misal: Sayap Kanan dekat Jendela...">{{ old('deskripsi') }}</textarea>
                        </div>

                        <button type="submit" class="btn-kr-submit btn-rak" onclick="event.stopImmediatePropagation(); this.closest('form').submit(); return false;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                            Tambah Rak
                        </button>
                    </form>
                </div>

                {{-- Daftar Rak --}}
                <div class="kr-list-card">
                    <div class="kr-list-head">
                        <h2 class="kr-list-title">Daftar Rak</h2>
                        <span class="kr-list-count" id="rakCount">{{ $raks->count() }} Rak</span>
                    </div>

                    <div class="kr-search-wrap">
                        <svg class="kr-search-ic" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#2D7076" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                        <input type="text" id="searchBukuRak" class="kr-search" placeholder="Cari buku dalam rak...">
                    </div>

                    <ul class="kr-list" id="listRak">
                        @forelse ($raks as $rak)
                            @php
                                $targetId = 'rak-' . $rak->id;
                                $kodePendek = strtoupper(substr($rak->kode_rak, 0, 2));
                                $deskripsiRak = $rak->deskripsi ?: ($rak->bukus_count . ' buku berada di rak ini');
                            @endphp

                            <li class="kr-item" data-id="{{ $targetId }}">
                                <div class="kr-item-main">
                                    <div class="kr-item-kode">{{ $kodePendek }}</div>

                                    <div class="kr-item-info">
                                        <span class="kr-item-nama">
                                            Rak {{ $rak->kode_rak }}
                                            @if ($rak->lokasi)
                                                <span class="kr-rak-lokasi">· {{ $rak->lokasi }}</span>
                                            @endif
                                        </span>
                                        <span class="kr-item-sub">{{ $deskripsiRak }}</span>
                                    </div>

                                    <div class="kr-item-actions">
                                        <button type="button" class="kr-btn-expand" data-target="{{ $targetId }}" title="Lihat buku">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg>
                                        </button>

                                        <form action="{{ url('/kategori-rak/rak/' . $rak->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit" class="kr-btn-hapus" data-id="{{ $targetId }}" data-nama="Rak {{ $rak->kode_rak }}" title="Hapus" onclick="event.stopImmediatePropagation(); return confirm('Hapus rak {{ $rak->kode_rak }}?');">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                                            </button>
                                        </form>
                                    </div>
                                </div>

                                <div class="kr-item-books" id="books-{{ $targetId }}">
                                    <div class="kr-books-search-wrap">
                                        <input type="text" class="kr-books-search" placeholder="Cari di Rak {{ $rak->kode_rak }}..." data-target="{{ $targetId }}">
                                    </div>

                                    <ul class="kr-book-list">
                                        @forelse ($rak->bukus as $buku)
                                            @php
                                                $stokClass = $buku->stok_tersedia <= 0 ? 'stok-empty' : ($buku->stok_tersedia <= 2 ? 'stok-warn' : 'stok-ok');

                                                $coverUrl = asset('assets/icon buku.png');

                                                if (!empty($buku->cover)) {
                                                    if (str_starts_with($buku->cover, 'http://') || str_starts_with($buku->cover, 'https://')) {
                                                        $coverUrl = $buku->cover;
                                                    } elseif (str_starts_with($buku->cover, 'assets/')) {
                                                        $coverUrl = asset($buku->cover);
                                                    } else {
                                                        $coverUrl = asset('storage/' . $buku->cover);
                                                    }
                                                }
                                            @endphp

                                            <li class="kr-book-item" data-judul="{{ strtolower($buku->judul_buku) }}" data-penulis="{{ strtolower($buku->penulis) }}">
                                                <img src="{{ $coverUrl }}" alt="Cover" class="kr-book-cover">

                                                <div class="kr-book-info">
                                                    <span class="kr-book-judul">{{ $buku->judul_buku }}</span>
                                                    <span class="kr-book-penulis">{{ $buku->penulis }} · {{ $buku->nomor_panggil ?? '-' }}</span>
                                                </div>

                                                <span class="kr-book-stok {{ $stokClass }}">Stok: {{ $buku->stok_tersedia }}</span>

                                                <a href="{{ url('/informasi-buku/' . $buku->id) }}" class="kr-book-link" title="Detail">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#2D7076" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                                </a>
                                            </li>
                                        @empty
                                            <li class="kr-no-book">Belum ada buku di rak ini.</li>
                                        @endforelse
                                    </ul>
                                </div>
                            </li>
                        @empty
                            <li class="kr-item">
                                <div class="kr-item-main">
                                    <div class="kr-item-kode">-</div>
                                    <div class="kr-item-info">
                                        <span class="kr-item-nama">Belum ada rak</span>
                                        <span class="kr-item-sub">Tambahkan rak baru melalui form di sebelah kiri.</span>
                                    </div>
                                </div>
                            </li>
                        @endforelse
                    </ul>
                </div>

            </div>
        </section>
    </div>

    {{-- ===== MODAL HAPUS ===== --}}
    <div class="kr-modal" id="krModal">
        <div class="kr-modal-inner">
            <div class="kr-modal-ic">
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#c0392b" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
            </div>
            <h3 class="kr-modal-title">Hapus <span id="krModalNama"></span>?</h3>
            <p class="kr-modal-desc">Tindakan ini tidak bisa dibatalkan. Kategori/rak yang dihapus tidak dapat dipulihkan.</p>
            <div class="kr-modal-btns">
                <button class="btn-kr-konfirm" id="btnKrKonfirm">Ya, Hapus</button>
                <button class="btn-kr-batal" id="btnKrBatal">Batal</button>
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
                <h4 class="footer-col-title">Navigasi</h4>
                <ul>
                    <li><a href="{{ url('/kelola-buku') }}">Kelola Buku</a></li>
                    <li><a href="{{ url('/tambah-buku') }}">Tambah Buku</a></li>
                </ul>
            </div>

            <div class="footer-col">
                <h4 class="footer-col-title">Kebijakan</h4>
                <ul>
                    <li><a href="#">Privacy Policy</a></li>
                    <li><a href="#">Terms of Service</a></li>
                </ul>
            </div>

            <div class="footer-col">
                <h4 class="footer-col-title">Hubungi Kami</h4>
                <address>library@smait-aluswah.sch.id<br>Surabaya, Jawa Timur</address>
            </div>
        </div>

        <div class="footer-bottom">
            <p>© 2026 Perpustakaan SMAIT Al-Uswah. Menjaga Tradisi, Membangun Literasi.</p>
        </div>
    </footer>

    <script src="{{ asset('js/script-kategori-rak.js') }}"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const toast = document.getElementById('toast');

            const toastMessage = @json(session('success') ?? session('error') ?? ($errors->any() ? 'Periksa kembali data yang diisi.' : null));

            if (toast && toastMessage) {
                toast.textContent = toastMessage;
                toast.classList.add('show');

                setTimeout(function () {
                    toast.classList.remove('show');
                }, 3000);
            }

            const hasRakError = @json($errors->has('kode_rak') || $errors->has('lokasi'));

            if (hasRakError) {
                const modeKategori = document.getElementById('modeKategori');
                const modeRak = document.getElementById('modeRak');
                const btnModeKategori = document.getElementById('btnModeKategori');
                const btnModeRak = document.getElementById('btnModeRak');

                if (modeKategori && modeRak && btnModeKategori && btnModeRak) {
                    modeKategori.style.display = 'none';
                    modeRak.style.display = '';
                    btnModeKategori.classList.remove('active');
                    btnModeRak.classList.add('active');
                }
            }
        });
    </script>
</body>
</html>