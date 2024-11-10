<?php
// Router with Middleware Integration
class Request
{
    private string $path;
    private bool $authenticated;

    public function __construct(string $path, bool $authenticated = false)
    {
        $this->path = $path;
        $this->authenticated = $authenticated;
    }

    public function getPath(): string
    {
        return $this->path;
    }
    public function isAuthenticated(): bool
    {
        return $this->authenticated;
    }
}

$router = new Router();
$router->addRoute('GET', '/dashboard', function () {
    echo "Welcome to the dashboard!";
});

$request = new Request('/dashboard', false); // Simulating an unauthenticated user
$middlewares = [
    new LoggingMiddleware(),
    new AuthMiddleware()
];

// Core handler for the route
$coreHandler = fn($request) => $router->dispatch('GET', $request->getPath());

try {
    handleRequest($request, $middlewares, $coreHandler);
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
