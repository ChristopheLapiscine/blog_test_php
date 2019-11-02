<?php

namespace App;

use \PDO;

class Connection
{
    public static function getPDO() {
        return new PDO('mysql:host=127.0.0.1;port=8889;dbname=blog_learn', 'root', 'root', [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);
    }
}