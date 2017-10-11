<?php

function sendMail($to, $sub, $msg) {

require_once "vendor/autoload.php";

//PHPMailer Object
$mail = new PHPMailer;

//From email address and name
$mail->From = "noreply@badgem.com";
$mail->FromName = "Badgem Webmail";

//To address and name
$mail->addAddress($to);

//Address to which recipient will reply
$mail->addReplyTo("reply@yourdomain.com", "Reply");


//Send HTML or Plain Text email
$mail->isHTML(true);

$mail->Subject = $sub;
$mail->Body = $msg;

if(!$mail->send()) 
{
    echo "Mailer Error: " . $mail->ErrorInfo;
} 
else 
{
    echo "Message has been sent successfully";
}

}