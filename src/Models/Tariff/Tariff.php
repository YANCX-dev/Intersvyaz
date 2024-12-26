<?php

namespace App\Models\Tariff;

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

        try {
            $query = SqlHelper::getSqlQuery($queryPath);

            $stmt = $this->pdo->prepare($query);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }

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
                'created_at' => $data['created_at'],//Формат даты переделаю
                'speed' => $data['speed'],
            ];

            if (!array_key_exists('logo', $data)) {
                return $stmt->execute($params);
            }

            $params['logo'] = $data['logo'];

            return $stmt->execute($params);

        } catch (Exception) {
            return false;
        }
    }

    /**
     * @throws Exception
     */
    public function getAllTariffs(): array
    {
        $queryPath = __DIR__ . '/sqls/getAllTariffs.sql';

        try {
            $query = SqlHelper::getSqlQuery($queryPath);

            $stmt = $this->pdo->prepare($query);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function createTariff(array $data): bool
    {
        $queryPath = __DIR__ . '/sqls/createTariff.sql';

        $query = SqlHelper::getSqlQuery($queryPath);

        $stmt = $this->pdo->prepare($query);

        if ($this->unique($data['name'])) {
            return $stmt->execute([
                'name' => $data['name'],
                'description' => $data['description'],
                'price' => $data['price'],
                'speed' => $data['speed'],
                'created_at' => $data['created_at'],
                'expires_at' => $data['expires_at'],
                'logo' => $data['logo'] ?? null,
            ]);
        }

        return false;

    }

    /**
     * @param $value
     * @return bool
     * @throws Exception
     */
    protected function unique($value): bool
    {
        $queryPath = __DIR__ . '/sqls/unique.sql';
        $query = SqlHelper::getSqlQuery($queryPath);
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':value', $value);
        $stmt->execute();

        $temp = $stmt->fetchColumn();

        return !$temp;
    }
}
