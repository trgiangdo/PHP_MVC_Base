<?php

namespace App\Models;

use Core\Database\QueryBuilder;

/**
 * Example user model
 *
 * PHP version 7.0
 */
class User
{
    /**
     * Get all the users as an associative array
     *
     * @return array
     */
    public static function getAll()
    {
        $stmt = QueryBuilder::table('users')
                            ->select('username')
                            ->get();
        return $stmt;
    }

    public static function getAdmin()
    {
        $stmt = QueryBuilder::table('users')->where('username', 'admin')->get();
        return $stmt;
    }
}