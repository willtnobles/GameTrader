<!DOCTYPE html>
<html>
    <head>
    <link rel="stylesheet" href="stylesheet.css">
        <meta charset="UTF-8">
        <title>Log in to Website</title>
        <style>
            input {
                margin-bottom: 0.5em;
            }
          </style>
      </head>
      <body background="images/background.jpg">
  
      <?php
      require_once 'login.php';
      $connection = new mysqli($hn, $un, $pw, $db); 
      if ($connection->connect_error) 
        die($connection->connect_error);
      
      session_start();
      if($_SESSION != NULL)
      {
      
      /*-----------------Checks If User Is Already Logged In-----------------*/
      if ($_SESSION['admin'] == 1)
        {
          header("Location: admin_page.php"); //If User is logged in as admin go to admin homepage
        }
      else if($_SESSION['user'] == 1)
        {
          header("Location: home_page.php"); //If User is logged in as user go to user homepage
        }
      }    
        
       /*---------If User Is Not Already Logged In Wait On Log in Info-------*/ 
       else if($_SERVER['REQUEST_METHOD'] == "POST")
      {
          if (isset($_POST['username']) && isset($_POST['password']))
          {
            $un_temp = mysql_entities_fix_string($connection, $_POST['username']);
            $pw_temp = mysql_entities_fix_string($connection, $_POST['password']);
    
            $query  = "SELECT * FROM tbx_UserTable WHERE username='$un_temp'";    
            $result = $connection->query($query);
                    
            if (!$result) 
              die($connection->error);
            
            elseif ($result->num_rows)
            {
              $row = $result->fetch_array(MYSQLI_NUM);
           		$result->close();
    
              $salt1 = "qm&h*";
              $salt2 = "pg!@";
              $token = hash('ripemd128', "$salt1$pw_temp$salt2");         
    
              if ($token == $row[5] && $row[4] == "admin") 
            	{
                  echo "Admin Log In";  //Go to user page
                  $_SESSION['admin'] = 1;
                  $_SESSION['user'] =  0;
                  $_SESSION['username'] = $un_temp;
              }
              
              else if ($token == $row[5] && $row[4] == "user") 
            	 {
                  echo "User Log In";  //Go to user page
                  $_SESSION['admin'] = 0;
                  $_SESSION['user'] =  1;
                  $_SESSION['username'] = $_POST['username'];
                  header("Location: home_page.php");
               }
               
              else 
                echo("Invalid username/password combination");
                header("Location: login_page.php");
            }     
         }
      }  
       $connection->close();        
      ?>
        
        
        <h1>Log In</h1>
                
        <p style="color: red">
        <!--Placeholder for error messages-->
        </p>
        
        <form method="post" action="login_page.php">
            <label>Username: </label>
            <input type="text" name="username"> <br>
            <label>Password: </label>
            <input type="password" name="password"> <br>
            <input type="submit" value="Log in">
        </form>
        <a href="createaccount_page">Create Account</a>
        <a href="home_page">Return Home</a>
        </p>
</html>


   <?php
      function mysql_entities_fix_string($connection, $string)
      {
        return htmlentities(mysql_fix_string($connection, $string));
      }	
    
      function mysql_fix_string($connection, $string)
      {
        if (get_magic_quotes_gpc()) $string = stripslashes($string);
          return $connection->real_escape_string($string);
      }
?>
