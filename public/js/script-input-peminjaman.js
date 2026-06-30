/**
 * script-input-peminjaman.js
 * Perpustakaan SMAIT Al-Uswah
 */

'use strict';

/* ============================================================
   DATA DUMMY
   ============================================================ */
const daftarAnggota = [
    { id: '1', nis: '20210045', nama: 'Ahmad Fathoni',     kelas: 'XI-MIPA 1',  email: 'ahmad.f@uswah.sch.id',  inisial: 'AF', avatarClass: 'av-teal' },
    { id: '2', nis: '19880412', nama: 'Siti Aminah, M.Pd', kelas: 'Guru',        email: 'siti.aminah@uswah.sch.id', inisial: 'SA', avatarClass: 'av-orange' },
    { id: '3', nis: '20220192', nama: 'Rara Anindia',      kelas: 'X-IPS 3',    email: 'rara.an@uswah.sch.id',  inisial: 'RA', avatarClass: 'av-purple' },
    { id: '4', nis: '20230087', nama: 'Budi Santoso',      kelas: 'XII-MIPA 1', email: 'budi.s@uswah.sch.id',   inisial: 'BS', avatarClass: 'av-teal' },
    { id: '5', nis: '20210156', nama: 'Citra Lestari',     kelas: 'XI-IPS 1',   email: 'citra.l@uswah.sch.id',  inisial: 'CL', avatarClass: 'av-mint' },
    { id: '6', nis: '20241001', nama: 'Nadia Rahma',       kelas: 'X-IPS 3',    email: 'nadia.r@uswah.sch.id',  inisial: 'NR', avatarClass: 'av-orange' },
];

const daftarBuku = [
    { id: '1', judul: 'Laskar Pelangi',        penulis: 'Andrea Hirata',              isbn: '979-3062-79-7',    stok: 8, cover: 'Laskar_pelangi_sampul.jpg' },
    { id: '2', judul: 'Dunia Sophie',           penulis: 'Jostein Gaarder',            isbn: '978-602-441-020-9', stok: 5, cover: 'dunia-sophie-sampul.jpg' },
    { id: '3', judul: 'Sejarah Peradaban Islam',penulis: 'Prof. Dr. Badri Yatim, M.A.',isbn: '979-421-337-3',    stok: 2, cover: 'sejarah-peradaban-silam-sampul.png' },
    { id: '4', judul: 'The Things You Can See Only When You Slow Down', penulis: 'Haemin Sunim', isbn: '978-602-481-365-9', stok: 0, cover: 'slow-down-sampul.jpg' },
];

/* ============================================================
   STATE
   ============================================================ */
let selectedAnggota = null;
let selectedBuku    = []; // [{...buku}]
let step            = 1;

/* ============================================================
   HELPERS
   ============================================================ */
function showToast(msg, color) {
    const t = document.getElementById('toast');
    if (!t) return;
    t.textContent = msg; t.style.background = color || 'var(--primary)';
    t.classList.add('show'); clearTimeout(t._x);
    t._x = setTimeout(() => t.classList.remove('show'), 2800);
}

function openModal(id) { document.getElementById(id)?.classList.add('active'); }
function closeModal(id) { document.getElementById(id)?.classList.remove('active'); }

function setErr(id, msg) {
    document.getElementById(id)?.closest('.ip-form-group')?.classList.add('is-error');
    const e = document.getElementById('err-' + id);
    if (e) e.textContent = msg;
}
function clearErr(id) {
    document.getElementById(id)?.closest('.ip-form-group')?.classList.remove('is-error');
    const e = document.getElementById('err-' + id);
    if (e) e.textContent = '';
}

/* ============================================================
   STEPPER
   ============================================================ */
function setStep(n) {
    step = n;
    for (let i = 1; i <= 3; i++) {
        const el   = document.getElementById('step-ind-' + i);
        const line = document.getElementById('line-' + i);
        if (!el) continue;
        el.classList.remove('active', 'done');
        if (i < n)  { el.classList.add('done'); if (line) line.classList.add('done'); }
        if (i === n){ el.classList.add('active'); }
        if (i > n && line) line.classList.remove('done');
    }
}

/* ============================================================
   RINGKASAN — update real-time
   ============================================================ */
