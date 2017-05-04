<?php

namespace App\App\Controllers;

use App\App\Models\Answer;
use App\App\Models\Gate;
use App\App\Models\Task;
use App\App\Models\TaskInTaskList;
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

        $message = getMessage();

        return view('tasks', compact('tasks', 'message'));
    }

    public function create()
    {
        $req = App::get('request');

        $tasks = [];
        $id = $req->get('id');

        if (isset($id)) {
            $tasks = Task::all();
        }

        $errors = getErrors();

        return view('tasks-create', compact('errors', 'id', 'tasks'));
    }

    public function save()
    {
        $req = App::get('request');
        $db = App::get('database');

        $errors = (new Validator([
            'kuvaus' => 'required',
            'vastaus' => 'required',
        ]))->validate();

        if (count($errors) > 0) {
            $_SESSION['errors'] = $errors;
            header('Location: /tasks/create');
        }
        else {
            $db->beginTransaction();
            try {
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

                $id = $req->get('id');

                if (isset($id)) {
                    TaskInTaskList::create([
                        'ID_TEHTAVA' => $taskId,
                        'ID_TLISTA' => $id
                    ]);
                }
            }
            catch (\Exception $e)
            {
                $db->rollback();
                $errors[] = $e->getMessage();
                $_SESSION['errors'] = $errors;
                header('Location: /tasks/create');
                die();
            }
            $db->commit();
            header('Location: /tasks');
        }
    }

    public function edit()
    {
        $req = App::get('request');

        $task = Task::find($req->get('id'));
        $answers = Answer::findAllWhere('ID_TEHTAVA', $task->ID_TEHTAVA);

        $errors = getErrors();
        $message = getMessage();

        return view('edit-task', compact('task', 'answers', 'errors', 'message'));
    }

    public function update()
    {
        $req = App::get('request');

        $errors = [];
        $inputs = $req->request->all();

        $previousPage = $req->headers->get('referer');

        foreach ($inputs as $key => $value) {
            $errors = array_merge($errors, (new Validator([
                $key => 'required'
            ]))->validate());
        }

        if (count($errors) > 0) {
            $_SESSION['errors'] = $errors;
            header("Location: $previousPage");
        } else {
            $newAnswers = preg_grep_keys('/^(vastaus)/', $inputs);
            $ogAnswers = preg_grep_keys('/^(alkuperainen)/', $inputs);

            $index = 0;

            foreach ($newAnswers as $new) {
                Answer::updateWhere(
                    'VASTAUS', $ogAnswers["alkuperainen$index"],
                    ['VASTAUS' => $new]
                );
                $index += 1;
            }

            Task::update($req->get('id'), ['KUVAUS' => $req->get('kuvaus')]);

            $_SESSION['message'] = 'Päivitys onnistui!';

            header("Location: $previousPage");
        }
    }

    public function delete()
    {
        $req = App::get('request');

        Task::delete($req->get('id'));

        $_SESSION['message'] = 'Tehtävä poistettu!';

        header('Location: /tasks');
    }
}