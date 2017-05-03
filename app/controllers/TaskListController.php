<?php

namespace App\App\Controllers;

use App\App\Models\Gate;
use App\App\Models\Task;
use App\App\Models\TaskInTaskList;
use App\App\Models\TaskList;
use App\Core\App;
use App\Core\Validator;

class TaskListController
{
    public function __construct()
    {
        if (! auth() && Gate::hasRole('opiskelija')) {
            header('Location: /');
        }
    }

    public function index()
    {
        $taskLists = TaskList::all();
        $message = getMessage();

        return view('tasklists', compact('taskLists', 'message'));
    }

    public function create()
    {
        $tasks = Task::all();

        $errors = getErrors();

        return view('tasklists-create', compact('tasks', 'errors'));
    }

    public function save()
    {
        $req = App::get('request');

        $errors = (new Validator([
            'kuvaus' => 'required',
            'tehtavat' => 'required'
        ]))->validate();

        if (count($errors) > 0) {
            $_SESSION['errors'] = $errors;
            header('Location: /tasklists/create');
        }

        $taskIds = getIds($req->get('tehtavat'));

        $taskListId = TaskList::create([
            'ID_KAYTTAJA' => auth()->ID_KAYTTAJA,
            'KUVAUS' => $req->get('kuvaus'),
            'LUOMPVM' => date('y-m-d')
        ]);

        foreach ($taskIds as $taskId) {
            TaskInTaskList::create([
                'ID_TLISTA' => $taskListId,
                'ID_TEHTAVA' => $taskId
            ]);
        }

        header('Location: /tasklists');
    }

    public function show()
    {
        $req = App::get('request');
        $id = $req->get('id');
        $taskListCreator = TaskList::find($id)->ID_KAYTTAJA;
        $tasks = Task::findAllTasksFromTaskList($id);

        return view('show-tasklist', compact(
            'tasks',
            'taskListCreator',
            'id'));
    }

    public function edit()
    {
        $req = App::get('request');
        $id = $req->get('id');
        $taskList = TaskList::find($id);

        if (! Gate::hasRole('admin') && ! auth()->ID_KAYTTAJA == $taskList->ID_KAYTTAJA) {
            header('Location: /');
        }

        $tasks = Task::findAllTasksFromTaskList($id);

        return view('edit-tasklist', compact(
            'tasks',
            'id'));
    }

    public function update()
    {
        $req = App::get('request');

        $errors = (new Validator([
            'tehtavat' => 'required'
        ]))->validate();

        if (count($errors) > 0) {
            $_SESSION['errors'] = $errors;
            header('Location: ' . getReferer());
        } else {
            $taskIds = getIds($req->get('tehtavat'));

            foreach ($taskIds as $taskId) {
                TaskInTaskList::create([
                    'ID_TLISTA' => $req->get('id'),
                    'ID_TEHTAVA' => $taskId
                ]);
            }

            header('Location: /tasklists');
        }
    }

    public function delete()
    {
        $req = App::get('request');

        TaskList::delete($req->get('id'));
        TaskInTaskList::deleteWhere('ID_TLISTA', $req->get('id'));

        $_SESSION['message'] = 'Tehtävälista poistettu!';

        header('Location: /tasklists');
    }

    public function deleteTask()
    {
        $req = App::get('request');

        TaskInTaskList::deleteTaskInTaskList(
            $req->get('tlistaId'),
            $req->get('tehtavaId')
        );

        $previousPage = $req->headers->get('referer');
        header("Location: $previousPage");
    }
}