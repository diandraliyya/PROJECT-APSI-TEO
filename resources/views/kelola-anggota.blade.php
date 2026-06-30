@php
    $adminName = session('auth_name') ?? 'Admin';

    $search = $search ?? request('search');
    $kelas = $kelas ?? request('kelas');
    $status = $status ?? request('status');

    $kelasList = collect($kelasList ?? []);

    $avatarClasses = ['av-teal', 'av-orange', 'av-purple', 'av-mint'];

    $initials = function ($nama) {
        $nama = trim($nama ?: 'Anggota');
        $parts = preg_split('/\s+/', $nama);

        $first = strtoupper(substr($parts[0] ?? 'A', 0, 1));
        $second = strtoupper(substr($parts[1] ?? '', 0, 1));

        return $first . $second;
    };

    $fotoUrl = function ($anggota) {
        if (empty($anggota->foto)) {
            return null;
        }

        if (str_starts_with($anggota->foto, 'http://') || str_starts_with($anggota->foto, 'https://')) {
            return $anggota->foto;
        }

        if (str_starts_with($anggota->foto, 'assets/')) {
            return asset($anggota->foto);
        }

        return asset('storage/' . $anggota->foto);
    };

    $formatTanggal = function ($tanggal) {
        if (!$tanggal) {
            return '-';
        }

        return \Illuminate\Support\Carbon::parse($tanggal)->translatedFormat('d M Y');
    };

    $statusClass = [
        'aktif' => 'st-aktif',
        'nonaktif' => 'st-nonaktif',
        'lulus' => 'st-nonaktif',
    ];

    $statusPendaftaranLabel = [
        'menunggu' => 'Menunggu',
        'disetujui' => 'Disetujui',
        'ditolak' => 'Ditolak',
    ];
