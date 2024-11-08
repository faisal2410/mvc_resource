<?php
// File: index.php
require 'models/User.php';
require 'controllers/UserController.php';

// Set up PDO and instantiate model
$pdo = new PDO('mysql:host=localhost;dbname=testdb', 'root', '');
$userModel = new User($pdo);

// Instantiate controller
$userController = new UserController($userModel);

// Example request to show user profile with ID 1
$userController->showProfile(5);
