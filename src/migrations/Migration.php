<?php

namespace App\migrations;

use App\Config\Database;
use App\Helpers\SqlHelper;
use PDO;

abstract class Migration
{
    private PDO $pdo;

    /**
     * @var string Path to sql file
     */
    protected string $filename;

    public function __construct($pdo = '')
    {
        if (empty($pdo)) {
            $pdo = Database::instance()->connect();
        }
        $this->pdo = $pdo;
    }

    /**
     * @return void
     */
    public function executeMigration(): void
    {
        try {

            $pathToSql = __DIR__ . "/../migrations/sqls/{$this->filename}";

            $query = SqlHelper::getSqlQuery($pathToSql);

            $result = $this->pdo->exec($query);

            if ($result === false) {
                throw new \Exception("SQL query failed to execute");
            }

        } catch (\Exception $e) {

            throw new \RuntimeException("Erorr crating table" . $e->getMessage(), 0, $e);

        }


    }
}