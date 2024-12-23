<?php

namespace App\Models\Tariff;

use App\Config\Database;
use App\Helpers\SqlHelper;
use App\Models\Model as BaseModel;
use Exception;
use PDO;

class Tariff extends BaseModel
{
    /**
     * @return array
     * @throws Exception
     */
    public function getTariffs(): array
    {
        $queryPath = __DIR__ . '/sqls/getAllTariffs.sql';

        $query = SqlHelper::getSqlQuery($queryPath);

        $stmt = $this->pdo->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * @param $id
     * @return array
     * @throws Exception
     */
    public function getTariffById($id): array
    {
        $queryPath = __DIR__ . '/sqls/getTariffById.sql';

        $query = SqlHelper::getSqlQuery($queryPath);

        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * @param $id
     * @param array $data
     * @return bool
     */
    public function updateTariffById($id, array $data): bool
    {
        $queryPath = __DIR__ . '/sqls/updateTariffById.sql';

        $query = SqlHelper::getSqlQuery($queryPath);

        $stmt = $this->pdo->prepare($query);


        return $stmt->execute([
            'id' => $id,
            'name' => $data['name'],
            'description' => $data['description'],
            'price' => $data['price'],
            'expires_at' => $data['expires_at'],
            'created_at' => $data['created_at'],
            'speed' => $data['speed'],
            'logo' => $data['logo'] ?? null,
        ]);
    }


}
