<?php

use App\App\Models\Session;
use App\App\Models\TaskCompletion;
use App\App\Models\Attempt;
use App\App\Models\Query;
use App\Core\App;
use App\App\Models\Gate;

function anyTasksLeft($taskIndex, $tasks, $session)
{
    if ($taskIndex >= count($tasks)) {
        Session::update($session->ID_SESSIO, [
            'LOPAIKA' => date("Y-m-d H:i:s")
        ]);

        return false;
    }
    return true;
}

function setSessionTimeOfBeginning($session)
{
    Session::update($session->ID_SESSIO, [
        'ALKAIKA' => date("Y-m-d H:i:s")
    ]);
}

function createTaskCompletion($sessionId, $tasks, $taskIndex, $timeAtStart)
{
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
}

function answersLowerCase($answers)
{
    $lowerCaseAnswersArray = [];

    foreach ($answers as $answer) {
        $lowerCaseAnswersArray[] = strtolower($answer->VASTAUS);
    }

    return $lowerCaseAnswersArray;
}

function correctAnswer($answer, $answerArray)
{
    return in_array($answer, $answerArray);
}

function createAttempt($req, $answer, $correct)
{
    $attempts = Attempt::findAllAttempts(
        'ID_TEHTAVA',
        $req->get('tehtavaId'),
        'ID_SESSIO',
        $req->get('sessionId')
    );

    Attempt::create([
        'ID_TEHTAVA' => $req->get('tehtavaId'),
        'ID_SESSIO' => $req->get('sessionId'),
        'YRITYSKERTA' => count($attempts)+1,
        'VASTAUS' => $answer,
        'ALKAIKA' => $req->get('timeAtStart'),
        'LOPAIKA' => date("Y-m-d H:i:s"),
        'OLIKOOIKEIN' => $correct
    ]);

    return count($attempts);
}

function updateTaskCompletion($req) {
    TaskCompletion::updateTaskCompletion(
        $req->get('tehtavaId'),
        $req->get('sessionId'),
        date("Y-m-d H:i:s")
    );
}

function getQueryResult(){
    $queryResult = [];

    if(isset($_SESSION['queryResult'])){
        $queryResult = $_SESSION['queryResult'];
        unset($_SESSION['queryResult']);
    }
    return $queryResult;
}

function getCorrectTable(){
    $correctTable = [];

    if(isset($_SESSION['correctTable'])){
        $correctTable = $_SESSION['correctTable'];
        unset($_SESSION['correctTable']);
    }
    return $correctTable;
}

function arrayToHtml($tableName){
    $table = Query::rawQuery(Session::selectFrom($tableName, '*'));
    $columnNames = Query::rawQuery(Session::selectColumnNames($tableName));
    $tableHtml = "<table style=\"width:100%\"><caption>$tableName</caption><tr>";
    foreach ($columnNames as $row) {
        foreach ($row as $index)
            $tableHtml .= "<th>" . $index . "</th>";
    }
    $tableHtml .= "</tr>";
    foreach ($table as $row) {
        $tableHtml .= "<tr>";
        foreach ($row as $index)
            $tableHtml .= "<td>" . $index . "</td>";
        $tableHtml .= "</tr>";
    }
    $tableHtml .= "</table><br>";
    return $tableHtml;
}

function getQueryType($answer) {
    $query = explode(' ', $answer);

    return strtoupper($query[0]);
}

function getIds($ids) {
    return explode(' ', $ids);
}

function getErrors() {
    $errors = [];

    if (isset($_SESSION['errors'])) {
        $errors = $_SESSION['errors'];
        unset($_SESSION['errors']);
    }

    return $errors;
}

function getMessage() {
    $message = null;

    if (isset($_SESSION['message'])) {
        $message = $_SESSION['message'];
        unset($_SESSION['message']);
    }

    return $message;
}

function preg_grep_keys($pattern, $input, $flags = 0) {
    return array_intersect_key($input, array_flip(preg_grep($pattern, array_keys($input), $flags)));
}

function getReferer() {
    return \App\Core\App::get('request')
        ->headers
        ->get('referer');
}

function urlMatches($pattern) {
    return preg_grep($pattern, [$_SERVER['REQUEST_URI']]);
}

function getHomePage() {
    if (Gate::hasRole('opiskelija')) {
        return '/student-home';
    } else if (Gate::hasRole('opettaja')) {
        return '/teacher-home';
    } else if (Gate::hasRole('admin')) {
        return '/admin-home';
    }
    return '/';
}
function queryToHtml($table){
    $tableHtml = "<table style=\"width:100%\">";
    foreach($table as $row){
        $first = true;
        $tableHtml .= "<tr>";
        foreach($row as $index) {
            if ($first) {
                $first = false;
            }
            else
                $tableHtml .= "<td>" . $index . "</td>";
        }
        $tableHtml .= "</tr>";
    }
    $tableHtml .= "</table><br>";
    return $tableHtml;
}

function startOfSession($session) {
    return $session->ALKAIKA == null;
}

function sessionConfirmed($session) {
    if (! $session || $session->ID_KAYTTAJA != auth()->ID_KAYTTAJA || $session->LOPAIKA) {
        $_SESSION['error'] = 'Sessiota ei löytynyt tälle käyttäjälle tai se on jo suoritettu.';
        return false;
    }
    return true;
}

function createExampleTables($id) {
    Query::createSchema($id);
    Query::createExampleTables($id);
    Query::insertExampleValues($id);
}