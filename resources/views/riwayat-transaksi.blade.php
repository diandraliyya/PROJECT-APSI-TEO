@php
    $adminName = session('auth_name') ?? 'Admin';

    $search = $search ?? request('search');
    $status = $status ?? request('status');

    $avatarClasses = ['av-teal', 'av-orange', 'av-purple', 'av-mint'];

    $initials = function ($nama) {
        $nama = trim($nama ?: 'A');
        $parts = preg_split('/\s+/', $nama);

        $first = strtoupper(substr($parts[0] ?? 'A', 0, 1));
        $second = strtoupper(substr($parts[1] ?? '', 0, 1));

        return $first . $second;
    };

    $formatTanggal = function ($tanggal) {
        if (!$tanggal) {
            return '-';
        }

        return \Illuminate\Support\Carbon::parse($tanggal)->translatedFormat('d M Y');
    };

    $statusLabel = [
        'dipinjam' => 'Dipinjam',
        'terlambat' => 'Terlambat',
        'dikembalikan' => 'Dikembalikan',
    ];

    $statusClass = [
        'dipinjam' => 'st-dipinjam',
        'terlambat' => 'st-terlambat',
        'dikembalikan' => 'st-dikembalikan',
    ];
@endphp

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Transaksi – Perpustakaan SMAIT Al-Uswah</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style-home.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style-home-anggota.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style-home-admin.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style-riwayat-transaksi.css') }}">
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
    <section class="rt-hero">
        <div class="rt-hero-inner">
            <div class="rt-hero-left">
                <div class="rt-hero-icons">
                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#2D7076" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#b8742f" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>
                </div>
                <h1 class="rt-title">Riwayat Transaksi</h1>
                <p class="rt-desc">Pantau dan kelola seluruh alur sirkulasi buku perpustakaan secara terorganisir dan efisien.</p>
            </div>

            <a href="{{ url('/input-peminjaman') }}" class="btn-input-pinjam">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                Input Peminjaman Baru
            </a>
        </div>
    </section>

    {{-- ===== FILTER ===== --}}
    <section class="rt-filter-section">
        <div class="rt-filter-inner">
            <form action="{{ url('/riwayat-transaksi') }}" method="GET" class="rt-filter-bar">

                <div class="rt-filter-field">
                    <label>Cari Transaksi / Anggota</label>
                    <div class="rt-search-wrap rt-search-has-ic">
                        <input type="text" name="search" value="{{ $search }}" class="rt-search" placeholder="Kode transaksi, nama, NIS, atau no anggota...">
                        <svg class="rt-search-ic" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#2D7076" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                    </div>
                </div>

                <div class="rt-filter-field">
                    <label>Status Transaksi</label>
                    <div class="rt-select-wrap">
                        <select name="status" class="rt-select" onchange="this.form.submit()">
                            <option value="">Semua Status</option>
                            <option value="dipinjam" {{ $status === 'dipinjam' ? 'selected' : '' }}>Dipinjam</option>
                            <option value="terlambat" {{ $status === 'terlambat' ? 'selected' : '' }}>Terlambat</option>
                            <option value="dikembalikan" {{ $status === 'dikembalikan' ? 'selected' : '' }}>Dikembalikan</option>
                        </select>
                        <svg class="rt-select-arrow" xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#2D7076" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg>
                    </div>
                </div>

                <div class="rt-filter-field" style="justify-content:flex-end;">
                    <label>&nbsp;</label>
                    <button type="submit" class="btn-input-pinjam" style="border:none; cursor:pointer;">
                        Cari
                    </button>
                </div>

                @if ($search || $status)
                    <div class="rt-filter-field" style="justify-content:flex-end;">
                        <label>&nbsp;</label>
                        <a href="{{ url('/riwayat-transaksi') }}" class="btn-input-pinjam" style="background:#f5f5f5; color:#2D7076;">
                            Reset
                        </a>
                    </div>
                @endif

            </form>
        </div>
    </section>

    {{-- ===== TABEL ===== --}}
    <section class="rt-table-section">
        <div class="rt-table-inner">
            <div class="rt-table-card">

                @if (session('success'))
                    <div style="background:#f0fff4; border:1px solid #a7e3b5; color:#24733b; padding:14px 18px; border-radius:14px; margin-bottom:18px;">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div style="background:#fff3f3; border:1px solid #f3b5b5; color:#9f2f2f; padding:14px 18px; border-radius:14px; margin-bottom:18px;">
                        {{ session('error') }}
                    </div>
                @endif

                <div class="rt-table-wrap">
                    <table class="rt-table">
                        <thead>
                            <tr>
                                <th>ID Transaksi</th>
                                <th>Nama Anggota</th>
                                <th>Jumlah Buku</th>
                                <th>Tanggal Pinjam</th>
                                <th>Jatuh Tempo</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($transaksis as $transaksi)
                                @php
                                    $anggota = $transaksi->anggota;
                                    $namaAnggota = optional($anggota)->nama_anggota ?? 'Anggota Tidak Ditemukan';
                                    $kelasAnggota = optional($anggota)->kelas ?? '-';
                                    $inisial = $initials($namaAnggota);
                                    $avatarClass = $avatarClasses[$loop->index % count($avatarClasses)];

                                    $statusTransaksi = $transaksi->status_transaksi ?? 'dipinjam';
                                    $labelStatus = $statusLabel[$statusTransaksi] ?? ucfirst(str_replace('_', ' ', $statusTransaksi));
                                    $classStatus = $statusClass[$statusTransaksi] ?? 'st-dipinjam';

                                    $jumlahBuku = $transaksi->total_item ?: $transaksi->detailTransaksis->sum('jumlah');

                                    $judulBuku = $transaksi->detailTransaksis
                                        ->map(fn ($detail) => optional($detail->buku)->judul_buku)
                                        ->filter()
                                        ->implode(', ');
                                @endphp

                                <tr class="rt-row"
                                    data-id="{{ $transaksi->kode_transaksi }}"
                                    data-nama="{{ strtolower($namaAnggota) }}"
                                    data-kelas="{{ $kelasAnggota }}"
                                    data-buku="{{ strtolower($judulBuku) }}"
                                    data-status="{{ $statusTransaksi }}"
                                    data-tgl-pinjam="{{ $transaksi->tanggal_pinjam }}"
                                    data-tgl-tempo="{{ $transaksi->tanggal_jatuh_tempo }}"
                                    data-trx-id="{{ $transaksi->id }}">
                                    <td class="rt-id">#{{ $transaksi->kode_transaksi }}</td>

                                    <td>
                                        <div class="rt-anggota">
                                            <div class="rt-avatar {{ $avatarClass }}">{{ $inisial }}</div>
                                            <div>
                                                <span class="rt-anggota-nama">{{ $namaAnggota }}</span>
                                                <span class="rt-anggota-kelas">{{ $kelasAnggota }}</span>
                                            </div>
                                        </div>
                                    </td>

                                    <td>{{ $jumlahBuku }} Buku</td>

                                    <td>{{ $formatTanggal($transaksi->tanggal_pinjam) }}</td>

                                    <td class="{{ $statusTransaksi === 'terlambat' ? 'rt-tgl-terlambat' : '' }}">
                                        {{ $formatTanggal($transaksi->tanggal_jatuh_tempo) }}
                                    </td>

                                    <td>
                                        <span class="rt-status {{ $classStatus }}">{{ $labelStatus }}</span>
                                    </td>

                                    <td>
                                        <a href="{{ url('/detail-transaksi/' . $transaksi->id) }}" class="btn-rt-detail" title="Lihat Detail">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" style="text-align:center; padding:32px;">
                                        Tidak ada transaksi yang cocok.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="rt-empty" id="rtEmpty" style="{{ $transaksis->count() > 0 ? 'display:none;' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="#2D7076" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                    <p>Tidak ada transaksi yang cocok.</p>
                </div>

                <div class="rt-table-footer">
                    <span class="rt-info">
                        @if ($transaksis->total() > 0)
                            Menampilkan {{ $transaksis->firstItem() }}–{{ $transaksis->lastItem() }} dari {{ $transaksis->total() }} transaksi
                        @else
                            Menampilkan 0 transaksi
                        @endif
                    </span>

                    <div class="rt-pagination">
                        @if ($transaksis->onFirstPage())
                            <button class="rt-page-btn" disabled>
                                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
                            </button>
                        @else
                            <a href="{{ $transaksis->previousPageUrl() }}" class="rt-page-btn">
                                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
                            </a>
                        @endif

                        @for ($i = 1; $i <= $transaksis->lastPage(); $i++)
                            @if ($i === $transaksis->currentPage())
                                <button class="rt-page-btn active">{{ $i }}</button>
                            @else
                                <a href="{{ $transaksis->url($i) }}" class="rt-page-btn">{{ $i }}</a>
                            @endif
                        @endfor

                        @if ($transaksis->hasMorePages())
                            <a href="{{ $transaksis->nextPageUrl() }}" class="rt-page-btn">
                                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
                            </a>
                        @else
                            <button class="rt-page-btn" disabled>
                                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
                            </button>
                        @endif
                    </div>
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
                <h4 class="footer-col-title">Navigasi</h4>
                <ul>
                    <li><a href="{{ url('/dashboard-admin') }}">Dashboard</a></li>
                    <li><a href="{{ url('/kelola-buku') }}">Kelola Buku</a></li>
                    <li><a href="{{ url('/kelola-anggota') }}">Kelola Anggota</a></li>
                </ul>
            </div>

            <div class="footer-col">
                <h4 class="footer-col-title">Dukungan</h4>
                <ul>
                    <li><a href="#">SOP Peminjaman</a></li>
                    <li><a href="#">Pusat Bantuan</a></li>
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

    {{-- Script lama dummy dimatikan dulu --}}
    {{-- <script src="{{ asset('js/script-riwayat-transaksi.js') }}"></script> --}}

</body>
</html>