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
        require '../app/views/user_index.php';
    }

    public function create()
    {
        // Capture POST data
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->userModel->create($_POST['name'], $_POST['email']);
            header("Location: /?controller=user&action=index");
        }
        require '../app/views/user_create.php';
    }


    public function update()
    {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            echo "Invalid user ID.";
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Handle form submission
            $name = $_POST['name'];
            $email = $_POST['email'];
            $this->userModel->update($id, $name, $email);
            header("Location: /?controller=user&action=index");
        } else {
            // Display the form with existing user data
            $user = $this->userModel->getById($id);
            require '../app/views/user_update.php';
        }
    }

    public function delete()
    {
        $id = $_GET['id'] ?? null;
        if ($id && $this->userModel->delete($id)) {
            header("Location: /?controller=user&action=index");
        } else {
            echo "Unable to delete user.";
        }
    }

}
