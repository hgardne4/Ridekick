<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Login</title>
		<link rel="stylesheet" href="styles.css">
		<link rel="preconnect" href="https://fonts.googleapis.com">
	    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@800&display=swap" rel="stylesheet"> 
	    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
		</div>
			<div class="nav-links" id="navLinks">
                <ul>
                    <li><a href="index.php">HOME</a></li>
                    <li><a href="schedule.php">SCHEDULE</a></li>
			</div>
		</nav>
	</head>
	<body>
		<div class="login">
			<h1>Create an Account</h1>
			<form action="config.php" method="post">
				<label for="name">
					<i class="fas fa-user"></i>
				</label>
				<input type="text" name="username" placeholder="Enter Name" id="username" required>
				<label for="password">
					<i class="fas fa-lock"></i>
				</label>
				<input type="password" name="password" placeholder="Enter a Password" id="password" required>
				<label for="password2">
					<i class="fas fa-lock"></i>
				</label>
				<input type="password" name="password2" placeholder="Re-enter Password" id="password2" required>
				<input type="submit" value="Create Account">
				<input type="hidden" name="came_from" value="signup">

			</form>

			<?php
				session_start();
				if($_SESSION['passwordsNotMatching'] == TRUE){
					echo "<p style=\"color:red;\">Passwords do not match or an error occured when creating account.</p>";
				}
			?>
		</div>
	</body>
</html>