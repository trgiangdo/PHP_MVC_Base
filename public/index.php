<?php

use Core\Route\Router;
use Core\Route\Request;

/**
 * Front controller
 *
 * PHP version 7.0
 */


/**
 * Autoload all class
 */
require "../Core/Autoloader.php";
spl_autoload_register('Autoloader::load');


/**
 * Start session
 */
session_start();


/**
 * Error and Exception handling
 */
error_reporting(E_ALL);
set_error_handler('Core\App\Error::errorHandler');
set_exception_handler('Core\App\Error::exceptionHandler');


/**
 * Routing
 */
Router::load('../routes.php')
      			 ->direct(Request::uri(), Request::method());