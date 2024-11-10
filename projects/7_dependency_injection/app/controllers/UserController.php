<?php
// app/controllers/UserController.php

class UserController
{
    private $userService;

    public function __construct($userService)
    {
        $this->userService = $userService;
    }

    public function listUsers()
    {
        $users = $this->userService->getAllUsers();
        print_r($users);
        // foreach ($users as $user) {
        //     echo $user['name'] . "<br>";
        // }
    }
}
