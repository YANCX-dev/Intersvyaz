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


    public function updateTariffById($id, array $data): bool
    {
        $queryPath = __DIR__ . '/sqls/updateTariffById.sql';

        try {
            $query = SqlHelper::getSqlQuery($queryPath);


            if (empty($data['logo'])) {
                $query = preg_replace('/,\s*logo\s*=\s*:logo/', '', $query);
            }

            $stmt = $this->pdo->prepare($query);

            $params = [
                'id' => $id,
                'name' => $data['name'],
                'description' => $data['description'],
                'price' => $data['price'],
                'expires_at' => $data['expires_at'],
                'created_at' => $data['created_at'],
                'speed' => $data['speed'],
            ];

            if (!array_key_exists('logo', $data)) {
                return $stmt->execute($params);
            }

            $params['logo'] = $data['logo'];

            return $stmt->execute($params);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    private function dd(mixed $args)
    {
        echo '<pre>';
        var_dump($args);
        echo '</pre>';
    }

}
