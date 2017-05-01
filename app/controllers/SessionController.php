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
        $taskIndex = $req->get('taskIndex');

        $session = Session::find($sessionId);
        $taskList = TaskList::find($session->ID_TLISTA);
        $tasks = Task::findAllTasksFromTaskList($taskList->ID_TLISTA);

        if (! anyTasksLeft($taskIndex, $tasks, $session))
        {
            header('Location: /student-home');
        }

        $timeAtStart = date("Y-m-d H:i:s");

        setSessionTimeOfBeginning($taskIndex, $session);
        createTaskCompletion($sessionId, $tasks, $taskIndex, $timeAtStart);

        $task = $tasks[$taskIndex];

        return view('session', compact('task', 'taskIndex', 'sessionId', 'timeAtStart', 'coursesTable', 'studentsTable', 'courseCompletionTable'));
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

        $explanswers = Answer::findAllWhere('ID_TEHTAVA', $req->get('tehtavaId'));

        $lowerCaseAnswersArray = answersLowerCase($explanswers);
        $lowerCaseAnswer = strtolower($req->get('vastaus'));

        $db = App::get('database');
        $answer = $db->query($lowerCaseAnswer);

        $correct = null;
        foreach($lowerCaseAnswersArray as $row){
            $sql = $row->VASTAUS;
            $explAnswer = $db->query($sql);
            if($answer == $explAnswer)
                $correct = true;
        }
        if ($correct)
        {
            $db->beginTransaction();
            try {
                createAttempt($req, $lowerCaseAnswer, true);
                updateTaskCompletion($req);
                $db->commit();
                header("Location: $nextPage");
            }
            catch (\Exception $e) {
                $db->rollback();
            }
        }
        else
        {
            $db->beginTransaction();
            try {
                $attemptCount = createAttempt($req, $lowerCaseAnswer, false);
                if ($attemptCount >= 2)
                {
                    updateTaskCompletion($req);
                    $db->commit();
                    header("Location: $nextPage");
                }
                else
                {
                    $db->commit();
                    header("Location: $previousPage");
                }
            }
            catch (\Exception $e) {
                $db->rollback();
            }
        }

    }
}