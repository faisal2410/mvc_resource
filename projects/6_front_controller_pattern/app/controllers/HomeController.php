<?php

namespace App\Controllers;

class HomeController
{
    public function index()
    {
        // Load data from the model
        $data = ['title' => 'Welcome to Our Site!'];

        // Load the view and pass data to it
  
        require_once __DIR__."/../views/home.php";
    }
}
