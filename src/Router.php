<?php

namespace App;

class Router
{
//    Пока оставил, может быть понадобится
    public string $route;
    public string $method;
    public array $handler;

    public function __construct($method, $route, $handler)
    {
        $this->method = $method;
        $this->route = $route;
        $this->handler = $handler;
    }
}