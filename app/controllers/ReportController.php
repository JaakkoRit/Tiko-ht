<?php

namespace App\App\Controllers;

use App\App\Models\TaskList;
use App\App\Models\Session;
use App\App\Models\Gate;

class ReportController
{
    public function __construct(){
        if(Gate::hasRole('opiskelija'))
            header('Location:/student-home');
    }

    public function showSessionRaport(){
        $tasklistArray = TaskList::all();
        $report = null;

        foreach ($tasklistArray as $tasklist) {
            $report .= getSessionReport($tasklist);
        }

        return view('session-report', compact('report'));
    }

    public function showTaskListSessionReport(){
        $tasklistArray = TaskList::all();
        $sessionArray = Session::all();
        $report = null;
        foreach ($tasklistArray as $tasklist) {
            $report .= getTaskListSessionReport($sessionArray, $tasklist);
        }

        return view('tasklistsession-report', compact('report'));
    }
    public function showTaskListTaskReport(){
        $tasklistArray = TaskList::all();

        $report = null;
        foreach ($tasklistArray as $tasklist) {
            $report .= getTaskReport($tasklist);
        }
        return view('tasklisttask-report', compact('report'));
    }
    public function showTaskDifficultyReport(){
        $tasklistArray = TaskList::all();

        $report = null;
        foreach ($tasklistArray as $tasklist) {
            $report .= getTaskDifficultyReport($tasklist);
        }
        return view('taskdifficulty-report', compact('report'));
    }
    public function showTaskSuccessReport(){

        $report = getTaskSuccess();
        return view('tasksuccess-report', compact('report'));
    }
}