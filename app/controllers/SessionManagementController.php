<?php

namespace App\App\Controllers;

use App\App\Models\Gate;
use App\App\Models\Session;
use App\App\Models\Student;
use App\App\Models\TaskList;
use App\Core\App;
use App\Core\Validator;

class SessionManagementController
{
    public function __construct()
    {
        if (! auth() || Gate::hasRole('opiskelija')) {
            header('Location: /');
        }
    }

    public function index()
    {
        $sessions = Session::all();

        return view('sessions-management', compact('sessions'));
    }

    public function create()
    {
        $students = Student::all();
        $taskLists = TaskList::all();

        $errors = getErrors();

        return view('sessions-management-create', compact('students', 'taskLists', 'errors'));
    }

    public function save()
    {
        $req = App::get('request');

        $errors = (new Validator([
            'kayttajat' => 'required',
            'tehtavalista' => 'required'
        ]))->validate();

        if (count($errors) > 0) {
            $_SESSION['errors'] = $errors;
            header('Location: /sessions-management/create');
        }

        $userIds = getIds($req->get('kayttajat'));

        foreach ($userIds as $userId) {
            Session::create([
                'ID_KAYTTAJA' => $userId,
                'ID_TLISTA' => $req->get('tehtavalista')
            ]);
        }

        header('Location: /sessions-management');
    }
}