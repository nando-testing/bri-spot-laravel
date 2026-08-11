<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LwDebitur extends Model
{
    use HasFactory;

    protected $table = 'lw_debiturs';

    protected $fillable = [
        'periode',
        'kanca',
        'nomor_rekening',
        'nama_debitur',
        'jenis_pinjaman',
        'plafon',
        'balance',
        'rate',
        'tgl_realisasi',
        'tgl_jatuh_tempo',
        'jangka_waktu',
        'kol_adk',
        'pn_pengelola',
    ];
}
