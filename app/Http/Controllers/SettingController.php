<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SettingController extends Controller
{
    public function index()
    {
        $setting = Setting::firstOrCreate(
            ['id' => 1],
            [
                'tarif_denda_per_hari' => 1000,
                'maksimal_hari_pinjam' => 7,
                'nama_perpustakaan' => 'SMAIT Al-Uswah Library',
                'email_perpustakaan' => null,
                'telepon_perpustakaan' => null,
                'alamat_perpustakaan' => null,
            ]
        );

        $admin = session('auth_role') === 'admin'
            ? Admin::find(session('auth_id'))
            : Admin::first();

        return view('setting', compact('setting', 'admin'));
    }

    public function updatePerpustakaan(Request $request)
    {
        $validated = $request->validate([
            'nama_perpustakaan' => ['required', 'string', 'max:150'],
            'tarif_denda_per_hari' => ['required', 'numeric', 'min:0'],
            'maksimal_hari_pinjam' => ['required', 'integer', 'min:1'],
            'email_perpustakaan' => ['nullable', 'email', 'max:100'],
            'telepon_perpustakaan' => ['nullable', 'string', 'max:20'],
            'alamat_perpustakaan' => ['nullable', 'string'],
        ]);

        $setting = Setting::firstOrCreate(['id' => 1]);

        $setting->update($validated);

        return redirect()
            ->route('setting')
            ->with('success', 'Pengaturan perpustakaan berhasil diperbarui.');
    }

    public function updateAdmin(Request $request)
    {
        $admin = session('auth_role') === 'admin'
            ? Admin::find(session('auth_id'))
            : Admin::first();

        if (!$admin) {
            return redirect()
                ->route('setting')
                ->with('error', 'Data admin tidak ditemukan.');
        }

        $validated = $request->validate([
            'nama_admin' => ['required', 'string', 'max:100'],
            'username' => ['required', 'string', 'max:50', 'unique:admins,username,' . $admin->id],
            'email' => ['required', 'email', 'max:100', 'unique:admins,email,' . $admin->id],
            'no_hp' => ['nullable', 'string', 'max:20'],
        ]);

        $admin->update($validated);

        if (session('auth_role') === 'admin') {
            session([
                'auth_name' => $admin->nama_admin,
            ]);
        }

        return redirect()
            ->route('setting')
            ->with('success', 'Data admin berhasil diperbarui.');
    }

    public function updatePassword(Request $request)
    {
        $admin = session('auth_role') === 'admin'
            ? Admin::find(session('auth_id'))
            : Admin::first();

        if (!$admin) {
            return redirect()
                ->route('setting')
                ->with('error', 'Data admin tidak ditemukan.');
        }

        $validated = $request->validate([
            'password_lama' => ['required', 'string'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        if (!Hash::check($validated['password_lama'], $admin->password)) {
            return redirect()
                ->route('setting')
                ->withErrors(['password_lama' => 'Password lama tidak sesuai.']);
        }

        $admin->update([
            'password' => Hash::make($validated['password']),
        ]);

        return redirect()
            ->route('setting')
            ->with('success', 'Password admin berhasil diperbarui.');
    }
}