<?php
// Get the settings for the email
require_once '../settings.php';

// Get the variables
$name 	 = trim( $_GET['name'] );
$email 	= trim( $_GET['email'] );
$subject 	= trim( $_GET['subject'] );
$comment  = trim( $_GET['comment'] );

// Set the INI file to smtp
ini_set("SMTP", $GLOBALS['smtp']);

// this will be the 'from' address
$headers = '';

// this is the subject of the message
$subject = "{$subject} - {$name}";
$headers .= "Content-type: text/html\r\n";

$message  = "<b>Email</b>: {$email}<br /><br />";
$message .= "<b>Message</b>: {$comment}<br />";

$send = @mail($global_email, $subject, $message, $headers);

if ($send)
	echo 1;
else
	echo 0;
	
?>