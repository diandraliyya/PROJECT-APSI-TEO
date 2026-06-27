<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Laporan extends Model
{
    protected $fillable = [
        'admin_id',
        'jenis_laporan',
        'periode_awal',
        'periode_akhir',
        'format_laporan',
        'tanggal_cetak',
    ];

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }
}