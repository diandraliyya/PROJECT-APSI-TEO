/**
 * script-profil-anggota.js
 * Perpustakaan SMAIT Al-Uswah
 *
 * - Ganti / hapus foto profil (pilih file beneran)
 * - Modal kartu anggota (klik kartu → pop-up di tengah)
 * - Section password collapse/expand
 * - Validasi form selaras dgn register & login
 */

'use strict';

/* ── helper error ── */
function showError(fieldId, errId, msg) {
    const field = document.getElementById(fieldId);
    const err = document.getElementById(errId);
    if (field) field.closest('.form-group')?.classList.add('is-error');
    if (err) err.textContent = msg;
}
function clearError(fieldId, errId) {
    const field = document.getElementById(fieldId);
    const err = document.getElementById(errId);
    if (field) field.closest('.form-group')?.classList.remove('is-error');
    if (err) err.textContent = '';
}

function showToast(msg) {
    const toast = document.getElementById('toast');
    if (!toast) return;
    toast.textContent = msg;
    toast.classList.add('show');
    clearTimeout(toast._t);
    toast._t = setTimeout(() => toast.classList.remove('show'), 2600);
}

document.addEventListener('DOMContentLoaded', function () {

    /* ── Active nav link ── */
    document.querySelectorAll('.nav-link').forEach(link => {
        if (link.getAttribute('href') === window.location.pathname) link.classList.add('active');
    });

    /* ============================================================
       FOTO PROFIL — ganti / hapus
       ============================================================ */
    const photoInput   = document.getElementById('photoInput');
    const photoPreview = document.getElementById('photoPreview');
    const photoEditBtn = document.getElementById('photoEditBtn');
    const btnChange    = document.getElementById('btnChangePhoto');
    const btnDelete    = document.getElementById('btnDeletePhoto');
    const initialChar  = (document.getElementById('photoInitial')?.textContent || 'A').trim();

    function triggerPick() { photoInput?.click(); }

    photoEditBtn?.addEventListener('click', triggerPick);
    btnChange?.addEventListener('click', triggerPick);

    photoInput?.addEventListener('change', function () {
        const file = this.files && this.files[0];
        if (!file) return;

        if (!file.type.startsWith('image/')) {
            showToast('File harus berupa gambar.');
            return;
        }
        if (file.size > 2 * 1024 * 1024) {
            showToast('Ukuran gambar maksimal 2 MB.');
            return;
        }

        const reader = new FileReader();
        reader.onload = e => {
            photoPreview.innerHTML = '<img src="' + e.target.result + '" alt="Foto Profil" id="photoImg">';
            btnDelete?.classList.remove('hidden');
            showToast('Foto dipilih. Jangan lupa Simpan Perubahan.');
        };
        reader.readAsDataURL(file);
    });

    btnDelete?.addEventListener('click', function () {
        photoPreview.innerHTML = '<div class="photo-placeholder" id="photoInitial">' + initialChar + '</div>';
        if (photoInput) photoInput.value = '';
        btnDelete.classList.add('hidden');
        showToast('Foto dihapus.');
    });

    /* ============================================================
       MODAL KARTU ANGGOTA
       ============================================================ */
    const ecardTrigger = document.getElementById('ecardTrigger');
    const ecardModal   = document.getElementById('ecardModal');
    const ecardClose   = document.getElementById('ecardModalClose');
    const btnDownload  = document.getElementById('btnDownloadCard');

    function openCard() { ecardModal?.classList.add('active'); }
    function closeCard() { ecardModal?.classList.remove('active'); }

    ecardTrigger?.addEventListener('click', openCard);
    ecardClose?.addEventListener('click', closeCard);
    ecardModal?.addEventListener('click', e => { if (e.target === ecardModal) closeCard(); });
    document.addEventListener('keydown', e => { if (e.key === 'Escape') closeCard(); });

    btnDownload?.addEventListener('click', function () {
        // Placeholder unduh — implementasi nyata bisa pakai html2canvas / endpoint server.
        showToast('Menyiapkan unduhan kartu...');
    });

    /* ============================================================
       PASSWORD — collapse/expand
       ============================================================ */
    const btnToggleSec = document.getElementById('btnToggleSecurity');
    const securityBody = document.getElementById('securityBody');
    const secToggleTxt = document.getElementById('securityToggleText');
    const secChevron   = document.querySelector('.security-chevron');
    let secOpen = false;

    btnToggleSec?.addEventListener('click', function () {
        secOpen = !secOpen;
        securityBody?.classList.toggle('hidden', !secOpen);
        if (secToggleTxt) secToggleTxt.textContent = secOpen ? 'Tutup' : 'Ubah Password';
        if (secChevron) secChevron.style.transform = secOpen ? 'rotate(180deg)' : 'rotate(0deg)';
    });

    /* ── Toggle lihat/sembunyi password ── */
    document.querySelectorAll('.pass-toggle').forEach(btn => {
        btn.addEventListener('click', function () {
            const target = document.getElementById(this.dataset.target);
            if (!target) return;
            target.type = target.type === 'password' ? 'text' : 'password';
        });
    });

    /* ============================================================
       VALIDASI — Informasi Personal
       ============================================================ */
    const profilForm = document.getElementById('profilForm');
    profilForm?.addEventListener('submit', function (e) {
        e.preventDefault();
        let ok = true;

        const nama   = document.getElementById('nama_lengkap').value.trim();
        const email  = document.getElementById('email').value.trim();
        const hp     = document.getElementById('nomor_hp').value.trim();
        const alamat = document.getElementById('alamat').value.trim();

        clearError('nama_lengkap', 'err-nama');
        clearError('email', 'err-email');
        clearError('nomor_hp', 'err-hp');
        clearError('alamat', 'err-alamat');

        if (!nama) { showError('nama_lengkap', 'err-nama', 'Nama lengkap wajib diisi.'); ok = false; }
        else if (nama.length < 3) { showError('nama_lengkap', 'err-nama', 'Nama minimal 3 karakter.'); ok = false; }

        if (!email) { showError('email', 'err-email', 'Email wajib diisi.'); ok = false; }
        else if (!email.toLowerCase().endsWith('@gmail.com')) { showError('email', 'err-email', 'Email harus menggunakan @gmail.com.'); ok = false; }
        else if (!/^[^\s@]+@gmail\.com$/.test(email.toLowerCase())) { showError('email', 'err-email', 'Format email tidak valid.'); ok = false; }

        if (!hp) { showError('nomor_hp', 'err-hp', 'Nomor telepon wajib diisi.'); ok = false; }
        else if (!/^[0-9]{9,15}$/.test(hp.replace(/[-\s]/g, ''))) { showError('nomor_hp', 'err-hp', 'Nomor telepon harus 9–15 digit angka.'); ok = false; }

        if (!alamat) { showError('alamat', 'err-alamat', 'Alamat wajib diisi.'); ok = false; }
        else if (alamat.length < 10) { showError('alamat', 'err-alamat', 'Alamat terlalu pendek (min 10 karakter).'); ok = false; }

        if (ok) {
            showToast('Perubahan profil berhasil disimpan!');
            // profilForm.submit(); // aktifkan saat terhubung backend
        }
    });

    /* Reset/batal */
    document.getElementById('btnBatal')?.addEventListener('click', function () {
        profilForm?.reset();
        ['nama_lengkap','email','nomor_hp','alamat'].forEach(f => clearError(f, 'err-' + (f === 'nama_lengkap' ? 'nama' : f === 'nomor_hp' ? 'hp' : f)));
    });

    /* ============================================================
       VALIDASI — Password (opsional, hanya kalau diisi)
       ============================================================ */
    const passwordForm = document.getElementById('passwordForm');
    passwordForm?.addEventListener('submit', function (e) {
        e.preventDefault();
        let ok = true;

        const lama  = document.getElementById('pass_lama').value;
        const baru  = document.getElementById('pass_baru').value;
        const konf  = document.getElementById('pass_konfirmasi').value;

        clearError('pass_lama', 'err-pass-lama');
        clearError('pass_baru', 'err-pass-baru');
        clearError('pass_konfirmasi', 'err-pass-konfirmasi');

        if (!lama) { showError('pass_lama', 'err-pass-lama', 'Masukkan kata sandi lama.'); ok = false; }

        if (!baru) { showError('pass_baru', 'err-pass-baru', 'Masukkan kata sandi baru.'); ok = false; }
        else if (baru.length < 8) { showError('pass_baru', 'err-pass-baru', 'Sandi baru minimal 8 karakter.'); ok = false; }

        if (!konf) { showError('pass_konfirmasi', 'err-pass-konfirmasi', 'Konfirmasi sandi baru.'); ok = false; }
        else if (baru !== konf) { showError('pass_konfirmasi', 'err-pass-konfirmasi', 'Konfirmasi tidak cocok.'); ok = false; }

        if (ok) {
            showToast('Password berhasil diperbarui!');
            passwordForm.reset();
            // passwordForm.submit(); // aktifkan saat terhubung backend
        }
    });
});