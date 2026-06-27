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
            <a href="{{ route('home-anggota') }}" class="nav-brand">
                <img src="{{ asset('assets/logo.png') }}" alt="Logo" class="nav-logo">
                <span class="nav-brand-name">Al-Uswah Library</span>
            </a>

            <nav class="nav-links">
                <a href="{{ route('dashboard-anggota') }}" class="nav-link">Dashboard</a>
                <a href="{{ route('katalog-anggota') }}" class="nav-link">Katalog</a>
                <a href="{{ route('tentang-perpustakaan-anggota') }}" class="nav-link">Tentang</a>
                <a href="{{ route('riwayat-peminjaman') }}" class="nav-link">Riwayat</a>
                <a href="{{ route('status-denda') }}" class="nav-link">Denda</a>
            </nav>

            <a href="{{ route('profil-anggota') }}" class="nav-profile active-profile">
                <div class="nav-avatar">
                    @if(auth()->user()?->foto)
                        <img src="{{ asset('storage/' . auth()->user()->foto) }}" alt="Foto Profil" class="avatar-img">
                    @else
                        <div class="avatar-placeholder">{{ strtoupper(substr(auth()->user()?->nama_lengkap ?? 'A', 0, 1)) }}</div>
                    @endif
                </div>
                <span class="nav-username">{{ auth()->user()?->nama_lengkap ?? 'Anggota' }}</span>
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
                            @if(auth()->user()?->foto)
                                <img src="{{ asset('storage/' . auth()->user()->foto) }}" alt="Foto Profil" id="photoImg">
                            @else
                                <div class="photo-placeholder" id="photoInitial">{{ strtoupper(substr(auth()->user()?->nama_lengkap ?? 'A', 0, 1)) }}</div>
                            @endif
                        </div>
                        <button type="button" class="photo-edit-btn" id="photoEditBtn" title="Ganti foto">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"/><circle cx="12" cy="13" r="4"/></svg>
                        </button>
                        <input type="file" id="photoInput" accept="image/*" hidden>
                    </div>

                    {{-- Menu kecil ganti/hapus foto --}}
                    <div class="photo-actions" id="photoActions">
                        <button type="button" class="photo-action" id="btnChangePhoto">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                            Ganti Foto
                        </button>
                        <button type="button" class="photo-action photo-action-danger hidden" id="btnDeletePhoto">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                            Hapus Foto
                        </button>
                    </div>

                    <h2 class="profil-name">{{ auth()->user()?->nama_lengkap ?? 'Adelia Putri Ramadhani' }}</h2>
                    <p class="profil-meta">{{ auth()->user()?->kelas ?? 'XII MIPA 1' }} &bull; {{ auth()->user()?->nis ?? '2026.08.0125' }}</p>

                    <div class="profil-divider-line"></div>

                    <ul class="profil-info-list">
                        <li>
                            <span class="info-ic">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#2D7076" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                            </span>
                            <div>
                                <span class="info-label">EMAIL</span>
                                <span class="info-value">{{ auth()->user()?->email ?? 'adelia.putri@gmail.com' }}</span>
                            </div>
                        </li>
                        <li>
                            <span class="info-ic">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#2D7076" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                            </span>
                            <div>
                                <span class="info-label">NO. TELEPON</span>
                                <span class="info-value">{{ auth()->user()?->nomor_hp ?? '0812-3456-7890' }}</span>
                            </div>
                        </li>
                        <li>
                            <span class="info-ic">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#2D7076" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                            </span>
                            <div>
                                <span class="info-label">ALAMAT</span>
                                <span class="info-value">{{ auth()->user()?->alamat ?? 'Jl. Ketintang Madya No. 81, Surabaya' }}</span>
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
                        <h4 class="ecard-name">{{ strtoupper(auth()->user()?->nama_lengkap ?? 'Adelia Putri R.') }}</h4>
                        <span class="ecard-id">Member ID: {{ auth()->user()?->nis ?? '2026.08.0125' }}</span>
                        <div class="ecard-qr">
                            <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="#2D7076" stroke-width="1.5"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/><line x1="14" y1="14" x2="14" y2="14.01"/><line x1="21" y1="14" x2="21" y2="14.01"/><line x1="14" y1="21" x2="14" y2="21.01"/><line x1="21" y1="21" x2="21" y2="21.01"/><line x1="17.5" y1="17.5" x2="17.5" y2="17.51"/></svg>
                        </div>
                    </div>
                    <p class="ecard-hint">Klik kartu untuk memperbesar &amp; unduh</p>
                </div>
            </aside>

            {{-- ===== RIGHT: form ===== --}}
            <div class="profil-content">

                {{-- Informasi Personal --}}
                <div class="profil-panel">
                    <div class="panel-head">
                        <h2 class="panel-title">Informasi Personal</h2>
                        <span class="panel-edit-ic">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#2D7076" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                        </span>
                    </div>

                    <form id="profilForm" novalidate>
                        <div class="form-group">
                            <label for="nama_lengkap">Nama Lengkap</label>
                            <input type="text" id="nama_lengkap" name="nama_lengkap" value="{{ auth()->user()?->nama_lengkap ?? 'Adelia Putri Ramadhani' }}">
                            <span class="form-err" id="err-nama"></span>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="nis">NIS (Nomor Induk Siswa)</label>
                                <input type="text" id="nis" name="nis" value="{{ auth()->user()?->nis ?? '2026.08.0125' }}" disabled class="input-locked">
                                <span class="form-hint">NIS tidak dapat diubah secara mandiri</span>
                            </div>
                            <div class="form-group">
                                <label for="kelas">Kelas</label>
                                <div class="select-wrap">
                                    <select id="kelas" name="kelas">
                                        <option @if((auth()->user()?->kelas ?? 'XII MIPA 1') === 'X MIPA 1') selected @endif>X MIPA 1</option>
                                        <option @if((auth()->user()?->kelas ?? 'XII MIPA 1') === 'XI MIPA 1') selected @endif>XI MIPA 1</option>
                                        <option @if((auth()->user()?->kelas ?? 'XII MIPA 1') === 'XII MIPA 1') selected @endif>XII MIPA 1</option>
                                        <option @if((auth()->user()?->kelas ?? '') === 'XII IPS 1') selected @endif>XII IPS 1</option>
                                    </select>
                                    <svg class="select-arrow" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#2D7076" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg>
                                </div>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="email">Email Sekolah</label>
                                <input type="email" id="email" name="email" value="{{ auth()->user()?->email ?? 'adelia.putri@gmail.com' }}">
                                <span class="form-err" id="err-email"></span>
                            </div>
                            <div class="form-group">
                                <label for="nomor_hp">Nomor Telepon/WA</label>
                                <input type="text" id="nomor_hp" name="nomor_hp" value="{{ auth()->user()?->nomor_hp ?? '081234567890' }}">
                                <span class="form-err" id="err-hp"></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="alamat">Alamat Lengkap</label>
                            <textarea id="alamat" name="alamat" rows="3">{{ auth()->user()?->alamat ?? 'Jl. Ketintang Madya No. 81, Gayungan, Surabaya, Jawa Timur 60232' }}</textarea>
                            <span class="form-err" id="err-alamat"></span>
                        </div>

                        <div class="form-actions">
                            <button type="button" class="btn-batal" id="btnBatal">Batalkan</button>
                            <button type="submit" class="btn-simpan">Simpan Perubahan</button>
                        </div>
                    </form>
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
                        <form id="passwordForm" novalidate>
                            <div class="form-row form-row-3">
                                <div class="form-group">
                                    <label for="pass_lama">Kata Sandi Lama</label>
                                    <div class="pass-wrap">
                                        <input type="password" id="pass_lama" name="pass_lama" placeholder="••••••••">
                                        <button type="button" class="pass-toggle" data-target="pass_lama" aria-label="Lihat sandi">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                        </button>
                                    </div>
                                    <span class="form-err" id="err-pass-lama"></span>
                                </div>
                                <div class="form-group">
                                    <label for="pass_baru">Kata Sandi Baru</label>
                                    <div class="pass-wrap">
                                        <input type="password" id="pass_baru" name="pass_baru" placeholder="••••••••">
                                        <button type="button" class="pass-toggle" data-target="pass_baru" aria-label="Lihat sandi">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                        </button>
                                    </div>
                                    <span class="form-err" id="err-pass-baru"></span>
                                </div>
                                <div class="form-group">
                                    <label for="pass_konfirmasi">Konfirmasi Sandi Baru</label>
                                    <div class="pass-wrap">
                                        <input type="password" id="pass_konfirmasi" name="pass_konfirmasi" placeholder="••••••••">
                                        <button type="button" class="pass-toggle" data-target="pass_konfirmasi" aria-label="Lihat sandi">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                        </button>
                                    </div>
                                    <span class="form-err" id="err-pass-konfirmasi"></span>
                                </div>
                            </div>

                            <div class="security-footer">
                                <p class="security-note">Gunakan minimal 8 karakter dengan kombinasi huruf besar, kecil, dan angka untuk keamanan ekstra.</p>
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
                <h4 class="ecard-name">{{ strtoupper(auth()->user()?->nama_lengkap ?? 'Adelia Putri R.') }}</h4>
                <span class="ecard-id">Member ID: {{ auth()->user()?->nis ?? '2026.08.0125' }}</span>
                <div class="ecard-qr">
                    <svg xmlns="http://www.w3.org/2000/svg" width="56" height="56" viewBox="0 0 24 24" fill="none" stroke="#2D7076" stroke-width="1.5"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/><line x1="14" y1="14" x2="14" y2="14.01"/><line x1="21" y1="14" x2="21" y2="14.01"/><line x1="14" y1="21" x2="14" y2="21.01"/><line x1="21" y1="21" x2="21" y2="21.01"/><line x1="17.5" y1="17.5" x2="17.5" y2="17.51"/></svg>
                </div>
            </div>

            <button class="btn-download-card" id="btnDownloadCard">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                Unduh Kartu
            </button>
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
                    <li><a href="#">Visi &amp; Misi</a></li>
                    <li><a href="#">Kebijakan Layanan</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h4 class="footer-col-title">Dukungan</h4>
                <ul>
                    <li><a href="#">Pusat Bantuan</a></li>
                    <li><a href="#">Donasi Buku</a></li>
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

    <script src="{{ asset('js/script-profil-anggota.js') }}"></script>
</body>
</html>