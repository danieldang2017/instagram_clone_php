<?php
    include("connectToServer.php");
    $id = $_POST['user'];
    $sqlQuery = $mySQLConnection->prepare("SELECT * FROM Users WHERE ID = $id");
    $sqlQuery->execute();
    
    $response = $sqlQuery->fetchAll();
    
    echo json_encode($response);
    header("Content-type:application/json");
?>