<?php
   include("config.php");
   include("hash.php");
   session_start();
   use PHPMailer\PHPMailer\PHPMailer;
   use PHPMailer\PHPMailer\Exception;
   
   if($_SERVER["REQUEST_METHOD"] == "POST") {
        $type = mysqli_real_escape_string($db,$_POST['type']); 
        $PostID = mysqli_real_escape_string($db,$_POST['id']); 
        $FollowID = mysqli_real_escape_string($db,$_POST['followid']); 
   
        // Find User from session
        $user_check = $_SESSION['login_user']; // Update when haveing login
        // get user ID
        $sql = "SELECT * FROM Users WHERE email = '$user_check'";
        $result = mysqli_query($db,$sql);
        $row = $result->fetch_assoc();
        $UserID = $row["ID"];
      
        if ($type == 'increLike'){
            // Check Like exists
            $sql = "SELECT * FROM Likes WHERE user = '$UserID' AND post = '$PostID'";
            $result = mysqli_query($db,$sql);
            $row = $result->fetch_assoc();
            
            // Increase like 
            if ($result->num_rows == 0) {
                
                // Update Like which is creased by 1
                $sql = "SELECT * FROM Posts WHERE ID = '$PostID'";
                $result = mysqli_query($db,$sql);
                $row = $result->fetch_assoc();
                $NewLike = $row["likeCount"] + 1;
                $sqlUpdateLike = "UPDATE Posts SET likeCount = $NewLike WHERE ID = '$PostID'";
                $result = mysqli_query($db,$sqlUpdateLike);
            
                // Insert the new like into Likes table
                $sqlInsert = "INSERT INTO Likes (user, post, likeDate) VALUES ('$UserID', '$PostID', NOW())";
                $result = mysqli_query($db,$sqlInsert);
                     
	            if($result) {
                    header( "Content-type: application/json" );
                    $jsonAnswer = array('result' => true, 'count' => $NewLike, 'id' => $PostID);
                    echo json_encode($jsonAnswer);
	            }
            } 
            // Decrease like when it is already liked
            else {
                $LikeID = $row['ID'];
                // Update Like which is decreased by 1
                $sql = "SELECT * FROM Posts WHERE ID = '$PostID'";
                $result = mysqli_query($db,$sql);
                $row = $result->fetch_assoc();
                $NewLike = $row["likeCount"] - 1;
                $sqlUpdateLike = "UPDATE Posts SET likeCount = $NewLike WHERE ID = '$PostID'";
                $result = mysqli_query($db,$sqlUpdateLike);
            
                // Insert the new like into Likes table
                $sqlDelete = "DELETE FROM Likes WHERE ID = '$LikeID'";
                $result = mysqli_query($db,$sqlDelete);
                
                if($result) {
                    header( "Content-type: application/json" );
                    $jsonAnswer = array('result' => false, 'count' => $NewLike, 'id' => $PostID);
                    echo json_encode($jsonAnswer);
	            }
            }
        } else if ($type == 'isLike') {
            //Check Like
            $sql = "SELECT * FROM Likes WHERE user = '$UserID' AND post = '$PostID'";
            $result = mysqli_query($db,$sql);
            if($result->num_rows > 0) {
                header( "Content-type: application/json" );
                $jsonAnswer = array('result' => true);
                echo json_encode($jsonAnswer);
            } else {
                header( "Content-type: application/json" );
                $jsonAnswer = array('result' => false);
                echo json_encode($jsonAnswer);
            }
        } else if ($type == 'incrFollow') {
            // Check Follow exists
            $sql = "SELECT * FROM Follows WHERE followingUser = '$UserID' AND followedUser = '$FollowID'";
            $result = mysqli_query($db,$sql);
            $row = $result->fetch_assoc();
            
            // Increase Follower and Following 
            if ($result->num_rows == 0) {
               
                $sql = "UPDATE Users SET followingCount = followingCount + 1 WHERE ID = '$UserID';";
                $result = mysqli_query($db,$sql);
                
                $sql = "UPDATE Users SET followersCount = followersCount + 1 WHERE ID = '$FollowID';";
                $result = mysqli_query($db,$sql);
                
                $sql = "SELECT * FROM Users WHERE ID = '$UserID'";
                $result = mysqli_query($db,$sql);
                $row = $result->fetch_assoc();
                $CurrentFollowingCount = $row["followingCount"];
              
                // insert the new Follow record
                $sql = "INSERT INTO Follows ( followingUser, followedUser, followDate) VALUES ('$UserID', '$FollowID', now());";
                $result = mysqli_query($db,$sql);
              
                if($result) {
                    header( "Content-type: application/json" );
                    $jsonAnswer = array('result' => true, 'id' => $FollowID, 'followingCount' => $CurrentFollowingCount);
                    echo json_encode($jsonAnswer);
                }
            }
            // Decrease Follower and Following 
            else {
                $sql = "UPDATE Users SET followingCount = followingCount - 1 WHERE ID = '$UserID';";
                $result = mysqli_query($db,$sql);
                
                $sql = "UPDATE Users SET followersCount = followersCount - 1 WHERE ID = '$FollowID';";
                $result = mysqli_query($db,$sql);
                
                $sql = "SELECT * FROM Users WHERE ID = '$UserID'";
                $result = mysqli_query($db,$sql);
                $row = $result->fetch_assoc();
                $CurrentFollowingCount = $row["followingCount"];
                
                // Delete Follow record
                $sql = "DELETE FROM Follows WHERE followingUser = '$UserID' AND followedUser = '$FollowID'";
                $result = mysqli_query($db,$sql);
              
                if($result) {
                    header( "Content-type: application/json" );
                    $jsonAnswer = array('result' => false, 'id' => $FollowID, 'followingCount' => $CurrentFollowingCount);
                    echo json_encode($jsonAnswer);
                }
           }
      } else if ($type == 'isFollow') {
            $sql = "SELECT * FROM Follows WHERE followingUser = '$UserID' AND followedUser = '$FollowID'";
            $result = mysqli_query($db,$sql);
            if ($result->num_rows == 0) {
                header( "Content-type: application/json" );
                $jsonAnswer = array('result' => false);
                echo json_encode($jsonAnswer);
            } else {
                header( "Content-type: application/json" );
                $jsonAnswer = array('result' => true);
                echo json_encode($jsonAnswer);
            }
        } else if ($type == 'sendEmail') {

            //Load composer's autoloader
            require __DIR__.'/vendor/autoload.php';
            $resetEmail = mysqli_real_escape_string($db,$_POST['email']); 
            $resetPass = mysqli_real_escape_string($db,$_POST['password']); 
   
            // Check email exist
            $sql = "SELECT * FROM Users WHERE email = '$resetEmail'";
            $result = mysqli_query($db,$sql);
            $row = $result->fetch_assoc();
            $firstNameReset = $row["firstName"];
            $lastNameReset = $row["lastName"];
            $userIDReset = $row["ID"];
            if ($result->num_rows > 0) {
        
                $mail = new PHPMailer(true); // Passing `true` enables exceptions
                //Hash and save password
                $secrectPass = hashString($resetPass);
       
                // Save new password to temp reset table
                $sql = "INSERT INTO PasswordRecoveries( user ,password, expirationDate) VALUES ($userIDReset, '$secrectPass' , DATE_ADD(now(), INTERVAL 1 DAY));";
                $result = mysqli_query($db,$sql);
                // GetID back
                $sql = "SELECT * FROM PasswordRecoveries WHERE user = '$userIDReset' AND password = '$secrectPass'";
                $result = mysqli_query($db,$sql);
                $row = $result->fetch_assoc();
                $ResetID = $row["ID"];
                // Update verify ID
                $verifyID = $ResetID . $secrectPass;
                $verifyID =  str_replace(".","",$verifyID); 
                $sql = "UPDATE PasswordRecoveries SET verifyID = '$verifyID' WHERE ID = $ResetID";
                $result = mysqli_query($db,$sql);

                try {
                    //Server settings
                    $mail->SMTPDebug = 2; // Enable verbose debug output
                    $mail->isSMTP();  // Set mailer to use SMTP
                    $mail->Host = 'smtp.gmail.com'; // Specify main and backup SMTP servers
                    $mail->SMTPAutoTLS = false;
                    $mail->SMTPAuth = true; // Enable SMTP authentication
                    $mail->Username = 'recievewebdesign@gmail.com'; // SMTP username
                    $mail->Password = 'recievewebdesign123@'; // SMTP password
                    $mail->SMTPSecure = 'ssl'; // Enable TLS encryption, `ssl` also accepted
                    $mail->Port = 465; // TCP port to connect to
                    
                    //Recipients
                    $mail->setFrom('recievewebdesign@gmail.com', 'Instagram');
                    $mail->addAddress($resetEmail); // Add a recipient
                    
                    //Content
                    $mail->Subject = 'Password recovery';
                    
                    $url =$_SERVER['HTTP_HOST'];
                    $emailBody = "Dear " . $firstNameReset . " ". $lastNameReset .","  . "\n \n";
                    $emailBody = $emailBody . "We have received a request to reset the password for this email. \n";
                    $emailBody = $emailBody . "Please click on the link below to confirm your new password. \n \n";
                    $emailBody = $emailBody . "https://" . $url . '/server/verifypassword.php?id=' . $verifyID;
                    $emailBody = $emailBody . "\n \n";
                    $emailBody = $emailBody . "Thank You! \n";
                    $emailBody = $emailBody . "Instagram Customer Service";
                    $mail->Body  = $emailBody;
                    if ($mail->send()) {
                        header( "Content-type: application/json" );
                        $jsonAnswer = array('isValid' => true, 'message' =>  'Your Account has been reset! </br> Please check your email to confirm');
                        echo json_encode($jsonAnswer);
                    }
                } catch (Exception $e) {
                    header( "Content-type: application/json" );
                    $jsonAnswer = array('isValid' => false, 'message' =>  'Message could not be sent. Please contact administrator');
                    echo json_encode($jsonAnswer);
                }
            } else {
                header( "Content-type: application/json" );
                $jsonAnswer = array('isValid' => false, 'message' =>  'Email is not correct');
                echo json_encode($jsonAnswer);
            }
        }
    }
?>