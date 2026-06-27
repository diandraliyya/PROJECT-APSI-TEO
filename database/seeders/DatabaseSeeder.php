<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Anggota;
use App\Models\Buku;
use App\Models\Denda;
use App\Models\DetailTransaksi;
use App\Models\Kategori;
use App\Models\PembayaranDenda;
use App\Models\Rak;
use App\Models\Setting;
use App\Models\Transaksi;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $admin = Admin::updateOrCreate(
            ['username' => 'admin_al_uswah'],
            [
                'nama_admin' => 'Admin Perpustakaan SMAIT',
                'password' => Hash::make('admin12345'),
                'email' => 'library@smait-uswah.sch.id',
                'no_hp' => '081234567890',
                'status_admin' => 'aktif',
            ]
        );

        $kategoriFiksi = Kategori::updateOrCreate(
            ['nama_kategori' => 'Fiksi'],
            ['deskripsi' => 'Novel, cerpen, dan komik.']
        );

        $kategoriSejarah = Kategori::updateOrCreate(
            ['nama_kategori' => 'Sejarah'],
            ['deskripsi' => 'Buku sejarah dan peradaban.']
        );

        $kategoriSains = Kategori::updateOrCreate(
            ['nama_kategori' => 'Sains'],
            ['deskripsi' => 'Buku sains, teknologi, dan akademik.']
        );

        $kategoriAgama = Kategori::updateOrCreate(
            ['nama_kategori' => 'Agama'],
            ['deskripsi' => 'Buku agama, fiqih, dan akidah.']
        );

        $rakA = Rak::updateOrCreate(
            ['kode_rak' => 'A-204'],
            [
                'lokasi' => 'Lantai 1 Sayap Kanan',
                'deskripsi' => 'Rak koleksi sejarah dan agama.',
            ]
        );

        $rakS = Rak::updateOrCreate(
            ['kode_rak' => 'S-102'],
            [
                'lokasi' => 'Lantai 2 Mezzanine',
                'deskripsi' => 'Rak koleksi sains dan referensi.',
            ]
        );

        $rakF = Rak::updateOrCreate(
            ['kode_rak' => 'F-001'],
            [
                'lokasi' => 'Area baca utama',
                'deskripsi' => 'Rak koleksi fiksi populer.',
            ]
        );

        $buku1 = Buku::updateOrCreate(
            ['isbn' => '978-602-1234-56-7'],
            [
                'kategori_id' => $kategoriSejarah->id,
                'rak_id' => $rakA->id,
                'judul_buku' => 'Sejarah Peradaban Islam',
                'penulis' => 'Badri Yatim',
                'penerbit' => 'Pustaka Al-Uswah',
                'tahun_terbit' => 2023,
                'nomor_panggil' => '950.1 HAM h',
                'stok_total' => 12,
                'stok_tersedia' => 8,
                'status_buku' => 'tersedia',
                'sinopsis' => 'Buku ini membahas sejarah perkembangan peradaban Islam dari masa klasik hingga modern.',
                'cover' => null,
            ]
        );

        $buku2 = Buku::updateOrCreate(
            ['isbn' => '978-602-456-112'],
            [
                'kategori_id' => $kategoriSains->id,
                'rak_id' => $rakS->id,
                'judul_buku' => 'Fisika Quantum: Dasar Penemuan Modern',
                'penulis' => 'Dr. Suyanto',
                'penerbit' => 'Erlangga',
                'tahun_terbit' => 2024,
                'nomor_panggil' => '530 SUY f',
                'stok_total' => 5,
                'stok_tersedia' => 2,
                'status_buku' => 'stok_sedikit',
                'sinopsis' => 'Buku pengantar fisika quantum yang menjelaskan konsep dasar penemuan modern secara sederhana.',
                'cover' => null,
            ]
        );

        $buku3 = Buku::updateOrCreate(
            ['isbn' => '978-602-9876-54-3'],
            [
                'kategori_id' => $kategoriFiksi->id,
                'rak_id' => $rakF->id,
                'judul_buku' => 'Laskar Pelangi',
                'penulis' => 'Andrea Hirata',
                'penerbit' => 'Bentang Pustaka',
                'tahun_terbit' => 2022,
                'nomor_panggil' => '813 HIR l',
                'stok_total' => 10,
                'stok_tersedia' => 6,
                'status_buku' => 'tersedia',
                'sinopsis' => 'Novel inspiratif tentang perjuangan anak-anak Belitung dalam meraih pendidikan.',
                'cover' => null,
            ]
        );

        $buku4 = Buku::updateOrCreate(
            ['isbn' => '978-602-421-518-9'],
            [
                'kategori_id' => $kategoriFiksi->id,
                'rak_id' => $rakF->id,
                'judul_buku' => 'Filosofi Teras',
                'penulis' => 'Henry Manampiring',
                'penerbit' => 'Kompas',
                'tahun_terbit' => 2021,
                'nomor_panggil' => '100 HEN f',
                'stok_total' => 3,
                'stok_tersedia' => 2,
                'status_buku' => 'tersedia',
                'sinopsis' => 'Buku pengantar filsafat stoikisme untuk kehidupan sehari-hari.',
                'cover' => null,
            ]
        );

        $anggota1 = Anggota::updateOrCreate(
            ['nis' => '2024008125'],
            [
                'admin_id' => $admin->id,
                'no_anggota' => '2024.08.0125',
                'nama_anggota' => 'Adelia Putri Ramadhani',
                'kelas' => 'XII MIPA 1',
                'username' => 'adelia',
                'password' => Hash::make('anggota12345'),
                'email' => 'adelia.putri@email.com',
                'no_hp' => '081234567890',
                'alamat' => 'Jl. Ketintang Madya No. 81, Surabaya',
                'tanggal_daftar' => Carbon::parse('2024-08-01'),
                'status_pendaftaran' => 'disetujui',
                'status_anggota' => 'aktif',
            ]
        );

        $anggota2 = Anggota::updateOrCreate(
            ['nis' => '20210045'],
            [
                'admin_id' => $admin->id,
                'no_anggota' => '2024.01.0045',
                'nama_anggota' => 'Ahmad Fathoni',
                'kelas' => 'XI MIPA 1',
                'username' => 'ahmad',
                'password' => Hash::make('anggota12345'),
                'email' => 'ahmad.f@uswah.sch.id',
                'no_hp' => '081222333444',
                'alamat' => 'Surabaya',
                'tanggal_daftar' => Carbon::parse('2024-01-12'),
                'status_pendaftaran' => 'disetujui',
                'status_anggota' => 'aktif',
            ]
        );

        Setting::updateOrCreate(
            ['id' => 1],
            [
                'tarif_denda_per_hari' => 1000,
                'maksimal_hari_pinjam' => 7,
                'nama_perpustakaan' => 'SMAIT Al-Uswah Library',
                'email_perpustakaan' => 'library@smait-uswah.sch.id',
                'telepon_perpustakaan' => '0315931222',
                'alamat_perpustakaan' => 'Jl. Kejawan Putih Tambak No. 1, Surabaya',
            ]
        );

        $transaksi1 = Transaksi::updateOrCreate(
            ['kode_transaksi' => 'TRX-8819'],
            [
                'anggota_id' => $anggota1->id,
                'admin_id' => $admin->id,
                'tanggal_pinjam' => Carbon::parse('2024-10-05'),
                'tanggal_jatuh_tempo' => Carbon::parse('2024-10-12'),
                'tanggal_kembali' => null,
                'status_transaksi' => 'terlambat',
                'total_item' => 1,
                'catatan' => 'Peminjaman buku sains.',
            ]
        );

        $detail1 = DetailTransaksi::updateOrCreate(
            [
                'transaksi_id' => $transaksi1->id,
                'buku_id' => $buku2->id,
            ],
            [
                'jumlah' => 1,
                'status_item' => 'terlambat',
                'tanggal_kembali_item' => null,
            ]
        );

        $denda1 = Denda::updateOrCreate(
            ['detail_transaksi_id' => $detail1->id],
            [
                'anggota_id' => $anggota1->id,
                'jumlah_hari_terlambat' => 5,
                'tarif_per_hari' => 1000,
                'total_denda' => 5000,
                'status_denda' => 'belum_lunas',
                'tanggal_denda' => Carbon::parse('2024-10-17'),
            ]
        );

        $transaksi2 = Transaksi::updateOrCreate(
            ['kode_transaksi' => 'TRX-8821'],
            [
                'anggota_id' => $anggota2->id,
                'admin_id' => $admin->id,
                'tanggal_pinjam' => Carbon::parse('2024-10-12'),
                'tanggal_jatuh_tempo' => Carbon::parse('2024-10-19'),
                'tanggal_kembali' => Carbon::parse('2024-10-18'),
                'status_transaksi' => 'dikembalikan',
                'total_item' => 1,
                'catatan' => 'Sudah dikembalikan tepat waktu.',
            ]
        );

        DetailTransaksi::updateOrCreate(
            [
                'transaksi_id' => $transaksi2->id,
                'buku_id' => $buku3->id,
            ],
            [
                'jumlah' => 1,
                'status_item' => 'dikembalikan',
                'tanggal_kembali_item' => Carbon::parse('2024-10-18'),
            ]
        );

        PembayaranDenda::updateOrCreate(
            ['denda_id' => $denda1->id],
            [
                'admin_id' => $admin->id,
                'tanggal_pembayaran' => Carbon::parse('2024-10-20'),
                'nominal_bayar' => 0,
                'metode_pembayaran' => 'tunai',
                'status_validasi' => 'menunggu',
                'keterangan' => 'Belum dilakukan pembayaran.',
            ]
        );
    }
}