<?php
  
if($_POST) {
    $visitor_name = "";
    $visitor_email = "";
    $visitor_phone = "";
    $visitor_cover_letter = "";

    $email_title = "Message received through website (careers).";
    $email_body = "<div>";
      
    if(isset($_POST['visitor_name'])) {
        $visitor_name = filter_var($_POST['visitor_name'], FILTER_SANITIZE_STRING);
        $email_body .= "<div>
                           <label><b>Name:</b></label>&nbsp;<span>".$visitor_name."</span>
                        </div>";
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
        $visitor_phone = filter_var($visitor_phone, FILTER_VALIDATE_EMAIL);
        $email_body .= "<div>
                           <label><b>Email:</b></label>&nbsp;<span>".$visitor_phone."</span>
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
      
    if(mail($recipient, $email_title, $email_body, $headers)) {
        echo "<p>Thank you for contacting us, $visitor_name. We will get in touch with you shortly.</p>";
    } else {
        echo '<p>We are sorry but the email did not go through.</p>';
    }

    mail($recipient_cc, $email_title, $email_body, $headers);
      
} else {
    echo '<p>Something went wrong</p>';
}
?>