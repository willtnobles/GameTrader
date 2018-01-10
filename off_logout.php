<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Home</title>
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
        <div class="tile1" style="background:url('images/tiles/logo.jpg'); background-size:634px 385px" ></div>
      </td>
      <td>
        <div class="tile2" style="background:url('images/tiles/search.jpg'); background-size:634px 184px"; onclick="location.href='search_page_loggedout.php';"></div><br>
        <div class="tile2" style="background:url('images/tiles/about.jpg'); background-size:634px 184px";" onclick="location.href='aboutus_page.php';"></div>
      </td>
    </tr>
    <tr>
    <td>
        <div class="tile2" style="background:url('images/tiles/createAccount.jpg'); background-size:634px 184px"; onclick="location.href='createaccount_page.php';"></div><br>
        <div class="tile2" style="background:url('images/tiles/login.jpg'); background-size:634px 184px"; onclick="location.href='login_page.php';"></div>
      </td>
      <td>
        <div class="tile1" style="background:url('images/tiles/howWorks.jpg'); background-size:634px 385px"; onclick="location.href='howitworks_page.php';"></div>
      </td>
    </tr>
  </table>
        <?php
          //require_once 'login.php';

          session_start();
          check_status();

          /*echo "<a href='login_page.php'>Login</a><br>"; 
          echo "<a href='viewprofile_page'>View Profile</a><br>";
          echo "<a href='search_page'>Search</a>";
          if ($_SERVER['REQUEST_METHOD'] == 'POST') 
          {
            if($_POST['submit'] == "Search")
            {
              header("Location: viewinventory_page.php");
            }
            else if($_POST['submit'] == "View Profile")
            {
              header("Location: viewinventory_page.php");
            }
            else if($_POST['submit'] == "View All Games")
            {
              header("Location: viewinventory_page.php");
            }
            
                <form method="post" action="viewprofile_page.php"> 
        <input type="submit" name="submit" value="Search"><br>  
        <input type="submit" name="submit" value="View Profile"><br>  
        <input type="submit" name="submit" value="View All Games"><br>
        </form>
          }*/   
        ?>
    </body>
</html>                                                                    

<?php
  function check_status()
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