<?php

use App\Config\Routing\Routes;

ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../vendor/autoload.php';

$router = new Routes();
$response = $router->handleRequest();

if (is_array($response) && count($response) > 0) {
    [$view, $data] = $response;
}
function renderView(string $viewPath, array $data): void
{
    require_once __DIR__ . '/../src/Views/inc/header.view.php';
    ob_start();
    extract($data);
    require_once $viewPath;
    ob_end_flush();
    require_once __DIR__ . '/../src/Views/inc/footer.view.php';
}

if (!empty($view) && !empty($data)) {
    renderView($view, $data);
}


