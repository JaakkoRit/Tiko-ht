<?php

namespace App\App\Controllers;
use App\App\Models\User;
use App\Core\App;
use App\Core\Validator;

class UsersController
{
    public function create()
    {
        return view('register');
    }

    public function save()
    {
        $req = App::get('request');

        $errors = (new Validator([
            'name' => 'required',
            'email' => 'required',
            'password' => 'required'
        ]))->validate();

        if (count($errors) > 0) {
            return view('register', compact('errors'));
        }

        User::create([
            'name' => $req->get('name'),
            'email' => $req->get('email'),
            'password' => password_hash($req->get('password'), PASSWORD_DEFAULT)
        ]);

        return view('register', ['message' => 'Account created!']);
    }
}