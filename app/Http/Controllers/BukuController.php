<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Kategori;
use App\Models\Rak;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class BukuController extends Controller
{
    public function katalog(Request $request)
    {
        $search = $request->query('search');
        $kategori = $request->query('kategori');
        $sort = $request->query('sort', 'terbaru');

        $bukus = Buku::with(['kategori', 'rak'])
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('judul_buku', 'like', "%{$search}%")
                        ->orWhere('penulis', 'like', "%{$search}%")
                        ->orWhere('isbn', 'like', "%{$search}%");
                });
            })
            ->when($kategori, function ($query) use ($kategori) {
                $query->whereHas('kategori', function ($q) use ($kategori) {
                    $q->where('nama_kategori', $kategori);
                });
            })
            ->when($sort === 'tersedia', function ($query) {
                $query->where('stok_tersedia', '>', 0);
            })
            ->when($sort === 'terbaru', function ($query) {
                $query->orderByDesc('id');
            })
            ->when($sort === 'terlama', function ($query) {
                $query->orderBy('id');
            })
            ->when($sort === 'az', function ($query) {
                $query->orderBy('judul_buku');
            })
            ->when($sort === 'za', function ($query) {
                $query->orderByDesc('judul_buku');
            })
            ->when(!in_array($sort, ['terbaru', 'terlama', 'az', 'za', 'tersedia']), function ($query) {
                $query->orderByDesc('id');
            })
            ->paginate(8)
            ->withQueryString();

        $kategoris = Kategori::orderBy('nama_kategori')->get();

        return view('katalog', compact('bukus', 'kategoris', 'search', 'kategori', 'sort'));
    }

    public function katalogAnggota(Request $request)
    {
        $search = $request->query('search');
        $kategori = $request->query('kategori');
        $sort = $request->query('sort', 'terbaru');

        $bukus = Buku::with(['kategori', 'rak'])
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('judul_buku', 'like', "%{$search}%")
                        ->orWhere('penulis', 'like', "%{$search}%")
                        ->orWhere('isbn', 'like', "%{$search}%");
                });
            })
            ->when($kategori, function ($query) use ($kategori) {
                $query->whereHas('kategori', function ($q) use ($kategori) {
                    $q->where('nama_kategori', $kategori);
                });
            })
            ->when($sort === 'tersedia', function ($query) {
                $query->where('stok_tersedia', '>', 0);
            })
            ->when($sort === 'terbaru', function ($query) {
                $query->orderByDesc('id');
            })
            ->when($sort === 'terlama', function ($query) {
                $query->orderBy('id');
            })
            ->when($sort === 'az', function ($query) {
                $query->orderBy('judul_buku');
            })
            ->when($sort === 'za', function ($query) {
                $query->orderByDesc('judul_buku');
            })
            ->when(!in_array($sort, ['terbaru', 'terlama', 'az', 'za', 'tersedia']), function ($query) {
                $query->orderByDesc('id');
            })
            ->paginate(8)
            ->withQueryString();

        $kategoris = Kategori::orderBy('nama_kategori')->get();

        return view('katalog-anggota', compact('bukus', 'kategoris', 'search', 'kategori', 'sort'));
    }

    public function katalogAdmin(Request $request)
    {
    $search = $request->query('search');
    $kategori = $request->query('kategori');
    $sort = $request->query('sort', 'terbaru');

    $bukus = Buku::with(['kategori', 'rak'])
        ->when($search, function ($query) use ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('judul_buku', 'like', "%{$search}%")
                    ->orWhere('penulis', 'like', "%{$search}%")
                    ->orWhere('isbn', 'like', "%{$search}%");
            });
        })
        ->when($kategori, function ($query) use ($kategori) {
            $query->where('kategori_id', $kategori);
        })
        ->when($sort === 'tersedia', function ($query) {
            $query->where('status_buku', 'tersedia');
        })
        ->when($sort === 'terbaru', function ($query) {
            $query->orderByDesc('id');
        })
        ->when($sort === 'terlama', function ($query) {
            $query->orderBy('id');
        })
        ->when($sort === 'az', function ($query) {
            $query->orderBy('judul_buku');
        })
        ->when($sort === 'za', function ($query) {
            $query->orderByDesc('judul_buku');
        })
        ->paginate(8)
        ->withQueryString();

    $kategoris = Kategori::orderBy('nama_kategori')->get();

    return view('katalog-admin', compact('bukus', 'kategoris', 'search', 'kategori', 'sort'));
    }

    public function indexAdmin(Request $request)
    {
        $search = $request->query('search');
        $kategori = $request->query('kategori');
        $status = $request->query('status');

        $bukus = Buku::with(['kategori', 'rak'])
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('judul_buku', 'like', "%{$search}%")
                        ->orWhere('penulis', 'like', "%{$search}%")
                        ->orWhere('isbn', 'like', "%{$search}%");
                });
            })
            ->when($kategori, function ($query) use ($kategori) {
                $query->where('kategori_id', $kategori);
            })
            ->when($status, function ($query) use ($status) {
                $query->where('status_buku', $status);
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $kategoris = Kategori::orderBy('nama_kategori')->get();
        $raks = Rak::orderBy('kode_rak')->get();

        return view('kelola-buku', compact('bukus', 'kategoris', 'raks', 'search', 'kategori', 'status'));
    }

    public function create()
    {
        $kategoris = Kategori::orderBy('nama_kategori')->get();
        $raks = Rak::orderBy('kode_rak')->get();

        return view('tambah-buku', compact('kategoris', 'raks'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul_buku' => ['required', 'string', 'max:150'],
            'isbn' => ['nullable', 'string', 'max:30', 'unique:bukus,isbn'],
            'tahun_terbit' => ['nullable', 'integer', 'min:1900', 'max:' . date('Y')],
            'penulis' => ['required', 'string', 'max:100'],
            'penerbit' => ['nullable', 'string', 'max:100'],
            'kategori_id' => ['required', 'exists:kategoris,id'],
            'rak_id' => ['nullable', 'exists:raks,id'],
            'stok_total' => ['required', 'integer', 'min:0'],
            'stok_tersedia' => ['nullable', 'integer', 'min:0'],
            'nomor_panggil' => ['nullable', 'string', 'max:50'],
            'sinopsis' => ['nullable', 'string'],
            'cover' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        $validated['stok_tersedia'] = $validated['stok_tersedia'] ?? $validated['stok_total'];
        $validated['status_buku'] = $this->hitungStatusBuku($validated['stok_tersedia']);

        if ($request->hasFile('cover')) {
            $validated['cover'] = $request->file('cover')->store('covers', 'public');
        }

        Buku::create($validated);

        return redirect()
            ->route('buku.index')
            ->with('success', 'Data buku berhasil ditambahkan.');
    }

    public function show(Buku $buku)
    {
        $buku->load(['kategori', 'rak']);

        return view('informasi-buku', compact('buku'));
    }

    public function showAdmin(Buku $buku)
    {
        $buku->load(['kategori', 'rak']);

        return view('informasi-buku-admin', compact('buku'));
    }

    public function edit(Buku $buku)
    {
        $buku->load(['kategori', 'rak']);

        $kategoris = Kategori::orderBy('nama_kategori')->get();
        $raks = Rak::orderBy('kode_rak')->get();

        return view('edit-buku', compact('buku', 'kategoris', 'raks'));
    }

    public function update(Request $request, Buku $buku)
    {
        $validated = $request->validate([
            'judul_buku' => ['required', 'string', 'max:150'],
            'isbn' => [
                'nullable',
                'string',
                'max:30',
                Rule::unique('bukus', 'isbn')->ignore($buku->id),
            ],
            'tahun_terbit' => ['nullable', 'integer', 'min:1900', 'max:' . date('Y')],
            'penulis' => ['required', 'string', 'max:100'],
            'penerbit' => ['nullable', 'string', 'max:100'],
            'kategori_id' => ['required', 'exists:kategoris,id'],
            'rak_id' => ['nullable', 'exists:raks,id'],
            'stok_total' => ['required', 'integer', 'min:0'],
            'stok_tersedia' => ['nullable', 'integer', 'min:0'],
            'nomor_panggil' => ['nullable', 'string', 'max:50'],
            'sinopsis' => ['nullable', 'string'],
            'cover' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        $validated['stok_tersedia'] = $validated['stok_tersedia'] ?? $buku->stok_tersedia;
        $validated['status_buku'] = $this->hitungStatusBuku($validated['stok_tersedia']);

        if ($request->hasFile('cover')) {
            if ($buku->cover) {
                Storage::disk('public')->delete($buku->cover);
            }

            $validated['cover'] = $request->file('cover')->store('covers', 'public');
        }

        $buku->update($validated);

        return redirect()
            ->route('buku.index')
            ->with('success', 'Data buku berhasil diperbarui.');
    }

    public function destroy(Buku $buku)
    {
        if ($buku->detailTransaksis()->exists()) {
            return redirect()
                ->route('buku.index')
                ->with('error', 'Buku tidak bisa dihapus karena sudah memiliki riwayat transaksi.');
        }

        if ($buku->cover) {
            Storage::disk('public')->delete($buku->cover);
        }

        $buku->delete();

        return redirect()
            ->route('buku.index')
            ->with('success', 'Data buku berhasil dihapus.');
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