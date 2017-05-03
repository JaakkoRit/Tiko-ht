<?php

namespace App\App\Controllers;


use App\App\Models\Session;
use App\App\Models\Student;
use App\Core\App;

class StudentManagementController
{
    public function index()
    {
        $students = Student::all();
        $sessionStudents = Student::findStudentsWhoHaveDoneUsersSession(auth()->ID_KAYTTAJA);

        return view('students-management', compact('students', 'sessionStudents'));
    }

    public function show()
    {
        $req = App::get('request');

        $id = $req->get('id');
        $student = Student::find($id);

        $sessions = Session::findAllCompletedSessions('ID_KAYTTAJA', $student->ID_KAYTTAJA);

        return view('students-show', compact('student', 'sessions'));
    }
}