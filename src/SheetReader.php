<?php

require_once __DIR__ . '/../vendor/autoload.php';
include_once __DIR__ . '/Rofi.php';

if ($xlsx = SimpleXLSX::parse(__DIR__ . '/../resources/sheets/php.xlsx')) {
    // actual sheet namesfrom xls file
    $sheets = $xlsx->sheetNames();

    // rofi menu arrays
    $sheet_list = [];
    $row_list = [];

    // create menu items for rofi sheet picker
    foreach ($sheets as $index => $sheet) {
        array_push($sheet_list, "$sheet <span lang='@$index'></span>");
    }

    // present sheet picker
    $sheets_picker = new Rofi($sheet_list);
    $sheet = $sheets_picker->openMenu();
    $sheet_index = preg_match_all("/lang='@(\d+)'/", $sheet, $sheet_match);

    // die if not set
    if (!isset($sheet_match[1]) || !isset($sheet_match[1][0])) {
        die;
    }

    // set rowsdepending on sheet index
    $rows = $xlsx->rows($sheet_match[1][0]);

    // create rofi menu items for row selector
    foreach ($rows as $r => $row) {
        array_push($row_list, "$row[0] <span lang='@$r'></span>");
    }

    // present row picker
    $options = new Rofi($row_list);
    $row = $options->openMenu();
    $index = preg_match_all("/lang='@(\d+)'/", $row, $match);

    // copy paste selected row data
    if (isset($match[1]) && isset($match[1][0])) {
        print_r($rows[$match[1][0]]);
        if(isset($rows[$match[1][0]][1]) && $rows[$match[1][0]][1]) {
            $options->copyPaste($rows[$match[1][0]][1]);
        } else {
            $options->copyPaste($rows[$match[1][0]][0]);
        }
        die;
    }
} else {
    echo SimpleXLSX::parseError();
}
