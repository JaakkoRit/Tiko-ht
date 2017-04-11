<?php

namespace App\App\Controllers;


use App\App\Models\Student;
use App\App\Models\Teacher;
use App\App\Models\User;
use App\Core\App;
use App\Core\Validator;

class DevController
{

    /*
     *|-----------------------------------
     *| Opiskelija
     *|-----------------------------------
     *| Nämä funktiot ovat opiskelijoiden
     *| rekisteröintiinn tarkoitettuja
     *| funktioita.
     *|
     */
    public function create()
    {
        return view('student-registration');
    }

    public function save()
    {
        $req = App::get('request');

        $errors = (new Validator([
            'onro' => 'required',
            'nimi' => 'required',
            'paaaine' => 'required',
            'salasana' => 'required',
        ]))->validate();

        if (count($errors) > 0) {
            return view('student-registration', compact('errors'));
        }

        $studentId = Student::create([
            'ONRO' => $req->get('onro'),
            'NIMI' => $req->get('nimi'),
            'PAAAINE' => $req->get('paaaine'),
            'SALASANA' => password_hash($req->get('salasana'), PASSWORD_DEFAULT)
        ]);

        $student = Student::find($studentId);

        User::create([
            'ID_KAYTTAJA' => $student->ID_KAYTTAJA,
            'ROOLI' => 'opiskelija'
        ]);

        header('Location: /');
    }

    /*
     *|-----------------------------------
     *| Opettaja
     *|-----------------------------------
     *| Nämä funktiot ovat opettajien
     *| rekisteröintiinn tarkoitettuja
     *| funktioita.
     *|
     */
    public function create2()
    {
        return view('teacher-registration');
    }

    public function save2()
    {
        $req = App::get('request');

        $errors = (new Validator([
            'onro' => 'required',
            'nimi' => 'required',
            'salasana' => 'required',
        ]))->validate();

        if (count($errors) > 0) {
            return view('teacher-registration', compact('errors'));
        }

        $teacherId = Teacher::create([
            'ONRO' => $req->get('onro'),
            'NIMI' => $req->get('nimi'),
            'SALASANA' => password_hash($req->get('salasana'), PASSWORD_DEFAULT)
        ]);

        $teacher = Teacher::find($teacherId);

        User::create([
            'ID_KAYTTAJA' => $teacher->ID_KAYTTAJA,
            'ROOLI' => 'opettaja'
        ]);

        header('Location: /');
    }

}