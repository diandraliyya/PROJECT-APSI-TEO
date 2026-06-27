@php
    // ====== DATA TRANSAKSI (dummy, nanti dari controller) ======
    $dataTransaksi = [
        10 => [
            'kode' => 'TRX-8819',
            'status' => 'Terlambat', 'status_class' => 'late',
            'tanggal_transaksi' => '05 Oktober 2026',
            'anggota' => 'Nadia Rahma', 'nis' => '222310104', 'kelas' => 'X IPS 2',
            'anggota_status' => 'AKTIF',
            'tgl_pinjam' => '05 Okt 2026', 'jatuh_tempo' => '12 Okt 2026',
            'status_sekarang' => 'Sedang Dipinjam',
            'total_item' => '1 Buku', 'lama_pinjam' => '10 Hari', 'petugas' => 'Admin Utama',
            'terlambat_hari' => 3, 'estimasi_denda' => '1.500',
            'buku' => [
                ['judul' => 'The Things You Can See Only When You Slow Down', 'isbn' => '978-602-481-365-9', 'cover' => 'slow-down-sampul.jpg', 'jumlah' => 1, 'status_item' => 'Tersedia', 'status_kembali' => 'Belum Kembali', 'kembali_class' => 'belum'],
            ],
        ],
        11 => [
            'kode' => 'TRX-8820',
            'status' => 'Tepat Waktu', 'status_class' => 'safe',
            'tanggal_transaksi' => '08 September 2026',
            'anggota' => 'Maya Kusuma', 'nis' => '222310045', 'kelas' => 'X-A',
            'anggota_status' => 'AKTIF',
            'tgl_pinjam' => '01 Sep 2026', 'jatuh_tempo' => '15 Sep 2026',
            'status_sekarang' => 'Sudah Dikembalikan',
            'total_item' => '1 Buku', 'lama_pinjam' => '14 Hari', 'petugas' => 'Admin Utama',
            'terlambat_hari' => 0, 'estimasi_denda' => '0',
            'buku' => [
                ['judul' => 'Laskar Pelangi', 'isbn' => '979-3062-79-7', 'cover' => 'Laskar_pelangi_sampul.jpg', 'jumlah' => 1, 'status_item' => 'Tersedia', 'status_kembali' => 'Sudah Kembali', 'kembali_class' => 'sudah'],
            ],
        ],
    ];

    $id = request()->route('id') ?? request('id') ?? 10;
    $trx = $dataTransaksi[$id] ?? $dataTransaksi[10];
@endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Transaksi #{{ $trx['kode'] }} – Perpustakaan SMAIT Al-Uswah</title>
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
            <a href="{{ route('home-admin') }}" class="nav-brand">
                <img src="{{ asset('assets/logo.png') }}" alt="Logo" class="nav-logo">
                <span class="nav-brand-name">Al-Uswah Library</span>
            </a>

            <nav class="nav-links">
                <a href="{{ route('dashboard-admin') }}" class="nav-link">Dashboard</a>
                <a href="{{ route('katalog-admin') }}" class="nav-link">Katalog</a>
                <a href="{{ route('tentang-perpustakaan-admin') }}" class="nav-link">Tentang</a>
                <a href="{{ route('kelola-buku') }}" class="nav-link">Buku</a>
                <a href="{{ route('kelola-anggota') }}" class="nav-link">Anggota</a>
                <a href="{{ route('riwayat-transaksi') }}" class="nav-link active">Transaksi</a>
                <a href="{{ route('kelola-denda') }}" class="nav-link">Denda</a>
            </nav>

            <a href="{{ route('setting') }}" class="nav-profile">
                <div class="nav-avatar">
                    <div class="avatar-placeholder admin-avatar">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                    </div>
                </div>
                <div class="nav-profile-info">
                    <span class="nav-username">{{ auth()->user()?->nama_lengkap ?? 'Admin' }}</span>
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
                <h1 class="dt-kode">#{{ $trx['kode'] }}</h1>
                <div class="dt-meta">
                    <span class="dt-status-badge badge-{{ $trx['status_class'] }}">{{ $trx['status'] }}</span>
                    <span class="dt-date">
                        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                        {{ $trx['tanggal_transaksi'] }}
                    </span>
                </div>
            </div>

            @if($trx['status_sekarang'] !== 'Sudah Dikembalikan')
                <button class="btn-catat-kembali" id="btnCatatKembali">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                    Catat Dikembalikan
                </button>
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
                    <div class="dt-anggota-foto">{{ strtoupper(substr($trx['anggota'], 0, 2)) }}</div>
                    <div class="dt-anggota-info">
                        <h3 class="dt-anggota-nama">{{ $trx['anggota'] }}</h3>
                        <p class="dt-anggota-detail">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><circle cx="12" cy="12" r="3"/></svg>
                            NIS: {{ $trx['nis'] }}
                        </p>
                        <p class="dt-anggota-detail">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c3 3 9 3 12 0v-5"/></svg>
                            Kelas: {{ $trx['kelas'] }}
                        </p>
                        <span class="dt-anggota-status">{{ $trx['anggota_status'] }}</span>
                    </div>
                </div>
            </div>

            {{-- Ringkasan Transaksi --}}
            <div class="dt-ringkasan-card">
                <h2 class="dt-card-title primary">Ringkasan Transaksi</h2>
                <div class="dt-ringkasan-grid">
                    <div class="dt-ring-item">
                        <span class="dt-ring-label">Tanggal Pinjam</span>
                        <span class="dt-ring-value primary">{{ $trx['tgl_pinjam'] }}</span>
                    </div>
                    <div class="dt-ring-item">
                        <span class="dt-ring-label">Jatuh Tempo</span>
                        <span class="dt-ring-value {{ $trx['status_class'] === 'late' ? 'danger' : 'primary' }}">{{ $trx['jatuh_tempo'] }}</span>
                    </div>
                    <div class="dt-ring-item">
                        <span class="dt-ring-label">Status Sekarang</span>
                        <span class="dt-ring-value">{{ $trx['status_sekarang'] }}</span>
                    </div>
                    <div class="dt-ring-item">
                        <span class="dt-ring-label">Total Item</span>
                        <span class="dt-ring-value">{{ $trx['total_item'] }}</span>
                    </div>
                    <div class="dt-ring-item">
                        <span class="dt-ring-label">Lama Pinjam</span>
                        <span class="dt-ring-value">{{ $trx['lama_pinjam'] }}</span>
                    </div>
                    <div class="dt-ring-item">
                        <span class="dt-ring-label">Petugas</span>
                        <span class="dt-ring-value">{{ $trx['petugas'] }}</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ===== ALERT DENDA (jika terlambat) ===== --}}
    @if($trx['terlambat_hari'] > 0)
    <section class="dt-alert-section">
        <div class="dt-alert-inner">
            <div class="dt-alert">
                <div class="dt-alert-ic">
                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="#b8742f" stroke="none"><path d="M19 21l-7-5-7 5V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2z"/></svg>
                </div>
                <div class="dt-alert-text">
                    <strong>Terlambat {{ $trx['terlambat_hari'] }} Hari</strong>
                    <p>Masa peminjaman telah habis. Anggota dikenakan denda keterlambatan.</p>
                </div>
                <div class="dt-alert-denda">
                    <span class="dt-alert-denda-label">Estimasi Denda</span>
                    <span class="dt-alert-denda-value">Rp {{ $trx['estimasi_denda'] }}</span>
                </div>
            </div>
        </div>
    </section>
    @endif

    {{-- ===== DAFTAR BUKU ===== --}}
    <section class="dt-books-section">
        <div class="dt-books-inner">
            <div class="dt-books-card">
                <div class="dt-books-head">
                    <h2 class="dt-books-title">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#2D7076" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>
                        Daftar Buku Terkait
                    </h2>
                    <span class="dt-books-count">{{ count($trx['buku']) }} ITEM</span>
                </div>

                <div class="dt-table-wrap">
                    <table class="dt-table">
                        <thead>
                            <tr>
                                <th>JUDUL BUKU</th>
                                <th>JUMLAH</th>
                                <th>STATUS ITEM</th>
                                <th>STATUS PENGEMBALIAN</th>
                                <th>AKSI</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($trx['buku'] as $buku)
                            <tr>
                                <td>
                                    <div class="dt-book">
                                        <img src="{{ asset('assets/' . $buku['cover']) }}" alt="{{ $buku['judul'] }}" class="dt-book-cover">
                                        <div>
                                            <span class="dt-book-judul">{{ $buku['judul'] }}</span>
                                            <span class="dt-book-isbn">ISBN: {{ $buku['isbn'] }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td><span class="dt-jumlah">{{ $buku['jumlah'] }}</span></td>
                                <td><span class="dt-item-status">{{ $buku['status_item'] }}</span></td>
                                <td>
                                    <span class="dt-kembali dt-kembali-{{ $buku['kembali_class'] }}">
                                        @if($buku['kembali_class'] === 'belum')
                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                                        @else
                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                                        @endif
                                        {{ $buku['status_kembali'] }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('informasi-buku-admin', ['id' => 1]) }}" class="dt-action" title="Lihat buku">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#2D7076" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
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
                <h4 class="footer-col-title">Menu Navigasi</h4>
                <ul>
                    <li><a href="{{ route('dashboard-admin') }}">Dashboard</a></li>
                    <li><a href="{{ route('riwayat-transaksi') }}">Transaksi</a></li>
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

    <script src="{{ asset('js/script-detail-transaksi.js') }}"></script>
</body>
</html>