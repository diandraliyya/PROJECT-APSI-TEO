@php
    $adminName = session('auth_name') ?? 'Admin';

    $anggota = $transaksi->anggota;
    $admin = $transaksi->admin;

    $namaAnggota = optional($anggota)->nama_anggota ?? 'Anggota Tidak Ditemukan';
    $nisAnggota = optional($anggota)->nis ?? '-';
    $kelasAnggota = optional($anggota)->kelas ?? '-';
    $statusAnggota = optional($anggota)->status_anggota ?? '-';

    $tanggalPinjam = $transaksi->tanggal_pinjam
        ? \Illuminate\Support\Carbon::parse($transaksi->tanggal_pinjam)
        : null;

    $tanggalJatuhTempo = $transaksi->tanggal_jatuh_tempo
        ? \Illuminate\Support\Carbon::parse($transaksi->tanggal_jatuh_tempo)
        : null;

    $tanggalKembali = $transaksi->tanggal_kembali
        ? \Illuminate\Support\Carbon::parse($transaksi->tanggal_kembali)
        : null;

    $formatTanggal = function ($tanggal) {
        if (!$tanggal) {
            return '-';
        }

        return \Illuminate\Support\Carbon::parse($tanggal)->translatedFormat('d M Y');
    };

    $detailItems = $transaksi->detailTransaksis ?? collect();

    $jumlahItem = $transaksi->total_item ?: $detailItems->sum('jumlah');

    $jumlahBelumKembali = $detailItems
        ->whereNull('tanggal_kembali_item')
        ->whereIn('status_item', ['dipinjam', 'terlambat'])
        ->count();

    $adaItemTerlambat = $detailItems->contains(function ($detail) {
        return $detail->status_item === 'terlambat';
    });

    $sudahLewatTempo = $tanggalJatuhTempo && now()->startOfDay()->gt($tanggalJatuhTempo->copy()->startOfDay()) && $jumlahBelumKembali > 0;

    $statusTransaksi = $transaksi->status_transaksi ?? 'dipinjam';

    if ($statusTransaksi !== 'dikembalikan' && $sudahLewatTempo) {
        $statusTampilan = 'Terlambat';
        $statusClass = 'late';
    } elseif ($statusTransaksi === 'dikembalikan') {
        $statusTampilan = 'Dikembalikan';
        $statusClass = 'safe';
    } elseif ($statusTransaksi === 'terlambat' || $adaItemTerlambat) {
        $statusTampilan = 'Terlambat';
        $statusClass = 'late';
    } else {
        $statusTampilan = 'Dipinjam';
        $statusClass = 'safe';
    }

    $statusSekarang = $statusTransaksi === 'dikembalikan'
        ? 'Sudah Dikembalikan'
        : ($statusClass === 'late' ? 'Terlambat' : 'Sedang Dipinjam');

    $lamaPinjam = '-';

    if ($tanggalPinjam && $tanggalJatuhTempo) {
        $lamaPinjam = $tanggalPinjam->diffInDays($tanggalJatuhTempo) . ' Hari';
    }

    $hariTerlambat = 0;

    if ($tanggalJatuhTempo && $statusTransaksi !== 'dikembalikan' && now()->startOfDay()->gt($tanggalJatuhTempo->copy()->startOfDay())) {
        $hariTerlambat = $tanggalJatuhTempo->copy()->startOfDay()->diffInDays(now()->startOfDay());
    }

    $totalDenda = $detailItems->sum(function ($detail) {
        return optional($detail->denda)->total_denda ?? 0;
    });

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

    $initials = function ($nama) {
        $nama = trim($nama ?: 'A');
        $parts = preg_split('/\s+/', $nama);

        $first = strtoupper(substr($parts[0] ?? 'A', 0, 1));
        $second = strtoupper(substr($parts[1] ?? '', 0, 1));

        return $first . $second;
    };
