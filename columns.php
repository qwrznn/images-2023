<?php

include_once 'students.php';
$result = [];
for ($i = 0; $i < count($students); $i++) {
    $result[] = (int) round(array_sum($students[$i]["marks"]) / count($students[$i]["marks"]));
}

$stat = array_count_values($result);
// // Количество столбцов диаграммы:
$columns = count($stat);
// print_r($columns);
// print_r($stat);
// Задаем щирину и высоту всего изображения
$width = 300;
$height = 200;
// Задаем пространство между колонками:
$padding = 5;
// Получаем ширину одной колонки:
$column_width = $width / $columns;
// Создаем переменные
$im = imagecreate($width, $height);
$gray = imagecolorallocate($im, 0xcc, 0xcc, 0xcc);
$gray_lite = imagecolorallocate($im, 0xee, 0xee, 0xee);
$gray_dark = imagecolorallocate($im, 0x7f, 0x7f, 0x7f);
$white = imagecolorallocate($im, 0xff, 0xff, 0xff);
$darkgray = imagecolorallocate($im, 0x90, 0x90, 0x90);
$navy = imagecolorallocate($im, 0x00, 0x00, 0x80);
$darknavy = imagecolorallocate($im, 0x00, 0x00, 0x50);
$red = imagecolorallocate($im, 0xFF, 0x00, 0x00);
$darkred = imagecolorallocate($im, 0x90, 0x00, 0x00);
// Заполняем фон картинки
imagefilledrectangle($im, 0, 0, $width, $height, $white);
$maxv = 0;
// Вычисляем максимум
for ($i = 0; $i < $columns; $i++) {
    $maxv = max($result[$i], $maxv);
}
// Рисуем каждую колонку
// for ($i = 0; $i < $columns; $i++) {
$i = 0;
foreach ($stat as $key => $value) {
    $column_height = ($height / 100) * (($result[$i] / $maxv) * 100);
    $x1 = $i * $column_width;
    $y1 = $height - $column_height;
    $x2 = (($i + 1) * $column_width) - $padding;
    $y2 = $height;
    $colors = [5 => $navy, 4 => $red, 3 => $gray, 2 => $darkred];
    imagefilledrectangle($im, $x1, $y1, $x2, $y2, $colors[$key]);
    $i++;
}
// }

// Посылаем информацию заголовку, можно заменить на JPEG или GIF
header("Content-type: image/png");
imagepng($im);
