<?php

namespace App\App\Controllers;

use App\App\Models\Answer;
use App\App\Models\Session;
use App\App\Models\Task;
use App\App\Models\TaskList;
use App\Core\App;
use App\Core\Validator;

class SessionController
{
    public function show()
    {
        $req = App::get('request');
        $sessionId = $req->get('sessionid');

        $session = Session::find($sessionId);
        $taskList = TaskList::find($session->ID_TLISTA);
        $tasks = Task::findAllTasksFromTaskList($taskList->ID_TLISTA);

        $taskIndex = $req->get('taskIndex');

        if ($taskIndex >= count($tasks)) {
            header('Location: /student-home');
        }

        $task = $tasks[$taskIndex];

        return view('session', compact('task', 'taskIndex', 'sessionId'));
    }

    public function save()
    {
        $req = App::get('request');

        $previousPage = $req->headers->get('referer');
        $nextPage = $req->get('seuraavaSivu');

        $errors = (new Validator([
            'vastaus' => 'required'
        ]))->validate();

        if (count($errors) > 0) {
            header("Location: $previousPage");
        }

        $answers = Answer::findAllWhere('ID_TEHTAVA', $req->get('tehtavaId'));

        $lowerCaseAnswersArray = [];

        foreach ($answers as $answer) {
            $lowerCaseAnswersArray[] = strtolower($answer->VASTAUS);
        }

        $lowerCaseAnswer = strtolower($req->get('vastaus'));

        if (in_array($lowerCaseAnswer, $lowerCaseAnswersArray)) {
            header("Location: $nextPage");
        } else {
            header("Location: $previousPage");
        }
    }
}