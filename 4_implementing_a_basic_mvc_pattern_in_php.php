<?php
/*

Here's a detailed script for your screencast on "Implementing a Basic MVC Pattern in PHP," covering how to set up a simple MVC structure in PHP and build basic CRUD functionality.

Title: Building a Simple MVC Pattern in PHP with Basic CRUD Operations
Agenda
Introduction to MVC Architecture
Setting Up a Simple MVC Structure in PHP
Creating Models for Data Handling
Building Views for Displaying Data
Developing Controllers for Business Logic
Implementing Basic CRUD Operations
Conclusion and Final Remarks
Script
Introduction to MVC Architecture
Hello everyone! In this video, we’ll explore the Model-View-Controller (MVC) Pattern in PHP. MVC is a design pattern that helps separate concerns by dividing code into three main components:

Model: Manages data and business logic.
View: Handles the presentation and output of data.
Controller: Acts as an intermediary, handling input and coordinating between the Model and View.
MVC architecture is commonly used in frameworks, but today, we’ll build a simple MVC structure without using any framework, helping you understand how MVC works at a fundamental level.

Setting Up a Simple MVC Structure in PHP
Let's start by creating a basic folder structure for our MVC application:

plaintext
Copy code
project-root/
│
├── public/
│   └── index.php        # Entry point
│
├── app/
│   ├── controllers/
│   ├── models/
│   └── views/
│
├── core/
│   ├── App.php          # Core MVC setup
│   ├── Controller.php   # Base controller class
│   └── Model.php        # Base model class
│
└── config/
    └── config.php       # Database configuration
public/index.php – Our entry point, which initializes the application.
app/controllers – Stores all controllers.
app/models – Contains all models.
app/views – Holds all views.
core – Contains core files like our App class, base controller, and model.
Creating Models for Data Handling
For our example, we’ll build a CRUD application to manage a list of users in a database. We’ll start by setting up our User model.

Configuring the Database
Create config/config.php with the following database setup:

php
Copy code
<?php
return [
    'host' => 'localhost',
    'dbname' => 'mvc_app',
    'username' => 'root',
    'password' => '',
];
Creating the Base Model
Next, create core/Model.php to handle database connections.

php
Copy code
<?php
namespace Core;

use PDO;
use PDOException;

abstract class Model {
    protected $db;

    public function __construct() {
        $config = require __DIR__ . '/../config/config.php';
        try {
            $this->db = new PDO("mysql:host={$config['host']};dbname={$config['dbname']}", $config['username'], $config['password']);
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Database connection failed: " . $e->getMessage());
        }
    }
}
Creating the User Model
Now, create app/models/User.php to represent our users table.

php
Copy code
<?php
namespace App\Models;

use Core\Model;
use PDO;

class User extends Model {
    public function getAllUsers() {
        $stmt = $this->db->query("SELECT * FROM users");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function createUser($name, $email) {
        $stmt = $this->db->prepare("INSERT INTO users (name, email) VALUES (:name, :email)");
        $stmt->execute(['name' => $name, 'email' => $email]);
    }

    public function getUserById($id) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateUser($id, $name, $email) {
        $stmt = $this->db->prepare("UPDATE users SET name = :name, email = :email WHERE id = :id");
        $stmt->execute(['id' => $id, 'name' => $name, 'email' => $email]);
    }

    public function deleteUser($id) {
        $stmt = $this->db->prepare("DELETE FROM users WHERE id = :id");
        $stmt->execute(['id' => $id]);
    }
}
Building Views for Displaying Data
Our views will display data returned by controllers. Let’s create a simple view to display all users.

In app/views/users/index.php:

php
Copy code
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Users</title>
</head>
<body>
    <h1>Users</h1>
    <table>
        <tr><th>ID</th><th>Name</th><th>Email</th><th>Actions</th></tr>
        <?php foreach ($users as $user): ?>
            <tr>
                <td><?= $user['id'] ?></td>
                <td><?= $user['name'] ?></td>
                <td><?= $user['email'] ?></td>
                <td>
                    <a href="/user/edit/<?= $user['id'] ?>">Edit</a> |
                    <a href="/user/delete/<?= $user['id'] ?>">Delete</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
Developing Controllers for Business Logic
The UserController will fetch user data and send it to views.

In app/controllers/UserController.php:

php
Copy code
<?php
namespace App\Controllers;

use App\Models\User;

class UserController {
    public function index() {
        $userModel = new User();
        $users = $userModel->getAllUsers();
        require __DIR__ . '/../views/users/index.php';
    }

    public function create($name, $email) {
        $userModel = new User();
        $userModel->createUser($name, $email);
        header("Location: /user/index");
    }

    public function edit($id) {
        // Show edit form (implement as needed)
    }

    public function delete($id) {
        $userModel = new User();
        $userModel->deleteUser($id);
        header("Location: /user/index");
    }
}
Implementing Basic CRUD Operations
With MVC structure in place, let’s outline basic CRUD:

Create: createUser inserts a new record.
Read: getAllUsers retrieves users.
Update: updateUser modifies existing data.
Delete: deleteUser removes a record.
Here’s a quick look at how to integrate these methods within controllers and views for CRUD functionality.

Conclusion and Final Remarks
To wrap up, we covered setting up a simple MVC structure in PHP from scratch. You now understand how MVC helps organize code by dividing data management, display, and application logic. I hope this tutorial helps you feel more confident with MVC in PHP. Thank you for watching, and happy coding!








*/ 