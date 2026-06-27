<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dendas', function (Blueprint $table) {
            $table->id();

            $table->foreignId('anggota_id')
                ->constrained('anggotas')
                ->cascadeOnDelete();

            $table->foreignId('detail_transaksi_id')
                ->nullable()
                ->constrained('detail_transaksis')
                ->nullOnDelete();

            $table->unsignedInteger('jumlah_hari_terlambat')->default(0);
            $table->decimal('tarif_per_hari', 10, 2)->default(0);
            $table->decimal('total_denda', 10, 2)->default(0);

            $table->enum('status_denda', ['belum_lunas', 'lunas'])
                ->default('belum_lunas');

            $table->date('tanggal_denda');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dendas');
    }
};