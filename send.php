


<?php

 use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once "vendor/autoload.php";

//PHPMailer Object
 $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
 
   //Server settings
            $mail->SMTPDebug = 2;                                 // Enable verbose debug output
            $mail->isSMTP();                                      // Set mailer to use SMTP
            $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
            $mail->SMTPAutoTLS = false;
            $mail->SMTPAuth = true;                               // Enable SMTP authentication
            $mail->Username = 'recievewebdesign@gmail.com';                 // SMTP username
            $mail->Password = 'recievewebdesign123@';                           // SMTP password
            $mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
            $mail->Port = 465;                                    // TCP port to connect to
        
            //Recipients
            $mail->setFrom('recievewebdesign@gmail.com', 'Instagram');
            $mail->addAddress($resetEmail);     // Add a recipient
        
            //Content
           // $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = 'Subject';
           
            $mail->Body  = "Body";
            


?>