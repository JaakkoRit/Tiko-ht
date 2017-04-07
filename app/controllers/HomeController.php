<?php

namespace App\App\Controllers;

class HomeController
{
    public function index()
    {
        $message = 'Hello World!';
        require __DIR__ . "/../resources/views/index.view.php";
    }

    public function about()
    {
        $message = 'Hello from about page!';
        require __DIR__ . "/../resources/views/about.view.php";
    }
}