@php
$dataBuku = [
    1 => [
        'judul' => 'Laskar Pelangi', 'isbn' => '979-3062-79-7', 'tahun' => 2005,
        'pengarang' => 'Andrea Hirata', 'penerbit' => 'Bentang Pustaka',
        'kategori' => 'fiksi', 'rak' => 'F-001', 'stok' => 8,
        'status' => 'Tersedia', 'status_class' => 'tersedia',
        'cover' => 'Laskar_pelangi_sampul.jpg', 'id_buku' => 'BUKU-2026-001',
        'peminjaman' => 88, 'populer' => true,
        'sinopsis' => 'Novel karya Andrea Hirata yang mengisahkan perjuangan anak-anak Belitung dalam meraih pendidikan. Penuh semangat dan inspirasi.',
    ],
    2 => [
        'judul' => 'Dunia Sophie', 'isbn' => '978-602-441-020-9', 'tahun' => 1996,
        'pengarang' => 'Jostein Gaarder', 'penerbit' => 'Mizan',
        'kategori' => 'filsafat', 'rak' => 'F-010', 'stok' => 5,
        'status' => 'Tersedia', 'status_class' => 'tersedia',
        'cover' => 'dunia-sophie-sampul.jpg', 'id_buku' => 'BUKU-2026-002',
        'peminjaman' => 72, 'populer' => false,
        'sinopsis' => 'Novel filsafat yang membawa pembaca menyelami sejarah pemikiran manusia melalui perjalanan seorang gadis bernama Sophie.',
    ],
    3 => [
        'judul' => 'Sejarah Peradaban Islam', 'isbn' => '979-421-337-3', 'tahun' => 2008,
        'pengarang' => 'Prof. Dr. Badri Yatim, M.A.', 'penerbit' => 'Rajawali Pers',
        'kategori' => 'sejarah', 'rak' => 'S-105', 'stok' => 2,
        'status' => 'Stok Sedikit', 'status_class' => 'sedikit',
        'cover' => 'sejarah-peradaban-silam-sampul.png', 'id_buku' => 'BUKU-2026-003',
        'peminjaman' => 54, 'populer' => false,
        'sinopsis' => 'Buku referensi akademis tentang perjalanan peradaban Islam dari masa Nabi Muhammad SAW hingga era modern.',
    ],
    4 => [
        'judul' => 'The Things You Can See Only When You Slow Down', 'isbn' => '978-602-481-365-9', 'tahun' => 2020,
        'pengarang' => 'Haemin Sunim', 'penerbit' => 'POP (KPG)',
        'kategori' => 'motivasi', 'rak' => 'M-022', 'stok' => 0,
        'status' => 'Tidak Tersedia', 'status_class' => 'habis',
        'cover' => 'slow-down-sampul.jpg', 'id_buku' => 'BUKU-2026-004',
        'peminjaman' => 48, 'populer' => true,
        'sinopsis' => 'Kumpulan kebijaksanaan dari biksu Buddha Korea yang mengajak kita memperlambat langkah dan menemukan keindahan dalam kesederhanaan.',
    ],
];
$id = request()->route('id') ?? request('id') ?? 1;
$buku = $dataBuku[$id] ?? $dataBuku[1];
@endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Buku – {{ $buku['judul'] }} – Perpustakaan SMAIT Al-Uswah</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style-home.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style-home-anggota.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style-home-admin.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style-edit-buku.css') }}">
</head>
<body class="admin-page">

    {{-- NAVBAR --}}
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

    {{-- HERO --}}
    <section class="eb-hero">
        <div class="eb-hero-inner">
            <div>
                <span class="eb-eyebrow">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#b8742f" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="8" y1="6" x2="21" y2="6"/><line x1="8" y1="12" x2="21" y2="12"/><line x1="8" y1="18" x2="21" y2="18"/><line x1="3" y1="6" x2="3.01" y2="6"/><line x1="3" y1="12" x2="3.01" y2="12"/><line x1="3" y1="18" x2="3.01" y2="18"/></svg>
                    Manajemen Koleksi
                </span>
                <h1 class="eb-title">Edit Data Buku</h1>
                <p class="eb-desc">Perbarui informasi koleksi buku perpustakaan untuk memastikan data tetap akurat.</p>
            </div>
            <div class="eb-hero-star">
                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="#b8742f" stroke="none"><path d="M12 2l2.4 7.4H22l-6.2 4.5 2.4 7.4L12 17l-6.2 4.3 2.4-7.4L2 9.4h7.6z"/></svg>
            </div>
        </div>
    </section>

    {{-- MAIN GRID --}}
    <section class="eb-main">
        <div class="eb-main-inner">
            <form id="editBukuForm" novalidate>
                <div class="eb-grid">

                    {{-- LEFT: Pratinjau --}}
                    <div class="eb-left">
                        <div class="eb-preview-card">
                            <div class="eb-preview-head">
                                <h3 class="eb-preview-title">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#b8742f" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="3" width="20" height="14" rx="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg>
                                    Pratinjau Saat Ini
                                </h3>
                                <span class="eb-status-badge badge-{{ $buku['status_class'] }}">{{ $buku['status'] }}</span>
                            </div>

                            {{-- Cover --}}
                            <div class="eb-cover-wrap" id="ebCoverWrap">
                                <img src="{{ asset('assets/' . $buku['cover']) }}" alt="{{ $buku['judul'] }}" class="eb-cover-img" id="ebCoverImg">
                                <input type="file" id="ebCoverInput" accept="image/jpeg,image/png,image/webp" hidden>
                            </div>

                            <h3 class="eb-preview-judul">{{ $buku['judul'] }}</h3>
                            <p class="eb-preview-id">ID: {{ $buku['id_buku'] }}</p>

                            <button type="button" class="btn-ganti-sampul" id="btnGantiSampul">
                                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                                Ganti Sampul
                            </button>

                            <div class="eb-stats">
                                <div class="eb-stat">
                                    <span class="eb-stat-label">PEMINJAMAN</span>
                                    <span class="eb-stat-value">{{ $buku['peminjaman'] }}</span>
                                </div>
                                <div class="eb-stat">
                                    <span class="eb-stat-label">POPULER</span>
                                    <span class="eb-stat-value">
                                        @if($buku['populer'])
                                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="#b8742f" stroke="none"><path d="M12 2l2.4 7.4H22l-6.2 4.5 2.4 7.4L12 17l-6.2 4.3 2.4-7.4L2 9.4h7.6z"/></svg>
                                        @else
                                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#ccc" stroke-width="2"><path d="M12 2l2.4 7.4H22l-6.2 4.5 2.4 7.4L12 17l-6.2 4.3 2.4-7.4L2 9.4h7.6z"/></svg>
                                        @endif
                                    </span>
                                </div>
                            </div>

                            <div class="eb-tips">
                                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#2D7076" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>
                                <div>
                                    <strong>Tips Editor</strong>
                                    <p>Pastikan judul, ISBN, dan pengarang sesuai data fisik buku sebelum menyimpan perubahan.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- RIGHT: Form --}}
                    <div class="eb-right">

                        {{-- Panel Informasi Buku --}}
                        <div class="eb-panel">
                            <div class="eb-panel-head">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#2D7076" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>
                                <h2 class="eb-panel-title">Informasi Buku</h2>
                            </div>
                            <div class="eb-panel-divider"></div>

                            <div class="eb-form-group">
                                <label for="judul">Judul Buku <span class="eb-req">*</span></label>
                                <input type="text" id="judul" name="judul" value="{{ $buku['judul'] }}">
                                <span class="eb-err" id="err-judul"></span>
                            </div>

                            <div class="eb-form-row">
                                <div class="eb-form-group">
                                    <label for="isbn">ISBN <span class="eb-req">*</span></label>
                                    <input type="text" id="isbn" name="isbn" value="{{ $buku['isbn'] }}">
                                    <span class="eb-err" id="err-isbn"></span>
                                </div>
                                <div class="eb-form-group">
                                    <label for="kategori">Kategori <span class="eb-req">*</span></label>
                                    <div class="eb-select-wrap">
                                        <select id="kategori" name="kategori">
                                            <option value="fiksi"     @if($buku['kategori']==='fiksi')     selected @endif>Fiksi</option>
                                            <option value="sejarah"   @if($buku['kategori']==='sejarah')   selected @endif>Sejarah</option>
                                            <option value="sains"     @if($buku['kategori']==='sains')     selected @endif>Sains</option>
                                            <option value="agama"     @if($buku['kategori']==='agama')     selected @endif>Agama</option>
                                            <option value="filsafat"  @if($buku['kategori']==='filsafat')  selected @endif>Filsafat</option>
                                            <option value="motivasi"  @if($buku['kategori']==='motivasi')  selected @endif>Motivasi</option>
                                        </select>
                                        <svg class="eb-select-arrow" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#2D7076" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg>
                                    </div>
                                </div>
                            </div>

                            <div class="eb-form-row">
                                <div class="eb-form-group">
                                    <label for="pengarang">Pengarang <span class="eb-req">*</span></label>
                                    <input type="text" id="pengarang" name="pengarang" value="{{ $buku['pengarang'] }}">
                                    <span class="eb-err" id="err-pengarang"></span>
                                </div>
                                <div class="eb-form-group">
                                    <label for="penerbit">Penerbit <span class="eb-req">*</span></label>
                                    <input type="text" id="penerbit" name="penerbit" value="{{ $buku['penerbit'] }}">
                                    <span class="eb-err" id="err-penerbit"></span>
                                </div>
                            </div>
                        </div>

                        {{-- Panel Lokasi & Stok --}}
                        <div class="eb-panel">
                            <div class="eb-panel-head">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#2D7076" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                                <h2 class="eb-panel-title">Lokasi &amp; Stok</h2>
                            </div>
                            <div class="eb-panel-divider"></div>

                            <div class="eb-form-row eb-form-row-3">
                                <div class="eb-form-group">
                                    <label for="rak">Rak <span class="eb-req">*</span></label>
                                    <input type="text" id="rak" name="rak" value="{{ $buku['rak'] }}">
                                    <span class="eb-err" id="err-rak"></span>
                                </div>
                                <div class="eb-form-group">
                                    <label for="stok">Stok Total <span class="eb-req">*</span></label>
                                    <input type="number" id="stok" name="stok" value="{{ $buku['stok'] }}" min="0">
                                    <span class="eb-err" id="err-stok"></span>
                                </div>
                            </div>
                        </div>

                        {{-- Panel Deskripsi --}}
                        <div class="eb-panel">
                            <div class="eb-panel-head">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#2D7076" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
                                <h2 class="eb-panel-title">Deskripsi</h2>
                            </div>
                            <div class="eb-panel-divider"></div>

                            <div class="eb-form-group">
                                <label for="sinopsis">Sinopsis / Ringkasan</label>
                                <textarea id="sinopsis" name="sinopsis" rows="6">{{ $buku['sinopsis'] }}</textarea>
                            </div>
                        </div>

                        {{-- Tombol Aksi --}}
                        <div class="eb-actions">
                            <button type="button" class="btn-hapus-buku" id="btnHapusBuku">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                                Hapus Buku
                            </button>
                            <div class="eb-actions-right">
                                <a href="{{ route('kelola-buku') }}" class="btn-batal-edit">Batal</a>
                                <button type="submit" class="btn-simpan-edit">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                                    Simpan Perubahan
                                </button>
                            </div>
                        </div>

                    </div>
                </div>
            </form>
        </div>
    </section>

    {{-- MODAL SIMPAN SUKSES --}}
    <div class="eb-modal" id="modalSimpan">
        <div class="eb-modal-inner">
            <div class="eb-modal-ic ic-green">
                <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="#16a085" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
            </div>
            <h3 class="eb-modal-title green">Perubahan Tersimpan!</h3>
            <p class="eb-modal-desc">Data buku <strong id="simpanJudul"></strong> berhasil diperbarui.</p>
            <button class="btn-modal-ok ok-green" id="btnOkSimpan">OK, Kembali ke Kelola Buku</button>
        </div>
    </div>

    {{-- MODAL KONFIRMASI HAPUS --}}
    <div class="eb-modal" id="modalHapus">
        <div class="eb-modal-inner">
            <div class="eb-modal-ic ic-red">
                <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="#c0392b" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/><line x1="10" y1="11" x2="10" y2="17"/><line x1="14" y1="11" x2="14" y2="17"/></svg>
            </div>
            <h3 class="eb-modal-title red">Hapus Buku?</h3>
            <p class="eb-modal-desc">Kamu yakin ingin menghapus <strong>{{ $buku['judul'] }}</strong>? Tindakan ini tidak bisa dibatalkan.</p>
            <div class="eb-modal-btns">
                <button class="btn-modal-ok ok-red" id="btnKonfirmasiHapus">Ya, Hapus Buku</button>
                <button class="btn-modal-batal" id="btnBatalHapus">Batal</button>
            </div>
        </div>
    </div>

    {{-- MODAL HAPUS SUKSES --}}
    <div class="eb-modal" id="modalHapusSukses">
        <div class="eb-modal-inner">
            <div class="eb-modal-ic ic-green">
                <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="#16a085" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
            </div>
            <h3 class="eb-modal-title green">Buku Dihapus!</h3>
            <p class="eb-modal-desc">Buku <strong>{{ $buku['judul'] }}</strong> telah berhasil dihapus dari koleksi.</p>
            <button class="btn-modal-ok ok-green" id="btnOkHapus">OK, Kembali ke Kelola Buku</button>
        </div>
    </div>

    {{-- FOOTER --}}
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
                <ul><li><a href="{{ route('kelola-buku') }}">Kelola Buku</a></li><li><a href="{{ route('tambah-buku') }}">Tambah Buku</a></li></ul>
            </div>
            <div class="footer-col">
                <h4 class="footer-col-title">Dukungan</h4>
                <ul><li><a href="#">Panduan Perpustakaan</a></li><li><a href="#">Peraturan Anggota</a></li></ul>
            </div>
            <div class="footer-col">
                <h4 class="footer-col-title">Kontak Kami</h4>
                <address>library@smait-aluswah.sch.id<br>Surabaya, Jawa Timur</address>
            </div>
        </div>
        <div class="footer-bottom"><p>© 2026 Perpustakaan SMAIT Al-Uswah. Menjaga Tradisi, Membangun Literasi.</p></div>
    </footer>

    <script src="{{ asset('js/script-edit-buku.js') }}"></script>
</body>
</html>