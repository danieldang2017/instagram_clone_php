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
        //echo "Connected successfully"; 
    }
    catch(PDOException $e)
    {
        // Notify connection errors
        echo "Connection failed: " . $e->getMessage();
    }
    $sqlQuery = $mySQLConnection->prepare("SELECT * FROM Users ORDER BY followersCount DESC LIMIT 3");
    $sqlQuery->execute();
    
    $response = $sqlQuery->fetchAll();
    
    echo json_encode($response);
    header("Content-type:application/json");
?>