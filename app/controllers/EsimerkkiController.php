<?php

namespace App\App\Controllers;

use App\Core\App;

class EsimerkkiController
{
    public function miukumauku()
    {
        view('esimerkki');
    }

    public function save()
    {
        $req = App::get('request');

        $esimerkki1 = $req->get('esimerkki');
        $esimerkki2 = $req->get('esimerkki2');

        Taulu::create([
            'esimerkki1' => $esimerkki1,
            'esimerkki2' => $esimerkki2
        ]);
    }
}