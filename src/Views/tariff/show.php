<?php

require __DIR__ . '/../../../vendor/autoload.php';

$heading = 'Show tariff page';

?>

<div class="tariff-detail">
    <div class="detail-info">
        <h3><?= htmlspecialchars($model['name']) ?></h3>
        <p class="tariff-speed">Скорость Интернета: до <?= htmlspecialchars($model['speed']) ?> Мбит/с</p>
        <p class="tariff-description"><?= htmlspecialchars($model['description']) ?></p>
        <p class="tariff-price">Стоимость: <?= htmlspecialchars($model['price']) ?> ₽/мес</p>
        <a href="/tariffs/edit/<?= urlencode($model['id']) ?>" class="btn">Изменить тариф</a>
    </div>
    <div class="logo-container" style="width: 50%;">
        <img src="/<?= $model['logo'] ?>" alt="logo">
    </div>
</div>

