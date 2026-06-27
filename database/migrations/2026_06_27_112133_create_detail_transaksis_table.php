<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('detail_transaksis', function (Blueprint $table) {
            $table->id();

            $table->foreignId('transaksi_id')
                ->constrained('transaksis')
                ->cascadeOnDelete();

            $table->foreignId('buku_id')
                ->constrained('bukus')
                ->restrictOnDelete();

            $table->unsignedInteger('jumlah')->default(1);

            $table->enum('status_item', ['dipinjam', 'terlambat', 'dikembalikan'])
                ->default('dipinjam');

            $table->date('tanggal_kembali_item')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('detail_transaksis');
    }
};