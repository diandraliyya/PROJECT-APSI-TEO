<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Anggota Baru – Perpustakaan SMAIT Al-Uswah</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style-home.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style-home-anggota.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style-home-admin.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style-tambah-anggota.css') }}">
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
                <a href="{{ route('kelola-anggota') }}" class="nav-link active">Anggota</a>
                <a href="{{ route('riwayat-transaksi') }}" class="nav-link">Transaksi</a>
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

    {{-- ===== HERO ===== --}}
    <section class="ta-hero">
        <div class="ta-hero-inner">
            <div class="ta-hero-left">
                <span class="ta-eyebrow">
                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="#b8742f" stroke="none"><path d="M12 2l2.4 7.4H22l-6.2 4.5 2.4 7.4L12 17l-6.2 4.3 2.4-7.4L2 9.4h7.6z"/></svg>
                    Buat akun baru
                </span>
                <h1 class="ta-title">Tambah Anggota Baru</h1>
                <p class="ta-desc">Masukkan data siswa untuk membuat akun anggota perpustakaan. Pastikan data yang dimasukkan sudah sesuai dengan Kartu Pelajar.</p>
            </div>
            <div class="ta-hero-deco">
                <div class="ta-deco-card">
                    <div class="ta-deco-avatar"></div>
                    <div class="ta-deco-lines">
                        <span></span><span></span>
                    </div>
                </div>
                <div class="ta-deco-star">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="#b8742f" stroke="none"><path d="M12 2l2.4 7.4H22l-6.2 4.5 2.4 7.4L12 17l-6.2 4.3 2.4-7.4L2 9.4h7.6z"/></svg>
                    <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 24 24" fill="#90C3C6" stroke="none"><path d="M12 2l2.4 7.4H22l-6.2 4.5 2.4 7.4L12 17l-6.2 4.3 2.4-7.4L2 9.4h7.6z"/></svg>
                </div>
            </div>
        </div>
    </section>

    {{-- ===== FORM ===== --}}
    <section class="ta-main">
        <div class="ta-main-inner">
            <form id="tambahAnggotaForm" novalidate>
                <div class="ta-grid">

                    {{-- ===== CARD KIRI: Data Diri + Akun ===== --}}
                    <div class="ta-card">
                        <div class="ta-card-head">
                            <div class="ta-card-ic">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#b8742f" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                            </div>
                            <h2 class="ta-card-title">Data Diri</h2>
                        </div>

                        {{-- Foto Profil --}}
                        <div class="ta-foto-row">
                            <div class="ta-foto-preview" id="taFotoPreview">
                                <div class="ta-foto-placeholder" id="taFotoPlaceholder">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="rgba(255,255,255,.8)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"/><circle cx="12" cy="13" r="4"/></svg>
                                </div>
                                <img id="taFotoImg" src="" alt="Foto Profil" class="ta-foto-img hidden">
                            </div>
                            <div class="ta-foto-info">
                                <span class="ta-foto-label">Foto Profil</span>
                                <span class="ta-foto-hint">Rasio 1:1, Max 2MB. JPG atau PNG.</span>
                                <div class="ta-foto-btns">
                                    <button type="button" class="btn-ganti-foto" id="btnGantiFoto">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"/><circle cx="12" cy="13" r="4"/></svg>
                                        Ganti Foto
                                    </button>
                                    <button type="button" class="btn-hapus-foto hidden" id="btnHapusFoto">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                                        Hapus
                                    </button>
                                </div>
                                <input type="file" id="taFotoInput" accept="image/jpeg,image/png,image/webp" hidden>
                            </div>
                        </div>

                        {{-- NIS + Nama --}}
                        <div class="ta-form-row">
                            <div class="ta-form-group">
                                <label for="nis">Nomor Induk Siswa (NIS) <span class="ta-req">*</span></label>
                                <input type="text" id="nis" name="nis" placeholder="Contoh: 20241001">
                                <span class="ta-err" id="err-nis"></span>
                            </div>
                            <div class="ta-form-group">
                                <label for="nama_lengkap">Nama Lengkap <span class="ta-req">*</span></label>
                                <input type="text" id="nama_lengkap" name="nama_lengkap" placeholder="Masukkan nama sesuai ijazah">
                                <span class="ta-err" id="err-nama_lengkap"></span>
                            </div>
                        </div>

                        {{-- Kelas + No HP --}}
                        <div class="ta-form-row">
                            <div class="ta-form-group">
                                <label for="kelas">Kelas <span class="ta-req">*</span></label>
                                <div class="ta-select-wrap">
                                    <select id="kelas" name="kelas">
                                        <option value="">Pilih Kelas</option>
                                        <option value="X-MIPA-1">X-MIPA 1</option>
                                        <option value="X-MIPA-2">X-MIPA 2</option>
                                        <option value="X-IPS-1">X-IPS 1</option>
                                        <option value="X-IPS-2">X-IPS 2</option>
                                        <option value="X-IPS-3">X-IPS 3</option>
                                        <option value="XI-MIPA-1">XI-MIPA 1</option>
                                        <option value="XI-MIPA-2">XI-MIPA 2</option>
                                        <option value="XI-IPS-1">XI-IPS 1</option>
                                        <option value="XI-IPS-2">XI-IPS 2</option>
                                        <option value="XII-MIPA-1">XII-MIPA 1</option>
                                        <option value="XII-MIPA-2">XII-MIPA 2</option>
                                        <option value="XII-IPS-1">XII-IPS 1</option>
                                        <option value="XII-IPS-2">XII-IPS 2</option>
                                        <option value="Guru">Guru</option>
                                        <option value="Staf">Staf</option>
                                    </select>
                                    <svg class="ta-select-arrow" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#2D7076" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg>
                                </div>
                                <span class="ta-err" id="err-kelas"></span>
                            </div>
                            <div class="ta-form-group">
                                <label for="no_hp">Nomor HP / WhatsApp <span class="ta-req">*</span></label>
                                <input type="tel" id="no_hp" name="no_hp" placeholder="081234567XXX">
                                <span class="ta-err" id="err-no_hp"></span>
                            </div>
                        </div>

                        {{-- Email --}}
                        <div class="ta-form-group">
                            <label for="email">Alamat Email <span class="ta-req">*</span></label>
                            <input type="email" id="email" name="email" placeholder="siswa@al-uswah.sch.id">
                            <span class="ta-err" id="err-email"></span>
                        </div>

                        {{-- Alamat --}}
                        <div class="ta-form-group">
                            <label for="alamat">Alamat Tinggal</label>
                            <textarea id="alamat" name="alamat" rows="3" placeholder="Jl. Al-Uswah No. 123..."></textarea>
                        </div>

                        {{-- Divider --}}
                        <div class="ta-section-divider">
                            <div class="ta-section-ic">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#2D7076" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                            </div>
                            <span class="ta-section-label">Data Akun</span>
                            <div class="ta-section-line"></div>
                        </div>

                        {{-- Username + Password --}}
                        <div class="ta-form-row">
                            <div class="ta-form-group">
                                <label for="username">Username <span class="ta-req">*</span></label>
                                <input type="text" id="username" name="username" placeholder="contoh: ahmad.fathoni">
                                <span class="ta-err" id="err-username"></span>
                            </div>
                            <div class="ta-form-group">
                                <label for="password">Password <span class="ta-req">*</span></label>
                                <div class="ta-pass-wrap">
                                    <input type="password" id="password" name="password" placeholder="Min. 8 karakter">
                                    <button type="button" class="ta-pass-toggle" data-target="password">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                    </button>
                                </div>
                                <span class="ta-err" id="err-password"></span>
                            </div>
                        </div>

                        {{-- Konfirmasi Password --}}
                        <div class="ta-form-group ta-form-group-half">
                            <label for="konfirmasi_password">Konfirmasi Password <span class="ta-req">*</span></label>
                            <div class="ta-pass-wrap">
                                <input type="password" id="konfirmasi_password" name="konfirmasi_password" placeholder="Ulangi password">
                                <button type="button" class="ta-pass-toggle" data-target="konfirmasi_password">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                </button>
                            </div>
                            <span class="ta-err" id="err-konfirmasi_password"></span>
                        </div>

                    </div>{{-- end .ta-card --}}

                </div>{{-- end .ta-grid --}}

                {{-- ===== TOMBOL AKSI ===== --}}
                <div class="ta-actions">
                    <a href="{{ route('kelola-anggota') }}" class="btn-ta-batal">Batal</a>
                    <button type="submit" class="btn-ta-simpan">
                        <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                        Simpan Anggota
                    </button>
                </div>

            </form>
        </div>
    </section>

    {{-- ===== MODAL SUKSES ===== --}}
    <div class="ta-modal" id="taModal">
        <div class="ta-modal-inner">
            <div class="ta-modal-ic">
                <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="#16a085" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
            </div>
            <h3 class="ta-modal-title">Anggota Berhasil Ditambahkan!</h3>
            <p class="ta-modal-desc">Akun anggota atas nama <strong id="taModalNama"></strong> telah berhasil dibuat dan siap digunakan.</p>
            <button class="btn-ta-modal-ok" id="btnTaModalOk">OK, Kembali ke Kelola Anggota</button>
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
                <h4 class="footer-col-title">Navigasi</h4>
                <ul>
                    <li><a href="{{ route('kelola-anggota') }}">Kelola Anggota</a></li>
                    <li><a href="{{ route('dashboard-admin') }}">Dashboard</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h4 class="footer-col-title">Kebijakan</h4>
                <ul>
                    <li><a href="#">Privacy Policy</a></li>
                    <li><a href="#">Terms of Service</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h4 class="footer-col-title">Hubungi Kami</h4>
                <address>library@smait-aluswah.sch.id<br>Surabaya, Jawa Timur</address>
            </div>
        </div>
        <div class="footer-bottom">
            <p>© 2026 Perpustakaan SMAIT Al-Uswah. Menjaga Tradisi, Membangun Literasi.</p>
        </div>
    </footer>

    <script src="{{ asset('js/script-tambah-anggota.js') }}"></script>
</body>
</html>