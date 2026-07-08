@php
    $namaAnggota = optional($anggota)->nama_anggota ?? session('auth_name') ?? 'Anggota';
    $inisialAnggota = strtoupper(substr($namaAnggota ?: 'A', 0, 1));

    $fotoAnggotaUrl = optional($anggota)->foto_url;

    $formatTanggal = function ($tanggal) {
        if (!$tanggal) {
            return '-';
        }

        return \Illuminate\Support\Carbon::parse($tanggal)->translatedFormat('d M Y');
    };
@endphp

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Saya – Perpustakaan SMAIT Al-Uswah</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style-home.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style-home-anggota.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style-profil-anggota.css') }}">
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

            <a href="{{ url('/profil-anggota') }}" class="nav-profile active-profile">
                <div class="nav-avatar">
                    @if($fotoAnggotaUrl)
                        <img src="{{ $fotoAnggotaUrl }}" alt="Foto Profil" class="avatar-img">
                    @else
                        <div class="avatar-placeholder">{{ $inisialAnggota }}</div>
                    @endif
                </div>
                <span class="nav-username">{{ $namaAnggota }}</span>
            </a>
        </div>
    </header>

    {{-- ===== HERO ===== --}}
    <section class="profil-hero">
        <div class="profil-hero-inner">
            <span class="profil-eyebrow">identitas literasimu</span>
            <h1 class="profil-title">Profil Saya</h1>
            <div class="profil-divider">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="#90C3C6" stroke="none"><path d="M12 2l1.5 5.5L19 9l-5.5 1.5L12 16l-1.5-5.5L5 9l5.5-1.5z"/></svg>
                <span class="divider-line"></span>
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="#b8742f" stroke="none"><path d="M12 2l1.5 5.5L19 9l-5.5 1.5L12 16l-1.5-5.5L5 9l5.5-1.5z"/></svg>
            </div>
        </div>
    </section>

    {{-- ===== MAIN ===== --}}
    <section class="profil-main">
        <div class="profil-main-inner">

            {{-- ===== LEFT: kartu identitas ===== --}}
            <aside class="profil-side">
                <div class="profil-card">
                    <div class="profil-photo-wrap">
                        <div class="profil-photo" id="photoPreview">
                            @if($fotoAnggotaUrl)
                                <img src="{{ $fotoAnggotaUrl }}" alt="Foto Profil" id="photoImg">
                            @else
                                <div class="photo-placeholder" id="photoInitial">{{ $inisialAnggota }}</div>
                            @endif
                        </div>
                        <button type="button" class="photo-edit-btn" id="photoEditBtn" title="Ganti foto">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"/><circle cx="12" cy="13" r="4"/></svg>
                        </button>

                        <input type="file" id="photoInput" name="foto" accept="image/*" hidden form="profilForm">
                    </div>

                    <div class="photo-actions" id="photoActions">
                        <button type="button" class="photo-action" id="btnChangePhoto">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                            Ganti Foto
                        </button>
                    </div>

                    <h2 class="profil-name">{{ $namaAnggota }}</h2>
                    <p class="profil-meta">
                        {{ optional($anggota)->kelas ?? '-' }} &bull; {{ optional($anggota)->nis ?? '-' }}
                    </p>

                    <div class="profil-divider-line"></div>

                    <ul class="profil-info-list">
                        <li>
                            <span class="info-ic">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#2D7076" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                            </span>
                            <div>
                                <span class="info-label">EMAIL</span>
                                <span class="info-value">{{ optional($anggota)->email ?? '-' }}</span>
                            </div>
                        </li>
                        <li>
                            <span class="info-ic">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#2D7076" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                            </span>
                            <div>
                                <span class="info-label">NO. TELEPON</span>
                                <span class="info-value">{{ optional($anggota)->no_hp ?? '-' }}</span>
                            </div>
                        </li>
                        <li>
                            <span class="info-ic">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#2D7076" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                            </span>
                            <div>
                                <span class="info-label">ALAMAT</span>
                                <span class="info-value">{{ optional($anggota)->alamat ?? '-' }}</span>
                            </div>
                        </li>
                        <li>
                            <span class="info-ic">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#2D7076" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                            </span>
                            <div>
                                <span class="info-label">STATUS</span>
                                <span class="info-value">{{ ucfirst(optional($anggota)->status_anggota ?? '-') }}</span>
                            </div>
                        </li>
                    </ul>
                </div>

                {{-- Kartu Anggota --}}
                <div class="kartu-anggota-block">
                    <h3 class="kartu-anggota-heading">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#2D7076" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="4" width="20" height="16" rx="2"/><circle cx="8" cy="10" r="2"/><path d="M14 9h4"/><path d="M14 13h4"/><path d="M5 16h6"/></svg>
                        Kartu Anggota
                    </h3>

                    <div class="ecard" id="ecardTrigger">
                        <div class="ecard-star">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="rgba(255,255,255,.6)" stroke-width="2"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                        </div>
                        <span class="ecard-org">SMAIT AL-USWAH SURABAYA</span>
                        <span class="ecard-type">E-LIBRARY CARD</span>
                        <h4 class="ecard-name">{{ strtoupper($namaAnggota) }}</h4>
                        <span class="ecard-id">Member ID: {{ optional($anggota)->no_anggota ?? optional($anggota)->nis ?? '-' }}</span>
                        <div class="ecard-qr">
                            <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="#2D7076" stroke-width="1.5"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/><line x1="14" y1="14" x2="14" y2="14.01"/><line x1="21" y1="14" x2="21" y2="14.01"/><line x1="14" y1="21" x2="14" y2="21.01"/><line x1="21" y1="21" x2="21" y2="21.01"/><line x1="17.5" y1="17.5" x2="17.5" y2="17.51"/></svg>
                        </div>
                    </div>
                    <p class="ecard-hint">Klik kartu untuk memperbesar</p>
                </div>
            </aside>

            {{-- ===== RIGHT: form ===== --}}
            <div class="profil-content">

                @if (session('success'))
                    <div style="background:#f0fff4; border:1px solid #a7e3b5; color:#24733b; padding:12px 14px; border-radius:12px; margin-bottom:16px; font-size:14px;">
                        {{ session('success') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div style="background:#fff3f3; border:1px solid #f3b5b5; color:#9f2f2f; padding:12px 14px; border-radius:12px; margin-bottom:16px; font-size:14px;">
                        <strong>Perubahan belum bisa disimpan.</strong>
                        <ul style="margin:8px 0 0 18px;">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- Informasi Personal --}}
                <div class="profil-panel">
                    <div class="panel-head">
                        <h2 class="panel-title">Informasi Personal</h2>
                        <span class="panel-edit-ic">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#2D7076" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                        </span>
                    </div>

                    <form id="profilForm" action="{{ url('/profil-anggota') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')

                        <div class="form-group">
                            <label for="nama_anggota">Nama Lengkap</label>
                            <input type="text" id="nama_anggota" value="{{ $namaAnggota }}" disabled class="input-locked">
                            <span class="form-hint">Nama lengkap hanya dapat diubah oleh admin</span>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="nis">NIS (Nomor Induk Siswa)</label>
                                <input type="text" id="nis" value="{{ optional($anggota)->nis ?? '-' }}" disabled class="input-locked">
                                <span class="form-hint">NIS tidak dapat diubah secara mandiri</span>
                            </div>
                            <div class="form-group">
                                <label for="kelas">Kelas</label>
                                <input type="text" id="kelas" value="{{ optional($anggota)->kelas ?? '-' }}" disabled class="input-locked">
                                <span class="form-hint">Kelas hanya dapat diubah oleh admin</span>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="no_anggota">Nomor Anggota</label>
                                <input type="text" id="no_anggota" value="{{ optional($anggota)->no_anggota ?? '-' }}" disabled class="input-locked">
                            </div>
                            <div class="form-group">
                                <label for="tanggal_daftar">Tanggal Daftar</label>
                                <input type="text" id="tanggal_daftar" value="{{ $formatTanggal(optional($anggota)->tanggal_daftar) }}" disabled class="input-locked">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" id="username" name="username" value="{{ old('username', optional($anggota)->username) }}" required>
                            <span class="form-err" id="err-username"></span>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" id="email" name="email" value="{{ old('email', optional($anggota)->email) }}" required>
                                <span class="form-err" id="err-email"></span>
                            </div>
                            <div class="form-group">
                                <label for="no_hp">Nomor Telepon/WA</label>
                                <input type="text" id="no_hp" name="no_hp" value="{{ old('no_hp', optional($anggota)->no_hp) }}">
                                <span class="form-err" id="err-hp"></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="alamat">Alamat Lengkap</label>
                            <textarea id="alamat" name="alamat" rows="3">{{ old('alamat', optional($anggota)->alamat) }}</textarea>
                            <span class="form-err" id="err-alamat"></span>
                        </div>
                    </form>

                    {{-- ===== FORM ACTIONS (termasuk tombol Logout) =====
                         Batalkan & Simpan Perubahan tetap terikat ke #profilForm lewat atribut form="profilForm",
                         sehingga submit tetap berjalan normal meski elemen ini berada di luar tag <form>.
                         Logout dipisah ke ujung kanan baris yang sama sebagai aksi yang berbeda konteksnya. --}}
                    <div class="form-actions" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 15px; margin-top: 20px; padding-top: 20px; border-top: 1px solid #e5e7eb;">

                        <div style="display: flex; gap: 15px; align-items: center; flex-wrap: wrap;">
                            <a href="{{ url('/profil-anggota') }}" class="btn-batal" id="btnBatal" style="text-decoration:none; display:inline-flex; align-items:center; justify-content:center; padding: 10px 24px; background: #e5e7eb; color: #333; border-radius: 8px; font-weight: 600; border: none; cursor: pointer;">
                                Batalkan
                            </a>
                            <button type="submit" form="profilForm" class="btn-simpan" style="padding: 10px 24px; background: #2D7076; color: white; border: none; border-radius: 8px; cursor: pointer; font-weight: 600; display: inline-flex; align-items: center; gap: 8px;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                                Simpan Perubahan
                            </button>
                        </div>

                        <form action="{{ url('/logout') }}" method="POST" style="margin: 0;">
                            @csrf
                            <button type="submit" style="padding: 10px 24px; background: #c0392b; color: white; border: none; border-radius: 8px; cursor: pointer; font-weight: 600; display: inline-flex; align-items: center; gap: 8px;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                                Logout
                            </button>
                        </form>
                    </div>

                </div>

                {{-- Keamanan Akun --}}
                <div class="profil-panel panel-security">
                    <div class="panel-head security-head" id="securityToggle">
                        <h2 class="panel-title">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#2D7076" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                            Keamanan Akun
                        </h2>
                        <button type="button" class="btn-toggle-security" id="btnToggleSecurity">
                            <span id="securityToggleText">Ubah Password</span>
                            <svg class="security-chevron" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg>
                        </button>
                    </div>

                    <div class="security-body hidden" id="securityBody">
                        <form id="passwordForm" action="{{ url('/profil-anggota/password') }}" method="POST">
                            @csrf
                            @method('PATCH')

                            <div class="form-row form-row-3">
                                <div class="form-group">
                                    <label for="password_lama">Kata Sandi Lama</label>
                                    <div class="pass-wrap">
                                        <input type="password" id="password_lama" name="password_lama" placeholder="••••••••" required>
                                        <button type="button" class="pass-toggle" data-target="password_lama" aria-label="Lihat sandi">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                        </button>
                                    </div>
                                    <span class="form-err" id="err-pass-lama"></span>
                                </div>
                                <div class="form-group">
                                    <label for="password">Kata Sandi Baru</label>
                                    <div class="pass-wrap">
                                        <input type="password" id="password" name="password" placeholder="••••••••" required>
                                        <button type="button" class="pass-toggle" data-target="password" aria-label="Lihat sandi">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                        </button>
                                    </div>
                                    <span class="form-err" id="err-pass-baru"></span>
                                </div>
                                <div class="form-group">
                                    <label for="password_confirmation">Konfirmasi Sandi Baru</label>
                                    <div class="pass-wrap">
                                        <input type="password" id="password_confirmation" name="password_confirmation" placeholder="••••••••" required>
                                        <button type="button" class="pass-toggle" data-target="password_confirmation" aria-label="Lihat sandi">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                        </button>
                                    </div>
                                    <span class="form-err" id="err-pass-konfirmasi"></span>
                                </div>
                            </div>

                            <div class="security-footer">
                                <p class="security-note">Gunakan minimal 8 karakter agar password lebih aman.</p>
                                <button type="submit" class="btn-update-pass">Update Password</button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </section>

    {{-- ===== MODAL KARTU ANGGOTA ===== --}}
    <div class="ecard-modal" id="ecardModal">
        <div class="ecard-modal-inner">
            <button class="ecard-modal-close" id="ecardModalClose" aria-label="Tutup">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>

            <div class="ecard ecard-large">
                <div class="ecard-star">
                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="rgba(255,255,255,.6)" stroke-width="2"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                </div>
                <span class="ecard-org">SMAIT AL-USWAH SURABAYA</span>
                <span class="ecard-type">E-LIBRARY CARD</span>
                <h4 class="ecard-name">{{ strtoupper($namaAnggota) }}</h4>
                <span class="ecard-id">Member ID: {{ optional($anggota)->no_anggota ?? optional($anggota)->nis ?? '-' }}</span>
                <div class="ecard-qr">
                    <svg xmlns="http://www.w3.org/2000/svg" width="56" height="56" viewBox="0 0 24 24" fill="none" stroke="#2D7076" stroke-width="1.5"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/><line x1="14" y1="14" x2="14" y2="14.01"/><line x1="21" y1="14" x2="21" y2="14.01"/><line x1="14" y1="21" x2="14" y2="21.01"/><line x1="21" y1="21" x2="21" y2="21.01"/><line x1="17.5" y1="17.5" x2="17.5" y2="17.51"/></svg>
                </div>
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
    {{-- <script src="{{ asset('js/script-profil-anggota.js') }}"></script> --}}

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const photoEditBtn = document.getElementById('photoEditBtn');
            const btnChangePhoto = document.getElementById('btnChangePhoto');
            const photoInput = document.getElementById('photoInput');
            const photoPreview = document.getElementById('photoPreview');

            function pilihFoto() {
                photoInput?.click();
            }

            photoEditBtn?.addEventListener('click', pilihFoto);
            btnChangePhoto?.addEventListener('click', pilihFoto);

            photoInput?.addEventListener('change', function () {
                const file = this.files?.[0];

                if (!file) return;

                const reader = new FileReader();

                reader.onload = function (event) {
                    photoPreview.innerHTML = `<img src="${event.target.result}" alt="Preview Foto" id="photoImg">`;
                };

                reader.readAsDataURL(file);
            });

            document.querySelectorAll('.pass-toggle').forEach(function (button) {
                button.addEventListener('click', function () {
                    const input = document.getElementById(button.dataset.target);

                    if (!input) return;

                    input.type = input.type === 'password' ? 'text' : 'password';
                });
            });

            const securityToggle = document.getElementById('securityToggle');
            const btnToggleSecurity = document.getElementById('btnToggleSecurity');
            const securityBody = document.getElementById('securityBody');
            const securityToggleText = document.getElementById('securityToggleText');

            function toggleSecurity() {
                securityBody?.classList.toggle('hidden');

                if (securityToggleText && securityBody) {
                    securityToggleText.textContent = securityBody.classList.contains('hidden')
                        ? 'Ubah Password'
                        : 'Tutup';
                }
            }

            securityToggle?.addEventListener('click', function (event) {
                if (event.target.closest('button')) return;
                toggleSecurity();
            });

            btnToggleSecurity?.addEventListener('click', toggleSecurity);

            const ecardTrigger = document.getElementById('ecardTrigger');
            const ecardModal = document.getElementById('ecardModal');
            const ecardModalClose = document.getElementById('ecardModalClose');

            ecardTrigger?.addEventListener('click', function () {
                ecardModal?.classList.add('show');
            });

            ecardModalClose?.addEventListener('click', function () {
                ecardModal?.classList.remove('show');
            });

            ecardModal?.addEventListener('click', function (event) {
                if (event.target === ecardModal) {
                    ecardModal.classList.remove('show');
                }
            });
        });
    </script>
</body>
</html>