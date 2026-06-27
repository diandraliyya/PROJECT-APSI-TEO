<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PembayaranDenda extends Model
{
    protected $fillable = [
        'denda_id',
        'admin_id',
        'tanggal_pembayaran',
        'nominal_bayar',
        'metode_pembayaran',
        'status_validasi',
        'keterangan',
    ];

    public function denda()
    {
        return $this->belongsTo(Denda::class);
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }
}