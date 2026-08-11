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
            $table->string('kode_kanwil')->nullable();
            $table->string('kanwil')->nullable();
            $table->string('kode_kanca')->nullable();
            $table->string('kanca')->nullable();
            $table->string('kode_uker')->nullable();
            $table->string('uker')->nullable();
            $table->string('currency')->nullable();
            $table->string('ln_type')->nullable();
            $table->string('nomor_rekening')->nullable();
            $table->string('nama_debitur')->nullable();
            $table->decimal('plafon', 18, 2)->default(0);
            $table->string('next_pmt_date')->nullable();
            $table->string('next_int_pmt_date')->nullable();
            $table->decimal('rate', 8, 4)->default(0);
            $table->string('tgl_menunggak')->nullable();
            $table->string('tgl_realisasi')->nullable();
            $table->string('tgl_jatuh_tempo')->nullable();
            $table->string('jangka_waktu')->nullable();
            $table->string('flag_restruk')->nullable();
            $table->string('cifno')->nullable();
            $table->decimal('kolektabilitas_lancar', 18, 2)->default(0);
            $table->decimal('kolektabilitas_dpk', 18, 2)->default(0);
            $table->decimal('kolektabilitas_kurang_lancar', 18, 2)->default(0);
            $table->decimal('kolektabilitas_diragukan', 18, 2)->default(0);
            $table->decimal('kolektabilitas_macet', 18, 2)->default(0);
            $table->decimal('tunggakan_pokok', 18, 2)->default(0);
            $table->decimal('tunggakan_bunga', 18, 2)->default(0);
            $table->decimal('tunggakan_pinalti', 18, 2)->default(0);
            $table->string('freq_payment')->nullable();
            $table->string('freq_int_payment')->nullable();
            $table->string('code')->nullable();
            $table->text('description')->nullable();
            $table->string('segmen_lv1')->nullable();
            $table->string('desc_segmen_lv1')->nullable();
            $table->string('kol_adk')->nullable();
            $table->string('pn_pengelola_singlepn')->nullable();
            $table->string('pn_pengelola_1')->nullable();
            $table->string('pn_pemrakarsa')->nullable();
            $table->string('pn_referral')->nullable();
            $table->string('pn_restruk')->nullable();
            $table->string('pn_pengelola_2')->nullable();
            $table->string('pn_pemutus')->nullable();
            $table->string('pn_crm')->nullable();
            $table->string('pn_rm_referral_naik_segmentasi')->nullable();
            $table->string('pn_rm_crr')->nullable();
            $table->decimal('plafon_dalam_idr', 18, 2)->default(0);
            $table->decimal('balance_dalam_idr', 18, 2)->default(0);
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
