<?php
/**
 * Created by PhpStorm.
 * User: Aapo
 * Date: 15.4.2017
 * Time: 16.11
 */

namespace App\App\Controllers;

use App\App\Models\User;
use App\Core\App;
use App\App\Models\Admin;

class AdminController
{
    public function create()
    {
        return view('admin-login');
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

            header('Location: /');
        }

        return view('admin-login', ['message' => 'Nimi tai salasana väärin.']);
    }
}