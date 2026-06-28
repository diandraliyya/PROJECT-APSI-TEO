/**
 * script-tambah-buku.js
 * Perpustakaan SMAIT Al-Uswah
 */

'use strict';

function showErr(id, msg) {
    document.getElementById(id)?.closest('.tb-form-group')?.classList.add('is-error');
    const err = document.getElementById('err-' + id);
    if (err) err.textContent = msg;
}

function clearErr(id) {
    document.getElementById(id)?.closest('.tb-form-group')?.classList.remove('is-error');
    const err = document.getElementById('err-' + id);
    if (err) err.textContent = '';
}

document.addEventListener('DOMContentLoaded', function () {

    /* ── Active nav ── */
    document.querySelectorAll('.nav-link').forEach(l => {
        if (l.getAttribute('href') === window.location.pathname) l.classList.add('active');
    });

    /* ============================================================
       COVER UPLOAD — klik, drag & drop, preview, hapus
       ============================================================ */
    const coverDrop        = document.getElementById('coverDrop');
    const coverInput       = document.getElementById('coverInput');
    const coverPreview     = document.getElementById('coverPreview');
    const coverImg         = document.getElementById('coverImg');
    const coverPlaceholder = document.getElementById('coverPlaceholder');
    const coverRemove      = document.getElementById('coverRemove');

    function showPreview(file) {
        if (!file.type.startsWith('image/')) {
            alert('File harus berupa gambar JPG/PNG.');
            return;
        }
        if (file.size > 2 * 1024 * 1024) {
            alert('Ukuran gambar maksimal 2 MB.');
            return;
        }
        const reader = new FileReader();
        reader.onload = e => {
            coverImg.src = e.target.result;
            coverPreview.classList.remove('hidden');
            coverPlaceholder.classList.add('hidden');
        };
        reader.readAsDataURL(file);
    }

    coverDrop?.addEventListener('click', e => {
        if (e.target === coverRemove || coverRemove?.contains(e.target)) return;
        coverInput?.click();
    });

    coverInput?.addEventListener('change', function () {
        if (this.files?.[0]) showPreview(this.files[0]);
    });

    coverDrop?.addEventListener('dragover', e => { e.preventDefault(); coverDrop.classList.add('drag-over'); });
    coverDrop?.addEventListener('dragleave', () => coverDrop.classList.remove('drag-over'));
    coverDrop?.addEventListener('drop', e => {
        e.preventDefault();
        coverDrop.classList.remove('drag-over');
        const file = e.dataTransfer?.files?.[0];
        if (file) showPreview(file);
    });

    coverRemove?.addEventListener('click', e => {
        e.stopPropagation();
        coverImg.src = '';
        coverPreview.classList.add('hidden');
        coverPlaceholder.classList.remove('hidden');
        if (coverInput) coverInput.value = '';
    });

    /* ============================================================
       MODAL SUKSES
       ============================================================ */
    const successModal = document.getElementById('successModal');
    const btnOkSukses  = document.getElementById('btnOkSukses');
    const kelolaBukuUrl = document.querySelector('a[href*="kelola-buku"]')?.href || '/admin/kelola-buku';

    function openSuccessModal() {
        if (successModal) successModal.classList.add('active');
    }

    btnOkSukses?.addEventListener('click', () => {
        window.location.href = kelolaBukuUrl;
    });

    /* ============================================================
       VALIDASI & SUBMIT
       ============================================================ */
    const fields = ['judul','isbn','tahun','pengarang','penerbit','kategori','stok','rak'];

    fields.forEach(id => {
        document.getElementById(id)?.addEventListener('input',  () => clearErr(id));
        document.getElementById(id)?.addEventListener('change', () => clearErr(id));
    });

    document.getElementById('tambahBukuForm')?.addEventListener('submit', function (e) {
        e.preventDefault();
        let ok = true;

        const v = id => (document.getElementById(id)?.value || '').trim();
        fields.forEach(id => clearErr(id));

        if (!v('judul'))     { showErr('judul',    'Judul buku wajib diisi.'); ok = false; }
        if (!v('isbn'))      { showErr('isbn',      'ISBN wajib diisi.'); ok = false; }
        if (!v('tahun'))     { showErr('tahun',     'Tahun terbit wajib diisi.'); ok = false; }
        else if (parseInt(v('tahun')) < 1900 || parseInt(v('tahun')) > 2099) {
            showErr('tahun', 'Tahun harus antara 1900–2099.'); ok = false;
        }
        if (!v('pengarang')) { showErr('pengarang', 'Nama pengarang wajib diisi.'); ok = false; }
        if (!v('penerbit'))  { showErr('penerbit',  'Nama penerbit wajib diisi.'); ok = false; }
        if (!v('kategori'))  { showErr('kategori',  'Pilih kategori buku.'); ok = false; }
        if (!v('stok') && v('stok') !== '0') { showErr('stok', 'Jumlah stok wajib diisi.'); ok = false; }
        else if (parseInt(v('stok')) < 0)    { showErr('stok', 'Stok tidak boleh negatif.'); ok = false; }
        if (!v('rak'))       { showErr('rak',       'Pilih rak penyimpanan.'); ok = false; }

        if (ok) {
            openSuccessModal();
            // form.submit(); // aktifkan saat tersambung backend
        } else {
            document.querySelector('.tb-form-group.is-error')
                ?.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
    });
});