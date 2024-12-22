<?php

$heading = 'Tariff index page';

?>

<form action="/tariffs/update" method="POST">
    <input type="hidden" name="id" value="<?= htmlspecialchars($tariff['id']) ?>">
    <label for="name">Название:</label>
    <input type="text" id="name" name="name" value="<?= htmlspecialchars($tariff['name']) ?>" required>

    <label for="speed">Скорость (Мбит/с):</label>
    <input type="number" id="speed" name="speed" value="<?= htmlspecialchars($tariff['speed']) ?>" required>

    <label for="description">Описание:</label>
    <textarea id="description" name="description" required><?= htmlspecialchars($tariff['description']) ?></textarea>

    <label for="price">Стоимость (₽):</label>
    <input type="number" id="price" name="price" value="<?= htmlspecialchars($tariff['price']) ?>" required>

    <button type="submit">Сохранить изменения</button>
</form>