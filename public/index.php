<?php

use App\Config\Routing\Routes;

ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../vendor/autoload.php';

$router = new Routes();
$response = $router->handleRequest();

if (!array_key_exists('errors', $response)) {
    if (isset($response[0]) || isset($response[1])) {
        [$view, $data] = $response;
    }

} else {
    foreach ($response['errors'] as $error) {
        echo $error . '<br>';
    }
    echo '<a href="/" style="font-size: 30px">' . 'Go back' . '</a>';
}


function dd($args)
{
    echo '<pre>';
    var_dump($args);
    echo '</pre>';
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

if (!empty($view)) {
    renderView($view, $data);
}