@endphp

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengelolaan Anggota – Perpustakaan SMAIT Al-Uswah</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style-home.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style-home-anggota.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style-home-admin.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style-kelola-anggota.css') }}">
</head>
<body class="admin-page">

    {{-- ===== NAVBAR ===== --}}
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
                <a href="{{ url('/kelola-anggota') }}" class="nav-link active">Anggota</a>
                <a href="{{ url('/riwayat-transaksi') }}" class="nav-link">Transaksi</a>
                <a href="{{ url('/kelola-denda') }}" class="nav-link">Denda</a>
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
    <section class="ka-hero">
        <div class="ka-hero-inner">
            <div class="ka-hero-left">
                <span class="ka-eyebrow">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#b8742f" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                    Panel Admin
                </span>
                <h1 class="ka-title">Pengelolaan Anggota</h1>
                <p class="ka-desc">Kelola data keanggotaan santri dan guru dengan mudah.</p>
            </div>

            <div class="ka-hero-right">
                <div class="ka-hero-ic">
                    <svg xmlns="http://www.w3.org/2000/svg" width="52" height="52" viewBox="0 0 24 24" fill="none" stroke="rgba(45,112,118,.2)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 7V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v2"/><line x1="12" y1="12" x2="12" y2="16"/><line x1="10" y1="14" x2="14" y2="14"/></svg>
                </div>

                <a href="{{ url('/tambah-anggota') }}" class="btn-tambah-anggota">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="8.5" cy="7" r="4"/><line x1="20" y1="8" x2="20" y2="14"/><line x1="23" y1="11" x2="17" y2="11"/></svg>
                    Tambah Anggota
                </a>
            </div>
        </div>
    </section>

    {{-- ===== FILTER ===== --}}
    <section class="ka-filter-section">
        <div class="ka-filter-inner">
            <form action="{{ url('/kelola-anggota') }}" method="GET" class="ka-filter-bar">

                {{-- Search --}}
                <div class="ka-search-wrap">
                    <svg class="ka-search-ic" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#2D7076" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                    <input type="text" id="searchInput" name="search" value="{{ $search }}" class="ka-search" placeholder="Cari NIS, nama, email, atau nomor anggota...">
                </div>

                {{-- Filter Kelas --}}
                <div class="ka-select-wrap">
                    <svg class="ka-select-ic" xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#2D7076" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 10v6M2 10l10-5 10 5-10 5z"/></svg>
                    <select id="kelasSelect" name="kelas" class="ka-select" onchange="this.form.submit()">
                        <option value="">Semua Kelas</option>
                        @foreach ($kelasList as $itemKelas)
                            <option value="{{ $itemKelas }}" {{ $kelas === $itemKelas ? 'selected' : '' }}>
                                {{ $itemKelas }}
                            </option>
                        @endforeach
                    </select>
                    <svg class="ka-select-arrow" xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#2D7076" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg>
                </div>

                {{-- Filter Status --}}
                <div class="ka-select-wrap">
                    <svg class="ka-select-ic" xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#2D7076" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                    <select id="statusSelect" name="status" class="ka-select" onchange="this.form.submit()">
                        <option value="">Semua Status</option>
                        <option value="aktif" {{ $status === 'aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="nonaktif" {{ $status === 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                        <option value="lulus" {{ $status === 'lulus' ? 'selected' : '' }}>Lulus</option>
                    </select>
                    <svg class="ka-select-arrow" xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#2D7076" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg>
                </div>

                <button type="submit" class="btn-sort" id="btnSort" title="Cari">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#2D7076" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                </button>

                @if ($search || $kelas || $status)
                    <a href="{{ url('/kelola-anggota') }}" class="btn-sort" title="Reset Filter">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#c0392b" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                    </a>
                @endif

            </form>
        </div>
    </section>

    {{-- ===== TABEL ANGGOTA ===== --}}
    <section class="ka-table-section">
        <div class="ka-table-inner">
            <div class="ka-table-card">

                <div class="ka-table-head">
                    <h2 class="ka-table-title">Daftar Anggota</h2>
                    <div class="ka-table-actions">
                        <button type="button" class="ka-action-btn" id="btnExport" title="Unduh data">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                        </button>
                        <button type="button" class="ka-action-btn" id="btnPrint" title="Cetak" onclick="window.print()">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 6 2 18 2 18 9"/><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><rect x="6" y="14" width="12" height="8"/></svg>
                        </button>
                    </div>
                </div>

                <div class="ka-table-wrap">
                    <table class="ka-table">
                        <thead>
                            <tr>
                                <th>FOTO</th>
                                <th>NIS / NO. ANGGOTA</th>
                                <th>NAMA LENGKAP</th>
                                <th>KELAS</th>
                                <th>EMAIL</th>
                                <th>STATUS</th>
                                <th>TERDAFTAR</th>
                                <th>AKSI</th>
                            </tr>
                        </thead>

                        <tbody id="anggotaTbody">
                            @forelse ($anggotas as $anggota)
                                @php
                                    $namaAnggota = $anggota->nama_anggota ?? 'Anggota';
                                    $inisial = $initials($namaAnggota);
                                    $foto = $fotoUrl($anggota);
                                    $avatarClass = $avatarClasses[$loop->index % count($avatarClasses)];

                                    $statusAnggota = $anggota->status_anggota ?? 'nonaktif';
                                    $labelStatusAnggota = ucfirst($statusAnggota);
                                    $classStatusAnggota = $statusClass[$statusAnggota] ?? 'st-nonaktif';

                                    $statusPendaftaran = $anggota->status_pendaftaran ?? '-';
                                    $labelPendaftaran = $statusPendaftaranLabel[$statusPendaftaran] ?? ucfirst($statusPendaftaran);

                                    $totalPinjam = $anggota->transaksis_count ?? 0;
                                    $pinjamAktif = $anggota->transaksi_aktif_count ?? 0;
                                    $totalDenda = $anggota->total_denda_belum_lunas ?? 0;
                                @endphp

                                <tr class="ka-row"
                                    data-nis="{{ strtolower($anggota->nis ?? '') }}"
                                    data-nama="{{ strtolower($namaAnggota) }}"
                                    data-kelas="{{ $anggota->kelas ?? '-' }}"
                                    data-status="{{ $statusAnggota }}"
                                    data-tgl="{{ $anggota->tanggal_daftar ?? $anggota->created_at }}"
                                >
                                    <td>
                                        @if ($foto)
                                            <img src="{{ $foto }}" alt="{{ $namaAnggota }}" class="ka-avatar" style="object-fit: cover;">
                                        @else
                                            <div class="ka-avatar {{ $avatarClass }}">{{ $inisial }}</div>
                                        @endif
                                    </td>

                                    <td class="ka-nis">
                                        <span>{{ $anggota->nis ?? '-' }}</span>
                                        <br>
                                        <small>{{ $anggota->no_anggota ?? 'Belum ada nomor' }}</small>
                                    </td>

                                    <td class="ka-nama">
                                        {{ $namaAnggota }}
                                        <br>
                                        <small>Username: {{ $anggota->username ?? '-' }}</small>
                                    </td>

                                    <td>{{ $anggota->kelas ?? '-' }}</td>

                                    <td class="ka-email">{{ $anggota->email ?? '-' }}</td>

                                    <td>
                                        <span class="ka-status {{ $classStatusAnggota }}">{{ $labelStatusAnggota }}</span>
                                        <br>
                                        <small>Pendaftaran: {{ $labelPendaftaran }}</small>
                                    </td>

                                    <td class="ka-tgl">{{ $formatTanggal($anggota->tanggal_daftar ?? $anggota->created_at) }}</td>

                                    <td>
                                        <div class="ka-aksi">
                                            <button type="button"
                                                class="ka-btn-aksi btn-lihat"
                                                title="Lihat Detail"
                                                onclick="bukaDetailAnggota(
                                                    '{{ addslashes($namaAnggota) }}',
                                                    '{{ addslashes($anggota->nis ?? '-') }}',
                                                    '{{ addslashes($anggota->no_anggota ?? '-') }}',
                                                    '{{ addslashes($anggota->kelas ?? '-') }}',
                                                    '{{ addslashes($anggota->email ?? '-') }}',
                                                    '{{ addslashes($anggota->no_hp ?? '-') }}',
                                                    '{{ addslashes($anggota->alamat ?? '-') }}',
                                                    '{{ addslashes($labelStatusAnggota) }}',
                                                    '{{ addslashes($labelPendaftaran) }}',
                                                    '{{ $totalPinjam }}',
                                                    '{{ $pinjamAktif }}',
                                                    'Rp {{ number_format($totalDenda, 0, ',', '.') }}'
                                                )">
                                                👁
                                            </button>

                                            @if ($anggota->status_pendaftaran === 'menunggu')
                                                <form action="{{ url('/anggota/' . $anggota->id . '/approve') }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="ka-btn-aksi btn-aktifkan" title="Setujui Pendaftaran" onclick="return confirm('Setujui pendaftaran {{ addslashes($namaAnggota) }}?')">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                                                    </button>
                                                </form>

                                                <form action="{{ url('/anggota/' . $anggota->id . '/reject') }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="ka-btn-aksi btn-nonaktif" title="Tolak Pendaftaran" onclick="return confirm('Tolak pendaftaran {{ addslashes($namaAnggota) }}?')">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="4.93" y1="4.93" x2="19.07" y2="19.07"/></svg>
                                                    </button>
                                                </form>
                                            @endif

                                            @if ($anggota->status_anggota === 'aktif')
                                                <form action="{{ url('/anggota/' . $anggota->id . '/deactivate') }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="ka-btn-aksi btn-nonaktif" title="Nonaktifkan" onclick="return confirm('Nonaktifkan anggota {{ addslashes($namaAnggota) }}?')">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="4.93" y1="4.93" x2="19.07" y2="19.07"/></svg>
                                                    </button>
                                                </form>
                                            @else
                                                <form action="{{ url('/anggota/' . $anggota->id . '/activate') }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="ka-btn-aksi btn-aktifkan" title="Aktifkan" onclick="return confirm('Aktifkan anggota {{ addslashes($namaAnggota) }}?')">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                                                    </button>
                                                </form>
                                            @endif

                                            <form action="{{ url('/anggota/' . $anggota->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="ka-btn-aksi btn-nonaktif" title="Hapus Anggota" onclick="return confirm('Hapus anggota {{ addslashes($namaAnggota) }}? Anggota yang sudah punya riwayat transaksi tidak bisa dihapus.')">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" style="text-align:center; padding: 32px;">
                                        Tidak ada anggota yang cocok.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="ka-empty" id="kaEmpty" style="{{ $anggotas->count() > 0 ? 'display:none;' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="#2D7076" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
                    <p>Tidak ada anggota yang cocok.</p>
                </div>

                <div class="ka-table-footer">
                    <span class="ka-info" id="kaInfo">
                        @if ($anggotas->total() > 0)
                            Menampilkan {{ $anggotas->firstItem() }}–{{ $anggotas->lastItem() }} dari {{ $anggotas->total() }} anggota
                        @else
                            Menampilkan 0 anggota
                        @endif
                    </span>

                    <div class="ka-pagination">
                        @if ($anggotas->onFirstPage())
                            <button class="ka-page-btn" disabled>
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
                            </button>
                        @else
                            <a href="{{ $anggotas->previousPageUrl() }}" class="ka-page-btn">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
                            </a>
                        @endif

                        @for ($i = 1; $i <= $anggotas->lastPage(); $i++)
                            @if ($i === $anggotas->currentPage())
                                <button class="ka-page-btn active" data-page="{{ $i }}">{{ $i }}</button>
                            @else
                                <a href="{{ $anggotas->url($i) }}" class="ka-page-btn" data-page="{{ $i }}">{{ $i }}</a>
                            @endif
                        @endfor

                        @if ($anggotas->hasMorePages())
                            <a href="{{ $anggotas->nextPageUrl() }}" class="ka-page-btn">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
                            </a>
                        @else
                            <button class="ka-page-btn" disabled>
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
                            </button>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </section>

    {{-- ===== MODAL DETAIL ANGGOTA ===== --}}
    <div class="da-modal" id="daModal">
        <div class="da-modal-inner">

            <div class="da-modal-head">
                <h3 class="da-modal-title">Detail Anggota</h3>
                <button type="button" class="da-modal-close" id="daModalClose" aria-label="Tutup">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                </button>
            </div>

            <div class="da-profil">
                <div class="da-profil-avatar" id="daAvatar">A</div>
                <div class="da-profil-info">
                    <h4 class="da-profil-nama" id="daNama">Nama Anggota</h4>
                    <span class="da-profil-nis" id="daNis">NIS: -</span>
                    <span class="da-profil-kelas" id="daKelas">-</span>
                    <span class="da-profil-email" id="daEmail">-</span>
                    <span class="da-profil-email" id="daNoHp">-</span>
                    <span class="da-profil-email" id="daAlamat">-</span>
                </div>
                <span class="da-profil-status" id="daStatus">-</span>
            </div>

            <div class="da-stats">
                <div class="da-stat">
                    <span class="da-stat-val" id="daTotalPinjam">0</span>
                    <span class="da-stat-lbl">Total Pinjam</span>
                </div>
                <div class="da-stat">
                    <span class="da-stat-val" id="daAktifPinjam">0</span>
                    <span class="da-stat-lbl">Sedang Dipinjam</span>
                </div>
                <div class="da-stat">
                    <span class="da-stat-val denda-val" id="daTotalDenda">Rp 0</span>
                    <span class="da-stat-lbl">Denda Belum Lunas</span>
                </div>
            </div>

            <div class="da-tabs">
                <button type="button" class="da-tab active" data-tab="pinjam">Info Anggota</button>
                <button type="button" class="da-tab" data-tab="denda">Status Pendaftaran</button>
            </div>

            <div class="da-tab-body" id="tabPinjam">
                <ul class="da-pinjam-list" id="daPinjamList">
                    <li>No anggota: <span id="daNoAnggota">-</span></li>
                    <li>Total transaksi akan dihitung otomatis dari data peminjaman.</li>
                </ul>
            </div>

            <div class="da-tab-body hidden" id="tabDenda">
                <ul class="da-denda-list" id="daDendaList">
                    <li>Status pendaftaran: <span id="daPendaftaran">-</span></li>
                </ul>
            </div>

        </div>
    </div>

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
                    <a href="#" class="social-btn" aria-label="Instagram"><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"/><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/></svg></a>
                    <a href="#" class="social-btn" aria-label="Email"><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,12 2,6"/></svg></a>
                </div>
            </div>

            <div class="footer-col">
                <h4 class="footer-col-title">Quick Links</h4>
                <ul>
                    <li><a href="{{ url('/dashboard-admin') }}">Dashboard Admin</a></li>
                    <li><a href="{{ url('/tambah-anggota') }}">Tambah Anggota</a></li>
                    <li><a href="{{ url('/input-peminjaman') }}">Input Peminjaman</a></li>
                </ul>
            </div>

            <div class="footer-col">
                <h4 class="footer-col-title">Kontak</h4>
                <ul>
                    <li>library@uswah.sch.id</li>
                    <li>+62 31 123 4567</li>
                </ul>
            </div>

            <div class="footer-col">
                <h4 class="footer-col-title">Jam Operasional</h4>
                <address>Senin – Jumat: 07:00–16:00<br>Sabtu: 08:00–12:00</address>
            </div>
        </div>

        <div class="footer-bottom">
            <p>© 2026 Perpustakaan SMAIT Al-Uswah. Menjaga Tradisi, Membangun Literasi.</p>
        </div>
    </footer>

    {{-- Script lama dummy tidak dipakai dulu --}}
    {{-- <script src="{{ asset('js/script-kelola-anggota.js') }}"></script> --}}

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const toast = document.getElementById('toast');
            const toastMessage = @json(session('success') ?? session('error') ?? ($errors->any() ? 'Periksa kembali data anggota.' : null));

            if (toast && toastMessage) {
                toast.textContent = toastMessage;
                toast.classList.add('show');

                setTimeout(function () {
                    toast.classList.remove('show');
                }, 3000);
            }

            const searchInput = document.getElementById('searchInput');

            if (searchInput) {
                searchInput.addEventListener('keydown', function (event) {
                    if (event.key === 'Enter') {
                        event.preventDefault();
                        this.closest('form').submit();
                    }
                });
            }

            const detailButtons = document.querySelectorAll('.btn-detail-anggota');
            const modal = document.getElementById('daModal');
            const closeBtn = document.getElementById('daModalClose');

            function setText(id, value) {
                const el = document.getElementById(id);

                if (el) {
                    el.textContent = value || '-';
                }
            }

            function openModal() {
                if (modal) {
                    modal.style.display = 'flex';
                    modal.classList.add('show');
                }
            }

            function closeModal() {
                if (modal) {
                    modal.style.display = 'none';
                    modal.classList.remove('show');
                }
            }

            if (modal) {
                modal.style.display = 'none';
            }

            detailButtons.forEach(function (button) {
                button.addEventListener('click', function () {
                    setText('daAvatar', button.dataset.inisial);
                    setText('daNama', button.dataset.nama);
                    setText('daNis', 'NIS: ' + (button.dataset.nis || '-'));
                    setText('daKelas', button.dataset.kelas);
                    setText('daEmail', button.dataset.email);
                    setText('daNoHp', 'No HP: ' + (button.dataset.noHp || '-'));
                    setText('daAlamat', 'Alamat: ' + (button.dataset.alamat || '-'));
                    setText('daStatus', button.dataset.status);
                    setText('daTotalPinjam', button.dataset.totalPinjam);
                    setText('daAktifPinjam', button.dataset.aktifPinjam);
                    setText('daTotalDenda', button.dataset.totalDenda);
                    setText('daNoAnggota', button.dataset.noAnggota);
                    setText('daPendaftaran', button.dataset.pendaftaran);

                    openModal();
                });
            });

            if (closeBtn) {
                closeBtn.addEventListener('click', closeModal);
            }

            if (modal) {
                modal.addEventListener('click', function (event) {
                    if (event.target === modal) {
                        closeModal();
                    }
                });
            }

            const tabButtons = document.querySelectorAll('.da-tab');
            const tabPinjam = document.getElementById('tabPinjam');
            const tabDenda = document.getElementById('tabDenda');

            tabButtons.forEach(function (button) {
                button.addEventListener('click', function () {
                    tabButtons.forEach(function (btn) {
                        btn.classList.remove('active');
                    });

                    button.classList.add('active');

                    if (button.dataset.tab === 'pinjam') {
                        tabPinjam?.classList.remove('hidden');
                        tabDenda?.classList.add('hidden');
                    } else {
                        tabPinjam?.classList.add('hidden');
                        tabDenda?.classList.remove('hidden');
                    }
                });
            });

            const btnExport = document.getElementById('btnExport');

            if (btnExport) {
                btnExport.addEventListener('click', function () {
                    alert('Export anggota bisa dibuat nanti di fitur laporan.');
                });
            }
        });
    </script>

    <script>
        function setDetailText(id, value) {
            const element = document.getElementById(id);

            if (element) {
                element.textContent = value || '-';
            }
        }

        function showDetailAnggota(button) {
            const modal = document.getElementById('daModal');

            setDetailText('daAvatar', button.dataset.inisial);
            setDetailText('daNama', button.dataset.nama);
            setDetailText('daNis', 'NIS: ' + (button.dataset.nis || '-'));
            setDetailText('daKelas', button.dataset.kelas);
            setDetailText('daEmail', button.dataset.email);
            setDetailText('daNoHp', 'No HP: ' + (button.dataset.noHp || '-'));
            setDetailText('daAlamat', 'Alamat: ' + (button.dataset.alamat || '-'));
            setDetailText('daStatus', button.dataset.status);
            setDetailText('daTotalPinjam', button.dataset.totalPinjam);
            setDetailText('daAktifPinjam', button.dataset.aktifPinjam);
            setDetailText('daTotalDenda', button.dataset.totalDenda);
            setDetailText('daNoAnggota', button.dataset.noAnggota);
            setDetailText('daPendaftaran', button.dataset.pendaftaran);

            if (modal) {
                modal.style.display = 'flex';
                modal.style.position = 'fixed';
                modal.style.inset = '0';
                modal.style.zIndex = '9999';
                modal.classList.add('show');
            }
        }

        document.addEventListener('DOMContentLoaded', function () {
            const modal = document.getElementById('daModal');
            const closeBtn = document.getElementById('daModalClose');

            if (modal) {
                modal.style.display = 'none';

                modal.addEventListener('click', function (event) {
                    if (event.target === modal) {
                        modal.style.display = 'none';
                        modal.classList.remove('show');
                    }
                });
            }

            if (closeBtn) {
                closeBtn.addEventListener('click', function () {
                    if (modal) {
                        modal.style.display = 'none';
                        modal.classList.remove('show');
                    }
                });
            }
        });
    </script>

    <div id="modalDetailAnggota" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.45); z-index:99999; align-items:center; justify-content:center;">
    <div style="background:white; width:90%; max-width:520px; border-radius:20px; padding:24px; font-family:Montserrat, sans-serif; box-shadow:0 20px 50px rgba(0,0,0,0.25);">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:18px;">
            <h3 style="margin:0; color:#2D7076;">Detail Anggota</h3>
            <button type="button" onclick="tutupDetailAnggota()" style="border:none; background:#f2f2f2; width:34px; height:34px; border-radius:50%; cursor:pointer;">×</button>
        </div>

        <div style="display:grid; gap:10px; font-size:14px; color:#333;">
            <p><strong>Nama:</strong> <span id="detailNama">-</span></p>
            <p><strong>NIS:</strong> <span id="detailNis">-</span></p>
            <p><strong>No. Anggota:</strong> <span id="detailNoAnggota">-</span></p>
            <p><strong>Kelas:</strong> <span id="detailKelas">-</span></p>
            <p><strong>Email:</strong> <span id="detailEmail">-</span></p>
            <p><strong>No. HP:</strong> <span id="detailNoHp">-</span></p>
            <p><strong>Alamat:</strong> <span id="detailAlamat">-</span></p>
            <p><strong>Status Anggota:</strong> <span id="detailStatus">-</span></p>
            <p><strong>Status Pendaftaran:</strong> <span id="detailPendaftaran">-</span></p>
            <hr>
            <p><strong>Total Peminjaman:</strong> <span id="detailTotalPinjam">0</span></p>
            <p><strong>Sedang Dipinjam:</strong> <span id="detailPinjamAktif">0</span></p>
            <p><strong>Denda Belum Lunas:</strong> <span id="detailTotalDenda">Rp 0</span></p>
        </div>
    </div>
