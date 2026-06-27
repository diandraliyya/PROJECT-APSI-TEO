<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class AnggotaController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');
        $kelas = $request->query('kelas');
        $status = $request->query('status');

        $anggotas = Anggota::query()
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('nama_anggota', 'like', "%{$search}%")
                        ->orWhere('nis', 'like', "%{$search}%")
                        ->orWhere('no_anggota', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->when($kelas, function ($query) use ($kelas) {
                $query->where('kelas', $kelas);
            })
            ->when($status, function ($query) use ($status) {
                $query->where('status_anggota', $status);
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $kelasList = Anggota::whereNotNull('kelas')
            ->select('kelas')
            ->distinct()
            ->orderBy('kelas')
            ->pluck('kelas');

        return view('kelola-anggota', compact('anggotas', 'kelasList', 'search', 'kelas', 'status'));
    }

    public function create()
    {
        return view('tambah-anggota');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nis' => ['required', 'string', 'max:30', 'unique:anggotas,nis'],
            'nama_anggota' => ['required', 'string', 'max:100'],
            'kelas' => ['nullable', 'string', 'max:50'],
            'email' => ['required', 'email', 'max:100', 'unique:anggotas,email'],
            'no_hp' => ['nullable', 'string', 'max:20'],
            'alamat' => ['nullable', 'string'],
            'username' => ['required', 'string', 'max:50', 'unique:anggotas,username'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'status_anggota' => ['required', Rule::in(['aktif', 'nonaktif', 'lulus'])],
            'foto' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')->store('anggota', 'public');
        }

        $validated['password'] = Hash::make($validated['password']);
        $validated['no_anggota'] = $this->generateNoAnggota();
        $validated['tanggal_daftar'] = now()->toDateString();
        $validated['status_pendaftaran'] = 'disetujui';

        Anggota::create($validated);

        return redirect()
            ->route('kelola-anggota')
            ->with('success', 'Anggota berhasil ditambahkan.');
    }

    public function approve(Anggota $anggota)
    {
        $anggota->update([
            'no_anggota' => $anggota->no_anggota ?? $this->generateNoAnggota(),
            'status_pendaftaran' => 'disetujui',
            'status_anggota' => 'aktif',
        ]);

        return redirect()
            ->route('kelola-anggota')
            ->with('success', 'Pendaftaran anggota berhasil disetujui.');
    }

    public function reject(Anggota $anggota)
    {
        $anggota->update([
            'status_pendaftaran' => 'ditolak',
            'status_anggota' => 'nonaktif',
        ]);

        return redirect()
            ->route('kelola-anggota')
            ->with('success', 'Pendaftaran anggota berhasil ditolak.');
    }

    public function activate(Anggota $anggota)
    {
        $anggota->update([
            'status_anggota' => 'aktif',
        ]);

        return redirect()
            ->route('kelola-anggota')
            ->with('success', 'Anggota berhasil diaktifkan.');
    }

    public function deactivate(Anggota $anggota)
    {
        $anggota->update([
            'status_anggota' => 'nonaktif',
        ]);

        return redirect()
            ->route('kelola-anggota')
            ->with('success', 'Anggota berhasil dinonaktifkan.');
    }

    public function destroy(Anggota $anggota)
    {
        if ($anggota->transaksis()->exists()) {
            return redirect()
                ->route('kelola-anggota')
                ->with('error', 'Anggota tidak bisa dihapus karena sudah memiliki riwayat transaksi.');
        }

        if ($anggota->foto) {
            Storage::disk('public')->delete($anggota->foto);
        }

        $anggota->delete();

        return redirect()
            ->route('kelola-anggota')
            ->with('success', 'Anggota berhasil dihapus.');
    }

    private function generateNoAnggota(): string
    {
        $tahun = now()->format('Y');
        $bulan = now()->format('m');

        $jumlahAnggotaBulanIni = Anggota::whereYear('created_at', now()->year)
            ->whereMonth('created_at', now()->month)
            ->count() + 1;

        return $tahun . '.' . $bulan . '.' . str_pad($jumlahAnggotaBulanIni, 4, '0', STR_PAD_LEFT);
    }
}