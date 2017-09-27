<?php
    session_start();
    if(session_destroy()) {
      $url = "https://" . $_SERVER['HTTP_HOST'] . "/client/views/loginAndRegistration.html";
      header("Location: $url");
   }
?>