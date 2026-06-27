<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bukus', function (Blueprint $table) {
            $table->id();

            $table->foreignId('kategori_id')
                ->nullable()
                ->constrained('kategoris')
                ->nullOnDelete();

            $table->foreignId('rak_id')
                ->nullable()
                ->constrained('raks')
                ->nullOnDelete();

            $table->string('judul_buku', 150);
            $table->string('penulis', 100);
            $table->string('penerbit', 100)->nullable();
            $table->year('tahun_terbit')->nullable();
            $table->string('isbn', 30)->nullable()->unique();
            $table->string('nomor_panggil', 50)->nullable();

            $table->unsignedInteger('stok_total')->default(0);
            $table->unsignedInteger('stok_tersedia')->default(0);

            $table->enum('status_buku', ['tersedia', 'stok_sedikit', 'tidak_tersedia'])
                ->default('tersedia');

            $table->text('sinopsis')->nullable();
            $table->string('cover')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bukus');
    }
};