<?php session_start();?>
<?php
		mb_internal_encoding('UTF-8');
		mb_http_output('UTF-8');

		if ($_GET["email"] !== NULL && $_GET["email"] != "" &&
			$_GET["psw"] !== NULL && $_GET["psw"] != "")
		{
       		include 'sunapeedb.php';
			$db = new SunapeeDB();
			$db->connect();
			$returnVal = $db->hw6_login($_GET["email"], $_GET["psw"]);
			if ($returnVal == 1) {
				$_SESSION["email"] = $_GET["email"];
				$_SESSION["id"] = $db->get_my_id($_GET["email"]);

				if ($db->is_emp($_SESSION["id"])) {
					header('Location: hw6_emp.php');
				}
				else {
					header('Location: hw6_customer.php');
				}
			}
			else if ($returnVal == 0) {
				echo '<p align="center">'. "Wrong Email or Password!\n" .'</p>';
				print "<form action='login.html'>
					   <center><button type='submit' name='return'>Return</center>
					   </form>";
			}
			$db->disconnect();
		}
		else {
			print("Input Invalid. Try Again!\n");
		}
?>