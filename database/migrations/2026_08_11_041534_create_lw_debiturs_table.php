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
        Schema::create('lw_debiturs', function (Blueprint $table) {
            $table->id();
            $table->string('periode')->nullable();
            $table->string('kanca')->nullable();
            $table->string('nomor_rekening')->nullable();
            $table->string('nama_debitur')->nullable();
            $table->string('jenis_pinjaman')->nullable();
            $table->decimal('plafon', 15, 2)->default(0);
            $table->decimal('balance', 15, 2)->default(0);
            $table->decimal('rate', 8, 4)->default(0);
            $table->string('tgl_realisasi')->nullable();
            $table->string('tgl_jatuh_tempo')->nullable();
            $table->string('jangka_waktu')->nullable();
            $table->string('kol_adk')->nullable();
            $table->string('pn_pengelola')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lw_debiturs');
    }
};
