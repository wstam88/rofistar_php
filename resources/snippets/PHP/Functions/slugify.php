<?php

function slugify($text)
{
    $text = preg_replace('~[^\pL\d]+~u', '-', $text);
    $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
    $text = preg_replace('~[^-\w]+~', '', $text);
    $text = preg_replace('~-+~', '-', $text);
    $text = strtolower($text);
    $text = trim($text, " \t\n\r\0\x0B-");
    if (empty($text)) {
        return 'n-a';
    }
    return $text;
}

echo slugify('Hello World'); // 'hello-world'
