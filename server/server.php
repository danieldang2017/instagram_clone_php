<?php
   include("config.php");
   session_start();
   
   if($_SERVER["REQUEST_METHOD"] == "POST") {
     
      $type = mysqli_real_escape_string($db,$_POST['type']); 
      $PostID = mysqli_real_escape_string($db,$_POST['id']); 
      if ($type == 'increLike'){
           
         
            // Find User from session
           //    $user_check = $_SESSION['login_user']; // Update when haveing login
           $user_check = "hieutrantvvn2006@gmail.com";
         
            // get user ID
            $sql = "select * from Users where email= '$user_check'";
            $result = mysqli_query($db,$sql);
            $row = $result->fetch_assoc();
            $UserID = $row["ID"];
            
            // Check Like exists
            $sql = "select * from Likes where user = '$UserID' and post = '$PostID'";
            $result = mysqli_query($db,$sql);
            $row = $result->fetch_assoc();
            
            // Increase like 
            if ($result->num_rows == 0) {
                
                // Update Like which is creased by 1
                 $sql = "select * from Posts where ID = '$PostID'";
                 $result = mysqli_query($db,$sql);
                 $row = $result->fetch_assoc();
                 $NewLike = $row["likeCount"] + 1;
                 $sqlUpdateLike = "Update Posts set likeCount = $NewLike where ID = '$PostID'";
                 $result = mysqli_query($db,$sqlUpdateLike);
            
                // Insert the new like into Likes table
                $sqlInsert = "insert into Likes (user, post, likeDate) values ('$UserID', '$PostID', now())";
                $result = mysqli_query($db,$sqlInsert);
                     
	            if($result)
	            {
	                   header( "Content-type: application/json" );
                       $jsonAnswer = array('result' => true, 'count' => $NewLike, 'id' => $PostID);
                       echo json_encode($jsonAnswer);
	            }
	
                 
            } 
            // Decrease like when it is already liked
            else {
                 $LikeID = $row['ID'];
                 // Update Like which is decreased by 1
                  // Update Like which is creased by 1
                 $sql = "select * from Posts where ID = '$PostID'";
                 $result = mysqli_query($db,$sql);
                 $row = $result->fetch_assoc();
                 $NewLike = $row["likeCount"] - 1;
                 $sqlUpdateLike = "Update Posts set likeCount = $NewLike where ID = '$PostID'";
                 $result = mysqli_query($db,$sqlUpdateLike);
            
                // Insert the new like into Likes table
                $sqlDelete = "delete from Likes where ID = '$LikeID'";
                $result = mysqli_query($db,$sqlDelete);
                
                if($result)
	            {
	                   header( "Content-type: application/json" );
                       $jsonAnswer = array('result' => false, 'count' => $NewLike, 'id' => $PostID);
                       echo json_encode($jsonAnswer);
	            }
                
            }
          
      }
      
      else if ($type == 'isLike'){
            
            // Find User from session
           //    $user_check = $_SESSION['login_user']; // Update when haveing login
           $user_check = "hieutrantvvn2006@gmail.com";
         
            // get user ID
            $sql = "select * from Users where email= '$user_check'";
            $result = mysqli_query($db,$sql);
            $row = $result->fetch_assoc();
            $UserID = $row["ID"];
            
            //Check Like
            $sql = "select * from Likes where user = '$UserID' and post = '$PostID'";
             $result = mysqli_query($db,$sql);
            if($result->num_rows > 0){
                header( "Content-type: application/json" );
                $jsonAnswer = array('result' => true);
                echo json_encode($jsonAnswer);
            }
            else {
                header( "Content-type: application/json" );
                $jsonAnswer = array('result' => false);
                echo json_encode($jsonAnswer);
            }
      }
   }
  

?>