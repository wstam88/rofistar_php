<?php 

$templateString = "Hello, {{name:string}}! how are ya @ {{date:date}}";
$jsonArray = ["name" => "Stone Little"];

function split_vars($part) {
    return explode(":", $part);
}

preg_match_all("~{{([^}]*)}}~", $templateString, $parts);

$parts = array_map('split_vars', $parts[1]);

print_r($parts);

$result = preg_replace_callback('~{{([^}]*)}}~', function ($m) use ($jsonArray) {
    return isset($jsonArray[$m[1]]) ? $jsonArray[$m[1]] : '';
}, $templateString);

print_r($result);