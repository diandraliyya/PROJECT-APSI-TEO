<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Anggota extends Model
{
    protected $fillable = [
        'admin_id',
        'no_anggota',
        'nis',
        'nama_anggota',
        'kelas',
        'username',
        'password',
        'email',
        'no_hp',
        'alamat',
        'foto',
        'tanggal_daftar',
        'status_pendaftaran',
        'status_anggota',
    ];

    protected $hidden = [
        'password',
    ];

    protected $appends = ['foto_url'];

    public function getFotoUrlAttribute()
    {
        if (!$this->foto) {
            return null;
        }

        if (Str::startsWith($this->foto, ['http://', 'https://'])) {
            return $this->foto;
        }

        if (Str::startsWith($this->foto, 'assets/')) {
            return asset($this->foto);
        }

        return asset('storage/' . ltrim($this->foto, '/'));
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }

    public function transaksis()
    {
        return $this->hasMany(Transaksi::class);
    }

    public function dendas()
    {
        return $this->hasMany(Denda::class);
    }
}