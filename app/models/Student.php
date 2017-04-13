<?php
/**
 * Created by PhpStorm.
 * User: ritol
 * Date: 11.4.2017
 * Time: 1.24
 */

namespace App\App\Models;

use App\Core\Database\Model;

class Student extends Model
{
    protected static $tableName = 'OPISKELIJA';
    protected static $primaryKey = 'ID_KAYTTAJA';

    public $ID_KAYTTAJA;
    public $ONRO;
    public $NIMI;
    public $PAAAINE;
    public $SALASANA;
}