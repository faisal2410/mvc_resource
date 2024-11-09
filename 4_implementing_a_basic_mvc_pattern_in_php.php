<?php
/*

Here's a detailed script for your screencast on "Implementing a Basic MVC Pattern in PHP". I'll include an agenda, a detailed explanation of each topic, and code examples to help your learners follow along easily.

Title: Implementing a Basic MVC Pattern in PHP from Scratch

Agenda:

Introduction to MVC Architecture
Setting Up a Simple MVC Structure in PHP
Creating Models, Views, and Controllers
Building Basic CRUD Functionality with MVC Principles
Connecting the MVC Components Together
Conclusion and Next Steps
1. Introduction to MVC Architecture
Explanation:
MVC (Model-View-Controller) is a design pattern that separates application logic into three interconnected components:

Model: Manages the data and business logic.
View: Handles the display of data.
Controller: Processes user input and coordinates the Model and View.
MVC improves code organization, testability, and separation of concerns.

2. Setting Up a Simple MVC Structure in PHP
Explanation:
We’ll start by creating a basic file structure. In the root folder of the project, create the following directories:

bash
Copy code
/mvc-app
    /app
        /Controllers
        /Models
        /Views
    /config
    /public
        index.php
    /vendor
Step-by-Step Code for Initial Structure:
Configuring index.php: This file will route requests to the correct controller and method.

php
Copy code
<?php
require_once '../config/routes.php';
Setting Up routes.php: In /config/routes.php, define basic routes for your app. Here we’ll use query parameters to identify the controller and action:

php
Copy code
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
3. Creating Models, Views, and Controllers
Creating a Model:
In /app/Models, create a User.php model to interact with the database.

php
Copy code
<?php
namespace App\Models;
use PDO;

class User {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getAll() {
        $stmt = $this->pdo->prepare("SELECT * FROM users");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create($name, $email) {
        $stmt = $this->pdo->prepare("INSERT INTO users (name, email) VALUES (:name, :email)");
        return $stmt->execute(['name' => $name, 'email' => $email]);
    }

    // Additional methods for read, update, and delete.
}
Creating a Controller:
In /app/Controllers, create a UserController.php file to handle actions for users.

php
Copy code
<?php
namespace App\Controllers;
use App\Models\User;
use PDO;

class UserController {
    private $userModel;

    public function __construct() {
        $pdo = new PDO("mysql:host=localhost;dbname=mvc_app", "username", "password");
        $this->userModel = new User($pdo);
    }

    public function index() {
        $users = $this->userModel->getAll();
        require '../app/Views/user_index.php';
    }

    public function create() {
        // Capture POST data
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->userModel->create($_POST['name'], $_POST['email']);
            header("Location: /?controller=user&action=index");
        }
        require '../app/Views/user_create.php';
    }
}
Creating a View:
In /app/Views, create user_index.php and user_create.php.

user_index.php:

php
Copy code
<h1>Users List</h1>
<a href="?controller=user&action=create">Add New User</a>
<ul>
    <?php foreach ($users as $user): ?>
        <li><?= htmlspecialchars($user['name']) ?> (<?= htmlspecialchars($user['email']) ?>)</li>
    <?php endforeach; ?>
</ul>
user_create.php:

php
Copy code
<h1>Create New User</h1>
<form action="?controller=user&action=create" method="POST">
    <label>Name: <input type="text" name="name"></label><br>
    <label>Email: <input type="email" name="email"></label><br>
    <button type="submit">Submit</button>
</form>
4. Building Basic CRUD Functionality with MVC Principles
Explanation:
To complete CRUD operations, we add methods for retrieving single records, updating, and deleting in both the User model and the UserController.

Update User in UserController:

php
Copy code
public function update($id) {
    // Implement the update logic
}
Delete User in UserController:

php
Copy code
public function delete($id) {
    // Implement the delete logic
}
Each action would have a corresponding view to capture form data or display feedback to the user.

5. Connecting the MVC Components Together
Explanation:
The routing in index.php will pass the correct parameters to the UserController. Each user action in the URL will correspond to a method in the controller, which in turn calls the necessary model methods and includes the appropriate view.

Example Usage:

/?controller=user&action=index - Lists users.
/?controller=user&action=create - Form to create a new user.
6. Conclusion and Next Steps
Explanation:
MVC is a powerful design pattern that structures applications effectively. From here, you can add middleware for authentication, more robust routing, and error handling to expand the MVC foundation you’ve built here.

This script introduces MVC concepts clearly, provides a working CRUD example, and emphasizes the purpose of each component within the MVC framework.



*/ 