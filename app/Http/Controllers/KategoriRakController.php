<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Rak;
use Illuminate\Http\Request;

class KategoriRakController extends Controller
{
    public function index()
    {
        $kategoris = Kategori::withCount('bukus')
            ->orderBy('nama_kategori')
            ->get();

        $raks = Rak::withCount('bukus')
            ->orderBy('kode_rak')
            ->get();

        return view('kategori-rak', compact('kategoris', 'raks'));
    }

    public function storeKategori(Request $request)
    {
        $validated = $request->validate([
            'nama_kategori' => ['required', 'string', 'max:100', 'unique:kategoris,nama_kategori'],
            'deskripsi' => ['nullable', 'string'],
        ]);

        Kategori::create($validated);

        return redirect()
            ->route('kategori-rak')
            ->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function storeRak(Request $request)
    {
        $validated = $request->validate([
            'kode_rak' => ['required', 'string', 'max:20', 'unique:raks,kode_rak'],
            'lokasi' => ['nullable', 'string', 'max:100'],
            'deskripsi' => ['nullable', 'string'],
        ]);

        Rak::create($validated);

        return redirect()
            ->route('kategori-rak')
            ->with('success', 'Rak berhasil ditambahkan.');
    }

    public function destroyKategori(Kategori $kategori)
    {
        if ($kategori->bukus()->exists()) {
            return redirect()
                ->route('kategori-rak')
                ->with('error', 'Kategori tidak bisa dihapus karena masih digunakan oleh buku.');
        }

        $kategori->delete();

        return redirect()
            ->route('kategori-rak')
            ->with('success', 'Kategori berhasil dihapus.');
    }

    public function destroyRak(Rak $rak)
    {
        if ($rak->bukus()->exists()) {
            return redirect()
                ->route('kategori-rak')
                ->with('error', 'Rak tidak bisa dihapus karena masih digunakan oleh buku.');
        }

        $rak->delete();

        return redirect()
            ->route('kategori-rak')
            ->with('success', 'Rak berhasil dihapus.');
    }
}