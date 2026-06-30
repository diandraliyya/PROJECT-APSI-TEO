/**
 * script-riwayat-peminjaman.js
 * Perpustakaan SMAIT Al-Uswah
 *
 * - Toggle kategori: Sedang Dipinjam / Sudah Dikembalikan (lihat semua per kategori)
 * - Dropdown Status menyesuaikan opsi sesuai kategori aktif
 * - Urutkan & Search aktif
 */

'use strict';

document.addEventListener('DOMContentLoaded', function () {

    const links = document.querySelectorAll('.nav-link');
    const current = window.location.pathname;
    links.forEach(link => {
        if (link.getAttribute('href') === current) link.classList.add('active');
    });

    const toggleBtns   = Array.from(document.querySelectorAll('.toggle-btn'));
    const sortSelect   = document.getElementById('sortSelect');
    const statusSelect = document.getElementById('statusSelect');
    const searchInput  = document.getElementById('searchInput');
    const emptyState   = document.getElementById('riwayatEmpty');
    const items        = Array.from(document.querySelectorAll('.riwayat-item'));

    const statusOptions = {
        dipinjam: [
            { value: 'semua',     label: 'Semua Status' },
            { value: 'aman',      label: 'Aman' },
            { value: 'hampir',    label: 'Hampir Jatuh Tempo' },
            { value: 'terlambat', label: 'Terlambat' },
        ],
        dikembalikan: [
            { value: 'semua',       label: 'Semua Status' },
            { value: 'tepat-waktu', label: 'Tepat Waktu' },
            { value: 'lunas',       label: 'Terlambat (Lunas)' },
        ],
    };

    let kondisiAktif = 'dipinjam';

    function refreshStatusOptions() {
        statusSelect.innerHTML = '';
        statusOptions[kondisiAktif].forEach(opt => {
            const o = document.createElement('option');
            o.value = opt.value;
            o.textContent = opt.label;
            statusSelect.appendChild(o);
        });
    }

    function render() {
        const q      = (searchInput.value || '').trim().toLowerCase();
        const status = statusSelect.value || 'semua';
        const sort   = sortSelect.value;

        let visible = items.filter(item => {
            const judul   = item.dataset.judul.toLowerCase();
            const penulis = item.dataset.penulis.toLowerCase();
            const st      = item.dataset.status;
            const kondisi = item.dataset.kondisi;

            const matchKondisi = kondisi === kondisiAktif;
            const matchSearch  = !q || judul.includes(q) || penulis.includes(q);
            const matchStatus  = status === 'semua' || st === status;
            return matchKondisi && matchSearch && matchStatus;
        });

        visible.sort((a, b) => {
            switch (sort) {
                case 'terbaru': return new Date(b.dataset.tanggal) - new Date(a.dataset.tanggal);
                case 'terlama': return new Date(a.dataset.tanggal) - new Date(b.dataset.tanggal);
                case 'tempo':   return new Date(a.dataset.tempo) - new Date(b.dataset.tempo);
                case 'az':      return a.dataset.judul.localeCompare(b.dataset.judul);
                default:        return 0;
            }
        });

        items.forEach(item => item.classList.add('hidden'));
        visible.forEach((item, i) => {
            item.classList.remove('hidden');
            item.style.order = i;
        });

        emptyState.classList.toggle('hidden', visible.length > 0);
    }

    toggleBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            toggleBtns.forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            kondisiAktif = btn.dataset.kondisi;
            refreshStatusOptions();
            render();
        });
    });

    sortSelect.addEventListener('change', render);
    statusSelect.addEventListener('change', render);
    searchInput.addEventListener('input', render);

    refreshStatusOptions();
    render();
});