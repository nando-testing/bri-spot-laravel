<?php

$zip = new ZipArchive();
if ($zip->open('lw_debitur.xlsx') === TRUE) {
    if (($sheetStr = $zip->getFromName('xl/worksheets/sheet1.xml')) !== FALSE) {
        $xml = simplexml_load_string($sheetStr);
        foreach ($xml->sheetData->row as $row) {
            $rNum = (int)$row['r'];
            if ($rNum <= 8) {
                $rowData = [];
                foreach ($row->c as $cell) {
                    $ref = (string)$cell['r'];
                    $type = (string)$cell['t'];
                    $val = '';
                    if ($type === 'inlineStr' && isset($cell->is->t)) {
                        $val = (string)$cell->is->t;
                    } else if (isset($cell->v)) {
                        $val = (string)$cell->v;
                    }
                    if ($val !== '') {
                        $rowData[$ref] = $val;
                    }
                }
                echo "ROW {$rNum}: " . json_encode($rowData, JSON_UNESCAPED_UNICODE) . "\n\n";
            }
        }
    }
    $zip->close();
}
