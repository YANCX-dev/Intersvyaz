<?php

namespace App\Controllers;


class TariffController
{

    /**
     * @param string $view
     * @return string
     */
    private function getViewPath(string $view): string
    {
        $baseDir = __DIR__ . '/../Views/';
        $viewPath = $baseDir . $view . '.php';

        if (!file_exists($viewPath)) {
            http_response_code(404);
            throw new \RuntimeException("View file not found: $viewPath");
        }

        return $viewPath;
    }

    /**
     * @return string
     */
    public function index(): string
    {
        return $this->getViewPath('tariff/index');
    }

    /**
     * @return string
     */
    public function edit(): string
    {
        return $this->getViewPath('tariff/edit');
    }

}

