<?php
/*
Title: Introduction to MVC and RESTful APIs in PHP
Agenda:
Understanding MVC Architecture in PHP
Designing RESTful Routes and Resources in MVC
Returning JSON Responses and Handling API Requests
Script
Part 1: Understanding MVC Architecture in PHP
Introduction

"In this section, we’ll explore what MVC is and why it’s a crucial pattern for building organized, maintainable web applications. By dividing an application into three distinct layers—Model, View, and Controller—MVC helps structure code for easier development and scalability."

Define MVC:

The Model represents the data and business logic.
The View is the UI or representation of the data.
The Controller manages communication between the Model and View, handling user input and updating the Model.
Example Breakdown:

Model (e.g., User Model): Handles database operations and business rules.
View (e.g., User Profile View): Displays user profile data in an HTML layout.
Controller (e.g., User Controller): Fetches user data from the Model and passes it to the View.
php
Copy code
// Sample Controller: UserController.php
class UserController {
    public function getUserProfile($userId) {
        $user = UserModel::find($userId);
        require 'views/userProfile.php';
    }
}
Recap: Summarize that MVC helps structure the app’s layers clearly, improving modularity and maintainability.
Part 2: Designing RESTful Routes and Resources in MVC
Introduction

"Next, let’s design RESTful routes and resources for our application using MVC principles. RESTful APIs follow specific conventions that make interacting with APIs easier and more predictable. We'll focus on creating well-defined routes and HTTP methods that correspond to specific actions."

1. Define REST and RESTful APIs
REST stands for Representational State Transfer. It’s an architectural style for building APIs.
RESTful APIs expose resources (e.g., /users, /products) and use HTTP methods (GET, POST, PUT, DELETE) to perform CRUD operations.
2. Designing RESTful Routes
Outline common routes for a resource like User, specifying the HTTP method, endpoint, and action.
HTTP Method	Endpoint	Action	Purpose
GET	/api/users	index()	Fetch all users
GET	/api/users/{id}	show()	Fetch a single user
POST	/api/users	store()	Create a new user
PUT	/api/users/{id}	update()	Update a user
DELETE	/api/users/{id}	destroy()	Delete a user
3. Implementing RESTful Endpoints in the Controller
php
Copy code
// UserController.php
class UserController {
    // Fetch all users
    public function index() {
        $users = UserModel::getAll();
        echo json_encode($users);
    }

    // Fetch a single user by ID
    public function show($id) {
        $user = UserModel::find($id);
        echo json_encode($user);
    }

    // Create a new user
    public function store() {
        $data = json_decode(file_get_contents("php://input"), true);
        $newUser = UserModel::create($data);
        echo json_encode($newUser);
    }

    // Update an existing user
    public function update($id) {
        $data = json_decode(file_get_contents("php://input"), true);
        $updatedUser = UserModel::update($id, $data);
        echo json_encode($updatedUser);
    }

    // Delete a user
    public function destroy($id) {
        UserModel::delete($id);
        echo json_encode(["message" => "User deleted successfully"]);
    }
}
4. Setting Up Routes
php
Copy code
// index.php
$controller = new UserController();

switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        if (isset($_GET['id'])) {
            $controller->show($_GET['id']);
        } else {
            $controller->index();
        }
        break;
    case 'POST':
        $controller->store();
        break;
    case 'PUT':
        parse_str(file_get_contents("php://input"), $_PUT);
        $controller->update($_GET['id']);
        break;
    case 'DELETE':
        $controller->destroy($_GET['id']);
        break;
}
Part 3: Returning JSON Responses and Handling API Requests
Introduction

"The last part of this tutorial covers returning JSON responses and handling API requests. JSON is the standard data format for REST APIs, allowing data to be exchanged between client and server in a structured way."

1. Returning JSON Responses
By default, PHP’s json_encode method converts arrays or objects into JSON.
Set the Content-Type header to application/json to ensure the client interprets the data as JSON.
php
Copy code
header("Content-Type: application/json");
echo json_encode($data);
2. Handling API Requests
Fetching JSON Data from a Request: For incoming API requests, use php://input to retrieve JSON data and decode it.
This is especially useful in methods like store and update where data is provided in JSON format.
php
Copy code
// Fetching JSON input data
$inputData = json_decode(file_get_contents("php://input"), true);
3. Handling Errors and Sending Response Status
Use HTTP status codes to indicate request success or errors.
Here’s an example of a successful response and an error response:
php
Copy code
// Success Response
http_response_code(200); // OK
echo json_encode(["status" => "success", "data" => $data]);

// Error Response
http_response_code(404); // Not Found
echo json_encode(["status" => "error", "message" => "User not found"]);
4. Putting It All Together: Example API Endpoint
php
Copy code
// Example: Update User API
public function update($id) {
    $data = json_decode(file_get_contents("php://input"), true);
    if (UserModel::exists($id)) {
        $updatedUser = UserModel::update($id, $data);
        http_response_code(200);
        echo json_encode(["status" => "success", "data" => $updatedUser]);
    } else {
        http_response_code(404);
        echo json_encode(["status" => "error", "message" => "User not found"]);
    }
}
Conclusion
"To wrap up, we’ve covered the basics of MVC architecture, how to design RESTful routes, and manage API responses. With MVC, our code stays organized and clean, while RESTful conventions and JSON responses ensure our APIs are predictable and user-friendly. This foundation can now serve as a base to build more complex and scalable applications."


*/ 