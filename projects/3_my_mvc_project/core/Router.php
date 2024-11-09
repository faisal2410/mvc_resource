<?php
// core/Router.php

class Router
{
    private $routes = [];

    public function addRoute($method, $path, $callback)
    {
        $this->routes[] = [
            'method' => $method,
            'path' => $path,
            'callback' => $callback,
        ];
    }

    public function dispatch($method, $path)
    {
        foreach ($this->routes as $route) {
            if ($route['method'] === $method && $route['path'] === $path) {
                return call_user_func($route['callback']);
            }
        }
        http_response_code(404);
        echo "404 - Page Not Found";
    }
}
