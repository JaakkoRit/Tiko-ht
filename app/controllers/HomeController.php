<?php

namespace App\App\Controllers;

class HomeController
{
    public function __construct()
    {
        if (auth()) {
            header('Location: ' . getHomePage());
        }
    }

    public function index()
    {
        return view('index');
    }
}