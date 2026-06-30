<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input Peminjaman Baru – Perpustakaan SMAIT Al-Uswah</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style-home.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style-home-anggota.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style-home-admin.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style-input-peminjaman.css') }}">
</head>
<body class="admin-page">

    {{-- ===== NAVBAR ===== --}}
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
                <a href="{{ route('riwayat-transaksi') }}" class="nav-link active">Transaksi</a>
                <a href="{{ route('kelola-denda') }}" class="nav-link">Denda</a>
            </nav>
            <a href="{{ route('setting') }}" class="nav-profile">
                <div class="nav-avatar"><div class="avatar-placeholder admin-avatar">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                </div></div>
                <div class="nav-profile-info">
                    <span class="nav-username">{{ auth()->user()?->nama_lengkap ?? 'Admin' }}</span>
                    <span class="nav-role">Administrator</span>
                </div>
            </a>
        </div>
    </header>

    {{-- ===== STEPPER ===== --}}
    <section class="ip-stepper-section">
        <div class="ip-stepper-inner">
            <div class="ip-stepper">
                <div class="ip-step active" id="step-ind-1">
                    <div class="ip-step-circle">1</div>
                    <span class="ip-step-label">Pilih Anggota</span>
                </div>
                <div class="ip-step-line" id="line-1"></div>
                <div class="ip-step" id="step-ind-2">
                    <div class="ip-step-circle">2</div>
                    <span class="ip-step-label">Pilih Buku</span>
                </div>
                <div class="ip-step-line" id="line-2"></div>
                <div class="ip-step" id="step-ind-3">
                    <div class="ip-step-circle">3</div>
                    <span class="ip-step-label">Konfirmasi</span>
                </div>
            </div>
        </div>
    </section>

    {{-- ===== HERO ===== --}}
    <section class="ip-hero">
        <div class="ip-hero-inner">
            <div>
                <span class="ip-eyebrow">Formulir Digital</span>
                <h1 class="ip-title">Input Peminjaman Baru</h1>
                <p class="ip-desc">
                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#2D7076" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                    Silakan isi data peminjaman dengan teliti.
                </p>
            </div>
            <div class="ip-hero-deco">
                <svg xmlns="http://www.w3.org/2000/svg" width="72" height="72" viewBox="0 0 24 24" fill="none" stroke="rgba(45,112,118,.15)" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>
            </div>
        </div>
    </section>

    {{-- ===== MAIN GRID ===== --}}
    <section class="ip-main">
        <div class="ip-main-inner">
            <div class="ip-grid">

                {{-- ===== LEFT COLUMN ===== --}}
                <div class="ip-left">

                    {{-- PANEL 1: Informasi Anggota --}}
                    <div class="ip-panel" id="panelAnggota">
                        <div class="ip-panel-head">
                            <div class="ip-panel-ic">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#2D7076" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                            </div>
                            <h2 class="ip-panel-title">Informasi Anggota</h2>
                        </div>

                        <label class="ip-label">Cari Nama atau NIS Anggota</label>
                        <div class="ip-anggota-search-wrap">
                            <svg class="ip-search-ic" xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="#2D7076" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                            <input type="text" id="searchAnggota" class="ip-anggota-search" placeholder="Ketik nama atau NIS...">
                            <div class="ip-anggota-dropdown" id="anggotaDropdown"></div>
                        </div>
                        <span class="ip-err" id="err-anggota"></span>

                        {{-- Card anggota terpilih --}}
                        <div class="ip-anggota-selected hidden" id="anggotaSelected">
                            <div class="ip-anggota-card">
                                <div class="ip-anggota-avatar" id="selAvatar">AF</div>
                                <div class="ip-anggota-info">
                                    <span class="ip-anggota-nama" id="selNama">Ahmad Fathoni</span>
                                    <span class="ip-anggota-meta" id="selMeta">NIS: 20210045 · XI-MIPA 1</span>
                                    <span class="ip-anggota-email" id="selEmail">ahmad.f@uswah.sch.id</span>
                                </div>
                                <button type="button" class="ip-anggota-clear" id="btnClearAnggota" title="Ganti anggota">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                                </button>
                            </div>
                        </div>
                    </div>

                    {{-- PANEL 2: Daftar Buku --}}
                    <div class="ip-panel" id="panelBuku">
                        <div class="ip-panel-head">
                            <div class="ip-panel-ic">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#2D7076" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>
                            </div>
                            <h2 class="ip-panel-title">Daftar Buku</h2>
                        </div>

                        <label class="ip-label">Tambah Buku ke Daftar</label>
                        <div class="ip-buku-search-row">
                            <div class="ip-buku-search-wrap">
                                <input type="text" id="searchBuku" class="ip-buku-search" placeholder="Judul Buku, Pengarang, atau ISBN...">
                            </div>
                            <button type="button" class="btn-ip-cari" id="btnCariSaran">
                                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                                Cari
                            </button>
                        </div>
                        <div class="ip-buku-saran hidden" id="bukuSaran"></div>
                        <span class="ip-err" id="err-buku"></span>

                        <div class="ip-buku-terpilih-head hidden" id="bukuTerpilihHead">
                            <span class="ip-buku-terpilih-label" id="bukuTerpilihLabel">Buku Terpilih (0)</span>
                        </div>
                        <ul class="ip-buku-list" id="bukuList"></ul>
                    </div>

                    {{-- PANEL 3: Detail Transaksi --}}
                    <div class="ip-panel" id="panelDetail">
                        <div class="ip-panel-head">
                            <div class="ip-panel-ic">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#2D7076" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                            </div>
                            <h2 class="ip-panel-title">Detail Transaksi</h2>
                        </div>

                        <div class="ip-form-row">
                            <div class="ip-form-group">
                                <label class="ip-label" for="tglPinjam">Tanggal Pinjam <span class="ip-req">*</span></label>
                                <input type="date" id="tglPinjam" name="tglPinjam">
                                <span class="ip-err" id="err-tglPinjam"></span>
                            </div>
                            <div class="ip-form-group">
                                <label class="ip-label" for="tglTempo">Tanggal Jatuh Tempo <span class="ip-req">*</span></label>
                                <input type="date" id="tglTempo" name="tglTempo">
                                <span class="ip-err" id="err-tglTempo"></span>
                            </div>
                        </div>

                        <div class="ip-form-group">
                            <label class="ip-label" for="catatan">Catatan Tambahan (Opsional)</label>
                            <textarea id="catatan" name="catatan" rows="4" placeholder="Contoh: Kondisi buku sedikit menguning..."></textarea>
                        </div>
                    </div>

                </div>

                {{-- ===== RIGHT: RINGKASAN ===== --}}
                <div class="ip-right">
                    <div class="ip-ringkasan">
                        <div class="ip-ring-head">
                            <h3 class="ip-ring-title">Ringkasan</h3>
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="rgba(45,112,118,.35)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                        </div>

                        <div class="ip-ring-rows">
                            <div class="ip-ring-row">
                                <span class="ip-ring-lbl">Total Buku</span>
                                <span class="ip-ring-val" id="ringTotalBuku">0 Eksemplar</span>
                            </div>
                            <div class="ip-ring-row">
                                <span class="ip-ring-lbl">Lama Pinjam</span>
                                <span class="ip-ring-val" id="ringLamaPinjam">– Hari</span>
                            </div>
                            <div class="ip-ring-row">
                                <span class="ip-ring-lbl">Jatuh Tempo</span>
                                <span class="ip-ring-val" id="ringJatuhTempo">–</span>
                            </div>
                            <div class="ip-ring-row">
                                <span class="ip-ring-lbl">Status</span>
                                <span class="ip-ring-badge" id="ringStatus">DRAFT</span>
                            </div>
                        </div>

                        <button type="button" class="btn-ip-simpan" id="btnSimpan">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                            Simpan Transaksi
                        </button>

                        <button type="button" class="btn-ip-batal" id="btnBatal">Batal &amp; Bersihkan</button>

                        <div class="ip-tips">
                            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#2D7076" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>
                            <span>Tips: Pastikan anggota dan buku sudah benar sebelum menyimpan transaksi.</span>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    {{-- ===== MODAL SUKSES ===== --}}
    <div class="ip-modal" id="ipModalSukses">
        <div class="ip-modal-inner">
            <div class="ip-modal-ic ic-green">
                <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="#16a085" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
            </div>
            <h3 class="ip-modal-title" style="color:#16a085;">Transaksi Berhasil Disimpan!</h3>
            <p class="ip-modal-desc" id="modalSuksesDesc">Peminjaman atas nama <strong id="modalSuksesNama"></strong> sebanyak <strong id="modalSuksesBuku"></strong> buku telah berhasil dicatat.</p>
            <div class="ip-modal-detail" id="modalSuksesDetail"></div>
            <div class="ip-modal-btns">
                <button class="ip-modal-btn btn-ip-ok" id="btnModalOk">OK, Lihat Riwayat Transaksi</button>
                <button class="ip-modal-btn-sec" id="btnModalBaru">Input Peminjaman Baru</button>
            </div>
        </div>
    </div>

    {{-- ===== MODAL KONFIRMASI BATAL ===== --}}
    <div class="ip-modal" id="ipModalBatal">
        <div class="ip-modal-inner">
            <div class="ip-modal-ic ic-red">
                <svg xmlns="http://www.w3.org/2000/svg" width="34" height="34" viewBox="0 0 24 24" fill="none" stroke="#c0392b" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
            </div>
            <h3 class="ip-modal-title" style="color:#c0392b;">Batal &amp; Bersihkan Form?</h3>
            <p class="ip-modal-desc">Semua data yang sudah diisi akan direset. Tindakan ini tidak bisa dibatalkan.</p>
            <div class="ip-modal-btns">
                <button class="ip-modal-btn btn-ip-konfirm-batal" id="btnKonfirmBatal">Ya, Bersihkan</button>
                <button class="ip-modal-btn-sec" id="btnBatalTutup">Kembali</button>
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
                    <a href="#" class="social-btn" aria-label="Email"><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,12 2,6"/></svg></a>
                </div>
            </div>
            <div class="footer-col">
                <h4 class="footer-col-title">Navigasi</h4>
                <ul><li><a href="{{ route('riwayat-transaksi') }}">Riwayat Transaksi</a></li><li><a href="{{ route('kelola-buku') }}">Kelola Buku</a></li></ul>
            </div>
            <div class="footer-col">
                <h4 class="footer-col-title">Kebijakan</h4>
                <ul><li><a href="#">SOP Peminjaman</a></li><li><a href="#">Aturan Denda</a></li></ul>
            </div>
            <div class="footer-col">
                <h4 class="footer-col-title">Hubungi Kami</h4>
                <address>library@smait-aluswah.sch.id<br>Surabaya, Jawa Timur</address>
            </div>
        </div>
        <div class="footer-bottom"><p>© 2026 Perpustakaan SMAIT Al-Uswah. Menjaga Tradisi, Membangun Literasi.</p></div>
    </footer>

    <script src="{{ asset('js/script-input-peminjaman.js') }}"></script>
</body>
</html>