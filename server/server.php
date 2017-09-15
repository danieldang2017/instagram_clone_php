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
        echo "Connected successfully"; 
    }
    catch(PDOException $e)
    {
        // Notify connection errors
        echo "Connection failed: " . $e->getMessage();
    }
    
    // Create tables if not already existed
    $sql = file_get_contents('../sql/createUsers.sql');
    $mySQLConnection->exec($sql);
    $sql = file_get_contents('../sql/createPosts.sql');
    $mySQLConnection->exec($sql);
    $sql = file_get_contents('../sql/createLikes.sql');
    $mySQLConnection->exec($sql);
    $sql = file_get_contents('../sql/createFollows.sql');
    $mySQLConnection->exec($sql);
?>