function updateRingkasan() {
    const totalBuku = selectedBuku.length;
    document.getElementById('ringTotalBuku').textContent = totalBuku + ' Eksemplar';

    const tglPinjam = document.getElementById('tglPinjam')?.value;
    const tglTempo  = document.getElementById('tglTempo')?.value;

    if (tglPinjam && tglTempo) {
        const dp = new Date(tglPinjam), dt = new Date(tglTempo);
        const hari = Math.round((dt - dp) / (1000 * 60 * 60 * 24));
        document.getElementById('ringLamaPinjam').textContent = (hari > 0 ? hari : '–') + ' Hari';

        const fmt = d => d.toLocaleDateString('id-ID', { day:'2-digit', month:'short', year:'numeric' });
        document.getElementById('ringJatuhTempo').textContent = tglTempo ? fmt(dt) : '–';
    } else {
        document.getElementById('ringLamaPinjam').textContent = '– Hari';
        document.getElementById('ringJatuhTempo').textContent = '–';
    }

    const badge = document.getElementById('ringStatus');
    const isReady = selectedAnggota && selectedBuku.length > 0 && tglPinjam && tglTempo;
    if (badge) {
        badge.textContent = isReady ? 'SIAP' : 'DRAFT';
        badge.className = 'ip-ring-badge' + (isReady ? ' ready' : '');
    }

    // Update stepper berdasarkan progress
    if (!selectedAnggota)              setStep(1);
    else if (selectedBuku.length === 0) setStep(2);
    else                                setStep(3);
}

/* ============================================================
   SEARCH ANGGOTA
   ============================================================ */
