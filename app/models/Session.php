<?php

namespace App\App\Models;

use App\Core\Database\Model;

class Session extends Model
{
    protected static $tableName = 'SESSIO';
    protected static $primaryKey = 'ID_SESSIO';

    public $ID_SESSIO;
    public $ID_KAYTTAJA;
    public $ID_TLISTA;
    public $ALKAIKA;
    public $LOPAIKA;
}