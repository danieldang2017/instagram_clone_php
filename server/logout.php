<?php
    session_start();
    if(session_destroy()) {
       header("location:/client/client/view/loginAndRegistration.html");
   }
?>