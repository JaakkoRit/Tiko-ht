<?php

namespace App\App\Models;


class Gate
{
    public static function hasRole($role){
        if($_SESSION['rooli'] == $role) {
            return true;
        }
        return false;
    }
}