<?php
// index.php

require_once 'app/models/User.php';
require_once 'app/services/UserService.php';
require_once 'app/controllers/UserController.php';
require_once 'app/Logger.php';
require_once 'app/Database.php';

// Setup dependencies
$db = new Database();
$logger = new Logger();
$userModel = new User($db, $logger);
$userService = new UserService($userModel);
$userController = new UserController($userService);

// Run the application
$userController->listUsers();
