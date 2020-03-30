<?php

include_once __DIR__ . '/Rofi.php';

/**
 * Filter . and ..
 *
 * @param [type] $item
 * @return void
 */
function filter_files($item)
{
    return $item != '.' && $item != '..';
}


/**
 * Prompt 
 *
 * @param [type] $dir
 * @param array $results
 * @return void
 */
function getDirContents($dir, &$results = array())
{
    $files = scandir($dir);
    $files = array_filter($files, 'filter_files');

    foreach($files as $index=>$value) {

        $path = realpath($dir . DIRECTORY_SEPARATOR . $value);
        echo $value;

        if(is_dir($path)) {
            $files[$index] = "📁 $value";
        } else {
            $files[$index] = "📄 $value";
        }
    }

    $options = new Rofi($files);
    $value = $options->openMenu();
    $value = preg_replace("/📄\s/", "", $value);
    $value = preg_replace("/📁\s/", "", $value);

    $path = realpath($dir . DIRECTORY_SEPARATOR . $value);

    if (!$value || !$path) {
        die();
    } elseif (!is_dir($path)) {
        $content = file_get_contents($path);
        $options->copyPaste($content);
        die();
    } elseif ($value != '.' && $value != '..') {
        getDirContents($path, $results);
    } else {
        die();
    }
}


getDirContents(__DIR__ . '/../resources/snippets');
