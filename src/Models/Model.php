<?php

namespace App\Models;

use App\Config\Database;
use PDO;

/** Базовый класс моделей */
abstract class Model
{
    /** @var PDO */
    protected PDO $pdo;

    /** Подключение к БД */
    public function __construct()
    {
        $this->pdo = Database::instance()->connect();
    }
}
