<?php

$heading = 'Tariff index page';

?>

<form action="/tariffs/update" method="POST" class="editForm">
    <input type="hidden" name="id" value="<?= htmlspecialchars($tariff['id']) ?>">
    <label for="name">Название:</label>
    <input type="text" id="name" name="name" value="<?= htmlspecialchars($tariff['name']) ?>" required>

    <label for="speed">Скорость (Мбит/с):</label>
    <input type="number" id="speed" name="speed" value="<?= htmlspecialchars($tariff['speed']) ?>" required>

    <label for="description">Описание:</label>
    <textarea id="description" name="description" required><?= htmlspecialchars($tariff['description']) ?></textarea>

    <label for="price">Стоимость (₽):</label>
    <input type="number" id="price" name="price" value="<?= htmlspecialchars($tariff['price']) ?>" required>

    <label for="created_at">Дата подключения:</label>
    <input type="date" id="created_at" name="created_at" value="<?= htmlspecialchars($tariff['created_at']) ?>"
           required>

    <label for="expires_at">Дата окончания тарифа:</label>
    <input type="date" id="expires_at" name="expires_at" value="<?= htmlspecialchars($tariff['expires_at']) ?>"
           required>

    <label for="logo">Логотип:</label>
    <input type="file" id="logo" name="logo" accept="image/png, image/jpeg">

    <button type="submit">Сохранить изменения</button>
</form>
