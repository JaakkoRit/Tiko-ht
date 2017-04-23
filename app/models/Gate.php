<?php

namespace App\App\Models;


class Gate
{
    public static function hasRole($role){
        if($_SESSION['opettaja'] == $role){
            return true;
        }
        else if($_SESSION['opiskelija'] == $role){
            return true;
        }
        else if($_SESSION['admin'] == $role){
            return true;
        }
        return false;
    }
}