<?php

namespace App\Http\Controllers;

use App\Models\Denda;
use App\Models\PembayaranDenda;
use Illuminate\Http\Request;
use App\Models\Setting;

class DendaController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');
        $status = $request->query('status');

        $dendas = Denda::with(['anggota', 'detailTransaksi.buku', 'pembayaranDendas'])
            ->when($search, function ($query) use ($search) {
                $query->where(function ($mainQuery) use ($search) {
                    $mainQuery->whereHas('anggota', function ($q) use ($search) {
                        $q->where('nama_anggota', 'like', "%{$search}%")
                            ->orWhere('nis', 'like', "%{$search}%")
                            ->orWhere('no_anggota', 'like', "%{$search}%");
                    })
                    ->orWhereHas('detailTransaksi.buku', function ($q) use ($search) {
                        $q->where('judul_buku', 'like', "%{$search}%")
                            ->orWhere('isbn', 'like', "%{$search}%");
                    });
                });
            })
            ->when($status, function ($query) use ($status) {
                $query->where('status_denda', $status);
            })
            ->orderByDesc('id')
            ->paginate(10)
            ->withQueryString();

        $totalBelumLunas = Denda::where('status_denda', 'belum_lunas')->count();
        $totalLunas = Denda::where('status_denda', 'lunas')->count();

        $totalDendaBelumLunas = Denda::where('status_denda', 'belum_lunas')->sum('total_denda');

        $totalDendaTerkumpul = PembayaranDenda::where('status_validasi', 'valid')->sum('nominal_bayar');

        $tarifDenda = Setting::first()->tarif_denda_per_hari ?? 1000;

        return view('kelola-denda', compact(
            'dendas',
            'search',
            'status',
            'totalBelumLunas',
            'totalLunas',
            'totalDendaBelumLunas',
            'totalDendaTerkumpul',
            'tarifDenda'
        ));
    }

    public function statusAnggota(Request $request)
    {
        $anggotaId = session('auth_role') === 'anggota'
            ? session('auth_id')
            : $request->query('anggota_id');

        $dendas = Denda::with(['detailTransaksi.buku', 'pembayaranDendas'])
            ->when($anggotaId, function ($query) use ($anggotaId) {
                $query->where('anggota_id', $anggotaId);
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('status-denda', compact('dendas'));
    }

    public function show(Denda $denda)
    {
        $denda->load([
            'anggota',
            'detailTransaksi.buku',
            'detailTransaksi.transaksi',
            'pembayaranDendas.admin',
        ]);

        return view('detail-denda', compact('denda'));
    }

    public function storePembayaran(Request $request, Denda $denda)
    {
        if ($denda->status_denda === 'lunas') {
            return back()->with('error', 'Denda ini sudah lunas.');
        }

        $validated = $request->validate([
            'nominal_bayar' => ['required', 'numeric', 'min:1'],
            'metode_pembayaran' => ['required', 'in:tunai,transfer,qris,lainnya'],
            'keterangan' => ['nullable', 'string'],
        ]);

        $totalSudahValid = $denda->pembayaranDendas()
            ->where('status_validasi', 'valid')
            ->sum('nominal_bayar');

        $sisaDenda = $denda->total_denda - $totalSudahValid;

        if ($validated['nominal_bayar'] > $sisaDenda) {
            return back()
                ->withErrors(['nominal_bayar' => 'Nominal pembayaran melebihi sisa denda.'])
                ->withInput();
        }

        PembayaranDenda::create([
            'denda_id' => $denda->id,
            'admin_id' => session('auth_role') === 'admin' ? session('auth_id') : null,
            'tanggal_pembayaran' => now()->toDateString(),
            'nominal_bayar' => $validated['nominal_bayar'],
            'metode_pembayaran' => $validated['metode_pembayaran'],
            'status_validasi' => session('auth_role') === 'admin' ? 'valid' : 'menunggu',
            'keterangan' => $validated['keterangan'] ?? null,
        ]);

        $this->sinkronStatusDenda($denda);

        return redirect()
            ->route('denda.show', $denda)
            ->with('success', 'Pembayaran denda berhasil disimpan.');
    }

    public function validasiPembayaran(PembayaranDenda $pembayaranDenda)
    {
        $pembayaranDenda->update([
            'admin_id' => session('auth_role') === 'admin' ? session('auth_id') : $pembayaranDenda->admin_id,
            'status_validasi' => 'valid',
        ]);

        $this->sinkronStatusDenda($pembayaranDenda->denda);

        return back()->with('success', 'Pembayaran berhasil divalidasi.');
    }

    public function tolakPembayaran(PembayaranDenda $pembayaranDenda)
    {
        $pembayaranDenda->update([
            'admin_id' => session('auth_role') === 'admin' ? session('auth_id') : $pembayaranDenda->admin_id,
            'status_validasi' => 'ditolak',
        ]);

        $this->sinkronStatusDenda($pembayaranDenda->denda);

        return back()->with('success', 'Pembayaran berhasil ditolak.');
    }

    public function lunasiManual(Denda $denda)
    {
        if ($denda->status_denda === 'lunas') {
            return back()->with('error', 'Denda ini sudah lunas.');
        }

        $totalSudahValid = $denda->pembayaranDendas()
            ->where('status_validasi', 'valid')
            ->sum('nominal_bayar');

        $sisaDenda = $denda->total_denda - $totalSudahValid;

        if ($sisaDenda <= 0) {
            $denda->update([
                'status_denda' => 'lunas',
            ]);

            return back()->with('success', 'Status denda berhasil diperbarui menjadi lunas.');
        }

        PembayaranDenda::create([
            'denda_id' => $denda->id,
            'admin_id' => session('auth_role') === 'admin' ? session('auth_id') : null,
            'tanggal_pembayaran' => now()->toDateString(),
            'nominal_bayar' => $sisaDenda,
            'metode_pembayaran' => 'tunai',
            'status_validasi' => 'valid',
            'keterangan' => 'Pelunasan manual oleh admin.',
        ]);

        $denda->update([
            'status_denda' => 'lunas',
        ]);

        return back()->with('success', 'Denda berhasil dilunasi.');
    }

    private function sinkronStatusDenda(Denda $denda): void
    {
        $denda->refresh();

        $totalSudahValid = $denda->pembayaranDendas()
            ->where('status_validasi', 'valid')
            ->sum('nominal_bayar');

        if ($totalSudahValid >= $denda->total_denda) {
            $denda->update([
                'status_denda' => 'lunas',
            ]);
        } else {
            $denda->update([
                'status_denda' => 'belum_lunas',
            ]);
        }
    }
}