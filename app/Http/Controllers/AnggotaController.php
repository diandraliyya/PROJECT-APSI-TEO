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
            ->withCount([
                'transaksis',
                'transaksis as transaksi_aktif_count' => function ($query) {
                    $query->whereIn('status_transaksi', ['dipinjam', 'terlambat']);
                },
                'dendas',
            ])
            ->withSum([
                'dendas as total_denda_belum_lunas' => function ($query) {
                    $query->where('status_denda', 'belum_lunas');
                }
            ], 'total_denda')
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('nama_anggota', 'like', "%{$search}%")
                        ->orWhere('nis', 'like', "%{$search}%")
                        ->orWhere('no_anggota', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('username', 'like', "%{$search}%");
                });
            })
            ->when($kelas, function ($query) use ($kelas) {
                $query->where('kelas', $kelas);
            })
            ->when($status, function ($query) use ($status) {
                $query->where('status_anggota', $status);
            })
            ->orderByDesc('id')
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
        $validated['admin_id'] = session('auth_role') === 'admin' ? session('auth_id') : null;
        
        Anggota::create($validated);

        return redirect()
            ->route('kelola-anggota')
            ->with('success', 'Anggota berhasil ditambahkan.');
    }

    public function approve(Anggota $anggota)
    {
        $anggota->update([
            'no_anggota' => $anggota->no_anggota ?? $this->generateNoAnggota(),
            'tanggal_daftar' => $anggota->tanggal_daftar ?? now()->toDateString(),
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
            'no_anggota' => $anggota->no_anggota ?? $this->generateNoAnggota(),
            'status_pendaftaran' => 'disetujui',
            'status_anggota' => 'aktif',
            'tanggal_daftar' => $anggota->tanggal_daftar ?? now()->toDateString(),
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
        if ($anggota->transaksis()->exists() || $anggota->dendas()->exists()) {
            return redirect()
                ->route('kelola-anggota')
                ->with('error', 'Anggota tidak bisa dihapus karena sudah memiliki riwayat transaksi atau denda.');
        }

        if ($anggota->foto) {
            Storage::disk('public')->delete($anggota->foto);
        }

        $anggota->delete();

        return redirect()
            ->route('kelola-anggota')
            ->with('success', 'Anggota berhasil dihapus.');
    }

    public function profil()
    {
        if (session('auth_role') !== 'anggota' || !session('auth_id')) {
            return redirect('/log-in')
                ->withErrors(['login' => 'Silakan login sebagai anggota terlebih dahulu.']);
        }

        $anggota = Anggota::find(session('auth_id'));

        if (!$anggota) {
            session()->forget(['auth_role', 'auth_id', 'auth_name']);

            return redirect('/log-in')
                ->withErrors(['login' => 'Data anggota tidak ditemukan. Silakan login kembali.']);
        }

        return view('profil-anggota', compact('anggota'));
    }

    public function updateProfil(Request $request)
    {
        if (session('auth_role') !== 'anggota' || !session('auth_id')) {
            return redirect('/log-in')
                ->withErrors(['login' => 'Silakan login sebagai anggota terlebih dahulu.']);
        }

        $anggota = Anggota::findOrFail(session('auth_id'));

        $validated = $request->validate([
            'username' => [
                'required',
                'string',
                'max:50',
                Rule::unique('anggotas', 'username')->ignore($anggota->id),
            ],
            'email' => [
                'required',
                'email',
                'max:100',
                Rule::unique('anggotas', 'email')->ignore($anggota->id),
            ],
            'no_hp' => ['nullable', 'string', 'max:20'],
            'alamat' => ['nullable', 'string'],
            'foto' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        if ($request->hasFile('foto')) {
            if ($anggota->foto) {
                Storage::disk('public')->delete($anggota->foto);
            }

            $validated['foto'] = $request->file('foto')->store('anggota', 'public');
        }

        $anggota->update($validated);

        return redirect('/profil-anggota')
            ->with('success', 'Profil berhasil diperbarui.');
    }

    public function updatePassword(Request $request)
    {
        if (session('auth_role') !== 'anggota' || !session('auth_id')) {
            return redirect('/log-in')
                ->withErrors(['login' => 'Silakan login sebagai anggota terlebih dahulu.']);
        }

        $anggota = Anggota::findOrFail(session('auth_id'));

        $validated = $request->validate([
            'password_lama' => ['required', 'string'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        if (!Hash::check($validated['password_lama'], $anggota->password)) {
            return back()
                ->withErrors(['password_lama' => 'Password lama tidak sesuai.'])
                ->withInput();
        }

        $anggota->update([
            'password' => Hash::make($validated['password']),
        ]);

        return redirect('/profil-anggota')
            ->with('success', 'Password berhasil diperbarui.');
    }

    private function generateNoAnggota(): string
    {
        $tahun = now()->format('Y');
        $bulan = now()->format('m');
        $prefix = $tahun . '.' . $bulan . '.';

        $nomorTerakhir = Anggota::where('no_anggota', 'like', $prefix . '%')
            ->orderByDesc('no_anggota')
            ->value('no_anggota');

        if ($nomorTerakhir) {
            $angkaTerakhir = (int) substr($nomorTerakhir, -4);
            $angkaBaru = $angkaTerakhir + 1;
        } else {
            $angkaBaru = 1;
        }

        return $prefix . str_pad($angkaBaru, 4, '0', STR_PAD_LEFT);
    }
}