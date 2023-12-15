<?php
include_once 'students.php';

$image = imagecreatetruecolor(100, 100);
$white = imagecolorallocate($image, 0xFF, 0xFF, 0xFF);
$gray = imagecolorallocate($image, 0xC0, 0xC0, 0xC0);
$darkgray = imagecolorallocate($image, 0x90, 0x90, 0x90);
$navy = imagecolorallocate($image, 0x00, 0x00, 0x80);
$darknavy = imagecolorallocate($image, 0x00, 0x00, 0x50);
$red = imagecolorallocate($image, 0xFF, 0x00, 0x00);
$darkred = imagecolorallocate($image, 0x90, 0x00, 0x00);
$result = [];
for ($i = 0; $i < count($students); $i++) {
    $result[] = (int) round(array_sum($students[$i]["marks"]) / count($students[$i]["marks"]));
}
$stat = array_count_values($result);
$a = 360 / count($students);

$corner = 90;
$colors = [5 => $red, 4 => $navy, 3 => $gray, 2 => $white];
foreach ($stat as $key => $value) {
    imagefilledarc($image, 50, 50, 100, 100, $corner, $corner + $a * $value, $colors[$key], IMG_ARC_PIE);
    $corner += $a * $value;
}

// вывод изображения
header('Content-type: image/png');
imagepng($image);
imagedestroy($image);
