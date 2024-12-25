<?php
$pathToStyles = '/styles/style.css';
//$scriptPath = $_SERVER['DOCUMENT_ROOT'] . '/../scripts/js/updateTariff.js';
$scriptPath = 'scripts/js/updateTariff.js';
$scriptPathUploadImage = 'scripts/js/uploadImage.js';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Тарифы</title>
    <link rel="stylesheet" href="<?= $pathToStyles ?>">
</head>
<body>
<header>
    <a href="/" class="logo">Интерсвязь</a>
    <nav>
        <ul class="menu">
            <li><a href="/">Главная</a></li>
            <li><a href="/csvtools">Загрузка/Выгрузка тарифов</a></li>
        </ul>
    </nav>
</header>
