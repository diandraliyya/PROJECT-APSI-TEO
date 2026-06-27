<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $fillable = [
        'anggota_id',
        'admin_id',
        'kode_transaksi',
        'tanggal_pinjam',
        'tanggal_jatuh_tempo',
        'tanggal_kembali',
        'status_transaksi',
        'total_item',
        'catatan',
    ];

    public function anggota()
    {
        return $this->belongsTo(Anggota::class);
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }

    public function detailTransaksis()
    {
        return $this->hasMany(DetailTransaksi::class);
    }
}