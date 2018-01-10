<!DOCTYPE html>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>User Page</title>
    </head>
	<body background="images/logo.jpg">

        <h1>User Page</h1>
        <?php
          require_once 'login.php';
          $connection = new mysqli($hn, $un, $pw, $db); 
          if ($connection->connect_error) 
            die($connection->connect_error);
          
          session_start();
          check_status($connection);
          echo "<a href='viewprofile_page.php'>View Profile</a>"; 
           
          
        ?>
    </body>
</html>                                                                    

<?php
  function check_status($connection)
  {
    if($_SESSION != NULL)  
    {
      if($_SESSION['user'] == 1 )
      {
        return;
      }
      else
      {
        echo "Error processing request";
        exit(1);
      }
    }
    return;
  }
  ?>

