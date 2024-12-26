<?php

namespace App\Config\Routing;

use App\Controllers\TariffController;
use App\Models\Tariff\Tariff;

class Routes
{

    /** Обработка HTTP реквеста
     * @return array
     */
    public function handleRequest(): array|string
    {
        $path = parse_url($_SERVER['REQUEST_URI'])['path'];
        $method = $_SERVER['REQUEST_METHOD'];

        $routes = [
            'GET' => [
                '/' => fn() => (new TariffController())->index(),
                '/csvtools' => fn() => (new TariffController())->csvToolsPage(),
                '/tariffs/edit/{id}' => fn($params) => (new TariffController())->edit($params['id']),
                '/tariffs/show/{id}' => fn($params) => (new TariffController())->show($params['id']),
                '/tariffs/export' => fn() => (new TariffController())->exportTariffsToCSV(),
                '/tariffs/export-pdf' => fn() => (new TariffController())->exportTariffsToPDF(),
            ],
            'POST' => [
                '/tariffs/update' => fn() => (new TariffController())->update(),
                '/tariffs/import' => fn() => (new TariffController())->importTariffsFromCSV(),
            ],
        ];

        return $this->routeToController($method, $path, $routes);
    }


    /**
     * @param int $statusCode
     * @param array $errors
     * @return array
     */
    private function abort(int $statusCode = 404, array $errors = []): array
    {
        http_response_code($statusCode);
        $path = __DIR__ . "/../../src/Views/errors/{$statusCode}.view.php";

        if (!file_exists($path)) {
            http_response_code(500);
            return [
                __DIR__ . "/../../src/Views/errors/500.view.php",
                $errors,
            ];
        }

        return [$path, $errors];
    }

    /**
     * @param string $method
     * @param string $uri
     * @param array $routes
     * @return array|string
     */
    private function routeToController(string $method, string $uri, array $routes): array|string
    {
        if (!isset($routes[$method])) {
            return $this->abort(404);
        }

        if (isset($routes[$method][$uri])) {
            return call_user_func($routes[$method][$uri]);
        }

        foreach ($routes[$method] as $route => $controller) {
            $pattern = preg_replace('/\{(\w+)\}/', '(?P<$1>[^/]+)', $route);
            $pattern = '#^' . $pattern . '$#'; // Формируем регулярное выражение с ограничителями

            if (preg_match($pattern, $uri, $matches)) {

                if ($method === "POST") {
                    return call_user_func($controller);
                }

                $params = array_filter($matches, fn($key) => !is_int($key), ARRAY_FILTER_USE_KEY);

                return call_user_func($controller, $params);
            }
        }

        return $this->abort(404);
    }

    public function dd($args)
    {
        echo '<pre>';
        var_dump($args);
        echo '</pre>';
        die();
    }
}
