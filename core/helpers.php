<?php

function dd($data)
{
    echo '<pre>';
    var_dump($data);
    echo '</pre>';
    die();
}

function view($template, $data = [])
{
    extract($data);

    return require __DIR__ . "/../app/resources/views/{$template}.view.php";
}

function auth()
{
    if (isset($_SESSION['id_kayttaja'])) {
        return \App\App\Models\User::find($_SESSION['id_kayttaja']);
    }

    return false;
}