document.addEventListener('DOMContentLoaded', function () {

    const searchAnggota   = document.getElementById('searchAnggota');
    const anggotaDropdown = document.getElementById('anggotaDropdown');
    const anggotaSelected = document.getElementById('anggotaSelected');

    function renderDropdown(q) {
        const hasil = daftarAnggota.filter(a =>
            a.nama.toLowerCase().includes(q.toLowerCase()) ||
            a.nis.includes(q)
        );

        if (hasil.length === 0 || !q) { anggotaDropdown.classList.remove('show'); return; }

        anggotaDropdown.innerHTML = hasil.map(a => `
            <div class="ip-dropdown-item" data-id="${a.id}">
                <div class="ip-dropdown-avatar ${a.avatarClass}">${a.inisial}</div>
                <div class="ip-dropdown-info">
                    <span class="ip-dropdown-nama">${a.nama}</span>
                    <span class="ip-dropdown-meta">NIS: ${a.nis} · ${a.kelas}</span>
                </div>
            </div>`).join('');

        anggotaDropdown.classList.add('show');

        anggotaDropdown.querySelectorAll('.ip-dropdown-item').forEach(item => {
            item.addEventListener('mousedown', e => { e.preventDefault();
                const anggota = daftarAnggota.find(a => a.id === item.dataset.id);
                if (!anggota) return;
                selectAnggota(anggota);
            });
        });
    }

    function selectAnggota(anggota) {
        selectedAnggota = anggota;
        searchAnggota.value = '';
        anggotaDropdown.classList.remove('show');

        document.getElementById('selAvatar').textContent  = anggota.inisial;
        document.getElementById('selAvatar').className    = 'ip-anggota-avatar ' + anggota.avatarClass;
        document.getElementById('selNama').textContent    = anggota.nama;
        document.getElementById('selMeta').textContent    = 'NIS: ' + anggota.nis + ' · ' + anggota.kelas;
        document.getElementById('selEmail').textContent   = anggota.email;

        anggotaSelected?.classList.remove('hidden');
        searchAnggota.classList.add('hidden');

        const errEl = document.getElementById('err-anggota');
        if (errEl) errEl.textContent = '';

        updateRingkasan();
    }

    searchAnggota?.addEventListener('input', () => renderDropdown(searchAnggota.value));
    searchAnggota?.addEventListener('focus', () => { if (searchAnggota.value) renderDropdown(searchAnggota.value); });

    document.addEventListener('click', e => {
        if (!e.target.closest('.ip-anggota-search-wrap')) anggotaDropdown.classList.remove('show');
    });

    document.getElementById('btnClearAnggota')?.addEventListener('click', () => {
        selectedAnggota = null;
        anggotaSelected?.classList.add('hidden');
        searchAnggota?.classList.remove('hidden');
        searchAnggota.value = '';
        updateRingkasan();
    });

    /* ============================================================
       CARI & TAMBAH BUKU
       ============================================================ */
    const searchBukuInput = document.getElementById('searchBuku');
    const bukuSaran       = document.getElementById('bukuSaran');
    const bukuList        = document.getElementById('bukuList');

    function stokClass(stok) {
        if (stok === 0) return 'stok-habis';
        if (stok <= 2)  return 'stok-warn';
        return 'stok-ok';
    }
    function stokLabel(stok) {
        if (stok === 0) return 'Habis';
        return 'Tersedia: ' + stok;
    }

    function renderSaran(q) {
        const sudahDipilih = selectedBuku.map(b => b.id);
        const hasil = daftarBuku.filter(b =>
            b.judul.toLowerCase().includes(q.toLowerCase()) ||
            b.penulis.toLowerCase().includes(q.toLowerCase()) ||
            b.isbn.includes(q)
        );

        if (hasil.length === 0) {
            bukuSaran.innerHTML = '<div class="ip-saran-item" style="color:var(--text);opacity:.5;cursor:default;">Buku tidak ditemukan.</div>';
        } else {
            bukuSaran.innerHTML = hasil.map(b => {
                const sudah = sudahDipilih.includes(b.id);
                return `<div class="ip-saran-item ${sudah ? 'disabled' : ''}" data-id="${b.id}">
                    <img src="/assets/${b.cover}" alt="" class="ip-saran-cover" onerror="this.style.display='none'">
                    <div class="ip-saran-info">
                        <span class="ip-saran-judul">${b.judul}</span>
                        <span class="ip-saran-sub">${b.penulis} · ISBN ${b.isbn}</span>
                    </div>
                    <span class="ip-saran-stok ${stokClass(b.stok)}">${stokLabel(b.stok)}</span>
                </div>`;
            }).join('');
        }

        bukuSaran.classList.remove('hidden');

        bukuSaran.querySelectorAll('.ip-saran-item:not(.disabled)').forEach(item => {
            item.addEventListener('mousedown', e => { e.preventDefault();
                const buku = daftarBuku.find(b => b.id === item.dataset.id);
                if (!buku) return;
                if (buku.stok === 0) { showToast('Stok buku habis!', '#c0392b'); return; }
                addBuku(buku);
                bukuSaran.classList.add('hidden');
                searchBukuInput.value = '';
            });
        });
    }

    function addBuku(buku) {
        if (selectedBuku.find(b => b.id === buku.id)) {
            showToast('Buku sudah ada dalam daftar.'); return;
        }
        selectedBuku.push(buku);
        renderBukuList();
        updateRingkasan();
        showToast('"' + buku.judul + '" ditambahkan.');
    }

    function removeBuku(id) {
        selectedBuku = selectedBuku.filter(b => b.id !== id);
        renderBukuList();
        updateRingkasan();
    }

    function renderBukuList() {
        const head = document.getElementById('bukuTerpilihHead');
        const label= document.getElementById('bukuTerpilihLabel');

        if (selectedBuku.length === 0) {
            bukuList.innerHTML = '';
            head?.classList.add('hidden');
            return;
        }

        head?.classList.remove('hidden');
        if (label) label.textContent = 'Buku Terpilih (' + selectedBuku.length + ')';

        bukuList.innerHTML = selectedBuku.map(b => `
            <li class="ip-buku-item">
                <img src="/assets/${b.cover}" alt="" class="ip-buku-item-cover" onerror="this.style.display='none'">
                <div class="ip-buku-item-info">
                    <span class="ip-buku-item-judul">${b.judul}</span>
                    <span class="ip-buku-item-penulis">${b.penulis}</span>
                </div>
                <span class="ip-buku-item-stok ${stokClass(b.stok)}">${stokLabel(b.stok)}</span>
                <button type="button" class="btn-ip-hapus-buku" data-id="${b.id}" title="Hapus">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                </button>
            </li>`).join('');

        bukuList.querySelectorAll('.btn-ip-hapus-buku').forEach(btn => {
            btn.addEventListener('click', () => removeBuku(btn.dataset.id));
        });
    }

    // Tombol cari → trigger saran
    document.getElementById('btnCariSaran')?.addEventListener('click', () => {
        const q = searchBukuInput?.value.trim();
        if (!q) { showToast('Ketik judul, pengarang, atau ISBN terlebih dahulu.'); return; }
        renderSaran(q);
    });

    // Enter juga trigger
    searchBukuInput?.addEventListener('keydown', e => {
        if (e.key === 'Enter') {
            e.preventDefault();
            document.getElementById('btnCariSaran')?.click();
        }
    });

    // Tutup saran klik luar dengan delay agar mousedown item selesai duluan
    document.addEventListener('click', e => {
        if (!e.target.closest('.ip-buku-search-row') && !e.target.closest('.ip-buku-saran')) {
            bukuSaran?.classList.add('hidden');
        }
    });

    /* ============================================================
       TANGGAL — update ringkasan real-time + auto-set tempo
       ============================================================ */
    const tglPinjamInput = document.getElementById('tglPinjam');
    const tglTempoInput  = document.getElementById('tglTempo');

    // Set default hari ini
    const today = new Date().toISOString().split('T')[0];
    if (tglPinjamInput) tglPinjamInput.value = today;

    // Auto-set tempo 7 hari dari pinjam
    function autoSetTempo() {
        const val = tglPinjamInput?.value;
        if (!val) return;
        const d = new Date(val);
        d.setDate(d.getDate() + 7);
        if (tglTempoInput && !tglTempoInput.value) {
            tglTempoInput.value = d.toISOString().split('T')[0];
        }
        updateRingkasan();
    }

    tglPinjamInput?.addEventListener('change', () => { autoSetTempo(); clearErr('tglPinjam'); });
    tglTempoInput?.addEventListener('change',  () => { updateRingkasan(); clearErr('tglTempo'); });

    autoSetTempo();

    /* ============================================================
       VALIDASI & SIMPAN
       ============================================================ */
    document.getElementById('btnSimpan')?.addEventListener('click', () => {
        let ok = true;

        // Clear errors
        ['anggota','buku','tglPinjam','tglTempo'].forEach(id => clearErr(id));

        if (!selectedAnggota) {
            const e = document.getElementById('err-anggota');
            if (e) e.textContent = 'Pilih anggota terlebih dahulu.';
            ok = false;
        }

        if (selectedBuku.length === 0) {
            const e = document.getElementById('err-buku');
            if (e) e.textContent = 'Tambahkan minimal 1 buku.';
            ok = false;
        }

        const tglP = tglPinjamInput?.value;
        const tglT = tglTempoInput?.value;

        if (!tglP) { setErr('tglPinjam', 'Tanggal pinjam wajib diisi.'); ok = false; }
        if (!tglT) { setErr('tglTempo',  'Tanggal jatuh tempo wajib diisi.'); ok = false; }
        else if (tglP && tglT && tglT <= tglP) {
            setErr('tglTempo', 'Jatuh tempo harus setelah tanggal pinjam.'); ok = false;
        }

        if (!ok) {
            document.querySelector('.ip-panel.is-error, [id^="err-"]')
                ?.scrollIntoView?.({ behavior: 'smooth', block: 'center' });
            return;
        }

        // Isi modal sukses
        document.getElementById('modalSuksesNama').textContent = selectedAnggota.nama;
        document.getElementById('modalSuksesBuku').textContent = selectedBuku.length;

        const fmtTgl = v => new Date(v).toLocaleDateString('id-ID', {day:'2-digit',month:'short',year:'numeric'});
        const detail = document.getElementById('modalSuksesDetail');
        if (detail) detail.innerHTML =
            `<span>Tanggal Pinjam: <strong>${fmtTgl(tglP)}</strong></span>` +
            `<span>Jatuh Tempo: <strong>${fmtTgl(tglT)}</strong></span>` +
            selectedBuku.map(b => `<span>· ${b.judul}</span>`).join('');

        openModal('ipModalSukses');
    });

    /* ── Modal Sukses: OK → riwayat-transaksi ── */
    document.getElementById('btnModalOk')?.addEventListener('click', () => {
        const url = document.querySelector('a[href*="riwayat-transaksi"]')?.href || '/admin/riwayat-transaksi';
        window.location.href = url;
    });

    /* ── Modal Sukses: Input Baru → reset form ── */
    document.getElementById('btnModalBaru')?.addEventListener('click', () => {
        closeModal('ipModalSukses');
        resetForm();
    });

    /* ── Batal & Bersihkan ── */
    document.getElementById('btnBatal')?.addEventListener('click', () => openModal('ipModalBatal'));
    document.getElementById('btnKonfirmBatal')?.addEventListener('click', () => {
        closeModal('ipModalBatal'); resetForm();
    });
    document.getElementById('btnBatalTutup')?.addEventListener('click', () => closeModal('ipModalBatal'));

    /* ── Escape menutup modal ── */
    document.addEventListener('keydown', e => {
        if (e.key === 'Escape') { closeModal('ipModalSukses'); closeModal('ipModalBatal'); }
    });

    document.getElementById('ipModalSukses')?.addEventListener('click', e => {
        if (e.target === document.getElementById('ipModalSukses')) closeModal('ipModalSukses');
    });
    document.getElementById('ipModalBatal')?.addEventListener('click', e => {
        if (e.target === document.getElementById('ipModalBatal')) closeModal('ipModalBatal');
    });

    /* ============================================================
       RESET FORM
       ============================================================ */
    function resetForm() {
        selectedAnggota = null;
        selectedBuku    = [];

        // Anggota
        document.getElementById('anggotaSelected')?.classList.add('hidden');
        const sa = document.getElementById('searchAnggota');
        if (sa) { sa.value = ''; sa.classList.remove('hidden'); }

        // Buku
        renderBukuList();
        bukuSaran?.classList.add('hidden');
        if (searchBukuInput) searchBukuInput.value = '';

        // Tanggal
        if (tglPinjamInput) tglPinjamInput.value = today;
        if (tglTempoInput)  tglTempoInput.value  = '';
        if (document.getElementById('catatan')) document.getElementById('catatan').value = '';

        // Errors
        ['anggota','buku','tglPinjam','tglTempo'].forEach(id => clearErr(id));

        autoSetTempo();
        updateRingkasan();
        setStep(1);
        showToast('Form berhasil dibersihkan.');
    }

    /* Init */
    updateRingkasan();
});