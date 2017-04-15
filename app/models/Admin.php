<?php
/**
 * Created by PhpStorm.
 * User: ritol
 * Date: 11.4.2017
 * Time: 23.42
 */

namespace App\App\Models;

use App\Core\Database\Model;

class Admin extends Model
{
    protected static $tableName = 'YLLAPITAJA';
    protected static $primaryKey = 'ID_KAYTTAJA';

    public $ID_KAYTTAJA;
    public $NIMI;
    public $SALASANA;
}