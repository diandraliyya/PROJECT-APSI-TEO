<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();

            $table->decimal('tarif_denda_per_hari', 10, 2)->default(1000);
            $table->unsignedInteger('maksimal_hari_pinjam')->default(7);

            $table->string('nama_perpustakaan', 100)->default('SMAIT Al-Uswah Library');
            $table->string('email_perpustakaan', 100)->nullable();
            $table->string('telepon_perpustakaan', 30)->nullable();
            $table->text('alamat_perpustakaan')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};