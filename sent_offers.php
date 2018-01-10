<!DOCTYPE html>

<html>
<head>
     <link rel="stylesheet" href="stylesheet.css">
        <meta charset="UTF-8">
        <style>
          body{
          text-align: center;
          font-size:30px;
			    margin-left: 0%;
			    white-space: nowrap; 
          }
        </style>

		<title>Sent Offers</title>

    </head>

	<body background="images/background.jpg">

		<h1>Your Sent Offers</h1>
	
		<?php
			//error_reporting(E_ALL);
			//ini_set('display_errors', 1);
			
			session_start();
			
			if (isset($_SESSION['username'])) {
				
				$user = $_SESSION['username'];
				
				require_once 'login.php';
				$connection = new mysqli($hn, $un, $pw, $db);
				
				if ($connection->connect_error) die($connection->connect_error);
				
				$query = "SELECT * FROM tbx_TradeTable WHERE username='$user'";
				$result = $connection->query($query);
				
				//display all the offers sent by the user
				for ($x=0; $x < $result->num_rows; $x++) {
					$result->data_seek($x);
					$row = $result->fetch_array(MYSQLI_ASSOC);
					
					$gameid1 = $row['gameid'];
					$gameid2 = $row['p_gameid'];
					$accept = $row['acceptance'];
					
					//retrieve the game titles from the inventory table
					$q = "SELECT * FROM tbx_InventoryTable WHERE gameid='$gameid1'";
					$q2 = "SELECT * FROM tbx_InventoryTable WHERE gameid='$gameid2'";
					
					$res = $connection->query($q);
					$res2 = $connection->query($q2);
					
					$r = $res->fetch_array(MYSQLI_ASSOC);
					$r2 = $res2->fetch_array(MYSQLI_ASSOC);
					
					$title1 = $r['title'];
					$title2 = $r2['title'];
					
					if ($accept) {
						$status = "Accepted";
					} else $status = "Pending";
					
					echo "To: ".$row['p_username']."<br>\n";
					echo "Your game: ".$title1."<br>\n";
					echo "For their game: ".$title2."<br>\n";
					echo "Status: ".$status."<br><br>\n";
					
					$res->close();
					$res2->close();
				}
				
				//displays if there are no offers the show
				if ($result->num_rows == 0) {
					echo "<h3>You haven't sent any offers</h3>";
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