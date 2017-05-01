<?php

namespace App\App\Controllers;

use App\App\Models\Answer;
use App\App\Models\Gate;
use App\App\Models\Task;
use App\Core\App;
use App\Core\Validator;

class TaskController
{
    public function __construct()
    {
        if (! auth() || Gate::hasRole('opiskelija')) {
            header('Location: /');
        }
    }

    public function index()
    {
        $tasks = Task::all();

        return view('tasks', compact('tasks'));
    }

    public function create()
    {
        $errors = getErrors();

        return view('tasks-create', compact('errors'));
    }

    public function save()
    {
        $req = App::get('request');

        $errors = (new Validator([
            'kuvaus' => 'required',
            'vastaus' => 'required',
        ]))->validate();

        if (count($errors) > 0) {
            $_SESSION['errors'] = $errors;
            header('Location: /tasks/create');
        }
        else {
            $queryType = getQueryType($req->get('vastaus'));

            $taskId = Task::create([
                'ID_KAYTTAJA' => auth()->ID_KAYTTAJA,
                'LUOMPVM' => date('y-m-d'),
                'KYSELYTYYPPI' => $queryType,
                'KUVAUS' => $req->get('kuvaus')
            ]);

            Answer::create([
                'ID_TEHTAVA' => $taskId,
                'VASTAUS' => $req->get('vastaus')
            ]);

            header('Location: /tasks');
        }
    }

    public function edit()
    {
        $req = App::get('request');

        $task = Task::find($req->get('id'));
        $answers = Answer::findAllWhere('ID_TEHTAVA', $task->ID_TEHTAVA);

        return view('edit-task', compact('task', 'answers'));
    }

    public function update()
    {
        $req = App::get('request');

        $errors = (new Validator([

        ]))->validate();

        $index = 0;
        $array = [];
        $continue = true;

        while ($continue) {
            $array[] = $req->get("vastaus$index");
            $index += 1;
            if ($req->get("vastaus$index") == null) {
                $continue = false;
            }
        }

        dd($array);
    }
}