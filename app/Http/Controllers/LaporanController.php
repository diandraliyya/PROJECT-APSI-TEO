<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\Buku;
use App\Models\Denda;
use App\Models\DetailTransaksi;
use App\Models\Laporan;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

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

        // ===== DATA CHART PER JENIS LAPORAN =====
        $chartData = $this->getChartData($jenis, $tanggalMulai, $tanggalSelesai);
        $chartTitle = $this->getChartTitle($jenis);
        $chartLabel = $this->getChartLabel($jenis);

        return view('laporan', compact(
            'jenis',
            'tanggalMulai',
            'tanggalSelesai',
            'dataLaporan',
            'riwayatLaporan',
            'chartData',
            'chartTitle',
            'chartLabel'
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

        // Simpan riwayat laporan
        Laporan::create([
            'admin_id' => session('auth_role') === 'admin' ? session('auth_id') : null,
            'jenis_laporan' => $validated['jenis_laporan'],
            'periode_mulai' => $periodeMulai,
            'periode_selesai' => $periodeSelesai,
            'format_laporan' => $validated['format_laporan'],
            'tanggal_cetak' => now(),
        ]);

        // Ambil data laporan
        $dataLaporan = $this->ambilDataLaporan($validated['jenis_laporan'], $periodeMulai, $periodeSelesai);

        // ===== EXPORT PDF =====
        if ($validated['format_laporan'] === 'pdf') {
            $pdf = Pdf::loadView('laporan-pdf', [
                'jenis' => $validated['jenis_laporan'],
                'periodeMulai' => $periodeMulai,
                'periodeSelesai' => $periodeSelesai,
                'data' => $dataLaporan,
            ]);

            $filename = 'laporan-' . $validated['jenis_laporan'] . '-' . date('Y-m-d') . '.pdf';

            return $pdf->download($filename);
        }

        // ===== EXPORT EXCEL (CSV) =====
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
            ->with('success', 'Laporan berhasil dibuat.');
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

    private function getChartData(string $jenis, string $tanggalMulai, string $tanggalSelesai)
    {
        $bulanList = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
        $data = [];
        $maxValue = 0;

        if ($jenis === 'peminjaman') {
            for ($i = 1; $i <= 12; $i++) {
                $total = Transaksi::whereYear('tanggal_pinjam', date('Y'))
                    ->whereMonth('tanggal_pinjam', $i)
                    ->count();
                $data[$i] = $total;
                if ($total > $maxValue) $maxValue = $total;
            }
        } elseif ($jenis === 'buku_terpopuler') {
            $topBuku = DetailTransaksi::select('buku_id', DB::raw('SUM(jumlah) as total_dipinjam'))
                ->with('buku')
                ->whereHas('transaksi', function ($query) use ($tanggalMulai, $tanggalSelesai) {
                    $query->whereBetween('tanggal_pinjam', [$tanggalMulai, $tanggalSelesai]);
                })
                ->groupBy('buku_id')
                ->orderByDesc('total_dipinjam')
                ->limit(5)
                ->get();

            foreach ($topBuku as $item) {
                $judul = $item->buku->judul_buku ?? 'Tidak Diketahui';
                if (strlen($judul) > 15) {
                    $judul = substr($judul, 0, 12) . '...';
                }
                $data[$judul] = $item->total_dipinjam;
                if ($item->total_dipinjam > $maxValue) $maxValue = $item->total_dipinjam;
            }
        } elseif ($jenis === 'anggota_aktif') {
            $topAnggota = Anggota::withCount('transaksis')
                ->where('status_anggota', 'aktif')
                ->orderByDesc('transaksis_count')
                ->limit(5)
                ->get();

            foreach ($topAnggota as $item) {
                $nama = $item->nama_anggota ?? 'Tidak Diketahui';
                if (strlen($nama) > 15) {
                    $nama = substr($nama, 0, 12) . '...';
                }
                $data[$nama] = $item->transaksis_count;
                if ($item->transaksis_count > $maxValue) $maxValue = $item->transaksis_count;
            }
        } elseif ($jenis === 'denda') {
            for ($i = 1; $i <= 12; $i++) {
                $total = Denda::whereYear('tanggal_denda', date('Y'))
                    ->whereMonth('tanggal_denda', $i)
                    ->sum('total_denda');
                $data[$i] = $total;
                if ($total > $maxValue) $maxValue = $total;
            }
        }

        $maxValue = $maxValue > 0 ? $maxValue : 1;

        return [
            'data' => $data,
            'maxValue' => $maxValue,
            'bulanList' => $bulanList,
        ];
    }

    private function getChartTitle(string $jenis): string
    {
        $titles = [
            'peminjaman' => 'Statistik Peminjaman ' . date('Y'),
            'buku_terpopuler' => 'Buku Terpopuler',
            'anggota_aktif' => 'Anggota Paling Aktif',
            'denda' => 'Statistik Denda ' . date('Y'),
        ];

        return $titles[$jenis] ?? 'Statistik';
    }

    private function getChartLabel(string $jenis): string
    {
        $labels = [
            'peminjaman' => 'Total Peminjaman',
            'buku_terpopuler' => 'Jumlah Dipinjam',
            'anggota_aktif' => 'Total Transaksi',
            'denda' => 'Total Denda (Rp)',
        ];

        return $labels[$jenis] ?? 'Total';
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