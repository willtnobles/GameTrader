<!DOCTYPE html>
<html lang="en">
    <head>
    <link rel="stylesheet" href="stylesheet.css">
        <meta charset="UTF-8">
        <title>User2 Page</title>
        <style>
            input {
                margin-bottom: 0.5em;
            }
            .error {color: #FF0000;}
          </style>
    </head>
    <body background="images/background.jpg">
        <h1>Viewing User Inventory</h1>
        <?php
		error_reporting(E_ALL);
	    ini_set('display_errors', 1);

          require_once 'login.php';
				
          $connection = new mysqli($hn, $un, $pw, $db); 
          if ($connection->connect_error) 
            die($connection->connect_error);
          
          session_start();
          
          
          
          //if(isset($_POST['altuser']){
          //$view = $_POST['altuser'];
         // }
          //$view = $_SESSION['altuser'];
         
          
          $view = $_GET['altuser'];
         
         
          $username = check_status();// Checks if user is logged in, if not go to login page
          
          echo $_GET['altuser'];
          echo $view;
          //echo $username;
            $query  = "SELECT * FROM tbx_InventoryTable WHERE username = '$view'";
          
            $result = $connection->query($query);
            if (!$result) 
                die($connection->error);
            
            $rows = $result->num_rows;
            
            for ($j = 0 ; $j < $rows ; ++$j)
            {
              $result->data_seek($j);
              $row = $result->fetch_array(MYSQLI_ASSOC);
              
              //echo get_game_image($row['gameid']);
			        echo 'Title: '   . $row['title']   . '<br>';
              echo 'Category: '. $row['category']    . '<br>';
              echo 'Console: ' . $row['console'] . '<br><br>';
             
             
            }
            
              $result->close();
              $connection->close();

          ?>



<?php
  function check_status()
  {
    if($_SESSION != NULL)  
    {
      $username = $_SESSION['username']; //Passes in the username
      if($_SESSION['user'] == 1 )
      {
        $username = $_SESSION['username'];
        return $username;//$view;
      }
      else
      {
        echo "Error processing request";
        header("Location: login_page.php");
      }
    }
    return;
  }
	function get_game_image($id) {
		$conn = new mysqli($hn, $un, $pw, $db);
		$q = "SELECT game_image FROM tbx_InventoryTable WHERE gameid = '$id'";
		$res = $conn->query($q);
		$r = $res->fetch_array(MYSQLI_ASSOC);
		$conn->close();
		$res->close();
		
		header("Content-type: image/jpeg");
		echo $r['game_image'];
	}
?>