@endphp

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Transaksi #{{ $transaksi->kode_transaksi }} – Perpustakaan SMAIT Al-Uswah</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style-home.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style-home-anggota.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style-home-admin.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style-detail-transaksi.css') }}">
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

    {{-- ===== HEADER TRANSAKSI ===== --}}
    <section class="dt-header">
        <div class="dt-header-inner">
            <div class="dt-header-left">
                <span class="dt-eyebrow">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
                    DETAIL TRANSAKSI
                </span>

                <h1 class="dt-kode">#{{ $transaksi->kode_transaksi }}</h1>

                <div class="dt-meta">
                    <span class="dt-status-badge badge-{{ $statusClass }}">{{ $statusTampilan }}</span>
                    <span class="dt-date">
                        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                        {{ $formatTanggal($transaksi->created_at) }}
                    </span>
                </div>
            </div>

            @if ($jumlahBelumKembali > 0)
                <a href="#daftar-buku" class="btn-catat-kembali">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                    Catat Pengembalian
                </a>
            @else
                <span class="dt-returned-badge">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                    Sudah Dikembalikan
                </span>
            @endif
        </div>
    </section>

    {{-- ===== INFO + RINGKASAN ===== --}}
    <section class="dt-main">
        <div class="dt-main-inner">

            {{-- Informasi Anggota --}}
            <div class="dt-anggota-card">
                <h2 class="dt-card-title">Informasi Anggota <span class="title-line"></span></h2>

                <div class="dt-anggota-body">
                    <div class="dt-anggota-foto">{{ $initials($namaAnggota) }}</div>

                    <div class="dt-anggota-info">
                        <h3 class="dt-anggota-nama">{{ $namaAnggota }}</h3>

                        <p class="dt-anggota-detail">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><circle cx="12" cy="12" r="3"/></svg>
                            NIS: {{ $nisAnggota }}
                        </p>

                        <p class="dt-anggota-detail">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c3 3 9 3 12 0v-5"/></svg>
                            Kelas: {{ $kelasAnggota }}
                        </p>

                        <span class="dt-anggota-status">{{ strtoupper($statusAnggota) }}</span>
                    </div>
                </div>
            </div>

            {{-- Ringkasan Transaksi --}}
            <div class="dt-ringkasan-card">
                <h2 class="dt-card-title primary">Ringkasan Transaksi</h2>

                <div class="dt-ringkasan-grid">
                    <div class="dt-ring-item">
                        <span class="dt-ring-label">Tanggal Pinjam</span>
                        <span class="dt-ring-value primary">{{ $formatTanggal($transaksi->tanggal_pinjam) }}</span>
                    </div>

                    <div class="dt-ring-item">
                        <span class="dt-ring-label">Jatuh Tempo</span>
                        <span class="dt-ring-value {{ $statusClass === 'late' ? 'danger' : 'primary' }}">
                            {{ $formatTanggal($transaksi->tanggal_jatuh_tempo) }}
                        </span>
                    </div>

                    <div class="dt-ring-item">
                        <span class="dt-ring-label">Status Sekarang</span>
                        <span class="dt-ring-value">{{ $statusSekarang }}</span>
                    </div>

                    <div class="dt-ring-item">
                        <span class="dt-ring-label">Total Item</span>
                        <span class="dt-ring-value">{{ $jumlahItem }} Buku</span>
                    </div>

                    <div class="dt-ring-item">
                        <span class="dt-ring-label">Lama Pinjam</span>
                        <span class="dt-ring-value">{{ $lamaPinjam }}</span>
                    </div>

                    <div class="dt-ring-item">
                        <span class="dt-ring-label">Petugas</span>
                        <span class="dt-ring-value">{{ optional($admin)->nama_admin ?? 'Admin' }}</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ===== ALERT DENDA / TERLAMBAT ===== --}}
    @if ($hariTerlambat > 0 || $totalDenda > 0)
        <section class="dt-alert-section">
            <div class="dt-alert-inner">
                <div class="dt-alert">
                    <div class="dt-alert-ic">
                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="#b8742f" stroke="none"><path d="M19 21l-7-5-7 5V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2z"/></svg>
                    </div>

                    <div class="dt-alert-text">
                        <strong>Terlambat {{ $hariTerlambat }} Hari</strong>
                        <p>Masa peminjaman telah habis. Denda akan dicatat ketika buku dikembalikan.</p>
                    </div>

                    <div class="dt-alert-denda">
                        <span class="dt-alert-denda-label">Denda Tercatat</span>
                        <span class="dt-alert-denda-value">Rp {{ number_format($totalDenda, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>
        </section>
    @endif

    {{-- ===== FLASH MESSAGE ===== --}}
    @if (session('success') || session('error'))
        <section class="dt-alert-section">
            <div class="dt-alert-inner">
                <div style="background: {{ session('success') ? '#f0fff4' : '#fff3f3' }}; border:1px solid {{ session('success') ? '#a7e3b5' : '#f3b5b5' }}; color: {{ session('success') ? '#24733b' : '#9f2f2f' }}; padding:14px 18px; border-radius:14px;">
                    {{ session('success') ?? session('error') }}
                </div>
            </div>
        </section>
    @endif

    {{-- ===== DAFTAR BUKU ===== --}}
    <section class="dt-books-section" id="daftar-buku">
        <div class="dt-books-inner">
            <div class="dt-books-card">
                <div class="dt-books-head">
                    <h2 class="dt-books-title">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#2D7076" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>
                        Daftar Buku Terkait
                    </h2>
                    <span class="dt-books-count">{{ $detailItems->count() }} ITEM</span>
                </div>

                <div class="dt-table-wrap">
                    <table class="dt-table">
                        <thead>
                            <tr>
                                <th>JUDUL BUKU</th>
                                <th>JUMLAH</th>
                                <th>STATUS ITEM</th>
                                <th>STATUS PENGEMBALIAN</th>
                                <th>DENDA</th>
                                <th>AKSI</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($detailItems as $detail)
                                @php
                                    $buku = $detail->buku;

                                    $judulBuku = optional($buku)->judul_buku ?? 'Buku Tidak Ditemukan';
                                    $isbnBuku = optional($buku)->isbn ?? '-';

                                    $statusItem = $detail->status_item ?? 'dipinjam';

                                    $belumKembali = is_null($detail->tanggal_kembali_item) && in_array($statusItem, ['dipinjam', 'terlambat']);

                                    $itemTerlambat = $belumKembali && $tanggalJatuhTempo && now()->startOfDay()->gt($tanggalJatuhTempo->copy()->startOfDay());

                                    if (!$belumKembali) {
                                        $statusPengembalian = 'Sudah Kembali';
                                        $kembaliClass = 'sudah';
                                    } elseif ($itemTerlambat || $statusItem === 'terlambat') {
                                        $statusPengembalian = 'Terlambat';
                                        $kembaliClass = 'belum';
                                    } else {
                                        $statusPengembalian = 'Belum Kembali';
                                        $kembaliClass = 'belum';
                                    }

                                    $statusItemLabel = [
                                        'dipinjam' => 'Dipinjam',
                                        'terlambat' => 'Terlambat',
                                        'dikembalikan' => 'Dikembalikan',
                                    ][$statusItem] ?? ucfirst($statusItem);

                                    $dendaItem = optional($detail->denda)->total_denda ?? 0;
                                @endphp

                                <tr>
                                    <td>
                                        <div class="dt-book">
                                            <img src="{{ $coverUrl($buku) }}" alt="{{ $judulBuku }}" class="dt-book-cover">

                                            <div>
                                                <span class="dt-book-judul">{{ $judulBuku }}</span>
                                                <span class="dt-book-isbn">ISBN: {{ $isbnBuku }}</span>
                                            </div>
                                        </div>
                                    </td>

                                    <td><span class="dt-jumlah">{{ $detail->jumlah ?? 1 }}</span></td>

                                    <td><span class="dt-item-status">{{ $statusItemLabel }}</span></td>

                                    <td>
                                        <span class="dt-kembali dt-kembali-{{ $kembaliClass }}">
                                            @if ($kembaliClass === 'belum')
                                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                                            @else
                                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                                            @endif

                                            {{ $statusPengembalian }}
                                        </span>

                                        @if ($detail->tanggal_kembali_item)
                                            <br>
                                            <small>{{ $formatTanggal($detail->tanggal_kembali_item) }}</small>
                                        @endif
                                    </td>

                                    <td>
                                        @if ($dendaItem > 0)
                                            Rp {{ number_format($dendaItem, 0, ',', '.') }}
                                        @else
                                            -
                                        @endif
                                    </td>

                                    <td>
                                        <div style="display:flex; gap:8px; align-items:center; flex-wrap:wrap;">
                                            @if ($buku)
                                                <a href="{{ url('/informasi-buku-admin/' . $buku->id) }}" class="dt-action" title="Lihat buku">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#2D7076" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
                                                </a>
                                            @endif

                                            @if ($belumKembali)
                                                <form action="{{ url('/pengembalian/' . $detail->id) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('PATCH')

                                                    <input type="hidden" name="tanggal_kembali_item" value="{{ now()->toDateString() }}">

                                                    <button type="submit" class="dt-action" title="Catat dikembalikan" onclick="return confirm('Catat buku {{ addslashes($judulBuku) }} sebagai sudah dikembalikan hari ini?')">
                                                        ✓
                                                    </button>
                                                </form>
                                            @else
                                                <span style="font-size:12px; color:#777;">Selesai</span>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" style="text-align:center; padding:32px;">
                                        Tidak ada buku pada transaksi ini.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div style="margin-top:18px;">
                    <a href="{{ url('/riwayat-transaksi') }}" class="btn-catat-kembali" style="display:inline-flex; text-decoration:none;">
                        Kembali ke Riwayat Transaksi
                    </a>
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
                <h4 class="footer-col-title">Menu Navigasi</h4>
                <ul>
                    <li><a href="{{ url('/dashboard-admin') }}">Dashboard</a></li>
                    <li><a href="{{ url('/riwayat-transaksi') }}">Transaksi</a></li>
                    <li><a href="{{ url('/input-peminjaman') }}">Input Peminjaman</a></li>
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

    {{-- Script lama dummy dimatikan dulu --}}
    {{-- <script src="{{ asset('js/script-detail-transaksi.js') }}"></script> --}}

</body>
</html>