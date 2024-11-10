<?php
// app/controllers/UserController.php

class UserController
{
    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function listUsers()
    {
        $users = $this->userService->getAllUsers();
        // print_r($users);
        // foreach ($users as $user) {
        //     echo $user['name'] . "<br>";
        // }
    }
}
