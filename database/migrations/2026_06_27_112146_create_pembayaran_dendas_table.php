<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pembayaran_dendas', function (Blueprint $table) {
            $table->id();

            $table->foreignId('denda_id')
                ->constrained('dendas')
                ->cascadeOnDelete();

            $table->foreignId('admin_id')
                ->nullable()
                ->constrained('admins')
                ->nullOnDelete();

            $table->date('tanggal_pembayaran');
            $table->decimal('nominal_bayar', 10, 2);

            $table->enum('metode_pembayaran', ['tunai', 'transfer', 'qris', 'lainnya'])
                ->default('tunai');

            $table->enum('status_validasi', ['menunggu', 'valid', 'ditolak'])
                ->default('valid');

            $table->text('keterangan')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pembayaran_dendas');
    }
};