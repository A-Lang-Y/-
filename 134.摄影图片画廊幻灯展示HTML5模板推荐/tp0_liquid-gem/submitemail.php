<?

/************************
* Variables you can change
*************************/

$mailto = "your email goes here";	/*PUT YOUR EMAIL IN HERE*/
$cc = "";
$bcc = "";
$subject = "enquiry";
$vname = "Website Contact Form";


/************************
* do not modify anything below unless you know PHP/HTML/XHTML
*************************/


$email = $_POST['email'];

function validateEmail($email)
{
   if(eregi('^[a-zA-Z0-9._-]+@[a-zA-Z0-9-]+\.[a-zA-Z]{2,4}(\.[a-zA-Z]{2,3})?(\.[a-zA-Z]{2,3})?$', $email))
	  return true;
   else
	  return false;
}


if(strlen($_POST['name']) < 1  || strlen($_POST['message']) < 1 || validateEmail($email) == FALSE)
{

	if(empty($_POST['name']))
	{
		$emailerror .= '<li>Enter name</li>';
	}

	if(validateEmail($email) == FALSE)
	{
		$emailerror .= '<li>Enter valid email</li>';
	}

	if(empty($_POST['message']))
	{
		$emailerror .= '<li>Enter message</li>';
	}
}
else
{
	$emailerror .= "Your email has been sent successfully";

	// NOW SEND THE ENQUIRY
	$timestamp = date("F j, Y, g:ia");

	$messageproper ="\n\n" .
		"Name: " .
		ucwords($_POST['name']) .
		"\n" .
		"Email: " .
		ucwords($email) .
		"\n" .
		"Comments: " .
		$_POST['message'] .
		"\n" .
		"\n\n" ;

		$messageproper = trim(stripslashes($messageproper));
		mail($mailto, $subject, $messageproper, "From: \"$vname\" <".$_POST['e_mail'].">\nReply-To: \"".ucwords($_POST['first_name'])."\" <".$_POST['e_mail'].">\nX-Mailer: PHP/" . phpversion() );
}
?>

<div id='emailerror'>
	<ul>
		<? echo $emailerror; ?>
	</ul>
</div>