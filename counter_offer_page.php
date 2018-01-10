<!DOCTYPE html>

<html>

	<head>
		<title>Counter Offer</title>
            <style>
            input {
                margin-bottom: 0.5em;
            }
            .error {color: #FF0000;}
            
          body{
          text-align: center;
          font-size:30px;
			    margin-left: 0%;
			    white-space: nowrap; 
            }
          
          input[type=submit]{
            background: #3498db;
            background-image: -webkit-linear-gradient(top, #3498db, #2980b9);
            background-image: -moz-linear-gradient(top, #3498db, #2980b9);
            background-image: -ms-linear-gradient(top, #3498db, #2980b9);
            background-image: -o-linear-gradient(top, #3498db, #2980b9);
            background-image: linear-gradient(to bottom, #3498db, #2980b9);
            -webkit-border-radius: 28;
            -moz-border-radius: 28;
            border-radius: 28px;
            font-family: Arial;
            color: #ffffff;
            font-size: 20px;
            padding: 10px 20px 10px 20px;
            text-decoration: none;
          }

          input[type=submit]:hover {
            background: #3cb0fd;
            background-image: -webkit-linear-gradient(top, #3cb0fd, #3498db);
            background-image: -moz-linear-gradient(top, #3cb0fd, #3498db);
            background-image: -ms-linear-gradient(top, #3cb0fd, #3498db);
            background-image: -o-linear-gradient(top, #3cb0fd, #3498db);
            background-image: linear-gradient(to bottom, #3cb0fd, #3498db);
            text-decoration: none;
          }
          
            input[type=text]{
            display: inline-block;
            -webkit-box-sizing: content-box;
            -moz-box-sizing: content-box;
            box-sizing: content-box;
            padding: 10px 20px;
            border: 1px solid #b7b7b7;
            -webkit-border-radius: 3px;
            border-radius: 3px;
            font: normal 16px/normal "Times New Roman", Times, serif;
            color: rgba(0,142,198,1);
            -o-text-overflow: clip;
            text-overflow: clip;
            background: rgba(252,252,252,1);
            -webkit-box-shadow: 2px 2px 2px 0 rgba(0,0,0,0.2) inset;
            box-shadow: 2px 2px 2px 0 rgba(0,0,0,0.2) inset;
            text-shadow: 1px 1px 0 rgba(255,255,255,0.66) ;
            -webkit-transition: all 200ms cubic-bezier(0.42, 0, 0.58, 1);
            -moz-transition: all 200ms cubic-bezier(0.42, 0, 0.58, 1);
            -o-transition: all 200ms cubic-bezier(0.42, 0, 0.58, 1);
            transition: all 200ms cubic-bezier(0.42, 0, 0.58, 1);
          }
          
          input[type=file]{
            background: #3498db;
            background-image: -webkit-linear-gradient(top, #3498db, #2980b9);
            background-image: -moz-linear-gradient(top, #3498db, #2980b9);
            background-image: -ms-linear-gradient(top, #3498db, #2980b9);
            background-image: -o-linear-gradient(top, #3498db, #2980b9);
            background-image: linear-gradient(to bottom, #3498db, #2980b9);
            -webkit-border-radius: 28;
            -moz-border-radius: 28;
            border-radius: 28px;
            font-family: Arial;
            color: #ffffff;
            font-size: 20px;
            padding: 10px 20px 10px 20px;
            text-decoration: none;
          }
          
           input[type=file]:hover {
            background: #3cb0fd;
            background-image: -webkit-linear-gradient(top, #3cb0fd, #3498db);
            background-image: -moz-linear-gradient(top, #3cb0fd, #3498db);
            background-image: -ms-linear-gradient(top, #3cb0fd, #3498db);
            background-image: -o-linear-gradient(top, #3cb0fd, #3498db);
            background-image: linear-gradient(to bottom, #3cb0fd, #3498db);
            text-decoration: none;
          }
          
          select{
            background: #3498db;
            background-image: -webkit-linear-gradient(top, #3498db, #2980b9);
            background-image: -moz-linear-gradient(top, #3498db, #2980b9);
            background-image: -ms-linear-gradient(top, #3498db, #2980b9);
            background-image: -o-linear-gradient(top, #3498db, #2980b9);
            background-image: linear-gradient(to bottom, #3498db, #2980b9);
            -webkit-border-radius: 28;
            -moz-border-radius: 28;
            border-radius: 28px;
            font-family: Arial;
            color: #ffffff;
            font-size: 20px;
            padding: 10px 20px 10px 20px;
            text-decoration: none;
          }
          
          select:hover {
            background: #3cb0fd;
            background-image: -webkit-linear-gradient(top, #3cb0fd, #3498db);
            background-image: -moz-linear-gradient(top, #3cb0fd, #3498db);
            background-image: -ms-linear-gradient(top, #3cb0fd, #3498db);
            background-image: -o-linear-gradient(top, #3cb0fd, #3498db);
            background-image: linear-gradient(to bottom, #3cb0fd, #3498db);
            text-decoration: none;
          }
          </style>
	</head>

	<body background="images/background.jpg">
	
		<?php
			//error_reporting(E_ALL);
			//ini_set('display_errors', 1);
			
			if ($_SERVER['REQUEST_METHOD'] == "GET") {
				
				session_start();
				
				if (isset($_SESSION['username'])) $check_user = $_SESSION['username'];
				$tradeid = $_GET['tradeid'];
				if (isset($_GET['err'])) $err = $_GET['err'];
				else $err = '';
				
				require_once 'login.php';
				$connection = new mysqli($hn, $un, $pw, $db); //connect to server
			
				if ($connection->connect_error) die($connection->connect_error);
				
				$query1 = "SELECT * FROM tbx_TradeTable WHERE tradeid='$tradeid'";
				
				//connect to database and retrieve the names of the users
				$result = $connection->query($query1); //retrieve games from each user
				$row1 = $result->fetch_array(MYSQLI_ASSOC);
				$user1 = $row1['p_username'];
				$user2 = $row1['username'];
				
				$result->close();
				
				//make sure the user is who they say they are
				if ($check_user != $user1) {
					$connection->close();
					header("Location: home_page.php");
				}
				
				$query1 = "SELECT * FROM tbx_InventoryTable WHERE username='$user1'";
				$query2 = "SELECT * FROM tbx_InventoryTable WHERE username='$user2'";
				
				$result1 = $connection->query($query1); //retrieve games from each user
				$result2 = $connection->query($query2);
				
				echo "<b>Select which games you would like to submit as your counter offer</b><br><br>\n";
				echo "<p style='color: #FF0000'>".$err."</p>";
				echo "Your games:<br>\n";
				echo "<form method='post' action='send_counter.php'>\n";
				
				//list the games of the user making the counter offer
				for ($x=0; $x < $result1->num_rows; $x++) {
					$result1->data_seek($x);
					$row = $result1->fetch_array(MYSQLI_ASSOC);
					
					echo "<input name='game1' type='radio' value=".$row['gameid'].">".$row['title']." (".$row['console'].")<br>\n";
				}
				
				echo "<br><br>\n";
				
				echo $user2."'s games:<br>\n";
				
				//list the games of the user receiving the counter offer
				for ($x=0; $x < $result2->num_rows; $x++) {
					$result2->data_seek($x);
					$row = $result2->fetch_array(MYSQLI_ASSOC);
					
					echo "<input name='game2' type='radio' value=".$row['gameid'].">".$row['title']." (".$row['console'].")<br>\n";
				}
				
				$result1->close();
				$result2->close();
				$connection->close();
				
				echo "<input type='hidden' name='altuser' value='$user2'>\n";
				echo "<input type='hidden' name='tradeid' value='$tradeid'>\n";
				echo "<br><input type='submit' value='Submit Offer'>\n";
				
				echo "</form><br>";
				
			} else header("Location: home_page.php");
		?>
		<form method='get' action='home_page.php'>
			<input type='submit' value='Cancel'>
		</form>
		
	</body>

</html>