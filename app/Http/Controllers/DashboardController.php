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

        $totalDipinjam = Transaksi::where('status_transaksi', 'dipinjam')->count();

        $totalTerlambat = Transaksi::where('status_transaksi', 'terlambat')->count();

        $totalDendaBelumLunas = Denda::where('status_denda', 'belum_lunas')->sum('total_denda');

        $transaksiTerbaru = Transaksi::with(['anggota', 'detailTransaksis.buku'])
            ->latest()
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

        return view('dashboard-admin', compact(
            'totalBuku',
            'totalStokTersedia',
            'totalAnggotaAktif',
            'totalPendaftaranMenunggu',
            'totalDipinjam',
            'totalTerlambat',
            'totalDendaBelumLunas',
            'transaksiTerbaru',
            'bukuStokSedikit',
            'bukuTerpopuler'
        ));
    }

    public function anggota(Request $request)
    {
        $anggotaId = session('auth_role') === 'anggota'
            ? session('auth_id')
            : $request->query('anggota_id');

        $anggota = $anggotaId
            ? Anggota::find($anggotaId)
            : Anggota::first();

        if (!$anggota) {
            return view('dashboard-anggota', [
                'anggota' => null,
                'totalSedangDipinjam' => 0,
                'totalRiwayatPeminjaman' => 0,
                'totalDendaBelumLunas' => 0,
                'transaksiAktif' => collect(),
                'dendaBelumLunas' => collect(),
                'notifikasi' => collect(),
            ]);
        }

        $totalSedangDipinjam = Transaksi::where('anggota_id', $anggota->id)
            ->whereIn('status_transaksi', ['dipinjam', 'terlambat'])
            ->count();

        $totalRiwayatPeminjaman = Transaksi::where('anggota_id', $anggota->id)->count();

        $totalDendaBelumLunas = Denda::where('anggota_id', $anggota->id)
            ->where('status_denda', 'belum_lunas')
            ->sum('total_denda');

        $transaksiAktif = Transaksi::with(['detailTransaksis.buku'])
            ->where('anggota_id', $anggota->id)
            ->whereIn('status_transaksi', ['dipinjam', 'terlambat'])
            ->latest()
            ->get();

        $dendaBelumLunas = Denda::with(['detailTransaksi.buku'])
            ->where('anggota_id', $anggota->id)
            ->where('status_denda', 'belum_lunas')
            ->latest()
            ->get();

        $notifikasi = $transaksiAktif->map(function ($transaksi) {
            $jatuhTempo = Carbon::parse($transaksi->tanggal_jatuh_tempo);
            $hari = now()->startOfDay()->diffInDays($jatuhTempo, false);

            if ($hari < 0) {
                return 'Peminjaman ' . $transaksi->kode_transaksi . ' terlambat ' . abs($hari) . ' hari.';
            }

            if ($hari === 0) {
                return 'Peminjaman ' . $transaksi->kode_transaksi . ' jatuh tempo hari ini.';
            }

            if ($hari <= 2) {
                return 'Peminjaman ' . $transaksi->kode_transaksi . ' jatuh tempo dalam ' . $hari . ' hari.';
            }

            return null;
        })->filter()->values();

        return view('dashboard-anggota', compact(
            'anggota',
            'totalSedangDipinjam',
            'totalRiwayatPeminjaman',
            'totalDendaBelumLunas',
            'transaksiAktif',
            'dendaBelumLunas',
            'notifikasi'
        ));
    }
}