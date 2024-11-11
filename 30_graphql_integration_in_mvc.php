<?php
/*

Title:
Integrating GraphQL in MVC Applications: A Step-by-Step Guide

Agenda:

Introduction to GraphQL and its Benefits over REST
Implementing GraphQL as an Alternative to REST in MVC Applications
Setting up GraphQL Queries and Mutations in the Model Layer
Managing Authorization and Data Fetching for GraphQL Endpoints in MVC
Conclusion and Best Practices
1. Introduction to GraphQL and its Benefits over REST
In this section, explain what GraphQL is and compare it briefly with REST.

GraphQL is a query language and runtime for APIs, developed by Facebook, that enables clients to request exactly the data they need. Unlike REST, where fixed endpoints often return fixed data structures, GraphQL allows clients to customize responses, which can reduce the amount of data transferred over the network.
Example Comparison of REST vs GraphQL:

REST request for fetching user data:

http
Copy code
GET /api/users/1
Response:
{
    "id": 1,
    "name": "Alice",
    "email": "alice@example.com",
    "posts": [
        {
            "id": 101,
            "title": "GraphQL in MVC",
            "content": "Intro to GraphQL..."
        },
        ...
    ]
}
GraphQL equivalent query:

graphql
Copy code
query {
    user(id: 1) {
        name
        email
        posts {
            title
        }
    }
}
2. Implementing GraphQL as an Alternative to REST in MVC Applications
In this section, explain how to implement GraphQL in an MVC application. We’ll use PHP for our example.

Step 1: Set Up a GraphQL Library
Start by installing a GraphQL PHP library, like webonyx/graphql-php, using Composer:
bash
Copy code
composer require webonyx/graphql-php
Step 2: Create the GraphQL Schema and Types
In the MVC pattern:

Model: Defines GraphQL types (e.g., UserType).
Controller: Handles GraphQL queries and mutations.
View: Not used directly in GraphQL but will display the results in a client.
Step 3: Define GraphQL Types in Model Layer
For example, create a UserType and PostType to represent users and posts.

php
Copy code
// src/Models/UserType.php
use GraphQL\Type\Definition\Type;
use GraphQL\Type\Definition\ObjectType;

class UserType extends ObjectType {
    public function __construct() {
        $config = [
            'fields' => [
                'id' => Type::int(),
                'name' => Type::string(),
                'email' => Type::string(),
                'posts' => [
                    'type' => Type::listOf(new PostType()),
                    'resolve' => function($user) {
                        return PostModel::getPostsByUserId($user['id']);
                    }
                ]
            ]
        ];
        parent::__construct($config);
    }
}
Step 4: Set Up the GraphQL Endpoint in the Controller
In the controller, set up a GraphQL endpoint where queries and mutations can be processed.

php
Copy code
// src/Controllers/GraphQLController.php
use GraphQL\GraphQL;
use GraphQL\Type\Schema;
use GraphQL\Error\FormattedError;
use GraphQL\Error\DebugFlag;

class GraphQLController {
    public function handleRequest() {
        $schema = new Schema([
            'query' => new QueryType(),
            'mutation' => new MutationType()
        ]);

        $input = json_decode(file_get_contents('php://input'), true);
        $query = $input['query'];
        $variables = isset($input['variables']) ? $input['variables'] : null;

        try {
            $result = GraphQL::executeQuery($schema, $query, null, null, $variables);
            $output = $result->toArray(DebugFlag::INCLUDE_DEBUG_MESSAGE);
        } catch (\Exception $e) {
            $output = [
                'error' => FormattedError::createFromException($e)
            ];
        }

        header('Content-Type: application/json');
        echo json_encode($output);
    }
}
3. Setting up GraphQL Queries and Mutations in the Model Layer
Explain how to define GraphQL queries and mutations in the model layer.

Step 1: Define Query Types
Create query definitions like UserQuery to fetch user data.

php
Copy code
// src/Models/Queries/UserQuery.php
use GraphQL\Type\Definition\Type;

class UserQuery extends ObjectType {
    public function __construct() {
        $config = [
            'fields' => [
                'user' => [
                    'type' => new UserType(),
                    'args' => [
                        'id' => Type::int()
                    ],
                    'resolve' => function($root, $args) {
                        return UserModel::getUserById($args['id']);
                    }
                ]
            ]
        ];
        parent::__construct($config);
    }
}
Step 2: Define Mutation Types
Define mutations to handle data updates.

php
Copy code
// src/Models/Mutations/CreateUserMutation.php
use GraphQL\Type\Definition\Type;

class CreateUserMutation extends ObjectType {
    public function __construct() {
        $config = [
            'fields' => [
                'createUser' => [
                    'type' => new UserType(),
                    'args' => [
                        'name' => Type::string(),
                        'email' => Type::string()
                    ],
                    'resolve' => function($root, $args) {
                        return UserModel::createUser($args['name'], $args['email']);
                    }
                ]
            ]
        ];
        parent::__construct($config);
    }
}
4. Managing Authorization and Data Fetching for GraphQL Endpoints in MVC
Explain how to manage user authorization and fetch data securely.

Step 1: Implement Authorization Middleware
Add middleware for authentication checks.

php
Copy code
// src/Middleware/AuthMiddleware.php
class AuthMiddleware {
    public function handle($next) {
        if (!Auth::check()) {
            throw new Exception('Unauthorized');
        }
        return $next();
    }
}
Step 2: Apply Authorization to Resolvers
In the resolver functions, verify if the user has permission.

php
Copy code
'resolve' => function($root, $args, $context) {
    if (!$context->user->can('view', UserModel::class)) {
        throw new Exception("Unauthorized access");
    }
    return UserModel::getUserById($args['id']);
}
Step 3: Setting Context in the GraphQL Endpoint
Pass the authenticated user context to GraphQL resolvers.

php
Copy code
$context = [
    'user' => Auth::user()
];
$result = GraphQL::executeQuery($schema, $query, null, $context, $variables);
5. Conclusion and Best Practices
Summarize the importance of structuring GraphQL implementations in MVC and share best practices:

Use Types and Interfaces: Leverage PHP OOP principles by creating types and interfaces for clean, maintainable code.
Secure Data Access: Always check authorization in resolvers to prevent unauthorized data access.
Optimize Queries: Avoid excessive nested queries; leverage GraphQL fragments to manage complex data structures efficiently.
End of Script

*/ 