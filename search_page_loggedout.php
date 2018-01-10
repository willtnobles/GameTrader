<!DOCTYPE html>
<html lang="en">
    <head>
     <link rel="stylesheet" href="stylesheet.css">
        <meta charset="UTF-8">
        <title>Search</title>
        <style>
          body{
          text-align: center;
          font-size:30px;
			    margin-left: 0%;
			    white-space: nowrap; 
          }
        </style>
    </head>
    <body background="images/background.jpg">
        <h1>Search</h1>

		<form method="get" action="search_page_loggedout.php">          
          Search Type: <select name="type" tabindex="1">
                      <option selected="selected" value="game">Game</option>
                      <option value="user">User</option>
                      <option value="match">Match</option>
                      </select><br><br>
          <input type="text" name="search" /><br><br>
          Add to Want List? <input type="checkbox" name="want" value="add"><br><br>
          <b>Match Search Options:</b><br>
          Show Users that Have Games you Want <input type="radio" name="mtype" value="want"><br>
          Show Users that Want Game you Have <input type="radio" name="mtype" value="have"><br>
          Complete Match <input type="radio" name="mtype" value="match"><br><br>
          <input type="submit" name="searchinput" value="Search" /> 
      	
          
    </form>
    <a href="home_page.php">Return Home</a>
    <br><br>-------------------------------------------------------- <br><br>
             
	
		
        <?php
		    $search = $_GET['search'];
        $type = $_GET['type'];
        $add = $_GET['want'];
        
        
		  
          require_once 'login.php';
     
          $connection = new mysqli($hn, $un, $pw, $db); 
          if ($connection->connect_error) 
            die($connection->connect_error);
          
          session_start();
          $username = check_status();
           
          /*----------------------------------
          --------- Basic Game Search --------
          ----------------------------------*/
          
          if($type == 'game'){ 
            $query = "SELECT * FROM tbx_InventoryTable WHERE title = '$search'";            
          
           $result = $connection->query($query);
            if (!$result)
                die($connection->error);
            
            
       
              
            $rows = $result->num_rows;
            for ($j = 0 ; $j < $rows ; ++$j)
            {
              $result->data_seek($j);
              $row = $result->fetch_array(MYSQLI_ASSOC);
              
                
                ${"user" . $j} = $row['username'];
                $var = $row['username'];
                $id = $row['gameid'];

				if ($var != $username) {
                
                	echo 'User: '  . $row['username'] . '<br>';
			          	echo 'Title: '   . $row['title']   . '<br>';
 			          	echo 'Console: ' . $row['console'] . '<br>';
                
                	?>
                <?php  }
                
            }
            
            if($add == 'add'){           
              add_game($connection, $username, $id); 
            }
               
            $result->close();
            $connection->close();
          }
          
          
          
          /*-----------------------------------------
          ------------- Basic User Search------------
          -----------------------------------------*/
          
          else if($type == 'user'){ //search for user
            $query = "SELECT username FROM tbx_UserTable WHERE username = '$search'";
            
            $result = $connection->query($query);
            if (!$result)
                die($connection->error);
                
            $rows = $result->num_rows;
            for ($j = 0 ; $j < 1 ; ++$j)
            {
            
              $result->data_seek($j);
              $row = $result->fetch_array(MYSQLI_ASSOC);
        
                $var = $row['username'];

				if ($var != $username) {
                
                	echo 'User: '  . $row['username'] . '<br>';
			          
                	?>
                <?php  }
            }
                  
            $result->close();
            $connection->close();            
          }
          
          /*----------------------------------------
          -------- Match Functions -----------------
          ----------------------------------------*/
          else{  
          
           //---------------------------Get User Games---------------------------//
           
           $query = "SELECT * FROM tbx_InventoryTable WHERE username = '$username'";            
           
           $result = $connection->query($query);
            if (!$result)
                die($connection->error);
                
            $rows = $result->num_rows;
            
            $allgames = array(); 
            $usernames = array();
            $userowned = array();
            $userwants = array();
            $allwants = array();
            $usernames2 = array();
             
            for ($j = 0 ; $j < $rows ; ++$j)
            {            
              $result->data_seek($j);
              $row = $result->fetch_array(MYSQLI_ASSOC);
                           
              $userowned[$j] = $row['title'];  
            }
            //------------ Get All Games--------------// 
            $query2 = "SELECT title, username FROM tbx_InventoryTable";           
           
            $result2 = $connection->query($query2);
            if (!$result2)
                die($connection->error);
                
            $rows = $result2->num_rows;                        
             
            for ($j = 0 ; $j < $rows ; ++$j)
            {            
              $result2->data_seek($j);
              $row = $result2->fetch_array(MYSQLI_ASSOC);
              
              $allgames[$j] = $row['title'];  
              $usernames[$j] = $row['username'];
              
              $var = $row['username'];              
            }
            
          $connection = new mysqli($hn, $un, $pw, $db); 
          if ($connection->connect_error) 
            die($connection->connect_error);
            
            //--------------- Get User Want List -------------------------------//
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
                          
              $result2->data_seek($j);
              $row2 = $result2->fetch_array(MYSQLI_ASSOC);
  
              $userwants[$j] = $row2['title'];    
                 
            }
            
            $connection = new mysqli($hn, $un, $pw, $db); 
          if ($connection->connect_error) 
            die($connection->connect_error);
            
            //--------------------------Get All Wanted Games----------------------//
            $query  = "SELECT * from tbx_WishlistTable";
            $result = $connection->query($query);
            if (!$result) 
                die($connection->error); 
            $rows = $result->num_rows;
            
            for ($j = 0 ; $j < $rows ; ++$j)
            {
              $result->data_seek($j);
              $row = $result->fetch_array(MYSQLI_ASSOC);

              $c = $row['gameid'];   
              $usernames2[$j] = $row['username'];
              
              $query2  = "SELECT * FROM tbx_InventoryTable WHERE gameid = '$c'";
              $result2 = $connection->query($query2);
              if (!$result2) 
                  die($connection->error); 
              $rows2 = $result2->num_rows;
              
              $result2->data_seek($j);
              $row2 = $result2->fetch_array(MYSQLI_ASSOC);
  
              $allwants[$j] = $row2['title'];
              
               
                  
            }

            /*-----------------------------------------
            -------------- Matching Logic--------------
            -----------------------------------------*/
            
            $count1 = count($userowned);
            $count2 = count($allgames);
            $count3 = count($userwants);
            $count4 = count($allwants);
            
            if($_GET['mtype'] == 'want'){  //Shows Users that have what you want
              for($x = 0 ; $x < $count3 ; ++$x) 
              {
                  for($y = 0 ; $y < $count2 ; ++$y)
                  {
                      
                      if($userwants[$x] == $allgames[$y])
                      {
                         if($usernames[$y] != $username){
                            echo 'User: ' . $usernames[$y] . '<br>';
                            echo 'Title: ' . $allgames[$y] . '<br>';
                         
                            $var = $usernames[$x];
                          
                            ?>
                            <br><br>
                            <?php  			                 
                        }
                      }
                  }
            
                }
              } 
                
            if($_GET['mtype'] == 'have'){ //Shows users that want what you have
              for($j = 0 ; $j < $count1 ; ++$j) 
              {
                  for($i = 0 ; $i < $count4 ; ++$i)
                  {
                      if($userowned[$j] == $allwants[$i])
                      {
                         if($usernames2[$i] != $username){
                            echo 'User: ' . $usernames2[$i] . '<br>';
                            echo 'Title: ' . $allwants[$i] . '<br>';
                          
                             $var = $usernames[$i];  
                          
                             ?>
                             <br><br>
                             <?php  			                 
                          }
                      }
                  }
            
              }
             } 
            
            if($_GET['mtype'] == 'match'){  //Complete Match
              for($x = 0 ; $x < $count3 ; ++$x) 
              {
                  for($y = 0 ; $y < $count2 ; ++$y)
                  {
                      for($j = 0; $j < $count1 ; ++$j)
                      {
                          for($i = 0; $i < $count4 ; ++$i)
                          {
                                   if($userwants[$x] == $allgames[$y] && $userowned[$j] == $allwants[$i]){
                                        
                                        if($usernames[$y] == $usernames2[$i] && $usernames[$y] != $username){
                                        
                                          echo 'User: ' . $usernames[$y] . '<br>';
                                          echo 'Wants: ' . $userowned[$j] . '<br>';
                                          echo 'Has: ' . $userwants[$x] . '<br>';
                                          
                                          $var = $usernames[$y]; 
                                          ?>
                                          <br><br>
                                          <?php  			                                        
                                        }                                 
                                    }
                            }
                        }
                    }            
                } 
            }
            $result->close();
            $connection->close();
          
          }
          
            
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
  
  
?>