</div>

    <script>
        function isiText(id, value) {
            const el = document.getElementById(id);
            if (el) {
                el.textContent = value || '-';
            }
        }

        function bukaDetailAnggota(nama, nis, noAnggota, kelas, email, noHp, alamat, status, pendaftaran, totalPinjam, pinjamAktif, totalDenda) {
            isiText('detailNama', nama);
            isiText('detailNis', nis);
            isiText('detailNoAnggota', noAnggota);
            isiText('detailKelas', kelas);
            isiText('detailEmail', email);
            isiText('detailNoHp', noHp);
            isiText('detailAlamat', alamat);
            isiText('detailStatus', status);
            isiText('detailPendaftaran', pendaftaran);
            isiText('detailTotalPinjam', totalPinjam);
            isiText('detailPinjamAktif', pinjamAktif);
            isiText('detailTotalDenda', totalDenda);

            const modal = document.getElementById('modalDetailAnggota');
            if (modal) {
                modal.style.display = 'flex';
            }
        }

        function tutupDetailAnggota() {
            const modal = document.getElementById('modalDetailAnggota');
            if (modal) {
                modal.style.display = 'none';
            }
        }

        document.addEventListener('click', function (event) {
            const modal = document.getElementById('modalDetailAnggota');

            if (modal && event.target === modal) {
                tutupDetailAnggota();
            }
        });
    </script>

</body>
</html>