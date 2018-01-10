<!DOCTYPE html>

<html>

	<head>
  <link rel="stylesheet" href="stylesheet.css">
		<title>Your Offers</title>
	</head>

	<body background="images/background.jpg">

		<h1>Your Offers</h1>
	
		<?php
			error_reporting(E_ALL);
			ini_set('display_errors', 1);
			
			session_start();
			
			if (isset($_SESSION['username'])) {
				
				$user = $_SESSION['username'];
				
				require_once 'login.php';
				$connection = new mysqli($hn, $un, $pw, $db);
				
				if ($connection->connect_error) die($connection->connect_error);
				
				$query = "SELECT * FROM tbx_TradeTable WHERE p_username='$user'";
				$result = $connection->query($query);
				
				//display the offers sent to the user
				for ($x=0; $x < $result->num_rows; $x++) {
					$result->data_seek($x);
					$row = $result->fetch_array(MYSQLI_ASSOC);
					
					$gameid1 = $row['gameid'];
					$gameid2 = $row['p_gameid'];
					
					//retrieve the game titles
					$q = "SELECT * FROM tbx_InventoryTable WHERE gameid='$gameid1'";
					$q2 = "SELECT * FROM tbx_InventoryTable WHERE gameid='$gameid2'";
					
					$res = $connection->query($q);
					$res2 = $connection->query($q2);
					
					$r = $res->fetch_array(MYSQLI_ASSOC);
					$r2 = $res2->fetch_array(MYSQLI_ASSOC);
					
					$title1 = $r['title'];
					$title2 = $r2['title'];
					
					echo "<form method='post' action='transaction.php'>\n";
					echo "From: ".$row['username']."<br>\n";
					echo "Your game: ".$title2."\n<br>";
					echo "For their game: ".$title1."\n<br>";
					echo "<input type='hidden' name='tradeid' value=".$row['tradeid'].">\n";
					echo "<input type='submit' name='submit' value='Accept'>\n";
					echo "<input type='submit' name='submit' value='Decline'>\n";
					echo "</form>\n";
					echo "<form method='get' action='counter_offer_page.php'>\n";
					echo "<input type='hidden' name='tradeid' value=".$row['tradeid'].">\n";
					echo "<input type='submit' name='submit' value='Counter Offer'>\n";
					echo "</form>";
					
					$res->close();
					$res2->close();
				}

				//displays if there are no offers to show
				if ($result->num_rows == 0) {
					echo "<h3>You have no offers</h3>";
				}
				
				$result->close();
				$connection->close();
				
			} else header("Location: home_page.php");
		?>
		
		<form action='display_offers.php'>
			<input type='submit' value='Return to Offers'>
		</form>
		
	</body>

</html>