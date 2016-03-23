<?php 
  session_start();
  if(!isset($_SESSION["email"]))
  {
    //echo "<script type=\"text/javascript\"> window.location = \"login.php\"</script>";
    header("Location: login.html");
    exit();
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Past Flights</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
  <link rel="stylesheet" href="dbstyle.css"> 
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
</head>
<body>

<nav class="navbar navbar-default">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="#">Customer</a>
    </div>
    <div>
      <ul class="nav navbar-nav">
        <li><a href="hw6_customer.php">Flight Schedules</a></li>
        <li class="active"><a href="#">Past Flights</a></li>
        <li><a href="hw6_upcoming_flight.php">Upcoming Flights</a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li><a href="#"><span class="glyphicon glyphicon-user"></span><?php echo $_SESSION["email"]?></a></li>
        <li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
      </ul>
    </div>
  </div>
</nav>

<?php
	include 'sunapeedb.php';
	$db = new SunapeeDB();
	$db->connect();
	$db->hw6_display_past_flight();
	$db->disconnect();
?>
</body>
</html>