<?php

class Autoloader
{
	public static function load($class)
	{
		$root = __DIR__ . '\\..\\'; 
	    $file = str_replace('\\', DIRECTORY_SEPARATOR, $class) . '.php';

	    $path = $root . $file;
	    if (file_exists($path)) {
	        require_once $path;
	    }
	}
}