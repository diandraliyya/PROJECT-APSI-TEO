<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    protected $fillable = [
        'nama_admin',
        'username',
        'password',
        'email',
        'no_hp',
        'status_admin',
    ];

    protected $hidden = [
        'password',
    ];

    public function anggotas()
    {
        return $this->hasMany(Anggota::class);
    }

    public function transaksis()
    {
        return $this->hasMany(Transaksi::class);
    }

    public function pembayaranDendas()
    {
        return $this->hasMany(PembayaranDenda::class);
    }

    public function laporans()
    {
        return $this->hasMany(Laporan::class);
    }
}