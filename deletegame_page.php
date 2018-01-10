<!DOCTYPE html>
<html lang="en">
    <head>
    <link rel="stylesheet" href="stylesheet.css">
        <meta charset="UTF-8">
        <title>Delete Games</title>
        <style>
            input {
                margin-bottom: 0.5em;
            }
            .error {color: #FF0000;}
          </style>
    </head>
    <body background="images/background.jpg">
        <h1>Delete Games</h1>
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
            
            if ($_SERVER['REQUEST_METHOD'] == 'POST') //Wait for user input 
          {
            if($_POST['submit'] == "Return Home") //Return to homepage
            {
              header("Location: home_page.php"); 
            }
            
            else
            {
              echo $_POST["submit"]; //Else delete game
              delete_game($connection, $_POST["submit"]);
              header("Location: deletegame_page.php");
            }
          }

            $query = "SELECT * FROM tbx_InventoryTable WHERE username = '$username'";
            $result = $connection->query($query);
            if (!$result)
                die($connection->error);
                
            $rows = $result->num_rows;
          ?>
<form method="POST" action="deletegame_page.php">
<?php for ($j = 0 ; $j < $rows ; ++$j)
{   
  $result->data_seek($j);
  $row = $result->fetch_array(MYSQLI_ASSOC); //For gameid print title and console
  $gameid = $row['gameid'];   
  echo 'Title: '   . $row['title']   . '<br>'; //
 	echo 'Console: ' . $row['console'] . '<br>'; ?>
  <form method="post" action="deletegame_page.php">  
	<input type="hidden" name="submit" value="<?php echo $gameid; ?>">
  <input type="submit" name="submit2" value= "Delete Game"><br><br></form>
  <?php } ?>        
</form>
  <form method="post" action="viewprofile_page.php">
  <input name="submit" type="submit" value="Return Home">

<?php
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
  
  
  function delete_game($connection, $g)
  {
    echo $g;
    $query = "DELETE FROM tbx_InventoryTable WHERE gameid='$g'";
    $result = $connection->query($query);
    if (!$result) die($connection->error);
  }
?>