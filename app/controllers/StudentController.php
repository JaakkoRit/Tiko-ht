<?php

namespace App\App\Controllers;

use App\Core\App;
use App\App\Models\Student;

class StudentController
{
    public function create()
    {
        return view('student-login');
    }

    public function save()
    {
        $req = App::get('request');
        $student = Student::findWhere('ONRO', $req->get('onro'));

        if ($student && password_verify($req->get('salasana'), $student->SALASANA)) {
            $_SESSION['nimi'] = $student->NIMI;
            $_SESSION['onro'] = $student->ONRO;

            header('Location: /');
        }

        return view('student-login', ['message' => 'Opiskelijanumero tai salasana väärin.']);
    }

    public function destroy()
    {
        session_unset();
        session_destroy();

        header('Location: /');
    }
}