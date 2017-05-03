<?php

namespace App\App\Controllers;


use App\App\Models\Answer;
use App\Core\App;
use App\Core\Validator;

class AnswerController
{
    public function create()
    {
        $req = App::get('request');

        $id = $req->get('id');

        if ($id == null) {
            header('Location: /');
        }

        $errors = getErrors();

        return view('create-answer', compact('id', 'errors'));
    }

    public function save()
    {
        $req = App::get('request');

        $errors = (new Validator([
            'vastaus' => 'required'
        ]))->validate();

        if (count($errors) > 0) {
            $_SESSION['errors'] = $errors;
            $previousPage = $req->headers->get('referer');
            header("Location: $previousPage");
        }

        $id = $req->get('id');

        Answer::create([
            'ID_TEHTAVA' => $id,
            'VASTAUS' => $req->get('vastaus')
        ]);

        $editPage = "/tasks/edit?id=$id";

        $_SESSION['message'] = 'Vastaus lisätty!';

        header("Location: $editPage");
    }

    public function delete()
    {
        $req = App::get('request');

        $answers = Answer::findAllWhere('ID_TEHTAVA', $req->get('id'));

        Answer::deleteAnswer(
            $req->get('id'),
            $answers[$req->get('index')]->VASTAUS
        );

        $previousPage = $req->headers->get('referer');

        $_SESSION['message'] = 'Vastaus poistettu!';

        header("Location: $previousPage");
    }
}