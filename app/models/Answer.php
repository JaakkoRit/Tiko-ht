<?php

namespace App\App\Models;


use App\Core\Database\Model;

class Answer extends Model
{
    protected static $tableName = 'ESIMVASTAUS';
    protected static $primaryKey = 'ID_TEHTAVA, VASTAUS';

    public $ID_TEHTAVA;
    public $VASTAUS;
}