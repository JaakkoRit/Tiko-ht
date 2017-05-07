<?php

namespace App\App\Controllers;

use App\App\Models\User;
use App\Core\App;
use App\App\Models\Admin;
use App\App\Models\Gate;

class AdminController
{
    public function __construct(){
        if(Gate::hasRole('opiskelija'))
            header('Location:/student-home');
        else if(Gate::hasRole('opettaja') )
            header('Location:/teacher-home');
    }
    public function index()
    {
        return view('admin-home', compact('sessions'));
    }
    public function create()
    {
        return view('login');
    }

    public function save()
    {
        $req = App::get('request');
        $admin = Admin::findWhere('NIMI', $req->get('nimi'));

        if ($admin && password_verify($req->get('salasana'), $admin->SALASANA)) {
            $user = User::find($admin->ID_KAYTTAJA);
            $_SESSION['id_kayttaja'] = $admin->ID_KAYTTAJA;
            $_SESSION['nimi'] = $admin->NIMI;
            $_SESSION['rooli'] = $user->ROOLI;

            header('Location: /admin-home');
            die();
        }

        header('Location: /');
    }
}