<?php

namespace App\App\Controllers;

use App\App\Models\Session;
use App\App\Models\Attempt;
use App\App\Models\TaskList;
use App\App\Models\Student;
use App\App\Models\Gate;

class ReportController
{
    public function __construct(){
        if(Gate::hasRole('opiskelija'))
            header('Location:/student-home');
    }
    public function showSessionRaport(){
        $taskListCreator = $_SESSION['id_kayttaja'];
        $tasklistArray = TaskList::findAllWhere("ID_KAYTTAJA", $_SESSION['id_kayttaja']);
        $sessionArray = Session::all();
        $studentArray = Student::all();
        $attemptArray = Attempt::all();
        return view('session-report', compact('sessionArray', 'attemptArray', 'studentArray', 'tasklistArray', 'taskListCreator'));
    }
    public function showTaskListSessionReport(){
        $taskListCreator = $_SESSION['id_kayttaja'];
        $tasklistArray = TaskList::findAllWhere("ID_KAYTTAJA", $_SESSION['id_kayttaja']);
        $sessionArray = Session::all();
        return view('tasklistsession-report', compact('tasklistArray', 'sessionArray', 'taskListCreator'));
    }
}