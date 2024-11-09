<?php
// index.php

require_once 'core/Router.php';
require_once 'controllers/HomeController.php';
require_once 'controllers/ProductController.php';

$router = new Router();

// Register routes
$router->addRoute('GET', '/', [new HomeController(), 'index']);
$router->addRoute('GET', '/products', [new ProductController(), 'list']);
$router->addRoute('GET', '/products/view', [new ProductController(), 'view']);

$method = $_SERVER['REQUEST_METHOD'];
$path = $_SERVER['REQUEST_URI'];

$router->dispatch($method, $path);
