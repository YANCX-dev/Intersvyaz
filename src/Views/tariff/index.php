<?php

$heading = 'Tariff index page';

?>


<div class="container">
    <h1>Тарифы</h1>
    <div class="tariff-grid">
        <?php foreach ($model as $tariff): ?>
            <div class="tariff-card">
                <h3><?= htmlspecialchars($tariff['name']) ?></h3>
                <p>Скорость Интернета: до <?= htmlspecialchars($tariff['speed']) ?> Мбит/с</p>
                <p><?= htmlspecialchars($tariff['description']) ?></p>
                <p>Стоимость: <?= htmlspecialchars($tariff['price']) ?> ₽/мес</p>
                <a href="/tariffs/show/<?= urlencode($tariff['id']) ?>" class="btn">Выбрать тариф</a>
            </div>
        <?php endforeach; ?>
    </div>
</div>

