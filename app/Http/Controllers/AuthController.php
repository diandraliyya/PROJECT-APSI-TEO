<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Anggota;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AuthController extends Controller
{
    public function showRegister()
    {
        return view('register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'nama_anggota' => ['required', 'string', 'max:100'],
            'nis' => ['required', 'string', 'max:30', 'unique:anggotas,nis'],
            'kelas' => ['nullable', 'string', 'max:50'],
            'email' => ['required', 'email', 'max:100', 'unique:anggotas,email'],
            'no_hp' => ['nullable', 'string', 'max:20'],
            'alamat' => ['nullable', 'string'],
            'username' => ['required', 'string', 'max:50', 'unique:anggotas,username'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        Anggota::create([
            'no_anggota' => null,
            'nis' => $validated['nis'],
            'nama_anggota' => $validated['nama_anggota'],
            'kelas' => $validated['kelas'] ?? null,
            'username' => $validated['username'],
            'password' => Hash::make($validated['password']),
            'email' => $validated['email'],
            'no_hp' => $validated['no_hp'] ?? null,
            'alamat' => $validated['alamat'] ?? null,
            'tanggal_daftar' => now()->toDateString(),
            'status_pendaftaran' => 'menunggu',
            'status_anggota' => 'nonaktif',
        ]);

        return redirect()
            ->route('log-in')
            ->with('success', 'Pendaftaran berhasil. Akun Anda menunggu persetujuan admin.');
    }

    public function showLogin()
    {
        return view('log-in');
    }

    public function login(Request $request)
    {
        $validated = $request->validate([
            'login' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        // Cek di tabel admins
        $admin = Admin::where('username', $validated['login'])
            ->orWhere('email', $validated['login'])
            ->first();

        if ($admin && Hash::check($validated['password'], $admin->password)) {
            session([
                'auth_role' => 'admin',
                'auth_id' => $admin->id,
                'auth_name' => $admin->nama_admin,
            ]);

            return redirect('/home-admin');  // ← Ubah ini
        }

        // Cek di tabel anggotas
        $anggota = Anggota::where('username', $validated['login'])
            ->orWhere('email', $validated['login'])
            ->orWhere('nis', $validated['login'])
            ->first();

        if ($anggota && Hash::check($validated['password'], $anggota->password)) {
            if ($anggota->status_pendaftaran !== 'disetujui') {
                return back()
                    ->withErrors(['login' => 'Akun Anda belum disetujui oleh admin.'])
                    ->withInput();
            }

            if ($anggota->status_anggota !== 'aktif') {
                return back()
                    ->withErrors(['login' => 'Akun Anda sedang tidak aktif. Hubungi admin.'])
                    ->withInput();
            }

            session([
                'auth_role' => 'anggota',
                'auth_id' => $anggota->id,
                'auth_name' => $anggota->nama_anggota,
            ]);

            return redirect('/home-anggota');  // ← Ubah ini
        }

        return back()
            ->withErrors(['login' => 'Username/email/NIS atau password salah.'])
            ->withInput();
    }

    public function logout(Request $request)
    {
        // 1. Hapus session kita sendiri
        $request->session()->forget(['auth_role', 'auth_id', 'auth_name']);

        // 2. Hapus semua data session (paksa)
        $request->session()->flush();

        // 3. Invalidate session biar token lama gak dipakai
        $request->session()->invalidate();

        // 4. Buat token baru
        $request->session()->regenerateToken();

        // 5. Redirect ke halaman login dengan pesan sukses
        return redirect('/log-in')->with('success', 'Anda berhasil logout.');
    }
}