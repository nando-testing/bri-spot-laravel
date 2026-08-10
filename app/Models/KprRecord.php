<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KprRecord extends Model
{
    use HasFactory;

    protected $table = 'kpr_records';

    protected $fillable = [
        'tanggal',
        'jabatan_petugas',
        'nama_petugas',
        'nama_rm_penanggung_jawab',
        'nama_developer',
        'nama_debitur',
        'jenis_kpr',
        'plafon_kredit',
        'unit_block',
        'status',
        'nomor_rekening',
    ];

    /**
     * Helper memeriksa wewenang RM secara ketat pada model
     */
    public function isAssignedToRm($user)
    {
        if (!$user) return false;
        $loggedName = strtolower(trim($user->name));
        $rmPj = strtolower(trim($this->nama_rm_penanggung_jawab ?? ''));
        $petugas = strtolower(trim($this->nama_petugas ?? ''));

        $cleanLogged = preg_replace('/,?\s*(s\.e\.|s\.h\.|s\.t\.|m\.m\.)/i', '', $loggedName);
        $cleanRmPj = preg_replace('/,?\s*(s\.e\.|s\.h\.|s\.t\.|m\.m\.)/i', '', $rmPj);
        $cleanPetugas = preg_replace('/,?\s*(s\.e\.|s\.h\.|s\.t\.|m\.m\.)/i', '', $petugas);

        $firstNameLogged = explode(' ', $cleanLogged)[0] ?? '';

        $matchesRmPj = $cleanRmPj && (
            str_contains($cleanRmPj, $cleanLogged) ||
            str_contains($cleanLogged, $cleanRmPj) ||
            ($firstNameLogged && str_contains($cleanRmPj, $firstNameLogged))
        );

        $matchesPetugas = $cleanPetugas && (
            str_contains($cleanPetugas, $cleanLogged) ||
            str_contains($cleanLogged, $cleanPetugas) ||
            ($firstNameLogged && str_contains($cleanPetugas, $firstNameLogged))
        );

        return $matchesRmPj || $matchesPetugas;
    }

    /**
     * Memeriksa apakah user berwenang MENGEDIT berkas ini
     */
    public function canEdit($user)
    {
        if (!$user) return false;
        $role = $user->role ?? 'SO';

        if ($role === 'Super Admin') {
            return true;
        }

        if ($role === 'Developer Perumahan') {
            return false; // Strictly Read-Only Monitoring
        }

        if ($role === 'SO') {
            // SO dapat mengedit berkas buatan sendiri atau berkas di tahap Collect Data & Proses RM
            $isCreator = strtolower(trim($this->nama_petugas)) === strtolower(trim($user->name));
            $isInitialStage = in_array($this->status, ['Collect Data', 'Proses RM']);
            return $isCreator || $isInitialStage;
        }

        if ($role === 'RM') {
            // RM HANYA berwenang mengedit berkas yang ditugaskan di bawah namanya
            return $this->isAssignedToRm($user);
        }

        if ($role === 'CBM') {
            // CBM berwenang mengedit berkas pada tahap verifikasi CBM
            return in_array($this->status, ['Proses RM Diterima', 'Verifikasi CBM', 'Proses Akad ADK']);
        }

        if ($role === 'ADK') {
            // ADK berwenang mengedit berkas pada tahap akad & input nomor rekening pinjaman
            return in_array($this->status, ['Verifikasi CBM', 'Proses Akad ADK', 'Input Nomor Rekening Pinjaman']);
        }

        return false;
    }

    /**
     * Memeriksa apakah user berwenang MENGHAPUS berkas ini
     */
    public function canDelete($user)
    {
        if (!$user) return false;
        $role = $user->role ?? 'SO';

        if ($role === 'Super Admin') {
            return true;
        }

        if ($role === 'Developer Perumahan') {
            return false; // Strictly Read-Only
        }

        if ($role === 'SO') {
            // SO hanya dapat menghapus berkas yang didaftarkan oleh SO tersebut pada tahap Collect Data / Proses RM
            $isCreator = strtolower(trim($this->nama_petugas)) === strtolower(trim($user->name));
            $isInitialStage = in_array($this->status, ['Collect Data', 'Proses RM']);
            return $isCreator && $isInitialStage;
        }

        if ($role === 'RM') {
            // RM HANYA dapat menghapus berkas milik dirinya sendiri
            return $this->isAssignedToRm($user);
        }

        if ($role === 'CBM' || $role === 'ADK') {
            // CBM dan ADK bertugas memverifikasi/mengisi akad, tidak untuk menghapus berkas dari master
            return false;
        }

        return false;
    }

    /**
     * Pesan penjelasan alasan pembatasan edit/hapus
     */
    public function getRestrictionReason($user)
    {
        if (!$user) return "Tidak terautentikasi.";
        $role = $user->role ?? 'SO';

        if ($role === 'Developer Perumahan') {
            return "Role Developer Perumahan hanya memiliki akses Monitoring (Read-Only).";
        }

        if ($role === 'RM') {
            return "RM {$user->name} hanya berwenang mengelola berkas yang ditugaskan di bawah namanya ({$this->nama_rm_penanggung_jawab}).";
        }

        if ($role === 'SO') {
            return "SO {$user->name} hanya berwenang mengelola berkas pendaftaran sendiri di tahap awal.";
        }

        if ($role === 'CBM') {
            return "CBM hanya berwenang mengedit berkas pada tahap verifikasi CBM.";
        }

        if ($role === 'ADK') {
            return "ADK hanya berwenang mengedit berkas pada tahap proses akad & nomor rekening.";
        }

        return "Anda tidak memiliki hak akses untuk mengelola berkas ini.";
    }
}
