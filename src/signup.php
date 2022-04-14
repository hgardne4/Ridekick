<?php
/*
Project Ridekick: Henry Gardner, Gabby Novack
CSC261 Final Project Milestone 3
Prof. Zhupa
*/

session_start();

class DB {
	private $host = "localhost";
	private $username = "root";
	private $password = "root";
	private $db_name = "ridekick";

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
				// echo "Successfully connected to MySQL with USER: " . $this->username . ", HOST: " . $this->host . "!\n\n";
			}
		}
	}

	// function to terminate/close the instance
	public function terminate() {
		$this->db->close();
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

	// function to add an account to the user table 
	public function add_user($name="", $password="", $password2="") {
		// first make sure the two passwords are equal, if so then we can insert into the database
		if($password == $password2) {
			$sql = $this -> db -> query("SELECT MAX(pid) FROM passenger");
			if (!$sql) {
			  echo "can't find index";
			} else if ($sql->num_rows == 0) {
			  $id = 1;
			} else {
			  $maxid = $sql->fetch_assoc();
				$id = intval(array_shift($maxid)) + 1;
			}
			// never store the password itself, only store hashed version
			$hashed_password = md5($password, true);
			$sql = $this->db->query("INSERT INTO passenger (pid, name, passHash) VALUES ('$id', '$name','$hashed_password')");
			// make sure the query was successful
			if($sql == TRUE){
				echo "Account successfully created, ".'<a href="login.html">click here to return to login page.</a>';
			}
		}
		else {
			die("Passwords did not match. ".'<a href="signup.html">Click here to try again.</a>');
		}
	}
}

$instance = new DB;
$instance->__construct();

if($_POST['came_from'] == "signup"){
	if(!isset($_POST['name'], $_POST['password'], $_POST['password2'])) {
		die("Error, please enter both a username and password...\n");
	}
	// o/w attempt to verify their credentials:
	else {
		$instance->add_user($_POST['name'], $_POST['password'], $_POST['password2']);
	}
}

?>