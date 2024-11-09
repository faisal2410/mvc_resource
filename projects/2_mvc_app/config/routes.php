<?php
$controller = $_GET['controller'] ?? 'home';
$action = $_GET['action'] ?? 'index';

$controllerClass = 'App\\Controllers\\' . ucfirst($controller) . 'Controller';

if (class_exists($controllerClass) && method_exists($controllerClass, $action)) {
    $controllerInstance = new $controllerClass();
    $controllerInstance->$action();
} else {
    echo "404 Not Found";
}
