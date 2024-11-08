<?php
// File: controllers/UserController.php
class UserController
{
    private $userModel;

    public function __construct($userModel)
    {
        $this->userModel = $userModel;
    }

    // Display user profile
    public function showProfile($userId)
    {
        $user = $this->userModel->find($userId);
        if ($user) {
            include 'views/userProfile.php'; // Load the view with user data
        } else {
            echo "User not found.";
        }
    }

    // Create a new user
    public function createUser($name, $email)
    {
        $result = $this->userModel->create($name, $email);
        if ($result) {
            echo "User created successfully!";
        } else {
            echo "Failed to create user.";
        }
    }
}
