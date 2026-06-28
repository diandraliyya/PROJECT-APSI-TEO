/**
 * script-setting.js
 * Perpustakaan SMAIT Al-Uswah
 */

'use strict';

function showToast(msg) {
    const toast = document.getElementById('toast');
    if (!toast) return;
    toast.textContent = msg;
    toast.classList.add('show');
    clearTimeout(toast._t);
    toast._t = setTimeout(() => toast.classList.remove('show'), 2600);
}

function showErr(fieldId, errId, msg) {
    document.getElementById(fieldId)?.closest('.st-form-group')?.classList.add('is-error');
    const el = document.getElementById(errId);
    if (el) el.textContent = msg;
}

function clearErr(fieldId, errId) {
    document.getElementById(fieldId)?.closest('.st-form-group')?.classList.remove('is-error');
    const el = document.getElementById(errId);
    if (el) el.textContent = '';
}

document.addEventListener('DOMContentLoaded', function () {

    /* ============================================================
       FOTO PROFIL — ganti / hapus (sama persis kayak profil-anggota)
       ============================================================ */
    const photoInput   = document.getElementById('stPhotoInput');
    const photoPreview = document.getElementById('stPhotoPreview');
    const photoEditBtn = document.getElementById('stPhotoEditBtn');
    const btnChange    = document.getElementById('stBtnChange');
    const btnDelete    = document.getElementById('stBtnDelete');
    const initEl       = document.getElementById('stPhotoInitial');
    const initialChar  = (initEl?.textContent || 'A').trim();

    function triggerPick() { photoInput?.click(); }
    photoEditBtn?.addEventListener('click', triggerPick);
    btnChange?.addEventListener('click', triggerPick);

    photoInput?.addEventListener('change', function () {
        const file = this.files?.[0];
        if (!file) return;
        if (!file.type.startsWith('image/')) { showToast('File harus berupa gambar.'); return; }
        if (file.size > 2 * 1024 * 1024) { showToast('Ukuran gambar maksimal 2 MB.'); return; }
        const reader = new FileReader();
        reader.onload = e => {
            photoPreview.innerHTML = '<img src="' + e.target.result + '" alt="Foto Profil">';
            btnDelete?.classList.remove('hidden');
            showToast('Foto dipilih. Klik Simpan Setting untuk menyimpan.');
        };
        reader.readAsDataURL(file);
    });

    btnDelete?.addEventListener('click', () => {
        photoPreview.innerHTML = '<div class="st-foto-placeholder" id="stPhotoInitial">' + initialChar + '</div>';
        if (photoInput) photoInput.value = '';
        btnDelete.classList.add('hidden');
        showToast('Foto dihapus.');
    });

    /* ── Toggle password section ── */
    const btnToggle  = document.getElementById('btnTogglePass');
    const passBody   = document.getElementById('passBody');
    const toggleText = document.getElementById('passToggleText');
    const chevron    = document.querySelector('.pass-chevron');
    let passOpen = false;

    btnToggle?.addEventListener('click', () => {
        passOpen = !passOpen;
        passBody?.classList.toggle('hidden', !passOpen);
        if (toggleText) toggleText.textContent = passOpen ? 'Tutup' : 'Ubah Password';
        if (chevron) chevron.style.transform = passOpen ? 'rotate(180deg)' : 'rotate(0deg)';
    });

    /* ── Show/hide password ── */
    document.querySelectorAll('.st-pass-toggle').forEach(btn => {
        btn.addEventListener('click', function () {
            const input = document.getElementById(this.dataset.target);
            if (input) input.type = input.type === 'password' ? 'text' : 'password';
        });
    });

    /* ── Simpan setting (validasi gabungan) ── */
    document.getElementById('btnSimpan')?.addEventListener('click', function () {
        let ok = true;

        // --- Validasi akun ---
        const nama  = document.getElementById('nama_admin')?.value.trim();
        const uname = document.getElementById('username')?.value.trim();
        const email = document.getElementById('email')?.value.trim();

        clearErr('nama_admin', 'err-nama');
        clearErr('username', 'err-username');
        clearErr('email', 'err-email');

        if (!nama || nama.length < 3) {
            showErr('nama_admin', 'err-nama', 'Nama minimal 3 karakter.'); ok = false;
        }
        if (!uname) {
            showErr('username', 'err-username', 'Username wajib diisi.'); ok = false;
        }
        if (!email) {
            showErr('email', 'err-email', 'Email wajib diisi.'); ok = false;
        }

        // --- Validasi password (hanya jika section terbuka & ada input) ---
        if (passOpen) {
            const lama  = document.getElementById('pass_lama')?.value;
            const baru  = document.getElementById('pass_baru')?.value;
            const konfirmasi = document.getElementById('pass_konfirmasi')?.value;

            clearErr('pass_lama', 'err-pass-lama');
            clearErr('pass_baru', 'err-pass-baru');
            clearErr('pass_konfirmasi', 'err-pass-konfirmasi');

            if (!lama) { showErr('pass_lama', 'err-pass-lama', 'Password lama wajib diisi.'); ok = false; }
            if (!baru) { showErr('pass_baru', 'err-pass-baru', 'Password baru wajib diisi.'); ok = false; }
            else if (baru.length < 8) { showErr('pass_baru', 'err-pass-baru', 'Password minimal 8 karakter.'); ok = false; }
            if (!konfirmasi) { showErr('pass_konfirmasi', 'err-pass-konfirmasi', 'Konfirmasi password wajib diisi.'); ok = false; }
            else if (baru !== konfirmasi) { showErr('pass_konfirmasi', 'err-pass-konfirmasi', 'Password tidak cocok.'); ok = false; }
        }

        if (ok) {
            showToast('Setting berhasil disimpan!');
            // Submit ke backend di sini saat terhubung.
        }
    });

    /* ── Batal ── */
    document.getElementById('btnBatal')?.addEventListener('click', () => {
        document.getElementById('akunForm')?.reset();
        document.getElementById('passForm')?.reset();
        ['nama_admin','username','email','pass_lama','pass_baru','pass_konfirmasi'].forEach(id => {
            document.getElementById(id)?.closest('.st-form-group')?.classList.remove('is-error');
        });
        ['err-nama','err-username','err-email','err-pass-lama','err-pass-baru','err-pass-konfirmasi'].forEach(id => {
            const el = document.getElementById(id);
            if (el) el.textContent = '';
        });
    });

    /* ── Clear error on input ── */
    const fieldErrMap = {
        'nama_admin': 'err-nama', 'username': 'err-username', 'email': 'err-email',
        'pass_lama': 'err-pass-lama', 'pass_baru': 'err-pass-baru', 'pass_konfirmasi': 'err-pass-konfirmasi',
    };
    Object.entries(fieldErrMap).forEach(([fieldId, errId]) => {
        document.getElementById(fieldId)?.addEventListener('input', () => clearErr(fieldId, errId));
    });
});