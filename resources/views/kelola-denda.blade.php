@php
    $adminName = session('auth_name') ?? 'Admin';

    $search = $search ?? request('search');
    $status = $status ?? request('status');

    $totalBelumLunas = $totalBelumLunas ?? 0;
    $totalLunas = $totalLunas ?? 0;
    $totalDendaBelumLunas = $totalDendaBelumLunas ?? 0;
    $totalDendaTerkumpul = $totalDendaTerkumpul ?? 0;
    $tarifDenda = $tarifDenda ?? 1000;

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

    $formatRupiah = function ($angka) {
        return 'Rp ' . number_format($angka ?? 0, 0, ',', '.');
    };
@endphp

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengelolaan Denda – Perpustakaan SMAIT Al-Uswah</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style-home.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style-home-anggota.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style-home-admin.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style-kelola-denda.css') }}">
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
                <a href="{{ url('/dashboard-admin') }}" class="nav-link">Dashboard</a>
                <a href="{{ url('/katalog-admin') }}" class="nav-link">Katalog</a>
                <a href="{{ url('/tentang-perpustakaan-admin') }}" class="nav-link">Tentang</a>
                <a href="{{ url('/kelola-buku') }}" class="nav-link">Buku</a>
                <a href="{{ url('/kelola-anggota') }}" class="nav-link">Anggota</a>
                <a href="{{ url('/riwayat-transaksi') }}" class="nav-link">Transaksi</a>
                <a href="{{ url('/kelola-denda') }}" class="nav-link active">Denda</a>
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
    <section class="kd-hero">
        <div class="kd-hero-inner">
            <span class="kd-eyebrow">Pusat Administrasi</span>
            <h1 class="kd-title">
                Pengelolaan Denda
                <span class="kd-title-ic">
                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#b8742f" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                </span>
            </h1>
        </div>
    </section>

    {{-- ===== SUMMARY + TARIF ===== --}}
    <section class="kd-summary-section">
        <div class="kd-summary-inner">

            <div class="kd-summary-card card-aktif">
                <div class="kd-card-head">
                    <div class="kd-card-ic">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                    </div>
                    <span class="kd-card-tag">Belum Lunas</span>
                </div>
                <span class="kd-card-label">Denda Aktif</span>
                <span class="kd-card-value">{{ $totalBelumLunas }} Kasus</span>
                <div class="kd-card-progress">
                    <div class="kd-card-progress-fill" style="width: {{ ($totalBelumLunas + $totalLunas) > 0 ? min(100, round(($totalBelumLunas / ($totalBelumLunas + $totalLunas)) * 100)) : 0 }}%;"></div>
                </div>
                <span class="kd-card-progress-label">{{ $formatRupiah($totalDendaBelumLunas) }}</span>
            </div>

            <div class="kd-summary-card card-lunas">
                <div class="kd-card-head">
                    <div class="kd-card-ic ic-light">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#2D7076" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="5" width="20" height="14" rx="2"/><line x1="2" y1="10" x2="22" y2="10"/></svg>
                    </div>
                    <span class="kd-card-tag tag-light">Selesai</span>
                </div>
                <span class="kd-card-label dark">Denda Lunas</span>
                <span class="kd-card-value dark">{{ $totalLunas }} Kasus</span>
                <span class="kd-card-note">Denda yang sudah diselesaikan.</span>
            </div>

            <div class="kd-summary-card card-total">
                <div class="kd-card-head">
                    <div class="kd-card-ic ic-brown">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 5c-1.5 0-2.8 1.4-3 2-3.5-1.5-11-.3-11 5 0 1.8 0 3 2 4.5V20h4v-2h3v2h4v-4c1-.5 1.7-1 2-2h2v-4h-2c0-1-.5-1.5-1-2V5z"/></svg>
                    </div>
                    <span class="kd-card-tag tag-brown">Valid</span>
                </div>
                <span class="kd-card-label light">Total Denda Terkumpul</span>
                <span class="kd-card-value light">{{ $formatRupiah($totalDendaTerkumpul) }}</span>
                <div class="kd-card-avatars">
                    <span class="kd-avatar a1">OK</span>
                    <span class="kd-avatar a2">Rp</span>
                    <span class="kd-avatar a3">✓</span>
                </div>
            </div>
        </div>

        {{-- ===== PANEL TARIF DENDA ===== --}}
        <div class="kd-tarif-inner">
            <div class="kd-tarif-panel">
                <div class="kd-tarif-info">
                    <div class="kd-tarif-ic">
                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#2D7076" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M16 8h-6a2 2 0 1 0 0 4h4a2 2 0 1 1 0 4H8"/><line x1="12" y1="6" x2="12" y2="8"/><line x1="12" y1="16" x2="12" y2="18"/></svg>
                    </div>
                    <div>
                        <span class="kd-tarif-label">Tarif Denda Saat Ini</span>
                        <span class="kd-tarif-value">{{ $formatRupiah($tarifDenda) }} <small>/ hari keterlambatan</small></span>
                    </div>
                </div>

                <a href="{{ url('/setting') }}" class="btn-update-tarif" style="text-decoration:none;">
                    Ubah di Setting
                </a>
            </div>
        </div>
    </section>

    {{-- ===== SEARCH & FILTER ===== --}}
    <section class="kd-filter-section">
        <div class="kd-filter-inner">
            <form action="{{ url('/kelola-denda') }}" method="GET" class="kd-filter-bar">
                <div class="kd-search-wrap">
                    <svg class="kd-search-ic" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#2D7076" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                    <input type="text" name="search" value="{{ $search }}" class="kd-search" placeholder="Cari nama anggota, NIS, judul buku, atau ISBN...">
                </div>

                <div class="kd-select-wrap">
                    <select name="status" class="kd-select" onchange="this.form.submit()">
                        <option value="">Semua Status</option>
                        <option value="belum_lunas" {{ $status === 'belum_lunas' ? 'selected' : '' }}>Belum Lunas</option>
                        <option value="lunas" {{ $status === 'lunas' ? 'selected' : '' }}>Lunas</option>
                    </select>
                    <svg class="kd-select-arrow" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#2D7076" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg>
                </div>

                <button type="submit" class="btn-update-tarif" style="border:none; cursor:pointer;">
                    Cari
                </button>

                @if ($search || $status)
                    <a href="{{ url('/kelola-denda') }}" class="btn-update-tarif" style="text-decoration:none; background:#f5f5f5; color:#2D7076;">
                        Reset
                    </a>
                @endif
            </form>
        </div>
    </section>

    {{-- ===== TABEL DENDA ===== --}}
    <section class="kd-table-section">
        <div class="kd-table-inner">
            <div class="kd-table-card">

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

                {{-- Tab --}}
                <div class="kd-tabs">
                    <a href="{{ url('/kelola-denda?status=belum_lunas') }}" class="kd-tab {{ $status === 'belum_lunas' || !$status ? 'active' : '' }}" style="text-decoration:none;">
                        Denda Aktif <span class="kd-tab-count">{{ $totalBelumLunas }}</span>
                    </a>

                    <a href="{{ url('/kelola-denda?status=lunas') }}" class="kd-tab {{ $status === 'lunas' ? 'active' : '' }}" style="text-decoration:none;">
                        Denda Lunas <span class="kd-tab-count">{{ $totalLunas }}</span>
                    </a>
                </div>

                {{-- Tabel --}}
                <div class="kd-table-wrap">
                    <table class="kd-table">
                        <thead>
                            <tr>
                                <th>Nama Anggota</th>
                                <th>Kelas</th>
                                <th>Judul Buku</th>
                                <th>Hari Terlambat</th>
                                <th>Total Denda</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>

                        <tbody id="dendaTbody">
                            @forelse ($dendas as $denda)
                                @php
                                    $anggota = $denda->anggota;
                                    $detail = $denda->detailTransaksi;
                                    $buku = optional($detail)->buku;

                                    $namaAnggota = optional($anggota)->nama_anggota ?? 'Anggota Tidak Ditemukan';
                                    $kelasAnggota = optional($anggota)->kelas ?? '-';
                                    $judulBuku = optional($buku)->judul_buku ?? 'Buku Tidak Ditemukan';

                                    $inisial = $initials($namaAnggota);
                                    $avatarClass = $avatarClasses[$loop->index % count($avatarClasses)];

                                    $isLunas = $denda->status_denda === 'lunas';

                                    $totalSudahValid = $denda->pembayaranDendas
                                        ->where('status_validasi', 'valid')
                                        ->sum('nominal_bayar');

                                    $sisaDenda = max(0, ($denda->total_denda ?? 0) - $totalSudahValid);
                                @endphp

                                <tr class="kd-row">
                                    <td>
                                        <div class="kd-anggota">
                                            <span class="kd-avatar-tbl {{ $avatarClass }}">{{ $inisial }}</span>
                                            <span class="kd-anggota-nama">{{ $namaAnggota }}</span>
                                        </div>
                                    </td>

                                    <td>{{ $kelasAnggota }}</td>

                                    <td>
                                        {{ $judulBuku }}
                                        <br>
                                        <small>Tanggal denda: {{ $formatTanggal($denda->tanggal_denda) }}</small>
                                    </td>

                                    <td>
                                        <span class="kd-late {{ $isLunas ? 'kd-late-grey' : 'kd-late-red' }}">
                                            {{ $denda->jumlah_hari_terlambat ?? 0 }} Hari
                                        </span>
                                    </td>

                                    <td>
                                        <span class="kd-denda {{ $isLunas ? 'kd-denda-zero' : '' }}">
                                            {{ $formatRupiah($denda->total_denda) }}
                                        </span>
                                        <br>
                                        <small>Sisa: {{ $formatRupiah($sisaDenda) }}</small>
                                    </td>

                                    <td>
                                        @if ($isLunas)
                                            <span class="kd-status status-lunas"><span class="status-dot"></span> LUNAS</span>
                                        @else
                                            <span class="kd-status status-belum"><span class="status-dot"></span> BELUM LUNAS</span>
                                        @endif
                                    </td>

                                    <td>
                                        <div style="display:flex; gap:8px; align-items:center; flex-wrap:wrap;">
                                            <a href="{{ url('/detail-denda/' . $denda->id) }}" class="btn-update-tarif" style="text-decoration:none; padding:8px 12px;">
                                                Detail
                                            </a>

                                            @if (!$isLunas)
                                                <form action="{{ url('/denda/' . $denda->id . '/lunasi') }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('PATCH')

                                                    <button type="submit" class="btn-update-tarif" style="border:none; cursor:pointer; padding:8px 12px;" onclick="return confirm('Lunasi denda milik {{ addslashes($namaAnggota) }} sebesar {{ $formatRupiah($sisaDenda) }}?')">
                                                        Lunasi
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" style="text-align:center; padding:32px;">
                                        Tidak ada data denda yang cocok.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <div class="kd-empty" id="kdEmpty" style="{{ $dendas->count() > 0 ? 'display:none;' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="44" height="44" viewBox="0 0 24 24" fill="none" stroke="#2D7076" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                        <p>Tidak ada data denda yang cocok.</p>
                    </div>
                </div>

                {{-- Footer tabel --}}
                <div class="kd-table-footer">
                    <span class="kd-table-info" id="kdInfo">
                        @if ($dendas->total() > 0)
                            Menampilkan {{ $dendas->firstItem() }}–{{ $dendas->lastItem() }} dari {{ $dendas->total() }} denda
                        @else
                            Menampilkan 0 denda
                        @endif
                    </span>

                    <div class="kd-pagination">
                        @if ($dendas->onFirstPage())
                            <button class="kd-page-btn" disabled aria-label="Sebelumnya">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
                            </button>
                        @else
                            <a href="{{ $dendas->previousPageUrl() }}" class="kd-page-btn" aria-label="Sebelumnya">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
                            </a>
                        @endif

                        @for ($i = 1; $i <= $dendas->lastPage(); $i++)
                            @if ($i === $dendas->currentPage())
                                <button class="kd-page-btn active">{{ $i }}</button>
                            @else
                                <a href="{{ $dendas->url($i) }}" class="kd-page-btn">{{ $i }}</a>
                            @endif
                        @endfor

                        @if ($dendas->hasMorePages())
                            <a href="{{ $dendas->nextPageUrl() }}" class="kd-page-btn" aria-label="Berikutnya">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
                            </a>
                        @else
                            <button class="kd-page-btn" disabled aria-label="Berikutnya">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
                            </button>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </section>

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
                <h4 class="footer-col-title">Kebijakan</h4>
                <ul>
                    <li><a href="#">Aturan Peminjaman</a></li>
                    <li><a href="#">Kebijakan Denda</a></li>
                </ul>
            </div>

            <div class="footer-col">
                <h4 class="footer-col-title">Layanan</h4>
                <ul>
                    <li><a href="{{ url('/riwayat-transaksi') }}">Transaksi</a></li>
                    <li><a href="{{ url('/input-peminjaman') }}">Input Peminjaman</a></li>
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
    {{-- <script src="{{ asset('js/script-kelola-denda.js') }}"></script> --}}

</body>
</html>