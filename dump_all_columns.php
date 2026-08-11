<?php

$zip = new ZipArchive();
if ($zip->open('lw_debitur.xlsx') === TRUE) {
    if (($sheetStr = $zip->getFromName('xl/worksheets/sheet1.xml')) !== FALSE) {
        $xml = simplexml_load_string($sheetStr);
        foreach ($xml->sheetData->row as $row) {
            $rNum = (int)$row['r'];
            if ($rNum == 4) { // Row 4 is header row
                $headers = [];
                foreach ($row->c as $cell) {
                    $ref = preg_replace('/[0-9]/', '', (string)$cell['r']);
                    $val = '';
                    if ((string)$cell['t'] === 'inlineStr' && isset($cell->is->t)) {
                        $val = (string)$cell->is->t;
                    } else if (isset($cell->v)) {
                        $val = (string)$cell->v;
                    }
                    $headers[$ref] = trim($val);
                }
                echo json_encode($headers, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
            }
        }
    }
    $zip->close();
}
