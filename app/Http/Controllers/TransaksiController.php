<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\Buku;
use App\Models\Denda;
use App\Models\DetailTransaksi;
use App\Models\Setting;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class TransaksiController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');
        $status = $request->query('status');

        $transaksis = Transaksi::with(['anggota', 'admin', 'detailTransaksis.buku'])
            ->when($search, function ($query) use ($search) {
                $query->where('kode_transaksi', 'like', "%{$search}%")
                    ->orWhereHas('anggota', function ($q) use ($search) {
                        $q->where('nama_anggota', 'like', "%{$search}%")
                            ->orWhere('nis', 'like', "%{$search}%")
                            ->orWhere('no_anggota', 'like', "%{$search}%");
                    });
            })
            ->when($status, function ($query) use ($status) {
                $query->where('status_transaksi', $status);
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('riwayat-transaksi', compact('transaksis', 'search', 'status'));
    }

    public function create()
    {
        $anggotas = Anggota::where('status_pendaftaran', 'disetujui')
            ->where('status_anggota', 'aktif')
            ->orderBy('nama_anggota')
            ->get();

        $bukus = Buku::where('stok_tersedia', '>', 0)
            ->orderBy('judul_buku')
            ->get();

        return view('input-peminjaman', compact('anggotas', 'bukus'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'anggota_id' => ['required', 'exists:anggotas,id'],
            'buku_id' => ['required', 'array', 'min:1'],
            'buku_id.*' => ['required', 'exists:bukus,id'],
            'tanggal_pinjam' => ['required', 'date'],
            'tanggal_jatuh_tempo' => ['nullable', 'date', 'after_or_equal:tanggal_pinjam'],
            'catatan' => ['nullable', 'string'],
        ]);

        $setting = Setting::first();
        $tanggalPinjam = Carbon::parse($validated['tanggal_pinjam']);

        $tanggalJatuhTempo = isset($validated['tanggal_jatuh_tempo'])
            ? Carbon::parse($validated['tanggal_jatuh_tempo'])
            : $tanggalPinjam->copy()->addDays($setting->maksimal_hari_pinjam ?? 7);

        DB::transaction(function () use ($validated, $tanggalPinjam, $tanggalJatuhTempo) {
            $transaksi = Transaksi::create([
                'anggota_id' => $validated['anggota_id'],
                'admin_id' => session('auth_role') === 'admin' ? session('auth_id') : null,
                'kode_transaksi' => $this->generateKodeTransaksi(),
                'tanggal_pinjam' => $tanggalPinjam->toDateString(),
                'tanggal_jatuh_tempo' => $tanggalJatuhTempo->toDateString(),
                'tanggal_kembali' => null,
                'status_transaksi' => 'dipinjam',
                'total_item' => count($validated['buku_id']),
                'catatan' => $validated['catatan'] ?? null,
            ]);

            foreach ($validated['buku_id'] as $bukuId) {
                $buku = Buku::lockForUpdate()->findOrFail($bukuId);

                if ($buku->stok_tersedia <= 0) {
                    throw new \Exception("Stok buku {$buku->judul_buku} tidak tersedia.");
                }

                DetailTransaksi::create([
                    'transaksi_id' => $transaksi->id,
                    'buku_id' => $buku->id,
                    'jumlah' => 1,
                    'status_item' => 'dipinjam',
                    'tanggal_kembali_item' => null,
                ]);

                $buku->stok_tersedia -= 1;
                $buku->status_buku = $this->hitungStatusBuku($buku->stok_tersedia);
                $buku->save();
            }
        });

        return redirect()
            ->route('riwayat-transaksi')
            ->with('success', 'Transaksi peminjaman berhasil disimpan.');
    }

    public function show(Transaksi $transaksi)
    {
        $transaksi->load(['anggota', 'admin', 'detailTransaksis.buku', 'detailTransaksis.denda']);

        return view('detail-transaksi', compact('transaksi'));
    }

    public function returnBook(Request $request, DetailTransaksi $detailTransaksi)
    {
        $validated = $request->validate([
            'tanggal_kembali_item' => ['nullable', 'date'],
        ]);

        $tanggalKembali = isset($validated['tanggal_kembali_item'])
            ? Carbon::parse($validated['tanggal_kembali_item'])
            : now();

        DB::transaction(function () use ($detailTransaksi, $tanggalKembali) {
            $detailTransaksi->load(['transaksi', 'buku']);

            if ($detailTransaksi->status_item === 'dikembalikan') {
                return;
            }

            $transaksi = $detailTransaksi->transaksi;
            $buku = Buku::lockForUpdate()->findOrFail($detailTransaksi->buku_id);

            $detailTransaksi->update([
                'status_item' => $tanggalKembali->gt(Carbon::parse($transaksi->tanggal_jatuh_tempo))
                    ? 'terlambat'
                    : 'dikembalikan',
                'tanggal_kembali_item' => $tanggalKembali->toDateString(),
            ]);

            $buku->stok_tersedia += 1;
            if ($buku->stok_tersedia > $buku->stok_total) {
                $buku->stok_tersedia = $buku->stok_total;
            }
            $buku->status_buku = $this->hitungStatusBuku($buku->stok_tersedia);
            $buku->save();

            $jatuhTempo = Carbon::parse($transaksi->tanggal_jatuh_tempo);

            if ($tanggalKembali->gt($jatuhTempo)) {
                $hariTerlambat = $jatuhTempo->diffInDays($tanggalKembali);
                $tarif = Setting::first()->tarif_denda_per_hari ?? 1000;

                Denda::updateOrCreate(
                    ['detail_transaksi_id' => $detailTransaksi->id],
                    [
                        'anggota_id' => $transaksi->anggota_id,
                        'jumlah_hari_terlambat' => $hariTerlambat,
                        'tarif_per_hari' => $tarif,
                        'total_denda' => $hariTerlambat * $tarif,
                        'status_denda' => 'belum_lunas',
                        'tanggal_denda' => $tanggalKembali->toDateString(),
                    ]
                );
            }

            $sisaDipinjam = $transaksi->detailTransaksis()
                ->whereIn('status_item', ['dipinjam', 'terlambat'])
                ->whereNull('tanggal_kembali_item')
                ->count();

            if ($sisaDipinjam === 0) {
                $adaTerlambat = $transaksi->detailTransaksis()
                    ->where('status_item', 'terlambat')
                    ->exists();

                $transaksi->update([
                    'tanggal_kembali' => $tanggalKembali->toDateString(),
                    'status_transaksi' => $adaTerlambat ? 'terlambat' : 'dikembalikan',
                ]);
            } else {
                if (now()->gt(Carbon::parse($transaksi->tanggal_jatuh_tempo))) {
                    $transaksi->update([
                        'status_transaksi' => 'terlambat',
                    ]);
                }
            }
        });

        return redirect()
            ->route('riwayat-transaksi')
            ->with('success', 'Pengembalian buku berhasil diproses.');
    }

    public function riwayatAnggota(Request $request)
    {
        $anggotaId = session('auth_role') === 'anggota'
            ? session('auth_id')
            : $request->query('anggota_id');

        $transaksis = Transaksi::with(['detailTransaksis.buku'])
            ->where('anggota_id', $anggotaId)
            ->latest()
            ->paginate(10);

        return view('riwayat-peminjaman', compact('transaksis'));
    }

    private function generateKodeTransaksi(): string
    {
        return 'TRX-' . now()->format('YmdHis') . '-' . rand(100, 999);
    }

    private function hitungStatusBuku(int $stokTersedia): string
    {
        if ($stokTersedia <= 0) {
            return 'tidak_tersedia';
        }

        if ($stokTersedia <= 2) {
            return 'stok_sedikit';
        }

        return 'tersedia';
    }
}