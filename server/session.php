<?php
   include('config.php');
   session_start();

if($_SERVER["REQUEST_METHOD"] == "POST") {
   $type = mysqli_real_escape_string($db,$_POST['type']);
   $user_check = $_SESSION['login_user'];
   $ses_sql = mysqli_query($db,"select email from Users where email = '$user_check' ");
   $row = mysqli_fetch_array($ses_sql,MYSQLI_ASSOC);
   $login_session = $row['email'];
   if(!isset($_SESSION['login_user'])){
       header( "Content-type: application/json" );
       $jsonAnswer = array('isValid' => false);
       echo json_encode($jsonAnswer);
   }
   else {
       header( "Content-type: application/json" );
       $jsonAnswer = array('isValid' => true);
       echo json_encode($jsonAnswer);
   }
}
?>