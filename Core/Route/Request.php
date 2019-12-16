<?php

namespace Core\Route;

/**
 * Error and exception handler
 *
 * PHP version 7.0
 */

class Request
{
    public static function uri()
    {
        // Co ten mien ao
        // $uri = trim(
        //     parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH),
        //     '/'
        // );

        // Khong co ten mien ao
        $uri = trim(
            str_replace('base-mcv-php/public/', '/', 
                        parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)),
            '/'
        );

        return $uri;
    }

    public static function method()
    {
        return $_SERVER['REQUEST_METHOD'];
    }
}