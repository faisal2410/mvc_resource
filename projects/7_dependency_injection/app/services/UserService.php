<?php
// app/services/UserService.php

class UserService
{
    private User $userModel;

    public function __construct(User $userModel)
    {
        $this->userModel = $userModel;
    }

    public function getAllUsers()
    {
        return $this->userModel->findAll();
    }
}
