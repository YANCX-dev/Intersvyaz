<?php

namespace App\Models\Tariff;

use App\Config\Database;
use App\Helpers\SqlHelper;
use Exception;
use PDO;

class Tariff
{
    private PDO $pdo;

    public function __construct($pdo = '')
    {
        if (empty($pdo)) {
            $pdo = Database::instance()->connect();
            $this->pdo = $pdo;
        } else {
            $this->pdo = $pdo;
        }

    }

    public function createTable(): void
    {
        try {

            $query = SqlHelper::getSqlQuery('createTariffsTable', 'Models', 'Tariff');

            $stmt = $this->pdo->prepare($query);

            $stmt->execute();

        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function getAllTariffs()
    {
//        $query = SqlHelper::getSqlQuery('getAllTariffs', 'Tariff');
//        $stmt = $this->pdo->query($query);
//        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}