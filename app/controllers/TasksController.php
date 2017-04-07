<?php

namespace App\App\Controllers;

use App\App\Models\Task;
use App\Core\App;

class TasksController
{
    #GET /tasks
    public function index()
    {
        $message = '';

        if (isset($_SESSION['message'])) {
            $message = $_SESSION['message'];
            unset($_SESSION['message']);
        }

        $_SESSION['token'] = '';
        $token = md5(mt_rand(1, 1000000) . 'fuubar');
        $_SESSION['token'] = $token;

        $tasks = Task::all();

        require __DIR__ . "/../resources/views/task.view.php";
    }

    #POST /tasks
    public function save($data)
    {
        if (! isset($_SESSION['name'])) {
            return view('login', ['message' => 'Please log in to do that.']);
        }

        $request = App::get('request');

        if (! isset($_SESSION['token']) || $request->get('token') !== $_SESSION['token']) {
            throw new \Exception('CSRF TOKEN MISMATCH EXCEPTION');
        }

        $id = Task::create([
            'description' => $request->get('description'),
            'completed' => false
        ]);

        header('Location: /index.php/todos');
    }
}