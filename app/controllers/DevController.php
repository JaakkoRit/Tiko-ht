<?php

namespace App\App\Controllers;


use App\App\Models\Student;
use App\App\Models\Teacher;
use App\App\Models\User;
use App\Core\App;
use App\Core\Validator;

class DevController
{

    /*
     *|-----------------------------------
     *| Opiskelija
     *|-----------------------------------
     *| Nämä funktiot ovat opiskelijoiden
     *| rekisteröintiinn tarkoitettuja
     *| funktioita.
     *|
     */
    public function create()
    {
        return view('student-registration');
    }

    public function save()
    {
        $req = App::get('request');

        // Varmistetaan, ettei käyttäjän syöttämät kentät ole tyhjiä.
        // Jos jokin kenttä on tyhjä, palautetaan tästä virheilmoitus taulukkoon.
        $errors = (new Validator([
            'onro' => 'required',
            'nimi' => 'required',
            'paaaine' => 'required',
            'salasana' => 'required'
        ]))->validate();

        // Jos on yhtään virheilmoitusta taulukossa, näytetään virheilmoitukset käyttäjälle.
        if (count($errors) > 0) {
            return view('student-registration', compact('errors'));
        }

        // Jos virheilmoituksia ei ollut, jatketaan matkaa.
        // Luodaan uusi käyttäjä, ja asetetaan sen rooliksi 'opiskelija.'
        // Uuden käyttäjän 'ID_KAYTTAJA'-sarake kasvattaa itseään automaattisesti,
        // joten sitä ei tarvitse erikseen määritellä.
        // Create-funktio palauttaa uuden käyttäjän id:n.
        $userId = User::create([
            'ROOLI' => 'opiskelija'
        ]);

        // Etsitään käyttäjä uuden käyttäjän id:n perusteella KAYTTAJA taulusta.
        // Find-funktio palauttaa tämän käyttäjän oliona.
        $user = User::find($userId);

        // Luomme uuden opiskelijan syötettyjen tietojen perusteella.
        // Annamme opiskelijalle id:n 'ID_KAYTTAJA'-sarakkeeseen juuri luodun käyttäjän id:stä.
        // Salasana kryptataan.
        Student::create([
            'ID_KAYTTAJA' => $user->ID_KAYTTAJA,
            'ONRO' => $req->get('onro'),
            'NIMI' => $req->get('nimi'),
            'PAAAINE' => $req->get('paaaine'),
            'SALASANA' => password_hash($req->get('salasana'), PASSWORD_DEFAULT)
        ]);

        // Uudelleenohjataan etusivulle.
        header('Location: /');
    }

    /*
     *|-----------------------------------
     *| Opettaja
     *|-----------------------------------
     *| Nämä funktiot ovat opettajien
     *| rekisteröintiin tarkoitettuja
     *| funktioita.
     *|
     */
    public function create2()
    {
        return view('teacher-registration');
    }

    public function save2()
    {
        $req = App::get('request');

        $errors = (new Validator([
            'onro' => 'required',
            'nimi' => 'required',
            'salasana' => 'required',
        ]))->validate();

        if (count($errors) > 0) {
            return view('teacher-registration', compact('errors'));
        }

        $userId = User::create([
            'ROOLI' => 'opettaja'
        ]);

        $user = User::find($userId);

        Teacher::create([
            'ID_KAYTTAJA' => $user->ID_KAYTTAJA,
            'ONRO' => $req->get('onro'),
            'NIMI' => $req->get('nimi'),
            'SALASANA' => password_hash($req->get('salasana'), PASSWORD_DEFAULT)
        ]);

        header('Location: /');
    }

}