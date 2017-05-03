<?php

namespace App\App\Models;


class Gate
{
    public static function hasRole($role){
        if(isset($_SESSION['rooli']))
            return $_SESSION['rooli'] == $role;
        return false;
    }
}