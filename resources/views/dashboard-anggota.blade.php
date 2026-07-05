@php
    $namaAnggota = optional($anggota)->nama_anggota ?? session('auth_name') ?? 'Anggota';
    $namaDepan = explode(' ', trim($namaAnggota))[0] ?? 'Anggota';
    $inisialUser = strtoupper(substr($namaAnggota, 0, 1));
    $noAnggota = optional($anggota)->no_anggota ?? '-';

    $formatRupiah = fn ($angka) => 'Rp ' . number_format((float) $angka, 0, ',', '.');

    $formatTanggal = function ($tanggal) {
        if (!$tanggal) {
            return '-';
        }

        return \Illuminate\Support\Carbon::parse($tanggal)->translatedFormat('d M Y');
    };

    $coverUrl = function ($buku) {
        if (!$buku || empty($buku->cover)) {
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

    $fotoUrl = function ($foto) {
        if (!$foto) {
            return null;
        }

        if (str_starts_with($foto, 'http://') || str_starts_with($foto, 'https://')) {
            return $foto;
        }

        if (str_starts_with($foto, 'assets/')) {
            return asset($foto);
        }

        return asset('storage/' . $foto);
    };

    if ($sisaHariTerdekat === null) {
        $sisaHariText = 'Tidak Ada';
        $sisaHariTrend = 'belum ada pinjaman aktif';
        $sisaHariTrendClass = '';
    } elseif ($sisaHariTerdekat < 0) {
        $sisaHariText = 'Terlambat ' . abs($sisaHariTerdekat) . ' Hari';
        $sisaHariTrend = 'segera kembalikan';
        $sisaHariTrendClass = 'trend-warn';
    } elseif ($sisaHariTerdekat === 0) {
        $sisaHariText = 'Hari Ini';
        $sisaHariTrend = 'jatuh tempo hari ini';
        $sisaHariTrendClass = 'trend-warn';
    } else {
        $sisaHariText = $sisaHariTerdekat . ' Hari Lagi';
        $sisaHariTrend = $sisaHariTerdekat <= 2 ? 'segera kembalikan' : 'masih aman';
        $sisaHariTrendClass = $sisaHariTerdekat <= 2 ? 'trend-warn' : '';
    }

    $fotoAnggota = optional($anggota)->foto;
@endphp

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard – Perpustakaan SMAIT Al-Uswah</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style-home.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style-home-anggota.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style-dashboard-anggota.css') }}">
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

            <a href="{{ url('/profil-anggota') }}" class="nav-profile">
                <div class="nav-avatar">
                    @if ($fotoUrl($fotoAnggota))
                        <img src="{{ $fotoUrl($fotoAnggota) }}" alt="Foto Profil" class="avatar-img">
                    @else
                        <span class="avatar-placeholder">{{ $inisialUser }}</span>
                    @endif
                </div>

                <span class="nav-username">{{ $namaAnggota }}</span>
            </a>
        </div>
    </header>

    {{-- ===== GREETING ===== --}}
    <section class="greeting-section">
        <div class="greeting-inner">
            <h1 class="greeting-title">
                <span class="greeting-spark">
                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="#90C3C6" stroke="none"><path d="M12 2l1.5 5.5L19 9l-5.5 1.5L12 16l-1.5-5.5L5 9l5.5-1.5z"/></svg>
                </span>
                Halo, {{ $namaDepan }} <em>selamat membaca</em>
            </h1>
            <p class="greeting-sub">Semangat belajarmu hari ini adalah kunci masa depan.</p>
        </div>
    </section>

    {{-- ===== STAT CARDS ===== --}}
    <section class="dashboard-stats">
        <div class="dashboard-stats-inner">

            <div class="dash-stat-card card-teal">
                <div class="dash-stat-deco"></div>
                <div class="dash-stat-head">
                    <span class="dash-stat-label">Buku Dipinjam</span>
                    <div class="dash-stat-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>
                    </div>
                </div>
                <span class="dash-stat-value">{{ $totalSedangDipinjam }} Buku</span>
                <span class="dash-stat-trend">
                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/><polyline points="17 6 23 6 23 12"/></svg>
                    {{ $totalRiwayatPeminjaman }} total riwayat
                </span>
            </div>

            <div class="dash-stat-card card-mint">
                <div class="dash-stat-deco"></div>
                <div class="dash-stat-head">
                    <span class="dash-stat-label">Sisa Hari</span>
                    <div class="dash-stat-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                    </div>
                </div>
                <span class="dash-stat-value">{{ $sisaHariText }}</span>
                <span class="dash-stat-trend {{ $sisaHariTrendClass }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                    {{ $sisaHariTrend }}
                </span>
            </div>

            <div class="dash-stat-card card-alert">
                <div class="dash-stat-deco"></div>
                <div class="dash-stat-head">
                    <span class="dash-stat-label">Denda Aktif</span>
                    <div class="dash-stat-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="5" width="20" height="14" rx="2"/><line x1="2" y1="10" x2="22" y2="10"/></svg>
                    </div>
                </div>
                <span class="dash-stat-value alert-value">{{ $formatRupiah($totalDendaBelumLunas) }}</span>
                <a href="{{ url('/status-denda') }}" class="dash-stat-trend trend-link">Lihat denda &rarr;</a>
            </div>

            <div class="dash-stat-card card-orchid">
                <div class="dash-stat-deco"></div>
                <div class="dash-stat-head">
                    <span class="dash-stat-label">Notifikasi</span>
                    <div class="dash-stat-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
                    </div>
                </div>
                <span class="dash-stat-value">{{ $notifikasi->count() }} Pesan Baru</span>
                <span class="dash-stat-trend">
                    <span class="ping-dot"></span>
                    {{ $notifikasi->count() > 0 ? 'perlu diperhatikan' : 'tidak ada notifikasi' }}
                </span>
            </div>

        </div>
    </section>

    {{-- ===== MAIN GRID ===== --}}
    <section class="dashboard-main">
        <div class="dashboard-main-inner">

            {{-- LEFT COLUMN --}}
            <div class="dash-left">

                {{-- Pinjaman Aktif --}}
                <div class="dash-block">
                    <h2 class="dash-block-title">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#2D7076" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>
                        Pinjaman Aktif
                    </h2>

                    @forelse ($pinjamanAktif->take(4) as $detail)
                        @php
                            $buku = $detail->buku;
                            $transaksi = $detail->transaksi;
                            $judulBuku = optional($buku)->judul_buku ?? 'Buku Tidak Ditemukan';
                            $tanggalTempo = optional($transaksi)->tanggal_jatuh_tempo;

                            $hari = $tanggalTempo
                                ? now()->startOfDay()->diffInDays(\Illuminate\Support\Carbon::parse($tanggalTempo)->startOfDay(), false)
                                : null;

                            if ($hari === null) {
                                $badgeClass = 'badge-aman';
                                $badgeText = 'AKTIF';
                                $kembaliText = '-';
                            } elseif ($hari < 0) {
                                $badgeClass = 'badge-segera';
                                $badgeText = 'TERLAMBAT';
                                $kembaliText = 'Terlambat ' . abs($hari) . ' hari';
                            } elseif ($hari === 0) {
                                $badgeClass = 'badge-segera';
                                $badgeText = 'HARI INI';
                                $kembaliText = 'Jatuh tempo hari ini';
                            } elseif ($hari <= 2) {
                                $badgeClass = 'badge-segera';
                                $badgeText = 'SEGERA';
                                $kembaliText = $hari . ' hari lagi';
                            } else {
                                $badgeClass = 'badge-aman';
                                $badgeText = 'AMAN';
                                $kembaliText = $formatTanggal($tanggalTempo);
                            }
                        @endphp

                        <div class="pinjaman-item">
                            <img src="{{ $coverUrl($buku) }}" alt="{{ $judulBuku }}" class="pinjaman-cover">
                            <div class="pinjaman-info">
                                <h3 class="pinjaman-judul">{{ $judulBuku }}</h3>
                                <p class="pinjaman-kembali">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="{{ $hari !== null && $hari <= 2 ? '#c0392b' : 'currentColor' }}" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                                    Kembali: {{ $kembaliText }}
                                    <span class="{{ $badgeClass }}">{{ $badgeText }}</span>
                                </p>
                            </div>
                            <a href="{{ $buku ? url('/informasi-buku/' . $buku->id) : url('/katalog-anggota') }}" class="pinjaman-menu" aria-label="Detail buku">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#484441" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="5" r="1"/><circle cx="12" cy="12" r="1"/><circle cx="12" cy="19" r="1"/></svg>
                            </a>
                        </div>
                    @empty
                        <div style="padding:18px; border:1px dashed #d8e8e8; border-radius:16px; color:#6b6b6b; background:#fff;">
                            Belum ada buku yang sedang dipinjam.
                        </div>
                    @endforelse
                </div>

                {{-- Rekomendasi --}}
                <div class="dash-block">
                    <div class="dash-block-header">
                        <h2 class="dash-block-title">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#2D7076" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2l1.5 5.5L19 9l-5.5 1.5L12 16l-1.5-5.5L5 9l5.5-1.5z"/></svg>
                            Rekomendasi Untukmu
                        </h2>
                        <a href="{{ url('/katalog-anggota') }}" class="dash-lihat-semua">Lihat Semua &rarr;</a>
                    </div>

                    <div class="rekomendasi-grid">
                        @forelse ($rekomendasiBuku as $buku)
                            <a href="{{ url('/informasi-buku/' . $buku->id) }}" class="rekom-card">
                                <img src="{{ $coverUrl($buku) }}" alt="{{ $buku->judul_buku }}" class="rekom-cover">
                                <h4 class="rekom-judul">{{ $buku->judul_buku }}</h4>
                                <p class="rekom-penulis">{{ $buku->penulis ?? '-' }}</p>
                            </a>
                        @empty
                            <div style="grid-column:1/-1; padding:18px; border:1px dashed #d8e8e8; border-radius:16px; color:#6b6b6b; background:#fff;">
                                Belum ada rekomendasi buku tersedia.
                            </div>
                        @endforelse
                    </div>
                </div>

            </div>

            {{-- RIGHT COLUMN --}}
            <div class="dash-right">

                {{-- Kartu Anggota Digital --}}
                <div class="kartu-digital">
                    <div class="kartu-star">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="#b8742f" stroke="none"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                    </div>
                    <div class="kartu-head">
                        <div>
                            <span class="kartu-label">KARTU ANGGOTA DIGITAL</span>
                            <h3 class="kartu-nama-perpus">SMAIT Al-Uswah</h3>
                        </div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="rgba(255,255,255,.8)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 8.5a6 6 0 0 1 12 0"/><path d="M3 11.5a9 9 0 0 1 18 0"/><circle cx="12" cy="14" r="2"/></svg>
                    </div>
                    <p class="kartu-nama-anggota">{{ $namaAnggota }}</p>
                    <div class="kartu-bottom">
                        <span class="kartu-id">{{ $noAnggota }}</span>
                        <div class="kartu-qr">
                            <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="#2D7076" stroke-width="1.5"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/><line x1="14" y1="14" x2="14" y2="14.01"/><line x1="21" y1="14" x2="21" y2="14.01"/><line x1="14" y1="21" x2="14" y2="21.01"/><line x1="21" y1="21" x2="21" y2="21.01"/><line x1="17.5" y1="17.5" x2="17.5" y2="17.51"/></svg>
                        </div>
                    </div>
                </div>
                <p class="kartu-note">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#2D7076" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>
                    Tunjukkan QR saat meminjam buku
                </p>

                {{-- Statistik Membaca --}}
                <div class="statistik-card">
                    <div class="statistik-head">
                        <h3 class="statistik-title">Statistik Membaca</h3>
                        <span class="statistik-period">6 Bulan Terakhir</span>
                    </div>

                    <div class="chart-bars" id="chartBars">
                        @forelse ($statistikBulanan as $index => $bulan)
                            @php
                                $tinggi = $maxStatistikBulanan > 0
                                    ? max(8, round(($bulan['total'] / $maxStatistikBulanan) * 100))
                                    : 8;
                            @endphp

                            <div class="chart-bar-col">
                                <div class="chart-bar {{ $loop->last ? 'chart-bar-active' : '' }}" style="--val: {{ $tinggi }}%;" data-count="{{ $bulan['total'] }}"></div>
                                <span class="chart-label">{{ $bulan['bulan'] }}</span>
                            </div>
                        @empty
                            @foreach (['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun'] as $bulanKosong)
                                <div class="chart-bar-col">
                                    <div class="chart-bar" style="--val: 8%;" data-count="0"></div>
                                    <span class="chart-label">{{ $bulanKosong }}</span>
                                </div>
                            @endforeach
                        @endforelse
                    </div>

                    <div class="statistik-footer">
                        <div class="statistik-total">
                            <span class="total-num">{{ $totalBukuTahunIni }}</span>
                            <span class="total-label">Buku tahun ini</span>
                        </div>
                        <div class="statistik-streak">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="#b8742f" stroke="none"><path d="M12 2C8 6 6 9 6 13a6 6 0 0 0 12 0c0-2-1-4-2-5 0 2-1 3-2 3 1-3-1-6-2-9z"/></svg>
                            <span>{{ $totalBukuTahunIni > 0 ? 'Pertahankan kebiasaan membacamu' : 'Mulai pinjam buku pertamamu' }}</span>
                        </div>
                    </div>
                </div>

                {{-- Notifikasi --}}
                @if ($notifikasi->count() > 0)
                    <div class="statistik-card">
                        <div class="statistik-head">
                            <h3 class="statistik-title">Notifikasi</h3>
                            <span class="statistik-period">{{ $notifikasi->count() }} pesan</span>
                        </div>

                        <div style="display:flex; flex-direction:column; gap:10px;">
                            @foreach ($notifikasi->take(4) as $pesan)
                                <div style="padding:12px 14px; border-radius:14px; background:#fff7ed; color:#7c4a03; font-size:13px; line-height:1.5;">
                                    {{ $pesan }}
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- Peringkat Membaca --}}
                <div class="peringkat-card">
                    <span class="peringkat-label">PERINGKAT MEMBACA</span>
                    <h3 class="peringkat-rank">{{ $peringkatMembaca }}</h3>
                    <div class="peringkat-progress">
                        <div class="peringkat-progress-fill" style="width: {{ $progressPeringkat }}%;"></div>
                    </div>
                    <p class="peringkat-note">
                        @if ($sisaTargetPeringkat > 0)
                            {{ $sisaTargetPeringkat }} buku lagi untuk naik level
                        @else
                            Kamu sudah mencapai target level ini
                        @endif
                    </p>
                    <div class="peringkat-star">
                        <svg xmlns="http://www.w3.org/2000/svg" width="60" height="60" viewBox="0 0 24 24" fill="rgba(255,255,255,.1)" stroke="none"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
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
                <h4 class="footer-col-title">Layanan</h4>
                <ul>
                    <li><a href="{{ url('/tentang-perpustakaan-anggota') }}">Visi &amp; Misi</a></li>
                    <li><a href="{{ url('/katalog-anggota') }}">Katalog Buku</a></li>
                </ul>
            </div>

            <div class="footer-col">
                <h4 class="footer-col-title">Dukungan</h4>
                <ul>
                    <li><a href="#">Pusat Bantuan</a></li>
                    <li><a href="{{ url('/status-denda') }}">Status Denda</a></li>
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

    {{-- Script lama dummy dimatikan dulu --}}
    {{-- <script src="{{ asset('js/script-dashboard-anggota.js') }}"></script> --}}
</body>
</html>