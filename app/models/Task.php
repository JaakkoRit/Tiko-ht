<?php

namespace App\App\Models;


use App\Core\Database\Model;

class Task extends Model
{
    protected static $tableName = 'TEHTAVA';
    protected static $primaryKey = 'ID_TEHTAVA';

    public $ID_TEHTAVA;
    public $ID_KAYTTAJA;
    public $LUOMPVM;
    public $KYSELYTYYPPI;
    public $KUVAUS;
}