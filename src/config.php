<?php
/*
Project Ridekick: Henry Gardner, Gabby Novack
CSC261 Final Project Milestone 3
Prof. Zhupa
*/

// use an object oriented approach 
class DB {
	private $host = "localhost";
	private $username = "root";
	private $password = "Test#123";
	private $db_name = "users";

	/* 
	function to try and connect to a database:
	note that -> is an object operator and the phrase "this ->" is accessing the current object's private data
	*/
	public function __construct() {
		if(!isset($this->db)){
			$link = new \mysqli($this->host, $this->username, $this->password, $this->db_name);
			// if the connection errored, exit and output via die() command
			if($link->connect_error){
				die("Error, cannot connect to to MySQL:" . $link->connect_error);
			}
			// o/w connection is secure, make the current database instance the linked connection and output success "." is string concatenation
			else {
				$this->db = $link;
				echo "Successfully connected to MySQL with USER: " . $this->username . ", HOST: " . $this->host . "!\n\n";
			}
		}
	}

	// NEEDS WORK
	// function to attempt to login a user, checks credentials, note no passwords are stored, only hashed versions
	public function verify_user_credentials($username="", $password="") {
		// execute the query to gather user information on the given input
		$sql = $this->db->query("SELECT * FROM users WHERE username = '$username' AND password = '".md5($password) ."'");

		// make sure the query gathered only one user:
		if($sql->num_rows == 1){
			// gather resulting data 
			$user = $sql->fetch_assoc();
			// make sure it was successful and then return the data from the user "=>" is used like a dictionary in an array, give A value B in A => B
			if ('1' == $user['status'])
				echo "Successful login!\n";
				return array('status' => 'success', 'id' => $user['id'], 'name' => $user['name'], 'type' => $user['type']);
		}
		// o/w unsuccessful, return the error array and output failed login attempt
		echo "Failed login, email or password invalid...\n";
		return array('status' => 'error', 'message' => "Failed login, email or password invalid...");
	}
}

$test = new DB;
$test->__construct();
$test->verify_user_credentials($username="hgardne4", $password=md5("Test#123"));
?>