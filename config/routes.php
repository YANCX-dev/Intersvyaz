<?php

use App\Controllers\TariffController;

return new class {


    public function handleRequest(): string
    {
        $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        switch ($path) {
            case '/':
                $controller = new TariffController();
                $viewPath = $controller->index();
                break;
            case '/tariffs/edit':
                $controller = new TariffController();
                $viewPath = $controller->edit();
                break;
//            case '/tariffs/update':
//                (new TariffController())->update();
//                break;
            default:
                http_response_code(404);
                echo '404 Not Found';
        }

        if (empty($viewPath)) {
            throw new RuntimeException("No view returned for path: $path");
        }

        return $viewPath;
    }

};