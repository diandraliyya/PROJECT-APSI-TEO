<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\Denda;
use App\Models\DetailTransaksi;
use App\Models\Laporan;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $jenis = $request->query('jenis', 'peminjaman');
        $tanggalMulai = $request->query('tanggal_mulai', now()->startOfMonth()->toDateString());
        $tanggalSelesai = $request->query('tanggal_selesai', now()->toDateString());

        $dataLaporan = $this->ambilDataLaporan($jenis, $tanggalMulai, $tanggalSelesai);

        $riwayatLaporan = Laporan::with('admin')
            ->latest()
            ->limit(10)
            ->get();

        return view('laporan', compact(
            'jenis',
            'tanggalMulai',
            'tanggalSelesai',
            'dataLaporan',
            'riwayatLaporan'
        ));
    }

    public function cetak(Request $request)
    {
        $validated = $request->validate([
            'jenis_laporan' => ['required', 'in:peminjaman,buku_terpopuler,anggota_aktif,denda'],
            'periode_mulai' => ['nullable', 'date'],
            'periode_selesai' => ['nullable', 'date', 'after_or_equal:periode_mulai'],
            'format_laporan' => ['required', 'in:pdf,excel'],
        ]);

        $periodeMulai = $validated['periode_mulai'] ?? now()->startOfMonth()->toDateString();
        $periodeSelesai = $validated['periode_selesai'] ?? now()->toDateString();

        Laporan::create([
            'admin_id' => session('auth_role') === 'admin' ? session('auth_id') : null,
            'jenis_laporan' => $validated['jenis_laporan'],
            'periode_mulai' => $periodeMulai,
            'periode_selesai' => $periodeSelesai,
            'format_laporan' => $validated['format_laporan'],
            'tanggal_cetak' => now(),
        ]);

        if ($validated['format_laporan'] === 'excel') {
            return $this->exportCsv(
                $validated['jenis_laporan'],
                $periodeMulai,
                $periodeSelesai
            );
        }

        return redirect()
            ->route('laporan', [
                'jenis' => $validated['jenis_laporan'],
                'tanggal_mulai' => $periodeMulai,
                'tanggal_selesai' => $periodeSelesai,
            ])
            ->with('success', 'Laporan berhasil dibuat. Untuk PDF, gunakan fitur print dari browser dulu.');
    }

    private function ambilDataLaporan(string $jenis, string $tanggalMulai, string $tanggalSelesai)
    {
        if ($jenis === 'peminjaman') {
            return Transaksi::with(['anggota', 'admin', 'detailTransaksis.buku'])
                ->whereBetween('tanggal_pinjam', [$tanggalMulai, $tanggalSelesai])
                ->latest()
                ->get();
        }

        if ($jenis === 'buku_terpopuler') {
            return DetailTransaksi::select('buku_id', DB::raw('SUM(jumlah) as total_dipinjam'))
                ->with('buku')
                ->whereHas('transaksi', function ($query) use ($tanggalMulai, $tanggalSelesai) {
                    $query->whereBetween('tanggal_pinjam', [$tanggalMulai, $tanggalSelesai]);
                })
                ->groupBy('buku_id')
                ->orderByDesc('total_dipinjam')
                ->get();
        }

        if ($jenis === 'anggota_aktif') {
            return Anggota::withCount('transaksis')
                ->where('status_anggota', 'aktif')
                ->orderBy('nama_anggota')
                ->get();
        }

        if ($jenis === 'denda') {
            return Denda::with(['anggota', 'detailTransaksi.buku', 'pembayaranDendas'])
                ->whereBetween('tanggal_denda', [$tanggalMulai, $tanggalSelesai])
                ->latest()
                ->get();
        }

        return collect();
    }

    private function exportCsv(string $jenis, string $tanggalMulai, string $tanggalSelesai)
    {
        $dataLaporan = $this->ambilDataLaporan($jenis, $tanggalMulai, $tanggalSelesai);

        $filename = 'laporan-' . $jenis . '-' . now()->format('YmdHis') . '.csv';

        return response()->streamDownload(function () use ($jenis, $dataLaporan) {
            $file = fopen('php://output', 'w');

            if ($jenis === 'peminjaman') {
                fputcsv($file, [
                    'Kode Transaksi',
                    'Nama Anggota',
                    'Tanggal Pinjam',
                    'Tanggal Jatuh Tempo',
                    'Tanggal Kembali',
                    'Status',
                    'Total Item',
                ]);

                foreach ($dataLaporan as $transaksi) {
                    fputcsv($file, [
                        $transaksi->kode_transaksi,
                        $transaksi->anggota->nama_anggota ?? '-',
                        $transaksi->tanggal_pinjam,
                        $transaksi->tanggal_jatuh_tempo,
                        $transaksi->tanggal_kembali ?? '-',
                        $transaksi->status_transaksi,
                        $transaksi->total_item,
                    ]);
                }
            }

            if ($jenis === 'buku_terpopuler') {
                fputcsv($file, [
                    'Judul Buku',
                    'Penulis',
                    'Total Dipinjam',
                ]);

                foreach ($dataLaporan as $item) {
                    fputcsv($file, [
                        $item->buku->judul_buku ?? '-',
                        $item->buku->penulis ?? '-',
                        $item->total_dipinjam,
                    ]);
                }
            }

            if ($jenis === 'anggota_aktif') {
                fputcsv($file, [
                    'No Anggota',
                    'NIS',
                    'Nama Anggota',
                    'Kelas',
                    'Email',
                    'Total Transaksi',
                    'Status',
                ]);

                foreach ($dataLaporan as $anggota) {
                    fputcsv($file, [
                        $anggota->no_anggota ?? '-',
                        $anggota->nis,
                        $anggota->nama_anggota,
                        $anggota->kelas ?? '-',
                        $anggota->email,
                        $anggota->transaksis_count,
                        $anggota->status_anggota,
                    ]);
                }
            }

            if ($jenis === 'denda') {
                fputcsv($file, [
                    'Nama Anggota',
                    'Judul Buku',
                    'Hari Terlambat',
                    'Tarif Per Hari',
                    'Total Denda',
                    'Status Denda',
                    'Tanggal Denda',
                ]);

                foreach ($dataLaporan as $denda) {
                    fputcsv($file, [
                        $denda->anggota->nama_anggota ?? '-',
                        $denda->detailTransaksi->buku->judul_buku ?? '-',
                        $denda->jumlah_hari_terlambat,
                        $denda->tarif_per_hari,
                        $denda->total_denda,
                        $denda->status_denda,
                        $denda->tanggal_denda,
                    ]);
                }
            }

            fclose($file);
        }, $filename, [
            'Content-Type' => 'text/csv',
        ]);
    }
}