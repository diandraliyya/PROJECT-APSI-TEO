/**
 * script-dashboard-admin.js
 * Perpustakaan SMAIT Al-Uswah
 */

'use strict';

document.addEventListener('DOMContentLoaded', function () {

    /* ── Active nav link ── */
    document.querySelectorAll('.nav-link').forEach(link => {
        if (link.getAttribute('href') === window.location.pathname) link.classList.add('active');
    });

    /* ── Animasi trend bar ── */
    const trendBars = document.querySelectorAll('.trend-bar');
    trendBars.forEach(bar => {
        const target = bar.style.getPropertyValue('--h');
        bar.style.height = '0%';
        requestAnimationFrame(() => {
            setTimeout(() => { bar.style.height = target; }, 150);
        });
    });

    /* ── Animasi popular bar ── */
    document.querySelectorAll('.popular-list .popular-bar-fill').forEach(fill => {
        const target = fill.style.width;
        fill.style.width = '0%';
        requestAnimationFrame(() => {
            setTimeout(() => { fill.style.width = target; }, 250);
        });
    });

    /* ============================================================
       MODAL BUKU POPULER
       ============================================================ */
    const btnPopuler  = document.getElementById('btnLihatPopuler');
    const popularModal = document.getElementById('popularModal');
    const popularClose = document.getElementById('popularModalClose');

    function openPopular() { popularModal?.classList.add('active'); }
    function closePopular() { popularModal?.classList.remove('active'); }

    btnPopuler?.addEventListener('click', openPopular);
    popularClose?.addEventListener('click', closePopular);
    popularModal?.addEventListener('click', e => { if (e.target === popularModal) closePopular(); });
    document.addEventListener('keydown', e => { if (e.key === 'Escape') closePopular(); });

    /* ============================================================
       SEARCH DENDA (filter tabel)
       ============================================================ */
    const dendaSearch = document.getElementById('dendaSearch');
    const dendaRows = Array.from(document.querySelectorAll('.denda-table tbody tr'));

    dendaSearch?.addEventListener('input', function () {
        const q = this.value.trim().toLowerCase();
        dendaRows.forEach(row => {
            const name = row.querySelector('.td-name')?.textContent.toLowerCase() || '';
            row.style.display = (!q || name.includes(q)) ? '' : 'none';
        });
    });

    /* ============================================================
       DROPDOWN TAHUN (grafik tren)
       ============================================================ */
    const yearBtn   = document.getElementById('yearBtn');
    const yearMenu  = document.getElementById('yearMenu');
    const yearLabel = document.getElementById('yearLabel');
    const yearOpts  = document.querySelectorAll('.year-opt');

    // Data tinggi bar per tahun (6 bulan terakhir)
    const yearData = {
        '2026': [38, 58, 48, 78, 62, 100],
        '2025': [50, 42, 65, 55, 80, 70],
        '2024': [30, 45, 40, 60, 52, 68],
    };

    yearBtn?.addEventListener('click', e => {
        e.stopPropagation();
        yearMenu?.classList.toggle('active');
    });

    document.addEventListener('click', () => yearMenu?.classList.remove('active'));

    yearOpts.forEach(opt => {
        opt.addEventListener('click', () => {
            const year = opt.dataset.year;

            yearOpts.forEach(o => o.classList.remove('active'));
            opt.classList.add('active');
            if (yearLabel) yearLabel.textContent = 'Tahun ' + year;
            yearMenu?.classList.remove('active');

            // Update tinggi bar
            const heights = yearData[year] || yearData['2026'];
            document.querySelectorAll('.trend-bar').forEach((bar, i) => {
                bar.style.height = heights[i] + '%';
            });
        });
    });

});