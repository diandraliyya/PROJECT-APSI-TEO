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

        $login = $validated['login'];
        $password = $validated['password'];

        $admin = Admin::where('username', $login)
            ->orWhere('email', $login)
            ->first();

        if ($admin && Hash::check($password, $admin->password)) {
            if ($admin->status_admin !== 'aktif') {
                return back()
                    ->withErrors(['login' => 'Akun admin tidak aktif.'])
                    ->withInput();
            }

            $request->session()->regenerate();

            session([
                'auth_role' => 'admin',
                'auth_id' => $admin->id,
                'auth_name' => $admin->nama_admin,
            ]);

            return redirect()->route('dashboard-admin');
        }

        $anggota = Anggota::where('username', $login)
            ->orWhere('email', $login)
            ->orWhere('nis', $login)
            ->first();

        if ($anggota && Hash::check($password, $anggota->password)) {
            if ($anggota->status_pendaftaran !== 'disetujui') {
                return back()
                    ->withErrors(['login' => 'Pendaftaran akun Anda belum disetujui admin.'])
                    ->withInput();
            }

            if ($anggota->status_anggota !== 'aktif') {
                return back()
                    ->withErrors(['login' => 'Akun anggota Anda belum aktif.'])
                    ->withInput();
            }

            $request->session()->regenerate();

            session([
                'auth_role' => 'anggota',
                'auth_id' => $anggota->id,
                'auth_name' => $anggota->nama_anggota,
            ]);

            return redirect()->route('dashboard-anggota');
        }

        return back()
            ->withErrors(['login' => 'Username/email/NIS atau password salah.'])
            ->withInput();
    }

    public function logout(Request $request)
    {
        $request->session()->forget([
            'auth_role',
            'auth_id',
            'auth_name',
        ]);

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}