<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once dirname(__FILE__).'/../vendor/autoload.php';

/** GMAIL SETUP
*$mail->Port       = 587;
*$mail->Host       = "smtp.gmail.com";
*$mail->Username   = "your-email@gmail.com";
*$mail->Password   = "your-gmail-password";
*
* Make sure that Less secure app access is enabled on your GMAIL account.
*/
// Create the Transport
$transport = (new Swift_SmtpTransport('smtp.mailgun.org', 587))
  ->setUsername('postmaster@mail.shfy.io')
  ->setPassword('bc058dab0b8808de3ba58294ab240b5e-1553bd45-8094f50a')
;

// Create the Mailer using your created Transport
$mailer = new Swift_Mailer($transport);

// Create a message
$message = (new Swift_Message('Wonderful Subject'))
  ->setFrom(['dino@shfy.io' => 'Hamdija'])
  ->setTo(['dino.keco@gmail.com'])
  ->setBody('Here is the message itself')
  ;

// Send the message
$result = $mailer->send($message);

print_r($result);
?>
