<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>Ridekick</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@800&display=swap" rel="stylesheet"> 
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="styles.css">

  <section class="header">
    	<div class="text-box">
    			<h1>Ridekick Transportation Service</h1>
    			<p>Explore the University of Rochester's campus and the greater Rochester area all through this one convenient site!  
    			</p>
    			<a href="login.php" class="page-btn">Login to get started!</a>
    	</div>
			<div class="nav-links" id="navLinks">
          <ul>
              <li><a href="index.php">HOME</a></li>
              <li><a href="schedule.php">SCHEDULE</a></li>
              <?php
              session_start();
              if($_SESSION['loggedin'] == TRUE){
                echo "<li><a href=\"profile.php\">PROFILE</a></li>";
                echo "<li><a href=\"logout.php\">LOGOUT</a></li>";
              }
              else {
                echo "<li><a href=\"login.php\">LOGIN/SIGNUP</a></li>";
              }
              ?>
          </ul>
			</div>
		</nav>
	</section>
</head>
<body>
<br><br>
  <h2 style = "text-align:center">Current Transportation Delays</h2>
  <br>
  <?php
  session_start();

  // use this for login display not showing failed attempt
  $_SESSION['loginattempt'] = "undefined";
  $_SESSION['passwordsNotMatching'] = FALSE;
  $_SESSION['invalidappointment'] = FALSE;
  $_SESSION['validappointment'] = FALSE;

  // connect to database
  $conn = \mysqli_connect("localhost", "root", "Test#123", "ridekick");
  if ($conn -> connect_error) {
	  die("Connection failed:". $conn -> connect_error);
  }
  $sql = "SELECT TIME_FORMAT(reporttime, '%h:%i %p') as time, length, experience_sid
          FROM delay";
  $result = $conn -> query($sql);
  if ($result -> num_rows>0) {
    echo "<ul>";
    while($row = $result -> fetch_assoc()) {
      $sid = intval($row["experience_sid"]);
      $qry = $conn -> query("SELECT startl,endl,
                            TIME_FORMAT(deptime, '%h:%i %p') as time
                            FROM service WHERE sid=".$sid);
      $locs = $qry -> fetch_assoc();
      echo "<li>".$locs["time"]." bus from ".$locs["startl"]." to ".$locs["endl"]." was reported delayed ".$row["length"]." minutes at ".$row["time"]."</li>";
    }
  echo "</ul><br><br>";
  } else { // no delays
    echo "Nothing to report!";
  }
  $conn -> close();
  ?>
</body>  
<section class="footer">
    <h4>About Us</h4>
    <p>Our website contains all the information needed to travel across the University of Rochester's campus and in the greater Rochester area. The goal is to make transportation easy for students, faculty, and staff. </p>
</section>
</html>