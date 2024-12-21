<?php

namespace App\Controllers;

class BaseController
{
    /**
     * @param string $view
     * @return string
     */
    protected function getViewPath(string $view): string
    {
        $baseDir = __DIR__ . '/../Views/';
        $viewPath = $baseDir . $view . '.php';

        if (!file_exists($viewPath)) {
            http_response_code(404);
            throw new \RuntimeException("View file not found: $viewPath");
        }

        return $viewPath;
    }
}