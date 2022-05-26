<?php
require 'vendor/autoload.php';

$bargen = new Picqer\Barcode\BarcodeGeneratorPNG();
$text = '3awoR0VXJ2Oam4V';

echo '<img src="data:image/png;base64,' . base64_encode($bargen->getBarcode($text, $bargen::TYPE_CODE_128, 1, 50)) . '">';