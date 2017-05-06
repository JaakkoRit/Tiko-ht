<?php

namespace App\App\Controllers;

use App\App\Models\Answer;
use App\App\Models\Session;
use App\App\Models\Task;
use App\App\Models\TaskCompletion;
use App\App\Models\TaskList;
use App\App\Models\Query;
use App\Core\App;
use App\Core\Validator;

class SessionController
{
    public function show()
    {
        $req = App::get('request');
        $sessionId = $req->get('sessionid');
        $session = Session::find($sessionId);

        if (! sessionConfirmed($session)) {
            header('Location: ' . getHomePage());
            die();
        }

        $tasks = Task::findAllTasksFromTaskList($session->ID_TLISTA);
        $task = null;
        $index = null;

        foreach ($tasks as $key => $value) {
            $taskCompletion = TaskCompletion::findTaskCompletion('ID_TEHTAVA', $value->ID_TEHTAVA, 'ID_SESSIO', $sessionId);
            if (!$taskCompletion || !$taskCompletion->LOPAIKA) {
                $task = $value;
                $index = $key;
                break;
            }
        }

        $courses = arrayToHtml('kurssit');
        $students = arrayToHtml('opiskelijat');
        $courseCompletion = arrayToHtml('suoritukset');
        $errors = getErrors();
        $queryResult = queryToHtml(getQueryResult());
        $correctTable = queryToHtml(getCorrectTable());

        if (!anyTasksLeft($index, $tasks, $session)) {
            $completed = true;
            Query::dropSchema($sessionId);
            return view('session', compact('completed', 'courses', 'students',
                'courseCompletion', 'errors', 'queryResult', 'correctTable'));
        }

        $timeAtStart = date("Y-m-d H:i:s");

        if (startOfSession($session)) {
            setSessionTimeOfBeginning($session);
            createExampleTables($session->ID_SESSIO);
        }

        createTaskCompletion($sessionId, $tasks, $index, $timeAtStart);

        return view('session', compact('task', 'sessionId', 'timeAtStart', 'courses', 'students',
            'courseCompletion', 'queryResult', 'errors', 'correctTable'));
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

        $db = App::get('database');
        $exmplanswers = Answer::findAllWhere('ID_TEHTAVA', $req->get('tehtavaId'));
        $lowerCaseAnswersArray = answersLowerCase($exmplanswers);
        $lowerCaseAnswer = strtolower($req->get('vastaus'));
        $result = null;
        $correct = false;

        Query::setSearchPathTo('esimtaulut' . $req->get('sessionId'));

        $db->beginTransaction();
        try {
            $result = Query::rawQuery($lowerCaseAnswer);
            $_SESSION['queryResult'] = $result;
        } catch (\Exception $e) {
            $_SESSION['errors'] = $e->getMessage();
        }
        $db->rollback();

        $db->beginTransaction();
        foreach ($lowerCaseAnswersArray as $row) {
            $correctTable = Query::rawQuery($row);
            $_SESSION['correctTable'] = $correctTable;
            if ($result == $correctTable) {
                $correct = true;
                $db->commit();
                break;
            } else {
                $db->rollback();
            }
        }

        Query::setSearchPathTo('tiko');

        if ($correct) {
            $db->beginTransaction();
            try {
                createAttempt($req, $lowerCaseAnswer, true);
                updateTaskCompletion($req);
                $db->commit();
                header("Location: $nextPage");
            } catch (\Exception $e) {
                $db->rollback();
                header("Location: $nextPage");
            }
        } else {
            $db->beginTransaction();
            try {
                $attemptCount = createAttempt($req, $lowerCaseAnswer, false);
                if ($attemptCount >= 2) {
                    updateTaskCompletion($req);
                    $db->commit();
                    header("Location: $nextPage");
                } else {
                    $db->commit();
                    header("Location: $previousPage");
                }
            } catch (\Exception $e) {
                $db->rollback();
                header("Location: $previousPage");
            }
        }
    }
}