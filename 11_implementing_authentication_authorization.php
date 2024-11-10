<?php
/*
Here's a script for your screencast video on implementing Authentication and Authorization with an MVC approach. Since you've learned PHP OOP, SOLID Principles, design patterns, PDO, error and exception handling, and SPL, this script will highlight a structured and robust MVC-based solution.

Title: Building Secure Authentication and Role-Based Authorization in PHP MVC
Agenda:
Introduction to Authentication and Authorization
Setting Up the MVC Structure
Implementing User Authentication in MVC
Setting Up Role-Based Access Control (RBAC)
Testing Authentication and RBAC in Action
Closing Remarks
1. Introduction to Authentication and Authorization
“In this screencast, we’re going to walk through implementing a secure, scalable Authentication and Authorization system using MVC in PHP. Authentication verifies user identity, while Authorization determines access rights based on roles. This approach will use PDO for secure database interaction and SOLID principles to ensure maintainability.”

2. Setting Up the MVC Structure
Model: Handles data-related logic.
View: Renders the UI, separate from the data.
Controller: Manages user requests and processes data.
Let’s create a basic directory structure:

plaintext
Copy code
project/
│
├── app/
│   ├── Controllers/
│   ├── Models/
│   ├── Views/
│   ├── Helpers/
│   └── config.php
│
├── public/
│   ├── index.php
│   └── .htaccess
│
└── vendor/
Explanation:
app/Controllers/: Houses business logic, such as login, logout, and registration.
app/Models/: Contains models like User for handling database interactions.
app/Views/: Renders the output to the user.
public/: Publicly accessible files, including index.php, which bootstraps the application.
3. Implementing User Authentication in MVC
Step 1: Creating the Database and User Table

sql
Copy code
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('user', 'admin') DEFAULT 'user'
);
Explanation: We’re storing the user’s role for role-based access later.
Step 2: Setting Up the User Model

In app/Models/User.php:

php
Copy code
<?php
namespace App\Models;

use PDO;

class User {
    private $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function findByUsername($username) {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->execute(['username' => $username]);
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function createUser($username, $password, $role = 'user') {
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $stmt = $this->pdo->prepare("INSERT INTO users (username, password, role) VALUES (:username, :password, :role)");
        return $stmt->execute(['username' => $username, 'password' => $hashedPassword, 'role' => $role]);
    }
}
Explanation: findByUsername checks if the user exists, while createUser adds a new user with a hashed password.
Step 3: Creating the Authentication Controller

In app/Controllers/AuthController.php:

php
Copy code
<?php
namespace App\Controllers;

use App\Models\User;

class AuthController {
    private $user;

    public function __construct(User $user) {
        $this->user = $user;
    }

    public function login($username, $password) {
        $user = $this->user->findByUsername($username);
        if ($user && password_verify($password, $user->password)) {
            $_SESSION['user_id'] = $user->id;
            $_SESSION['role'] = $user->role;
            return true;
        }
        return false;
    }

    public function logout() {
        session_unset();
        session_destroy();
    }
}
Explanation: login verifies the password using password_verify and sets session data for successful logins. logout clears the session.
4. Setting Up Role-Based Access Control (RBAC)
Step 1: Middleware for Role-Based Access

In app/Helpers/AuthMiddleware.php:

php
Copy code
<?php
namespace App\Helpers;

class AuthMiddleware {
    public static function checkRole($role) {
        return isset($_SESSION['role']) && $_SESSION['role'] === $role;
    }

    public static function requireRole($role) {
        if (!self::checkRole($role)) {
            header("Location: /login");
            exit;
        }
    }
}
Explanation: checkRole checks if the current user has the required role. requireRole enforces role-based access.
Step 2: Restricting Access in the Controller

In a DashboardController:

php
Copy code
<?php
namespace App\Controllers;

use App\Helpers\AuthMiddleware;

class DashboardController {
    public function __construct() {
        AuthMiddleware::requireRole('admin');
    }

    public function index() {
        echo "Welcome to the admin dashboard!";
    }
}
Explanation: DashboardController restricts access to the admin role. If the user is not an admin, they’re redirected to login.
5. Testing Authentication and RBAC in Action
Login Test:

Access the login page with user credentials. Observe successful redirection upon valid credentials.
Role-Based Access Control Test:

Try accessing the admin dashboard as a non-admin user. Verify redirection to the login page due to insufficient permissions.
6. Closing Remarks
“In this screencast, we covered an MVC-based approach to Authentication and Role-Based Authorization in PHP. We built a user authentication flow with secure password handling, session management, and role-based access controls to ensure only authorized users access restricted resources. This approach is a solid foundation for more advanced features in your applications.”

This script should give you a clear structure to guide viewers through Authentication and Authorization using an MVC approach, incorporating PDO, SOLID, and other best practices. Let me know if you'd like additional customization for specific areas!


*/ 