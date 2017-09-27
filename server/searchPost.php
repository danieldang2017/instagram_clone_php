<?php
    include("connectToServer.php");
    $id = $_POST['id'];
    $sqlQuery = $mySQLConnection->prepare("SELECT * FROM Posts WHERE ID = $id");
    $sqlQuery->execute();
    
    $response = $sqlQuery->fetchAll();
    
    echo json_encode($response);
    header("Content-type:application/json");
?>