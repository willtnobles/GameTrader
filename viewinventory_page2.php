<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>User Page</title>
    </head>
    <body background="images/background.jpg">
        <h1>User Page</h1>
        <?php
          require_once 'login.php';
     
          $connection = new mysqli($hn, $un, $pw, $db); 
          if ($connection->connect_error) 
            die($connection->connect_error);
          
          session_start();
          $username = check_status();// Checks if user is logged in, if not go to login page
          $query  = "SELECT * FROM tbx_InventoryTable WHERE username = '$username'";
            $result = $connection->query($query);
            if (!$result) 
                die($connection->error);
            
            $rows = $result->num_rows;
            
            for ($j = 0 ; $j < $rows ; ++$j)
            {
              $result->data_seek($j);
              $row = $result->fetch_array(MYSQLI_ASSOC);

              //$image = $row['game_image'];
			  //echo echo base64_encode(stream_get_contents($row2['image']));
			  echo '<img src="data:image/jpeg;base64,' . base64_encode( $row['game_image'] ) . '" />';
              echo "</tr>";
			  echo 'Title: '   . $row['title']   . '<br>';
              echo 'Category: '. $row['category']    . '<br>';
              echo 'Console: ' . $row['console'] . '<br>';
              
              
            }
            
              $result->close();
              $connection->close();
          ?>
    </body>
</html> 


<?php
  function check_status()
  {
    if($_SESSION != NULL)  
    {
      $username = $_SESSION['username']; //Passes in the username
      if($_SESSION['user'] == 1 )
      {
        $username = $_SESSION['username'];
        return $username;
      }
      else
      {
        echo "Error processing request";
        header("Location: login_page.php");
      }
    }
    return;
  }
	function get_game_image($name) {
		
	}
?>