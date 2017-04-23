<?php

namespace App\App\Models;


use App\Core\Database\Model;

class Attempt extends Model
{
    protected static $tableName = 'YRITYS';
    protected static $primaryKey = 'ID_TEHTAVA, ID_SESSIO';

    public $ID_TEHTAVA;
    public $ID_SESSIO;
    public $YRITYSKERTA;
    public $VASTAUS;
    public $ALKAIKA;
    public $LOPAIKA;
    public $OLIKOOIKEIN;
}