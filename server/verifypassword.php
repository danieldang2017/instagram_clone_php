<?php
    include("config.php");
    include("hash.php");
      
    if($_SERVER["REQUEST_METHOD"] == "GET") {
        $id = mysqli_real_escape_string($db,$_GET['id']);
        
        $sql = "SELECT * FROM PasswordRecoveries WHERE verifyID = '$id'";
        $result = mysqli_query($db,$sql);
        $row = $result->fetch_assoc();
      
        if ($result->num_rows > 0) {
            $expiredTime = $row["expirationDate"];
            $current = new DateTime();
            if($expiredTime <= $current) {
                //Update Users table
                $newPassword = $row["password"];
                $userID = $row["user"];
                
                $sql = "UPDATE Users SET password = '' WHERE ID = $userID";
                $result = mysqli_query($db,$sql);
                
                $sql = "UPDATE Users SET password = '$newPassword' WHERE ID = $userID";
                $result = mysqli_query($db,$sql);
                
                //Redirect to login page
                if($result) {
                  $url = "https://" . $_SERVER['HTTP_HOST'] . "/client/views/loginAndRegistration.html";
                  header("Location: $url");
                }
            } else {
               $url = "https://" . $_SERVER['HTTP_HOST'] . "/client/views/error.html?e=passwordExpired";
               header("Location: $url");
            }
   
            $a = 0;
        } else {
            $url = "https://" . $_SERVER['HTTP_HOST'] . "/client/views/error.html?e=invalidVerification";
            header("Location: $url");
        }
    }
 ?>