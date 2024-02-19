<?php
session_start();

// Utwórz losową liczbę dla CAPTCHA
$captcha_number = rand(1000, 9999);

// Zapisz wygenerowaną liczbę do sesji
$_SESSION['captcha_number'] = $captcha_number;

// Ustaw szerokość i wysokość obrazu CAPTCHA
$image_width = 200;
$image_height = 50;

// Utwórz obraz CAPTCHA
$image = imagecreatetruecolor($image_width, $image_height);

// Ustaw kolor tła i kolor tekstu
$background_color = imagecolorallocate($image, 255, 255, 255);
$text_color = imagecolorallocate($image, 0, 0, 0);

// Wypełnij tło obrazu
imagefilledrectangle($image, 0, 0, $image_width, $image_height, $background_color);

// Dodaj losowe linie na obrazie CAPTCHA
for ($i = 0; $i < 10; $i++) {
    imageline($image, mt_rand(0, $image_width), mt_rand(0, $image_height), mt_rand(0, $image_width), mt_rand(0, $image_height), $text_color);
}

// Dodaj tekst CAPTCHA z większą czcionką
$font_size = 30; // Rozmiar czcionki
$x = 50; // Pozycja x
$y = 40; // Pozycja y
$font_path = __DIR__ . '/font1.ttf'; // Ścieżka do pliku czcionki
imagettftext($image, $font_size, 0, $x, $y, $text_color, $font_path, $captcha_number);

// Ustaw nagłówek Content-Type
header('Content-type: image/png');

// Wyświetl obraz CAPTCHA
imagepng($image);

// Zwolnij zasoby obrazu
imagedestroy($image);
?>
