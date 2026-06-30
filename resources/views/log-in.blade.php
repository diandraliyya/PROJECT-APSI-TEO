<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login – Perpustakaan SMAIT Al-Uswah</title>

    {{-- Google Fonts --}}
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">

    {{-- CSS --}}
    <link rel="stylesheet" href="{{ asset('css/style-register.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style-log-in.css') }}">
</head>
<body class="login-page">

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
                <span>SELAMAT DATANG KEMBALI</span>
            </div>

            <h1 class="heading-hero">
                Masuk ke<br>Akun<br>Perpustakaan
            </h1>

            <p class="subtext">
                Lanjutkan perjalanan literasimu.<br>
                Akses koleksi buku dan riwayat peminjaman<br>
                di SMAIT Al-Uswah.
            </p>

            <div class="illustration-wrap">
                <div class="book-stack">
                    <img src="{{ asset('assets/icon buku.png') }}" alt="Ilustrasi tumpukan buku" class="illustration-main">
                </div>

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
                        <p>Tunjukkan kartu digital saat meminjam buku di perpustakaan.</p>
                    </div>
                </div>
            </div>
        </div>

        @if (session('success'))
            <div style="background:#f0fff4; border:1px solid #a7e3b5; color:#24733b; padding:12px 14px; border-radius:12px; margin-bottom:16px; font-size:14px;">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div style="background:#fff3f3; border:1px solid #f3b5b5; color:#9f2f2f; padding:12px 14px; border-radius:12px; margin-bottom:16px; font-size:14px;">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        {{-- Right Panel – Login Form --}}
        <div class="right-panel login-right">
            <div class="form-card">
                <div class="form-header">
                    <h2 class="form-title">Login</h2>
                    <svg class="form-icon" xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#2D7076" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/>
                        <polyline points="10 17 15 12 10 7"/>
                        <line x1="15" y1="12" x2="3" y2="12"/>
                    </svg>
                </div>

                <form id="loginForm" action="{{ url('/log-in') }}" method="POST">
                    @csrf

                    {{-- Username / Email --}}
                    <div class="form-group full-width">
                        <label for="login">
                            <svg class="label-icon" xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                                <circle cx="12" cy="7" r="4"/>
                            </svg>
                            Username / Email / NIS <span class="required">*</span>
                        </label>
                        <input type="text" id="login" name="login" value="{{ old('login') }}" placeholder="Username, email, atau NIS" autocomplete="username" required>
                        <span class="error-msg" id="err-identifier"></span>
                    </div>

                    {{-- Password --}}
                    <div class="form-group full-width">
                        <label for="password">
                            <svg class="label-icon" xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                                <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                            </svg>
                            Password <span class="required">*</span>
                        </label>

                        <div class="input-eye-wrap">
                            <input type="password" id="password" name="password" placeholder="Masukkan password" autocomplete="current-password" required>

                            <button type="button" class="eye-btn" data-target="password" aria-label="Tampilkan password">
                                <svg class="eye-icon eye-off" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/>
                                    <line x1="1" y1="1" x2="23" y2="23"/>
                                </svg>

                                <svg class="eye-icon eye-on hidden" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                    <circle cx="12" cy="12" r="3"/>
                                </svg>
                            </button>
                        </div>

                        <span class="error-msg" id="err-password"></span>
                    </div>

                    {{-- Submit --}}
                    <button type="submit" class="btn-daftar" id="btnLogin">Masuk</button>

                    <p class="login-link">
                        Belum punya akun?
                        <a href="{{ route('register') }}">Daftar di sini</a>
                    </p>

                    <div class="info-notice">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#2D7076" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10"/>
                            <line x1="12" y1="8" x2="12" y2="12"/>
                            <line x1="12" y1="16" x2="12.01" y2="16"/>
                        </svg>
                        <p>Akun Anda harus sudah diverifikasi oleh admin sebelum bisa login. Hubungi admin jika mengalami kendala.</p>
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
                <p class="footer-tagline">
                    © 2026 SMAIT Al-Uswah Library.<br>
                    Menumbuhkan Literasi,<br>
                    Mengukir Prestasi.
                </p>
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
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="2" y="2" width="20" height="20" rx="5" ry="5"/>
                            <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/>
                            <line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/>
                        </svg>
                    </a>

                    <a href="#" class="social-btn" aria-label="Email">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                            <polyline points="22,6 12,12 2,6"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </footer>

    {{-- JS --}}
    <!-- <script>
        window.LOGIN_ROUTES = {
            anggota: "{{ url('/home-anggota') }}",
            admin: "{{ url('/home-admin') }}"
        };
    </script>

    <script src="{{ asset('js/script-log-in.js') }}"></script> -->

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