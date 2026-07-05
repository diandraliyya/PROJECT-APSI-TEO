<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Perpustakaan – SMAIT Al-Uswah</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style-home.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style-home-anggota.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style-home-admin.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style-laporan.css') }}">
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
                    <span class="nav-username">{{ session('auth_name') ?? 'Admin' }}</span>
                    <span class="nav-role">Administrator</span>
                </div>
            </a>
        </div>
    </header>

    {{-- ===== HERO ===== --}}
    <section class="lap-hero">
        <div class="lap-hero-inner">
            <div class="lap-hero-text">
                <span class="lap-eyebrow">Literasi Masa Depan</span>
                <h1 class="lap-title">Laporan Perpustakaan</h1>
                <p class="lap-desc">Pantau pertumbuhan literasi dan aktivitas perpustakaan dengan data yang akurat untuk menciptakan generasi pembelajaran yang unggul.</p>
            </div>
            <div class="lap-period-badge">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                <div>
                    <span class="period-label">Periode Saat Ini</span>
                    <span class="period-value" id="periodLabel">{{ \Carbon\Carbon::parse($tanggalMulai)->translatedFormat('F Y') }}</span>
                </div>
            </div>
        </div>
    </section>

    {{-- ===== FILTER ===== --}}
    <section class="lap-filter-section">
        <div class="lap-filter-inner">
            <form action="{{ url('/laporan') }}" method="GET" class="lap-filter-card" id="filterForm">
                <div class="lap-filter-title">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#2D7076" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="8" y1="6" x2="21" y2="6"/><line x1="8" y1="12" x2="21" y2="12"/><line x1="8" y1="18" x2="21" y2="18"/><line x1="3" y1="6" x2="3.01" y2="6"/><line x1="3" y1="12" x2="3.01" y2="12"/><line x1="3" y1="18" x2="3.01" y2="18"/></svg>
                    Filter Data Laporan
                </div>
                <div class="lap-filter-row">
                    <div class="lap-filter-field">
                        <label>Jenis Laporan</label>
                        <div class="lap-select-wrap">
                            <select id="jenisLaporan" name="jenis">
                                <option value="peminjaman" {{ $jenis == 'peminjaman' ? 'selected' : '' }}>Peminjaman</option>
                                <option value="buku_terpopuler" {{ $jenis == 'buku_terpopuler' ? 'selected' : '' }}>Buku Terpopuler</option>
                                <option value="anggota_aktif" {{ $jenis == 'anggota_aktif' ? 'selected' : '' }}>Anggota Aktif</option>
                                <option value="denda" {{ $jenis == 'denda' ? 'selected' : '' }}>Rekap Denda</option>
                            </select>
                            <svg class="lap-select-arrow" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#2D7076" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg>
                        </div>
                    </div>
                    <div class="lap-filter-field">
                        <label>Tanggal Awal</label>
                        <input type="date" id="tglAwal" name="tanggal_mulai" class="lap-date-input" value="{{ $tanggalMulai }}">
                    </div>
                    <div class="lap-filter-field">
                        <label>Tanggal Akhir</label>
                        <input type="date" id="tglAkhir" name="tanggal_selesai" class="lap-date-input" value="{{ $tanggalSelesai }}">
                    </div>
                    <button type="submit" class="btn-tampilkan" id="btnTampilkan">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                        Tampilkan Laporan
                    </button>
                </div>
                <span class="lap-filter-err hidden" id="filterErr">Tanggal awal tidak boleh lebih besar dari tanggal akhir.</span>
            </form>
        </div>
    </section>

    {{-- ===== STATS + CHART ===== --}}
    <section class="lap-stats-section">
        <div class="lap-stats-inner">

            {{-- Grafik Statistik --}}
            <div class="lap-chart-card">
                <div class="lap-chart-head">
                    <h2 class="lap-chart-title" id="chartTitle">{{ $chartTitle }}</h2>
                    <div class="lap-chart-legend">
                        <span class="legend-dot dot-fiksi"></span> {{ $chartLabel }}
                    </div>
                </div>
                <div class="lap-bar-chart" id="lapBarChart">
                    @php
                        $chartDataArray = $chartData['data'];
                        $maxValue = $chartData['maxValue'];
                        $bulanList = $chartData['bulanList'];
                        $isMonthly = in_array($jenis, ['peminjaman', 'denda']);
                    @endphp

                    @if($isMonthly)
                        @foreach($chartDataArray as $bulan => $total)
                            @php
                                $persen = round(($total / $maxValue) * 100);
                                $persen = $persen > 0 ? max($persen, 5) : 0;
                            @endphp
                            <div class="lap-bar-col">
                                <div class="lap-bar-group">
                                    <div class="lap-bar b-fiksi" style="--h:{{ $persen }}%;">
                                        @if($total > 0)
                                            <span class="lap-bar-value">{{ $jenis == 'denda' ? 'Rp' . number_format($total, 0, ',', '.') : $total }}</span>
                                        @endif
                                    </div>
                                </div>
                                <span>{{ $bulanList[$bulan - 1] }}</span>
                            </div>
                        @endforeach
                    @else
                        @php
                            $keys = array_keys($chartDataArray);
                            $values = array_values($chartDataArray);
                            $totalItems = count($keys);
                        @endphp

                        @for($i = 0; $i < $totalItems; $i++)
                            @php
                                $persen = round(($values[$i] / $maxValue) * 100);
                                $persen = $persen > 0 ? max($persen, 5) : 0;
                            @endphp
                            <div class="lap-bar-col">
                                <div class="lap-bar-group">
                                    <div class="lap-bar b-fiksi" style="--h:{{ $persen }}%;">
                                        @if($values[$i] > 0)
                                            <span class="lap-bar-value">{{ $values[$i] }}</span>
                                        @endif
                                    </div>
                                </div>
                                <span>{{ $keys[$i] }}</span>
                            </div>
                        @endfor
                    @endif
                </div>
            </div>

            {{-- Summary Cards --}}
            <div class="lap-summary-col">
                <div class="lap-sum-card sum-teal">
                    <div class="lap-sum-head">
                        <span class="lap-sum-label">Total Data</span>
                        <div class="lap-sum-ic">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="rgba(255,255,255,.6)" stroke-width="2"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>
                        </div>
                    </div>
                    <span class="lap-sum-value">{{ $dataLaporan->count() }}</span>
                    <span class="lap-sum-trend">Total {{ ucfirst(str_replace('_', ' ', $jenis)) }}</span>
                </div>

                <div class="lap-sum-card sum-mint">
                    <div class="lap-sum-head">
                        <span class="lap-sum-label">Periode</span>
                        <div class="lap-sum-ic ic-mint">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#2D7076" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                        </div>
                    </div>
                    <span class="lap-sum-value sum-val-dark">{{ \Carbon\Carbon::parse($tanggalMulai)->format('d/m/Y') }}</span>
                    <span class="lap-sum-trend trend-dark">s/d {{ \Carbon\Carbon::parse($tanggalSelesai)->format('d/m/Y') }}</span>
                </div>

                <div class="lap-sum-card sum-peach">
                    <div class="lap-sum-head">
                        <span class="lap-sum-label sum-label-dark">Status</span>
                        <div class="lap-sum-ic ic-peach">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#b8742f" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 8v4l3 3"/></svg>
                        </div>
                    </div>
                    <span class="lap-sum-value sum-val-brown">Aktif</span>
                    <span class="lap-sum-trend trend-dark">Laporan Siap</span>
                </div>
            </div>

        </div>
    </section>

    {{-- ===== TABEL DATA LAPORAN ===== --}}
    <section class="lap-table-section">
        <div class="lap-table-inner">
            <div class="lap-table-card">
                <div class="lap-table-head">
                    <div>
                        <h2 class="lap-table-title">Data Detail Laporan</h2>
                        <p class="lap-table-sub" id="tableInfo">Menampilkan {{ $dataLaporan->count() }} data</p>
                    </div>
                    <div class="lap-export-btns">
                        <form action="{{ url('/laporan/cetak') }}" method="POST" style="display:inline;">
                            @csrf
                            <input type="hidden" name="jenis_laporan" value="{{ $jenis }}">
                            <input type="hidden" name="periode_mulai" value="{{ $tanggalMulai }}">
                            <input type="hidden" name="periode_selesai" value="{{ $tanggalSelesai }}">
                            <input type="hidden" name="format_laporan" value="pdf">
                            <button type="submit" class="btn-export btn-pdf" id="btnExportPdf">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                                Export PDF
                            </button>
                        </form>
                        <form action="{{ url('/laporan/cetak') }}" method="POST" style="display:inline;">
                            @csrf
                            <input type="hidden" name="jenis_laporan" value="{{ $jenis }}">
                            <input type="hidden" name="periode_mulai" value="{{ $tanggalMulai }}">
                            <input type="hidden" name="periode_selesai" value="{{ $tanggalSelesai }}">
                            <input type="hidden" name="format_laporan" value="excel">
                            <button type="submit" class="btn-export btn-excel" id="btnExportExcel">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2"/><line x1="3" y1="9" x2="21" y2="9"/><line x1="3" y1="15" x2="21" y2="15"/><line x1="9" y1="3" x2="9" y2="21"/><line x1="15" y1="3" x2="15" y2="21"/></svg>
                                Export Excel
                            </button>
                        </form>
                    </div>
                </div>

                <div class="lap-table-wrap">
                    <table class="lap-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                @if($jenis == 'peminjaman')
                                    <th>Kode Transaksi</th>
                                    <th>Anggota</th>
                                    <th>Tanggal Pinjam</th>
                                    <th>Jatuh Tempo</th>
                                    <th>Status</th>
                                @elseif($jenis == 'buku_terpopuler')
                                    <th>Judul Buku</th>
                                    <th>Penulis</th>
                                    <th>Total Dipinjam</th>
                                @elseif($jenis == 'anggota_aktif')
                                    <th>No Anggota</th>
                                    <th>Nama Anggota</th>
                                    <th>Kelas</th>
                                    <th>Total Transaksi</th>
                                    <th>Status</th>
                                @elseif($jenis == 'denda')
                                    <th>Anggota</th>
                                    <th>Buku</th>
                                    <th>Hari Terlambat</th>
                                    <th>Total Denda</th>
                                    <th>Status</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody id="lapTbody">
                            @forelse($dataLaporan as $index => $item)
                                <tr>
                                    <td class="td-no">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</td>
                                    @if($jenis == 'peminjaman')
                                        <td><strong>{{ $item->kode_transaksi }}</strong></td>
                                        <td>{{ $item->anggota->nama_anggota ?? '-' }}</td>
                                        <td>{{ \Carbon\Carbon::parse($item->tanggal_pinjam)->format('d/m/Y') }}</td>
                                        <td>{{ \Carbon\Carbon::parse($item->tanggal_jatuh_tempo)->format('d/m/Y') }}</td>
                                        <td><span class="lap-avail {{ $item->status_transaksi == 'dikembalikan' ? 'avail-green' : 'avail-red' }}">{{ ucfirst($item->status_transaksi) }}</span></td>
                                    @elseif($jenis == 'buku_terpopuler')
                                        <td><strong>{{ $item->buku->judul_buku ?? '-' }}</strong></td>
                                        <td>{{ $item->buku->penulis ?? '-' }}</td>
                                        <td><span class="lap-pinjam">{{ $item->total_dipinjam }}</span></td>
                                    @elseif($jenis == 'anggota_aktif')
                                        <td>{{ $item->no_anggota ?? '-' }}</td>
                                        <td><strong>{{ $item->nama_anggota }}</strong></td>
                                        <td>{{ $item->kelas ?? '-' }}</td>
                                        <td><span class="lap-pinjam">{{ $item->transaksis_count }}</span></td>
                                        <td><span class="lap-avail avail-green">{{ ucfirst($item->status_anggota) }}</span></td>
                                    @elseif($jenis == 'denda')
                                        <td>{{ $item->anggota->nama_anggota ?? '-' }}</td>
                                        <td>{{ $item->detailTransaksi->buku->judul_buku ?? '-' }}</td>
                                        <td>{{ $item->jumlah_hari_terlambat }} hari</td>
                                        <td>Rp {{ number_format($item->total_denda, 0, ',', '.') }}</td>
                                        <td><span class="lap-avail {{ $item->status_denda == 'lunas' ? 'avail-green' : 'avail-red' }}">{{ ucfirst($item->status_denda) }}</span></td>
                                    @endif
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="10" style="text-align:center; padding:40px;">
                                        <p>Tidak ada data untuk periode ini.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

    {{-- ===== QUOTE SECTION ===== --}}
    <section class="lap-quote-section">
        <div class="lap-quote-inner">
            <h2 class="lap-quote-text">Membaca adalah<br>Jendela Dunia</h2>
            <div class="lap-quote-img">
                <img src="{{ asset('assets/icon buku.png') }}" alt="Ilustrasi buku" class="lap-quote-illustration">
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
                <ul><li><a href="#">Kebijakan Privasi</a></li><li><a href="#">Syarat &amp; Ketentuan</a></li></ul>
            </div>
            <div class="footer-col">
                <h4 class="footer-col-title">Bantuan</h4>
                <ul><li><a href="#">Pusat Bantuan</a></li><li><a href="#">Kontak Admin</a></li></ul>
            </div>
            <div class="footer-col">
                <h4 class="footer-col-title">Hubungi Kami</h4>
                <address>Jl. Al-Uswah No. 123, Surabaya<br>library@smait-aluswah.sch.id</address>
            </div>
        </div>
        <div class="footer-bottom">
            <p>© 2026 Perpustakaan SMAIT Al-Uswah. Dibuat dengan cinta untuk masa depan pendidikan.</p>
        </div>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Toast message dari session
            const toast = document.getElementById('toast');
            const toastMessage = @json(session('success') ?? session('error') ?? ($errors->any() ? 'Periksa kembali data yang diisi.' : null));

            if (toast && toastMessage) {
                toast.textContent = toastMessage;
                toast.classList.add('show');
                setTimeout(function () {
                    toast.classList.remove('show');
                }, 4000);
            }

            // ===== AUTO SUBMIT SAAT DROPDOWN BERUBAH =====
            const jenisSelect = document.getElementById('jenisLaporan');
            const filterForm = document.getElementById('filterForm');

            if (jenisSelect && filterForm) {
                jenisSelect.addEventListener('change', function () {
                    filterForm.submit();
                });
            }

            // ===== VALIDASI TANGGAL =====
            const tglAwal = document.getElementById('tglAwal');
            const tglAkhir = document.getElementById('tglAkhir');
            const filterErr = document.getElementById('filterErr');
            const btnTampilkan = document.getElementById('btnTampilkan');

            if (btnTampilkan && tglAwal && tglAkhir) {
                btnTampilkan.addEventListener('click', function (e) {
                    if (tglAwal.value && tglAkhir.value && tglAwal.value > tglAkhir.value) {
                        e.preventDefault();
                        filterErr.classList.remove('hidden');
                    } else {
                        filterErr.classList.add('hidden');
                    }
                });
            }

            // ===== PERBARUI PERIODE LABEL =====
            const periodLabel = document.getElementById('periodLabel');
            if (periodLabel && tglAwal) {
                const date = new Date(tglAwal.value + '-01');
                const bulan = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 
                               'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
                if (!isNaN(date.getMonth())) {
                    periodLabel.textContent = bulan[date.getMonth()] + ' ' + date.getFullYear();
                }
            }
        });
    </script>
</body>
</html>