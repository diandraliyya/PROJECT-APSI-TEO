<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Denda extends Model
{
    protected $fillable = [
        'anggota_id',
        'detail_transaksi_id',
        'jumlah_hari_terlambat',
        'tarif_per_hari',
        'total_denda',
        'status_denda',
        'tanggal_denda',
    ];

    public function anggota()
    {
        return $this->belongsTo(Anggota::class);
    }

    public function detailTransaksi()
    {
        return $this->belongsTo(DetailTransaksi::class);
    }

    public function pembayaranDendas()
    {
        return $this->hasMany(PembayaranDenda::class);
    }
}