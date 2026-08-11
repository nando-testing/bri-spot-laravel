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
        
        LwDebitur::truncate(); // Clear previous sample records
        
        $count = 0;
        foreach ($xml->sheetData->row as $row) {
            $rNum = (int)$row['r'];
            if ($rNum < 5) continue; // Skip title and headers (rows 1-4)
            
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

            if (empty($rowData['L']) || empty($rowData['K'])) continue; // Must have debitur name & account number

            LwDebitur::create([
                'periode' => $rowData['B'] ?? '',
                'kanca' => $rowData['F'] ?? ($rowData['H'] ?? 'KC Jember'),
                'nomor_rekening' => $rowData['K'] ?? '',
                'nama_debitur' => $rowData['L'] ?? '',
                'jenis_pinjaman' => $rowData['AH'] ?? ($rowData['J'] ?? 'KPR'),
                'plafon' => floatval($rowData['M'] ?? 0),
                'balance' => floatval($rowData['AW'] ?? ($rowData['W'] ?? 0)),
                'rate' => floatval($rowData['P'] ?? 0),
                'tgl_realisasi' => $rowData['R'] ?? '',
                'tgl_jatuh_tempo' => $rowData['S'] ?? '',
                'jangka_waktu' => $rowData['T'] ?? '',
                'kol_adk' => $rowData['AK'] ?? '1',
                'pn_pengelola' => $rowData['AL'] ?? '',
            ]);

            $count++;
            if ($count >= 20) break; // Ambil 20 data saja dari excel untuk uji coba
        }
        
        echo "Berhasil mengimpor {$count} data master debitur dari lw_debitur.xlsx ke MariaDB!\n";
    }
    $zip->close();
} else {
    echo "Gagal membuka file lw_debitur.xlsx.\n";
}
