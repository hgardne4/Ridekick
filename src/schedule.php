<!-- 
Project Ridekick: Henry Gardner, Gabby Novack
CSC261 Final Project Milestone 3
Prof. Zhupa
-->

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
	<style>
		table {
			width: 100%;
			text-align: center;
		}

		th {
			border-bottom: 1px solid black;
		}
	</style>
    <section class="header">
    <div class="text-box">
            <h1>Schedule</h1>
        </div>
            <div class="nav-links" id="navLinks">
                <ul>
                    <li><a href="index.html">HOME</a></li>
                    <li><a href="schedule.html">SCHEDULE</a></li>
                </ul>
            </div>
        </nav>
    </section>
</head>
<body>
	<table>
		<tr>
			<th>Date</th>
			<th>Departure Time</th>
			<th>Start Location</th>
			<th>End Location</th>
			<th>Remaining Seats</th>
		</tr>
		<?php
// connect to database
$conn = mysqli_connect("localhost", "root", "root", "ridekick");
if ($conn -> connect_error) {
	die("Connection failed:". $conn -> connect_error);
}
// get the cols we need
$sql = "SELECT DATE_FORMAT(date, '%m/%d/%y') as date, TIME_FORMAT(deptime, '%h:%i %p') as deptime, startl, endl, nseats - napp as remseats from service";
$result = $conn -> query($sql);
// make sure has at least one row
if ($result -> num_rows > 0) {
	while($row = $result -> fetch_assoc()) {
		echo "<tr><td>".$row["date"]."</td><td>".$row["deptime"]."</td><td>".$row["startl"]."</td><td>".$row["endl"]."</td><td>".$row["remseats"]."</td></tr>";
	}
	echo "</table>";
	} else {
		echo "No services currently scheduled.";
	}
	$conn -> close();
?>
</table>		
</body>  
<section class="footer">
    <h4>About Us</h4>
    <p>Our website contains all the information needed to travel across the University of Rochester's campus and in the greater Rochester area. The goal is to make transportation easy for students, faculty, and staff. </p>
</section>
</html>	