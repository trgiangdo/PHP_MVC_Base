<?php

namespace Core\Database;

use Core\Frontend\View;
use App\Config;

class Connection
{
    public static function create()
    {
        try {
            return new \PDO(
                Config::DB_HOST.';dbname='.Config::DB_NAME,
                Config::DB_USER,
                Config::DB_PASSWORD,
                Config::DB_OPTION
            );
        } catch (\PDOException $err) {
            View::render(
                'errorPage', 
                ['erroeMessage' => $err]
            );
        }
    }
}