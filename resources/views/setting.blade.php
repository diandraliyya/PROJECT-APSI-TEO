<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Setting Sistem – Perpustakaan SMAIT Al-Uswah</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style-home.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style-home-anggota.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style-home-admin.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style-setting.css') }}">
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
                <a href="{{ route('kelola-denda') }}" class="nav-link">Denda</a>
            </nav>
            <a href="{{ route('setting') }}" class="nav-profile active-profile">
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

    {{-- ===== HERO ===== --}}
    <section class="st-hero">
        <div class="st-hero-inner">
            <div>
                <h1 class="st-title">Setting Sistem</h1>
                <p class="st-desc">Kelola operasional dan keamanan perpustakaan dalam satu tempat.</p>
            </div>
            <div class="st-hero-deco">
                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="#b8742f" stroke="none"><path d="M12 2l1.5 5.5L19 9l-5.5 1.5L12 16l-1.5-5.5L5 9l5.5-1.5z"/></svg>
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="#90C3C6" stroke="none"><path d="M12 2l1.5 5.5L19 9l-5.5 1.5L12 16l-1.5-5.5L5 9l5.5-1.5z"/></svg>
            </div>
        </div>
    </section>

    {{-- ===== MAIN ===== --}}
    <section class="st-main">
        <div class="st-main-inner">

            {{-- LEFT ===== --}}
            <div class="st-left">

                {{-- Data Akun Admin --}}
                <div class="st-panel">
                    <div class="st-panel-head">
                        <span class="st-panel-ic">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#b8742f" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                        </span>
                        <h2 class="st-panel-title">Data Akun Admin</h2>
                    </div>

                    {{-- Foto Profil --}}
                    <div class="st-foto-wrap">
                        <div class="st-foto-preview" id="stPhotoPreview">
                            <div class="st-foto-placeholder" id="stPhotoInitial">
                                {{ strtoupper(substr(auth()->user()?->nama_lengkap ?? 'A', 0, 1)) }}
                            </div>
                        </div>
                        <button type="button" class="st-foto-edit-btn" id="stPhotoEditBtn" title="Ganti foto">
                            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"/><circle cx="12" cy="13" r="4"/></svg>
                        </button>
                        <input type="file" id="stPhotoInput" accept="image/*" hidden>
                        <div class="st-foto-actions">
                            <button type="button" class="st-foto-action" id="stBtnChange">
                                <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                                Ganti Foto
                            </button>
                            <button type="button" class="st-foto-action st-foto-action-danger hidden" id="stBtnDelete">
                                <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                                Hapus Foto
                            </button>
                        </div>
                    </div>

                                        <form id="akunForm" novalidate>
                        <div class="st-form-row">
                            <div class="st-form-group">
                                <label for="nama_admin">Nama Admin</label>
                                <input type="text" id="nama_admin" name="nama_admin"
                                    value="{{ auth()->user()?->nama_lengkap ?? 'Admin Perpustakaan SMAIT' }}">
                                <span class="st-form-err" id="err-nama"></span>
                            </div>
                            <div class="st-form-group">
                                <label for="username">Username</label>
                                <input type="text" id="username" name="username"
                                    value="{{ auth()->user()?->username ?? 'admin_al_uswah' }}">
                                <span class="st-form-err" id="err-username"></span>
                            </div>
                        </div>
                        <div class="st-form-group">
                            <label for="email">Email</label>
                            <input type="email" id="email" name="email"
                                value="{{ auth()->user()?->email ?? 'library@smait-aluswah.sch.id' }}">
                            <span class="st-form-err" id="err-email"></span>
                        </div>
                    </form>
                </div>

            </div>

            {{-- RIGHT ===== --}}
            <div class="st-right">

                {{-- Keamanan & Password --}}
                <div class="st-panel">
                    <div class="st-panel-head">
                        <span class="st-panel-ic">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#b8742f" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                        </span>
                        <h2 class="st-panel-title">Keamanan &amp; Password</h2>
                        <button type="button" class="btn-toggle-pass" id="btnTogglePass">
                            <span id="passToggleText">Ubah Password</span>
                            <svg class="pass-chevron" xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg>
                        </button>
                    </div>

                    <div class="st-pass-body hidden" id="passBody">
                        <form id="passForm" novalidate>
                            <div class="st-form-group">
                                <label for="pass_lama">Password Lama</label>
                                <div class="st-pass-wrap">
                                    <input type="password" id="pass_lama" name="pass_lama" placeholder="••••••••">
                                    <button type="button" class="st-pass-toggle" data-target="pass_lama">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                    </button>
                                </div>
                                <span class="st-form-err" id="err-pass-lama"></span>
                            </div>
                            <div class="st-form-group">
                                <label for="pass_baru">Password Baru</label>
                                <div class="st-pass-wrap">
                                    <input type="password" id="pass_baru" name="pass_baru" placeholder="Min. 8 karakter">
                                    <button type="button" class="st-pass-toggle" data-target="pass_baru">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                    </button>
                                </div>
                                <span class="st-form-err" id="err-pass-baru"></span>
                            </div>
                            <div class="st-form-group">
                                <label for="pass_konfirmasi">Konfirmasi Password Baru</label>
                                <div class="st-pass-wrap">
                                    <input type="password" id="pass_konfirmasi" name="pass_konfirmasi" placeholder="Ulangi password baru">
                                    <button type="button" class="st-pass-toggle" data-target="pass_konfirmasi">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                    </button>
                                </div>
                                <span class="st-form-err" id="err-pass-konfirmasi"></span>
                            </div>
                            <div class="st-pass-note">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#2D7076" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>
                                <p>Pastikan password mengandung kombinasi huruf, angka, dan simbol untuk keamanan maksimal.</p>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>

        {{-- ACTION BUTTONS (full width bawah) --}}
        <div class="st-actions-inner">
            <div class="st-actions">
                <button type="button" class="btn-batal" id="btnBatal">Batal</button>
                <button type="button" class="btn-simpan" id="btnSimpan">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                    Simpan Setting
                </button>
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
                <ul><li><a href="#">Privacy Policy</a></li><li><a href="#">Terms of Service</a></li></ul>
            </div>
            <div class="footer-col">
                <h4 class="footer-col-title">Dukungan</h4>
                <ul><li><a href="#">Support</a></li><li><a href="#">Pusat Bantuan</a></li></ul>
            </div>
            <div class="footer-col">
                <h4 class="footer-col-title">Hubungi Kami</h4>
                <address>Jl. Al-Uswah No. 123, Surabaya<br>library@smait-aluswah.sch.id</address>
            </div>
        </div>
        <div class="footer-bottom">
            <p>© 2026 SMAIT Al-Uswah Library System. Nostalgic Learning, Modern Tools.</p>
        </div>
    </footer>

    <script src="{{ asset('js/script-setting.js') }}"></script>
</body>
</html>