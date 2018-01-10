<!DOCTYPE html>
<html lang="en">
    <head> 
    <link rel="stylesheet" href="stylesheet.css">
        <meta charset="UTF-8">
        <title>Add Games</title>
    </head>
    <body background="images/background.jpg">
        <h1>Add Games</h1>
        <?php
          require_once 'login.php';
     
          $connection = new mysqli($hn, $un, $pw, $db); 
          if ($connection->connect_error) 
            die($connection->connect_error);
          
          session_start();
          $username = check_status();// Checks if user is logged in, if not go to login page
          
          /*----------Initial Variable Declaration-------------*/  
          $title = "";
          $titleERR = "";
          
          $category = "";
          $categoryERR = "";
          
          $gameimage = "defaultgameimage.jpeg";
          $gameimageERR = "";
          
          $console = "";
          $consoleERR = "";
          
          /*------------------Waition on user input-------------*/
          if ($_SERVER['REQUEST_METHOD'] == 'POST') 
          { 
            /*-------Sets user input equal to appropriate variable------*/
            $title  = $_POST['title'];
            $category  = $_POST['category'];
            if($_POST['gameimage'] != NULL)
              $gameimage = $_POST['gameimage'];
            $console = $_POST['console'];
            
             
            /*-----------Error statements for inproper input----------*/ 
            if (strlen($title) < 3) //Checks if username is at least 6 characters
              $titleERR = "Your title must be 3 or more characters";
            
            if ($category == "--") //Makes sure name consists of letters
              $categoryERR = "Invalid category selection";
             
            if ($console == "--") //Checks for valid email info
              $consoleERR = "Invalid console selection";
            
            if($_POST['submit'] == "Add Game" && $titleERR == "" && $categoryERR == "" && $consoleERR == "")
            {
                add_game($connection, $username, $title, $category, $gameimage, $console);
            }
            
            else if($_POST['submit'] == "Done")
            {
                header("Location: viewprofile_page.php");
            }
          }
           $connection->close(); //Closes the connection to the data base
          ?>
           
        <p><span class="error">All form fields must be completed for account creation.</span></p> <!--All info required print statement-->
        <form method="post" action="addgame_page.php"> 
        
            <!--
            I was thinking about having a drop down box with Mr., Ms., or Mrs. to store in the data base. I know amazon does this it'll help us properly address them 
            if we ever have to send them information. It'll be pretty easy to implement so its on you guys if you want it our not just let me know
            --> 
        
            Upload Game Image: <input type="file" name="gameimage" accept="image/*" value="<?php echo $gameimage ?>" ><span class="error"><?php echo $gameimageERR ?></span><br><br>
            
            Title: <input type="text" size="35" name="title" placeholder="Insert Game Title" value="<?php echo $title ?>" > <!--Asks for game title-->
            <span class="error"><?php echo $titleERR ?></span>
            <br><br>
     
            Category: <select name="category"> <option selected> -- </option> <option> First Person Shooter </option> <option> Third Person Shooter </option> <option> Strategy </option> <option> Arcade </option> <option> Fighter </option> <option> Racing </option>
            <span class="error"><?php echo $categoryERR ?></span>
            </select><br><br>
            
            Console: <select name="console"> <option selected> -- </option> <option> Playstation 4 </option> <option> Playstation 3 </option> <option> Xbox One </option> <option> Xbox 360 </option> <option> Nintendo Switch </option> <option> Wii U </option>
            <span class="error"><?php echo $consoleERR ?></span>
            </select><br><br>
            
            <input type="submit" name="submit" value="Add Game"><br>
        </form>
        <form method="post" action="viewprofile_page.php">
            <input type="submit" name="submit" value="Done"><br>   
        </form>
        
        <a href="home_page.php">Return Home</a><br>
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
  }
  
  /*----------------------Add User Function----------------------------*/
  function add_game($connection, $un, $tt, $ct, $gi, $cs)
  {
    $query  = "INSERT INTO tbx_InventoryTable (username, title, category, game_image, console) "
            . "VALUES('$un', '$tt', '$ct', '$gi', '$cs')";
    $result = $connection->query($query);
    if (!$result) die($connection->error);
  }
?> 