<?php

namespace App\App\Models;


use App\Core\Database\Model;

class TaskList extends Model
{
    protected static $tableName = 'TEHTAVALISTA';
    protected static $primaryKey = 'ID_TLISTA';

    public $ID_TLISTA;
    public $ID_KAYTTAJA;
    public $KUVAUS;
    public $LUOMPVM;
}