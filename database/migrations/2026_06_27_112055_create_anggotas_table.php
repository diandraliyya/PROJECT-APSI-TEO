<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('anggotas', function (Blueprint $table) {
            $table->id();

            $table->foreignId('admin_id')
                ->nullable()
                ->constrained('admins')
                ->nullOnDelete();

            $table->string('no_anggota', 30)->nullable()->unique();
            $table->string('nis', 30)->unique();
            $table->string('nama_anggota', 100);
            $table->string('kelas', 50)->nullable();

            $table->string('username', 50)->unique();
            $table->string('password');
            $table->string('email', 100)->unique();
            $table->string('no_hp', 20)->nullable();
            $table->text('alamat')->nullable();
            $table->string('foto')->nullable();

            $table->date('tanggal_daftar')->nullable();

            $table->enum('status_pendaftaran', ['menunggu', 'disetujui', 'ditolak'])
                ->default('menunggu');

            $table->enum('status_anggota', ['aktif', 'nonaktif', 'lulus'])
                ->default('nonaktif');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('anggotas');
    }
};