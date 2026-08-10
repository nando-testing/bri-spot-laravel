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
        Schema::create('developers', function (Blueprint $table) {
            $table->id();
            $table->string('nama_developer')->unique();
            $table->timestamps();
        });

        Schema::create('kpr_records', function (Blueprint $table) {
            $table->id();
            $table->string('tanggal');
            $table->string('jabatan_petugas');
            $table->string('nama_petugas');
            $table->string('nama_rm_penanggung_jawab')->nullable();
            $table->string('nama_developer');
            $table->string('nama_debitur');
            $table->string('jenis_kpr')->default('KPR');
            $table->decimal('plafon_kredit', 15, 2);
            $table->string('unit_block');
            $table->string('status')->default('Collect Data');
            $table->string('nomor_rekening')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kpr_records');
        Schema::dropIfExists('developers');
    }
};
