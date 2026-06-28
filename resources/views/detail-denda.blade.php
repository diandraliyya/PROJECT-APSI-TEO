@php
    $dataDenda = [
        1 => [
            'id_denda'       => 'FIN-2026-0001',
            'status'         => 'Belum Lunas', 'status_class' => 'belum',
            'anggota'        => 'Ahmad Hidayat', 'nis' => '2122001', 'kelas' => 'X-A',
            'buku_judul'     => 'Laskar Pelangi', 'buku_isbn' => '979-3062-79-7', 'buku_cover' => 'Laskar_pelangi_sampul.jpg',
            'tgl_kembali'    => '12 Okt 26', 'jatuh_tempo' => '05 Okt 26',
            'terlambat_hari' => 5, 'tarif' => 'Rp 1.000/hr',
            'total_denda'    => '5.000,-', 'total_raw' => 5000,
        ],
        2 => [
            'id_denda'       => 'FIN-2026-0002',
            'status'         => 'Belum Lunas', 'status_class' => 'belum',
            'anggota'        => 'Siti Pertiwi', 'nis' => '2122045', 'kelas' => 'XII-C',
            'buku_judul'     => 'Dunia Sophie', 'buku_isbn' => '978-602-441-020-9', 'buku_cover' => 'dunia-sophie-sampul.jpg',
            'tgl_kembali'    => '28 Okt 26', 'jatuh_tempo' => '16 Okt 26',
            'terlambat_hari' => 12, 'tarif' => 'Rp 1.000/hr',
            'total_denda'    => '12.000,-', 'total_raw' => 12000,
        ],
        3 => [
            'id_denda'       => 'FIN-2026-0003',
            'status'         => 'Belum Lunas', 'status_class' => 'belum',
            'anggota'        => 'Bagas Nugroho', 'nis' => '2223015', 'kelas' => 'XI-B',
            'buku_judul'     => 'Sejarah Peradaban Islam', 'buku_isbn' => '979-421-337-3', 'buku_cover' => 'sejarah-peradaban-silam-sampul.png',
            'tgl_kembali'    => '10 Okt 26', 'jatuh_tempo' => '07 Okt 26',
            'terlambat_hari' => 3, 'tarif' => 'Rp 1.000/hr',
            'total_denda'    => '3.000,-', 'total_raw' => 3000,
        ],
    ];
    $id    = request()->route('id') ?? request('id') ?? 1;
    $denda = $dataDenda[$id] ?? $dataDenda[1];
@endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Denda #{{ $denda['id_denda'] }} – Perpustakaan SMAIT Al-Uswah</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style-home.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style-home-anggota.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style-home-admin.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style-detail-denda.css') }}">
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
                <a href="{{ route('riwayat-transaksi') }}" class="nav-link">Transaksi</a>
                <a href="{{ route('kelola-denda') }}" class="nav-link active">Denda</a>
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

    {{-- ===== HEADER ===== --}}
    <section class="dd-header">
        <div class="dd-header-inner">
            <div class="dd-header-left">
                <span class="dd-eyebrow">Petualangan Belajar</span>
                <div class="dd-title-row">
                    <h1 class="dd-title">Detail Denda</h1>
                    <span class="dd-status-badge badge-{{ $denda['status_class'] }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                        {{ $denda['status'] }}
                    </span>
                </div>
                <p class="dd-id"><span class="dd-id-hash">#</span> ID Denda: #{{ $denda['id_denda'] }}</p>
            </div>
            <div class="dd-header-actions">
                <button class="btn-cetak" id="btnCetak">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 6 2 18 2 18 9"/><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><rect x="6" y="14" width="12" height="8"/></svg>
                    Cetak Nota
                </button>
            </div>
        </div>
    </section>

    {{-- ===== MAIN GRID ===== --}}
    <section class="dd-main">
        <div class="dd-main-inner">

            {{-- LEFT: Informasi Peminjam --}}
            <div class="dd-left">
                <div class="dd-info-card">
                    <div class="dd-info-head">
                        <h2 class="dd-info-title">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#b8742f" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                            Informasi Peminjam
                        </h2>
                        <button class="btn-expand" id="btnExpand" title="Lihat lebih">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#2D7076" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 3 21 3 21 9"/><polyline points="9 21 3 21 3 15"/><line x1="21" y1="3" x2="14" y2="10"/><line x1="3" y1="21" x2="10" y2="14"/></svg>
                        </button>
                    </div>

                    <div class="dd-anggota-grid">
                        <div class="dd-anggota-col">
                            <span class="dd-field-label">NAMA ANGGOTA</span>
                            <span class="dd-field-value accent">{{ $denda['anggota'] }}</span>
                        </div>
                        <div class="dd-anggota-col">
                            <span class="dd-field-label">NIS / KELAS</span>
                            <span class="dd-field-value">{{ $denda['nis'] }} / {{ $denda['kelas'] }}</span>
                        </div>
                    </div>

                    <div class="dd-buku-row">
                        <img src="{{ asset('assets/' . $denda['buku_cover']) }}" alt="{{ $denda['buku_judul'] }}" class="dd-buku-cover">
                        <div>
                            <span class="dd-field-label">BUKU TERLAMBAT</span>
                            <span class="dd-buku-judul">{{ $denda['buku_judul'] }}</span>
                            <span class="dd-buku-isbn">ISBN: {{ $denda['buku_isbn'] }}</span>
                        </div>
                    </div>

                    <div class="dd-stats-row">
                        <div class="dd-stat">
                            <span class="dd-stat-label">Tgl Kembali</span>
                            <span class="dd-stat-value">{{ $denda['tgl_kembali'] }}</span>
                        </div>
                        <div class="dd-stat">
                            <span class="dd-stat-label">Jatuh Tempo</span>
                            <span class="dd-stat-value">{{ $denda['jatuh_tempo'] }}</span>
                        </div>
                        <div class="dd-stat dd-stat-red">
                            <span class="dd-stat-label">Terlambat</span>
                            <span class="dd-stat-value">{{ $denda['terlambat_hari'] }} Hari</span>
                        </div>
                        <div class="dd-stat dd-stat-peach">
                            <span class="dd-stat-label">Tarif</span>
                            <span class="dd-stat-value">{{ $denda['tarif'] }}</span>
                        </div>
                    </div>

                    <div class="dd-total">
                        <div>
                            <span class="dd-total-label">Total Denda</span>
                            <span class="dd-total-value">Rp {{ $denda['total_denda'] }}</span>
                        </div>
                        <div class="dd-total-ic">
                            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="5" width="20" height="14" rx="2"/><line x1="2" y1="10" x2="22" y2="10"/></svg>
                        </div>
                    </div>
                </div>
            </div>

            {{-- RIGHT: Validasi Bayar --}}
            <div class="dd-right">
                <div class="dd-validasi-card">
                    <h2 class="dd-validasi-title">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#2D7076" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                        Validasi Bayar
                    </h2>

                    <form id="validasiForm" novalidate>
                        <div class="dd-form-group">
                            <label for="tgl_bayar">Tanggal Pembayaran</label>
                            <input type="date" id="tgl_bayar" name="tgl_bayar" value="{{ date('Y-m-d') }}">
                            <span class="dd-form-err" id="err-tgl"></span>
                        </div>

                        <div class="dd-form-group">
                            <label for="nominal_bayar">Nominal Bayar</label>
                            <div class="dd-input-prefix-wrap">
                                <span class="dd-input-prefix">Rp</span>
                                <input type="number" id="nominal_bayar" name="nominal_bayar" placeholder="{{ $denda['total_raw'] }}" min="0">
                            </div>
                            <span class="dd-form-err" id="err-nominal"></span>
                        </div>

                        <div class="dd-form-group">
                            <label for="metode">Metode Pembayaran</label>
                            <div class="dd-select-wrap">
                                <select id="metode" name="metode">
                                    <option value="tunai" selected>Tunai</option>
                                    <option value="transfer">Transfer Bank</option>
                                    <option value="qris">QRIS</option>
                                </select>
                                <svg class="dd-select-arrow" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#2D7076" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg>
                            </div>
                        </div>

                        <div class="dd-form-group">
                            <label for="keterangan">Keterangan Tambahan</label>
                            <textarea id="keterangan" name="keterangan" rows="3" placeholder="Contoh: Dibayar pas istirahat pertama..."></textarea>
                        </div>

                        <button type="submit" class="btn-tandai-lunas">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                            Tandai Lunas
                        </button>

                        <a href="{{ route('kelola-denda') }}" class="btn-kembali">Kembali</a>
                    </form>

                    <div class="dd-catatan">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#2D7076" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>
                        <div>
                            <strong>Catatan Pustakawan</strong>
                            <p>Pastikan nominal yang diterima sesuai sebelum menekan tombol "Tandai Lunas". Struk fisik harus tetap diarsipkan.</p>
                        </div>
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
                <ul><li><a href="#">Kebijakan Perpustakaan</a></li><li><a href="#">Aturan Denda</a></li></ul>
            </div>
            <div class="footer-col">
                <h4 class="footer-col-title">Layanan</h4>
                <ul><li><a href="#">Jam Operasional</a></li><li><a href="#">Hubungi Kami</a></li></ul>
            </div>
            <div class="footer-col">
                <h4 class="footer-col-title">Hubungi Kami</h4>
                <address>Jl. Al-Uswah No. 123, Surabaya<br>library@smait-aluswah.sch.id</address>
            </div>
        </div>
        <div class="footer-bottom">
            <p>© 2026 Perpustakaan SMAIT Al-Uswah. Menjaga Tradisi, Membangun Literasi.</p>
        </div>
    </footer>

    <script src="{{ asset('js/script-detail-denda.js') }}"></script>
</body>
</html>