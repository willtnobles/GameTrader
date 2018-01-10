<!DOCTYPE html>
<html>
    <head>
    <link rel="stylesheet" href="stylesheet.css">
        <meta charset="UTF-8">
        <title>Create Account</title>
        <style>
            input {
                margin-bottom: 0.5em;
            }
            .error {color: #FF0000;}
          </style>
      </head>
      <body background="images/background.jpg">
      <?php
      require_once 'login.php';
      $connection = new mysqli($hn, $un, $pw, $db); 
      if ($connection->connect_error) 
        die($connection->connect_error);
      
      session_start();
      
      
      /*-----------------Checks If User Is Already Logged In-----------------*/
      /*This is here to stop already logged in users from creating an account, they will have to log out first. We should
      probably print a message out or something saying why they can't create an account lol*/
      
      if($_SESSION != NULL) //Considering making this a function because it's required for almost every page
      {
        if ($_SESSION['admin'] != NULL)
        {
          header("Location: admin_page.php"); //If User is logged in as admin go to admin homepage
        }
        else if($_SESSION['user'] == 1)
        {
          header("Location: user_page.php"); //If User is logged in as user go to user homepage
        }
      }    
      
       
      /*---------If User Is Not Already Logged In Wait On Creation Info-------*/ 
      else
      {
      /*----------Initial Variable Declaration-------------*/  
      $username = "";
      $usernameERR = "";
      
      $firstname = "";
      $firstnameERR = "";
      
      $lastname = "";
      $lastnameERR = "";
      
      $email = "";
      $emailERR = "";
      
      $password = "";
      $passwordERR = "";
      
      
      /*------------------Waition on user input-------------*/
      if($_SERVER['REQUEST_METHOD'] == "POST")
      {
          /*-------Sets user input equal to appropriate variable------*/
          $username  = $_POST['username'];
          $firstname  = $_POST['firstname'];
          $lastname  = $_POST['lastname'];
          $email = $_POST['email'];
          $password = $_POST['password'];
          
           
          /*-----------Error statements for inproper input----------*/ 
          if (strlen($username) < 6) //Checks if username is at least 6 characters
            $usernameERR = "Your username must be 6 or more characters";//SIDE NOTE: NEED TO CHECK IF IT IS ALREADY TAKEN
          
          if (!preg_match("/^[a-zA-Z ]*$/", $firstname) || $firstname == "") //Makes sure name consists of letters
            $firstnameERR = "Your first name must consist of letter and white space";
            
          if (!preg_match("/^[a-zA-Z ]*$/", $lastname) || $lastname == "") //Makes sure name consists of letters
            $lastnameERR = "Your last name must consist of letter and white space";
           
          if (!filter_var($email, FILTER_VALIDATE_EMAIL)) //Checks for valid email info
            $emailERR = "Invalid email format";
            
          if (strlen($password) < 6) //Makes sure password is at least 6 characters
            $passwordERR = "Your password must be 6 or more characters";
        
        
          /*-----------------------If all info is valid create the account-----------------------------*/
          if($usernameERR == "" && $firstnameERR == "" && $lastnameERR == "" && $emailERR == "" && $passwordERR == "")
          {
            $salt1    = "qm&h*";
            $salt2    = "pg!@";
            $type       = 'user'; //Type should default to user because all created accounts are users, admins must be created by other admins
            $token    = hash('ripemd128', "$salt1$password$salt2"); //Hashes the password
            add_user($connection, $username, $firstname, $lastname, $email, $type, $token); //Calls create account function
            header("Location: login_page.php");
            //$_SESSION['user'] =  1; //I haven't implemented yet but my plan is located below
            
            /*User session is set to one then the user is taken back to the homepage. The home page will run the log in check and see that a user is logged in and immediatly transfer 
            them to the user homepage. To the user he will think that he's been directly taken to the user page, but in actuallity there is a small step inbetween just incase we encounter 
            problem between the creation and login. If there is a problem the user will be prompted to log in at the log in page. It will be a slight inconveince but it will stop any unwanted
            errors from occuring*/
          }
      
      }
      $connection->close(); //Closes the connection to the data base
      }
    ?>
        <!-------------------------------Form Data-------------------------------*/
        <h1>Account Creation</h1> <!--Title-->
        <p><span class="error">All form fields must be completed for account creation.</span></p> <!--All info required print statement-->
        <form method="post" action="createaccount_page.php"> 
        
            <!--
            I was thinking about having a drop down box with Mr., Ms., or Mrs. to store in the data base. I know amazon does this it'll help us properly address them 
            if we ever have to send them information. It'll be pretty easy to implement so its on you guys if you want it our not just let me know
            --> 
        
            Username: <input type="text" size="35" name="username" placeholder="Username" value="<?php echo $username ?>" > <!--Asks for username-->
            <span class="error"><?php echo $usernameERR ?></span>
            <br><br>
            
            First Name: <input type="text" size="35" name="firstname" placeholder="First Name" value="<?php echo $firstname ?>" > <!--Asks for firstname-->
            <span class="error"><?php echo $firstnameERR ?></span>
            <br><br>
            
            Last Name: <input type="text" size="35" name="lastname" placeholder="Last Name" value="<?php echo $lastname ?>" > <!--Asks for lastname-->
            <span class="error"><?php echo $lastnameERR ?></span>
            <br><br>
            
            E-mail: <input type="text" size="35" name="email" placeholder="E-mail" value="<?php echo $email ?>"> <!--Asks for email-->
            <span class= "error"><?php echo $emailERR; ?></span>
            <br><br>
            
            Password: <input type="password" size="35" name="password" placeholder="Password"value="<?php echo $password ?>"> <!--Asks for password-->
            <span class= "error"><?php echo $passwordERR; ?></span>
            <br><br>
            
            <input type="submit" name="submit" value="submit">
            <a href="home_page.php">Return Home</a> 

        </form>
            
    </body>
</html>


<?php
  /*----------------------Add User Function----------------------------*/
  function add_user($connection, $un, $fn, $ln, $em, $ty, $pw)
  {
    $query  = "INSERT INTO tbx_UserTable (username, firstname, lastname, email, type, password) "
            . "VALUES('$un', '$fn', '$ln', '$em', '$ty', '$pw')";
    $result = $connection->query($query);
    if (!$result) die($connection->error);
  }
?>


