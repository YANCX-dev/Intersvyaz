<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

use App\Models\Tariff\Tariff;

require_once __DIR__ . '/../vendor/autoload.php';

//require_once __DIR__ . '/../config/bootstrap.php';

$router = require_once __DIR__ . '/../config/routes.php';

$tariff = new Tariff();

$tariff->createTable();

