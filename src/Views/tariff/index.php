<?php

$heading = 'Tariff index page';
$imagePath = '/uploads/tariff/logo_67699ae2899e28.33975035.jpg';
?>


<div class="container">
    <h1>Тарифы</h1>
    <div class="tariff-grid">
        <?php foreach ($model as $tariff): ?>
            <div class="tariff-card">
                <img alt="logo" src="<?= $tariff['logo'] ?>">
                <h3><?= htmlspecialchars($tariff['name']) ?></h3>
                <p>Скорость Интернета: до <?= htmlspecialchars($tariff['speed']) ?> Мбит/с</p>
                <p><?= htmlspecialchars($tariff['description']) ?></p>
                <p>Стоимость: <?= htmlspecialchars($tariff['price']) ?> ₽/мес</p>
                <a href="/tariffs/show/<?= urlencode($tariff['id']) ?>" class="btn">Выбрать тариф</a>
            </div>
        <?php endforeach; ?>
    </div>
</div>

