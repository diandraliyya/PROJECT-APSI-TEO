<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Buku Baru – Perpustakaan SMAIT Al-Uswah</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style-home.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style-home-anggota.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style-home-admin.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style-tambah-buku.css') }}">
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
                <a href="{{ route('kelola-buku') }}" class="nav-link active">Buku</a>
                <a href="{{ route('kelola-anggota') }}" class="nav-link">Anggota</a>
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
    <section class="tb-hero">
        <div class="tb-hero-inner">
            <div class="tb-hero-left">
                <h1 class="tb-title">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#2D7076" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>
                    Tambah Buku Baru
                    <span class="tb-title-star">
                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="#b8742f" stroke="none"><path d="M12 2l1.5 5.5L19 9l-5.5 1.5L12 16l-1.5-5.5L5 9l5.5-1.5z"/></svg>
                    </span>
                </h1>
                <p class="tb-desc">Lengkapi data koleksi perpustakaan dengan teliti untuk memudahkan siswa dalam menemukan inspirasi belajar mereka.</p>
            </div>
            <div class="tb-hero-deco">
                <svg xmlns="http://www.w3.org/2000/svg" width="52" height="52" viewBox="0 0 24 24" fill="none" stroke="rgba(184,116,47,.3)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
            </div>
        </div>
    </section>

    {{-- ===== MAIN FORM ===== --}}
    <section class="tb-main">
        <div class="tb-main-inner">
            <form id="tambahBukuForm" novalidate>

                <div class="tb-grid">

                    {{-- ===== LEFT: Cover Upload ===== --}}
                    <div class="tb-left">
                        <div class="tb-cover-panel">
                            <div class="tb-cover-head">
                                <h3 class="tb-cover-title">Upload Cover Buku</h3>
                                <p class="tb-cover-sub">Pastikan format JPG/PNG, maks 2MB.</p>
                            </div>

                            <div class="tb-cover-drop" id="coverDrop">
                                <div class="tb-cover-preview hidden" id="coverPreview">
                                    <img id="coverImg" src="" alt="Preview Cover">
                                    <button type="button" class="tb-cover-remove" id="coverRemove" title="Hapus foto">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                                    </button>
                                </div>

                                <div class="tb-cover-placeholder" id="coverPlaceholder">
                                    <div class="tb-cover-ic">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="#90C3C6" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                                    </div>
                                    <span class="tb-cover-cta">Klik untuk Unggah</span>
                                    <span class="tb-cover-hint">Seret dan letakkan file di sini</span>
                                </div>

                                <input type="file" id="coverInput" accept="image/jpeg,image/png,image/webp" hidden>
                            </div>

                            <p class="tb-cover-rasio">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#2D7076" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>
                                Rasio 3:4 sangat disarankan
                            </p>
                        </div>
                    </div>

                    {{-- ===== RIGHT: Form Fields ===== --}}
                    <div class="tb-right">

                        {{-- Panel: Informasi Buku --}}
                        <div class="tb-panel">
                            <div class="tb-panel-head">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#2D7076" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>
                                <h2 class="tb-panel-title">Informasi Buku</h2>
                            </div>
                            <div class="tb-panel-divider"></div>

                            <div class="tb-form-group">
                                <label for="judul">Judul Buku <span class="tb-required">*</span></label>
                                <input type="text" id="judul" name="judul" placeholder="Contoh: Laskar Pelangi">
                                <span class="tb-err" id="err-judul"></span>
                            </div>

                            <div class="tb-form-row">
                                <div class="tb-form-group">
                                    <label for="isbn">ISBN <span class="tb-required">*</span></label>
                                    <input type="text" id="isbn" name="isbn" placeholder="978-602-...">
                                    <span class="tb-err" id="err-isbn"></span>
                                </div>
                                <div class="tb-form-group">
                                    <label for="tahun">Tahun Terbit <span class="tb-required">*</span></label>
                                    <input type="number" id="tahun" name="tahun" placeholder="2026" min="1900" max="2099">
                                    <span class="tb-err" id="err-tahun"></span>
                                </div>
                            </div>

                            <div class="tb-form-row">
                                <div class="tb-form-group">
                                    <label for="pengarang">Pengarang <span class="tb-required">*</span></label>
                                    <input type="text" id="pengarang" name="pengarang" placeholder="Nama Penulis">
                                    <span class="tb-err" id="err-pengarang"></span>
                                </div>
                                <div class="tb-form-group">
                                    <label for="penerbit">Penerbit <span class="tb-required">*</span></label>
                                    <input type="text" id="penerbit" name="penerbit" placeholder="Nama Penerbit">
                                    <span class="tb-err" id="err-penerbit"></span>
                                </div>
                            </div>
                        </div>

                        {{-- Panel: Lokasi & Stok --}}
                        <div class="tb-panel">
                            <div class="tb-panel-head">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#2D7076" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="5" rx="1"/><rect x="3" y="10" width="18" height="5" rx="1"/><rect x="3" y="17" width="18" height="5" rx="1"/></svg>
                                <h2 class="tb-panel-title">Lokasi &amp; Stok</h2>
                            </div>
                            <div class="tb-panel-divider"></div>

                            <div class="tb-form-row">
                                <div class="tb-form-group">
                                    <label for="kategori">Kategori <span class="tb-required">*</span></label>
                                    <div class="tb-select-wrap">
                                        <select id="kategori" name="kategori">
                                            <option value="">Pilih Kategori</option>
                                            <option value="fiksi">Fiksi</option>
                                            <option value="sejarah">Sejarah</option>
                                            <option value="sains">Sains</option>
                                            <option value="agama">Agama</option>
                                            <option value="filsafat">Filsafat</option>
                                            <option value="motivasi">Motivasi</option>
                                        </select>
                                        <svg class="tb-select-arrow" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#2D7076" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg>
                                    </div>
                                    <span class="tb-err" id="err-kategori"></span>
                                </div>
                                <div class="tb-form-group">
                                    <label for="stok">Jumlah Stok <span class="tb-required">*</span></label>
                                    <input type="number" id="stok" name="stok" placeholder="1" min="0" value="1">
                                    <span class="tb-err" id="err-stok"></span>
                                </div>
                            </div>

                            <div class="tb-form-row">
                                <div class="tb-form-group">
                                    <label for="rak">Rak Penyimpanan <span class="tb-required">*</span></label>
                                    <div class="tb-select-wrap">
                                        <select id="rak" name="rak">
                                            <option value="">Pilih Rak</option>
                                            <option value="F">Rak F – Fiksi</option>
                                            <option value="S">Rak S – Sejarah</option>
                                            <option value="SC">Rak SC – Sains</option>
                                            <option value="AG">Rak AG – Agama</option>
                                            <option value="FL">Rak FL – Filsafat</option>
                                            <option value="M">Rak M – Motivasi</option>
                                        </select>
                                        <svg class="tb-select-arrow" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#2D7076" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg>
                                    </div>
                                    <span class="tb-err" id="err-rak"></span>
                                </div>
                            </div>
                        </div>

                                                {{-- Panel: Deskripsi --}}
                        <div class="tb-panel">
                            <div class="tb-panel-head">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#2D7076" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
                                <h2 class="tb-panel-title">Deskripsi</h2>
                            </div>
                            <div class="tb-panel-divider"></div>

                            <div class="tb-form-group">
                                <label for="sinopsis">Sinopsis / Ringkasan</label>
                                <textarea id="sinopsis" name="sinopsis" rows="6" placeholder="Masukkan ringkasan isi buku atau keterangan tambahan..."></textarea>
                            </div>
                        </div>

                    </div>
                </div>

                {{-- ===== TOMBOL AKSI ===== --}}
                <div class="tb-actions">
                    <button type="submit" class="btn-simpan-buku">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                        Simpan Buku
                    </button>
                    <a href="{{ route('kelola-buku') }}" class="btn-batal-buku">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                        Batal
                    </a>
                </div>

            </form>
        </div>
    </section>

    {{-- ===== MODAL SUKSES ===== --}}
    <div class="success-modal" id="successModal">
        <div class="success-modal-inner">
            <div class="success-modal-ic">
                <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="#16a085" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
            </div>
            <h3 class="success-modal-title">Buku Berhasil Disimpan!</h3>
            <p class="success-modal-desc">Data buku baru telah berhasil ditambahkan ke koleksi perpustakaan.</p>
            <button class="btn-ok-sukses" id="btnOkSukses">OK, Kembali ke Kelola Buku</button>
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
                    <li><a href="{{ route('kelola-buku') }}">Kelola Buku</a></li>
                    <li><a href="{{ route('kategori-rak') }}">Kategori &amp; Rak</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h4 class="footer-col-title">Dukungan</h4>
                <ul>
                    <li><a href="#">Panduan Perpustakaan</a></li>
                    <li><a href="#">Aturan Peminjaman</a></li>
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

    <script src="{{ asset('js/script-tambah-buku.js') }}"></script>
</body>
</html>