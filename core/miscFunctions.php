<?php

use App\App\Models\Session;
use App\App\Models\Student;
use App\App\Models\TaskCompletion;
use App\App\Models\Attempt;
use App\App\Models\Task;
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

function setSessionTimeOfBeginning($taskIndex, $session)
{
    if ($taskIndex == 0) {
        Session::update($session->ID_SESSIO, [
            'ALKAIKA' => date("Y-m-d H:i:s")
        ]);
    }
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

function tableToHtml($tableName){
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

function reportToHtml($table, $columnNames, $caption){

    $tableHtml = "
    <div class=\"col-md-6 col-sm-12\">
        <div class=\"row\">
            <div class=\"col-md-10 col-sm-12 nopadding\">
                <div class=\"styledtable nopadding scroll-list\">
                    <table = class=\"stretched-table\">
                        <caption>".$caption."<caption>
                        <tr>";
                        foreach ($columnNames as $index) {
                                $tableHtml .= "<th>" . $index . "</th>";
                        }
                                 $tableHtml .= "</tr>";
                        if($table != null){
                            foreach ($table as $row) {
                                $tableHtml .= "<tr>";
                                foreach ($row as $index)
                                    $tableHtml .= "<td>" . $index . "</td>";
                                $tableHtml .= "</tr>";
                            }
                        }
                        $tableHtml .= "
                    </table>
                </div>
            </div>
        </div>
    </div>";
    return $tableHtml;
}

function getSessionReport($tasklist){
    $count = 0;
    $sessionArray = Session::findAllWhere("ID_TLISTA", $tasklist->ID_TLISTA);
    $sessionsArray = null;
    foreach ($sessionArray as $session){
        $sessionsArray[$count][0] = $session->ID_SESSIO;
        $sessionsArray[$count][1] = Student::findWhere("ID_KAYTTAJA", $session->ID_KAYTTAJA)->NIMI;
        $sessionsArray[$count][2] = getRightAttemptCount(Attempt::findAllWhere("ID_SESSIO", $session->ID_SESSIO));
        if ($session->LOPAIKA == null)
            $sessionsArray[$count][3] = "Ei";
        else
            $sessionsArray[$count][3] = "Kyllä";
        $count++;
    }
    return reportToHtml($sessionsArray, array("Sessio", "Opiskelija", "Onnistuneiden lkm", "Suoritettu"), "Sessiot tehtävälistasta ".$tasklist->ID_TLISTA);
}
function getStudentReport($completedSessions){
    $count = 0;
    $completedSessionsArray = null;
    foreach($completedSessions as $session) {
        $completedSessionsArray[$count][0] = $session->ID_SESSIO;
        $completedSessionsArray[$count][1] = getRightAttemptCount(Attempt::findAllWhere("ID_SESSIO", $session->ID_SESSIO));
        $completedSessionsArray[$count][2] = gmdate("H:i:s", getSessionTime($session->ALKAIKA, $session->LOPAIKA));
        $count++;
    }
    return reportToHtml($completedSessionsArray, array("Sessio", "Oikein lkm", "Suoritusaika"), "Suoritetut sessiot");
}
function getTaskReport($tasklist){
    $tasks = Task::findAllTasksFromTaskList($tasklist->ID_TLISTA);
    $count = 0;
    $taskReportArray = null;
    foreach($tasks as $task){
        $attempts = Attempt::findAllWhere("ID_TEHTAVA", $task->ID_TEHTAVA);
        $taskReportArray[$count][0] = $task->KUVAUS;
        $taskReportArray[$count][1] = getPercentage($attempts);
        $taskReportArray[$count][2] = gmdate("H:i:s", getMeanTime($attempts));
        $count++;
    }
    return reportToHtml($taskReportArray, array("Tehtävä", "Onnistumisprosentti", "Keskim. suoritusaika"), "Tehtävän tilastot");
}
function getTaskListSessionReport($sessionArray, $tasklist){
    $fastest = 0; $slowest = 0;$freq = 0; $avgtime = 0; $timesum = 0;
    foreach ($sessionArray as $session){
        if($session->LOPAIKA != null) {
            if ($session->ID_TLISTA == $tasklist->ID_TLISTA) {
                $timedif = getSessionTime($session->ALKAIKA, $session->LOPAIKA);
                if ($timedif < $fastest || $fastest == 0)
                    $fastest = $timedif;
                if ($timedif > $slowest)
                    $slowest = $timedif;
                $freq++;
                $timesum = $timesum + $timedif;
                $avgtime = $timesum / $freq;
            }
        }
    }
    $sessionReportArray[0][0] = gmdate("H:i:s", $fastest);
    $sessionReportArray[0][1] = gmdate("H:i:s", $slowest);
    $sessionReportArray[0][2] = gmdate("H:i:s", $avgtime);

    return reportToHtml($sessionReportArray, array("Nopein suoritus", "Hitain suoritus", "Keskim. suoritusaika"), "Tehvalista ".$tasklist->ID_TLISTA.":n sessioiden raportti");
}
function getTaskDifficultyReport($tasklist){
    $tasks = Task::findAllTasksFromTaskList($tasklist->ID_TLISTA);
    $taskReportArray = array();
    $count = 0;
    foreach($tasks as $task){
        $taskCompletions = TaskCompletion::findAllWhere("ID_TEHTAVA", $task->ID_TEHTAVA);
        $sum = 0;
        $avgtime = 0;
        foreach($taskCompletions as $taskCompletion){
            $sum = $sum + getSessionTime($taskCompletion->ALKAIKA, $taskCompletion->LOPAIKA);
        }
        if(sizeof($taskCompletions) != 0)
            $avgtime = number_format((float)$sum / sizeof($taskCompletions), 1, '.', '');
        else
            $avgtime = 0;
        $taskReportArray[$count][0] = $task->ID_TEHTAVA;
        $taskReportArray[$count][1] = $avgtime;
        $taskReportArray[$count][2] = getMeanAttempts($task);
        $taskReportArray[$count][3] = getUnsolvedPercentage($task, $taskCompletions);
        $count++;
    }
    usort($taskReportArray, build_sorter(1));
    return reportToHtml($taskReportArray, array("Tehtävä", "Keskimääräinen suoritusaika", "Onnistuneesti ratkaistujen tehtävien yritysten keskimääräinen lkm", "Ratkaisemattomien prosenttiosuus"), "Tehtävälistan ".$tasklist->ID_TLISTA." tehtävät vaikeusjärjestyksessä");
}
function getRightAttemptCount($attemptArray){
    $rightcount = 0;
    foreach ($attemptArray as $attempt) {
        if ($attempt->OLIKOOIKEIN == '1')
            $rightcount++;
    }
    return $rightcount;
}
function getSessionTime($start, $finish){
    sscanf($start, "%d:%d:%d", $hours, $minutes, $seconds);
    $strtime = isset($seconds) ? $hours * 3600 + $minutes * 60 + $seconds : $hours * 60 + $minutes;

    sscanf($finish, "%d:%d:%d", $hours, $minutes, $seconds);
    $endtime = isset($seconds) ? $hours * 3600 + $minutes * 60 + $seconds : $hours * 60 + $minutes;

    $sessionTime = $endtime - $strtime;

    return $sessionTime;
}

function getPercentage($attempts){
    $divisor = sizeof($attempts);
    $dividend = 0;
    foreach($attempts as $attempt){
        if($attempt->OLIKOOIKEIN == 1)
            $dividend++;
    }
    if($divisor != 0)
        return  number_format((float)$dividend / $divisor * 100, 2, '.', '');
    else
        return 0;
}
function getMeanTime($attempts){
    $sum = 0;
    $freq = 0;
    foreach($attempts as $attempt){
        $sum = $sum + getSessionTime($attempt->ALKAIKA, $attempt->LOPAIKA);
        $freq++;
    }
    if($freq != 0)
        return $sum / $freq;
    else
        return 0;

}
function getMeanAttempts($task){
    $rightArray = Attempt::findAllAttempts("OLIKOOIKEIN", 1, "ID_TEHTAVA", $task->ID_TEHTAVA);
    $sum = 0;
    foreach($rightArray as $try) {
        $sum = $sum + $try->YRITYSKERTA;
    }
    if(sizeof($rightArray) != 0)
        return number_format((float)$sum / sizeof($rightArray), 1, '.', '');
    else
        return "Ei oikeita ratkaisuja";
}

function getUnsolvedPercentage($task, $taskCompletions){
    $failedAttempts = Attempt::findAllAttempts("ID_TEHTAVA", $task->ID_TEHTAVA, "OLIKOOIKEIN", 0);
    $failedCount = 0;
    foreach($failedAttempts as $attempt){
        if($attempt->YRITYSKERTA == 3)
            $failedCount++;
    }
    $completed = 0;
    foreach($taskCompletions as $taskCompletion){
        if($taskCompletion->LOPAIKA != null)
            $completed++;
    }
    if($completed != 0)
        return  number_format((float)$failedCount / $completed * 100, 0, '.', '')."%";
    else
        return 0;
}
function build_sorter($key) {
    return function ($a, $b) use ($key) {
        return strnatcmp($b[$key], $a[$key]);
    };
}