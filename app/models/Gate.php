<?php

namespace App\App\Models;


class Gate
{
    public static function hasRole($role){
        return $_SESSION['rooli'] == $role;
    }
}