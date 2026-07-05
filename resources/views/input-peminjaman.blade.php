@php
    $adminName = session('auth_name') ?? 'Admin';

    $tanggalPinjamDefault = old('tanggal_pinjam', now()->toDateString());
    $tanggalTempoDefault = old('tanggal_jatuh_tempo', now()->addDays(7)->toDateString());

    $anggotaData = $anggotas->map(function ($anggota) {
        return [
            'id' => $anggota->id,
            'nama' => $anggota->nama_anggota,
            'nis' => $anggota->nis,
            'no_anggota' => $anggota->no_anggota,
            'kelas' => $anggota->kelas,
            'email' => $anggota->email,
        ];
    })->values()->toArray();

    $bukuData = $bukus->map(function ($buku) {
        return [
            'id' => $buku->id,
            'judul' => $buku->judul_buku,
            'penulis' => $buku->penulis,
            'isbn' => $buku->isbn,
            'stok' => $buku->stok_tersedia,
        ];
    })->values()->toArray();
@endphp

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
                    <span class="nav-username">{{ $adminName }}</span>
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

            @if (session('error'))
                <div style="background:#fff3f3; border:1px solid #f3b5b5; color:#9f2f2f; padding:14px 18px; border-radius:14px; margin-bottom:18px;">
                    {{ session('error') }}
                </div>
            @endif

            @if ($errors->any())
                <div style="background:#fff3f3; border:1px solid #f3b5b5; color:#9f2f2f; padding:14px 18px; border-radius:14px; margin-bottom:18px;">
                    <strong>Transaksi belum bisa disimpan.</strong>
                    <ul style="margin:8px 0 0 18px;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form id="formPeminjaman" action="{{ url('/input-peminjaman') }}" method="POST">
                @csrf

                <input type="hidden" name="anggota_id" id="anggotaId" value="{{ old('anggota_id') }}">
                <div id="bukuHiddenInputs"></div>

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
                            <span class="ip-err" id="err-anggota">@error('anggota_id') {{ $message }} @enderror</span>

                            <div class="ip-anggota-selected hidden" id="anggotaSelected" style="display:none;">
                                <div class="ip-anggota-card">
                                    <div class="ip-anggota-avatar" id="selAvatar">A</div>
                                    <div class="ip-anggota-info">
                                        <span class="ip-anggota-nama" id="selNama">Nama Anggota</span>
                                        <span class="ip-anggota-meta" id="selMeta">NIS: - · -</span>
                                        <span class="ip-anggota-email" id="selEmail">-</span>
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

                            <div class="ip-buku-saran hidden" id="bukuSaran" style="display:none;"></div>
                            <span class="ip-err" id="err-buku">@error('buku_id') {{ $message }} @enderror</span>

                            <div class="ip-buku-terpilih-head hidden" id="bukuTerpilihHead" style="display:none;">
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
                                    <input type="date" id="tglPinjam" name="tanggal_pinjam" value="{{ $tanggalPinjamDefault }}" required>
                                    <span class="ip-err" id="err-tglPinjam">@error('tanggal_pinjam') {{ $message }} @enderror</span>
                                </div>

                                <div class="ip-form-group">
                                    <label class="ip-label" for="tglTempo">Tanggal Jatuh Tempo <span class="ip-req">*</span></label>
                                    <input type="date" id="tglTempo" name="tanggal_jatuh_tempo" value="{{ $tanggalTempoDefault }}" required>
                                    <span class="ip-err" id="err-tglTempo">@error('tanggal_jatuh_tempo') {{ $message }} @enderror</span>
                                </div>
                            </div>

                            <div class="ip-form-group">
                                <label class="ip-label" for="catatan">Catatan Tambahan (Opsional)</label>
                                <textarea id="catatan" name="catatan" rows="4" placeholder="Contoh: Kondisi buku="catatan" rows="4" placeholder="Contoh: Kondisi buku sedikit menguning...">{{ old('catatan') }}</textarea>
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

                            <button type="submit" class="btn-ip-simpan" id="btnSimpan">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                                Simpan Transaksi
                            </button>

                            <button type="button" class="btn-ip-batal" onclick="bersihkanFormPeminjaman()">
                                Batal &amp; Bersihkan
                            </button>

                            <div class="ip-tips">
                                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#2D7076" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>
                                <span>Tips: Pastikan anggota dan buku sudah benar sebelum menyimpan transaksi.</span>
                            </div>
                        </div>
                    </div>

                </div>
            </form>
        </div>
    </section>

    {{-- ===== MODAL KONFIRMASI BATAL ===== --}}
    <div class="ip-modal" id="ipModalBatal">
        <div class="ip-modal-inner">
            <div class="ip-modal-ic ic-red">
                <svg xmlns="http://www.w3.org/2000/svg" width="34" height="34" viewBox="0 0 24 24" fill="none" stroke="#c0392b" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
            </div>
            <h3 class="ip-modal-title" style="color:#c0392b;">Batal &amp; Bersihkan Form?</h3>
            <p class="ip-modal-desc">Semua data yang sudah diisi akan direset. Tindakan ini tidak bisa dibatalkan.</p>
            <div class="ip-modal-btns">
                <button type="button" class="ip-modal-btn btn-ip-konfirm-batal" id="btnKonfirmBatal">Ya, Bersihkan</button>
                <button type="button" class="ip-modal-btn-sec" id="btnBatalTutup">Kembali</button>
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
                <h4 class="footer-col-title">Navigasi</h4>
                <ul>
                    <li><a href="{{ url('/riwayat-transaksi') }}">Riwayat Transaksi</a></li>
                    <li><a href="{{ url('/kelola-buku') }}">Kelola Buku</a></li>
                </ul>
            </div>

            <div class="footer-col">
                <h4 class="footer-col-title">Kebijakan</h4>
                <ul>
                    <li><a href="#">SOP Peminjaman</a></li>
                    <li><a href="#">Aturan Denda</a></li>
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

    {{-- Script lama dummy tidak dipakai dulu --}}
    {{-- <script src="{{ asset('js/script-input-peminjaman.js') }}"></script> --}}

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const anggotaData = @json($anggotaData);
            const bukuData = @json($bukuData);

            const oldAnggotaId = @json((string) old('anggota_id', ''));
            let selectedBookIds = (@json(old('buku_id', [])) || []).map(String);

            const form = document.getElementById('formPeminjaman');
            const anggotaIdInput = document.getElementById('anggotaId');
            const searchAnggota = document.getElementById('searchAnggota');
            const anggotaDropdown = document.getElementById('anggotaDropdown');
            const anggotaSelected = document.getElementById('anggotaSelected');
            const btnClearAnggota = document.getElementById('btnClearAnggota');

            const selAvatar = document.getElementById('selAvatar');
            const selNama = document.getElementById('selNama');
            const selMeta = document.getElementById('selMeta');
            const selEmail = document.getElementById('selEmail');

            const searchBuku = document.getElementById('searchBuku');
            const btnCariSaran = document.getElementById('btnCariSaran');
            const bukuSaran = document.getElementById('bukuSaran');
            const bukuList = document.getElementById('bukuList');
            const bukuHiddenInputs = document.getElementById('bukuHiddenInputs');
            const bukuTerpilihHead = document.getElementById('bukuTerpilihHead');
            const bukuTerpilihLabel = document.getElementById('bukuTerpilihLabel');

            const tglPinjam = document.getElementById('tglPinjam');
            const tglTempo = document.getElementById('tglTempo');

            const ringTotalBuku = document.getElementById('ringTotalBuku');
            const ringLamaPinjam = document.getElementById('ringLamaPinjam');
            const ringJatuhTempo = document.getElementById('ringJatuhTempo');
            const ringStatus = document.getElementById('ringStatus');

            const errAnggota = document.getElementById('err-anggota');
            const errBuku = document.getElementById('err-buku');
            const errTglPinjam = document.getElementById('err-tglPinjam');
            const errTglTempo = document.getElementById('err-tglTempo');

            const modalBatal = document.getElementById('ipModalBatal');
            const btnBatal = document.getElementById('btnBatal');
            const btnKonfirmBatal = document.getElementById('btnKonfirmBatal');
            const btnBatalTutup = document.getElementById('btnBatalTutup');

            const toast = document.getElementById('toast');

            function showToast(message) {
                if (!toast) return;

                toast.textContent = message;
                toast.classList.add('show');

                setTimeout(function () {
                    toast.classList.remove('show');
                }, 3000);
            }

            function getInitials(name) {
                if (!name) return 'A';

                const parts = name.trim().split(/\s+/);
                const first = parts[0]?.charAt(0) || 'A';
                const second = parts[1]?.charAt(0) || '';

                return (first + second).toUpperCase();
            }

            function normalize(value) {
                return String(value || '').toLowerCase();
            }

            function pilihAnggota(anggota) {
                anggotaIdInput.value = anggota.id;
                searchAnggota.value = '';

                selAvatar.textContent = getInitials(anggota.nama);
                selNama.textContent = anggota.nama || '-';
                selMeta.textContent = 'NIS: ' + (anggota.nis || '-') + ' · ' + (anggota.kelas || '-');
                selEmail.textContent = anggota.email || '-';

                anggotaSelected.style.display = 'block';
                anggotaSelected.classList.remove('hidden');

                anggotaDropdown.style.display = 'none';
                anggotaDropdown.innerHTML = '';

                if (errAnggota) errAnggota.textContent = '';

                updateRingkasan();
            }

            function clearAnggota() {
                anggotaIdInput.value = '';
                searchAnggota.value = '';
                anggotaSelected.style.display = 'none';
                anggotaSelected.classList.add('hidden');
                updateRingkasan();
            }

            function renderAnggotaDropdown(keyword) {
                const q = normalize(keyword);

                if (!q) {
                    anggotaDropdown.style.display = 'none';
                    anggotaDropdown.innerHTML = '';
                    return;
                }

                const results = anggotaData.filter(function (anggota) {
                    return normalize(anggota.nama).includes(q)
                        || normalize(anggota.nis).includes(q)
                        || normalize(anggota.no_anggota).includes(q)
                        || normalize(anggota.email).includes(q);
                }).slice(0, 8);

                if (results.length === 0) {
                    anggotaDropdown.innerHTML = '<div style="padding:12px;">Anggota tidak ditemukan.</div>';
                    anggotaDropdown.style.display = 'block';
                    return;
                }

                anggotaDropdown.innerHTML = results.map(function (anggota) {
                    return `
                        <button type="button" class="anggota-option" data-id="${anggota.id}" style="display:block; width:100%; text-align:left; padding:12px; border:none; background:white; cursor:pointer;">
                            <strong>${anggota.nama || '-'}</strong><br>
                            <small>NIS: ${anggota.nis || '-'} · ${anggota.kelas || '-'} · ${anggota.email || '-'}</small>
                        </button>
                    `;
                }).join('');

                anggotaDropdown.style.display = 'block';
            }

            searchAnggota?.addEventListener('input', function () {
                renderAnggotaDropdown(this.value);
            });

            anggotaDropdown?.addEventListener('click', function (event) {
                const option = event.target.closest('.anggota-option');
                if (!option) return;

                const anggota = anggotaData.find(function (item) {
                    return String(item.id) === String(option.dataset.id);
                });

                if (anggota) {
                    pilihAnggota(anggota);
                }
            });

            btnClearAnggota?.addEventListener('click', clearAnggota);

            function tambahBuku(bukuId) {
                const id = String(bukuId);

                if (selectedBookIds.includes(id)) {
                    showToast('Buku ini sudah dipilih.');
                    return;
                }

                selectedBookIds.push(id);
                searchBuku.value = '';
                bukuSaran.style.display = 'none';
                bukuSaran.innerHTML = '';

                if (errBuku) errBuku.textContent = '';

                renderBukuTerpilih();
                updateRingkasan();
            }

            function hapusBuku(bukuId) {
                selectedBookIds = selectedBookIds.filter(function (id) {
                    return String(id) !== String(bukuId);
                });

                renderBukuTerpilih();
                updateRingkasan();
            }

            function renderSaranBuku() {
                const q = normalize(searchBuku.value);

                const results = bukuData.filter(function (buku) {
                    if (selectedBookIds.includes(String(buku.id))) {
                        return false;
                    }

                    if (!q) {
                        return true;
                    }

                    return normalize(buku.judul).includes(q)
                        || normalize(buku.penulis).includes(q)
                        || normalize(buku.isbn).includes(q);
                }).slice(0, 8);

                if (results.length === 0) {
                    bukuSaran.innerHTML = '<div style="padding:12px;">Buku tidak ditemukan atau sudah dipilih.</div>';
                    bukuSaran.style.display = 'block';
                    bukuSaran.classList.remove('hidden');
                    return;
                }

                bukuSaran.innerHTML = results.map(function (buku) {
                    return `
                        <button type="button" class="buku-option" data-id="${buku.id}" style="display:block; width:100%; text-align:left; padding:12px; border:none; background:white; cursor:pointer;">
                            <strong>${buku.judul || '-'}</strong><br>
                            <small>${buku.penulis || '-'} · ISBN: ${buku.isbn || '-'} · Stok: ${buku.stok || 0}</small>
                        </button>
                    `;
                }).join('');

                bukuSaran.style.display = 'block';
                bukuSaran.classList.remove('hidden');
            }

            btnCariSaran?.addEventListener('click', renderSaranBuku);

            searchBuku?.addEventListener('keydown', function (event) {
                if (event.key === 'Enter') {
                    event.preventDefault();
                    renderSaranBuku();
                }
            });

            bukuSaran?.addEventListener('click', function (event) {
                const option = event.target.closest('.buku-option');
                if (!option) return;

                tambahBuku(option.dataset.id);
            });

            function renderBukuTerpilih() {
                const selectedBooks = bukuData.filter(function (buku) {
                    return selectedBookIds.includes(String(buku.id));
                });

                bukuHiddenInputs.innerHTML = selectedBooks.map(function (buku) {
                    return `<input type="hidden" name="buku_id[]" value="${buku.id}">`;
                }).join('');

                if (selectedBooks.length === 0) {
                    bukuTerpilihHead.style.display = 'none';
                    bukuTerpilihHead.classList.add('hidden');
                    bukuList.innerHTML = '';
                    return;
                }

                bukuTerpilihHead.style.display = 'block';
                bukuTerpilihHead.classList.remove('hidden');
                bukuTerpilihLabel.textContent = `Buku Terpilih (${selectedBooks.length})`;

                bukuList.innerHTML = selectedBooks.map(function (buku) {
                    return `
                        <li style="display:flex; justify-content:space-between; gap:12px; align-items:center; padding:12px; border:1px solid rgba(45,112,118,.15); border-radius:14px; margin-bottom:10px; background:#fff;">
                            <div>
                                <strong>${buku.judul || '-'}</strong><br>
                                <small>${buku.penulis || '-'} · ISBN: ${buku.isbn || '-'} · Stok: ${buku.stok || 0}</small>
                            </div>
                            <button type="button" class="btn-hapus-buku" data-id="${buku.id}" style="border:none; border-radius:10px; padding:8px 10px; cursor:pointer;">
                                Hapus
                            </button>
                        </li>
                    `;
                }).join('');
            }

            bukuList?.addEventListener('click', function (event) {
                const button = event.target.closest('.btn-hapus-buku');
                if (!button) return;

                hapusBuku(button.dataset.id);
            });

            function updateRingkasan() {
                const totalBuku = selectedBookIds.length;
                ringTotalBuku.textContent = totalBuku + ' Eksemplar';

                if (tglPinjam.value && tglTempo.value) {
                    const pinjam = new Date(tglPinjam.value);
                    const tempo = new Date(tglTempo.value);
                    const diffMs = tempo - pinjam;
                    const diffDays = Math.ceil(diffMs / (1000 * 60 * 60 * 24));

                    ringLamaPinjam.textContent = diffDays >= 0 ? diffDays + ' Hari' : 'Tanggal tidak valid';
                    ringJatuhTempo.textContent = tglTempo.value;
                } else {
                    ringLamaPinjam.textContent = '– Hari';
                    ringJatuhTempo.textContent = '–';
                }

                if (anggotaIdInput.value && totalBuku > 0 && tglPinjam.value && tglTempo.value) {
                    ringStatus.textContent = 'SIAP';
                } else {
                    ringStatus.textContent = 'DRAFT';
                }

                updateStepper();
            }

            function updateStepper() {
                const step1 = document.getElementById('step-ind-1');
                const step2 = document.getElementById('step-ind-2');
                const step3 = document.getElementById('step-ind-3');
                const line1 = document.getElementById('line-1');
                const line2 = document.getElementById('line-2');

                if (anggotaIdInput.value) {
                    step1?.classList.add('active');
                    step2?.classList.add('active');
                    line1?.classList.add('active');
                } else {
                    step2?.classList.remove('active');
                    line1?.classList.remove('active');
                }

                if (anggotaIdInput.value && selectedBookIds.length > 0) {
                    step3?.classList.add('active');
                    line2?.classList.add('active');
                } else {
                    step3?.classList.remove('active');
                    line2?.classList.remove('active');
                }
            }

            tglPinjam?.addEventListener('change', updateRingkasan);
            tglTempo?.addEventListener('change', updateRingkasan);

            form?.addEventListener('submit', function (event) {
                let valid = true;

                if (errAnggota) errAnggota.textContent = '';
                if (errBuku) errBuku.textContent = '';
                if (errTglPinjam) errTglPinjam.textContent = '';
                if (errTglTempo) errTglTempo.textContent = '';

                if (!anggotaIdInput.value) {
                    if (errAnggota) errAnggota.textContent = 'Pilih anggota terlebih dahulu.';
                    valid = false;
                }

                if (selectedBookIds.length === 0) {
                    if (errBuku) errBuku.textContent = 'Pilih minimal satu buku.';
                    valid = false;
                }

                if (!tglPinjam.value) {
                    if (errTglPinjam) errTglPinjam.textContent = 'Tanggal pinjam wajib diisi.';
                    valid = false;
                }

                if (!tglTempo.value) {
                    if (errTglTempo) errTglTempo.textContent = 'Tanggal jatuh tempo wajib diisi.';
                    valid = false;
                }

                if (tglPinjam.value && tglTempo.value && new Date(tglTempo.value) < new Date(tglPinjam.value)) {
                    if (errTglTempo) errTglTempo.textContent = 'Tanggal jatuh tempo tidak boleh sebelum tanggal pinjam.';
                    valid = false;
                }

                if (!valid) {
                    event.preventDefault();
                    showToast('Lengkapi data peminjaman terlebih dahulu.');
                }
            });

            btnBatal?.addEventListener('click', function () {
                if (modalBatal) {
                    modalBatal.classList.add('show');
                    modalBatal.style.display = 'flex';
                }
            });

            btnBatalTutup?.addEventListener('click', function () {
                if (modalBatal) {
                    modalBatal.classList.remove('show');
                    modalBatal.style.display = 'none';
                }
            });

            btnKonfirmBatal?.addEventListener('click', function () {
                clearAnggota();
                selectedBookIds = [];
                renderBukuTerpilih();

                if (searchBuku) searchBuku.value = '';
                if (document.getElementById('catatan')) document.getElementById('catatan').value = '';

                if (modalBatal) {
                    modalBatal.classList.remove('show');
                    modalBatal.style.display = 'none';
                }

                updateRingkasan();
                showToast('Form peminjaman berhasil dibersihkan.');
            });

            if (modalBatal) {
                modalBatal.style.display = 'none';

                modalBatal.addEventListener('click', function (event) {
                    if (event.target === modalBatal) {
                        modalBatal.classList.remove('show');
                        modalBatal.style.display = 'none';
                    }
                });
            }

            if (oldAnggotaId) {
                const oldAnggota = anggotaData.find(function (anggota) {
                    return String(anggota.id) === String(oldAnggotaId);
                });

                if (oldAnggota) {
                    pilihAnggota(oldAnggota);
                }
            }

            renderBukuTerpilih();
            updateRingkasan();

            const errorMessage = @json(session('error') ?? ($errors->any() ? 'Periksa kembali data peminjaman.' : null));

            if (errorMessage) {
                showToast(errorMessage);
            }
        });
    </script>

    <script>
        function bersihkanFormPeminjaman() {
            const yakin = confirm('Bersihkan semua data peminjaman yang sudah diisi?');

            if (yakin) {
                window.location.href = "{{ url('/input-peminjaman') }}";
            }
        }
    </script>

</body>
</html>