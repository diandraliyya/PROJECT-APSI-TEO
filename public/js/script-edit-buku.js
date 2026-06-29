/**
 * script-edit-buku.js
 * Perpustakaan SMAIT Al-Uswah
 */

'use strict';

const KELOLA_URL = document.querySelector('a[href*="kelola-buku"]')?.href || '/admin/kelola-buku';

function showErr(id, msg) {
    document.getElementById(id)?.closest('.eb-form-group')?.classList.add('is-error');
    const el = document.getElementById('err-' + id);
    if (el) el.textContent = msg;
}

function clearErr(id) {
    document.getElementById(id)?.closest('.eb-form-group')?.classList.remove('is-error');
    const el = document.getElementById('err-' + id);
    if (el) el.textContent = '';
}

function openModal(id) { document.getElementById(id)?.classList.add('active'); }
function closeModal(id) { document.getElementById(id)?.classList.remove('active'); }

document.addEventListener('DOMContentLoaded', function () {

    /* ── Active nav ── */
    document.querySelectorAll('.nav-link').forEach(l => {
        if (l.getAttribute('href') === window.location.pathname) l.classList.add('active');
    });

    /* ============================================================
       GANTI SAMPUL — klik cover atau tombol
       ============================================================ */
    const coverInput = document.getElementById('ebCoverInput');
    const coverImg   = document.getElementById('ebCoverImg');

    function triggerCover() { coverInput?.click(); }

    document.getElementById('ebCoverWrap')?.addEventListener('click', triggerCover);
    document.getElementById('btnGantiSampul')?.addEventListener('click', triggerCover);

    coverInput?.addEventListener('change', function () {
        const file = this.files?.[0];
        if (!file) return;
        if (!file.type.startsWith('image/')) { alert('File harus berupa gambar.'); return; }
        if (file.size > 2 * 1024 * 1024) { alert('Ukuran maksimal 2 MB.'); return; }
        const reader = new FileReader();
        reader.onload = e => { if (coverImg) coverImg.src = e.target.result; };
        reader.readAsDataURL(file);
    });

    /* ============================================================
       FORM VALIDASI — Simpan Perubahan
       ============================================================ */
    const fields = ['judul','isbn','pengarang','penerbit','rak','stok'];

    fields.forEach(id => {
        document.getElementById(id)?.addEventListener('input',  () => clearErr(id));
        document.getElementById(id)?.addEventListener('change', () => clearErr(id));
    });

    document.getElementById('editBukuForm')?.addEventListener('submit', function (e) {
        e.preventDefault();
        let ok = true;
        const v = id => (document.getElementById(id)?.value || '').trim();

        fields.forEach(id => clearErr(id));

        if (!v('judul'))     { showErr('judul',    'Judul buku wajib diisi.'); ok = false; }
        if (!v('isbn'))      { showErr('isbn',      'ISBN wajib diisi.'); ok = false; }
        if (!v('pengarang')) { showErr('pengarang', 'Pengarang wajib diisi.'); ok = false; }
        if (!v('penerbit'))  { showErr('penerbit',  'Penerbit wajib diisi.'); ok = false; }
        if (!v('rak'))       { showErr('rak',       'Rak wajib diisi.'); ok = false; }
        if (parseInt(v('stok')) < 0) { showErr('stok', 'Stok tidak boleh negatif.'); ok = false; }

        if (ok) {
            // Isi judul di modal
            const judulEl = document.getElementById('simpanJudul');
            if (judulEl) judulEl.textContent = '"' + v('judul') + '"';
            openModal('modalSimpan');
        } else {
            document.querySelector('.eb-form-group.is-error')
                ?.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
    });

    /* ── Modal simpan: OK → kelola-buku ── */
    document.getElementById('btnOkSimpan')?.addEventListener('click', () => {
        window.location.href = KELOLA_URL;
    });

    /* ============================================================
       HAPUS BUKU
       ============================================================ */
    document.getElementById('btnHapusBuku')?.addEventListener('click', () => openModal('modalHapus'));

    document.getElementById('btnBatalHapus')?.addEventListener('click', () => closeModal('modalHapus'));

    document.getElementById('btnKonfirmasiHapus')?.addEventListener('click', () => {
        closeModal('modalHapus');
        openModal('modalHapusSukses');
    });

    document.getElementById('btnOkHapus')?.addEventListener('click', () => {
        window.location.href = KELOLA_URL;
    });

    /* ── Tutup modal klik background / Escape ── */
    ['modalSimpan','modalHapus','modalHapusSukses'].forEach(id => {
        document.getElementById(id)?.addEventListener('click', e => {
            if (e.target === document.getElementById(id)) {
                // Hanya tutup modal hapus (bukan modal sukses yang harus klik OK)
                if (id === 'modalHapus') closeModal(id);
            }
        });
    });

    document.addEventListener('keydown', e => {
        if (e.key === 'Escape') closeModal('modalHapus');
    });
});