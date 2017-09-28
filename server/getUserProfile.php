<?php
    include("connectToServer.php");
    
    session_start();
    $sqlQuery = $mySQLConnection->prepare("SELECT * FROM Users WHERE email = '" . $_SESSION['login_user'] . "'");
    $sqlQuery->execute();
    $response = $sqlQuery->fetchAll();
    
    echo json_encode($response);
    header("Content-type:application/json");
?>