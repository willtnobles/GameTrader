<!DOCTYPE html>

<html>

	<head>
  <head>
     <link rel="stylesheet" href="stylesheet.css">
		<title>Trade</title>
	</head>

	<body background="images/background.jpg">
	
		<?php
			//error_reporting(E_ALL);
			//ini_set('display_errors', 1);
			
			if ($_SERVER['REQUEST_METHOD'] == "GET") {
				
				session_start();
				
				if (isset($_SESSION['username'])) $user1 = $_SESSION['username'];
				$user2 = $_GET['altuser'];
				if (isset($_GET['err'])) $err = $_GET['err'];
				else $err = '';
				
				//echo $user1;
				//echo $user2;
				
				require_once 'login.php';
				$connection = new mysqli($hn, $un, $pw, $db); //connect to server
			
				if ($connection->connect_error) die($connection->connect_error);
				
				$query1 = "SELECT * FROM tbx_InventoryTable WHERE username='$user1'";
				$query2 = "SELECT * FROM tbx_InventoryTable WHERE username='$user2'";
				
				$result1 = $connection->query($query1); //retrieve games from each user
				$result2 = $connection->query($query2);
				
				echo "<b>Select which games you would like to trade</b><br>\n";
				echo "<p style='color: #FF0000'>".$err."</p>";
				echo "Your games:<br>\n";
				echo "<form method='post' action='send_offer.php'>\n";
				
				//list the games of the user making the offer
				for ($x=0; $x < $result1->num_rows; $x++) {
					$result1->data_seek($x);
					$row = $result1->fetch_array(MYSQLI_ASSOC);
					
					echo "<input name='game1' type='radio' value=".$row['gameid'].">".$row['title']." (".$row['console'].")<br>\n";
				}
				
				echo "<br><br>\n";
				
				echo $user2."'s games:<br>\n";
				
				//list the games of the user receiving the offer
				for ($x=0; $x < $result2->num_rows; $x++) {
					$result2->data_seek($x);
					$row = $result2->fetch_array(MYSQLI_ASSOC);
					
					echo "<input name='game2' type='radio' value=".$row['gameid'].">".$row['title']." (".$row['console'].")<br>\n";
				}
				
				$result1->close();
				$result2->close();
				$connection->close();
				
				echo "<input type='hidden' name='altuser' value='$user2'>\n";
				echo "<br><input type='submit' value='Submit Offer'>\n";
				
				echo "</form><br>";
				
			} else header("Location: home_page.php");
		?>
		<form method='get' action='home_page.php'>
			<input type='submit' value='Cancel'>
		</form>
		
	</body>

</html>