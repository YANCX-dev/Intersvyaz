<?php

namespace App\migrations;

use App\migrations\Migration as BaseMigration;
use PDO;

class TariffMigration extends BaseMigration
{
    /**
     * @inheritdoc
     */
    protected string $filename = "create_tariffs_table.sql";


}
