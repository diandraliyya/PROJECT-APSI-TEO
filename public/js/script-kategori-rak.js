/**
 * script-kategori-rak.js
 * Perpustakaan SMAIT Al-Uswah
 */

'use strict';

function showToast(msg, color) {
    const t = document.getElementById('toast');
    if (!t) return;
    t.textContent = msg; t.style.background = color || 'var(--primary)';
    t.classList.add('show'); clearTimeout(t._x);
    t._x = setTimeout(() => t.classList.remove('show'), 2800);
}

function showErr(id, msg) {
    document.getElementById(id)?.closest('.kr-form-group')?.classList.add('is-error');
    const e = document.getElementById('err-' + id);
    if (e) e.textContent = msg;
}
function clearErr(id) {
    document.getElementById(id)?.closest('.kr-form-group')?.classList.remove('is-error');
    const e = document.getElementById('err-' + id);
    if (e) e.textContent = '';
}

document.addEventListener('DOMContentLoaded', function () {

    /* ── Active nav ── */
    document.querySelectorAll('.nav-link').forEach(l => {
        if (l.getAttribute('href') === window.location.pathname) l.classList.add('active');
    });

    /* ============================================================
       MODE TOGGLE — Kategori vs Rak
       ============================================================ */
    const btnKat = document.getElementById('btnModeKategori');
    const btnRak = document.getElementById('btnModeRak');
    const modeKat = document.getElementById('modeKategori');
    const modeRak = document.getElementById('modeRak');

    btnKat?.addEventListener('click', () => {
        btnKat.classList.add('active'); btnRak.classList.remove('active');
        modeKat.style.display = ''; modeRak.style.display = 'none';
    });

    btnRak?.addEventListener('click', () => {
        btnRak.classList.add('active'); btnKat.classList.remove('active');
        modeRak.style.display = ''; modeKat.style.display = 'none';
    });

    /* ============================================================
       EXPAND / COLLAPSE buku per kategori atau rak
       ============================================================ */
    document.querySelectorAll('.kr-btn-expand').forEach(btn => {
        btn.addEventListener('click', function () {
            const target = this.dataset.target;
            const panel  = document.getElementById('books-' + target);
            if (!panel) return;
            const isOpen = panel.classList.contains('open');
            // Tutup semua dulu dalam mode yang sama
            const container = this.closest('#listKategori, #listRak');
            container?.querySelectorAll('.kr-item-books.open').forEach(p => p.classList.remove('open'));
            container?.querySelectorAll('.kr-btn-expand.open').forEach(b => b.classList.remove('open'));

            if (!isOpen) { panel.classList.add('open'); this.classList.add('open'); }
        });
    });

    /* ============================================================
       SEARCH BUKU DALAM PANEL (per kategori/rak)
       ============================================================ */
    document.querySelectorAll('.kr-books-search').forEach(input => {
        input.addEventListener('input', function () {
            const panel = document.getElementById('books-' + this.dataset.target);
            if (!panel) return;
            const q = this.value.trim().toLowerCase();
            panel.querySelectorAll('.kr-book-item').forEach(item => {
                const judul   = (item.dataset.judul   || '').toLowerCase();
                const penulis = (item.dataset.penulis || '').toLowerCase();
                item.classList.toggle('hidden', q !== '' && !judul.includes(q) && !penulis.includes(q));
            });
        });
    });

    /* ============================================================
       SEARCH GLOBAL — highlight buku di semua kategori/rak aktif
       ============================================================ */
    function setupGlobalSearch(inputId, listId) {
        const input = document.getElementById(inputId);
        if (!input) return;
        input.addEventListener('input', function () {
            const q = this.value.trim().toLowerCase();
            const list = document.getElementById(listId);
            list?.querySelectorAll('.kr-item').forEach(item => {
                if (!q) {
                    item.style.display = '';
                    item.querySelector('.kr-item-books')?.classList.remove('open');
                    item.querySelector('.kr-btn-expand')?.classList.remove('open');
                    item.querySelectorAll('.kr-book-item').forEach(b => b.classList.remove('hidden'));
                    return;
                }
                let anyMatch = false;
                item.querySelectorAll('.kr-book-item').forEach(b => {
                    const j = (b.dataset.judul   || '').toLowerCase();
                    const p = (b.dataset.penulis || '').toLowerCase();
                    const match = j.includes(q) || p.includes(q);
                    b.classList.toggle('hidden', !match);
                    if (match) anyMatch = true;
                });
                item.style.display = anyMatch ? '' : 'none';
                if (anyMatch) {
                    item.querySelector('.kr-item-books')?.classList.add('open');
                    item.querySelector('.kr-btn-expand')?.classList.add('open');
                }
            });
        });
    }

    setupGlobalSearch('searchBukuKategori', 'listKategori');
    setupGlobalSearch('searchBukuRak',      'listRak');

    /* ============================================================
       FORM TAMBAH KATEGORI
       ============================================================ */
    const formKat = document.getElementById('formTambahKategori');
    const namaKatInput = document.getElementById('namaKategori');
    const listKat = document.getElementById('listKategori');
    const katCount = document.getElementById('kategoriCount');

    namaKatInput?.addEventListener('input', () => clearErr('namaKategori'));

    formKat?.addEventListener('submit', function (e) {
        e.preventDefault();
        clearErr('namaKategori');
        const nama = namaKatInput?.value.trim();
        const desk = document.getElementById('deskripsiKategori')?.value.trim();

        if (!nama) { showErr('namaKategori', 'Nama kategori wajib diisi.'); return; }

        // Tambah item baru ke daftar
        const id = 'kat-' + Date.now();
        const li = document.createElement('li');
        li.className = 'kr-item'; li.dataset.id = id;
        li.innerHTML = `
            <div class="kr-item-main">
                <div class="kr-item-ic ic-sejarah">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/></svg>
                </div>
                <div class="kr-item-info">
                    <span class="kr-item-nama">${nama}</span>
                    <span class="kr-item-sub">${desk || 'Tanpa deskripsi'}</span>
                </div>
                <div class="kr-item-actions">
                    <button type="button" class="kr-btn-expand" data-target="${id}" title="Lihat buku">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg>
                    </button>
                    <button type="button" class="kr-btn-hapus" data-id="${id}" data-nama="${nama}" title="Hapus">
                        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                    </button>
                </div>
            </div>
            <div class="kr-item-books" id="books-${id}">
                <div class="kr-books-search-wrap">
                    <input type="text" class="kr-books-search" placeholder="Cari di ${nama}..." data-target="${id}">
                </div>
                <ul class="kr-book-list"><li class="kr-no-book">Belum ada buku di kategori ini.</li></ul>
            </div>`;

        listKat?.appendChild(li);
        bindNewItem(li);
        updateCount(listKat, katCount, 'Kategori');
        formKat.reset();
        showToast('Kategori "' + nama + '" berhasil ditambahkan!');
    });

    /* ============================================================
       FORM TAMBAH RAK
       ============================================================ */
    const formRak = document.getElementById('formTambahRak');
    const listRak = document.getElementById('listRak');
    const rakCount = document.getElementById('rakCount');

    ['kodeRak','lokasiRak'].forEach(id => {
        document.getElementById(id)?.addEventListener('input', () => clearErr(id));
    });

    formRak?.addEventListener('submit', function (e) {
        e.preventDefault();
        clearErr('kodeRak'); clearErr('lokasiRak');
        const kode   = document.getElementById('kodeRak')?.value.trim();
        const lokasi = document.getElementById('lokasiRak')?.value.trim();
        const ket    = document.getElementById('keteranganRak')?.value.trim();
        let ok = true;
        if (!kode)   { showErr('kodeRak',   'Kode rak wajib diisi.'); ok = false; }
        if (!lokasi) { showErr('lokasiRak', 'Lokasi wajib diisi.'); ok = false; }
        if (!ok) return;

        const id = 'rak-' + kode.replace(/\s+/g,'');
        const li = document.createElement('li');
        li.className = 'kr-item'; li.dataset.id = id;
        li.innerHTML = `
            <div class="kr-item-main">
                <div class="kr-item-kode">${kode.substring(0,3)}</div>
                <div class="kr-item-info">
                    <span class="kr-item-nama">Rak ${kode} <span class="kr-rak-lokasi">· ${lokasi}</span></span>
                    <span class="kr-item-sub">${ket || 'Tanpa keterangan'}</span>
                </div>
                <div class="kr-item-actions">
                    <button type="button" class="kr-btn-expand" data-target="${id}" title="Lihat buku">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg>
                    </button>
                    <button type="button" class="kr-btn-hapus" data-id="${id}" data-nama="Rak ${kode}" title="Hapus">
                        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                    </button>
                </div>
            </div>
            <div class="kr-item-books" id="books-${id}">
                <div class="kr-books-search-wrap">
                    <input type="text" class="kr-books-search" placeholder="Cari di Rak ${kode}..." data-target="${id}">
                </div>
                <ul class="kr-book-list"><li class="kr-no-book">Belum ada buku di rak ini.</li></ul>
            </div>`;

        listRak?.appendChild(li);
        bindNewItem(li);
        updateCount(listRak, rakCount, 'Rak');
        formRak.reset();
        showToast('Rak "' + kode + '" berhasil didaftarkan!', '#b8742f');
    });

    /* ============================================================
       MODAL HAPUS
       ============================================================ */
    const modal    = document.getElementById('krModal');
    const modalNama = document.getElementById('krModalNama');
    const btnKonfirm = document.getElementById('btnKrKonfirm');
    const btnBatal   = document.getElementById('btnKrBatal');
    let pendingItem = null;
    let pendingNama = '';

    function openModal(item, nama) {
        pendingItem = item; pendingNama = nama;
        if (modalNama) modalNama.textContent = '"' + nama + '"';
        modal?.classList.add('active');
    }
    function closeModal() { modal?.classList.remove('active'); pendingItem = null; }

    btnKonfirm?.addEventListener('click', () => {
        if (pendingItem) {
            const list = pendingItem.closest('#listKategori, #listRak');
            const count = list?.id === 'listKategori' ? katCount : rakCount;
            const label = list?.id === 'listKategori' ? 'Kategori' : 'Rak';
            pendingItem.remove();
            updateCount(list, count, label);
            showToast('"' + pendingNama + '" berhasil dihapus.', '#c0392b');
        }
        closeModal();
    });

    btnBatal?.addEventListener('click', closeModal);
    modal?.addEventListener('click', e => { if (e.target === modal) closeModal(); });
    document.addEventListener('keydown', e => { if (e.key === 'Escape') closeModal(); });

    // Bind hapus ke semua item yang sudah ada di DOM
    document.querySelectorAll('.kr-btn-hapus').forEach(btn => {
        btn.addEventListener('click', function () {
            openModal(this.closest('.kr-item'), this.dataset.nama || 'ini');
        });
    });

    /* ============================================================
       HELPER — bind event ke item baru yang ditambah secara dinamis
       ============================================================ */
    function bindNewItem(li) {
        li.querySelector('.kr-btn-expand')?.addEventListener('click', function () {
            const target = this.dataset.target;
            const panel  = document.getElementById('books-' + target);
            if (!panel) return;
            const isOpen = panel.classList.contains('open');
            const container = this.closest('#listKategori, #listRak');
            container?.querySelectorAll('.kr-item-books.open').forEach(p => p.classList.remove('open'));
            container?.querySelectorAll('.kr-btn-expand.open').forEach(b => b.classList.remove('open'));
            if (!isOpen) { panel.classList.add('open'); this.classList.add('open'); }
        });

        li.querySelector('.kr-btn-hapus')?.addEventListener('click', function () {
            openModal(this.closest('.kr-item'), this.dataset.nama || 'ini');
        });

        li.querySelector('.kr-books-search')?.addEventListener('input', function () {
            const panel = document.getElementById('books-' + this.dataset.target);
            if (!panel) return;
            const q = this.value.trim().toLowerCase();
            panel.querySelectorAll('.kr-book-item').forEach(item => {
                const j = (item.dataset.judul   || '').toLowerCase();
                const p = (item.dataset.penulis || '').toLowerCase();
                item.classList.toggle('hidden', q !== '' && !j.includes(q) && !p.includes(q));
            });
        });
    }

    function updateCount(list, badge, label) {
        if (!list || !badge) return;
        const n = list.querySelectorAll('.kr-item').length;
        badge.textContent = n + ' ' + label;
    }
});