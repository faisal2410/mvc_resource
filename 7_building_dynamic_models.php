<?php
/*

Title: Building Dynamic Models in PHP: A Practical Guide to ORM, PDO, and Encapsulating Business Logic
Script for Screencast Video

Introduction:

Hello, and welcome to this screencast video on Building Dynamic Models in PHP! In this session, we’ll cover how to create data models in PHP, interact with databases using PDO, and encapsulate business logic within model methods. By the end, you’ll have a comprehensive understanding of how to use PHP to build dynamic, secure, and maintainable models that integrate seamlessly with a database.

Agenda:

Understanding ORM (Object-Relational Mapping) and Its Role in MVC
Creating Data Models and Handling Database Interactions with PDO
Implementing Model Methods to Encapsulate Business Logic
Let’s dive in!

1. Understanding ORM and Its Role in MVC
Explanation: Object-Relational Mapping, or ORM, is a technique that allows us to interact with our database in a more object-oriented way. Instead of writing raw SQL queries, ORM allows us to use objects and methods to interact with database tables. In an MVC (Model-View-Controller) structure, models are responsible for handling data and business logic, making ORM especially useful for creating modular and reusable code.

Example: Let’s say we have a database table called users. With ORM, we can map each row in the users table to an instance of a User class, and each column becomes a property. Instead of writing complex SQL, we can retrieve, update, and delete user data with simple method calls.

2. Creating Data Models and Handling Database Interactions with PDO
Explanation: Now that we understand ORM, we’ll use PDO (PHP Data Objects) to create data models and interact with the database. PDO provides a secure way to work with databases, as it includes support for prepared statements to prevent SQL injection.

We’ll create a User model to manage data in the users table. This model will connect to the database using PDO, handle queries, and retrieve results.

Code Example:

Let’s start by creating a Database class to manage our database connection. Then, we’ll create a User model to interact with the users table.

php
Copy code
<?php

// Database.php - Handles PDO connection setup
class Database
{
    private $host = 'localhost';
    private $db = 'test_db';
    private $user = 'root';
    private $pass = '';
    private $charset = 'utf8mb4';
    private $pdo;

    public function __construct()
    {
        $dsn = "mysql:host={$this->host};dbname={$this->db};charset={$this->charset}";
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];

        try {
            $this->pdo = new PDO($dsn, $this->user, $this->pass, $options);
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int)$e->getCode());
        }
    }

    public function getConnection()
    {
        return $this->pdo;
    }
}
Now we’ll create a User model that interacts with the Database class to perform CRUD operations.

php
Copy code
<?php

// User.php - Our data model for users
class User
{
    private $pdo;

    public function __construct(Database $db)
    {
        $this->pdo = $db->getConnection();
    }

    public function findById($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    public function create($name, $email)
    {
        $stmt = $this->pdo->prepare("INSERT INTO users (name, email) VALUES (:name, :email)");
        $stmt->execute(['name' => $name, 'email' => $email]);
        return $this->pdo->lastInsertId();
    }

    public function update($id, $name, $email)
    {
        $stmt = $this->pdo->prepare("UPDATE users SET name = :name, email = :email WHERE id = :id");
        $stmt->execute(['id' => $id, 'name' => $name, 'email' => $email]);
    }

    public function delete($id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM users WHERE id = :id");
        $stmt->execute(['id' => $id]);
    }
}
3. Implementing Model Methods to Encapsulate Business Logic
Explanation: A key part of designing models is to encapsulate business logic. Instead of writing logic directly in controllers, we keep it within our models, which improves modularity and maintains the single-responsibility principle.

For example, let’s add a method to check if a user’s email is already registered.

Code Example:

php
Copy code
<?php

class User
{
    private $pdo;

    public function __construct(Database $db)
    {
        $this->pdo = $db->getConnection();
    }

    public function findById($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    public function create($name, $email)
    {
        if ($this->isEmailRegistered($email)) {
            throw new Exception("Email is already registered!");
        }

        $stmt = $this->pdo->prepare("INSERT INTO users (name, email) VALUES (:name, :email)");
        $stmt->execute(['name' => $name, 'email' => $email]);
        return $this->pdo->lastInsertId();
    }

    private function isEmailRegistered($email)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute(['email' => $email]);
        return $stmt->fetch() !== false;
    }
}
Summary and Closing Remarks
To recap:

ORM simplifies data handling in MVC by mapping database records to objects.
PDO provides a secure and flexible way to interact with databases, including prepared statements.
Model methods encapsulate business logic, keeping our code organized and maintainable.
Thank you for watching, and happy coding!



*/ 