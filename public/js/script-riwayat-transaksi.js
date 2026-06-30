/**
 * script-riwayat-transaksi.js
 * Perpustakaan SMAIT Al-Uswah
 */

'use strict';

/* ============================================================
   DATA TRANSAKSI per TRX-ID
   ============================================================ */
const dataTrx = {
    'TRX-8821': {
        kode: '#TRX-8821', status: 'dipinjam',
        nama: 'Ahmad Syahrul', kelas: 'XI-MIPA 1', email: 'ahmad.s@uswah.sch.id', inisial: 'AS', avatarClass: 'av-teal',
        tglPinjam: '12 Okt 2026', jatuhTempo: '19 Okt 2026', tglKembali: '–',
        buku: [
            { judul: 'Laskar Pelangi', penulis: 'Andrea Hirata', cover: 'Laskar_pelangi_sampul.jpg', status: 'dipinjam' },
            { judul: 'Dunia Sophie', penulis: 'Jostein Gaarder', cover: 'dunia-sophie-sampul.jpg', status: 'dipinjam' },
        ],
    },
    'TRX-8819': {
        kode: '#TRX-8819', status: 'terlambat',
        nama: 'Nadia Rahma', kelas: 'X-IPS 3', email: 'nadia.r@uswah.sch.id', inisial: 'NR', avatarClass: 'av-orange',
        tglPinjam: '05 Okt 2026', jatuhTempo: '12 Okt 2026', tglKembali: '–',
        buku: [
            { judul: 'The Things You Can See Only When You Slow Down', penulis: 'Haemin Sunim', cover: 'slow-down-sampul.jpg', status: 'terlambat' },
        ],
    },
    'TRX-8815': {
        kode: '#TRX-8815', status: 'dikembalikan',
        nama: 'Farel Kurniawan', kelas: 'XII-MIPA 1', email: 'farel.k@uswah.sch.id', inisial: 'FK', avatarClass: 'av-purple',
        tglPinjam: '01 Okt 2026', jatuhTempo: '08 Okt 2026', tglKembali: '08 Okt 2026',
        buku: [
            { judul: 'Laskar Pelangi', penulis: 'Andrea Hirata', cover: 'Laskar_pelangi_sampul.jpg', status: 'dikembalikan' },
            { judul: 'Sejarah Peradaban Islam', penulis: 'Badri Yatim', cover: 'sejarah-peradaban-silam-sampul.png', status: 'dikembalikan' },
            { judul: 'Dunia Sophie', penulis: 'Jostein Gaarder', cover: 'dunia-sophie-sampul.jpg', status: 'dikembalikan' },
        ],
    },
    'TRX-8810': {
        kode: '#TRX-8810', status: 'dikembalikan',
        nama: 'Siti Aminah, M.Pd', kelas: 'Guru', email: 'siti.aminah@uswah.sch.id', inisial: 'SA', avatarClass: 'av-mint',
        tglPinjam: '20 Sep 2026', jatuhTempo: '04 Okt 2026', tglKembali: '03 Okt 2026',
        buku: [
            { judul: 'Sejarah Peradaban Islam', penulis: 'Prof. Dr. Badri Yatim, M.A.', cover: 'sejarah-peradaban-silam-sampul.png', status: 'dikembalikan' },
        ],
    },
};

/* ============================================================
   DATA PEMINJAM PER BUKU
   ============================================================ */
