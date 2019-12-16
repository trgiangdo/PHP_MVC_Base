<?php

namespace App\Controllers;

use \Core\Frontend\View;
use \Core\App\Controller;
use \App\Models\User;

/**
 * Home controller
 *
 * PHP version 7.0
 */
class Home extends Controller
{


    /**
     * Show the index page
     *
     * @return void
     */
    public function index()
    {
        View::render(
        	'Home/index',
        	[
        		'title' => 'Home Page',
                'user' => User::getAdmin(),
                'allUser' => User::getAll()
        	]
        );
    }
}
