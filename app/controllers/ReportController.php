<?php

namespace App\App\Controllers;

use App\App\Models\Session;
use App\App\Models\Attempt;
use App\App\Models\TaskList;
use App\App\Models\Student;
use App\App\Models\Gate;

class ReportController
{
    public function showSessionRaport(){
        if(Gate::hasRole('opiskelija'))
            return view('index');
        else {
            $sessionArray = Session::all();
            $tasklistArray = TaskList::all();
            $studentArray = Student::all();
            $attemptArray = Attempt::all();
            return view('session-report', compact('sessionArray', 'attemptArray', 'studentArray', 'tasklistArray'));
        }
    }
    public function showTaskListSessionReport(){
        if(Gate::hasRole('opiskelija'))
            return view('index');
        else{
            $tasklistArray = TaskList::all();
            $sessionArray = Session::all();
            $attemptArray = Attempt::all();
            return view('tasklistsession-report', compact('tasklistArray', 'sessionArray', 'attemptArray'));
        }
    }
}