const dataPeminjamBuku = {
    '1': {
        judul: 'Laskar Pelangi', penulis: 'Andrea Hirata', cover: 'Laskar_pelangi_sampul.jpg',
        totalPinjam: 86, sedangDipinjam: 2, dikembalikan: 84,
        peminjam: [
            { nama: 'Ahmad Syahrul',   kelas: 'XI-MIPA 1',  tgl: '12 Okt 2026 – sekarang',      status: 'dipinjam',     inisial: 'AS', avatarClass: 'av-teal' },
            { nama: 'Farel Kurniawan', kelas: 'XII-MIPA 1', tgl: '01 – 08 Okt 2026',              status: 'dikembalikan', inisial: 'FK', avatarClass: 'av-purple' },
            { nama: 'Budi Santoso',    kelas: 'XII-MIPA 1', tgl: '05 – 19 Sep 2026',              status: 'dikembalikan', inisial: 'BS', avatarClass: 'av-teal' },
        ],
    },
    '2': {
        judul: 'Dunia Sophie', penulis: 'Jostein Gaarder', cover: 'dunia-sophie-sampul.jpg',
        totalPinjam: 72, sedangDipinjam: 0, dikembalikan: 72,
        peminjam: [
            { nama: 'Ahmad Syahrul',   kelas: 'XI-MIPA 1',  tgl: '12 Okt 2026 – sekarang',      status: 'dipinjam',     inisial: 'AS', avatarClass: 'av-teal' },
            { nama: 'Farel Kurniawan', kelas: 'XII-MIPA 1', tgl: '01 – 08 Okt 2026',              status: 'dikembalikan', inisial: 'FK', avatarClass: 'av-purple' },
            { nama: 'Citra Lestari',   kelas: 'XI-IPS 1',   tgl: '10 – 24 Feb 2026',              status: 'dikembalikan', inisial: 'CL', avatarClass: 'av-mint' },
        ],
    },
    '3': {
        judul: 'Sejarah Peradaban Islam', penulis: 'Prof. Dr. Badri Yatim, M.A.', cover: 'sejarah-peradaban-silam-sampul.png',
        totalPinjam: 54, sedangDipinjam: 0, dikembalikan: 54,
        peminjam: [
            { nama: 'Farel Kurniawan',   kelas: 'XII-MIPA 1', tgl: '01 – 08 Okt 2026',            status: 'dikembalikan', inisial: 'FK', avatarClass: 'av-purple' },
            { nama: 'Siti Aminah, M.Pd', kelas: 'Guru',       tgl: '20 Sep – 03 Okt 2026',        status: 'dikembalikan', inisial: 'SA', avatarClass: 'av-mint' },
        ],
    },
    '4': {
        judul: 'The Things You Can See Only When You Slow Down', penulis: 'Haemin Sunim', cover: 'slow-down-sampul.jpg',
        totalPinjam: 48, sedangDipinjam: 1, dikembalikan: 47,
        peminjam: [
            { nama: 'Nadia Rahma',  kelas: 'X-IPS 3', tgl: '05 Okt 2026 – sekarang (terlambat)', status: 'terlambat',    inisial: 'NR', avatarClass: 'av-orange' },
            { nama: 'Rara Anindia', kelas: 'X-IPS 3', tgl: '10 – 28 Okt 2025',                   status: 'dikembalikan', inisial: 'RA', avatarClass: 'av-purple' },
        ],
    },
};

const statusLabel = { dipinjam: 'Dipinjam', terlambat: 'Terlambat', dikembalikan: 'Dikembalikan' };
const statusClass  = { dipinjam: 'st-dipinjam', terlambat: 'st-terlambat', dikembalikan: 'st-dikembalikan' };

