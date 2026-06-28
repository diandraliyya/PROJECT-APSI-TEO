/**
 * script-kelola-buku.js
 * Perpustakaan SMAIT Al-Uswah
 */

'use strict';

function showToast(msg, color) {
    const t = document.getElementById('toast');
    if (!t) return;
    t.textContent = msg;
    t.style.background = color || 'var(--primary)';
    t.classList.add('show');
    clearTimeout(t._x);
    t._x = setTimeout(() => t.classList.remove('show'), 2800);
}

document.addEventListener('DOMContentLoaded', function () {

    /* ── Active nav ── */
    document.querySelectorAll('.nav-link').forEach(l => {
        if (l.getAttribute('href') === window.location.pathname) l.classList.add('active');
    });

    const search = document.getElementById('searchInput');
    const katSel = document.getElementById('kategoriSelect');
    const stSel  = document.getElementById('statusSelect');
    const info   = document.getElementById('kbInfo');
    const empty  = document.getElementById('kbEmpty');

    /* ============================================================
       FILTER + SEARCH
       Setiap render: baca ulang DOM untuk baris yang masih ada
       Pakai style.display langsung agar tidak ada sisa dari class
       ============================================================ */
    function render() {
        // Baca ulang dari DOM setiap kali — baris yang sudah .remove() tidak akan muncul
        const currentRows = Array.from(document.querySelectorAll('#bukuTbody .kb-row'));

        const q   = (search?.value || '').trim().toLowerCase();
        const kat = katSel?.value || 'semua';
        const st  = stSel?.value  || 'semua';

        let visibleCount = 0;

        currentRows.forEach(row => {
            const judul   = (row.dataset.judul   || '').toLowerCase();
            const penulis = (row.dataset.penulis  || '').toLowerCase();
            const isbn    = (row.dataset.isbn     || '').toLowerCase();
            const rowKat  = row.dataset.kategori  || '';
            const rowSt   = row.dataset.status    || '';

            const matchQ   = !q || judul.includes(q) || penulis.includes(q) || isbn.includes(q);
            const matchKat = kat === 'semua' || rowKat === kat;
            const matchSt  = st  === 'semua' || rowSt  === st;
            const visible  = matchQ && matchKat && matchSt;

            // Pakai style.display langsung — tidak ada class hidden yang bisa overlap
            row.style.display = visible ? '' : 'none';
            if (visible) visibleCount++;
        });

        if (empty)  empty.style.display  = visibleCount === 0 ? '' : 'none';
        if (info)   info.textContent = `Menampilkan 1–${visibleCount} dari 450 buku`;
    }

    search?.addEventListener('input', render);
    katSel?.addEventListener('change', render);
    stSel?.addEventListener('change', render);
    render();

    /* ============================================================
       PAGINATION
       ============================================================ */
    let currentPage = 1;
    const pageBtns  = Array.from(document.querySelectorAll('.kb-page-btn[data-page]'));

    pageBtns.forEach(btn => btn.addEventListener('click', () => setPage(parseInt(btn.dataset.page))));
    document.getElementById('kbPrev')?.addEventListener('click', () => setPage(currentPage - 1));
    document.getElementById('kbNext')?.addEventListener('click', () => setPage(currentPage + 1));

    function setPage(p) {
        currentPage = Math.max(1, Math.min(45, p));
        pageBtns.forEach(b => b.classList.toggle('active', parseInt(b.dataset.page) === currentPage));
        if (info) info.textContent = `Menampilkan ${(currentPage - 1) * 10 + 1}–${Math.min(currentPage * 10, 450)} dari 450 buku`;
    }

    /* ============================================================
       MODAL HAPUS
       ============================================================ */
    const hapusModal = document.getElementById('hapusModal');
    const hapusJudul = document.getElementById('hapusJudul');
    const btnKonfirm = document.getElementById('btnHapusKonfirm');
    const btnBatal   = document.getElementById('btnHapusBatal');
    let pendingRow   = null;
    let pendingJudul = '';

    function openHapus(row, judul) {
        pendingRow   = row;
        pendingJudul = judul;
        if (hapusJudul) hapusJudul.textContent = '"' + judul + '"';
        hapusModal?.classList.add('active');
    }

    function closeHapus() {
        hapusModal?.classList.remove('active');
        pendingRow = null;
    }

    document.querySelectorAll('.btn-hapus').forEach(btn => {
        btn.addEventListener('click', function () {
            openHapus(this.closest('.kb-row'), this.dataset.judul || 'buku ini');
        });
    });

    btnKonfirm?.addEventListener('click', () => {
        if (pendingRow) {
            // Langsung remove dari DOM — tidak ada animasi yang bisa ninggalin ruang kosong
            pendingRow.remove();
            showToast('"' + pendingJudul + '" berhasil dihapus.', '#c0392b');
            render(); // render dari DOM yang sudah bersih
        }
        closeHapus();
    });

    btnBatal?.addEventListener('click', closeHapus);
    hapusModal?.addEventListener('click', e => { if (e.target === hapusModal) closeHapus(); });
    document.addEventListener('keydown', e => { if (e.key === 'Escape') closeHapus(); });
});