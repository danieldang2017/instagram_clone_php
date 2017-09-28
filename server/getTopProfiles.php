<?php
    include("connectToServer.php");
    
    $sqlQuery = $mySQLConnection->prepare("SELECT * FROM Users ORDER BY followersCount DESC LIMIT 3");
    $sqlQuery->execute();
    $response = $sqlQuery->fetchAll();
    
    echo json_encode($response);
    header("Content-type:application/json");
?>