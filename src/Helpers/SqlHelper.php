<?php

namespace App\Helpers;

class SqlHelper
{
    /**
     * @param string $filename
     * @param string $type
     * @return string
     * @throws \Exception
     */
    public static function getSqlQuery(string $filename,string $type,  string $modelName): string
    {
        $filePath = __DIR__ . "/../{$type}/{$modelName}/sqls/{$filename}.sql";

        if (!file_exists($filePath)) {
            throw new \Exception("Sql file not found");
        }

        $query = file_get_contents($filePath);

        if ($query === false || trim($query) === "") {
            throw new \Exception("SQL file is empty or could not be read: {$filePath}");
        }

        return $query;
    }
}