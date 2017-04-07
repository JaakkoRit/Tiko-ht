<?php
/**
 * Created by PhpStorm.
 * User: Jaakko
 * Date: 6.4.2017
 * Time: 21.21
 */

namespace App\App\Controllers;


use App\App\Models\User;
use App\Core\App;

class SessionController
{
    public function create()
    {
        return view('login');
    }

    public function save()
    {
        $req = App::get('request');
        $user = User::findWhere('email', $req->get('email'));

        if ($user && password_verify($req->get('password'), $user->password)) {
            $_SESSION['name'] = $user->name;
            $_SESSION['email'] = $user->email;

            header('Location: /index.php/tasks');
        }

        return view('login', ['message' => 'The email or password was invalid.']);
    }

    public function destroy()
    {
        session_unset();
        session_destroy();

        header('Location: /index.php/');
    }
}