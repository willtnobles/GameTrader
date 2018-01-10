<?php //setupusers.php (with changes)
  error_reporting(E_ALL);
  ini_set('display_errors', 1);
  require_once 'login.php';
  $connection = new mysqli($hn, $un, $pw, $db);
   
  if ($connection->connect_error) die($connection->connect_error);
  
  /*---------------Creating Admin----------------*/
  $query  = "SELECT * FROM tbx_UserTable";
  $result = $connection->query($query); 
  if (!$result) die($connection->error);

  $salt1    = "qm&h*";
  $salt2    = "pg!@";

  $username   = 'whl54';
  $firstname  = 'William';
  $lastname   = 'Lee';
  $email      = 'sleeps_12@yahoo.com';
  $type       = 'admin';
  $password   = 'abcd';
  $token    = hash('ripemd128', "$salt1$password$salt2");

  add_user($connection, $username, $firstname, $lastname, $email, $type, $token);

  echo 'Table tbx_UserTable created and populated';
  $connection->close();
  
  
  
  /*----------------------Add User Function----------------------------*/
  function add_user($connection, $un, $fn, $ln, $em, $ty, $pw)
  {
    $query  = "INSERT INTO tbx_UserTable (username, firstname, lastname, email, type, password) "
            . "VALUES('$un', '$fn', '$ln', '$em', '$ty', '$pw')";
    $result = $connection->query($query);
    if (!$result) die($connection->error);
  }
?>
