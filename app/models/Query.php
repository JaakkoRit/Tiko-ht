<?php

namespace App\App\Models;

use App\Core\Database\Model;
use App\Core\App;

class Query extends Model
{
    public static function rawQuery($query){
        $db = App::get('database');
        $result = $db->query($query)->getAll(get_called_class());
        return $result;
    }
}