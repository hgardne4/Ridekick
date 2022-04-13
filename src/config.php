<?php
/*
Project Ridekick: Henry Gardner, Gabby Novack
CSC261 Final Project Milestone 3
Prof. Zhupa
*/

session_start();
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

	// function to attempt to login a user, checks credentials, note no passwords are stored, only hashed versions
	public function verify_user_credentials($username="", $password="") {
		// store the hashed version of the password
		$hashed_password = md5($password);
		// execute the query to gather user information on the given input
		$sql = $this->db->query("SELECT id, username, type FROM users WHERE username = '$username' AND password = '$hashed_password'");

		// now make sure the query gathered only one user:
		if($sql->num_rows == 1){
			// if there was one row, then output sucessful query
			echo "SUCESSFUL LOGIN @ " . date('m/d/Y h:i:s a', time()) . "\nResults:\n";
			// gather resulting data 
			$user = $sql->fetch_assoc();
			echo "ID: " . $user["id"]. ", USERNAME: " . $user["username"]. ", ACCOUNT_TYPE: " . $user["type"]. "\n";
			session_regenerate_id();
			$_SESSION['loggedin'] = TRUE;
			$_SESSION['name'] = $username;
			$_SESSION['id'] = $user['id'];
			echo "Welcome " . $username . "\n";

			// make sure it was successful and then return the data from the user "=>" is used like a dictionary in an array, give A value B in A => B
			return array('status' => 'success', 'id' => $user['id'], 'username' => $user['username'], 'type' => $user['type']);
		}
		// o/w unsuccessful, return the error array and output failed login attempt
		else {
			echo "Failed login, email or password invalid...\n";
			return array('status' => 'error', 'message' => "Failed login, email or password invalid...");
		}
	}
}

// TESTING THE CONNECTION
$instance = new DB;
$instance->__construct();

// now check when the user enters data into the login form page, exit if they attempt to login with not all needed info
if(!isset($_POST['username'], $_POST['password'])) {
	die("Error, please enter both a username and password...\n");
}
// o/w attempt to verify their credentials:
else {
	$instance->verify_user_credentials($_POST['username'], $_POST['password']);
}
?>