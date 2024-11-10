<?php
/*
Title: Enhancing Code Structure in PHP: Service Layer and Repository Pattern

Agenda
Introduction to the Service Layer and Repository Pattern
Adding a Service Layer to Separate Business Logic from Controllers
Using the Repository Pattern for Advanced Data Management
Implementing the Patterns in PHP: Practical Examples
Script
1. Introduction to the Service Layer and Repository Pattern
“Hello, and welcome! In today’s session, we’ll be diving into two essential patterns in software development: the Service Layer and the Repository Pattern. These design patterns help us write clean, modular, and testable code by separating concerns in our application.

We’ll start by understanding why these patterns are important, then implement them with practical examples. By the end, you’ll see how the Service Layer helps to encapsulate business logic and the Repository Pattern provides an interface for data access.”

2. Adding a Service Layer to Separate Business Logic from Controllers
“Let’s start by discussing the Service Layer. The Service Layer pattern allows us to keep our business logic separate from other parts of the application, such as controllers. Typically, in a web application, controllers handle HTTP requests and responses. However, placing business logic directly in controllers can lead to bloated, hard-to-maintain code.

By creating a separate Service Layer, we encapsulate all business logic in dedicated classes, making our controllers lighter and focused solely on handling HTTP traffic.”

Example Scenario: Imagine we have a simple application where users can purchase products. We’ll create a ProductController to handle the HTTP requests, and a ProductService class to encapsulate the business logic related to product purchasing.
Step 1: Controller without Service Layer

Let’s start with how a typical controller might look without a service layer:

php
Copy code
class ProductController {
    public function purchaseProduct($productId, $userId) {
        // Business logic directly in the controller
        $product = ProductRepository::find($productId);

        if ($product->stock <= 0) {
            throw new Exception("Product out of stock");
        }

        // Deduct stock and update user purchase history
        $product->stock--;
        ProductRepository::update($product);
        UserRepository::addPurchase($userId, $productId);

        return "Purchase successful!";
    }
}
Here, the controller is responsible for business logic, such as checking stock, updating the database, and managing user purchases. It’s clear that if we add more logic, the controller will quickly become difficult to manage.

Step 2: Adding a Service Layer

Now, let’s introduce a Service Layer by creating a ProductService class. This class will handle the business logic, and the controller will delegate the purchase operation to it.

php
Copy code
class ProductService {
    protected $productRepository;
    protected $userRepository;

    public function __construct(ProductRepository $productRepository, UserRepository $userRepository) {
        $this->productRepository = $productRepository;
        $this->userRepository = $userRepository;
    }

    public function purchaseProduct($productId, $userId) {
        $product = $this->productRepository->find($productId);

        if ($product->stock <= 0) {
            throw new Exception("Product out of stock");
        }

        $product->stock--;
        $this->productRepository->update($product);
        $this->userRepository->addPurchase($userId, $productId);

        return "Purchase successful!";
    }
}
Step 3: Using the Service Layer in the Controller

Our ProductController becomes much cleaner:

php
Copy code
class ProductController {
    protected $productService;

    public function __construct(ProductService $productService) {
        $this->productService = $productService;
    }

    public function purchaseProduct($productId, $userId) {
        try {
            return $this->productService->purchaseProduct($productId, $userId);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}
By using a service layer, our controller’s main role is to handle the request and response, while the ProductService focuses on the business logic.

3. Using the Repository Pattern for Advanced Data Management
“Now, let’s move on to the Repository Pattern. This pattern is essential for data management, as it abstracts data operations, allowing for a more modular and testable application. By implementing repositories, we’re no longer tightly coupled to specific database queries in our application.

The repository pattern allows us to define common operations, such as finding, updating, or deleting records, and organize them into reusable classes.”

Example: We’ll define a repository for the Product entity.
Step 1: Creating the Repository Interface

We’ll start by defining a ProductRepositoryInterface, which declares the operations we want to perform on products.

php
Copy code
interface ProductRepositoryInterface {
    public function find($productId);
    public function update($product);
}
Step 2: Implementing the Repository Interface with PDO

Next, let’s implement this interface in ProductRepository:

php
Copy code
class ProductRepository implements ProductRepositoryInterface {
    protected $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function find($productId) {
        $statement = $this->pdo->prepare("SELECT * FROM products WHERE id = :id");
        $statement->bindParam(':id', $productId);
        $statement->execute();

        return $statement->fetchObject(Product::class);
    }

    public function update($product) {
        $statement = $this->pdo->prepare("UPDATE products SET stock = :stock WHERE id = :id");
        $statement->bindParam(':stock', $product->stock);
        $statement->bindParam(':id', $product->id);
        $statement->execute();
    }
}
By using this pattern, if we change our database technology (for example, switching from MySQL to MongoDB), we’d only need to update the ProductRepository implementation, leaving the rest of the code unchanged.

4. Implementing the Patterns in PHP: Practical Example
Let’s combine everything by showing how ProductService interacts with ProductRepository.

Service Layer and Repository Interaction: The ProductService calls methods on ProductRepository, which abstracts away the data layer.
Controller Simplification: The ProductController simply calls methods on ProductService, not knowing about the underlying data structure.
This layered structure enhances testability, maintainability, and scalability.

Final ProductService with Repository

php
Copy code
class ProductService {
    protected $productRepository;

    public function __construct(ProductRepositoryInterface $productRepository) {
        $this->productRepository = $productRepository;
    }

    public function purchaseProduct($productId, $userId) {
        $product = $this->productRepository->find($productId);

        if ($product->stock <= 0) {
            throw new Exception("Product out of stock");
        }

        $product->stock--;
        $this->productRepository->update($product);

        // Additional business logic can go here
    }
}
In the ProductController, we now simply call the ProductService:

php
Copy code
class ProductController {
    protected $productService;

    public function __construct(ProductService $productService) {
        $this->productService = $productService;
    }

    public function purchaseProduct($productId, $userId) {
        return $this->productService->purchaseProduct($productId, $userId);
    }
}
Conclusion
“In summary, the Service Layer and Repository Pattern help organize our application by separating business logic from data access logic. The Service Layer encapsulates business logic in dedicated classes, while the Repository Pattern abstracts data access into manageable components.

Thank you for watching! I hope this has been helpful in understanding the importance of a Service Layer and Repository Pattern in structuring your PHP applications.”


*/ 