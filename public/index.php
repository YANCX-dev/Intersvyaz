<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../vendor/autoload.php';

$router = require_once __DIR__ . '/../config/routes.php';

$view = $router->handleRequest();

$uri = $_SERVER['REQUEST_URI'];

function renderView(string $viewPath): void
{
    require_once __DIR__ . '/../src/Views/inc/header.view.php';
    require_once $viewPath;
    require_once __DIR__ . '/../src/Views/inc/footer.view.php';
}

renderView($view);

