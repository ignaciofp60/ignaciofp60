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
    echo "Email was sent.";
    //Not really... we would have to implement the code but you get the idea of this demo.
    //If you would like to know how to send an emails with PHP check out this post I made:
    //https://eecs.blog/php-sending-emails/
    //Also check out this post on sanitizing your input data.
    //https://eecs.blog/php-string-sanitization/
}