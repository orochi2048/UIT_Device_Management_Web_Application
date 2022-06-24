<?php
require 'vendor/autoload.php';
require_once('./config.php');

$bargen = new Picqer\Barcode\BarcodeGeneratorSVG();

$bar_arr = array();
$bar_arr_len = 100;
for($x = 0; $x < $bar_arr_len; $x++) {
    $text = uniqid();
        
}

echo $bargen->getBarcode($text, $bargen::TYPE_CODE_128, 1, 80);