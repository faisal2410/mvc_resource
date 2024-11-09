<?php
include "Database.php";
include "User.php";
// Instantiate the database connection
$db = new Database();

// Create a new User model
$userModel = new User($db);

// Create a new user
// $newUserId = $userModel->create('John Doe', 'john@example.com');
// echo "New User ID: $newUserId\n";


// Find the user by ID
//  $user = $userModel->findById($newUserId);
 $user = $userModel->findById(8);
 print_r($user);
 echo "User Found: " . $user['name'] . " (" . $user['email'] . ")\n";
 
 // Update the user's name and email
//  $userModel->update($newUserId, 'Jane Doe', 'jane@example.com');
//  $userModel->update(8, 'Jane Doe', 'jane@example.com');
//  echo "User Updated\n";

// Check if email is registered
if ($userModel->isEmailRegistered('jane@example.com')) {
    echo "Email is registered.\n";
    }
    
    // Delete the user
    // $userModel->delete($newUserId);
    $userModel->delete(8);
    echo "User Deleted\n";
    /*
*/ 
