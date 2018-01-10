<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>User Page</title>
        <style>
          .tile1{
          height: 385px;
          width: 634px;
          overflow: hidden;
          background-repeat: no-repeat;
          max-width: 100%;
          text-align: center;
          vertical-align: middle;
          background-size:354px 634px;
          }
          
          .tile2{
          height: 184px;
          width: 634px;
          overflow: hidden;
          background-repeat: no-repeat;
          max-width: 100%;
          text-align: center;
          vertical-align: middle;
          background-size:200px 200px;
          }
          
          table
            {
              width: 872px ;
              margin-left: 17.5%; 
              margin-top: 2%;
            }
        </style> 
    </head>
    <body background="images/background.jpg">
    <table style="text-align:center;">
    <tr>
      <td>
        <div class="tile1" style="background:url('images/tiles/logo.jpg'); background-size:634px 385px" onclick="location.href='home_page.php';"></div>
      </td>
      <td>
        <div class="tile2" style="background:url('images/tiles/addGame.jpg'); background-size:634px 184px"; onclick="location.href='addgame_page.php';"></div> <br>
        <div class="tile2" style="background:url('images/tiles/delete.jpg'); background-size:634px 184px"; onclick="location.href='deletegame_page.php';"></div>
      </td>
    </tr>
    <tr>
    <td>
        <div class="tile2" style="background:url('images/tiles/removeWish.jpg'); background-size:634px 184px"; onclick="location.href='deletewant_page.php';"></div><br>
        <div class="tile2" style="background:url('images/tiles/return_home.jpg'); background-size:634px 184px"; onclick="location.href='home_page.php';"></div> 
      </td>
      <td>
        <div class="tile1" style="background:url('images/tiles/viewWish.jpg'); background-size:634px 385px" onclick="location.href='viewwishlist_page.php';"></div>
      </td>
    </tr>
  </table>
        <?php
			  error_reporting(E_ALL);
  			ini_set('display_errors', 1);

          require_once 'login.php';
          
          session_start();
          $username = check_status();// Checks if user is logged in, if not go to login page

          /*if ($_SERVER['REQUEST_METHOD'] == 'POST') 
          {
            if($_POST['submit'] == "View Game Inventory")
            {
              header("Location: viewinventory_page.php");
            }
            else if($_POST['submit'] == "Add Game to Inventory")
            {
              header("Location: addgame_page.php");
            }
            else if($_POST['submit'] == "Delete Game from Inventory")
            {
              header("Location: deletegame_page.php");
            }
            else if($_POST['submit'] == "Search for Trades")
            {
              header("Location: search_page.php");
            }
            else if($_POST['submit'] == "View Games You Want")
            {
              header("Location: viewwishlist_page.php");
            }
            else if($_POST['submit'] == "Delete Games You Want")
            {
              header("Location: deletewant_page.php");
            }
          }
           <form method="post" action="viewprofile_page.php"> 
        <input type="submit" name="submit" value="View Game Inventory"><br>
        <input type="submit" name="submit" value="View Games You Want"><br>  
        <input type="submit" name="submit" value="Add Game to Inventory"><br>  
        <input type="submit" name="submit" value="Delete Game from Inventory"><br>
        <input type="submit" name="submit" value="Delete Games You Want"><br>
        <input type="submit" name="submit" value="Search for Trades"><br><br>
        
        </form>
           <a href="home_page.php">Return Home</a>
           */    
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
        return;
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