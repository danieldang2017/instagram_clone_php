<?php
   include("config.php");
   include("hash.php");
   session_start();
   
   if($_SERVER["REQUEST_METHOD"] == "POST") {
     
      $type = mysqli_real_escape_string($db,$_POST['type']); 
      if ($type == 'signin'){
    // username and password sent from client
      $myemail = mysqli_real_escape_string($db,$_POST['email']);
      $mypassword = mysqli_real_escape_string($db,$_POST['password']); 

     // select data by email 
      $sql = "SELECT * FROM Users WHERE email = '$myemail' ";
      $result = mysqli_query($db,$sql);
      if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $secrectPass = $row["password"];
        
        //
            $pa = $mypassword;
            $sa = hashString($pa);
            $Check = hashCheckPassword($pa, $sa);
            $a = 0;
        //
        
        
        $passwordCheck = hashCheckPassword($mypassword, $secrectPass);
        if ($passwordCheck){
             $_SESSION['login_user'] =  $myemail;
            header( "Content-type: application/json" );
            $jsonAnswer = array('isValid' => true);
            echo json_encode($jsonAnswer);
        }
        else{
            header( "Content-type: application/json" );
            $jsonAnswer = array('isValid' => false);
            echo json_encode($jsonAnswer);
        }
      }
      else{
           header( "Content-type: application/json" );
            $jsonAnswer = array('isValid' => false);
            echo json_encode($jsonAnswer);
         }
      }
      
      if ($type == 'register'){
          // get data sent from client
          $displayName = mysqli_real_escape_string($db,$_POST['displayName']);
          $firstName = mysqli_real_escape_string($db,$_POST['firstName']); 
          $lastName = mysqli_real_escape_string($db,$_POST['lastName']); 
          $username = mysqli_real_escape_string($db,$_POST['username']); 
          $email = mysqli_real_escape_string($db,$_POST['email']); 
          $password = mysqli_real_escape_string($db,$_POST['password']); 
          $secrectPass = hashString($password);
          
          // Check username is unique
          $sql = "SELECT * FROM Users WHERE userName = '$username' ";
          $result = mysqli_query($db,$sql);
          if ($result->num_rows > 0) {
              header( "Content-type: application/json" );
              $jsonAnswer = array('isValid' => 'false', 'message' => 'Username is already used.');
              echo json_encode($jsonAnswer);
          }
          else {
               // Check email is unique
              $sql = "SELECT * FROM Users WHERE email = '$email' ";
              $result = mysqli_query($db,$sql);
             if ($result->num_rows > 0) {
                header( "Content-type: application/json" );
                $jsonAnswer = array('isValid' => false, 'message' => 'Email is already used');
                echo json_encode($jsonAnswer);
                }
                else {
                    // Insert new user into database
                   $sql = "INSERT INTO Users ( displayName, userName, email, password, imageProfile, firstName, lastName , createdDate) values ('$displayName', '$username', '$email', '$secrectPass', 'profile', '$firstName', '$lastName', now())";
                   $result = mysqli_query($db,$sql);
                   if($result)
                   {
                       header( "Content-type: application/json" );
                       $jsonAnswer = array('isValid' => true, 'message' => 'Successful');
                       echo json_encode($jsonAnswer);
                   }
                   else
                   {
                        header( "Content-type: application/json" );
                       $jsonAnswer = array('isValid' => false, 'message' => 'Netword Error');
                       echo json_encode($jsonAnswer);
                   }
                }
          }
         }
   }
  

?>