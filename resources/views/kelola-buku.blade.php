@php
    $adminName = session('auth_name') ?? 'Admin';

    $search = $search ?? request('search');
    $kategori = $kategori ?? request('kategori');
    $status = $status ?? request('status');

    $statusLabel = [
        'tersedia' => 'Tersedia',
        'stok_sedikit' => 'Stok Sedikit',
        'tidak_tersedia' => 'Tidak Tersedia',
    ];

    $statusClass = [
        'tersedia' => 'st-tersedia',
        'stok_sedikit' => 'st-sedikit',
        'tidak_tersedia' => 'st-habis',
    ];

    $stokClass = function ($stok) {
        if ($stok <= 0) {
            return 'stok-habis';
        }

        if ($stok <= 2) {
            return 'stok-sedikit';
        }

        return '';
    };

    $kategoriClass = function ($namaKategori) {
        $nama = strtolower($namaKategori ?? 'lainnya');
        $nama = str_replace(' ', '-', $nama);

        return 'kat-' . $nama;
    };

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
@endphp

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengelolaan Buku – Perpustakaan SMAIT Al-Uswah</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style-home.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style-home-anggota.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style-home-admin.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style-kelola-buku.css') }}">
</head>
<body class="admin-page">

    {{-- ===== NAVBAR ADMIN ===== --}}
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
    <section class="kb-hero">
        <div class="kb-hero-inner">
            <div class="kb-hero-left">
                <span class="kb-eyebrow">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="#b8742f" stroke="none"><path d="M12 2l1.5 5.5L19 9l-5.5 1.5L12 16l-1.5-5.5L5 9l5.5-1.5z"/></svg>
                    ADMIN DASHBOARD
                </span>
                <h1 class="kb-title">Pengelolaan Buku</h1>
                <p class="kb-desc">Kelola dan awasi koleksi literasimu dengan penuh ketelitian.</p>
            </div>

            <div class="kb-hero-right">
                <div class="kb-hero-deco">
                    <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" viewBox="0 0 24 24" fill="none" stroke="rgba(45,112,118,.15)" stroke-width="1" stroke-linecap="round" stroke-linejoin="round"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>
                </div>

                <a href="{{ url('/tambah-buku') }}" class="btn-tambah-buku">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                    Tambah Buku Baru
                </a>
            </div>
        </div>
    </section>

    {{-- ===== FILTER ===== --}}
    <section class="kb-filter-section">
        <div class="kb-filter-inner">
            <form action="{{ url('/kelola-buku') }}" method="GET" class="kb-filter-bar">
                <div class="kb-search-wrap">
                    <svg class="kb-search-ic" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#2D7076" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                    <input type="text" id="searchInput" name="search" class="kb-search" placeholder="Cari judul, ISBN, atau penulis..." value="{{ $search }}">
                </div>

                <div class="kb-select-wrap">
                    <select id="kategoriSelect" name="kategori" class="kb-select" onchange="this.form.submit()">
                        <option value="">Semua Kategori</option>
                        @foreach ($kategoris as $itemKategori)
                            <option value="{{ $itemKategori->id }}" {{ (string) $kategori === (string) $itemKategori->id ? 'selected' : '' }}>
                                {{ $itemKategori->nama_kategori }}
                            </option>
                        @endforeach
                    </select>
                    <svg class="kb-select-arrow" xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#2D7076" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg>
                </div>

                <div class="kb-select-wrap">
                    <select id="statusSelect" name="status" class="kb-select" onchange="this.form.submit()">
                        <option value="">Semua Status</option>
                        <option value="tersedia" {{ $status === 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                        <option value="stok_sedikit" {{ $status === 'stok_sedikit' ? 'selected' : '' }}>Stok Sedikit</option>
                        <option value="tidak_tersedia" {{ $status === 'tidak_tersedia' ? 'selected' : '' }}>Tidak Tersedia</option>
                    </select>
                    <svg class="kb-select-arrow" xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#2D7076" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg>
                </div>
            </form>
        </div>
    </section>

    {{-- ===== TABEL BUKU ===== --}}
    <section class="kb-table-section">
        <div class="kb-table-inner">
            <div class="kb-table-card">
                <table class="kb-table">
                    <thead>
                        <tr>
                            <th>Cover</th>
                            <th>Info Buku</th>
                            <th>ISBN</th>
                            <th>Kategori</th>
                            <th>Stok</th>
                            <th>Rak</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody id="bukuTbody">
                        @forelse ($bukus as $buku)
                            @php
                                $namaKategori = optional($buku->kategori)->nama_kategori ?? 'Tanpa Kategori';
                                $kodeRak = optional($buku->rak)->kode_rak ?? '-';
                                $statusBuku = $buku->status_buku ?? 'tidak_tersedia';
                                $labelStatus = $statusLabel[$statusBuku] ?? ucfirst(str_replace('_', ' ', $statusBuku));
                                $classStatus = $statusClass[$statusBuku] ?? 'st-habis';

                                $dataStatus = match ($statusBuku) {
                                    'tersedia' => 'tersedia',
                                    'stok_sedikit' => 'sedikit',
                                    'tidak_tersedia' => 'habis',
                                    default => $statusBuku,
                                };
                            @endphp

                            <tr class="kb-row"
                                data-id="{{ $buku->id }}"
                                data-judul="{{ strtolower($buku->judul_buku) }}"
                                data-penulis="{{ strtolower($buku->penulis) }}"
                                data-isbn="{{ strtolower($buku->isbn ?? '') }}"
                                data-kategori="{{ strtolower($namaKategori) }}"
                                data-stok="{{ $buku->stok_tersedia }}"
                                data-status="{{ $dataStatus }}">

                                <td>
                                    <img src="{{ $coverUrl($buku) }}" alt="Cover {{ $buku->judul_buku }}" class="kb-cover">
                                </td>

                                <td>
                                    <span class="kb-judul">{{ $buku->judul_buku }}</span>
                                    <span class="kb-penulis">{{ $buku->penulis }}</span>
                                </td>

                                <td class="kb-isbn">{{ $buku->isbn ?? '-' }}</td>

                                <td>
                                    <span class="kb-kat {{ $kategoriClass($namaKategori) }}">
                                        {{ strtoupper($namaKategori) }}
                                    </span>
                                </td>

                                <td class="kb-stok {{ $stokClass($buku->stok_tersedia) }}">
                                    {{ $buku->stok_tersedia }}
                                </td>

                                <td class="kb-rak">{{ $kodeRak }}</td>

                                <td>
                                    <span class="kb-status {{ $classStatus }}">
                                        <span class="st-dot"></span> {{ $labelStatus }}
                                    </span>
                                </td>

                                <td>
                                    <div class="kb-aksi">
                                        <a href="{{ url('/informasi-buku-admin/' . $buku->id) }}" class="kb-btn-aksi btn-lihat" title="Lihat Detail">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                        </a>

                                        <a href="{{ url('/edit-buku/' . $buku->id) }}" class="kb-btn-aksi btn-edit" title="Edit Buku">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                        </a>

                                        <form action="{{ url('/buku/' . $buku->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit"
                                                class="kb-btn-aksi btn-hapus"
                                                data-id="{{ $buku->id }}"
                                                data-judul="{{ $buku->judul_buku }}"
                                                title="Hapus Buku"
                                                onclick="event.stopImmediatePropagation(); return confirm('Hapus buku {{ addslashes($buku->judul_buku) }}?');">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr class="kb-row">
                                <td colspan="8" style="text-align:center; padding: 32px;">
                                    Tidak ada buku yang cocok dengan filter ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="kb-empty {{ $bukus->count() > 0 ? 'hidden' : '' }}" id="kbEmpty">
                    <svg xmlns="http://www.w3.org/2000/svg" width="44" height="44" viewBox="0 0 24 24" fill="none" stroke="#2D7076" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>
                    <p>Tidak ada buku yang cocok dengan filter ini.</p>
                </div>

                <div class="kb-table-footer">
                    <span class="kb-info" id="kbInfo">
                        @if ($bukus->total() > 0)
                            Menampilkan {{ $bukus->firstItem() }}–{{ $bukus->lastItem() }} dari {{ $bukus->total() }} buku
                        @else
                            Menampilkan 0 buku
                        @endif
                    </span>

                    <div class="kb-pagination">
                        @if ($bukus->onFirstPage())
                            <button class="kb-page-btn" disabled>Sebelumnya</button>
                        @else
                            <a href="{{ $bukus->previousPageUrl() }}" class="kb-page-btn">Sebelumnya</a>
                        @endif

                        @for ($i = 1; $i <= $bukus->lastPage(); $i++)
                            @if ($i === $bukus->currentPage())
                                <button class="kb-page-btn active" data-page="{{ $i }}">{{ $i }}</button>
                            @else
                                <a href="{{ $bukus->url($i) }}" class="kb-page-btn" data-page="{{ $i }}">{{ $i }}</a>
                            @endif
                        @endfor

                        @if ($bukus->hasMorePages())
                            <a href="{{ $bukus->nextPageUrl() }}" class="kb-page-btn">Berikutnya</a>
                        @else
                            <button class="kb-page-btn" disabled>Berikutnya</button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ===== MANAJEMEN KATEGORI & RAK ===== --}}
    <section class="kb-manajemen-section">
        <div class="kb-manajemen-inner">
            <h2 class="kb-manajemen-title">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#2D7076" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/></svg>
                Manajemen Koleksi
            </h2>

            <p class="kb-manajemen-sub">Atur kategori dan lokasi rak untuk memudahkan pengelolaan koleksi perpustakaan.</p>

            <div class="kb-manajemen-cards">
                <a href="{{ url('/kategori-rak') }}" class="kb-mana-card">
                    <div class="kb-mana-ic ic-teal">
                        <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="8" y1="6" x2="21" y2="6"/><line x1="8" y1="12" x2="21" y2="12"/><line x1="8" y1="18" x2="21" y2="18"/><line x1="3" y1="6" x2="3.01" y2="6"/><line x1="3" y1="12" x2="3.01" y2="12"/><line x1="3" y1="18" x2="3.01" y2="18"/></svg>
                    </div>

                    <div class="kb-mana-info">
                        <span class="kb-mana-label">Manajemen Kategori</span>
                        <span class="kb-mana-desc">Tambah, edit, dan atur kategori buku</span>
                    </div>

                    <svg class="kb-mana-arrow" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#2D7076" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
                </a>

                <a href="{{ url('/kategori-rak') }}" class="kb-mana-card">
                    <div class="kb-mana-ic ic-orange">
                        <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="3" width="20" height="5" rx="1"/><rect x="2" y="10" width="20" height="5" rx="1"/><rect x="2" y="17" width="20" height="5" rx="1"/></svg>
                    </div>

                    <div class="kb-mana-info">
                        <span class="kb-mana-label">Manajemen Rak</span>
                        <span class="kb-mana-desc">Atur posisi dan kode rak koleksi</span>
                    </div>

                    <svg class="kb-mana-arrow" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#b8742f" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
                </a>
            </div>
        </div>
    </section>

    {{-- ===== MODAL KONFIRMASI HAPUS ===== --}}
    <div class="hapus-modal" id="hapusModal">
        <div class="hapus-modal-inner">
            <div class="hapus-modal-ic">
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#c0392b" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/><line x1="10" y1="11" x2="10" y2="17"/><line x1="14" y1="11" x2="14" y2="17"/></svg>
            </div>

            <h3 class="hapus-modal-title">Hapus Buku?</h3>
            <p class="hapus-modal-desc">Kamu yakin ingin menghapus buku <strong id="hapusJudul">"Buku"</strong>? Tindakan ini tidak bisa dibatalkan.</p>

            <div class="hapus-modal-btns">
                <button class="btn-hapus-konfirm" id="btnHapusKonfirm">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                    Ya, Hapus
                </button>
                <button class="btn-hapus-batal" id="btnHapusBatal">Batal</button>
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

                <p class="footer-tagline">© 2026 SMAIT Al-Uswah Library.<br>Menumbuhkan Literasi, Mengukir Prestasi.</p>

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
                    <li><a href="{{ url('/dashboard-admin') }}">Dashboard</a></li>
                    <li><a href="{{ url('/tambah-buku') }}">Tambah Buku</a></li>
                    <li><a href="{{ url('/kategori-rak') }}">Kategori &amp; Rak</a></li>
                </ul>
            </div>

            <div class="footer-col">
                <h4 class="footer-col-title">Dukungan</h4>
                <ul>
                    <li><a href="#">Pusat Bantuan</a></li>
                    <li><a href="#">SOP Peminjaman</a></li>
                </ul>
            </div>

            <div class="footer-col">
                <h4 class="footer-col-title">Hubungi Kami</h4>
                <address>
                    Jl. Al-Uswah No. 123, Surabaya<br>
                    library@smait-aluswah.sch.id
                </address>
            </div>
        </div>

        <div class="footer-bottom">
            <p>© 2026 Perpustakaan SMAIT Al-Uswah. Menjaga Tradisi, Membangun Literasi.</p>
        </div>
    </footer>

    <!-- <script src="{{ asset('js/script-kelola-buku.js') }}"></script> -->

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

            const searchInput = document.getElementById('searchInput');

            if (searchInput) {
                searchInput.addEventListener('keydown', function (event) {
                    if (event.key === 'Enter') {
                        event.preventDefault();
                        this.closest('form').submit();
                    }
                });
            }
        });
    </script>
</body>
</html>