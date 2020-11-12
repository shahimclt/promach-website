<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';
  
if($_POST) {
    $visitor_name = "";
    $visitor_email = "";
    $visitor_phone = "";
    $visitor_cover_letter = "";

    $email_title = "Message received through website (careers)";
    $email_body = "<div>";
      
    if(isset($_POST['visitor_name'])) {
        $visitor_name = filter_var($_POST['visitor_name'], FILTER_SANITIZE_STRING);
        $email_body .= "<div>
                           <label><b>Name:</b></label>&nbsp;<span>".$visitor_name."</span>
                        </div>";
        $email_title = $email_title." : ".$visitor_name;
    }
 
    if(isset($_POST['visitor_email'])) {
        $visitor_email = str_replace(array("\r", "\n", "%0a", "%0d"), '', $_POST['visitor_email']);
        $visitor_email = filter_var($visitor_email, FILTER_VALIDATE_EMAIL);
        $email_body .= "<div>
                           <label><b>Email:</b></label>&nbsp;<span>".$visitor_email."</span>
                        </div>";
    }

    if(isset($_POST['visitor_phone'])) {
        $visitor_phone = str_replace(array("\r", "\n", "%0a", "%0d"), '', $_POST['visitor_phone']);
        $visitor_phone = filter_var($visitor_phone, FILTER_SANITIZE_STRING);
        $email_body .= "<div>
                           <label><b>Phone:</b></label>&nbsp;<span>".$visitor_phone."</span>
                        </div>";
    }
      
    if(isset($_POST['visitor_cover_letter'])) {
        $visitor_cover_letter = htmlspecialchars($_POST['visitor_cover_letter']);
        $email_body .= "<div>
                           <label><b>Message:</b></label>
                           <div>".$visitor_cover_letter."</div>
                        </div>";
    }
 
    // $recipient = "promachindia@gmail.com";
    $recipient = "info@promach.in";
    $recipient_cc = "sujin@promach.in";
      
    $email_body .= "</div>";
 
    $headers  = 'MIME-Version: 1.0' . "\r\n"
    .'Content-type: text/html; charset=utf-8' . "\r\n"
    .'From: ' . $visitor_email . "\r\n";
      
    // if(mail($recipient, $email_title, $email_body, $headers)) {
    //     echo "<p>Thank you for contacting us, $visitor_name. We will get in touch with you shortly.</p>";
    // } else {
    //     echo '<p>We are sorry but the email did not go through.</p>';
    // }

    // mail($recipient_cc, $email_title, $email_body, $headers);

    $mail = new PHPMailer(true);

    $mail->setFrom('website@promach.in', 'Website Mailer');
    //Set an alternative reply-to address
    $mail->addReplyTo('website@promach.in', 'Website Mailer');
    //Set who the message is to be sent to
    // $mail->addAddress($recipient);
    // $mail->addAddress($recipient_cc);
    $mail->addAddress('shahim.calicut@gmail.com');
    //Set the subject line
    $mail->Subject = $email_title;
    //Read an HTML message body from an external file, convert referenced images to embedded,
    //convert HTML into a basic plain-text alternative body
    $mail->msgHTML($email_body);

    echo 'attach: ' . $_FILES['visitor_resume']['name'];

    if (array_key_exists('visitor_resume', $_FILES)) {
        // First handle the upload
        // Don't trust provided filename - same goes for MIME types
        // See http://php.net/manual/en/features.file-upload.php#114004 for more thorough upload validation
        // Extract an extension from the provided filename
        $ext = PHPMailer::mb_pathinfo($_FILES['visitor_resume']['name'], PATHINFO_EXTENSION);
        // Define a safe location to move the uploaded file to, preserving the extension
        $uploadfile = tempnam(sys_get_temp_dir(), hash('sha256', $_FILES['visitor_resume']['name'])) . '.' . $ext;
    
        if (move_uploaded_file($_FILES['visitor_resume']['tmp_name'], $uploadfile)) {
            // Upload handled successfully
            if (!$mail->addAttachment($uploadfile, 'Resume_'.$visitor_name.'_'.$visitor_email)) {
                echo 'Failed to attach file ' . $_FILES['visitor_resume']['name'];
            }
        } else {
            echo 'Failed to move file to ' . $uploadfile;
        }
    }
    else {
        echo 'no attachment';
    }
    //Replace the plain text body with one created manually
    // $mail->AltBody = 'This is a plain-text message body';
    //Attach an image file
    // $mail->addAttachment('images/phpmailer_mini.png');

    //send the message, check for errors
    if (!$mail->send()) {
        echo 'Mailer Error: ' . $mail->ErrorInfo;
    } else {
        echo 'Message sent!';
    }
      
} else {
    echo '<p>Something went wrong</p>';
}
?>