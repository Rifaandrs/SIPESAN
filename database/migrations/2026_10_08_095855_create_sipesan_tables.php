<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Kategori Saran
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('deskripsi')->nullable();
            $table->timestamps();
        });

        // 2. Data Saran Eksternal
        Schema::create('sarans', function (Blueprint $table) {
            $table->id();
            $table->string('kode_saran')->unique();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('nama_pengirim');
            $table->string('kontak_pengirim');
            $table->string('status_pengirim'); // Orang Tua/Wali, Alumni, Masyarakat, Komite, Instansi, Lainnya
            $table->boolean('is_anonim')->default(false);
            $table->foreignId('category_id')->constrained('categories')->cascadeOnDelete();
            $table->string('judul');
            $table->text('isi');
            $table->string('lampiran')->nullable();
            $table->string('status')->default('Baru'); // Baru, Diterima, Sedang Diverifikasi, Dalam Proses Tindak Lanjut, Selesai, Ditolak
            $table->string('ditujukan_kepada')->nullable(); // Bagian Sarana dan Prasarana, dll
            $table->text('catatan_tindak_lanjut')->nullable();
            $table->timestamp('tanggal_tindak_lanjut')->nullable();
            $table->timestamps();
        });

        // 3. Riwayat / Log Perubahan Status Saran
        Schema::create('saran_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('saran_id')->constrained('sarans')->cascadeOnDelete();
            $table->string('status');
            $table->text('catatan')->nullable();
            $table->string('diperbarui_oleh')->default('Sistem');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('saran_histories');
        Schema::dropIfExists('sarans');
        Schema::dropIfExists('categories');
    }
};
