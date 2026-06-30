/**
 * script-kelola-anggota.js
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

document.addEventListener('DOMContentLoaded', function () {

    const searchInput = document.getElementById('searchInput');
    const kelasSelect = document.getElementById('kelasSelect');
    const statusSelect = document.getElementById('statusSelect');
    const tglFilter = document.getElementById('tglFilter');
    const empty = document.getElementById('kaEmpty');
    const info  = document.getElementById('kaInfo');

    /* ============================================================
       DATA DUMMY ANGGOTA (nanti dari controller)
       ============================================================ */
    const dataAnggota = {
        '1': {
            nama: 'Ahmad Fathoni', nis: '20210045', kelas: 'XI-MIPA 1',
            email: 'ahmad.f@uswah.sch.id', status: 'aktif', inisial: 'AF',
            avatarClass: 'av-teal',
            totalPinjam: 3, aktifPinjam: 1, totalDenda: 'Rp 0',
            pinjam: [
                { judul: 'Laskar Pelangi', penulis: 'Andrea Hirata', tgl: '10 Jun 2026 – 24 Jun 2026', status: 'Dikembalikan', badge: 'badge-kembali', cover: 'Laskar_pelangi_sampul.jpg' },
                { judul: 'Dunia Sophie',   penulis: 'Jostein Gaarder', tgl: '01 Jul 2026 – sekarang',  status: 'Dipinjam',      badge: 'badge-dipinjam', cover: 'dunia-sophie-sampul.jpg' },
                { judul: 'Sejarah Peradaban Islam', penulis: 'Badri Yatim', tgl: '05 Mar 2026 – 19 Mar 2026', status: 'Dikembalikan', badge: 'badge-kembali', cover: 'sejarah-peradaban-silam-sampul.png' },
            ],
            denda: [],
        },
        '2': {
            nama: 'Siti Aminah, M.Pd', nis: '19880412', kelas: 'Guru',
            email: 'siti.aminah@uswah.sch.id', status: 'aktif', inisial: 'SA',
            avatarClass: 'av-orange',
            totalPinjam: 5, aktifPinjam: 0, totalDenda: 'Rp 5.000',
            pinjam: [
                { judul: 'Laskar Pelangi', penulis: 'Andrea Hirata', tgl: '01 Jan 2026 – 15 Jan 2026', status: 'Dikembalikan', badge: 'badge-kembali', cover: 'Laskar_pelangi_sampul.jpg' },
                { judul: 'Dunia Sophie',   penulis: 'Jostein Gaarder', tgl: '20 Feb 2026 – 06 Mar 2026', status: 'Terlambat', badge: 'badge-terlambat', cover: 'dunia-sophie-sampul.jpg' },
            ],
            denda: [
                { buku: 'Dunia Sophie', tanggal: '07 Mar 2026', nominal: 'Rp 5.000', status: 'Lunas', statusClass: 'denda-lunas' },
            ],
        },
        '3': {
            nama: 'Rara Anindia', nis: '20220192', kelas: 'X-IPS 3',
            email: 'rara.an@uswah.sch.id', status: 'nonaktif', inisial: 'RA',
            avatarClass: 'av-purple',
            totalPinjam: 1, aktifPinjam: 0, totalDenda: 'Rp 12.000',
            pinjam: [
                { judul: 'The Things You Can See Only When You Slow Down', penulis: 'Haemin Sunim', tgl: '10 Okt 2025 – 28 Okt 2025', status: 'Terlambat', badge: 'badge-terlambat', cover: 'slow-down-sampul.jpg' },
            ],
            denda: [
                { buku: 'The Things You Can See Only When You Slow Down', tanggal: '29 Okt 2025', nominal: 'Rp 12.000', status: 'Belum Lunas', statusClass: 'denda-belum' },
            ],
        },
        '4': {
            nama: 'Budi Santoso', nis: '20230087', kelas: 'XII-MIPA 1',
            email: 'budi.s@uswah.sch.id', status: 'aktif', inisial: 'BS',
            avatarClass: 'av-teal',
            totalPinjam: 7, aktifPinjam: 0, totalDenda: 'Rp 0',
            pinjam: [
                { judul: 'Laskar Pelangi', penulis: 'Andrea Hirata', tgl: '05 Mei 2026 – 19 Mei 2026', status: 'Dikembalikan', badge: 'badge-kembali', cover: 'Laskar_pelangi_sampul.jpg' },
                { judul: 'Sejarah Peradaban Islam', penulis: 'Badri Yatim', tgl: '01 Apr 2026 – 15 Apr 2026', status: 'Dikembalikan', badge: 'badge-kembali', cover: 'sejarah-peradaban-silam-sampul.png' },
            ],
            denda: [],
        },
        '5': {
            nama: 'Citra Lestari', nis: '20210156', kelas: 'XI-IPS 1',
            email: 'citra.l@uswah.sch.id', status: 'nonaktif', inisial: 'CL',
            avatarClass: 'av-mint',
            totalPinjam: 2, aktifPinjam: 0, totalDenda: 'Rp 2.000',
            pinjam: [
                { judul: 'Dunia Sophie', penulis: 'Jostein Gaarder', tgl: '10 Feb 2026 – 14 Feb 2026', status: 'Terlambat', badge: 'badge-terlambat', cover: 'dunia-sophie-sampul.jpg' },
            ],
            denda: [
                { buku: 'Dunia Sophie', tanggal: '15 Feb 2026', nominal: 'Rp 2.000', status: 'Lunas', statusClass: 'denda-lunas' },
            ],
        },
    };

    /* ============================================================
       MODAL DETAIL ANGGOTA
       ============================================================ */
    const daModal   = document.getElementById('daModal');
    const daClose   = document.getElementById('daModalClose');
    const daTabs    = document.querySelectorAll('.da-tab');
    const tabPinjam = document.getElementById('tabPinjam');
    const tabDenda  = document.getElementById('tabDenda');

    function openDetailModal(id) {
        const d = dataAnggota[id];
        if (!d) return;

        // Isi profil
        const av = document.getElementById('daAvatar');
        av.textContent = d.inisial;
        av.className = 'da-profil-avatar ' + d.avatarClass;

        document.getElementById('daNama').textContent   = d.nama;
        document.getElementById('daNis').textContent    = 'NIS: ' + d.nis;
        document.getElementById('daKelas').textContent  = d.kelas;
        document.getElementById('daEmail').textContent  = d.email;

        const stEl = document.getElementById('daStatus');
        stEl.textContent = d.status === 'aktif' ? 'Aktif' : 'Nonaktif';
        stEl.className   = 'da-profil-status ' + (d.status === 'aktif' ? 'st-aktif' : 'st-nonaktif');

        // Stats
        document.getElementById('daTotalPinjam').textContent  = d.totalPinjam;
        document.getElementById('daAktifPinjam').textContent  = d.aktifPinjam;
        document.getElementById('daTotalDenda').textContent   = d.totalDenda;

        // Pinjam list
        const pinjamList = document.getElementById('daPinjamList');
        pinjamList.innerHTML = d.pinjam.length === 0
            ? '<p class="da-empty-msg">Belum pernah meminjam buku.</p>'
            : d.pinjam.map(p => `
                <li class="da-pinjam-item">
                    <img src="/assets/${p.cover}" alt="" class="da-pinjam-cover" onerror="this.style.display='none'">
                    <div class="da-pinjam-info">
                        <span class="da-pinjam-judul">${p.judul}</span>
                        <span class="da-pinjam-meta">${p.penulis} · ${p.tgl}</span>
                    </div>
                    <span class="da-pinjam-badge ${p.badge}">${p.status}</span>
                </li>`).join('');

        // Denda list
        const dendaList = document.getElementById('daDendaList');
        dendaList.innerHTML = d.denda.length === 0
            ? '<p class="da-empty-msg">Tidak ada riwayat denda.</p>'
            : d.denda.map(dn => `
                <li class="da-denda-item">
                    <div class="da-denda-info">
                        <span class="da-denda-buku">${dn.buku}</span>
                        <span class="da-denda-tanggal">${dn.tanggal}</span>
                    </div>
                    <div class="da-denda-right">
                        <span class="da-denda-nominal">${dn.nominal}</span>
                        <span class="da-denda-status ${dn.statusClass}">${dn.status}</span>
                    </div>
                </li>`).join('');

        // Reset tab ke pinjam
        daTabs.forEach(t => t.classList.remove('active'));
        daTabs[0]?.classList.add('active');
        tabPinjam?.classList.remove('hidden');
        tabDenda?.classList.add('hidden');

        daModal?.classList.add('active');
    }

    function closeDetailModal() { daModal?.classList.remove('active'); }

    daClose?.addEventListener('click', closeDetailModal);
    daModal?.addEventListener('click', e => { if (e.target === daModal) closeDetailModal(); });

    // Tab switch
    daTabs.forEach(tab => {
        tab.addEventListener('click', function () {
            daTabs.forEach(t => t.classList.remove('active'));
            this.classList.add('active');
            if (this.dataset.tab === 'pinjam') {
                tabPinjam?.classList.remove('hidden');
                tabDenda?.classList.add('hidden');
            } else {
                tabDenda?.classList.remove('hidden');
                tabPinjam?.classList.add('hidden');
            }
        });
    });

    // Bind tombol lihat
    document.querySelectorAll('.btn-lihat').forEach(btn => {
        btn.addEventListener('click', function () {
            openDetailModal(this.dataset.id);
        });
    });

    /* ============================================================
       FILTER + SEARCH
       ============================================================ */
    function render() {
        const rows = Array.from(document.querySelectorAll('#anggotaTbody .ka-row'));
        const q      = (searchInput?.value || '').trim().toLowerCase();
        const kelas  = kelasSelect?.value  || 'semua';
        const status = statusSelect?.value || 'semua';
        const tgl    = tglFilter?.value    || '';

        let count = 0;
        rows.forEach(row => {
            const nama    = (row.dataset.nama   || '').toLowerCase();
            const nis     = (row.dataset.nis    || '').toLowerCase();
            const rowKls  = row.dataset.kelas   || '';
            const rowSt   = row.dataset.status  || '';
            const rowTgl  = row.dataset.tgl     || '';

            const matchQ   = !q      || nama.includes(q) || nis.includes(q);
            const matchKls = kelas  === 'semua' || rowKls === kelas;
            const matchSt  = status === 'semua' || rowSt  === status;
            const matchTgl = !tgl   || rowTgl === tgl;

            const show = matchQ && matchKls && matchSt && matchTgl;
            row.style.display = show ? '' : 'none';
            if (show) count++;
        });

        empty.style.display = count === 0 ? '' : 'none';
        if (info) info.textContent = `Menampilkan 1–${count} dari 1.240 anggota`;
    }

    searchInput?.addEventListener('input',  render);
    kelasSelect?.addEventListener('change', render);
    statusSelect?.addEventListener('change', render);
    tglFilter?.addEventListener('change',   render);
    render();

    /* ============================================================
       SORT
       ============================================================ */
    let sortCol = null, sortDir = 1;

    document.querySelectorAll('.ka-table thead th.sortable').forEach(th => {
        th.addEventListener('click', function () {
            const col = this.dataset.col;
            if (sortCol === col) sortDir *= -1; else { sortCol = col; sortDir = 1; }

            // Reset visual
            document.querySelectorAll('.ka-table thead th.sortable').forEach(t => {
                t.classList.remove('sort-asc','sort-desc');
            });
            this.classList.add(sortDir === 1 ? 'sort-asc' : 'sort-desc');

            const tbody = document.getElementById('anggotaTbody');
            const rows = Array.from(tbody.querySelectorAll('.ka-row'));
            rows.sort((a, b) => {
                const va = a.dataset[col === 'tgl' ? 'tgl' : col === 'nis' ? 'nis' : 'nama'] || '';
                const vb = b.dataset[col === 'tgl' ? 'tgl' : col === 'nis' ? 'nis' : 'nama'] || '';
                return va.localeCompare(vb, 'id') * sortDir;
            });
            rows.forEach(r => tbody.appendChild(r));
        });
    });

    /* ============================================================
       TOMBOL SORT FILTER (≡ ikon)
       ============================================================ */
    document.getElementById('btnSort')?.addEventListener('click', function () {
        // Toggle antara urutkan nama A-Z dan Z-A
        const tbody = document.getElementById('anggotaTbody');
        const rows = Array.from(tbody.querySelectorAll('.ka-row'));
        sortDir = sortCol === 'nama' ? sortDir * -1 : 1;
        sortCol = 'nama';
        rows.sort((a, b) => (a.dataset.nama || '').localeCompare(b.dataset.nama || '', 'id') * sortDir);
        rows.forEach(r => tbody.appendChild(r));
        showToast('Diurutkan ' + (sortDir === 1 ? 'A → Z' : 'Z → A'));
    });

    /* ============================================================
       EXPORT & PRINT
       ============================================================ */
    document.getElementById('btnExport')?.addEventListener('click', () => {
        const rows = Array.from(document.querySelectorAll('#anggotaTbody .ka-row'))
            .filter(r => r.style.display !== 'none');
        const lines = ['NIS,Nama,Kelas,Email,Status,Terdaftar'];
        rows.forEach(r => {
            const cells = r.querySelectorAll('td');
            lines.push([
                cells[1]?.textContent.trim(),
                cells[2]?.textContent.trim(),
                cells[3]?.textContent.trim(),
                cells[4]?.textContent.trim(),
                cells[5]?.textContent.trim(),
                cells[6]?.textContent.trim(),
            ].map(v => '"' + v + '"').join(','));
        });
        const blob = new Blob([lines.join('\n')], { type: 'text/csv' });
        const a = document.createElement('a');
        a.href = URL.createObjectURL(blob);
        a.download = 'daftar-anggota.csv';
        a.click();
        showToast('Data berhasil diunduh!');
    });

    document.getElementById('btnPrint')?.addEventListener('click', () => window.print());

    /* ============================================================
       PAGINATION
       ============================================================ */
    let currentPage = 1;
    const pageBtns = Array.from(document.querySelectorAll('.ka-page-btn[data-page]'));

    pageBtns.forEach(btn => btn.addEventListener('click', () => setPage(parseInt(btn.dataset.page))));
    document.getElementById('kaPrev')?.addEventListener('click', () => setPage(currentPage - 1));
    document.getElementById('kaNext')?.addEventListener('click', () => setPage(currentPage + 1));

    function setPage(p) {
        currentPage = Math.max(1, Math.min(124, p));
        pageBtns.forEach(b => b.classList.toggle('active', parseInt(b.dataset.page) === currentPage));
        if (info) info.textContent = `Menampilkan ${(currentPage-1)*10+1}–${Math.min(currentPage*10, 1240)} dari 1.240 anggota`;
    }

    /* ============================================================
       MODAL TOGGLE STATUS (Nonaktifkan / Aktifkan)
       ============================================================ */
    const modal      = document.getElementById('kaModal');
    const modalIc    = document.getElementById('kaModalIc');
    const modalTitle = document.getElementById('kaModalTitle');
    const modalDesc  = document.getElementById('kaModalDesc');
    const btnKonfirm = document.getElementById('btnKaKonfirm');
    const btnBatal   = document.getElementById('btnKaBatal');
    let pendingBtn = null;

    function openModal(btn) {
        pendingBtn = btn;
        const nama   = btn.dataset.nama;
        const status = btn.dataset.status;
        const isAktif = status === 'aktif';

        modalIc.style.background = isAktif ? 'rgba(192,57,43,.1)' : 'rgba(22,160,133,.1)';
        modalIc.innerHTML = isAktif
            ? '<svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="#c0392b" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="4.93" y1="4.93" x2="19.07" y2="19.07"/></svg>'
            : '<svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="#16a085" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>';

        modalTitle.textContent = isAktif ? 'Nonaktifkan Anggota?' : 'Aktifkan Anggota?';
        modalTitle.style.color = isAktif ? '#c0392b' : '#16a085';
        modalDesc.textContent  = `${isAktif ? 'Nonaktifkan' : 'Aktifkan'} akun "${nama}"? Status keanggotaan akan segera diperbarui.`;

        btnKonfirm.textContent       = isAktif ? 'Ya, Nonaktifkan' : 'Ya, Aktifkan';
        btnKonfirm.style.background  = isAktif ? '#c0392b' : '#16a085';

        modal.classList.add('active');
    }

    function closeModal() { modal.classList.remove('active'); pendingBtn = null; }

    btnKonfirm?.addEventListener('click', () => {
        if (!pendingBtn) return;
        const row    = pendingBtn.closest('.ka-row');
        const nama   = pendingBtn.dataset.nama;
        const isAktif = pendingBtn.dataset.status === 'aktif';
        const newStatus = isAktif ? 'nonaktif' : 'aktif';

        // Update badge
        const badge = row?.querySelector('.ka-status');
        if (badge) {
            badge.textContent = isAktif ? 'Nonaktif' : 'Aktif';
            badge.className = 'ka-status ' + (isAktif ? 'st-nonaktif' : 'st-aktif');
        }

        // Ganti tombol aksi
        const aksiDiv = row?.querySelector('.ka-aksi');
        if (aksiDiv) {
            const newBtn = pendingBtn.cloneNode(true);
            newBtn.dataset.status = newStatus;
            if (isAktif) {
                newBtn.className = 'ka-btn-aksi btn-aktifkan';
                newBtn.title = 'Aktifkan';
                newBtn.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>';
            } else {
                newBtn.className = 'ka-btn-aksi btn-nonaktif';
                newBtn.title = 'Nonaktifkan';
                newBtn.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="4.93" y1="4.93" x2="19.07" y2="19.07"/></svg>';
            }
            newBtn.addEventListener('click', () => openModal(newBtn));
            pendingBtn.replaceWith(newBtn);
        }

        // Update data-status di row
        row.dataset.status = newStatus;

        showToast('"' + nama + '" berhasil ' + (isAktif ? 'dinonaktifkan.' : 'diaktifkan.'),
                  isAktif ? '#c0392b' : '#16a085');
        closeModal();
        render();
    });

    btnBatal?.addEventListener('click', closeModal);
    modal?.addEventListener('click', e => { if (e.target === modal) closeModal(); });
    document.addEventListener('keydown', e => { if (e.key === 'Escape') closeModal(); });

    // Bind tombol status
    document.querySelectorAll('.btn-nonaktif, .btn-aktifkan').forEach(btn => {
        btn.addEventListener('click', () => openModal(btn));
    });
});