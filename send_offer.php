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
		$gameid1 = $_POST['game1'];
		$gameid2 = $_POST['game2'];
		
		//echo $gameid1."\n";
		//echo $gameid2;

		//make sure 2 games were selected
		if ($gameid1 == '' || $gameid2 == '') {
			$err = "You must select two games";
			$altuser = $_POST['altuser'];
			header("Location: transaction_page.php?altuser=$altuser&err=$err");
		}
		
		require_once 'login.php';
		$connection = new mysqli($hn, $un, $pw, $db);
			
		if ($connection->connect_error) die($connection->connect_error);
		
		//retrieve info for the user sending the offer
		$q = "SELECT * FROM tbx_InventoryTable WHERE gameid='$gameid1'";
		$res = $connection->query($q);
		$r = $res->fetch_array(MYSQLI_ASSOC);
		$user1 = $r['username'];
		$game1 = $r['title'];
		$console1 = $r['console'];
		
		$res->close();
		
		//retrieve info for the user receiving the offer
		$query = "SELECT * FROM tbx_InventoryTable WHERE gameid='$gameid2'";
		$result = $connection->query($query);
		$row = $result->fetch_array(MYSQLI_ASSOC);
		$user2 = $row['username'];
		$game2 = $row['title'];
		$console2 = $row['console'];
		
		$result->close();
		
		//retrieve the email of the user receiving the offer
		$q2 = "SELECT * FROM tbx_UserTable WHERE username='$user2'";
		$res2 = $connection->query($q2);
		$r2 = $res2->fetch_array(MYSQLI_ASSOC);
		$email = $r2['email'];
		
		$res2->close();
		
		//insert the trade into the table
		$query2 = "INSERT INTO tbx_TradeTable (username, gameid, p_username, p_gameid) VALUES('$user1', '$gameid1', '$user2', '$gameid2')";
		$connection->query($query2);
		
		$connection->close();
		
	} else header("Location: home_page.php");
?>
	
		<h2>Your offer has been sent!</h2><br><br>
		<p>Your offer will be pending until the other user has accepted it.</p>

		<form action='home_page.php'>
			<input type='submit' value='Return Home'>
		</form>
	
	</body>

</html>