<?php

namespace App;

/**
 * Application configuration
 *
 * PHP version 7.0
 */
class Config
{
    /**
     * App name
     * @var string
     */
    const APP_NAME = 'Base MVC App';

    /**
     * Database host
     * @var string
     */
    const DB_HOST = 'mysql:host=127.0.0.1';

    /**
     * Database user
     * @var string
     */
    const DB_USER = 'root';

     /**
     * Database name
     * @var string
     */
    const DB_NAME = 'test';

    /**
     * Database password
     * @var string
     */
    const DB_PASSWORD = '';

    /**
     * Show error or not
     * @var string
     */
    const SHOW_ERRORS = True;

    /**
     * Specify PDO modes
     * @var boolean
     */
    const DB_OPTION = [
        \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION
    ];
}
