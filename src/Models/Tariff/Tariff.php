<?php

namespace App\Models\Tariff;

use App\Config\Database;
use App\Helpers\SqlHelper;
use Exception;
use PDO;

class Tariff
{
    /**
     * @var PDO|mixed|string
     */
    private PDO $pdo;

    /**
     * @param $pdo
     */
    public function __construct($pdo = '')
    {
        if (empty($pdo)) {
            $pdo = Database::instance()->connect();
            $this->pdo = $pdo;
        } else {
            $this->pdo = $pdo;
        }

    }

}