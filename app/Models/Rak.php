<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rak extends Model
{
    protected $fillable = [
        'kode_rak',
        'lokasi',
        'deskripsi',
    ];

    public function bukus()
    {
        return $this->hasMany(Buku::class);
    }
}