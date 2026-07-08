@php
    $adminName = session('auth_name') ?? 'Admin';

    $kategoris = collect($kategoris ?? []);
    $raks = collect($raks ?? []);

    $statusBuku = $buku->status_buku ?? 'tidak_tersedia';

    $statusLabel = [
        'tersedia' => 'Tersedia',
        'stok_sedikit' => 'Stok Sedikit',
        'tidak_tersedia' => 'Tidak Tersedia',
    ];

    $statusBadgeClass = [
        'tersedia' => 'tersedia',
        'stok_sedikit' => 'sedikit',
        'tidak_tersedia' => 'habis',
    ];

    $labelStatus = $statusLabel[$statusBuku] ?? ucfirst(str_replace('_', ' ', $statusBuku));
    $badgeClass = $statusBadgeClass[$statusBuku] ?? 'habis';

    $totalPeminjaman = 0;

    try {
        $totalPeminjaman = $buku->detailTransaksis()->sum('jumlah');
    } catch (\Throwable $e) {
        $totalPeminjaman = 0;
    }

    $isPopuler = $totalPeminjaman >= 5;
@endphp

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Buku – {{ $buku->judul_buku }} – Perpustakaan SMAIT Al-Uswah</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style-home.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style-home-anggota.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style-home-admin.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style-edit-buku.css') }}">
</head>
<body class="admin-page">

    {{-- NAVBAR --}}
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

    {{-- HERO --}}
    <section class="eb-hero">
        <div class="eb-hero-inner">
            <div>
                <span class="eb-eyebrow">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#b8742f" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="8" y1="6" x2="21" y2="6"/><line x1="8" y1="12" x2="21" y2="12"/><line x1="8" y1="18" x2="21" y2="18"/><line x1="3" y1="6" x2="3.01" y2="6"/><line x1="3" y1="12" x2="3.01" y2="12"/><line x1="3" y1="18" x2="3.01" y2="18"/></svg>
                    Manajemen Koleksi
                </span>
                <h1 class="eb-title">Edit Data Buku</h1>
                <p class="eb-desc">Perbarui informasi koleksi buku perpustakaan untuk memastikan data tetap akurat.</p>
            </div>
            <div class="eb-hero-star">
                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="#b8742f" stroke="none"><path d="M12 2l2.4 7.4H22l-6.2 4.5 2.4 7.4L12 17l-6.2 4.3 2.4-7.4L2 9.4h7.6z"/></svg>
            </div>
        </div>
    </section>

    {{-- MAIN GRID --}}
    <section class="eb-main">
        <div class="eb-main-inner">
            <form id="editBukuForm" action="{{ url('/edit-buku/' . $buku->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="eb-grid">

                    {{-- LEFT: Pratinjau --}}
                    <div class="eb-left">
                        <div class="eb-preview-card">
                            <div class="eb-preview-head">
                                <h3 class="eb-preview-title">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#b8742f" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="3" width="20" height="14" rx="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg>
                                    Pratinjau Saat Ini
                                </h3>
                                <span class="eb-status-badge badge-{{ $badgeClass }}">{{ $labelStatus }}</span>
                            </div>

                            <div class="eb-cover-wrap" id="ebCoverWrap">
                                <img src="{{ $buku->cover_url }}" alt="{{ $buku->judul_buku }}" class="eb-cover-img" id="ebCoverImg">
                                <input type="file" id="ebCoverInput" name="cover" accept="image/jpeg,image/png,image/webp" hidden>
                            </div>

                            @error('cover')
                                <span class="eb-err">{{ $message }}</span>
                            @enderror

                            <h3 class="eb-preview-judul">{{ $buku->judul_buku }}</h3>
                            <p class="eb-preview-id">ID: BUKU-{{ str_pad($buku->id, 4, '0', STR_PAD_LEFT) }}</p>

                            <button type="button" class="btn-ganti-sampul" id="btnGantiSampul">
                                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                                Ganti Sampul
                            </button>

                            <div class="eb-stats">
                                <div class="eb-stat">
                                    <span class="eb-stat-label">PEMINJAMAN</span>
                                    <span class="eb-stat-value">{{ $totalPeminjaman }}</span>
                                </div>
                                <div class="eb-stat">
                                    <span class="eb-stat-label">POPULER</span>
                                    <span class="eb-stat-value">
                                        @if($isPopuler)
                                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="#b8742f" stroke="none"><path d="M12 2l2.4 7.4H22l-6.2 4.5 2.4 7.4L12 17l-6.2 4.3 2.4-7.4L2 9.4h7.6z"/></svg>
                                        @else
                                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#ccc" stroke-width="2"><path d="M12 2l2.4 7.4H22l-6.2 4.5 2.4 7.4L12 17l-6.2 4.3 2.4-7.4L2 9.4h7.6z"/></svg>
                                        @endif
                                    </span>
                                </div>
                            </div>

                            <div class="eb-tips">
                                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#2D7076" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>
                                <div>
                                    <strong>Tips Editor</strong>
                                    <p>Pastikan judul, ISBN, dan pengarang sesuai data fisik buku sebelum menyimpan perubahan.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- RIGHT: Form --}}
                    <div class="eb-right">

                        {{-- Panel Informasi Buku --}}
                        <div class="eb-panel">
                            <div class="eb-panel-head">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#2D7076" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>
                                <h2 class="eb-panel-title">Informasi Buku</h2>
                            </div>
                            <div class="eb-panel-divider"></div>

                            <div class="eb-form-group">
                                <label for="judul_buku">Judul Buku <span class="eb-req">*</span></label>
                                <input type="text" id="judul_buku" name="judul_buku" value="{{ old('judul_buku', $buku->judul_buku) }}">
                                <span class="eb-err">
                                    @error('judul_buku')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>

                            <div class="eb-form-row">
                                <div class="eb-form-group">
                                    <label for="isbn">ISBN</label>
                                    <input type="text" id="isbn" name="isbn" value="{{ old('isbn', $buku->isbn) }}">
                                    <span class="eb-err">
                                        @error('isbn')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>

                                <div class="eb-form-group">
                                    <label for="tahun_terbit">Tahun Terbit</label>
                                    <input type="number" id="tahun_terbit" name="tahun_terbit" min="1900" max="{{ date('Y') }}" value="{{ old('tahun_terbit', $buku->tahun_terbit) }}">
                                    <span class="eb-err">
                                        @error('tahun_terbit')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>
                            </div>

                            <div class="eb-form-row">
                                <div class="eb-form-group">
                                    <label for="kategori_id">Kategori <span class="eb-req">*</span></label>
                                    <div class="eb-select-wrap">
                                        <select id="kategori_id" name="kategori_id">
                                            <option value="">Pilih Kategori</option>
                                            @foreach ($kategoris as $kategori)
                                                <option value="{{ $kategori->id }}" {{ old('kategori_id', $buku->kategori_id) == $kategori->id ? 'selected' : '' }}>
                                                    {{ $kategori->nama_kategori }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <svg class="eb-select-arrow" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#2D7076" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg>
                                    </div>
                                    <span class="eb-err">
                                        @error('kategori_id')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>

                                <div class="eb-form-group">
                                    <label for="nomor_panggil">Nomor Panggil</label>
                                    <input type="text" id="nomor_panggil" name="nomor_panggil" value="{{ old('nomor_panggil', $buku->nomor_panggil) }}">
                                    <span class="eb-err">
                                        @error('nomor_panggil')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>
                            </div>

                            <div class="eb-form-row">
                                <div class="eb-form-group">
                                    <label for="penulis">Pengarang <span class="eb-req">*</span></label>
                                    <input type="text" id="penulis" name="penulis" value="{{ old('penulis', $buku->penulis) }}">
                                    <span class="eb-err">
                                        @error('penulis')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>

                                <div class="eb-form-group">
                                    <label for="penerbit">Penerbit</label>
                                    <input type="text" id="penerbit" name="penerbit" value="{{ old('penerbit', $buku->penerbit) }}">
                                    <span class="eb-err">
                                        @error('penerbit')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>
                            </div>
                        </div>

                        {{-- Panel Lokasi & Stok --}}
                        <div class="eb-panel">
                            <div class="eb-panel-head">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#2D7076" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                                <h2 class="eb-panel-title">Lokasi &amp; Stok</h2>
                            </div>
                            <div class="eb-panel-divider"></div>

                            <div class="eb-form-row">
                                <div class="eb-form-group">
                                    <label for="rak_id">Rak</label>
                                    <div class="eb-select-wrap">
                                        <select id="rak_id" name="rak_id">
                                            <option value="">Pilih Rak</option>
                                            @foreach ($raks as $rak)
                                                <option value="{{ $rak->id }}" {{ old('rak_id', $buku->rak_id) == $rak->id ? 'selected' : '' }}>
                                                    Rak {{ $rak->kode_rak }}{{ $rak->lokasi ? ' – ' . $rak->lokasi : '' }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <svg class="eb-select-arrow" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#2D7076" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg>
                                    </div>
                                    <span class="eb-err">
                                        @error('rak_id')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>

                                <div class="eb-form-group">
                                    <label for="stok_total">Stok Total <span class="eb-req">*</span></label>
                                    <input type="number" id="stok_total" name="stok_total" value="{{ old('stok_total', $buku->stok_total) }}" min="0">
                                    <span class="eb-err">
                                        @error('stok_total')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>
                            </div>

                            <div class="eb-form-row">
                                <div class="eb-form-group">
                                    <label for="stok_tersedia">Stok Tersedia</label>
                                    <input type="number" id="stok_tersedia" name="stok_tersedia" value="{{ old('stok_tersedia', $buku->stok_tersedia) }}" min="0">
                                    <span class="eb-err">
                                        @error('stok_tersedia')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>
                            </div>
                        </div>

                        {{-- Panel Deskripsi --}}
                        <div class="eb-panel">
                            <div class="eb-panel-head">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#2D7076" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
                                <h2 class="eb-panel-title">Deskripsi</h2>
                            </div>
                            <div class="eb-panel-divider"></div>

                            <div class="eb-form-group">
                                <label for="sinopsis">Sinopsis / Ringkasan</label>
                                <textarea id="sinopsis" name="sinopsis" rows="6">{{ old('sinopsis', $buku->sinopsis) }}</textarea>
                                <span class="eb-err">
                                    @error('sinopsis')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>
                        </div>

                        {{-- Tombol Aksi --}}
                        <div class="eb-actions">
                            <button type="button" class="btn-hapus-buku" id="btnHapusBuku">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                                Hapus Buku
                            </button>

                            <div class="eb-actions-right">
                                <a href="{{ url('/kelola-buku') }}" class="btn-batal-edit">Batal</a>
                                <button type="submit" class="btn-simpan-edit">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                                    Simpan Perubahan
                                </button>
                            </div>
                        </div>

                    </div>
                </div>
            </form>

            <form id="hapusBukuForm" action="{{ url('/buku/' . $buku->id) }}" method="POST" style="display:none;">
                @csrf
                @method('DELETE')
            </form>
        </div>
    </section>

    {{-- MODAL KONFIRMASI HAPUS --}}
    <div class="eb-modal" id="modalHapus">
        <div class="eb-modal-inner">
            <div class="eb-modal-ic ic-red">
                <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="#c0392b" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/><line x1="10" y1="11" x2="10" y2="17"/><line x1="14" y1="11" x2="14" y2="17"/></svg>
            </div>
            <h3 class="eb-modal-title red">Hapus Buku?</h3>
            <p class="eb-modal-desc">Kamu yakin ingin menghapus <strong>{{ $buku->judul_buku }}</strong>? Buku yang sudah punya riwayat transaksi tidak bisa dihapus.</p>
            <div class="eb-modal-btns">
                <button type="button" class="btn-modal-ok ok-red" id="btnKonfirmasiHapus">Ya, Hapus Buku</button>
                <button type="button" class="btn-modal-batal" id="btnBatalHapus">Batal</button>
            </div>
        </div>
    </div>

    {{-- TOAST --}}
    <div class="toast" id="toast"></div>

    {{-- FOOTER --}}
    <footer class="site-footer">
        <div class="footer-inner">
            <div class="footer-brand">
                <div class="footer-brand-top">
                    <img src="{{ asset('assets/logo.png') }}" alt="Logo" class="footer-logo">
                    <span class="footer-brand-name">Al-Uswah Library</span>
                </div>
                <p class="footer-tagline">© 2026 SMAIT Al-Uswah Library.<br>Menumbuhkan Literasi,<br>Mengukir Prestasi.</p>
                <div class="footer-socials">
                    <a href="#" class="social-btn" aria-label="Instagram"><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"/><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/></svg></a>
                    <a href="#" class="social-btn" aria-label="Email"><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,12 2,6"/></svg></a>
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
                <h4 class="footer-col-title">Dukungan</h4>
                <ul>
                    <li><a href="#">Panduan Perpustakaan</a></li>
                    <li><a href="#">Peraturan Anggota</a></li>
                </ul>
            </div>

            <div class="footer-col">
                <h4 class="footer-col-title">Kontak Kami</h4>
                <address>library@smait-aluswah.sch.id<br>Surabaya, Jawa Timur</address>
            </div>
        </div>

        <div class="footer-bottom">
            <p>© 2026 Perpustakaan SMAIT Al-Uswah. Menjaga Tradisi, Membangun Literasi.</p>
        </div>
    </footer>

    {{-- Script lama dummy sengaja tidak dipakai dulu --}}
    {{-- <script src="{{ asset('js/script-edit-buku.js') }}"></script> --}}

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const coverWrap = document.getElementById('ebCoverWrap');
            const coverInput = document.getElementById('ebCoverInput');
            const coverImg = document.getElementById('ebCoverImg');
            const btnGantiSampul = document.getElementById('btnGantiSampul');

            const btnHapusBuku = document.getElementById('btnHapusBuku');
            const modalHapus = document.getElementById('modalHapus');
            const btnKonfirmasiHapus = document.getElementById('btnKonfirmasiHapus');
            const btnBatalHapus = document.getElementById('btnBatalHapus');
            const hapusBukuForm = document.getElementById('hapusBukuForm');

            const toast = document.getElementById('toast');
            const toastMessage = @json(session('success') ?? session('error') ?? ($errors->any() ? 'Periksa kembali data buku yang diisi.' : null));

            if (toast && toastMessage) {
                toast.textContent = toastMessage;
                toast.classList.add('show');

                setTimeout(function () {
                    toast.classList.remove('show');
                }, 3000);
            }

            function openFilePicker() {
                if (coverInput) {
                    coverInput.click();
                }
            }

            if (coverWrap) {
                coverWrap.addEventListener('click', openFilePicker);
            }

            if (btnGantiSampul) {
                btnGantiSampul.addEventListener('click', openFilePicker);
            }

            if (coverInput) {
                coverInput.addEventListener('change', function () {
                    const file = coverInput.files[0];

                    if (!file) {
                        return;
                    }

                    const allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];

                    if (!allowedTypes.includes(file.type)) {
                        alert('Format cover harus JPG, PNG, atau WEBP.');
                        coverInput.value = '';
                        return;
                    }

                    if (file.size > 2 * 1024 * 1024) {
                        alert('Ukuran cover maksimal 2MB.');
                        coverInput.value = '';
                        return;
                    }

                    const reader = new FileReader();

                    reader.onload = function (event) {
                        coverImg.src = event.target.result;
                    };

                    reader.readAsDataURL(file);
                });
            }

            if (btnHapusBuku && modalHapus) {
                btnHapusBuku.addEventListener('click', function () {
                    modalHapus.classList.add('show');
                });
            }

            if (btnBatalHapus && modalHapus) {
                btnBatalHapus.addEventListener('click', function () {
                    modalHapus.classList.remove('show');
                });
            }

            if (btnKonfirmasiHapus && hapusBukuForm) {
                btnKonfirmasiHapus.addEventListener('click', function () {
                    hapusBukuForm.submit();
                });
            }

            if (modalHapus) {
                modalHapus.addEventListener('click', function (event) {
                    if (event.target === modalHapus) {
                        modalHapus.classList.remove('show');
                    }
                });
            }
        });
    </script>
</body>
</html>