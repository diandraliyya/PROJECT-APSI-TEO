<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailTransaksi extends Model
{
    protected $fillable = [
        'transaksi_id',
        'buku_id',
        'jumlah',
        'status_item',
        'tanggal_kembali_item',
    ];

    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class);
    }

    public function buku()
    {
        return $this->belongsTo(Buku::class);
    }

    public function denda()
    {
        return $this->hasOne(Denda::class);
    }
}