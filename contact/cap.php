<?php
//Entry point///////////////////////////////////////////////////////
$recaptcha = $_POST["token"];
if(checkCaptcha($recaptcha))
    sendEmail($_POST["email"]);
else
    die("Recaptcha failed!");
///////////////////////////////////////////////////////////////////
//Functions////////////////////////////////////////////////////////
function checkCaptcha($recaptcha){
    $url = 'https://www.google.com/recaptcha/api/siteverify';
    $data = array(
        'secret' => '6LdUoPQkAAAAAPufXeLs7CukmtBVS5pImeLR9rNt',
        'response' => $recaptcha
    );
    $options = array(
        'http' => array (
            'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
            'method' => 'POST',
            'content' => http_build_query($data)
        )
    );
    $context  = stream_context_create($options);
    $verify = file_get_contents($url, false, $context);
    $captcha_success = json_decode($verify);
 
    return $captcha_success->success;
}
function sendEmail($email){
    if(isset($_POST['submit'])) {
    $mailto = "f.zpnacho@gmail.com";  //My email address
    //getting customer data
    $fromEmail = $_POST['email']; //getting customer email
    $subject = $_POST['subject']; //getting subject line from client
    $subject2 = "Confirmation: Message was submitted successfully | Ignacio Fernández"; // For customer confirmation
    
    //Email body I will receive
    $message = "Client Message: " . "\n" . $_POST['message'];
    
    //Message for client confirmation
    $message2 = "Thank you for contacting us. We will get back to you shortly!" . "\n\n"
    . "You submitted the following message: " . "\n" . $_POST['message'] . "\n\n"
    . "Regards," . "\n" . "- Ignacio Fernández";
    
    //Email headers
    $headers = "From: " . $fromEmail; // Client email, I will receive
    $headers2 = "From: " . $mailto; // This will receive client
    
    //PHP mailer function
    
     $result1 = mail($mailto, $subject, $message, $headers); // This email sent to My address
     $result2 = mail($fromEmail, $subject2, $message2, $headers2); //This confirmation email to client
    
     //Checking if Mails sent successfully
    
     if ($result1 && $result2) {
       $success = "Your Message was sent Successfully!";
     } else {
       $failed = "Sorry! Message was not sent, Try again Later.";
     }

     echo "Email was sent.";
    
   }
} 








?>