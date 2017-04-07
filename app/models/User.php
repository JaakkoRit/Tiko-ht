<?php
/**
 * Created by PhpStorm.
 * User: Jaakko
 * Date: 6.4.2017
 * Time: 20.27
 */

namespace App\App\Models;

use App\Core\Database\Model;
use App\Core\App;

class User extends Model
{
    public $name;
    public $email;
    public $password;
}