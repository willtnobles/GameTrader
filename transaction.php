<!DOCTYPE html>

<html>
<head>
   <link rel="stylesheet" href="stylesheet.css">
		<title>Offer Sent</title>
	</head>
	<body background="images/background.jpg">
	
	<?php
		//error_reporting(E_ALL);
		//ini_set('display_errors', 1);
		
		if ($_SERVER['REQUEST_METHOD'] == "POST") {
			
			if ($_POST['submit'] == 'Decline') {
				
				$tradeid = $_POST['tradeid'];
				
				require_once 'login.php';
				$connection = new mysqli($hn, $un, $pw, $db);
				
				if ($connection->connect_error) die($connection->connect_error);
				
				//deletes the declined trade from the table
				$query = "DELETE FROM tbx_TradeTable WHERE tradeid='$tradeid'";
				$connection->query($query);
				
				$connection->close();
				
				//send email

				header("Location: view_offers.php");
			}
			
			else if ($_POST['submit'] == 'Accept') {
				
				$tradeid = $_POST['tradeid'];
				
				require_once 'login.php';
				$connection = new mysqli($hn, $un, $pw, $db);
				
				if ($connection->connect_error) die($connection->connect_error);
				
				//changes the acceptance value of the trade to 1 to show that the offer has been accepted
				$query = "UPDATE tbx_TradeTable SET acceptance=1 WHERE tradeid='$tradeid'";
				
				$connection->query($query);
				
				$connection->close();
				
				echo "Transaction Complete!";
				
				//send email
			}
			
		} else header("Location: home_page.php");
	?>
  <h1> Instructions </h1>
  <p> Send game to address below 
  <br><br> Include your address on a slip inside of game case 
  <br><br> We will check the game to ensure quality before sending to recipient</p>
  
  <h1>Shipping Address</h1>
  <p> This is totally an address <br></p>
  <p> Defintley A zip code <br></p>
  <p> 100% A state <br></p>

	<a href='home_page.php'>Return Home</a>
	
</body>
</html>
  