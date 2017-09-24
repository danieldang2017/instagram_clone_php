<?php
    function Redirect($url, $permanent = false)
    {
        header('Location: ' . $url, true, $permanent ? 301 : 302);
        exit();
    }
    $_SERVER['DOCUMENT_ROOT'];
    Redirect('/client/views/index.html', false);
    
    /* Re-create database. Drop database c9 before using it. Should only use once at the beginning.
    Redirect('/server/initializeDatabase.php', false);
    */
    
?>