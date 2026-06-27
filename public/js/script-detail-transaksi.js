/**
 * script-detail-transaksi.js
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

document.addEventListener('DOMContentLoaded', function () {

    /* ── Active nav link ── */
    document.querySelectorAll('.nav-link').forEach(link => {
        if (link.getAttribute('href') === window.location.pathname) link.classList.add('active');
    });

    /* ── Tombol catat dikembalikan ── */
    const btnKembali = document.getElementById('btnCatatKembali');
    btnKembali?.addEventListener('click', function () {
        showToast('Buku berhasil dicatat sebagai dikembalikan.');
        // Submit ke backend di sini saat sudah terhubung.
    });
});