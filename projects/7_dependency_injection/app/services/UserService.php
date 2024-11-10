<?php
// app/services/UserService.php

class UserService
{
    private $userModel;

    public function __construct($userModel)
    {
        $this->userModel = $userModel;
    }

    public function getAllUsers()
    {
        return $this->userModel->findAll();
    }
}
