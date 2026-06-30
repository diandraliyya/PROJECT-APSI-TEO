/**
 * script-laporan.js
 * Perpustakaan SMAIT Al-Uswah
 *
 * - Filter laporan (validasi tanggal, update label periode)
 * - Animasi bar chart
 * - Export PDF (jsPDF) & Excel (SheetJS) dengan modal konfirmasi
 * - Pagination
 */

'use strict';

/* ── Toast ── */
function showToast(msg, color) {
    const toast = document.getElementById('toast');
    if (!toast) return;
    toast.textContent = msg;
    toast.style.background = color || 'var(--primary)';
    toast.classList.add('show');
    clearTimeout(toast._t);
    toast._t = setTimeout(() => toast.classList.remove('show'), 3000);
}

/* ── Animasi bar chart ── */
function animateBars() {
    document.querySelectorAll('.lap-bar').forEach(bar => {
        const t = bar.style.getPropertyValue('--h');
        bar.style.setProperty('--h', '0%');
        requestAnimationFrame(() => setTimeout(() => bar.style.setProperty('--h', t), 100));
    });
}

document.addEventListener('DOMContentLoaded', function () {

    /* ── Active nav ── */
    document.querySelectorAll('.nav-link').forEach(link => {
        if (link.getAttribute('href') === window.location.pathname) link.classList.add('active');
    });

    animateBars();

    /* ================================================================
       FILTER LAPORAN
       ================================================================ */
    const btnTampilkan  = document.getElementById('btnTampilkan');
    const tglAwal       = document.getElementById('tglAwal');
    const tglAkhir      = document.getElementById('tglAkhir');
    const jenisLaporan  = document.getElementById('jenisLaporan');
    const filterErr     = document.getElementById('filterErr');
    const periodLabel   = document.getElementById('periodLabel');
    const chartTitle    = document.getElementById('chartTitle');
    const tableInfo     = document.getElementById('tableInfo');

    const judulMap = {
        'pinjam-bulan': { chart: 'Statistik Peminjaman', info: 'Menampilkan 4 dari 150 data buku terpopuler' },
        'pinjam-buku':  { chart: 'Buku Terpopuler',     info: 'Menampilkan 4 dari 87 judul buku' },
        'denda':        { chart: 'Statistik Denda',     info: 'Menampilkan 4 dari 42 data denda aktif' },
        'anggota':      { chart: 'Aktivitas Anggota',   info: 'Menampilkan 4 dari 312 anggota aktif' },
    };

    btnTampilkan?.addEventListener('click', function () {
        filterErr.classList.add('hidden');

        const a = tglAwal.value;
        const b = tglAkhir.value;

        if (a && b && a > b) {
            filterErr.classList.remove('hidden');
            return;
        }

        const jenis = jenisLaporan.value;
        const titles = judulMap[jenis] || judulMap['pinjam-bulan'];

        // Update chart title
        if (chartTitle) chartTitle.textContent = titles.chart;
        if (tableInfo) tableInfo.textContent = titles.info;

        // Update period label
        if (a && b) {
            const fmt = d => new Date(d).toLocaleDateString('id-ID', { day: 'numeric', month: 'short', year: 'numeric' });
            periodLabel.textContent = fmt(a) + ' – ' + fmt(b);
        } else {
            const now = new Date();
            periodLabel.textContent = now.toLocaleDateString('id-ID', { month: 'long', year: 'numeric' });
        }

        // Animate bars with random-ish new data
        const variants = [[55,45,70,80,60,90],[40,60,50,75,65,85],[30,50,45,65,55,70],[60,40,80,55,70,65]];
        const v = variants[Object.keys(judulMap).indexOf(jenis)] || variants[0];
        document.querySelectorAll('.lap-bar.b-fiksi').forEach((bar, i) => {
            bar.style.setProperty('--h', '0%');
            requestAnimationFrame(() => setTimeout(() => bar.style.setProperty('--h', (v[i] || 50) + '%'), 100));
        });
        document.querySelectorAll('.lap-bar.b-nonfiksi').forEach((bar, i) => {
            bar.style.setProperty('--h', '0%');
            requestAnimationFrame(() => setTimeout(() => bar.style.setProperty('--h', ((v[i] || 50) - 20) + '%'), 100));
        });

        showToast('Laporan berhasil diperbarui!');
    });

    /* ================================================================
       PAGINATION
       ================================================================ */
    const pageBtns = document.querySelectorAll('.lap-page-btn[data-page]');
    const pagePrev = document.getElementById('pagePrev');
    const pageNext = document.getElementById('pageNext');
    let currentPage = 1;
    const totalPages = 15;

    function setPage(p) {
        currentPage = Math.max(1, Math.min(totalPages, p));
        pageBtns.forEach(btn => {
            btn.classList.toggle('active', parseInt(btn.dataset.page) === currentPage);
        });
        if (tableInfo) tableInfo.textContent = `Menampilkan ${(currentPage - 1) * 4 + 1}–${Math.min(currentPage * 4, 150)} dari 150 data`;
    }

    pageBtns.forEach(btn => {
        btn.addEventListener('click', () => setPage(parseInt(btn.dataset.page)));
    });

    pagePrev?.addEventListener('click', () => setPage(currentPage - 1));
    pageNext?.addEventListener('click', () => setPage(currentPage + 1));

    /* ================================================================
       EXPORT — Modal konfirmasi
       ================================================================ */
    const exportModal    = document.getElementById('exportModal');
    const exportModalIc  = document.getElementById('exportModalIc');
    const exportModalTitle = document.getElementById('exportModalTitle');
    const exportModalDesc  = document.getElementById('exportModalDesc');
    const btnConfirm     = document.getElementById('btnModalConfirm');
    const btnCancel      = document.getElementById('btnModalCancel');
    let pendingExport    = null;

    function openExportModal(type) {
        pendingExport = type;

        const isPdf = type === 'pdf';
        exportModalIc.style.background = isPdf ? 'rgba(192,57,43,.12)' : 'rgba(22,160,133,.12)';
        exportModalIc.innerHTML = isPdf
            ? '<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#c0392b" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>'
            : '<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#16a085" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2"/><line x1="3" y1="9" x2="21" y2="9"/><line x1="3" y1="15" x2="21" y2="15"/><line x1="9" y1="3" x2="9" y2="21"/><line x1="15" y1="3" x2="15" y2="21"/></svg>';

        exportModalTitle.textContent = isPdf ? 'Export sebagai PDF?' : 'Export sebagai Excel?';
        exportModalDesc.textContent = `Laporan "${jenisLaporan.options[jenisLaporan.selectedIndex].text}" akan diunduh dalam format ${isPdf ? 'PDF' : 'Excel (.xlsx'}).`;
        btnConfirm.style.background = isPdf ? '#c0392b' : '#16a085';

        exportModal.classList.add('active');
    }

    function closeExportModal() {
        exportModal.classList.remove('active');
        pendingExport = null;
    }

    document.getElementById('btnExportPdf')?.addEventListener('click', () => openExportModal('pdf'));
    document.getElementById('btnExportExcel')?.addEventListener('click', () => openExportModal('excel'));

    btnCancel?.addEventListener('click', closeExportModal);
    exportModal?.addEventListener('click', e => { if (e.target === exportModal) closeExportModal(); });
    document.addEventListener('keydown', e => { if (e.key === 'Escape') closeExportModal(); });

    /* ================================================================
       EXPORT BENERAN — PDF via jsPDF & Excel via SheetJS
       ================================================================ */
    function getTableData() {
        const rows = [];
        document.querySelectorAll('#lapTbody tr').forEach(tr => {
            const cells = tr.querySelectorAll('td');
            rows.push([
                cells[0]?.textContent.trim(),
                (cells[1]?.querySelector('.lap-book-judul')?.textContent.trim() || '') + ' – ' + (cells[1]?.querySelector('.lap-book-meta')?.textContent.trim() || ''),
                cells[2]?.textContent.trim(),
                cells[3]?.textContent.trim(),
                cells[4]?.textContent.trim(),
            ]);
        });
        return rows;
    }

    function doExportPdf() {
        try {
            const { jsPDF } = window.jspdf;
            if (!jsPDF) throw new Error('jsPDF not loaded');
            const doc = new jsPDF();
            const jenis = jenisLaporan.options[jenisLaporan.selectedIndex].text;
            const period = periodLabel.textContent;

            doc.setFont('helvetica', 'bold');
            doc.setFontSize(16);
            doc.text('Laporan Perpustakaan SMAIT Al-Uswah', 14, 20);
            doc.setFont('helvetica', 'normal');
            doc.setFontSize(10);
            doc.text(`Jenis: ${jenis} | Periode: ${period}`, 14, 28);

            doc.autoTable({
                head: [['No', 'Kategori / Judul Buku', 'Jumlah Pinjam', 'Ketersediaan', 'Status Trend']],
                body: getTableData(),
                startY: 36,
                styles: { fontSize: 9 },
                headStyles: { fillColor: [45, 112, 118] },
            });

            doc.save(`laporan-perpustakaan-${Date.now()}.pdf`);
            showToast('PDF berhasil diunduh!', '#c0392b');
        } catch (err) {
            showToast('Gagal membuat PDF. Coba lagi.');
        }
    }

    function doExportExcel() {
        try {
            if (!window.XLSX) throw new Error('SheetJS not loaded');
            const jenis = jenisLaporan.options[jenisLaporan.selectedIndex].text;
            const period = periodLabel.textContent;
            const header = ['No', 'Kategori / Judul Buku', 'Jumlah Pinjam', 'Ketersediaan', 'Status Trend'];
            const data = [
                [`Laporan Perpustakaan SMAIT Al-Uswah`],
                [`Jenis: ${jenis} | Periode: ${period}`],
                [],
                header,
                ...getTableData(),
            ];
            const ws = XLSX.utils.aoa_to_sheet(data);
            const wb = XLSX.utils.book_new();
            XLSX.utils.book_append_sheet(wb, ws, 'Laporan');
            XLSX.writeFile(wb, `laporan-perpustakaan-${Date.now()}.xlsx`);
            showToast('Excel berhasil diunduh!', '#16a085');
        } catch (err) {
            showToast('Gagal membuat Excel. Coba lagi.');
        }
    }

    btnConfirm?.addEventListener('click', function () {
        closeExportModal();
        if (pendingExport === 'pdf') doExportPdf();
        else if (pendingExport === 'excel') doExportExcel();
    });
});