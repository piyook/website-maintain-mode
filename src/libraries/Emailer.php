<?php

namespace Libraries;


/**
 * Emailer Class
 * 1. Validates entered email address
 * 2. Send PHP Mail to website admin - defined in .env.php
 */
class Emailer {
        
    /**
     * contact_email
     * method to :
     * 1. check email is not being sent repeatedly
     * 2. check email post variable was passed
     * 3. check this is an email address
     * 4. sanitise email
     * 5. return a success or fail message
     * @return string Returns Error Message
     */
    public function contact_email(){
        
      if (isset($_POST['email']) ) {
             
        $error_message='Your Email Address';

        $email=filter_var($_POST['email'],FILTER_SANITIZE_EMAIL);
        
        if (filter_var($email, FILTER_VALIDATE_EMAIL)):
          
            $mailMessage="Someone has requested to be contacted from your site: "
                          .SITE_NAME.
                          "<br><br>Email: ".$email."<br>";
        
            $to = SITE_EMAIL;
            $subject = "Message from ".SITE_EMAIL;
            $message="<html><body>";  
            $message .= "Hi <br><br><br>";
            $message .= $mailMessage; 
            $message .="<br><br><hr><br><br></body></html>";
            $headers = "From:".SITE_EMAIL."\r\n";
            $headers .= "Reply-To:".SITE_EMAIL."\r\n";
            $headers .= "MIME-Version: 1.0 \r\n";
            $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";   
                  
                  
            (mail($to,$subject,$message,$headers))
            ? 
            $error_message="email sent OK"
            :
            $error_message="failed to send email";
                  
        else: 
        
          $error_message='Error: Enter A Correct Email Address';
        
        endif;
          
        return $error_message;
        
      
      }
      
    }
}


?>