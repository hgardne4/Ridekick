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
			<h1>Login</h1>
			<form action="config.php" method="post">
				<label for="username">
					<i class="fas fa-user"></i>
				</label>
				<input type="text" name="username" placeholder="Username" id="username" required>
				<label for="password">
					<i class="fas fa-lock"></i>
				</label>
				<input type="password" name="password" placeholder="Password" id="password" required>
				<input type="submit" value="Login">
				<input type="hidden" name="came_from" value="login">
			</form>
			<p>Don't have an account? <a href="signup.php">Create account</a> now!</p>
			<?php
				session_start();
				if($_SESSION['loginattempt'] == "failed"){
					echo "<p style=\"color:red;\">Invalid username and/or password.</p>";
				}
			?>
		</div>
	</body>
</html>