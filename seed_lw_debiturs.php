<?php

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\LwDebitur;

$zip = new ZipArchive();
if ($zip->open('lw_debitur.xlsx') === TRUE) {
    if (($sheetStr = $zip->getFromName('xl/worksheets/sheet1.xml')) !== FALSE) {
        $xml = simplexml_load_string($sheetStr);
        
        LwDebitur::truncate(); // Reset data
        
        $count = 0;
        foreach ($xml->sheetData->row as $row) {
            $rNum = (int)$row['r'];
            if ($rNum < 5) continue; // Skip header row 1-4
            
            $rowData = [];
            foreach ($row->c as $cell) {
                $ref = preg_replace('/[0-9]/', '', (string)$cell['r']);
                $type = (string)$cell['t'];
                $val = '';
                if ($type === 'inlineStr' && isset($cell->is->t)) {
                    $val = (string)$cell->is->t;
                } else if (isset($cell->v)) {
                    $val = (string)$cell->v;
                }
                $rowData[$ref] = trim($val);
            }

            if (empty($rowData['L']) || empty($rowData['K'])) continue; // Filter baris kosong

            LwDebitur::create([
                'periode' => $rowData['B'] ?? '',
                'kode_kanwil' => $rowData['C'] ?? '',
                'kanwil' => $rowData['D'] ?? '',
                'kode_kanca' => $rowData['E'] ?? '',
                'kanca' => $rowData['F'] ?? '',
                'kode_uker' => $rowData['G'] ?? '',
                'uker' => $rowData['H'] ?? '',
                'currency' => $rowData['I'] ?? 'IDR',
                'ln_type' => $rowData['J'] ?? '',
                'nomor_rekening' => $rowData['K'] ?? '',
                'nama_debitur' => $rowData['L'] ?? '',
                'plafon' => floatval($rowData['M'] ?? 0),
                'next_pmt_date' => $rowData['N'] ?? '',
                'next_int_pmt_date' => $rowData['O'] ?? '',
                'rate' => floatval($rowData['P'] ?? 0),
                'tgl_menunggak' => $rowData['Q'] ?? '',
                'tgl_realisasi' => $rowData['R'] ?? '',
                'tgl_jatuh_tempo' => $rowData['S'] ?? '',
                'jangka_waktu' => $rowData['T'] ?? '',
                'flag_restruk' => $rowData['U'] ?? '',
                'cifno' => $rowData['V'] ?? '',
                'kolektabilitas_lancar' => floatval($rowData['W'] ?? 0),
                'kolektabilitas_dpk' => floatval($rowData['X'] ?? 0),
                'kolektabilitas_kurang_lancar' => floatval($rowData['Y'] ?? 0),
                'kolektabilitas_diragukan' => floatval($rowData['Z'] ?? 0),
                'kolektabilitas_macet' => floatval($rowData['AA'] ?? 0),
                'tunggakan_pokok' => floatval($rowData['AB'] ?? 0),
                'tunggakan_bunga' => floatval($rowData['AC'] ?? 0),
                'tunggakan_pinalti' => floatval($rowData['AD'] ?? 0),
                'freq_payment' => $rowData['AE'] ?? '',
                'freq_int_payment' => $rowData['AF'] ?? '',
                'code' => $rowData['AG'] ?? '',
                'description' => $rowData['AH'] ?? '',
                'segmen_lv1' => $rowData['AI'] ?? '',
                'desc_segmen_lv1' => $rowData['AJ'] ?? '',
                'kol_adk' => $rowData['AK'] ?? '',
                'pn_pengelola_singlepn' => $rowData['AL'] ?? '',
                'pn_pengelola_1' => $rowData['AM'] ?? '',
                'pn_pemrakarsa' => $rowData['AN'] ?? '',
                'pn_referral' => $rowData['AO'] ?? '',
                'pn_restruk' => $rowData['AP'] ?? '',
                'pn_pengelola_2' => $rowData['AQ'] ?? '',
                'pn_pemutus' => $rowData['AR'] ?? '',
                'pn_crm' => $rowData['AS'] ?? '',
                'pn_rm_referral_naik_segmentasi' => $rowData['AT'] ?? '',
                'pn_rm_crr' => $rowData['AU'] ?? '',
                'plafon_dalam_idr' => floatval($rowData['AV'] ?? 0),
                'balance_dalam_idr' => floatval($rowData['AW'] ?? 0),
            ]);

            $count++;
            if ($count >= 20) break; // Ambil 20 data sampel dari Excel
        }
        
        echo "Berhasil mengimpor {$count} data master debitur LENGKAP DENGAN 48 KOLOM ke MariaDB!\n";
    }
    $zip->close();
} else {
    echo "Gagal membuka file lw_debitur.xlsx.\n";
}
