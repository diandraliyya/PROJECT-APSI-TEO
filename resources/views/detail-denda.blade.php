@php
    $adminName = session('auth_name') ?? 'Admin';

    $anggota = $denda->anggota;
    $detail = $denda->detailTransaksi;
    $buku = optional($detail)->buku;
    $transaksi = optional($detail)->transaksi;
    $pembayaranDendas = $denda->pembayaranDendas ?? collect();

    $kodeDenda = 'FIN-' . str_pad($denda->id, 4, '0', STR_PAD_LEFT);

    $namaAnggota = optional($anggota)->nama_anggota ?? 'Anggota Tidak Ditemukan';
    $nisAnggota = optional($anggota)->nis ?? '-';
    $kelasAnggota = optional($anggota)->kelas ?? '-';

    $judulBuku = optional($buku)->judul_buku ?? 'Buku Tidak Ditemukan';
    $isbnBuku = optional($buku)->isbn ?? '-';

    $statusDenda = $denda->status_denda ?? 'belum_lunas';
    $isLunas = $statusDenda === 'lunas';

    $statusLabel = $isLunas ? 'Lunas' : 'Belum Lunas';
    $statusClass = $isLunas ? 'lunas' : 'belum';

    $totalDenda = $denda->total_denda ?? 0;

    $totalSudahValid = $pembayaranDendas
        ->where('status_validasi', 'valid')
        ->sum('nominal_bayar');

    $sisaDenda = max(0, $totalDenda - $totalSudahValid);

    $formatTanggal = function ($tanggal) {
        if (!$tanggal) {
            return '-';
        }

        return \Illuminate\Support\Carbon::parse($tanggal)->translatedFormat('d M Y');
    };

    $formatRupiah = function ($angka) {
        return 'Rp ' . number_format($angka ?? 0, 0, ',', '.');
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

    $tanggalKembali = optional($detail)->tanggal_kembali_item;
    $jatuhTempo = optional($transaksi)->tanggal_jatuh_tempo;
@endphp

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Denda #{{ $kodeDenda }} – Perpustakaan SMAIT Al-Uswah</title>
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

    {{-- ===== HEADER ===== --}}
    <section class="dd-header">
        <div class="dd-header-inner">
            <div class="dd-header-left">
                <span class="dd-eyebrow">Administrasi Denda</span>

                <div class="dd-title-row">
                    <h1 class="dd-title">Detail Denda</h1>

                    <span class="dd-status-badge badge-{{ $statusClass }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                        {{ $statusLabel }}
                    </span>
                </div>

                <p class="dd-id">
                    <span class="dd-id-hash">#</span> ID Denda: #{{ $kodeDenda }}
                </p>
            </div>

            <div class="dd-header-actions">
                <button type="button" class="btn-cetak" onclick="window.print()">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 6 2 18 2 18 9"/><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><rect x="6" y="14" width="12" height="8"/></svg>
                    Cetak Nota
                </button>
            </div>
        </div>
    </section>

    {{-- ===== FLASH MESSAGE ===== --}}
    @if (session('success') || session('error') || $errors->any())
        <section style="max-width:1120px; margin:20px auto 0; padding:0 24px;">
            @if (session('success'))
                <div style="background:#f0fff4; border:1px solid #a7e3b5; color:#24733b; padding:14px 18px; border-radius:14px;">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div style="background:#fff3f3; border:1px solid #f3b5b5; color:#9f2f2f; padding:14px 18px; border-radius:14px;">
                    {{ session('error') }}
                </div>
            @endif

            @if ($errors->any())
                <div style="background:#fff3f3; border:1px solid #f3b5b5; color:#9f2f2f; padding:14px 18px; border-radius:14px;">
                    <strong>Data pembayaran belum valid.</strong>
                    <ul style="margin:8px 0 0 18px;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </section>
    @endif

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
                    </div>

                    <div class="dd-anggota-grid">
                        <div class="dd-anggota-col">
                            <span class="dd-field-label">NAMA ANGGOTA</span>
                            <span class="dd-field-value accent">{{ $namaAnggota }}</span>
                        </div>

                        <div class="dd-anggota-col">
                            <span class="dd-field-label">NIS / KELAS</span>
                            <span class="dd-field-value">{{ $nisAnggota }} / {{ $kelasAnggota }}</span>
                        </div>
                    </div>

                    <div class="dd-buku-row">
                        <img src="{{ $coverUrl($buku) }}" alt="{{ $judulBuku }}" class="dd-buku-cover">

                        <div>
                            <span class="dd-field-label">BUKU TERLAMBAT</span>
                            <span class="dd-buku-judul">{{ $judulBuku }}</span>
                            <span class="dd-buku-isbn">ISBN: {{ $isbnBuku }}</span>

                            @if ($buku)
                                <br>
                                <a href="{{ url('/informasi-buku-admin/' . $buku->id) }}" style="font-size:12px; color:#2D7076; text-decoration:none;">
                                    Lihat detail buku
                                </a>
                            @endif
                        </div>
                    </div>

                    <div class="dd-stats-row">
                        <div class="dd-stat">
                            <span class="dd-stat-label">Tgl Kembali</span>
                            <span class="dd-stat-value">{{ $formatTanggal($tanggalKembali) }}</span>
                        </div>

                        <div class="dd-stat">
                            <span class="dd-stat-label">Jatuh Tempo</span>
                            <span class="dd-stat-value">{{ $formatTanggal($jatuhTempo) }}</span>
                        </div>

                        <div class="dd-stat dd-stat-red">
                            <span class="dd-stat-label">Terlambat</span>
                            <span class="dd-stat-value">{{ $denda->jumlah_hari_terlambat ?? 0 }} Hari</span>
                        </div>

                        <div class="dd-stat dd-stat-peach">
                            <span class="dd-stat-label">Tarif</span>
                            <span class="dd-stat-value">{{ $formatRupiah($denda->tarif_per_hari) }}/hr</span>
                        </div>
                    </div>

                    <div class="dd-total">
                        <div>
                            <span class="dd-total-label">Total Denda</span>
                            <span class="dd-total-value">{{ $formatRupiah($totalDenda) }}</span>
                        </div>

                        <div class="dd-total-ic">
                            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="5" width="20" height="14" rx="2"/><line x1="2" y1="10" x2="22" y2="10"/></svg>
                        </div>
                    </div>

                    <div style="margin-top:18px; display:grid; gap:8px; font-size:14px;">
                        <div><strong>Total sudah valid:</strong> {{ $formatRupiah($totalSudahValid) }}</div>
                        <div><strong>Sisa denda:</strong> {{ $formatRupiah($sisaDenda) }}</div>
                        <div><strong>Tanggal denda:</strong> {{ $formatTanggal($denda->tanggal_denda) }}</div>

                        @if ($transaksi)
                            <div>
                                <strong>Transaksi:</strong>
                                <a href="{{ url('/detail-transaksi/' . $transaksi->id) }}" style="color:#2D7076; text-decoration:none;">
                                    #{{ $transaksi->kode_transaksi }}
                                </a>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- RIWAYAT PEMBAYARAN --}}
                <div class="dd-info-card" style="margin-top:22px;">
                    <div class="dd-info-head">
                        <h2 class="dd-info-title">
                            Riwayat Pembayaran
                        </h2>
                    </div>

                    @forelse ($pembayaranDendas as $pembayaran)
                        @php
                            $statusBayar = $pembayaran->status_validasi ?? 'menunggu';

                            $statusBayarLabel = [
                                'menunggu' => 'Menunggu',
                                'valid' => 'Valid',
                                'ditolak' => 'Ditolak',
                            ][$statusBayar] ?? ucfirst($statusBayar);
                        @endphp

                        <div style="border:1px solid rgba(45,112,118,.15); border-radius:14px; padding:14px; margin-bottom:12px;">
                            <div style="display:flex; justify-content:space-between; gap:12px; flex-wrap:wrap;">
                                <div>
                                    <strong>{{ $formatRupiah($pembayaran->nominal_bayar) }}</strong>
                                    <br>
                                    <small>
                                        {{ $formatTanggal($pembayaran->tanggal_pembayaran) }}
                                        · {{ ucfirst($pembayaran->metode_pembayaran ?? '-') }}
                                    </small>
                                    <br>
                                    <small>Status: {{ $statusBayarLabel }}</small>

                                    @if ($pembayaran->keterangan)
                                        <br>
                                        <small>Catatan: {{ $pembayaran->keterangan }}</small>
                                    @endif
                                </div>

                                <div style="display:flex; gap:8px; align-items:center; flex-wrap:wrap;">
                                    @if ($statusBayar === 'menunggu')
                                        <form action="{{ url('/pembayaran-denda/' . $pembayaran->id . '/validasi') }}" method="POST">
                                            @csrf
                                            @method('PATCH')

                                            <button type="submit" class="btn-cetak" style="border:none; cursor:pointer;" onclick="return confirm('Validasi pembayaran ini?')">
                                                Validasi
                                            </button>
                                        </form>

                                        <form action="{{ url('/pembayaran-denda/' . $pembayaran->id . '/tolak') }}" method="POST">
                                            @csrf
                                            @method('PATCH')

                                            <button type="submit" class="btn-kembali" style="border:none; cursor:pointer;" onclick="return confirm('Tolak pembayaran ini?')">
                                                Tolak
                                            </button>
                                        </form>
                                    @else
                                        <span style="font-size:12px; color:#777;">{{ $statusBayarLabel }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <p style="font-size:14px; color:#777;">Belum ada riwayat pembayaran untuk denda ini.</p>
                    @endforelse
                </div>
            </div>

            {{-- RIGHT: Validasi Bayar --}}
            <div class="dd-right">
                <div class="dd-validasi-card">
                    <h2 class="dd-validasi-title">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#2D7076" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                        Validasi Bayar
                    </h2>

                    @if ($isLunas || $sisaDenda <= 0)
                        <div style="background:#f0fff4; border:1px solid #a7e3b5; color:#24733b; padding:14px 18px; border-radius:14px; margin-bottom:16px;">
                            Denda ini sudah lunas.
                        </div>

                        <a href="{{ url('/kelola-denda') }}" class="btn-kembali">Kembali</a>
                    @else
                        <form id="validasiForm" action="{{ url('/denda/' . $denda->id . '/pembayaran') }}" method="POST">
                            @csrf

                            <div class="dd-form-group">
                                <label for="tanggal_bayar">Tanggal Pembayaran</label>
                                <input type="date" id="tanggal_bayar" value="{{ now()->toDateString() }}" disabled>
                                <span class="dd-form-err">Tanggal pembayaran otomatis memakai tanggal hari ini.</span>
                            </div>

                            <div class="dd-form-group">
                                <label for="nominal_bayar">Nominal Bayar</label>
                                <div class="dd-input-prefix-wrap">
                                    <span class="dd-input-prefix">Rp</span>
                                    <input type="number" id="nominal_bayar" name="nominal_bayar" value="{{ old('nominal_bayar', $sisaDenda) }}" min="1" max="{{ $sisaDenda }}" required>
                                </div>
                                <span class="dd-form-err">@error('nominal_bayar') {{ $message }} @enderror</span>
                            </div>

                            <div class="dd-form-group">
                                <label for="metode_pembayaran">Metode Pembayaran</label>
                                <div class="dd-select-wrap">
                                    <select id="metode_pembayaran" name="metode_pembayaran" required>
                                        <option value="tunai" {{ old('metode_pembayaran', 'tunai') === 'tunai' ? 'selected' : '' }}>Tunai</option>
                                        <option value="transfer" {{ old('metode_pembayaran') === 'transfer' ? 'selected' : '' }}>Transfer Bank</option>
                                        <option value="qris" {{ old('metode_pembayaran') === 'qris' ? 'selected' : '' }}>QRIS</option>
                                        <option value="lainnya" {{ old('metode_pembayaran') === 'lainnya' ? 'selected' : '' }}>Lainnya</option>
                                    </select>

                                    <svg class="dd-select-arrow" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#2D7076" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg>
                                </div>
                                <span class="dd-form-err">@error('metode_pembayaran') {{ $message }} @enderror</span>
                            </div>

                            <div class="dd-form-group">
                                <label for="keterangan">Keterangan Tambahan</label>
                                <textarea id="keterangan" name="keterangan" rows="3" placeholder="Contoh: Dibayar tunai di meja perpustakaan.">{{ old('keterangan') }}</textarea>
                            </div>

                            <button type="submit" class="btn-tandai-lunas" onclick="return confirm('Simpan pembayaran denda sebesar {{ $formatRupiah($sisaDenda) }}?')">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                                Simpan Pembayaran
                            </button>
                        </form>

                        <form action="{{ url('/denda/' . $denda->id . '/lunasi') }}" method="POST" style="margin-top:12px;">
                            @csrf
                            @method('PATCH')

                            <button type="submit" class="btn-cetak" style="width:100%; border:none; cursor:pointer;" onclick="return confirm('Lunasi denda ini secara manual?')">
                                Lunasi Manual
                            </button>
                        </form>

                        <a href="{{ url('/kelola-denda') }}" class="btn-kembali" style="margin-top:12px;">Kembali</a>
                    @endif

                    <div class="dd-catatan">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#2D7076" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>
                        <div>
                            <strong>Catatan Pustakawan</strong>
                            <p>Pastikan nominal yang diterima sesuai sebelum menyimpan pembayaran. Pembayaran dari admin langsung dianggap valid.</p>
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
                <ul>
                    <li><a href="#">Kebijakan Perpustakaan</a></li>
                    <li><a href="#">Aturan Denda</a></li>
                </ul>
            </div>

            <div class="footer-col">
                <h4 class="footer-col-title">Layanan</h4>
                <ul>
                    <li><a href="{{ url('/kelola-denda') }}">Kelola Denda</a></li>
                    <li><a href="{{ url('/riwayat-transaksi') }}">Riwayat Transaksi</a></li>
                </ul>
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

    {{-- Script lama dummy dimatikan dulu --}}
    {{-- <script src="{{ asset('js/script-detail-denda.js') }}"></script> --}}
</body>
</html>