<?php

namespace App\App\Models;


use App\Core\Database\Model;

class TaskInTaskList extends Model
{
    protected static $tableName = 'TEHTAVALISTANTEHTAVA';
    protected static $primaryKey = 'ID_TLISTA, ID_TEHTAVA';

    public $ID_TLISTA;
    public $ID_TEHTAVA;
}