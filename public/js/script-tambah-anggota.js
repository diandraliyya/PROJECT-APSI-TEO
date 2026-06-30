/**
 * script-tambah-anggota.js
 * Perpustakaan SMAIT Al-Uswah
 */

'use strict';

function showToast(msg) {
    const t = document.getElementById('toast');
    if (!t) return;
    t.textContent = msg; t.style.background = 'var(--primary)';
    t.classList.add('show'); clearTimeout(t._x);
    t._x = setTimeout(() => t.classList.remove('show'), 2800);
}

function setErr(id, msg) {
    document.getElementById(id)?.closest('.ta-form-group')?.classList.add('is-error');
    const e = document.getElementById('err-' + id);
    if (e) e.textContent = msg;
}

function clearErr(id) {
    document.getElementById(id)?.closest('.ta-form-group')?.classList.remove('is-error');
    const e = document.getElementById('err-' + id);
    if (e) e.textContent = '';
}

document.addEventListener('DOMContentLoaded', function () {

    /* ── Active nav ── */
    document.querySelectorAll('.nav-link').forEach(l => {
        if (l.getAttribute('href') === window.location.pathname) l.classList.add('active');
    });

    /* ============================================================
       FOTO PROFIL — upload, preview, hapus
       ============================================================ */
    const fotoInput      = document.getElementById('taFotoInput');
    const fotoImg        = document.getElementById('taFotoImg');
    const fotoPlaceholder= document.getElementById('taFotoPlaceholder');
    const fotoPreview    = document.getElementById('taFotoPreview');
    const btnGantiFoto   = document.getElementById('btnGantiFoto');
    const btnHapusFoto   = document.getElementById('btnHapusFoto');

    function triggerFoto() { fotoInput?.click(); }

    btnGantiFoto?.addEventListener('click', triggerFoto);
    fotoPreview?.addEventListener('click', triggerFoto);

    fotoInput?.addEventListener('change', function () {
        const file = this.files?.[0];
        if (!file) return;
        if (!file.type.startsWith('image/')) {
            showToast('File harus berupa gambar JPG atau PNG.');
            return;
        }
        if (file.size > 2 * 1024 * 1024) {
            showToast('Ukuran gambar maksimal 2 MB.');
            return;
        }
        const reader = new FileReader();
        reader.onload = e => {
            fotoImg.src = e.target.result;
            fotoImg.classList.remove('hidden');
            fotoPlaceholder.classList.add('hidden');
            btnHapusFoto?.classList.remove('hidden');
        };
        reader.readAsDataURL(file);
    });

    btnHapusFoto?.addEventListener('click', function (e) {
        e.stopPropagation();
        fotoImg.src = '';
        fotoImg.classList.add('hidden');
        fotoPlaceholder.classList.remove('hidden');
        btnHapusFoto.classList.add('hidden');
        if (fotoInput) fotoInput.value = '';
    });

    /* ============================================================
       SHOW/HIDE PASSWORD
       ============================================================ */
    document.querySelectorAll('.ta-pass-toggle').forEach(btn => {
        btn.addEventListener('click', function () {
            const input = document.getElementById(this.dataset.target);
            if (!input) return;
            input.type = input.type === 'password' ? 'text' : 'password';
        });
    });

    /* ============================================================
       CLEAR ERROR ON INPUT
       ============================================================ */
    const fields = ['nis','nama_lengkap','kelas','no_hp','email','username','password','konfirmasi_password'];
    fields.forEach(id => {
        document.getElementById(id)?.addEventListener('input',  () => clearErr(id));
        document.getElementById(id)?.addEventListener('change', () => clearErr(id));
    });

    /* ============================================================
       VALIDASI & SUBMIT
       ============================================================ */
    document.getElementById('tambahAnggotaForm')?.addEventListener('submit', function (e) {
        e.preventDefault();

        let ok = true;
        const v = id => (document.getElementById(id)?.value || '').trim();

        fields.forEach(id => clearErr(id));

        // NIS
        if (!v('nis')) {
            setErr('nis', 'NIS wajib diisi.'); ok = false;
        } else if (!/^\d{6,12}$/.test(v('nis'))) {
            setErr('nis', 'NIS harus berupa angka 6–12 digit.'); ok = false;
        }

        // Nama
        if (!v('nama_lengkap')) {
            setErr('nama_lengkap', 'Nama lengkap wajib diisi.'); ok = false;
        } else if (v('nama_lengkap').length < 3) {
            setErr('nama_lengkap', 'Nama minimal 3 karakter.'); ok = false;
        }

        // Kelas
        if (!v('kelas')) {
            setErr('kelas', 'Pilih kelas terlebih dahulu.'); ok = false;
        }

        // No HP
        if (!v('no_hp')) {
            setErr('no_hp', 'Nomor HP wajib diisi.'); ok = false;
        } else if (!/^(\+62|08)\d{8,13}$/.test(v('no_hp').replace(/\s/g, ''))) {
            setErr('no_hp', 'Format nomor HP tidak valid.'); ok = false;
        }

        // Email
        if (!v('email')) {
            setErr('email', 'Email wajib diisi.'); ok = false;
        } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(v('email'))) {
            setErr('email', 'Format email tidak valid.'); ok = false;
        }

        // Username
        if (!v('username')) {
            setErr('username', 'Username wajib diisi.'); ok = false;
        } else if (v('username').length < 4) {
            setErr('username', 'Username minimal 4 karakter.'); ok = false;
        } else if (/\s/.test(v('username'))) {
            setErr('username', 'Username tidak boleh mengandung spasi.'); ok = false;
        }

        // Password
        const pass = v('password');
        if (!pass) {
            setErr('password', 'Password wajib diisi.'); ok = false;
        } else if (pass.length < 8) {
            setErr('password', 'Password minimal 8 karakter.'); ok = false;
        }

        // Konfirmasi
        if (!v('konfirmasi_password')) {
            setErr('konfirmasi_password', 'Konfirmasi password wajib diisi.'); ok = false;
        } else if (pass && v('konfirmasi_password') !== pass) {
            setErr('konfirmasi_password', 'Password tidak cocok.'); ok = false;
        }

        if (!ok) {
            // Scroll ke error pertama
            document.querySelector('.ta-form-group.is-error')
                ?.scrollIntoView({ behavior: 'smooth', block: 'center' });
            return;
        }

        // Sukses → buka modal
        const modalNama = document.getElementById('taModalNama');
        if (modalNama) modalNama.textContent = v('nama_lengkap');
        document.getElementById('taModal')?.classList.add('active');
    });

    /* ── Modal OK → kelola-anggota ── */
    document.getElementById('btnTaModalOk')?.addEventListener('click', () => {
        const kelola = document.querySelector('a[href*="kelola-anggota"]')?.href || '/admin/kelola-anggota';
        window.location.href = kelola;
    });
});