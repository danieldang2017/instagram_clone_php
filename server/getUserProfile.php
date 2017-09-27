<?php
    include("connectToServer.php");
    
    //for testing purpose only
    $_SESSION['login_user'] = 'hieutrantvvn2006@gmail.com';
    
    $sqlQuery = $mySQLConnection->prepare("SELECT * FROM Users WHERE email = '" . $_SESSION['login_user'] . "'");
    $sqlQuery->execute();
    
    $response = $sqlQuery->fetchAll();
    
    echo json_encode($response);
    header("Content-type:application/json");
?>