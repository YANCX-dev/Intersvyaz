<?php

namespace App\Models\Tariff;

use App\Config\Database;
use App\Helpers\SqlHelper;
use App\Models\Model as BaseModel;
use Exception;
use PDO;

class Tariff extends BaseModel
{
    public function getTariffs(): array
    {
        $queryPath = __DIR__ . '/sqls/getAllTariffs.sql';

        $query = SqlHelper::getSqlQuery($queryPath);

        $stmt = $this->pdo->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTariffById($id): array
    {
        $queryPath = __DIR__ . '/sqls/getTariffById.sql';

        $query = SqlHelper::getSqlQuery($queryPath);

        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
