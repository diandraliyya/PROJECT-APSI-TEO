@php
    $adminName = session('auth_name') ?? 'Admin';

    $totalBuku = $totalBuku ?? 0;
    $totalStokTersedia = $totalStokTersedia ?? 0;
    $totalAnggotaAktif = $totalAnggotaAktif ?? 0;
    $totalPendaftaranMenunggu = $totalPendaftaranMenunggu ?? 0;
    $totalPinjamHariIni = $totalPinjamHariIni ?? 0;
    $totalDipinjam = $totalDipinjam ?? 0;
    $totalTerlambat = $totalTerlambat ?? 0;
    $totalBukuSedangDipinjam = $totalBukuSedangDipinjam ?? 0;
    $totalDendaBelumLunas = $totalDendaBelumLunas ?? 0;

    $trenPeminjaman = collect($trenPeminjaman ?? []);
    $kategoriDistribusi = collect($kategoriDistribusi ?? []);
    $bukuTerpopuler = collect($bukuTerpopuler ?? []);
    $semuaBukuTerpopuler = collect($semuaBukuTerpopuler ?? $bukuTerpopuler);
    $anggotaTeraktif = collect($anggotaTeraktif ?? []);
    $dendaAktif = collect($dendaAktif ?? []);

    $maxTrenPeminjaman = $maxTrenPeminjaman ?? 1;
    $maxTotalPinjamBuku = $maxTotalPinjamBuku ?? 1;

    $kategoriPertama = $kategoriDistribusi->get(0);
    $kategoriKedua = $kategoriDistribusi->get(1);

    $persenKategoriPertama = $kategoriPertama->persentase ?? 0;
    $persenKategoriKedua = $kategoriKedua->persentase ?? 0;
