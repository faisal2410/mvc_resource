<?php

namespace App\Controllers;

class AboutController
{
    public function index()
    {
        // Load data from the model
        $data = ['title' => 'Welcome to about page of Our Site!'];

        // Load the view and pass data to it
        require __DIR__.'/../views/about.php';
    }
}
