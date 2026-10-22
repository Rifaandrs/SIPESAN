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
        Schema::table('sarans', function (Blueprint $table) {
            $table->string('nama_pengirim')->nullable()->default('Masyarakat')->change();
            $table->string('kontak_pengirim')->nullable()->default('-')->change();
            $table->string('status_pengirim')->nullable()->default('Masyarakat')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sarans', function (Blueprint $table) {
            $table->string('nama_pengirim')->nullable(false)->change();
            $table->string('kontak_pengirim')->nullable(false)->change();
            $table->string('status_pengirim')->nullable(false)->change();
        });
    }
};
