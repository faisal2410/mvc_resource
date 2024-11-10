<?php
/*

Title: Understanding MVC and the Front Controller Pattern in PHP

Agenda:

What is the MVC Pattern?
Understanding the Front Controller Pattern
Creating a Central Entry Point (index.php) to Handle All Requests
Practical Code Example: Implementing MVC with a Front Controller
Recap and Summary
Script
Introduction

Hello, and welcome to this screencast on MVC and the Front Controller Pattern in PHP! Today, we’ll dive into two essential architectural patterns: the Model-View-Controller (MVC) and Front Controller. We’ll also explore how these patterns work together to structure web applications efficiently.

By the end of this video, you’ll understand what these patterns do, how they improve code organization, and you’ll see a practical example in PHP. Let’s get started!

1. What is the MVC Pattern?
The MVC pattern, or Model-View-Controller, is a design pattern that helps separate different parts of an application:

Model: Manages data and business logic, interacting with the database through PDO in our case.
View: Handles what the user sees – HTML, CSS, and any dynamic data from the Model.
Controller: Acts as an intermediary, processing user input, and determining which Model and View to load.
Diagram for MVC Architecture:

rust
Copy code
User -> Controller -> Model -> View -> User
The MVC pattern allows our application to be modular, making code more reusable and easier to maintain. For example, we can change how data is presented in the View without altering the Model.

2. Understanding the Front Controller Pattern
Now, let’s talk about the Front Controller Pattern.

In an MVC framework, the Front Controller serves as a single entry point that processes all incoming requests. Instead of having multiple entry points, all requests are directed to one file – typically named index.php. This central file routes requests to the correct controller based on the URL.

Benefits of the Front Controller Pattern:

Centralized Control: The Front Controller handles authentication, routing, and error handling in one place.
Consistency: All requests are processed through a single script, simplifying URL management and improving security.
Easier to Maintain: Changes in request processing only need to be made in the front controller, not multiple files.
3. Creating a Central Entry Point (index.php) to Handle All Requests
Let’s move on to how we can implement the Front Controller pattern.

We’ll create an index.php file that will serve as our single entry point. This file will handle all incoming requests and route them to the appropriate controller.

Step 1: Create a Basic Folder Structure
arduino
Copy code
project_root/
├── index.php          # Front Controller
├── app/
│   ├── Controllers/
│   ├── Models/
│   └── Views/
├── config/
└── public/
This structure helps keep code organized, with the main logic residing in the app folder and all incoming requests handled by index.php.

Step 2: Write the index.php Front Controller
Here’s a simple version of the index.php file:

php
Copy code
<?php
// index.php - Front Controller

require_once 'config/bootstrap.php';

$requestUri = $_SERVER['REQUEST_URI'];
$scriptName = $_SERVER['SCRIPT_NAME'];

// Remove the script name from the URL to get the route
$route = str_replace($scriptName, '', $requestUri);
$route = trim($route, '/');

// Define simple routing
switch ($route) {
    case '':
        $controller = new \App\Controllers\HomeController();
        $controller->index();
        break;
    case 'about':
        $controller = new \App\Controllers\AboutController();
        $controller->index();
        break;
    default:
        echo "404 - Page Not Found";
}
?>
In this code:

We include our configuration file, bootstrap.php.
We analyze the URL to determine the route.
Using a switch statement, we route to different controllers based on the requested URL.
This allows index.php to handle different pages, such as the homepage (/) and an about page (/about).

4. Practical Code Example: Implementing MVC with a Front Controller
Let’s now implement a simple MVC structure by adding a HomeController and a View file.

Step 1: Create a Basic Controller (HomeController.php)
In app/Controllers/HomeController.php:

php
Copy code
<?php

namespace App\Controllers;

class HomeController {
    public function index() {
        // Load data from the model
        $data = ['title' => 'Welcome to Our Site!'];
        
        // Load the view and pass data to it
        require '../app/Views/home.php';
    }
}
?>
The HomeController:

Fetches data (hardcoded for simplicity here).
Loads a home.php view file and passes data to it.
Step 2: Create a Basic View (home.php)
In app/Views/home.php:

php
Copy code
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo $data['title']; ?></title>
</head>
<body>
    <h1><?php echo $data['title']; ?></h1>
    <p>This is a simple MVC application using the Front Controller pattern.</p>
</body>
</html>
This view file displays the title and content passed from the controller. It’s fully separated from any logic, adhering to the MVC principle of keeping views presentation-focused.

Step 3: Testing the Setup
Start a PHP server by running php -S localhost:8000 in your terminal.
Visit http://localhost:8000 in your browser.
If everything is set up correctly, you’ll see the homepage content from the home.php view file.

5. Recap and Summary
MVC: Separates concerns into Model, View, and Controller.
Front Controller Pattern: Uses a single entry point (index.php) to handle all requests.
We implemented a basic MVC structure using the Front Controller pattern, creating a centralized index.php that directs requests to the appropriate controller.
Thank you for watching! I hope this screencast helped you understand MVC and the Front Controller Pattern, and how they work together to build a structured PHP application.








*/ 