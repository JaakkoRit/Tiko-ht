<?php

namespace App\App\Controllers;

use App\App\Models\User;
use App\Core\App;
use App\App\Models\Student;
use App\App\Models\Session;
use App\App\Models\Gate;

class StudentController
{
    public function index()
    {
        if(Gate::hasRole('opettaja'))
            header('Location:/teacher-home');
        else{
            $unCompletedSessions = Session::findAllUnCompletedSessions('ID_KAYTTAJA', auth()->ID_KAYTTAJA);
            $completedSessions = Session::findAllCompletedSessions('ID_KAYTTAJA', auth()->ID_KAYTTAJA);
            $completedSessionsReport = getStudentReport($completedSessions);

            return view('student-home', compact('unCompletedSessions', 'completedSessionsReport'));
        }
    }

    public function create()
    {
        if(Gate::hasRole('opettaja'))
            header('Location:/teacher-home');
        else
            return view('login');
    }

    public function save()
    {
        if(Gate::hasRole('opettaja'))
            header('Location:/teacher-home');
        else{
            $req = App::get('request');
            $student = Student::findWhere('ONRO', $req->get('onro'));

            if ($student && password_verify($req->get('salasana'), $student->SALASANA)) {
                $user = User::find($student->ID_KAYTTAJA);

                $_SESSION['id_kayttaja'] = $student->ID_KAYTTAJA;
                $_SESSION['nimi'] = $student->NIMI;
                $_SESSION['onro'] = $student->ONRO;
                $_SESSION['rooli'] = $user->ROOLI;

                header('Location: /student-home');
                die();
            }

            header('Location: /');
        }

    }

    public function destroy()
    {
        session_unset();
        session_destroy();

        header('Location: /');
    }
}