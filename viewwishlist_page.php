<!DOCTYPE html>
<html lang="en">
    <head>
    <link rel="stylesheet" href="stylesheet.css">
        <meta charset="UTF-8">
        <title>View Wishlist</title>
        <style>
            input {
                margin-bottom: 0.5em;
            }
            .error {color: #FF0000;}
          </style>
    </head>
    <body background="images/background.jpg">
        <h1>View Wishlist</h1>
        <?php
	    ini_set('display_errors', 1);

          require_once 'login.php';
          
          session_start();
          
          if ($_SERVER['REQUEST_METHOD'] == 'POST') 
          {
            if($_POST['submit'] == "Return Home")
            {
              header("Location: viewprofile_page.php");
            }
          }
          $username = check_status();// Checks if user is logged in, if not go to login page

		  $connection = new mysqli($hn, $un, $pw, $db); 
          if ($connection->connect_error) 
            die($connection->connect_error);

            $query  = "SELECT * FROM tbx_WishlistTable WHERE username = '$username'";
            $result = $connection->query($query);
            if (!$result) 
                die($connection->error); 
            $rows = $result->num_rows;
            
            for ($j = 0 ; $j < $rows ; ++$j)
            {
              $result->data_seek($j);
              $row = $result->fetch_array(MYSQLI_ASSOC);

              $c = $row['gameid'];   
              
              $query2  = "SELECT * FROM tbx_InventoryTable WHERE gameid = '$c'";
              $result2 = $connection->query($query2);
              if (!$result2) 
                  die($connection->error); 
              $rows2 = $result2->num_rows;
              
              for ($x = 0 ; $x < $rows2 ; ++$x)
              {
                $result2->data_seek($j);
                $row2 = $result2->fetch_array(MYSQLI_ASSOC);
  
                echo 'Title: '   . $row2['title']   . '<br>'; 
                echo "<img src='images/cat.jpg' style='width:100px;height:120px;'><br>";
                echo 'Category: '. $row2['category']    . '<br>';
                echo 'Console: ' . $row2['console'] . '<br><br>';      
              }    
            }
            
            /*
              
            */
            
              $result->close();
              $connection->close();

          ?>
<form method="POST" action="viewinventory_page.php">
<input name="submit" type="submit" value="Return Home">
</form>
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
	
?>