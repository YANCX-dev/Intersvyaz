<div class="save-tools">
    <form action="/tariffs/export" method="GET">
        <button type="submit" class="export-btn">Экспортировать в CSV</button>
    </form>
    <form action="/tariffs/import" method="POST" enctype="multipart/form-data">
        <label for="csv_file">Выберите CSV файл:</label>
        <input type="file" id="csv_file" name="csv_file" accept=".csv" required>
        <button type="submit" class="import-btn">Импортировать</button>
    </form>
</div>