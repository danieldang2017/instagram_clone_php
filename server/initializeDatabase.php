<?php 
    include("connectToServer.php");
    
    // Create tables if not already existed
    $sqlQuery = file_get_contents('../sql/createUsers.sql');
    $mySQLConnection->exec($sqlQuery);
    $sqlQuery = file_get_contents('../sql/createPosts.sql');
    $mySQLConnection->exec($sqlQuery);
    $sqlQuery = file_get_contents('../sql/createLikes.sql');
    $mySQLConnection->exec($sqlQuery);
    $sqlQuery = file_get_contents('../sql/createFollows.sql');
    $mySQLConnection->exec($sqlQuery);
    $sqlQuery = file_get_contents('../sql/createPasswordRecoveries.sql');
    $mySQLConnection->exec($sqlQuery);
    
    // Populate data for the tables. Should only run once at the beginning.
    
    $sqlQuery = file_get_contents('../sql/populateUsers.sql');
    $mySQLConnection->exec($sqlQuery);
    $sqlQuery = file_get_contents('../sql/populatePosts.sql');
    $mySQLConnection->exec($sqlQuery);
    
?>