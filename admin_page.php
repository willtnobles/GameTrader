<!DOCTYPE html>
<html lang="en">
    <head> 
    <link rel="stylesheet" href="stylesheet.css">
        <meta charset="UTF-8">
        <title>Administrator Page</title>
    </head>
    <body background="images/background.jpg">
        <h1>Administrator Page</h1>
        <?php
        session_start();   
        if($_SESSION != NULL)  
        {   
        if($_SESSION['admin'] == 1) //Check if admin is logged in 
          {
             
            require_once 'login.php';
            $connection = new mysqli($hn, $un, $pw, $db); 
            if ($connection->connect_error) 
               die($connection->connect_error);
               
            if ($_SERVER['REQUEST_METHOD'] == 'POST')// Wait for user input
            {
              if($_POST['submit2'] == 'Delete User')//If the user selects delete user
                {
                   delete_user($connection, $_POST["submit"]);//call delete function
                   header("Location: admin_page.php");//
                
                }
            }
            
            
            $query = "SELECT username, firstname, lastname FROM tbx_UserTable WHERE TYPE = 'user'";          
          
            $result = $connection->query($query);
            if (!$result)
                die($connection->error);
                          
            $rows = $result->num_rows;
            for ($j = 0 ; $j < $rows ; ++$j)
            {
            
              $result->data_seek($j);
              $row = $result->fetch_array(MYSQLI_ASSOC);
                
                $user = $row['username'];
                echo 'User: '  . $row['username'] . '<br>'; //Print username name
                echo 'Firstname: '  . $row['firstname'] . '<br>';  //Print first name
                echo 'Lastname: '  . $row['lastname'] . '<br>'; //Print last name
                ?>
                <form method="post" action="admin_page.php">   
              	<input type="hidden" name="submit" value="<?php echo $user; ?>">
                <input type="submit" name="submit2" value= "Delete User"><br><br></form>
                <?php     
             }
            
            $result->close;
            $connection->close;
            
          }
          
          else
          {
            echo "<a href=login_page.php>Invalid User: Click Here To Go Back To The Homepage</a>";
            exit();
          }
        }
          else
          {
            echo "<a href=login_page.php>Invalid User: Click Here To Go Back To The Homepage</a>";
            exit();
          }
                             
        ?>
    </body>
</html>
<?php
function delete_user($connection, $user)
{
  echo $user;
  $query = "DELETE FROM tbx_UserTable WHERE username='$user'"; //
  $result = $connection->query($query);
  if (!$result) die($connection->error);
  $query = "DELETE FROM tbx_InventoryTable WHERE username='$user'";
  $result = $connection->query($query);
  if(!$result) die($connection->error);
  $query = "DELETE FROM tbx_WishlistTable WHERE username='$user'";
}
?>