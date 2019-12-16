<?php

namespace Core\Auth;

class User extends Password
{

    private $_db;
    private $_table;

	function __construct($db, $table){
		parent::__construct();

		$this->_db = $db;
		$this->_table = $table;
	}

	public static function is_logged_in(){
		if(isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] == true){
			return true;
		}
	}

	private function get_user_hash($username){

		return $this->_db->table($this->_table)
						 ->select($username)
						 ->get();
	}


	public function login($username, $password){

		$user = $this->get_user_hash($username);

		if($this->password_verify($password, $user['password'])){

		    $_SESSION['loggedIn'] = true;
		    $_SESSION['memberID'] = $user['memberID'];
		    $_SESSION['username'] = $user['username'];
		    return true;
		}
	}


	public function logout(){
		session_destroy();
	}

}