/**
 * script-detail-denda.js
 * Perpustakaan SMAIT Al-Uswah
 */

'use strict';

function showToast(msg, type) {
    const toast = document.getElementById('toast');
    if (!toast) return;
    toast.textContent = msg;
    toast.style.background = type === 'success' ? '#16a085' : 'var(--primary)';
    toast.classList.add('show');
    clearTimeout(toast._t);
    toast._t = setTimeout(() => toast.classList.remove('show'), 3000);
}

function showError(id, msg) {
    const el = document.getElementById(id);
    if (el) el.textContent = msg;
    const input = document.getElementById(id.replace('err-', '')) || document.getElementById(id.replace('err-', '') + '_bayar');
    if (input) input.style.borderColor = '#c0392b';
}

function clearError(id) {
    const el = document.getElementById(id);
    if (el) el.textContent = '';
}

document.addEventListener('DOMContentLoaded', function () {

    /* ── Active nav link ── */
    document.querySelectorAll('.nav-link').forEach(link => {
        if (link.getAttribute('href') === window.location.pathname) link.classList.add('active');
    });

    /* ── Cetak nota ── */
    document.getElementById('btnCetak')?.addEventListener('click', () => window.print());

    /* ── Expand detail (placeholder) ── */
    document.getElementById('btnExpand')?.addEventListener('click', () => {
        showToast('Fitur ini akan menampilkan riwayat lengkap anggota.');
    });

    /* ── Form validasi bayar ── */
    const form = document.getElementById('validasiForm');
    form?.addEventListener('submit', function (e) {
        e.preventDefault();
        let ok = true;

        clearError('err-tgl');
        clearError('err-nominal');

        const tgl     = document.getElementById('tgl_bayar').value;
        const nominal = parseInt(document.getElementById('nominal_bayar').value, 10);

        if (!tgl) {
            showError('err-tgl', 'Tanggal pembayaran wajib diisi.');
            ok = false;
        }

        if (!nominal || nominal <= 0) {
            showError('err-nominal', 'Nominal bayar wajib diisi dan harus lebih dari 0.');
            ok = false;
        }

        if (ok) {
            showToast('Denda berhasil ditandai lunas!', 'success');
            // form.submit(); // aktifkan saat tersambung backend
        }
    });

    /* ── Reset border on input ── */
    ['tgl_bayar', 'nominal_bayar'].forEach(id => {
        document.getElementById(id)?.addEventListener('input', function () {
            this.style.borderColor = '';
        });
    });
});