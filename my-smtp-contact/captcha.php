<?php

session_start();

// Tworzenie losowego ciągu znaków dla captchy
$captchaString = substr(md5(mt_rand()), 0, 5);

// Zapisywanie ciągu w sesji
$_SESSION['captcha'] = $captchaString;

// Tworzenie obrazka
$image = imagecreatetruecolor(150, 50);

// Kolor tła
$bgColor = imagecolorallocate($image, 255, 255, 255);

// Kolor tekstu
$textColor = imagecolorallocate($image, mt_rand(0, 100), mt_rand(0, 100), mt_rand(0, 100));

// Wypełnienie tłem
imagefill($image, 0, 0, $bgColor);

// Dodanie szumów w tle
for ($i = 0; $i < 30; $i++) {
    $noiseColor = imagecolorallocate($image, mt_rand(0, 255), mt_rand(0, 255), mt_rand(0, 255));
    imagesetpixel($image, mt_rand(0, 150), mt_rand(0, 50), $noiseColor);
    imageline($image, mt_rand(0, 150), mt_rand(0, 50), mt_rand(0, 150), mt_rand(0, 50), $noiseColor);
}

// Dodanie tekstu na obrazek
imagestring($image, 30, 60, 15, $captchaString, $textColor);

// Ustawienie nagłówka
header('Content-Type: image/png');

// Wyświetlenie obrazka
imagepng($image);

// Zwolnienie zasobów
imagedestroy($image);

?>
