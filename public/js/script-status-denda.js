/**
 * script-status-denda.js
 * Perpustakaan SMAIT Al-Uswah
 */

'use strict';

/* ── Active nav link ── */
(function () {
    const links = document.querySelectorAll('.nav-link');
    const current = window.location.pathname;
    links.forEach(link => {
        if (link.getAttribute('href') === current) link.classList.add('active');
    });
})();

/* ── Expand / collapse riwayat denda ── */
const btnRiwayat = document.getElementById('btnLihatRiwayat');
if (btnRiwayat) {
    const extras    = document.querySelectorAll('.rd-extra');
    const textShow  = btnRiwayat.querySelector('.btn-text-show');
    const textHide  = btnRiwayat.querySelector('.btn-text-hide');
    const chevron   = btnRiwayat.querySelector('.btn-chevron');
    let expanded = false;

    btnRiwayat.addEventListener('click', () => {
        expanded = !expanded;

        extras.forEach(item => item.classList.toggle('hidden', !expanded));

        if (textShow) textShow.classList.toggle('hidden', expanded);
        if (textHide) textHide.classList.toggle('hidden', !expanded);
        if (chevron) chevron.style.transform = expanded ? 'rotate(180deg)' : 'rotate(0deg)';
    });
}