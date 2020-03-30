<?php

function getDirContents($dir, &$results = array()) {
    $files = scandir($dir);

    foreach ($files as $key => $value) {
        $path = realpath($dir . DIRECTORY_SEPARATOR . $value);
        if (!is_dir($path)) {
            $results[] = $path;
        } else if ($value != "." && $value != "..") {
            getDirContents($path, $results);
            $results[] = $path;
        }
    }

    return $results;
}

var_dump(getDirContents('./'));

// array (size=12)
//   0 => string '/xampp/htdocs/WORK/iframe.html' (length=30)
//   1 => string '/xampp/htdocs/WORK/index.html' (length=29)
//   2 => string '/xampp/htdocs/WORK/js' (length=21)
//   3 => string '/xampp/htdocs/WORK/js/btwn.js' (length=29)
//   4 => string '/xampp/htdocs/WORK/js/qunit' (length=27)
//   5 => string '/xampp/htdocs/WORK/js/qunit/qunit.css' (length=37)
//   6 => string '/xampp/htdocs/WORK/js/qunit/qunit.js' (length=36)
//   7 => string '/xampp/htdocs/WORK/js/unit-test.js' (length=34)
//   8 => string '/xampp/htdocs/WORK/xxxxx.js' (length=30)
//   9 => string '/xampp/htdocs/WORK/plane.png' (length=28)
//   10 => string '/xampp/htdocs/WORK/qunit.html' (length=29)
//   11 => string '/xampp/htdocs/WORK/styles.less' (length=30)