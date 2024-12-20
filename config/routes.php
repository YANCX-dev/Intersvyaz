<?php

use App\Controllers\TariffController;

return new class {

    /**
     * @return void
     */
    public function handleRequest(): void
    {
        $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        switch ($path) {
            case '/':
                (new TariffController())->index();
                break;
            case '/tariffs/edit':
                (new TariffController())->edit();
                break;
            case '/tariffs/update':
                (new TariffController())->update();
                break;
            default:
                http_response_code(404);
                echo '404 Not Found';
        }
    }

};