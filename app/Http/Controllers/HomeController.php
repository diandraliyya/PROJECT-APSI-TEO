<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Ambil 4 buku terpopuler (bisa berdasarkan stok yang paling banyak dipinjam)
        // Atau bisa juga berdasarkan yang terbaru
        $bukuPopuler = Buku::with(['kategori'])
            ->where('stok_total', '>', 0)
            ->orderByDesc('id')
            ->limit(4)
            ->get();

        return view('home', compact('bukuPopuler'));
    }
}