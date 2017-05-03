<?php

namespace App\App\Controllers;

use App\App\Models\User;
use App\Core\App;
use App\App\Models\Admin;

class AdminController
{
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
        $user = User::find($admin->ID_KAYTTAJA);

        if ($admin && password_verify($req->get('salasana'), $admin->SALASANA)) {
            $_SESSION['id_kayttaja'] = $admin->ID_KAYTTAJA;
            $_SESSION['nimi'] = $admin->NIMI;
            $_SESSION['rooli'] = $user->ROOLI;

            header('Location: /admin-home');
        }

        return view('login', ['message' => 'Nimi tai salasana väärin.']);
    }
}