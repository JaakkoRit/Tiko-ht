<?php
/**
 * Created by PhpStorm.
 * User: ritol
 * Date: 11.4.2017
 * Time: 23.37
 */

namespace App\App\Controllers;

use App\Core\App;
use App\App\Models\Teacher;

class TeacherController
{
    public function create()
    {
        return view('teacher-login');
    }

    public function save()
    {
        $req = App::get('request');
        $teacher = Teacher::findWhere('ONRO', $req->get('onro'));

        if ($teacher && password_verify($req->get('salasana'), $teacher->SALASANA)) {
            $_SESSION['id_kayttaja'] = $teacher->ID_KAYTTAJA;
            $_SESSION['nimi'] = $teacher->NIMI;
            $_SESSION['onro'] = $teacher->ONRO;

            header('Location: /');
        }

        return view('teacher-login', ['message' => 'Opettajanumero tai salasana väärin.']);
    }
}