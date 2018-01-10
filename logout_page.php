<!DOCTYPE html>
<html>
    <head>
     <link rel="stylesheet" href="stylesheet.css">
        <title>Logged Out</title>
    </head>
    <?php
        session_start();
        session_unset();
        session_destroy();
        
    ?> 
    <body background="images/background.jpg">
        <h1>Logged Out</h1>
        <p>
            You are now logged out of the website.
        </p>
        <p>
            <a href="login_page.php">Log in</a> again. <br><br>
            <a href="home_page.php">Return Home</a>
        </p>
    </body>
</html>