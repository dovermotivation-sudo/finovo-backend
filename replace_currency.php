<?php

$dir = new RecursiveDirectoryIterator(__DIR__ . '/resources/views');
$ite = new RecursiveIteratorIterator($dir);
$files = new RegexIterator($ite, '/.*\.blade\.php$/', RegexIterator::GET_MATCH);
$count = 0;

foreach($files as $file) {
    $path = $file[0];
    $content = file_get_contents($path);
    if (strpos($content, '₹') !== false) {
        $content = str_replace('₹', '$', $content);
        file_put_contents($path, $content);
        $count++;
    }
}

echo "Replaced ₹ with $ in $count files.";
