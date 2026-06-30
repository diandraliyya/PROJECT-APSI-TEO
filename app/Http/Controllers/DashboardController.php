<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\Buku;
use App\Models\Denda;
use App\Models\DetailTransaksi;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function admin()
    {
        $totalBuku = Buku::count();

        $totalStokTersedia = Buku::sum('stok_tersedia');

        $totalAnggotaAktif = Anggota::where('status_anggota', 'aktif')->count();

        $totalPendaftaranMenunggu = Anggota::where('status_pendaftaran', 'menunggu')->count();

        $totalPinjamHariIni = Transaksi::whereDate('tanggal_pinjam', Carbon::today())->count();

        $totalDipinjam = Transaksi::where('status_transaksi', 'dipinjam')->count();

        $totalTerlambat = Transaksi::where('status_transaksi', 'terlambat')->count();

        $totalBukuSedangDipinjam = DB::table('detail_transaksis')
            ->join('transaksis', 'detail_transaksis.transaksi_id', '=', 'transaksis.id')
            ->whereIn('transaksis.status_transaksi', ['dipinjam', 'terlambat'])
            ->whereIn('detail_transaksis.status_item', ['dipinjam', 'terlambat'])
            ->sum('detail_transaksis.jumlah');

        $totalDendaBelumLunas = Denda::where('status_denda', 'belum_lunas')
            ->sum('total_denda');

        $transaksiTerbaru = Transaksi::with(['anggota', 'detailTransaksis.buku'])
            ->orderByDesc('id')
            ->limit(5)
            ->get();

        $bukuStokSedikit = Buku::with(['kategori', 'rak'])
            ->where('stok_tersedia', '<=', 2)
            ->orderBy('stok_tersedia')
            ->limit(5)
            ->get();

        $bukuTerpopuler = DetailTransaksi::select('buku_id', DB::raw('SUM(jumlah) as total_dipinjam'))
            ->with('buku')
            ->groupBy('buku_id')
            ->orderByDesc('total_dipinjam')
            ->limit(5)
            ->get();

        $semuaBukuTerpopuler = DetailTransaksi::select('buku_id', DB::raw('SUM(jumlah) as total_dipinjam'))
            ->with('buku')
            ->groupBy('buku_id')
            ->orderByDesc('total_dipinjam')
            ->limit(10)
            ->get();

        $maxTotalPinjamBuku = max(1, (int) $semuaBukuTerpopuler->max('total_dipinjam'));

        $namaBulan = [
            1 => 'Jan',
            2 => 'Feb',
            3 => 'Mar',
            4 => 'Apr',
            5 => 'Mei',
            6 => 'Jun',
            7 => 'Jul',
            8 => 'Agst',
            9 => 'Sept',
            10 => 'Okt',
            11 => 'Nov',
            12 => 'Des',
        ];

        $trenPeminjaman = collect(range(5, 0))->map(function ($mundur) use ($namaBulan) {
            $tanggal = now()->startOfMonth()->subMonthsNoOverflow($mundur);

            $total = Transaksi::whereYear('tanggal_pinjam', $tanggal->year)
                ->whereMonth('tanggal_pinjam', $tanggal->month)
                ->count();

            return [
                'bulan' => $namaBulan[(int) $tanggal->month],
                'tahun' => $tanggal->year,
                'total' => $total,
            ];
        });

        $maxTrenPeminjaman = max(1, (int) $trenPeminjaman->max('total'));

        $kategoriRaw = DB::table('kategoris')
            ->leftJoin('bukus', 'kategoris.id', '=', 'bukus.kategori_id')
            ->select(
                'kategoris.id',
                'kategoris.nama_kategori',
                DB::raw('COUNT(bukus.id) as total_buku')
            )
            ->groupBy('kategoris.id', 'kategoris.nama_kategori')
            ->orderByDesc('total_buku')
            ->limit(3)
            ->get();

        $totalKategoriBuku = max(1, (int) $kategoriRaw->sum('total_buku'));

        $kategoriDistribusi = $kategoriRaw->map(function ($kategori) use ($totalKategoriBuku) {
            $kategori->persentase = round(($kategori->total_buku / $totalKategoriBuku) * 100);
            return $kategori;
        });

        $anggotaTeraktif = Anggota::query()
            ->select('anggotas.*')
            ->selectSub(function ($query) {
                $query->from('transaksis')
                    ->selectRaw('COUNT(*)')
                    ->whereColumn('transaksis.anggota_id', 'anggotas.id');
            }, 'total_pinjam')
            ->orderByDesc('total_pinjam')
            ->limit(3)
            ->get();

        $dendaAktif = Denda::with(['anggota', 'detailTransaksi.buku'])
            ->where('status_denda', 'belum_lunas')
            ->orderByDesc('id')
            ->limit(5)
            ->get();

        return view('dashboard-admin', compact(
            'totalBuku',
            'totalStokTersedia',
            'totalAnggotaAktif',
            'totalPendaftaranMenunggu',
            'totalPinjamHariIni',
            'totalDipinjam',
            'totalTerlambat',
            'totalBukuSedangDipinjam',
            'totalDendaBelumLunas',
            'transaksiTerbaru',
            'bukuStokSedikit',
            'bukuTerpopuler',
            'semuaBukuTerpopuler',
            'maxTotalPinjamBuku',
            'trenPeminjaman',
            'maxTrenPeminjaman',
            'kategoriDistribusi',
            'anggotaTeraktif',
            'dendaAktif'
        ));
    }

    public function anggota(Request $request)
    {
        $anggotaId = session('auth_role') === 'anggota'
            ? session('auth_id')
            : $request->query('anggota_id');

        $anggota = $anggotaId
            ? Anggota::find($anggotaId)
            : null;

        if (!$anggota) {
            return view('dashboard-anggota', [
                'anggota' => null,
                'totalSedangDipinjam' => 0,
                'totalRiwayatPeminjaman' => 0,
                'totalDendaBelumLunas' => 0,
                'pinjamanAktif' => collect(),
                'dendaBelumLunas' => collect(),
                'notifikasi' => collect(),
                'rekomendasiBuku' => collect(),
                'statistikBulanan' => collect(),
                'maxStatistikBulanan' => 1,
                'totalBukuTahunIni' => 0,
                'sisaHariTerdekat' => null,
                'peringkatMembaca' => 'Pembaca Baru',
                'progressPeringkat' => 0,
                'targetPeringkat' => 5,
                'sisaTargetPeringkat' => 5,
            ]);
        }

        $pinjamanAktif = DetailTransaksi::with(['buku', 'transaksi'])
            ->whereIn('status_item', ['dipinjam', 'terlambat'])
            ->whereHas('transaksi', function ($query) use ($anggota) {
                $query->where('anggota_id', $anggota->id)
                    ->whereIn('status_transaksi', ['dipinjam', 'terlambat']);
            })
            ->orderByDesc('id')
            ->get();

        $totalSedangDipinjam = $pinjamanAktif->sum('jumlah');

        $totalRiwayatPeminjaman = DetailTransaksi::whereHas('transaksi', function ($query) use ($anggota) {
                $query->where('anggota_id', $anggota->id);
            })
            ->sum('jumlah');

        $totalDendaBelumLunas = Denda::where('anggota_id', $anggota->id)
            ->where('status_denda', 'belum_lunas')
            ->sum('total_denda');

        $dendaBelumLunas = Denda::with(['detailTransaksi.buku'])
            ->where('anggota_id', $anggota->id)
            ->where('status_denda', 'belum_lunas')
            ->orderByDesc('id')
            ->get();

        $sisaHariTerdekat = $pinjamanAktif
            ->filter(fn ($detail) => $detail->transaksi && $detail->transaksi->tanggal_jatuh_tempo)
            ->map(function ($detail) {
                return now()->startOfDay()->diffInDays(
                    Carbon::parse($detail->transaksi->tanggal_jatuh_tempo)->startOfDay(),
                    false
                );
            })
            ->min();

        $notifikasiPeminjaman = $pinjamanAktif->map(function ($detail) {
            if (!$detail->transaksi || !$detail->transaksi->tanggal_jatuh_tempo) {
                return null;
            }

            $judul = optional($detail->buku)->judul_buku ?? 'Buku';
            $jatuhTempo = Carbon::parse($detail->transaksi->tanggal_jatuh_tempo)->startOfDay();
            $hari = now()->startOfDay()->diffInDays($jatuhTempo, false);

            if ($hari < 0) {
                return $judul . ' terlambat ' . abs($hari) . ' hari.';
            }

            if ($hari === 0) {
                return $judul . ' jatuh tempo hari ini.';
            }

            if ($hari <= 2) {
                return $judul . ' jatuh tempo dalam ' . $hari . ' hari.';
            }

            return null;
        })->filter()->values();

        $notifikasiDenda = $dendaBelumLunas->count() > 0
            ? collect(['Kamu memiliki denda belum lunas sebesar Rp ' . number_format($totalDendaBelumLunas, 0, ',', '.') . '.'])
            : collect();

        $notifikasi = $notifikasiPeminjaman
            ->merge($notifikasiDenda)
            ->values();

        $rekomendasiBuku = Buku::with(['kategori', 'rak'])
            ->where('stok_tersedia', '>', 0)
            ->orderByDesc('id')
            ->limit(3)
            ->get();

        $namaBulan = [
            1 => 'Jan',
            2 => 'Feb',
            3 => 'Mar',
            4 => 'Apr',
            5 => 'Mei',
            6 => 'Jun',
            7 => 'Jul',
            8 => 'Agu',
            9 => 'Sep',
            10 => 'Okt',
            11 => 'Nov',
            12 => 'Des',
        ];

        $statistikBulanan = collect(range(5, 0))->map(function ($mundur) use ($anggota, $namaBulan) {
            $tanggal = now()->startOfMonth()->subMonthsNoOverflow($mundur);

            $total = DetailTransaksi::whereHas('transaksi', function ($query) use ($anggota, $tanggal) {
                    $query->where('anggota_id', $anggota->id)
                        ->whereYear('tanggal_pinjam', $tanggal->year)
                        ->whereMonth('tanggal_pinjam', $tanggal->month);
                })
                ->sum('jumlah');

            return [
                'bulan' => $namaBulan[(int) $tanggal->month],
                'tahun' => $tanggal->year,
                'total' => (int) $total,
            ];
        });

        $maxStatistikBulanan = max(1, (int) $statistikBulanan->max('total'));

        $totalBukuTahunIni = DetailTransaksi::whereHas('transaksi', function ($query) use ($anggota) {
                $query->where('anggota_id', $anggota->id)
                    ->whereYear('tanggal_pinjam', now()->year);
            })
            ->sum('jumlah');

        if ($totalBukuTahunIni >= 24) {
            $peringkatMembaca = 'Duta Literasi';
            $targetPeringkat = 24;
        } elseif ($totalBukuTahunIni >= 12) {
            $peringkatMembaca = 'Pembaca Tekun';
            $targetPeringkat = 24;
        } elseif ($totalBukuTahunIni >= 5) {
            $peringkatMembaca = 'Pembaca Aktif';
            $targetPeringkat = 12;
        } else {
            $peringkatMembaca = 'Pembaca Baru';
            $targetPeringkat = 5;
        }

        $progressPeringkat = min(100, round(($totalBukuTahunIni / max(1, $targetPeringkat)) * 100));
        $sisaTargetPeringkat = max(0, $targetPeringkat - $totalBukuTahunIni);

        return view('dashboard-anggota', compact(
            'anggota',
            'totalSedangDipinjam',
            'totalRiwayatPeminjaman',
            'totalDendaBelumLunas',
            'pinjamanAktif',
            'dendaBelumLunas',
            'notifikasi',
            'rekomendasiBuku',
            'statistikBulanan',
            'maxStatistikBulanan',
            'totalBukuTahunIni',
            'sisaHariTerdekat',
            'peringkatMembaca',
            'progressPeringkat',
            'targetPeringkat',
            'sisaTargetPeringkat'
        ));
    }
}