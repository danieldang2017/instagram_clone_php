<?php
    session_start();
    if($_SERVER["REQUEST_METHOD"] == "POST") {
        if(session_destroy()) {
            header( "Content-type: application/json" );
            $jsonAnswer = array('result' => true);
            echo json_encode($jsonAnswer);
        }
    }
?>