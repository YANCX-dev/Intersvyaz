<?php

namespace App\Controllers;

use App\Config\Database;
use App\Models\Tariff\Tariff;

class TariffController
{
    public function index(): void
    {
       $database = Database::instance();

       $pdo = $database->connect();

       $tariffModel = new Tariff($pdo);

       $tariffModel->createTable();
    }
}