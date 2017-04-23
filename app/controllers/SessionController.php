<?php

namespace App\App\Controllers;

use App\App\Models\Answer;
use App\App\Models\Attempt;
use App\App\Models\Session;
use App\App\Models\Task;
use App\App\Models\TaskCompletion;
use App\App\Models\TaskList;
use App\Core\App;
use App\Core\Validator;

class SessionController
{
    public function show()
    {
        $req = App::get('request');

        $sessionId = $req->get('sessionid');
        $taskIndex = $req->get('taskIndex');

        $session = Session::find($sessionId);
        $taskList = TaskList::find($session->ID_TLISTA);
        $tasks = Task::findAllTasksFromTaskList($taskList->ID_TLISTA);

        if ($taskIndex >= count($tasks)) {
            Session::update($session->ID_SESSIO, [
                'LOPAIKA' => date("Y-m-d H:i:s")
            ]);

            header('Location: /student-home');
        }

        if ($taskIndex == 0) {
            Session::update($session->ID_SESSIO, [
                'ALKAIKA' => date("Y-m-d H:i:s")
            ]);
        }

        $timeAtStart = date("Y-m-d H:i:s");

        $taskCompletion = TaskCompletion::findTaskCompletion(
            'ID_SESSIO', $sessionId,
            'ID_TEHTAVA', $tasks[$taskIndex]->ID_TEHTAVA
        );

        if (! $taskCompletion) {
            TaskCompletion::create([
                'ID_TEHTAVA' => $tasks[$taskIndex]->ID_TEHTAVA,
                'ID_SESSIO' => $sessionId,
                'ALKAIKA' => $timeAtStart
            ]);
        }

        $task = $tasks[$taskIndex];

        return view('session', compact('task', 'taskIndex', 'sessionId', 'timeAtStart'));
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

            $attempts = Attempt::findAllAttempts('ID_TEHTAVA', $req->get('tehtavaId'), 'ID_SESSIO', $req->get('sessionId'));

            Attempt::create([
                'ID_TEHTAVA' => $req->get('tehtavaId'),
                'ID_SESSIO' => $req->get('sessionId'),
                'YRITYSKERTA' => count($attempts)+1,
                'VASTAUS' => $lowerCaseAnswer,
                'ALKAIKA' => $req->get('timeAtStart'),
                'LOPAIKA' => date("Y-m-d H:i:s"),
                'OLIKOOIKEIN' => true
            ]);

            TaskCompletion::updateTaskCompletion(
                $req->get('tehtavaId'),
                $req->get('sessionId'),
                date("Y-m-d H:i:s")
            );

            header("Location: $nextPage");
        } else {

            $attempts = Attempt::findAllAttempts('ID_TEHTAVA', $req->get('tehtavaId'), 'ID_SESSIO', $req->get('sessionId'));

            Attempt::create([
                'ID_TEHTAVA' => $req->get('tehtavaId'),
                'ID_SESSIO' => $req->get('sessionId'),
                'YRITYSKERTA' => count($attempts)+1,
                'VASTAUS' => $lowerCaseAnswer,
                'ALKAIKA' => $req->get('timeAtStart'),
                'LOPAIKA' => date("Y-m-d H:i:s"),
                'OLIKOOIKEIN' => false
            ]);

            if (count($attempts) >= 2) {
                TaskCompletion::updateTaskCompletion(
                    $req->get('tehtavaId'),
                    $req->get('sessionId'),
                    date("Y-m-d H:i:s")
                );

                header("Location: $nextPage");
            } else {
                header("Location: $previousPage");
            }
        }

    }

}