document.addEventListener('DOMContentLoaded', function () {

    document.querySelectorAll('.nav-link').forEach(l => {
        if (l.getAttribute('href') === window.location.pathname) l.classList.add('active');
    });

    /* ============================================================
       MODE TOGGLE
       ============================================================ */
    const btnAnggota     = document.getElementById('btnModeAnggota');
    const btnBuku        = document.getElementById('btnModeBuku');
    const modeAnggotaSec = document.querySelector('.rt-table-section:not(#modeBukuSection)');
    const modeBukuSec    = document.getElementById('modeBukuSection');
    const filterSection  = document.querySelector('.rt-filter-section');

    btnAnggota?.addEventListener('click', () => {
        btnAnggota.classList.add('active'); btnBuku.classList.remove('active');
        if (modeAnggotaSec) modeAnggotaSec.style.display = '';
        if (modeBukuSec)    modeBukuSec.style.display    = 'none';
        if (filterSection)  filterSection.style.display  = '';
        render();
    });

    btnBuku?.addEventListener('click', () => {
        btnBuku.classList.add('active'); btnAnggota.classList.remove('active');
        if (modeAnggotaSec) modeAnggotaSec.style.display = 'none';
        if (modeBukuSec)    modeBukuSec.style.display    = '';
        if (filterSection)  filterSection.style.display  = 'none';
        renderBukuGrid();
    });

    /* ============================================================
       FILTER MODE ANGGOTA
       ============================================================ */
    const rtEmpty = document.getElementById('rtEmpty');
    const rtInfo  = document.getElementById('rtInfo');

    function render() {
        const rows   = Array.from(document.querySelectorAll('#rtTbody .rt-row'));
        const status = (document.getElementById('statusSelect')?.value  || 'semua');
        const kelas  = (document.getElementById('kelasSelect')?.value   || 'semua');
        const qNama  = (document.getElementById('searchNama')?.value    || '').trim().toLowerCase();
        const tglA   = document.getElementById('tglAwal')?.value   || '';
        const tglB   = document.getElementById('tglAkhir')?.value  || '';

        let count = 0;
        rows.forEach(row => {
            const matchStatus = status === 'semua' || row.dataset.status === status;
            const matchKelas  = kelas  === 'semua' || row.dataset.kelas  === kelas;
            const matchNama   = !qNama || (row.dataset.nama || '').toLowerCase().includes(qNama);
            const rowTgl      = row.dataset.tglPinjam || '';
            const matchTgl    = (!tglA || rowTgl >= tglA) && (!tglB || rowTgl <= tglB);
            const show = matchStatus && matchKelas && matchNama && matchTgl;
            row.style.display = show ? '' : 'none';
            if (show) count++;
        });

        if (rtEmpty) rtEmpty.style.display = count === 0 ? '' : 'none';
        if (rtInfo)  rtInfo.textContent = `Menampilkan 1–${count} dari 124 transaksi`;
    }

    ['statusSelect','kelasSelect','searchNama','tglAwal','tglAkhir'].forEach(id => {
        document.getElementById(id)?.addEventListener(['statusSelect','kelasSelect'].includes(id) ? 'change' : 'input', render);
    });
    render();

    /* ============================================================
       GRID BUKU + SEARCH
       ============================================================ */
    function renderBukuGrid() {
        const q = (document.getElementById('searchBukuGrid')?.value || '').trim().toLowerCase();
        let count = 0;
        document.querySelectorAll('.rt-buku-card').forEach(card => {
            const show = !q || (card.dataset.judul || '').includes(q);
            card.style.display = show ? '' : 'none';
            if (show) count++;
        });
        const empty = document.getElementById('rtBukuEmpty');
        if (empty) empty.style.display = count === 0 ? '' : 'none';
    }

    document.getElementById('searchBukuGrid')?.addEventListener('input', renderBukuGrid);

    /* ============================================================
       PAGINATION
       ============================================================ */
    let page = 1;
    document.querySelectorAll('.rt-page-btn[data-page]').forEach(btn => {
        btn.addEventListener('click', () => {
            page = parseInt(btn.dataset.page);
            document.querySelectorAll('.rt-page-btn[data-page]').forEach(b =>
                b.classList.toggle('active', parseInt(b.dataset.page) === page));
            if (rtInfo) rtInfo.textContent = `Menampilkan ${(page-1)*10+1}–${Math.min(page*10,124)} dari 124 transaksi`;
        });
    });

    /* ============================================================
       MODAL DETAIL TRANSAKSI (per anggota)
       ============================================================ */
    const trxModal      = document.getElementById('rtModal');
    const trxModalClose = document.getElementById('rtModalClose');

    function openTrxModal(id) {
        const d = dataTrx[id];
        if (!d) return;
        document.getElementById('modalKode').textContent      = d.kode;
        document.getElementById('modalTglPinjam').textContent = d.tglPinjam;
        document.getElementById('modalJatuhTempo').textContent= d.jatuhTempo;
        document.getElementById('modalTglKembali').textContent= d.tglKembali;
        document.getElementById('modalNama').textContent      = d.nama;
        document.getElementById('modalKelas').textContent     = d.kelas;
        document.getElementById('modalEmail').textContent     = d.email;
        const av = document.getElementById('modalAvatar');
        av.textContent = d.inisial; av.className = 'rt-modal-avatar ' + d.avatarClass;
        const st = document.getElementById('modalStatus');
        st.textContent = statusLabel[d.status]; st.className = 'rt-modal-status ' + statusClass[d.status];
        document.getElementById('modalBookList').innerHTML = d.buku.map(b => `
            <li class="rt-modal-book-item">
                <img src="/assets/${b.cover}" alt="" class="rt-modal-book-cover" onerror="this.style.display='none'">
                <div class="rt-modal-book-info">
                    <span class="rt-modal-book-judul">${b.judul}</span>
                    <span class="rt-modal-book-penulis">${b.penulis}</span>
                </div>
                <span class="rt-modal-book-status ${statusClass[b.status]}">${statusLabel[b.status]}</span>
            </li>`).join('');
        trxModal?.classList.add('active');
    }

    function closeTrxModal() { trxModal?.classList.remove('active'); }

    document.querySelectorAll('.btn-rt-detail').forEach(btn => {
        btn.addEventListener('click', () => openTrxModal(btn.dataset.id));
    });
    trxModalClose?.addEventListener('click', closeTrxModal);
    trxModal?.addEventListener('click', e => { if (e.target === trxModal) closeTrxModal(); });

    /* ============================================================
       MODAL PEMINJAM PER BUKU
       ============================================================ */
    const bukuModal      = document.getElementById('rtBukuModal');
    const bukuModalClose = document.getElementById('rtBukuModalClose');

    function openBukuModal(id) {
        const d = dataPeminjamBuku[id];
        if (!d) return;
        document.getElementById('bukuModalJudul').textContent  = d.judul;
        document.getElementById('bukuModalPenulis').textContent = d.penulis;
        const coverEl = document.getElementById('bukuModalCover');
        if (coverEl) { coverEl.src = '/assets/' + d.cover; coverEl.alt = d.judul; }

        document.getElementById('bukuModalStats').innerHTML = `
            <div class="rt-buku-modal-stat">
                <span class="rt-buku-modal-stat-val">${d.totalPinjam}</span>
                <span class="rt-buku-modal-stat-lbl">Total Dipinjam</span>
            </div>
            <div class="rt-buku-modal-stat">
                <span class="rt-buku-modal-stat-val" style="color:var(--primary)">${d.sedangDipinjam}</span>
                <span class="rt-buku-modal-stat-lbl">Sedang Dipinjam</span>
            </div>
            <div class="rt-buku-modal-stat">
                <span class="rt-buku-modal-stat-val" style="color:#16a085">${d.dikembalikan}</span>
                <span class="rt-buku-modal-stat-lbl">Dikembalikan</span>
            </div>`;

        document.getElementById('bukuModalPeminjamList').innerHTML = d.peminjam.map(p => `
            <li class="rt-modal-book-item rt-peminjam-item">
                <div class="rt-peminjam-avatar ${p.avatarClass}">${p.inisial}</div>
                <div class="rt-peminjam-info">
                    <span class="rt-peminjam-nama">${p.nama}</span>
                    <span class="rt-peminjam-detail">${p.kelas} · ${p.tgl}</span>
                </div>
                <span class="rt-modal-book-status ${statusClass[p.status]}">${statusLabel[p.status]}</span>
            </li>`).join('');

        bukuModal?.classList.add('active');
    }

    function closeBukuModal() { bukuModal?.classList.remove('active'); }

    document.querySelectorAll('.rt-buku-card').forEach(card => {
        card.addEventListener('click', () => openBukuModal(card.dataset.bukuId));
    });
    bukuModalClose?.addEventListener('click', closeBukuModal);
    bukuModal?.addEventListener('click', e => { if (e.target === bukuModal) closeBukuModal(); });

    document.addEventListener('keydown', e => {
        if (e.key === 'Escape') { closeTrxModal(); closeBukuModal(); }
    });
});