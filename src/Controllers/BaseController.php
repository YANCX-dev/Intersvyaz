<?php

namespace App\Controllers;

class BaseController
{
    /**
     * @param string $view
     * @param array $data
     * @return array
     */
    protected function getViewPath(string $view, array $data = []): array|null
    {
        $baseDir = __DIR__ . '/../Views/';
        $viewPath = $baseDir . $view . '.php';

        if (!file_exists($viewPath)) {
            http_response_code(404);
            throw new \RuntimeException("View file not found: $viewPath");
        }

        return [$viewPath, $data];
    }

    public function dd($args)
    {
        echo '<pre>';
        var_dump($args);
        echo '</pre>';
    }

}