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
  <title>Most Booked Flights</title>
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
      <a class="navbar-brand" href="#">Employee</a>
    </div>
    <div>
      <ul class="nav navbar-nav">
        <li><a href="hw6_emp.php">Passenger List</a></li>
        <li class="active"><a href="#">Top 5 Most Booked Flights</a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li><a href="#"><span class="glyphicon glyphicon-user"></span><?php echo $_SESSION["email"]?></a></li>
        <li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
      </ul>
    </div>
  </div>
</nav>

<div style="background-color:white; color:black; padding:20px;">

<h2><center>Choose Date</center></h2>
  <form action="hw6_handle_most_booked_flights.php" method="get"><br>
  <center><p><b>From:</b>  <input type="date" name="from"></center><br></p>
  <center><p><b>To:</b>  <input type="date" name="to" ></center><br></p>
  <center><input type="submit" value="submit"></center>
</div>


<!--
<br><br>
<div class="container">
  <h2><center>Choose Date</center></h2><br>
  <form class="form-horizontal" role="form">
    <div class="form-group">
      <label class="control-label col-sm-2" for="email">From:</label>
      <div div class='input-group date' id='datetimepicker1'>
        <input type="date" class="form-control" id="email" name="from">
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-sm-2" for="pwd">To:</label>
      <div div class='input-group date' id='datetimepicker1'>          
        <input type="date" class="form-control" id="pwd" name="to">
      </div>
    </div>

    <div class="form-group">        
      <div class="col-sm-offset-2 col-sm-10">
        <button type="submit" class="btn btn-default">Submit</button>
      </div>
    </div>
  </form>
</div>
-->

</body>
</html>



</body>
</html>