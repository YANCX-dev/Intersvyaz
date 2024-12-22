<?php

use App\Config\Routing\Routes;

ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../vendor/autoload.php';

$router = new Routes();
[$view, $data] = $router->handleRequest();

function renderView(string $viewPath, array $data): void
{
    require_once __DIR__ . '/../src/Views/inc/header.view.php';
    ob_start();
    extract($data);
    require_once $viewPath;
    ob_end_flush();
    require_once __DIR__ . '/../src/Views/inc/footer.view.php';
}

renderView($view, $data);

