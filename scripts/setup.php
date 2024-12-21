<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Config\Database;
use App\migrations\TariffMigration;

try {
    $migrations = [
        TariffMigration::class,
    ];

    foreach ($migrations as $migrationClass) {
        $migrations = new $migrationClass();
        $migrations->executeMigration();
        echo "Successful created migrations.\n";
    }

} catch (Exception $e) {
    echo $e->getMessage() . "\n";
}