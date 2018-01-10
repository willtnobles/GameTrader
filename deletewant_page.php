<!DOCTYPE html>
<html lang="en">
    <head>
    <link rel="stylesheet" href="stylesheet.css">
        <meta charset="UTF-8">
        <title>Remove from Wishlist</title>
        <style>
            input {
                margin-bottom: 0.5em;
            }
            .error {color: #FF0000;}
          </style>
    </head>
    <body background="images/background.jpg">
        <h1>Delete from Wishlist</h1>
        <?php
		error_reporting(E_ALL);
	    ini_set('display_errors', 1);

          require_once 'login.php';
          
          session_start();
          $gameid = "";  
          $username = check_status();// Checks if user is logged in, if not go to login page
          
		      $connection = new mysqli($hn, $un, $pw, $db); 
          if ($connection->connect_error) 
            die($connection->connect_error);
            
            if ($_SERVER['REQUEST_METHOD'] == 'POST') 
          {
            if($_POST['submit'] == "Return Home")
            {
              header("Location: viewprofile_page.php");
            }
            
            else
            {
              echo $_POST["submit"];
              deletewish_game($connection, $_POST["submit"]);
              header("Location: deletewant_page.php");
            }
          }
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
          ?>
          
<form method="POST" action="deletewant_page.php">
<?php for ($x = 0 ; $x < $rows2; ++$x)
{
  $result2->data_seek($j);
  $row2 = $result2->fetch_array(MYSQLI_ASSOC);
  $gameid = $row2['gameid'];    
  echo 'Title: '   . $row2['title']   . '<br>'; 
  echo "<img src='images/cat.jpg' style='width:100px;height:120px;'><br>";
  echo 'Category: '. $row2['category']    . '<br>';
  echo 'Console: ' . $row2['console'] . '<br><br>';
  ?>
  <form method="post" action="deletewant_page.php">   
	<input type="hidden" name="submit" value="<?php echo $gameid; ?>">
  <input type="submit" name="submit2" value= "Delete Game"><br><br></form>
  <?php } } ?>        
</form>
  <form method="post" action="deletewant_page.php">
  <input name="submit" type="submit" value="Return Home">

<?php

      $result->close();
      $connection->close();
?>
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
  
    
  function deletewish_game($connection, $g)
  {
    echo $g;
    $query = "DELETE FROM tbx_WishlistTable WHERE gameid='$g'";
    $result = $connection->query($query);
    if (!$result) die($connection->error);
  }
	
?>