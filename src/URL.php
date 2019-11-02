<?php

namespace App;

use Exception;

class URL
{
    public static function getInt($name, $default = null)
    {
        if (!isset($_GET[$name])) return $default;
        if ($_GET[$name] === '0') return 0;

        if (!filter_var($_GET[$name], FILTER_VALIDATE_INT))
        {
            throw new Exception("Le paramètre '$name' dans l'url n'est pas un entier");
        }
        return $_GET[$name];
    }

    public static function getPositiveInt($name, $default = null)
    {
        $param = self::getInt($name, $default);
        if ($param !==null && $param <=0){
            throw new Exception("Le paramètre '$name' dans l'url n'est pas un entier positif");
        }
        return $param;
    }
}