@endphp

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin – Perpustakaan SMAIT Al-Uswah</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style-home.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style-home-anggota.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style-home-admin.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style-dashboard-admin.css') }}">
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

    {{-- ===== HERO BANNER ===== --}}
    <section class="admin-hero">
        <div class="admin-hero-inner">
            <div class="admin-hero-banner">
                <div class="admin-hero-text">
                    <span class="admin-hero-eyebrow">semangat bertugas!</span>
                    <h1 class="admin-hero-title">Dashboard Admin<br>Perpustakaan</h1>
                    <p class="admin-hero-desc">
                        Selamat datang kembali di panel literasi digital. Kelola koleksi buku, pantau aktivitas peminjaman, dan pastikan setiap ilmu tersampaikan dengan baik.
                    </p>
                    <div class="admin-hero-actions">
                        <a href="{{ url('/tambah-buku') }}" class="btn-hero-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2"/><line x1="12" y1="8" x2="12" y2="16"/><line x1="8" y1="12" x2="16" y2="12"/></svg>
                            Tambah Buku Baru
                        </a>
                        <a href="{{ url('/laporan') }}" class="btn-hero-secondary">Lihat Laporan</a>
                    </div>
                </div>
                <div class="admin-hero-img">
                    <img src="{{ asset('assets/icon buku.png') }}" alt="Ilustrasi" class="admin-hero-illustration">
                </div>
            </div>
        </div>
    </section>

    {{-- ===== STAT CARDS ===== --}}
    <section class="admin-stats">
        <div class="admin-stats-inner">

            <div class="admin-stat-card stat-peach">
                <div class="admin-stat-ic">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#2D7076" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>
                </div>
                <span class="admin-stat-label">TOTAL PINJAM HARI INI</span>
                <span class="admin-stat-value">{{ $totalPinjamHariIni }}</span>
                <span class="admin-stat-trend trend-up">
                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/><polyline points="17 6 23 6 23 12"/></svg>
                    Data hari ini
                </span>
            </div>

            <div class="admin-stat-card stat-mint">
                <div class="admin-stat-ic">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#2D7076" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>
                </div>
                <span class="admin-stat-label">BUKU SEDANG DIPINJAM</span>
                <span class="admin-stat-value">{{ $totalBukuSedangDipinjam }}</span>
                <span class="admin-stat-trend">Update otomatis sistem</span>
            </div>

            <div class="admin-stat-card stat-peach">
                <div class="admin-stat-ic">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#c0392b" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/></svg>
                </div>
                <span class="admin-stat-label">KETERLAMBATAN AKTIF</span>
                <span class="admin-stat-value">{{ $totalTerlambat }}</span>
                <span class="admin-stat-trend trend-alert">! Perlu segera ditindak</span>
            </div>

            <div class="admin-stat-card stat-mint">
                <div class="admin-stat-ic">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#2D7076" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="5" width="20" height="14" rx="2"/><line x1="2" y1="10" x2="22" y2="10"/></svg>
                </div>
                <span class="admin-stat-label">DENDA TERKUMPUL</span>
                <span class="admin-stat-value">Rp {{ number_format($totalDendaTerkumpul ?? 0, 0, ',', '.') }}</span>
                <span class="admin-stat-trend">Total denda yang sudah dibayar</span>
            </div>

        </div>
    </section>

    {{-- ===== CHARTS ROW ===== --}}
    <section class="admin-charts">
        <div class="admin-charts-inner">

            {{-- Tren Peminjaman --}}
            <div class="admin-panel">
                <div class="panel-head">
                    <div>
                        <h2 class="panel-title">Tren Peminjaman Buku</h2>
                        <p class="panel-sub">Statistik 6 bulan terakhir</p>
                    </div>
                    <div class="year-dropdown">
                        <button type="button" class="panel-badge" id="yearBtn">
                            <span id="yearLabel">Tahun {{ now()->year }}</span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg>
                        </button>
                        <div class="year-menu" id="yearMenu">
                            <button type="button" class="year-opt active" data-year="{{ now()->year }}">Tahun {{ now()->year }}</button>
                            <button type="button" class="year-opt" data-year="{{ now()->subYear()->year }}">Tahun {{ now()->subYear()->year }}</button>
                            <button type="button" class="year-opt" data-year="{{ now()->subYears(2)->year }}">Tahun {{ now()->subYears(2)->year }}</button>
                        </div>
                    </div>
                </div>

                <div class="trend-chart">
                    @forelse ($trenPeminjaman as $tren)
                        @php
                            $tinggiBar = $maxTrenPeminjaman > 0
                                ? max(8, round(($tren['total'] / $maxTrenPeminjaman) * 100))
                                : 8;
                        @endphp

                        <div class="trend-bar-col">
                            <div class="trend-bar {{ $loop->last ? 'trend-bar-active' : '' }}" style="--h: {{ $tinggiBar }}%;"></div>
                            <span class="{{ $loop->last ? 'active-month' : '' }}">{{ $tren['bulan'] }}</span>
                        </div>
                    @empty
                        <div class="trend-bar-col"><div class="trend-bar" style="--h: 8%;"></div><span>-</span></div>
                    @endforelse
                </div>
            </div>

            {{-- Distribusi Kategori --}}
            <div class="admin-panel">
                <h2 class="panel-title">Distribusi Kategori</h2>
                <div class="donut-wrap">
                    <div class="donut" style="--fiksi: {{ $persenKategoriPertama }}; --sains: {{ $persenKategoriKedua }};">
                        <div class="donut-center">
                            <span class="donut-total">{{ number_format($totalBuku, 0, ',', '.') }}</span>
                            <span class="donut-label">Total Koleksi</span>
                        </div>
                    </div>
                </div>
                <ul class="donut-legend">
                    @forelse ($kategoriDistribusi as $kategori)
                        @php
                            $dotClass = ['dot-fiksi', 'dot-sains', 'dot-lain'][$loop->index] ?? 'dot-lain';
                        @endphp

                        <li>
                            <span class="legend-dot {{ $dotClass }}"></span>
                            <span class="legend-name">{{ $kategori->nama_kategori ?? '-' }}</span>
                            <span class="legend-pct">{{ $kategori->persentase ?? 0 }}%</span>
                        </li>
                    @empty
                        <li>
                            <span class="legend-dot dot-lain"></span>
                            <span class="legend-name">Belum ada kategori</span>
                            <span class="legend-pct">0%</span>
                        </li>
                    @endforelse
                </ul>
            </div>

        </div>
    </section>

    {{-- ===== POPULER & ANGGOTA ===== --}}
    <section class="admin-lists">
        <div class="admin-lists-inner">

            {{-- Buku Populer --}}
            <div class="admin-panel">
                <div class="panel-head">
                    <h2 class="panel-title">Buku Populer</h2>
                    <button type="button" class="panel-link" id="btnLihatPopuler">Lihat Semua</button>
                </div>

                <div class="popular-list">
                    @forelse ($bukuTerpopuler as $item)
                        @php
                            $judulBuku = optional($item->buku)->judul_buku ?? 'Judul buku tidak tersedia';
                            $penulisBuku = optional($item->buku)->penulis;
                            $totalDipinjamBuku = $item->total_dipinjam ?? 0;
                            $lebarBar = $maxTotalPinjamBuku > 0
                                ? min(100, round(($totalDipinjamBuku / $maxTotalPinjamBuku) * 100))
                                : 0;
                        @endphp

                        <div class="popular-item">
                            <div class="popular-info">
                                <span class="popular-judul">
                                    {{ $judulBuku }}{{ $penulisBuku ? ' - ' . $penulisBuku : '' }}
                                </span>
                                <span class="popular-count">{{ $totalDipinjamBuku }} Pinjam</span>
                            </div>
                            <div class="popular-bar"><div class="popular-bar-fill" style="width: {{ $lebarBar }}%;"></div></div>
                        </div>
                    @empty
                        <div class="popular-item">
                            <div class="popular-info">
                                <span class="popular-judul">Belum ada data buku populer</span>
                                <span class="popular-count">0 Pinjam</span>
                            </div>
                            <div class="popular-bar"><div class="popular-bar-fill" style="width: 0%;"></div></div>
                        </div>
                    @endforelse
                </div>
            </div>

            {{-- Anggota Teraktif --}}
            <div class="admin-panel">
                <h2 class="panel-title">Anggota Teraktif</h2>
                <div class="active-members">
                    @forelse ($anggotaTeraktif as $anggota)
                        @php
                            $namaAnggota = $anggota->nama_anggota ?? $anggota->username ?? 'Anggota';
                            $kataNama = explode(' ', trim($namaAnggota));
                            $inisial = strtoupper(substr($kataNama[0] ?? 'A', 0, 1) . substr($kataNama[1] ?? '', 0, 1));
                            $totalPinjamAnggota = $anggota->total_pinjam ?? 0;
                        @endphp

                        <div class="member-item">
                            <div class="member-avatar">{{ $inisial }}</div>
                            <div class="member-info">
                                <span class="member-name">{{ $namaAnggota }}</span>
                                <span class="member-class">Anggota Perpustakaan</span>
                            </div>
                            <div class="member-pts">
                                <span class="pts-value">{{ $totalPinjamAnggota }} Pts</span>
                                @if ($loop->first)
                                    <span class="pts-badge">Top Reader</span>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="member-item">
                            <div class="member-avatar">A</div>
                            <div class="member-info">
                                <span class="member-name">Belum ada data anggota aktif</span>
                                <span class="member-class">Data akan muncul setelah ada transaksi</span>
                            </div>
                            <div class="member-pts">
                                <span class="pts-value">0 Pts</span>
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>

        </div>
    </section>

    {{-- ===== STATUS DENDA AKTIF ===== --}}
    <section class="admin-denda">
        <div class="admin-denda-inner">
            <div class="admin-panel">
                <div class="panel-head denda-head">
                    <h2 class="panel-title">Status Denda Aktif</h2>
                    <div class="denda-search-wrap">
                        <input type="text" id="dendaSearch" class="denda-search" placeholder="Cari nama anggota...">
                        <button class="denda-search-btn" aria-label="Cari">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                        </button>
                    </div>
                </div>

                <div class="denda-table-wrap">
                    <table class="denda-table">
                        <thead>
                            <tr>
                                <th>NAMA ANGGOTA</th>
                                <th>JUDUL BUKU</th>
                                <th>TERLAMBAT</th>
                                <th>TOTAL DENDA</th>
                                <th>STATUS</th>
                                <th>AKSI</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($dendaAktif as $denda)
                                @php
                                    $namaAnggota = optional($denda->anggota)->nama_anggota
                                        ?? optional($denda->anggota)->username
                                        ?? '-';

                                    $nisAnggota = optional($denda->anggota)->nis ?? '-';

                                    $judulBuku = optional(optional($denda->detailTransaksi)->buku)->judul_buku ?? '-';

                                    $hariTerlambat = $denda->jumlah_hari_terlambat ?? 0;

                                    $totalDenda = $denda->total_denda ?? 0;
                                @endphp

                                <tr>
                                    <td>
                                        <span class="td-name">{{ $namaAnggota }}</span>
                                        <span class="td-nis">NIS: {{ $nisAnggota }}</span>
                                    </td>
                                    <td>{{ $judulBuku }}</td>
                                    <td>{{ $hariTerlambat }} Hari</td>
                                    <td>
                                        <span class="td-denda">
                                            Rp {{ number_format($totalDenda, 0, ',', '.') }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="td-status status-belum">Belum Bayar</span>
                                    </td>
                                    <td>
                                        <a href="{{ url('/detail-denda/' . $denda->id) }}" class="td-action" title="Detail Denda">
                                            Detail
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td>
                                        <span class="td-name">Belum ada denda aktif</span>
                                        <span class="td-nis">NIS: -</span>
                                    </td>
                                    <td>-</td>
                                    <td>0 Hari</td>
                                    <td><span class="td-denda">Rp 0</span></td>
                                    <td><span class="td-status status-belum">Belum Ada</span></td>
                                    <td>-</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <a href="{{ url('/kelola-denda') }}" class="denda-lihat-semua">Lihat Semua Data Denda &rarr;</a>
            </div>
        </div>
    </section>

    {{-- ===== MODAL BUKU POPULER ===== --}}
    <div class="popular-modal" id="popularModal">
        <div class="popular-modal-inner">
            <div class="popular-modal-head">
                <h3>Semua Buku Populer</h3>
                <button class="popular-modal-close" id="popularModalClose" aria-label="Tutup">
                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                </button>
            </div>
            <div class="popular-modal-body">
                @forelse ($semuaBukuTerpopuler as $item)
                    @php
                        $judulBuku = optional($item->buku)->judul_buku ?? 'Judul buku tidak tersedia';
                        $penulisBuku = optional($item->buku)->penulis;
                        $totalDipinjamBuku = $item->total_dipinjam ?? 0;
                        $lebarBar = $maxTotalPinjamBuku > 0
                            ? min(100, round(($totalDipinjamBuku / $maxTotalPinjamBuku) * 100))
                            : 0;
                    @endphp

                    <div class="popular-item">
                        <div class="popular-info">
                            <span class="popular-judul">
                                {{ $judulBuku }}{{ $penulisBuku ? ' - ' . $penulisBuku : '' }}
                            </span>
                            <span class="popular-count">{{ $totalDipinjamBuku }} Pinjam</span>
                        </div>
                        <div class="popular-bar"><div class="popular-bar-fill" style="width:{{ $lebarBar }}%;"></div></div>
                    </div>
                @empty
                    <div class="popular-item">
                        <div class="popular-info">
                            <span class="popular-judul">Belum ada data buku populer</span>
                            <span class="popular-count">0 Pinjam</span>
                        </div>
                        <div class="popular-bar"><div class="popular-bar-fill" style="width:0%;"></div></div>
                    </div>
                @endforelse
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
                <h4 class="footer-col-title">Menu Navigasi</h4>
                <ul>
                    <li><a href="{{ url('/dashboard-admin') }}">Dashboard</a></li>
                    <li><a href="{{ url('/katalog-admin') }}">Katalog Buku</a></li>
                    <li><a href="{{ url('/kelola-anggota') }}">Database Anggota</a></li>
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
                    Jl. Kejawan Putih Tambak No. 1, Surabaya<br>
                    library@smait-aluswah.sch.id
                </address>
            </div>
        </div>
        <div class="footer-bottom">
            <p>© 2026 Perpustakaan SMAIT Al-Uswah. Menjaga Tradisi, Membangun Literasi.</p>
        </div>
    </footer>

    <script src="{{ asset('js/script-dashboard-admin.js') }}"></script>
</body>
</html>