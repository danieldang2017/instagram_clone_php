<?php
    include("connectToServer.php");
    $searchText = $_POST['user'];
    $sqlQuery = $mySQLConnection->prepare("SELECT ID FROM Users WHERE ID = '$searchText' OR userName = '$searchText' OR email = '$searchText'");
    $sqlQuery->execute();
    
    $response = $sqlQuery->fetchAll();
    header("Location: /client/views/postList.html?id=" . $response[0]['ID']);
?>