<?php

namespace App\Helpers;

class SqlHelper
{

    /**
     * @param $pathToFile
     * @return string
     * @throws \Exception
     */
    public static function getSqlQuery($pathToFile): string
    {

        if (!file_exists($pathToFile)) {
            throw new \Exception("Sql file not found");
        }

        $query = file_get_contents($pathToFile);

        if ($query === false || trim($query) === "") {
            throw new \Exception("SQL file is empty or could not be read: {$pathToFile}");
        }

        return $query;
    }
}