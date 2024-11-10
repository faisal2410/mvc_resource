<?php
/*
Title: Mastering Advanced Routing and Middleware in PHP for Dynamic and Secure Applications
Agenda
Introduction to Advanced Routing in PHP
Setting Up Nested and Parameterized Routes
Implementing Middleware for Cross-Cutting Concerns
Practical Demonstration: Using Middleware for Authentication and Logging
Summary and Best Practices
1. Introduction to Advanced Routing in PHP
Script:
“Welcome to this screencast on Advanced Routing and Middleware in PHP. Today, we’ll cover how to set up sophisticated routing with nested and parameterized routes to enhance the flexibility and organization of your PHP application. We'll then dive into middleware, which is key for handling cross-cutting concerns like authentication and logging.”

2. Setting Up Nested and Parameterized Routes
Explanation:
“Let’s begin by setting up a routing system with nested and parameterized routes. Advanced routing allows us to define routes with more specific patterns, such as routes that contain variables or have multiple layers of URL nesting.”

Example Code:

php
Copy code
// Routing System using Basic PHP
class Router {
    private array $routes = [];

    public function addRoute(string $method, string $pattern, callable $handler) {
        $this->routes[$method][$pattern] = $handler;
    }

    public function dispatch(string $method, string $uri) {
        foreach ($this->routes[$method] as $pattern => $handler) {
            if (preg_match($this->convertPattern($pattern), $uri, $params)) {
                return $handler(...array_values($params));
            }
        }
        throw new Exception("No route matched.");
    }

    private function convertPattern(string $pattern): string {
        return '#^' . preg_replace('/\{(\w+)\}/', '(?P<\1>[^/]+)', $pattern) . '$#';
    }
}

// Example of defining nested and parameterized routes
$router = new Router();
$router->addRoute('GET', '/users/{userId}/posts/{postId}', function($userId, $postId) {
    echo "User ID: $userId, Post ID: $postId";
});
Explanation:
“Here, we’re using a basic router that can handle parameterized routes. The route pattern /users/{userId}/posts/{postId} allows us to capture values for userId and postId from the URL. Our dispatch method matches the URL and passes the parameters to the route handler, enabling dynamic URL handling.”

3. Implementing Middleware for Cross-Cutting Concerns
Explanation:
“Middleware acts as a filter in the request-response cycle, handling tasks like authentication, logging, or cross-site request forgery (CSRF) protection. By creating middleware layers, we can keep our application’s core logic cleaner and more focused.”

Example Code:

php
Copy code
// Middleware Interface
interface Middleware {
    public function handle(Request $request, Closure $next);
}

// Logging Middleware
class LoggingMiddleware implements Middleware {
    public function handle(Request $request, Closure $next) {
        error_log("Request received: " . $request->getPath());
        return $next($request);
    }
}

// Authentication Middleware
class AuthMiddleware implements Middleware {
    public function handle(Request $request, Closure $next) {
        if (!$request->isAuthenticated()) {
            throw new Exception("Unauthorized access.");
        }
        return $next($request);
    }
}

// Middleware stack execution
function handleRequest(Request $request, array $middlewares, Closure $coreHandler) {
    $pipeline = array_reduce(array_reverse($middlewares), function ($next, $middleware) {
        return fn($request) => $middleware->handle($request, $next);
    }, $coreHandler);

    return $pipeline($request);
}
Explanation:
“Here, we define a Middleware interface and create LoggingMiddleware and AuthMiddleware classes. Each middleware class has a handle method, which performs an action on the request, like logging or authentication checks, before calling the next function. This enables a pipeline approach where multiple middlewares can process a request in a layered manner.”

4. Practical Demonstration: Using Middleware for Authentication and Logging
Example Code (Combining Router and Middleware):

php
Copy code
// Router with Middleware Integration
class Request {
    private string $path;
    private bool $authenticated;

    public function __construct(string $path, bool $authenticated = false) {
        $this->path = $path;
        $this->authenticated = $authenticated;
    }

    public function getPath(): string { return $this->path; }
    public function isAuthenticated(): bool { return $this->authenticated; }
}

$router = new Router();
$router->addRoute('GET', '/dashboard', function() {
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
Explanation:
“In this demonstration, we’ve combined routing and middleware. Here’s how it works:

We define a request to /dashboard and specify whether the user is authenticated.
A handleRequest function passes this request through our middleware pipeline, which includes logging and authentication checks.
If the user isn’t authenticated, an error message is shown, stopping the request before it reaches the route handler.”
5. Summary and Best Practices
Summary Script:
“To recap, we covered setting up advanced routing with nested and parameterized routes, allowing us to capture URL parameters and organize routes effectively. We then explored middleware as a means of handling common tasks that are best kept separate from route-specific logic. Using middleware, we created filters for logging and authentication, enhancing security and observability in the application.

When implementing advanced routing and middleware, remember:

Keep your routes organized by grouping related routes and using parameters where dynamic values are needed.
Apply middleware in layers to ensure that only necessary logic is applied at each step.
Handle exceptions gracefully in middleware and routes to maintain a smooth user experience.”


*/ 