<?php
// Middleware Interface
interface Middleware
{
    public function handle(Request $request, Closure $next);
}

// Logging Middleware
class LoggingMiddleware implements Middleware
{
    public function handle(Request $request, Closure $next)
    {
        error_log("Request received: " . $request->getPath());
        return $next($request);
    }
}

// Authentication Middleware
class AuthMiddleware implements Middleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!$request->isAuthenticated()) {
            throw new Exception("Unauthorized access.");
        }
        return $next($request);
    }
}

// Middleware stack execution
function handleRequest(Request $request, array $middlewares, Closure $coreHandler)
{
    $pipeline = array_reduce(array_reverse($middlewares), function ($next, $middleware) {
        return fn($request) => $middleware->handle($request, $next);
    }, $coreHandler);

    return $pipeline($request);
}
