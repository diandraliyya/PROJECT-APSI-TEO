@php
    $anggotaLogin = $anggota ?? null;

    $namaAnggota = optional($anggotaLogin)->nama_anggota ?? session('auth_name') ?? 'Anggota';
    $fotoAnggota = optional($anggotaLogin)->foto;

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

    $formatTanggal = function ($tanggal) {
        if (!$tanggal) {
            return '-';
        }

        return \Illuminate\Support\Carbon::parse($tanggal)->translatedFormat('d M Y');
    };

    $avatarInitial = strtoupper(substr($namaAnggota ?: 'A', 0, 1));

    $adaRiwayat = $transaksis->count() > 0;
@endphp

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Peminjaman – Perpustakaan SMAIT Al-Uswah</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style-home.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style-home-anggota.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style-riwayat-peminjaman.css') }}">
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
                        <div class="avatar-placeholder">{{ $avatarInitial }}</div>
                    @endif
                </div>
                <span class="nav-username">{{ $namaAnggota }}</span>
            </a>
        </div>
    </header>

    {{-- ===== HERO ===== --}}
    <section class="riwayat-hero">
        <div class="riwayat-hero-inner">
            <div class="riwayat-hero-img">
                <img src="{{ asset('assets/icon buku.png') }}" alt="Ilustrasi buku" class="riwayat-illustration">
            </div>
            <div class="riwayat-hero-text">
                <span class="riwayat-eyebrow">arsip membacamu</span>
                <h1 class="riwayat-title">Riwayat Peminjaman</h1>
                <p class="riwayat-desc">
                    Catatan setiap petualangan literasimu di SMAIT Al-Uswah. Pastikan untuk mengembalikan tepat waktu agar teman lain bisa ikut membaca!
                </p>
            </div>
        </div>
    </section>

    {{-- ===== TOGGLE KATEGORI ===== --}}
    <section class="riwayat-toggle-section">
        <div class="riwayat-toggle-inner">
            <button type="button" class="toggle-btn active" data-kondisi="dipinjam">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>
                Sedang Dipinjam
            </button>

            <button type="button" class="toggle-btn" data-kondisi="dikembalikan">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 3v5h5"/><path d="M3.05 13A9 9 0 1 0 6 5.3L3 8"/><polyline points="12 7 12 12 15 15"/></svg>
                Sudah Dikembalikan
            </button>
        </div>
    </section>

    {{-- ===== FILTER BAR ===== --}}
    <section class="riwayat-filter-section">
        <div class="riwayat-filter-inner">
            <div class="filter-bar">
                <div class="filter-field">
                    <label class="filter-label">URUTKAN</label>
                    <div class="select-wrap">
                        <select id="sortSelect" class="filter-select">
                            <option value="terbaru">Terbaru Dipinjam</option>
                            <option value="terlama">Terlama Dipinjam</option>
                            <option value="tempo">Jatuh Tempo Terdekat</option>
                            <option value="az">Judul A – Z</option>
                        </select>
                        <svg class="select-arrow" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#2D7076" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg>
                    </div>
                </div>

                <div class="filter-field">
                    <label class="filter-label">STATUS</label>
                    <div class="select-wrap">
                        <select id="statusSelect" class="filter-select">
                            <option value="">Semua Status</option>
                        </select>
                        <svg class="select-arrow" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#2D7076" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg>
                    </div>
                </div>

                <div class="filter-field filter-search">
                    <label class="filter-label">CARI BUKU</label>
                    <div class="search-input-wrap">
                        <input type="text" id="searchInput" class="filter-search-input" placeholder="Masukkan judul atau penulis...">
                        <svg class="search-ic" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#2D7076" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ===== LIST RIWAYAT ===== --}}
    <section class="riwayat-list-section">
        <div class="riwayat-list-inner" id="riwayatList">

            @forelse ($transaksis as $transaksi)
                @foreach ($transaksi->detailTransaksis as $detail)
                    @php
                        $buku = $detail->buku;

                        $judulBuku = optional($buku)->judul_buku ?? 'Buku Tidak Ditemukan';
                        $penulisBuku = optional($buku)->penulis ?? '-';

                        $tanggalPinjam = $transaksi->tanggal_pinjam
                            ? \Illuminate\Support\Carbon::parse($transaksi->tanggal_pinjam)
                            : null;

                        $tanggalJatuhTempo = $transaksi->tanggal_jatuh_tempo
                            ? \Illuminate\Support\Carbon::parse($transaksi->tanggal_jatuh_tempo)
                            : null;

                        $tanggalKembaliItem = $detail->tanggal_kembali_item
                            ? \Illuminate\Support\Carbon::parse($detail->tanggal_kembali_item)
                            : null;

                        $statusItem = $detail->status_item ?? 'dipinjam';

                        $belumKembali = !$tanggalKembaliItem && in_array($statusItem, ['dipinjam', 'terlambat']);

                        $kondisi = $belumKembali ? 'dipinjam' : 'dikembalikan';

                        $statusFilter = 'aman';
                        $statusBadge = 'Aman';
                        $statusSub = '-';
                        $borderClass = 'border-safe';
                        $badgeClass = 'badge-safe';
                        $tempoClass = '';
                        $iconClass = 'icon-mint';
                        $iconTitle = 'Detail';
                        $iconHref = $buku ? url('/informasi-buku/' . $buku->id) : url('/katalog-anggota');

                        if ($belumKembali) {
                            if ($tanggalJatuhTempo) {
                                $today = now()->startOfDay();
                                $tempo = $tanggalJatuhTempo->copy()->startOfDay();

                                if ($today->gt($tempo)) {
                                    $lewat = $tempo->diffInDays($today);

                                    $statusFilter = 'terlambat';
                                    $statusBadge = 'Terlambat';
                                    $statusSub = 'Lewat ' . $lewat . ' Hari';
                                    $borderClass = 'border-late';
                                    $badgeClass = 'badge-late';
                                    $tempoClass = 'tempo-late';
                                    $iconClass = 'icon-red';
                                    $iconTitle = 'Cek Denda';
                                    $iconHref = url('/status-denda');
                                } else {
                                    $sisa = $today->diffInDays($tempo);

                                    if ($sisa <= 3) {
                                        $statusFilter = 'hampir';
                                        $statusBadge = 'Hampir Jatuh Tempo';
                                        $statusSub = $sisa . ' Hari Lagi';
                                        $borderClass = 'border-warn';
                                        $badgeClass = 'badge-warn';
                                        $tempoClass = 'tempo-warn';
                                        $iconClass = 'icon-teal';
                                    } else {
                                        $statusFilter = 'aman';
                                        $statusBadge = 'Aman';
                                        $statusSub = $sisa . ' Hari Lagi';
                                        $borderClass = 'border-safe';
                                        $badgeClass = 'badge-safe';
                                        $tempoClass = '';
                                        $iconClass = 'icon-mint';
                                    }
                                }
                            }
                        } else {
                            $denda = $detail->denda;

                            if ($statusItem === 'terlambat') {
                                if ($denda && $denda->status_denda === 'lunas') {
                                    $statusFilter = 'lunas';
                                    $statusBadge = 'Terlambat (Lunas)';
                                    $statusSub = 'Denda Dibayar';
                                    $badgeClass = 'badge-lunas';
                                } else {
                                    $statusFilter = 'belum-lunas';
                                    $statusBadge = 'Terlambat';
                                    $statusSub = 'Denda Belum Lunas';
                                    $badgeClass = 'badge-late';
                                }
                            } else {
                                $statusFilter = 'tepat-waktu';
                                $statusBadge = 'Tepat Waktu';
                                $statusSub = 'Selesai';
                                $badgeClass = 'badge-returned';
                            }

                            $borderClass = 'border-returned';
                            $tempoClass = '';
                            $iconClass = 'icon-mint';
                            $iconTitle = 'Detail Buku';
                            $iconHref = $buku ? url('/informasi-buku/' . $buku->id) : url('/katalog-anggota');
                        }
                    @endphp

                    <div class="riwayat-item {{ $borderClass }}"
                        data-judul="{{ strtolower($judulBuku) }}"
                        data-penulis="{{ strtolower($penulisBuku) }}"
                        data-status="{{ $statusFilter }}"
                        data-tanggal="{{ $transaksi->tanggal_pinjam }}"
                        data-tempo="{{ $transaksi->tanggal_jatuh_tempo }}"
                        data-kondisi="{{ $kondisi }}">

                        <img src="{{ $coverUrl($buku) }}" alt="{{ $judulBuku }}" class="riwayat-cover">

                        <div class="riwayat-book">
                            <h3 class="riwayat-judul">{{ $judulBuku }}</h3>
                            <p class="riwayat-penulis">{{ $penulisBuku }}</p>
                            <small style="color:#777;">#{{ $transaksi->kode_transaksi }}</small>
                        </div>

                        <div class="riwayat-tanggal">
                            <span class="tgl-label">TANGGAL PINJAM</span>
                            <span class="tgl-value">{{ $formatTanggal($transaksi->tanggal_pinjam) }}</span>
                        </div>

                        <div class="riwayat-tanggal">
                            @if ($belumKembali)
                                <span class="tgl-label">JATUH TEMPO</span>
                                <span class="tgl-value {{ $tempoClass }}">{{ $formatTanggal($transaksi->tanggal_jatuh_tempo) }}</span>
                            @else
                                <span class="tgl-label">DIKEMBALIKAN</span>
                                <span class="tgl-value">{{ $formatTanggal($detail->tanggal_kembali_item) }}</span>
                            @endif
                        </div>

                        <div class="riwayat-status">
                            <span class="status-badge {{ $badgeClass }}">{{ $statusBadge }}</span>
                            <span class="status-sub {{ $statusFilter === 'terlambat' ? 'sub-late' : '' }}">{{ $statusSub }}</span>
                        </div>

                        <a href="{{ $iconHref }}" class="riwayat-icon {{ $iconClass }}" title="{{ $iconTitle }}">
                            @if ($statusFilter === 'terlambat')
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="5" width="20" height="14" rx="2"/><line x1="2" y1="10" x2="22" y2="10"/></svg>
                            @elseif ($kondisi === 'dikembalikan')
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#2D7076" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6 9 17l-5-5"/></svg>
                            @else
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#2D7076" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>
                            @endif
                        </a>
                    </div>
                @endforeach
            @empty
                {{-- kosong, ditangani empty state --}}
            @endforelse

            {{-- Empty state --}}
            <div class="riwayat-empty {{ $adaRiwayat ? 'hidden' : '' }}" id="riwayatEmpty">
                <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="#2D7076" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>
                <h3>Tidak ada riwayat ditemukan</h3>
                <p>Coba ubah filter atau kata kunci pencarianmu.</p>
            </div>

            @if ($transaksis->hasPages())
                <div style="display:flex; justify-content:center; gap:8px; margin-top:28px; flex-wrap:wrap;">
                    @if ($transaksis->onFirstPage())
                        <button disabled style="padding:9px 13px; border-radius:10px; border:1px solid #ddd;">‹</button>
                    @else
                        <a href="{{ $transaksis->previousPageUrl() }}" style="padding:9px 13px; border-radius:10px; border:1px solid #ddd; text-decoration:none; color:#2D7076;">‹</a>
                    @endif

                    @for ($i = 1; $i <= $transaksis->lastPage(); $i++)
                        @if ($i === $transaksis->currentPage())
                            <button style="padding:9px 13px; border-radius:10px; border:1px solid #2D7076; background:#2D7076; color:white;">{{ $i }}</button>
                        @else
                            <a href="{{ $transaksis->url($i) }}" style="padding:9px 13px; border-radius:10px; border:1px solid #ddd; text-decoration:none; color:#2D7076;">{{ $i }}</a>
                        @endif
                    @endfor

                    @if ($transaksis->hasMorePages())
                        <a href="{{ $transaksis->nextPageUrl() }}" style="padding:9px 13px; border-radius:10px; border:1px solid #ddd; text-decoration:none; color:#2D7076;">›</a>
                    @else
                        <button disabled style="padding:9px 13px; border-radius:10px; border:1px solid #ddd;">›</button>
                    @endif
                </div>
            @endif

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
    {{-- <script src="{{ asset('js/script-riwayat-peminjaman.js') }}"></script> --}}

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const toggleButtons = document.querySelectorAll('.toggle-btn');
            const statusSelect = document.getElementById('statusSelect');
            const sortSelect = document.getElementById('sortSelect');
            const searchInput = document.getElementById('searchInput');
            const list = document.getElementById('riwayatList');
            const empty = document.getElementById('riwayatEmpty');

            let activeKondisi = 'dipinjam';

            const statusOptions = {
                dipinjam: [
                    { value: '', label: 'Semua Status' },
                    { value: 'aman', label: 'Aman' },
                    { value: 'hampir', label: 'Hampir Jatuh Tempo' },
                    { value: 'terlambat', label: 'Terlambat' },
                ],
                dikembalikan: [
                    { value: '', label: 'Semua Status' },
                    { value: 'tepat-waktu', label: 'Tepat Waktu' },
                    { value: 'lunas', label: 'Terlambat Lunas' },
                    { value: 'belum-lunas', label: 'Terlambat Belum Lunas' },
                ],
            };

            function isiStatusOptions() {
                if (!statusSelect) return;

                statusSelect.innerHTML = statusOptions[activeKondisi].map(function (item) {
                    return `<option value="${item.value}">${item.label}</option>`;
                }).join('');
            }

            function applyFilter() {
                const keyword = String(searchInput?.value || '').toLowerCase();
                const selectedStatus = statusSelect?.value || '';
                const sortValue = sortSelect?.value || 'terbaru';

                const items = Array.from(document.querySelectorAll('.riwayat-item'));
                let visibleCount = 0;

                items.sort(function (a, b) {
                    if (sortValue === 'terbaru') {
                        return String(b.dataset.tanggal || '').localeCompare(String(a.dataset.tanggal || ''));
                    }

                    if (sortValue === 'terlama') {
                        return String(a.dataset.tanggal || '').localeCompare(String(b.dataset.tanggal || ''));
                    }

                    if (sortValue === 'tempo') {
                        return String(a.dataset.tempo || '').localeCompare(String(b.dataset.tempo || ''));
                    }

                    if (sortValue === 'az') {
                        return String(a.dataset.judul || '').localeCompare(String(b.dataset.judul || ''));
                    }

                    return 0;
                });

                items.forEach(function (item) {
                    list.insertBefore(item, empty);

                    const cocokKondisi = item.dataset.kondisi === activeKondisi;
                    const cocokStatus = !selectedStatus || item.dataset.status === selectedStatus;
                    const cocokSearch = !keyword
                        || String(item.dataset.judul || '').includes(keyword)
                        || String(item.dataset.penulis || '').includes(keyword);

                    const show = cocokKondisi && cocokStatus && cocokSearch;

                    item.style.display = show ? '' : 'none';

                    if (show) {
                        visibleCount++;
                    }
                });

                if (empty) {
                    if (visibleCount === 0) {
                        empty.classList.remove('hidden');
                        empty.style.display = 'block';
                    } else {
                        empty.classList.add('hidden');
                        empty.style.display = 'none';
                    }
                }
            }

            toggleButtons.forEach(function (button) {
                button.addEventListener('click', function () {
                    toggleButtons.forEach(function (btn) {
                        btn.classList.remove('active');
                    });

                    button.classList.add('active');
                    activeKondisi = button.dataset.kondisi;

                    isiStatusOptions();
                    applyFilter();
                });
            });

            statusSelect?.addEventListener('change', applyFilter);
            sortSelect?.addEventListener('change', applyFilter);
            searchInput?.addEventListener('input', applyFilter);

            isiStatusOptions();
            applyFilter();
        });
    </script>
</body>
</html>