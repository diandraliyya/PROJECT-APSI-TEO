/**
 * script-kelola-denda.js
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

    /* ── Animasi progress ── */
    document.querySelectorAll('.kd-card-progress-fill').forEach(fill => {
        const t = fill.style.width;
        fill.style.width = '0%';
        requestAnimationFrame(() => setTimeout(() => { fill.style.width = t; }, 200));
    });

    /* ============================================================
       PANEL TARIF DENDA
       ============================================================ */
    const tarifForm    = document.getElementById('tarifForm');
    const tarifInput   = document.getElementById('tarifInput');
    const tarifDisplay = document.getElementById('tarifDisplay');

    tarifForm?.addEventListener('submit', function (e) {
        e.preventDefault();
        const val = parseInt(tarifInput.value, 10);
        if (isNaN(val) || val < 0) {
            showToast('Masukkan tarif yang valid.');
            return;
        }
        const formatted = 'Rp ' + val.toLocaleString('id-ID');
        tarifDisplay.innerHTML = formatted + ' <small>/ hari keterlambatan</small>';
        showToast('Tarif denda diperbarui menjadi ' + formatted + ' / hari.');
        // Kirim ke backend di sini bila sudah terhubung.
    });

    /* ============================================================
       TAB AKTIF / LUNAS
       ============================================================ */
    const tabs   = document.querySelectorAll('.kd-tab');
    const rows   = Array.from(document.querySelectorAll('.kd-row'));
    const empty  = document.getElementById('kdEmpty');
    const info   = document.getElementById('kdInfo');
    const search = document.getElementById('searchInput');
    const kelasSelect = document.getElementById('kelasSelect');
    const waktuSelect = document.getElementById('waktuSelect');

    let kondisiAktif = 'aktif';

    function render() {
        const q     = (search.value || '').trim().toLowerCase();
        const kelas = kelasSelect.value;

        let visible = rows.filter(row => {
            const matchKondisi = row.dataset.kondisi === kondisiAktif;
            const nama  = (row.dataset.nama || '').toLowerCase();
            const judul = (row.dataset.judul || '').toLowerCase();
            const kls   = row.dataset.kelas || '';

            const matchSearch = !q || nama.includes(q) || judul.includes(q);
            const matchKelas  = kelas === 'semua' || kls === kelas;
            return matchKondisi && matchSearch && matchKelas;
        });

        rows.forEach(r => r.classList.add('hidden'));
        visible.forEach(r => r.classList.remove('hidden'));

        empty.classList.toggle('hidden', visible.length > 0);

        const total = kondisiAktif === 'aktif' ? 42 : 158;
        const label = kondisiAktif === 'aktif' ? 'denda aktif' : 'denda lunas';
        info.textContent = visible.length
            ? `Menampilkan 1–${visible.length} dari ${total} ${label}`
            : `Tidak ada ${label} yang cocok`;
    }

    tabs.forEach(tab => {
        tab.addEventListener('click', () => {
            tabs.forEach(t => t.classList.remove('active'));
            tab.classList.add('active');
            kondisiAktif = tab.dataset.tab;
            render();
        });
    });

    /* ── Filter listeners ── */
    search?.addEventListener('input', render);
    kelasSelect?.addEventListener('change', render);
    waktuSelect?.addEventListener('change', render);

    /* ── Init ── */
    render();
});