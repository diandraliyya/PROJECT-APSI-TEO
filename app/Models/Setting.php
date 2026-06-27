<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
        'tarif_denda_per_hari',
        'maksimal_hari_pinjam',
        'nama_perpustakaan',
        'email_perpustakaan',
        'telepon_perpustakaan',
        'alamat_perpustakaan',
    ];
}