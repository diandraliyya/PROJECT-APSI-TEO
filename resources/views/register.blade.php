<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Anggota – Perpustakaan SMAIT Al-Uswah</title>

    {{-- Google Fonts --}}
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">

    {{-- CSS --}}
    <link rel="stylesheet" href="{{ asset('css/style-register.css') }}">
</head>
<body>

    {{-- ===== MINIMAL HEADER (no nav) ===== --}}
    <header class="site-header">
        <div class="header-brand">
            <img src="{{ asset('assets/logo.png') }}" alt="Logo Perpustakaan SMAIT Al-Uswah" class="header-logo">
            <span class="header-name">Perpustakaan SMAIT Al-Uswah</span>
        </div>
    </header>

    {{-- ===== MAIN CONTENT ===== --}}
    <main class="register-main">

        {{-- Left Panel --}}
        <div class="left-panel">
            <div class="badge-open">
                <span class="badge-dot"></span>
                <span>PENDAFTARAN TERBUKA</span>
            </div>

            <h1 class="heading-hero">
                Gabung Menjadi<br>Anggota<br>Perpustakaan
            </h1>

            <p class="subtext">
                Buka pintu menuju ribuan jendela dunia.<br>
                Daftarkan diri Anda dan nikmati akses literasi<br>
                tanpa batas di SMAIT Al-Uswah.
            </p>

            <div class="illustration-wrap">
                {{-- Kotak besar: ilustrasi icon buku --}}
                <div class="book-stack">
                    <img src="{{ asset('assets/icon buku.png') }}" alt="Ilustrasi tumpukan buku" class="illustration-main">
                </div>

                {{-- Card digital dengan animasi floating --}}
                <div class="card-digital">
                    <div class="card-icon-wrap">
                        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 48 48" fill="none">
                            <rect x="4" y="10" width="40" height="28" rx="5" fill="#FFDDD2"/>
                            <rect x="4" y="10" width="40" height="28" rx="5" stroke="#2D7076" stroke-width="2"/>
                            <circle cx="16" cy="24" r="6" fill="#2D7076" opacity=".3"/>
                            <circle cx="16" cy="24" r="4" fill="#2D7076"/>
                            <rect x="26" y="20" width="12" height="2.5" rx="1.25" fill="#2D7076" opacity=".7"/>
                            <rect x="26" y="25" width="8" height="2.5" rx="1.25" fill="#2D7076" opacity=".4"/>
                            <rect x="4" y="15" width="40" height="4" fill="#2D7076" opacity=".08"/>
                        </svg>
                    </div>
                    <div class="card-text">
                        <strong>Kartu Digital</strong>
                        <p>Dapatkan kartu anggota digital langsung setelah akun disetujui admin.</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Right Panel – Registration Form --}}
        <div class="right-panel">
            <div class="form-card">
                <div class="form-header">
                    <h2 class="form-title">Pendaftaran Anggota</h2>
                    <svg class="form-icon" xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#2D7076" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                        <polyline points="14 2 14 8 20 8"/>
                        <line x1="16" y1="13" x2="8" y2="13"/>
                        <line x1="16" y1="17" x2="8" y2="17"/>
                        <polyline points="10 9 9 9 8 9"/>
                    </svg>
                </div>

                @if ($errors->any())
                    <div style="background:#fff3f3; border:1px solid #f3b5b5; color:#9f2f2f; padding:12px 14px; border-radius:12px; margin-bottom:16px; font-size:14px;">
                        <strong>Pendaftaran belum bisa diproses.</strong>
                        <ul style="margin:8px 0 0 18px;">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if (session('success'))
                    <div style="background:#f0fff4; border:1px solid #a7e3b5; color:#24733b; padding:12px 14px; border-radius:12px; margin-bottom:16px; font-size:14px;">
                        {{ session('success') }}
                    </div>
                @endif

                <form id="registerForm" action="{{ url('/register') }}" method="POST">
                    @csrf

                    <div class="form-row">
                        {{-- Nama Lengkap --}}
                        <div class="form-group">
                            <label for="nama_anggota">
                                <svg class="label-icon" xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                                Nama Anggota <span class="required">*</span>
                            </label>
                            <input type="text" id="nama_anggota" name="nama_anggota" value="{{ old('nama_anggota') }}" placeholder="Masukkan nama lengkap" autocomplete="name" required>
                            <span class="error-msg" id="err-nama"></span>
                        </div>

                        {{-- NIS --}}
                        <div class="form-group">
                            <label for="nis">
                                <svg class="label-icon" xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="5" width="20" height="14" rx="2"/><line x1="2" y1="10" x2="22" y2="10"/></svg>
                                NIS <span class="required">*</span>
                            </label>
                            <input type="text" id="nis" name="nis" value="{{ old('nis') }}" placeholder="Nomor Induk Siswa" inputmode="numeric" required>
                            <span class="error-msg" id="err-nis"></span>
                        </div>
                    </div>

                    <div class="form-row">
                        {{-- Kelas --}}
                        <div class="form-group">
                            <label for="kelas">
                                <svg class="label-icon" xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c3 3 9 3 12 0v-5"/></svg>
                                Kelas <span class="required">*</span>
                            </label>
                            <div class="select-wrap">
                                <select id="kelas" name="kelas">
                                    <option value="">Pilih Kelas</option>
                                    <option value="X MIPA 1">X MIPA 1</option>
                                    <option value="X MIPA 2">X MIPA 2</option>
                                    <option value="X IPS 1">X IPS 1</option>
                                    <option value="X IPS 2">X IPS 2</option>
                                    <option value="X IPS 3">X IPS 3</option>
                                    <option value="XI MIPA 1">XI MIPA 1</option>
                                    <option value="XI MIPA 2">XI MIPA 2</option>
                                    <option value="XI IPS 1">XI IPS 1</option>
                                    <option value="XI IPS 2">XI IPS 2</option>
                                    <option value="XII MIPA 1">XII MIPA 1</option>
                                    <option value="XII MIPA 2">XII MIPA 2</option>
                                    <option value="XII IPS 1">XII IPS 1</option>
                                    <option value="XII IPS 2">XII IPS 2</option>
                                    <option value="Guru">Guru</option>
                                    <option value="Staf">Staf</option>
                                </select>
                                <svg class="select-arrow" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#2D7076" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg>
                            </div>
                            <span class="error-msg" id="err-kelas"></span>
                        </div>

                        {{-- Email --}}
                        <div class="form-group">
                            <label for="email">
                                <svg class="label-icon" xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,12 2,6"/></svg>
                                Email <span class="required">*</span>
                            </label>
                            <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="example@gmail.com" autocomplete="email" required>
                            <span class="error-msg" id="err-email"></span>
                        </div>
                    </div>

                    {{-- Nomor HP --}}
                    <div class="form-group full-width">
                        <label for="no_hp">
                            <svg class="label-icon" xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 12 19.79 19.79 0 0 1 1.61 3.18 2 2 0 0 1 3.58 1h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L7.91 8.64a16 16 0 0 0 6.29 6.29l.98-.98a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                            Nomor HP <span class="required">*</span>
                        </label>
                        <input type="tel" id="no_hp" name="no_hp" value="{{ old('no_hp') }}" placeholder="08XXXXXXXXXX" inputmode="numeric" autocomplete="tel">
                        <span class="error-msg" id="err-hp"></span>
                    </div>

                    {{-- Alamat --}}
                    <div class="form-group full-width">
                        <label for="alamat">
                            <svg class="label-icon" xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                            Alamat <span class="required">*</span>
                        </label>
                        <textarea id="alamat" name="alamat" placeholder="Alamat lengkap sesuai KTP/KK" rows="3">{{ old('alamat') }}</textarea>
                        <span class="error-msg" id="err-alamat"></span>
                    </div>

                    <div class="form-group full-width">
                        <label for="username">
                            <svg class="label-icon" xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                            Username <span class="required">*</span>
                        </label>
                        <input type="text" id="username" name="username" value="{{ old('username') }}" placeholder="Masukkan username untuk login" autocomplete="username" required>
                        <span class="error-msg" id="err-username"></span>
                    </div>

                    <div class="form-row">
                        {{-- Password --}}
                        <div class="form-group">
                            <label for="password">
                                <svg class="label-icon" xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                                Password <span class="required">*</span>
                            </label>
                            <div class="input-eye-wrap">
                                <input type="password" id="password" name="password" placeholder="Min. 8 karakter" autocomplete="new-password">
                                <button type="button" class="eye-btn" data-target="password" aria-label="Tampilkan password">
                                    <svg class="eye-icon eye-off" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/></svg>
                                    <svg class="eye-icon eye-on hidden" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                </button>
                            </div>
                            <span class="error-msg" id="err-password"></span>
                        </div>

                        {{-- Konfirmasi Password --}}
                        <div class="form-group">
                            <label for="password_confirmation">
                                <svg class="label-icon" xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                                Konfirmasi Password <span class="required">*</span>
                            </label>
                            <div class="input-eye-wrap">
                                <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Ulangi password" autocomplete="new-password" required>
                                <button type="button" class="eye-btn" data-target="password_confirmation" aria-label="Tampilkan konfirmasi password">
                                    <svg class="eye-icon eye-off" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/></svg>
                                    <svg class="eye-icon eye-on hidden" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                </button>
                            </div>
                            <span class="error-msg" id="err-konfirmasi"></span>
                        </div>
                    </div>

                    {{-- Submit --}}
                    <button type="submit" class="btn-daftar" id="btnDaftar">Daftar Sekarang</button>

                    <p class="login-link">Sudah punya akun? <a href="{{ route('log-in') }}">Login</a></p>

                    <div class="info-notice">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#2D7076" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                        <p>Pendaftaran Anda akan ditinjau oleh admin perpustakaan. Notifikasi persetujuan akan dikirim melalui Email atau Nomor HP yang terdaftar.</p>
                    </div>
                </form>
            </div>
        </div>
    </main>

    {{-- ===== FOOTER ===== --}}
    <footer class="site-footer">
        <div class="footer-inner">
            <div class="footer-brand">
                <h3 class="footer-title">SMAIT Al-Uswah</h3>
                <p class="footer-tagline">© 2026 SMAIT Al-Uswah Library.<br>Menumbuhkan Literasi,<br>Mengukir Prestasi.</p>
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
                <div class="footer-socials">
                    <a href="#" class="social-btn" aria-label="Instagram">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"/><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/></svg>
                    </a>
                    <a href="#" class="social-btn" aria-label="Email">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,12 2,6"/></svg>
                    </a>
                </div>
            </div>
        </div>
    </footer>

    {{-- ===== SUCCESS MODAL ===== --}}
    <div class="modal-overlay" id="modalOverlay" role="dialog" aria-modal="true" aria-labelledby="modalTitle">
        <div class="modal-box">
            <div class="modal-icon-wrap">
                <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="#2D7076" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
            </div>
            <h3 class="modal-title" id="modalTitle">Pendaftaran Berhasil!</h3>
            <p class="modal-body">Terima kasih telah mendaftar. Akun Anda sedang dalam proses verifikasi oleh admin perpustakaan. Kami akan menghubungi Anda melalui email atau nomor HP yang terdaftar.</p>
            <a href="{{ route('log-in') }}" class="btn-modal">Mengerti, ke Halaman Login</a>
        </div>
    </div>

    {{-- JS --}}
    <!-- <script src="{{ asset('js/script-register.js') }}"></script> -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.eye-btn').forEach(function (button) {
                button.addEventListener('click', function () {
                    const targetId = button.dataset.target;
                    const input = document.getElementById(targetId);

                    if (!input) return;

                    input.type = input.type === 'password' ? 'text' : 'password';

                    const eyeOff = button.querySelector('.eye-off');
                    const eyeOn = button.querySelector('.eye-on');

                    eyeOff?.classList.toggle('hidden');
                    eyeOn?.classList.toggle('hidden');
                });
            });
        });
    </script>
</body>
</html>