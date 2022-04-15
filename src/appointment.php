<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Appointment</title>
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
      </div>
    </nav>
  </head>
  <body>
    <div class="login">
      <h1>Schedule Appointment</h1>
      <form action="config.php" method="post">
              
          <?php
          session_start();
          // connect to database
          $conn = \mysqli_connect("localhost", "root", "Test#123", "ridekick");
          if ($conn -> connect_error) {
            die("Connection failed:". $conn -> connect_error);
          }
          // SERVICE
          $sql = "SELECT * FROM service WHERE isactive = 1 AND nseats > 0";
          $result = $conn -> query($sql);
          echo "<select name=\"service\" id=\"service\" required>";
          if ($result -> num_rows>0) {
            while($row = $result -> fetch_assoc()){
              echo "<option value=".$row['sid'].">ID: ".$row['sid']." Start: ".$row['startL']." End: ".$row['endL']."</option>";
            }
          }
          echo "</select>";

          // DATE
          $sql = "SELECT date FROM service WHERE isactive = 1 AND nseats > 0";
          $result = $conn -> query($sql);
          echo "<select name=\"date\" id=\"date\" required>";
          if ($result -> num_rows>0) {
            while($row = $result -> fetch_assoc()){
              echo "<option value=".$row['date'].">".$row['date']."</option>";
            }
          }
          echo "</select>";

          //DEPARTURE TIME
          $sql = "SELECT deptime FROM service WHERE isactive = 1 AND nseats > 0";
          $result = $conn -> query($sql);
          echo "<select name=\"deptime\" id=\"deptime\" required>";
          if ($result -> num_rows>0) {
            while($row = $result -> fetch_assoc()){
              echo "<option value=".$row['deptime'].">".$row['deptime']."</option>";
            }
          }
          echo "</select>";
          ?>
        
        <input type="submit" value="Submit">
        <input type="hidden" name="came_from" value="appointment">
      </form>
      <?php
        session_start();
        if($_SESSION['invalidappointment'] == TRUE){
          echo "<p style=\"color:red;\">Appointment full or undetected.</p>";
        }
        else if($_SESSION['validappointment'] == TRUE) {
          echo "<p style=\"color:green;\">Appointment confirmed, check profile.</p>";
        }
      ?>
    </div>
  </body>
</html>