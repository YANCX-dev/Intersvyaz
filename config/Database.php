<?php

namespace App\Config;

use PDOException;
use PDO;

class Database
{
    private static ?PDO $pdo = null;
    private string $dsn;

    /**
     * @param string $dsn
     */
    public function __construct(string $dsn = '')
    {
        $this->dsn = $dsn ?: 'sqlite:' . __DIR__ . '/../storage/database.sqlite';
    }

    /**
     * @return PDO
     */
    public function connect(): PDO
    {
        if (self::$pdo === null) {

            try {

                self::$pdo = new PDO($this->dsn);

                self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                self::$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

            } catch (PDOException $e) {

                throw new PDOException($e->getMessage());

            }
        }
        return self::$pdo;
    }


    /**
     * @param string $dsn
     * @return static
     */
    public static function instance(string $dsn = ''): static
    {
        return new static($dsn);
    }

    /**
     * @return void
     */
    public static function disconnect(): void
    {
        self::$pdo = null;
    }

}