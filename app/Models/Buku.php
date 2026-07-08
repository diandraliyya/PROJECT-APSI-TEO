<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Buku extends Model
{
    protected $fillable = [
        'kategori_id',
        'rak_id',
        'judul_buku',
        'penulis',
        'penerbit',
        'tahun_terbit',
        'isbn',
        'nomor_panggil',
        'stok_total',
        'stok_tersedia',
        'status_buku',
        'sinopsis',
        'cover',
    ];

    protected $appends = ['cover_url'];

    public function getCoverUrlAttribute()
    {
        if (!$this->cover) {
            return asset('assets/icon buku.png');
        }

        if (Str::startsWith($this->cover, ['http://', 'https://'])) {
            return $this->cover;
        }

        if (Str::startsWith($this->cover, 'assets/')) {
            return asset($this->cover);
        }

        return asset('storage/' . ltrim($this->cover, '/'));
    }

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    public function rak()
    {
        return $this->belongsTo(Rak::class);
    }

    public function detailTransaksis()
    {
        return $this->hasMany(DetailTransaksi::class);
    }
}