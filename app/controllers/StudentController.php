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
            $sessions = Session::findAllWhere('ID_KAYTTAJA', auth()->ID_KAYTTAJA);

            return view('student-home', compact('sessions'));
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
            $user = User::find($student->ID_KAYTTAJA);

            if ($student && password_verify($req->get('salasana'), $student->SALASANA)) {
                $_SESSION['id_kayttaja'] = $student->ID_KAYTTAJA;
                $_SESSION['nimi'] = $student->NIMI;
                $_SESSION['onro'] = $student->ONRO;
                $_SESSION['rooli'] = $user->ROOLI;

                header('Location: /student-home');
            }

            return view('login', ['message' => 'Opiskelijanumero tai salasana väärin.']);
        }

    }

    public function destroy()
    {
        session_unset();
        session_destroy();

        header('Location: /');
    }
}