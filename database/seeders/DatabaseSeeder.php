<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Developer;
use App\Models\KprRecord;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Seed 11 Default Users
        $users = [
            ['username' => 'admin', 'name' => 'Super Admin BRI', 'role' => 'Super Admin'],
            ['username' => 'budi_so', 'name' => 'Budi Santoso', 'role' => 'SO'],
            ['username' => 'fajri_so', 'name' => 'Fajri Kurniawan', 'role' => 'SO'],
            ['username' => 'dian_so', 'name' => 'Dian Permata', 'role' => 'SO'],
            ['username' => 'rina_rm', 'name' => 'Rina Wijaya, S.E.', 'role' => 'RM'],
            ['username' => 'doni_rm', 'name' => 'Doni Pratama, S.H.', 'role' => 'RM'],
            ['username' => 'ahmad_rm', 'name' => 'Ahmad Subagja, S.T.', 'role' => 'RM'],
            ['username' => 'hendra_cbm', 'name' => 'Hendra Gunawan', 'role' => 'CBM'],
            ['username' => 'maya_cbm', 'name' => 'Maya Indah, S.E.', 'role' => 'CBM'],
            ['username' => 'dewi_adk', 'name' => 'Dewi Lestari', 'role' => 'ADK'],
            ['username' => 'ciputra_dev', 'name' => 'PT. Ciputra Development', 'role' => 'Developer Perumahan'],
        ];

        foreach ($users as $u) {
            User::firstOrCreate(
                ['username' => $u['username']],
                [
                    'name' => $u['name'],
                    'password' => Hash::make('123456'),
                    'role' => $u['role'],
                ]
            );
        }

        // 2. Seed Master Developers
        $developers = [
            'PT Bentuyung Graha Perkasa', 'PT Ika Setya Agung Pratama', 'PT Bernady Sukses Grup',
            'PT Arsy Jaya Sentosa', 'PT Argopuro Karya Kencana', 'PT Bintang Indonesia Sentosa',
            'PT Moriz Propertindo', 'PT Cileungsi Graha Raya', 'PT Graha Cipta Sejahtera',
            'PT Bumi Cipta Sejahtera', 'PT Broca Sinergi', 'PT Sembilan Bintang Lestari',
            'PT Sintesa Citra Abadi', 'PT Indo Mitra Perkasa', 'PT. Ciputra Development',
            'PT. Summarecon Agung', 'PT. Pakuwon Jati', 'PT. Sinarmas Land',
            'PT. Jaya Real Property', 'PT. Agung Podomoro Land'
        ];

        foreach ($developers as $dev) {
            Developer::firstOrCreate(['nama_developer' => $dev]);
        }

        // 3. Seed 20 Clean Initial KPR Records
        $kprRecords = [
            ['tanggal' => '01/08/2026', 'jabatan_petugas' => 'SO', 'nama_petugas' => 'Budi Santoso', 'nama_rm_penanggung_jawab' => 'Rina Wijaya, S.E.', 'nama_developer' => 'PT. Ciputra Development', 'nama_debitur' => 'Budi Kurniawan', 'jenis_kpr' => 'KPR', 'plafon_kredit' => 450000000, 'unit_block' => 'Blok A1 No. 5', 'status' => 'Collect Data', 'nomor_rekening' => ''],
            ['tanggal' => '02/08/2026', 'jabatan_petugas' => 'RM', 'nama_petugas' => 'Rina Wijaya', 'nama_rm_penanggung_jawab' => 'Rina Wijaya, S.E.', 'nama_developer' => 'PT. Summarecon Agung', 'nama_debitur' => 'Siti Aminah', 'jenis_kpr' => 'KPRS', 'plafon_kredit' => 168000000, 'unit_block' => 'Blok C3 No. 12', 'status' => 'Proses RM', 'nomor_rekening' => ''],
            ['tanggal' => '03/08/2026', 'jabatan_petugas' => 'RM', 'nama_petugas' => 'Rina Wijaya', 'nama_rm_penanggung_jawab' => 'Rina Wijaya, S.E.', 'nama_developer' => 'PT. Pakuwon Jati', 'nama_debitur' => 'Hendra Setiawan', 'jenis_kpr' => 'KPRS', 'plafon_kredit' => 620000000, 'unit_block' => 'Blok B2 No. 8', 'status' => 'Proses RM Diterima', 'nomor_rekening' => ''],
            ['tanggal' => '04/08/2026', 'jabatan_petugas' => 'SO', 'nama_petugas' => 'Fajri Kurniawan', 'nama_rm_penanggung_jawab' => 'Doni Pratama, S.H.', 'nama_developer' => 'PT. Ciputra Development', 'nama_debitur' => 'Dewi Rahmawati', 'jenis_kpr' => 'KPR', 'plafon_kredit' => 550000000, 'unit_block' => 'Blok A2 No. 12', 'status' => 'Verifikasi CBM', 'nomor_rekening' => ''],
            ['tanggal' => '05/08/2026', 'jabatan_petugas' => 'SO', 'nama_petugas' => 'Dian Permata', 'nama_rm_penanggung_jawab' => 'Ahmad Subagja, S.T.', 'nama_developer' => 'PT. Jaya Real Property', 'nama_debitur' => 'Agus Susanto', 'jenis_kpr' => 'KPR', 'plafon_kredit' => 890000000, 'unit_block' => 'Blok E1 No. 2', 'status' => 'Proses Akad ADK', 'nomor_rekening' => ''],
            ['tanggal' => '06/08/2026', 'jabatan_petugas' => 'RM', 'nama_petugas' => 'Doni Pratama', 'nama_rm_penanggung_jawab' => 'Doni Pratama, S.H.', 'nama_developer' => 'PT. Agung Podomoro Land', 'nama_debitur' => 'Bambang Pamungkas', 'jenis_kpr' => 'KPR', 'plafon_kredit' => 550000000, 'unit_block' => 'Blok F4 No. 15', 'status' => 'Selesai', 'nomor_rekening' => '882-9401-2291'],
            ['tanggal' => '06/08/2026', 'jabatan_petugas' => 'SO', 'nama_petugas' => 'Budi Santoso', 'nama_rm_penanggung_jawab' => 'Rina Wijaya, S.E.', 'nama_developer' => 'PT. Ciputra Development', 'nama_debitur' => 'Eko Prasetyo', 'jenis_kpr' => 'KPRS', 'plafon_kredit' => 168000000, 'unit_block' => 'Blok A3 No. 8', 'status' => 'Proses RM', 'nomor_rekening' => ''],
            ['tanggal' => '07/08/2026', 'jabatan_petugas' => 'SO', 'nama_petugas' => 'Fajri Kurniawan', 'nama_rm_penanggung_jawab' => 'Doni Pratama, S.H.', 'nama_developer' => 'PT Ika Setya Agung Pratama', 'nama_debitur' => 'Fitri Handayani', 'jenis_kpr' => 'KPRS', 'plafon_kredit' => 520000000, 'unit_block' => 'Blok B1 No. 4', 'status' => 'Proses RM', 'nomor_rekening' => ''],
            ['tanggal' => '07/08/2026', 'jabatan_petugas' => 'RM', 'nama_petugas' => 'Ahmad Subagja', 'nama_rm_penanggung_jawab' => 'Ahmad Subagja, S.T.', 'nama_developer' => 'PT Bernady Sukses Grup', 'nama_debitur' => 'Giri Santoso', 'jenis_kpr' => 'KPR', 'plafon_kredit' => 750000000, 'unit_block' => 'Blok C5 No. 9', 'status' => 'Proses RM Diterima', 'nomor_rekening' => ''],
            ['tanggal' => '07/08/2026', 'jabatan_petugas' => 'SO', 'nama_petugas' => 'Dian Permata', 'nama_rm_penanggung_jawab' => 'Rina Wijaya, S.E.', 'nama_developer' => 'PT. Ciputra Development', 'nama_debitur' => 'Hardi Utomo', 'jenis_kpr' => 'KPR', 'plafon_kredit' => 420000000, 'unit_block' => 'Blok A4 No. 18', 'status' => 'Proses Akad ADK', 'nomor_rekening' => ''],
            ['tanggal' => '08/08/2026', 'jabatan_petugas' => 'SO', 'nama_petugas' => 'Budi Santoso', 'nama_rm_penanggung_jawab' => 'Ahmad Subagja, S.T.', 'nama_developer' => 'PT Argopuro Karya Kencana', 'nama_debitur' => 'Iwan Budiman', 'jenis_kpr' => 'KPR', 'plafon_kredit' => 680000000, 'unit_block' => 'Blok E3 No. 7', 'status' => 'Proses Akad ADK', 'nomor_rekening' => ''],
            ['tanggal' => '08/08/2026', 'jabatan_petugas' => 'RM', 'nama_petugas' => 'Rina Wijaya', 'nama_rm_penanggung_jawab' => 'Rina Wijaya, S.E.', 'nama_developer' => 'PT. Ciputra Development', 'nama_debitur' => 'Joko Sucipto', 'jenis_kpr' => 'KPR', 'plafon_kredit' => 910000000, 'unit_block' => 'Blok A5 No. 3', 'status' => 'Selesai', 'nomor_rekening' => '883-1092-3341'],
            ['tanggal' => '08/08/2026', 'jabatan_petugas' => 'SO', 'nama_petugas' => 'Fajri Kurniawan', 'nama_rm_penanggung_jawab' => 'Rina Wijaya, S.E.', 'nama_developer' => 'PT Moriz Propertindo', 'nama_debitur' => 'Kartika Sari', 'jenis_kpr' => 'KPRS', 'plafon_kredit' => 168000000, 'unit_block' => 'Blok G2 No. 11', 'status' => 'Collect Data', 'nomor_rekening' => ''],
            ['tanggal' => '08/08/2026', 'jabatan_petugas' => 'SO', 'nama_petugas' => 'Dian Permata', 'nama_rm_penanggung_jawab' => 'Doni Pratama, S.H.', 'nama_developer' => 'PT Cileungsi Graha Raya', 'nama_debitur' => 'Lukman Hakim', 'jenis_kpr' => 'KPRS', 'plafon_kredit' => 480000000, 'unit_block' => 'Blok H4 No. 6', 'status' => 'Proses RM', 'nomor_rekening' => ''],
            ['tanggal' => '08/08/2026', 'jabatan_petugas' => 'RM', 'nama_petugas' => 'Doni Pratama', 'nama_rm_penanggung_jawab' => 'Doni Pratama, S.H.', 'nama_developer' => 'PT Graha Cipta Sejahtera', 'nama_debitur' => 'Maya Indah', 'jenis_kpr' => 'KPR', 'plafon_kredit' => 630000000, 'unit_block' => 'Blok A3 No. 14', 'status' => 'Proses RM Diterima', 'nomor_rekening' => ''],
            ['tanggal' => '09/08/2026', 'jabatan_petugas' => 'SO', 'nama_petugas' => 'Budi Santoso', 'nama_rm_penanggung_jawab' => 'Doni Pratama, S.H.', 'nama_developer' => 'PT Bumi Cipta Sejahtera', 'nama_debitur' => 'Nugroho Saputra', 'jenis_kpr' => 'KPR', 'plafon_kredit' => 390000000, 'unit_block' => 'Blok B5 No. 22', 'status' => 'Verifikasi CBM', 'nomor_rekening' => ''],
            ['tanggal' => '09/08/2026', 'jabatan_petugas' => 'SO', 'nama_petugas' => 'Fajri Kurniawan', 'nama_rm_penanggung_jawab' => 'Ahmad Subagja, S.T.', 'nama_developer' => 'PT Broca Sinergi', 'nama_debitur' => 'Oki Setiawan', 'jenis_kpr' => 'KPR', 'plafon_kredit' => 820000000, 'unit_block' => 'Blok C2 No. 1', 'status' => 'Proses Akad ADK', 'nomor_rekening' => ''],
            ['tanggal' => '09/08/2026', 'jabatan_petugas' => 'RM', 'nama_petugas' => 'Ahmad Subagja', 'nama_rm_penanggung_jawab' => 'Ahmad Subagja, S.T.', 'nama_developer' => 'PT Sembilan Bintang Lestari', 'nama_debitur' => 'Prasetyo Wibowo', 'jenis_kpr' => 'KPR', 'plafon_kredit' => 720000000, 'unit_block' => 'Blok D1 No. 19', 'status' => 'Selesai', 'nomor_rekening' => '884-2910-4412'],
            ['tanggal' => '09/08/2026', 'jabatan_petugas' => 'SO', 'nama_petugas' => 'Dian Permata', 'nama_rm_penanggung_jawab' => 'Rina Wijaya, S.E.', 'nama_developer' => 'PT Sintesa Citra Abadi', 'nama_debitur' => 'Qori Hidayat', 'jenis_kpr' => 'KPRS', 'plafon_kredit' => 168000000, 'unit_block' => 'Blok E4 No. 8', 'status' => 'Collect Data', 'nomor_rekening' => ''],
            ['tanggal' => '09/08/2026', 'jabatan_petugas' => 'RM', 'nama_petugas' => 'Rina Wijaya', 'nama_rm_penanggung_jawab' => 'Rina Wijaya, S.E.', 'nama_developer' => 'PT Indo Mitra Perkasa', 'nama_debitur' => 'Rudi Ramadhan', 'jenis_kpr' => 'KPRS', 'plafon_kredit' => 590000000, 'unit_block' => 'Blok F2 No. 16', 'status' => 'Proses RM Diterima', 'nomor_rekening' => '']
        ];

        foreach ($kprRecords as $r) {
            KprRecord::firstOrCreate(
                ['nama_debitur' => $r['nama_debitur'], 'unit_block' => $r['unit_block']],
                $r
            );
        }
    }
}
