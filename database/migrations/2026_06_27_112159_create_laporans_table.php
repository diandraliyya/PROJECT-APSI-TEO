<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('laporans', function (Blueprint $table) {
            $table->id();

            $table->foreignId('admin_id')
                ->nullable()
                ->constrained('admins')
                ->nullOnDelete();

            $table->enum('jenis_laporan', [
                'peminjaman',
                'buku_terpopuler',
                'anggota_aktif',
                'denda'
            ]);

            $table->date('periode_awal')->nullable();
            $table->date('periode_akhir')->nullable();

            $table->enum('format_laporan', ['pdf', 'excel'])
                ->default('pdf');

            $table->timestamp('tanggal_cetak')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('laporans');
    }
};