<?php

namespace App\App\Models;


use App\Core\Database\Model;

class TaskCompletion extends Model
{
    protected static $tableName = 'TEHTAVASUORITUS';
    protected static $primaryKey = 'ID_TEHTAVA, ID_SESSIO';

    public $ID_TEHTAVA;
    public $ID_SESSIO;
    public $ALKAIKA;
    public $LOPAIKA;
}