<?php
    // Initialize server schemas
    $servername = getenv('IP');
    $username = getenv('C9_USER');
    $password = "";
    
    try {
        // Create connection to mySQL server
        $mySQLConnection = new PDO("mysql:dbname=c9;host=$servername", $username, $password);
        
        // set the PDO error mode to exception
        $mySQLConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    catch(PDOException $e)
    {
    }
?>