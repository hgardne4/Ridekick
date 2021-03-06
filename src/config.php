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
				//echo "Successfully connected to MySQL with USER: " . $this->username . ", HOST: " . $this->host . "!\n\n";
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
		$hashed_password = md5($password, true);
		// execute the query to gather user information on the given input
		$sql = $this->db->query("SELECT * FROM passenger WHERE name = '$username' AND passHash = '$hashed_password'");

		// now make sure the query gathered only one user:
		if($sql->num_rows == 1){
			// if there was one row, then output sucessful query
			//echo "SUCESSFUL LOGIN @ " . date('m/d/Y h:i:s a', time()) . "\nResults:\n";
			// gather resulting data 
			$user = $sql->fetch_assoc();
			//echo "ID: " . $user["pid"]. ", USERNAME: " . $user["name"]. ", NUMBER_OF_APPOINTMENTS: " . $user["nApp"]. "\n";
			session_regenerate_id();
			$_SESSION['loggedin'] = TRUE;
			$_SESSION['name'] = str_replace(["'", '"'], "", $username);
			$_SESSION['id'] = $user['pid'];
			$_SESSION['loginattempt'] = "success";
			$_SESSION['passwordsNotMatching'] = FALSE;
			$_SESSION['invalidappointment'] = FALSE;
			echo "Welcome " . $username . "\n";
			header('Location: profile.php');
			exit;

			// make sure it was successful and then return the data from the user "=>" is used like a dictionary in an array, give A value B in A => B
			//return array('status' => 'success', 'id' => $user['pid'], 'username' => $user['name'], 'nApp' => $user['nApp']);
		}
		// o/w unsuccessful, return the error array and output failed login attempt
		else {
			$_SESSION['loginattempt'] = "failed";
			// redirect to the login page as it failed
			header('Location: login.php');
			exit;
			//echo "Failed login, email or password invalid...\n";
			//return array('status' => 'error', 'message' => "Failed login, email or password invalid...");
		}
	}

	// function to add an account to the user table 
	public function add_user($name="", $password="", $password2="") {
		/*
		- first make sure the two passwords are equal, if so then we can insert into the database
		- make sure the password has the following:
			- a special character
			- is at least 8 characters long
			- consists of both upperase and lowercase letters
			- contains a number
		*/ 
		if($password == $password2 && preg_match('/[\'^??$%&*()}{@#~?><>,|=_+??-]/', $password) && !ctype_digit($password) && !ctype_lower($password) && !ctype_upper($password) && strlen($password) > 7) {
			$_SESSION['passwordsNotMatching'] = FALSE;
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
			header("Location: login.php");
			exit;
		}
		else {
			$_SESSION['passwordsNotMatching'] = TRUE;
			header("Location: signup.php");
			exit;
		}
	}

	// function to add appointment to the the appointment table
	public function add_appointment($service="", $date="", $deptime="") {
		$_SESSION['invalidappointment'] = FALSE;
		$sql = $this->db->query("SELECT * FROM service WHERE sid = '$service' AND date = '$date' AND deptime = '$deptime' AND nseats > 0");
		if (mysqli_num_rows($sql) > 0) {

			// if there exists a row with this data update the appointment and service table!
			$sql2 = $this->db->query("UPDATE service SET nseats = nseats - 1 WHERE sid = '$service' AND date = '$date' AND deptime = '$deptime' AND nseats > 0");
			$pid = $_SESSION['id'];
			$sql3 = $this->db->query("INSERT INTO appointment (date, time, aid, isfor_sid, schedules_pid) SELECT '$date', '$deptime', MAX(aid) + 1, $service, '$pid' FROM appointment");
	
			$_SESSION['validappointment'] = TRUE;
			header("Location: appointment.php");
			exit;
			
			
		} 
		// o/w don't add to the table as we cannot add appointment
		else {
			$_SESSION['invalidappointment'] = TRUE;
			header("Location: appointment.php");
			exit;
		}	
	}
}

// TESTING THE CONNECTION
$instance = new DB;
$instance->__construct();

$_SESSION['loginattempt'] = "undefined";
$_SESSION['passwordsNotMatching'] = FALSE;
$_SESSION['invalidappointment'] = FALSE;
$_SESSION['validappointment'] = FALSE;

// LOGIN
// now check when the user enters data into the login form page, exit if they attempt to login with not all needed info
if($_POST['came_from'] == "login"){
	if(!isset($_POST['username'], $_POST['password'])) {
		die("Error, please enter both a username and password...\n");
	}
	// o/w attempt to verify their credentials:
	else {
		$instance->verify_user_credentials($_POST['username'], $_POST['password']);
	}
}

// SIGNUP
// now check when the user enters data into the signup form page, exit if they attempt to login with not all needed info
if($_POST['came_from'] == "signup"){
	if(!isset($_POST['username'], $_POST['password'], $_POST['password2'])) {
		$_SESSION['passwordsNotMatching'] = TRUE;
		header("Location: signup.php");
		exit;	
	}
	// o/w attempt to verify their credentials:
	else {
		$instance->add_user($_POST['username'], $_POST['password'], $_POST['password2']);
	}
}

// APPOINTMENT
// now check when the user enters data into the appointment form page, exit if they attempt to login with not all needed info
if($_POST['came_from'] == "appointment"){
	if(!isset($_POST['service'], $_POST['date'], $_POST['deptime'])) {
		$_SESSION['invalidappointment'] = TRUE;
		header("Location: appointment.php");
		exit;	
	}
	// o/w attempt to verify their credentials:
	else {
		$instance->add_appointment($_POST['service'], $_POST['date'], $_POST['deptime']);
	}
}
?>