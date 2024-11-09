<?php
/*

Here's a detailed script for your screencast video on "Mastering Routing in MVC with PHP". This script will guide you through explaining the concept of routing in an MVC architecture and building a basic routing mechanism. Given your knowledge, we'll use PHP OOP principles, adhere to SOLID principles, and integrate clean code practices.

Title: Mastering Routing in MVC with PHP
Agenda
Introduction to Routing in MVC
Understanding the Concept of Routing in MVC
Setting Up a Basic Routing Mechanism in PHP
Building and Testing Routes
Conclusion
Script
1. Introduction to Routing in MVC
Welcome message and purpose:

"Hello, everyone! Welcome to today’s screencast. In this session, we’re diving into Routing in MVC—a critical component that helps our applications handle different URL requests efficiently. By the end of this session, you'll not only understand the core concept of routing but also build a basic routing mechanism in PHP."

2. Understanding the Concept of Routing in MVC
Define Routing: "In an MVC framework, routing is the process of mapping incoming URL requests to the right controller and action method. It serves as a bridge between the user request and the server's response, making sure each URL directs the user to the correct page or function."

Purpose of Routing:

"Routing enables clean, user-friendly URLs."
"It abstracts URL structure from implementation details, improving maintainability and scalability."
Diagram Overview (if using visuals):

"Imagine we have different pages like ‘/home’, ‘/about’, and ‘/products’. The router intercepts these requests and directs them to the appropriate controller and action within our MVC architecture."
3. Setting Up a Basic Routing Mechanism in PHP
3.1 File Structure

"Let’s set up a simple file structure for our routing mechanism. Here’s how our MVC framework will be organized:"

lua
Copy code
/my_mvc_project
|-- /controllers
|   |-- HomeController.php
|   |-- ProductController.php
|
|-- /views
|   |-- home.php
|   |-- products.php
|
|-- /models
|
|-- /core
|   |-- Router.php
|
|-- index.php
3.2 Creating the Router Class

"Let's begin by creating a Router.php class in our /core directory. This class will handle registering routes and matching incoming requests."

Code Example:
php
Copy code
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
Explanation:
"addRoute method registers a new route with an HTTP method, URL path, and a callback."
"dispatch method checks if any registered route matches the current request method and path."
4. Building and Testing Routes
4.1 Registering Routes in index.php

"Now that we have our Router class, let's use it in index.php to register some routes and test our routing."

Code Example:
php
Copy code
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
Explanation:
"Here, we're creating an instance of Router, registering routes with controllers and actions, and finally calling dispatch() with the current HTTP method and URI."
"We’re using array syntax [new ControllerClass(), 'methodName'] to specify a controller and its action."
4.2 Building Controllers

"Next, let’s create basic controller classes, HomeController and ProductController, to handle the logic for these routes."

Code Example:
php
Copy code
<?php
// controllers/HomeController.php

class HomeController
{
    public function index()
    {
        echo "Welcome to the Home Page!";
    }
}
php
Copy code
<?php
// controllers/ProductController.php

class ProductController
{
    public function list()
    {
        echo "Product List";
    }

    public function view()
    {
        echo "View Product";
    }
}
Explanation:
"Each method here corresponds to a route’s action. When we access /products, the list method of ProductController will be invoked."
"This setup follows SOLID principles by separating responsibilities among classes."
4.3 Testing the Routes

"Now, start a local server using PHP’s built-in server to test our routes."
bash
Copy code
php -S localhost:8000
Demo:
"Access http://localhost:8000/ to see the Home Page response."
"Navigate to http://localhost:8000/products to see the Product List."
"Similarly, try other routes to verify they’re working as expected."
5. Conclusion
Recap: "In this session, we covered the basics of routing in an MVC structure, set up a router class, registered routes, and linked them to controllers."

Next Steps: "You can extend this router to include features like dynamic parameters, middleware, or more complex route handling."

This script is ready for recording, and each section includes a detailed code walkthrough and explanations to ensure your audience understands both the concept and the code behind routing in MVC.


*/ 