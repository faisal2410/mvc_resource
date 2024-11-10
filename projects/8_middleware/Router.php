<?php
// Routing System using Basic PHP
class Router
{
    private array $routes = [];

    public function addRoute(string $method, string $pattern, callable $handler)
    {
        $this->routes[$method][$pattern] = $handler;
    }

    public function dispatch(string $method, string $uri)
    {
        foreach ($this->routes[$method] as $pattern => $handler) {
            if (preg_match($this->convertPattern($pattern), $uri, $params)) {
                return $handler(...array_values($params));
            }
        }
        throw new Exception("No route matched.");
    }

    private function convertPattern(string $pattern): string
    {
        return '#^' . preg_replace('/\{(\w+)\}/', '(?P<\1>[^/]+)', $pattern) . '$#';
    }
}

// Example of defining nested and parameterized routes
$router = new Router();
$router->addRoute('GET', '/users/{userId}/posts/{postId}', function ($userId, $postId) {
    echo "User ID: $userId, Post ID: $postId";
});
