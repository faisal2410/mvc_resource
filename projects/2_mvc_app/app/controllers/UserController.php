<?php

namespace App\Controllers;

use App\Models\User;
use PDO;

class UserController
{
    private $userModel;

    public function __construct()
    {
        $pdo = new PDO("mysql:host=localhost;dbname=mvc_app", "root", "");
        $this->userModel = new User($pdo);
    }

    public function index()
    {
        $users = $this->userModel->getAll();
        require '../app/Views/user_index.php';
    }

    public function create()
    {
        // Capture POST data
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->userModel->create($_POST['name'], $_POST['email']);
            header("Location: /?controller=user&action=index");
        }
        require '../app/Views/user_create.php';
    }


    public function update($id)
    {
        // Implement the update logic
    }


    public function delete($id)
    {
        // Implement the delete logic
    }


}
