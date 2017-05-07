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

        $errors = getErrors();
        $sqlError = getSQLError();
        $queryResult = null;
        $correctTable = null;
        $correctAnswer = getCorrectAnswer();
        $correct = getCorrect();
        $syntaxErrors = getSyntaxErrors();

        if (isset($_SESSION['queryResult']) &&
            $_SESSION['queryResult'] != 1 && $_SESSION['queryResult'] != 0) {
            $queryResult = queryToHtml(getQueryResult());
        } else {
            $queryResult = getQueryResult();
        }

        if (isset($_SESSION['correctTable']) &&
            $_SESSION['correctTable'] != 1 && $_SESSION['correctTable'] != 0) {
            $correctTable = queryToHtml(getCorrectTable());
        } else {
            $correctTable = getCorrectTable();
        }

        $timeAtStart = date("Y-m-d H:i:s");

        if (startOfSession($session)) {
            setSessionTimeOfBeginning($session);
            createExampleTables($session->ID_SESSIO);
        }

        createTaskCompletion($sessionId, $tasks, $index, $timeAtStart);

        $courses = tableToHtml("esimtaulut$sessionId.kurssit");
        $students = tableToHtml("esimtaulut$sessionId.opiskelijat");
        $courseCompletion = tableToHtml("esimtaulut$sessionId.suoritukset");

        if ($task == null) {
            $completed = true;
            Query::dropSchema($sessionId);
            setSessionTimeOfEnding($session);
            return view('session', compact('completed', 'courses', 'students',
                'courseCompletion', 'errors', 'queryResult', 'correctTable', 'correctAnswer', 'correct', 'syntaxErrors', 'sqlError'));
        }


        return view('session', compact('task', 'sessionId', 'timeAtStart', 'courses', 'students',
            'courseCompletion', 'queryResult', 'errors', 'correctTable', 'correctAnswer', 'correct', 'syntaxErrors', 'sqlError'));
    }

    public function save()
    {
        $req = App::get('request');
        $previousPage = $req->headers->get('referer');
        $nextPage = $req->get('seuraavaSivu');
        $tyyppi = $req->get('tyyppi');

        $errors = (new Validator([
            'vastaus' => 'required'
        ]))->validate();

        if (count($errors) > 0) {
            $_SESSION['errors'] = $errors;
            header("Location: $previousPage");
            die();
        }

        $db = App::get('database');
        $exmplanswers = Answer::findAllWhere('ID_TEHTAVA', $req->get('tehtavaId'));
        $lowerCaseAnswersArray = answersLowerCase($exmplanswers);
        $lowerCaseAnswer = strtolower($req->get('vastaus'));

        if ($lowerCaseAnswer == null) {
            header('Location: ' . $previousPage);
        }

        $result = null;
        $correct = false;

        Query::setSearchPathTo('esimtaulut' . $req->get('sessionId'));

        $db->beginTransaction();
        try {
            if ($tyyppi == 'DELETE' || $tyyppi == 'INSERT') {
                $result = Query::rawQueryExecute($lowerCaseAnswer);
            } else {
                $result = Query::rawQuery($lowerCaseAnswer);
            }
            $_SESSION['queryResult'] = $result;
        } catch (\Exception $e) {
            $_SESSION['sqlError'] = $e->getMessage();
        }
        $db->rollback();

        $db->beginTransaction();
        foreach ($lowerCaseAnswersArray as $row) {
            if ($tyyppi == 'DELETE' || $tyyppi == 'INSERT') {
                $correctTable = Query::rawQueryExecute($row);
            } else {
                $correctTable = Query::rawQuery($row);
            }
            $_SESSION['correctTable'] = $correctTable;
            if ($result == $correctTable) {
                $correct = true;
                $db->commit();
                break;
            } else {
                Query::setSearchPathTo('tiko');
                if (countAttempts($req->get('tehtavaId'), $req->get('sessionId')) >= 2) {
                    $db->commit();
                } else {
                    $db->rollback();
                }
            }
        }

        Query::setSearchPathTo('tiko');

        $syntaxErrors = checkForSyntaxErrors($lowerCaseAnswer);

        if (! empty($syntaxErrors)) {
            $correct = false;
        }

        if ($correct) {
            $db->beginTransaction();
            try {
                createAttempt($req, $lowerCaseAnswer, true);
                updateTaskCompletion($req);
                $db->commit();
                $_SESSION['correct'] = true;
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
                    $_SESSION['correct'] = false;
                    $_SESSION['syntaxErrors'] = $syntaxErrors;
                    $_SESSION['correctAnswer'] = $lowerCaseAnswersArray[0];
                    header("Location: $nextPage");
                } else {
                    $db->commit();
                    $_SESSION['syntaxErrors'] = $syntaxErrors;
                    $_SESSION['correct'] = false;
                    header("Location: $previousPage");
                }
            } catch (\Exception $e) {
                $db->rollback();
                header("Location: $previousPage");
            }
        }
    }
}