<?php
    include("connectToServer.php");
    $id = $_POST['id'];
    $max = $_POST['max'];
    $sqlQuery = $mySQLConnection->prepare("SELECT * FROM Posts WHERE user=$id ORDER BY createdDate DESC LIMIT 4");
    $sqlQuery->execute();
    
    $response = $sqlQuery->fetchAll();
    
    echo json_encode($response);
    header("Content-type:application/json");
?>