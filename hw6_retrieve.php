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
  <title>Retrieve Passenger List</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
  <link rel="stylesheet" href="dbstyle.css"> 
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
</head>

<body>
<?php
		mb_internal_encoding('UTF-8');
		mb_http_output('UTF-8');

		if ($_GET["retrieve"] !== NULL && $_GET["retrieve"] != "")
		{
			include 'sunapeedb.php';
			$db = new SunapeeDB();
			$db->connect();
			$db->hw6_show_passenger_list($_GET["retrieve"]);
			$db->disconnect();
		}
		else {
			print("NULL\n");
		}
?>

<br>
<form action='hw6_emp.php'>
	<center><button type="submit" name="return">Return</center>
</form>
</body>

</html>

