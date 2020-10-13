<?php

/**
 * Define the from email
 */ 
 
// email
define('TO_EMAIL', 'myemail@mydomain.com');
define('FROM_EMAIL', 'info@test.com');
define('FROM_NAME', 'Test'); 

/**
 * define the body of the email. You can add some shortcode, with this format: %ID%
 * 
 * ID = the id have you insert on the html markup.
 * 
 * e.g.
 * <input type="text" name="email" />
 *       
 * You can add on BODY, this:
 * email: %email%   
 */ 
define( 'BODY', '%message%<br /><br /><small>email send by %name%, email %email%, tel.: %phone%.</small>' );
define( 'SUBJECT', 'Email from yoursite.com' );

// here the redirect, when the form is submitted
define( 'ERROR_URL', 'contact-error.html' );
define( 'SUCCESS_URL', 'contact-success.html' );
define( 'NOTSENT_URL', 'contact-error.html' );

// the message feedback of ajax request
$msg = array(
    'error' => '<p class="error">Warning! Fill correctly the fields marked in red</p>',
    'success' => '<p class="success">Email sent correctly. Thanks to get in touch us!</p>',
    'not-sent' => '<p class="error">An error has been encountered. Please try again.</p>'
);      
    
// the field required, by name
$required = array( 'name', 'email', 'message' );

/**
 * Send the email.
 * 
 * SERVER-SIDE: the functions redirect to some URL, in base of result of control and send.
 * The urls must be set in the constants above: ERROR_URL, SUCCESS_URL, NOTSENT_URL
 * 
 * CLIENT-SIDE: in js/contact.js, there is already script for real-time checking of fields
 * and for ajax request of send email, that request in this page (sendmail.php) and echo the feedback message.    
 */   
sendemail();
                     
// NO NEED EDIT
function sendemail() 
{                                
    global $msg, $required;
    
    if ( isset( $_POST['ajax'] ) )
        $ajax = $_POST['ajax'];
    else
        $ajax = false;
    
	if ( isset( $_POST['yit_action'] ) AND $_POST['yit_action'] == 'sendmail' ) 
	{
	                                
	    $body = BODY;
	    
	    $post_data = array_map( 'stripslashes', $_POST["yit_contact"] );
 	    //print_r($post_data);
        //die;
	    
	    foreach ( $required as $id_field ) {

            if( $post_data[$id_field] == '' || is_null( $post_data[$id_field] ) ) {
    	        if ( $ajax )
    	           end_ajax( $msg['error'] );
    	        else
    	    	   redirect( ERROR_URL );
    	    }                       
    	}
	    
	    if( !is_email( $post_data['email'] ) OR $post_data['email'] == '' )
	        if ( $ajax )
	           end_ajax( $msg['error'] );
	        else
    	       redirect( ERROR_URL );
	      
	    foreach( $post_data as $id => $var )
	    {
	    	if( $id == 'message' ) $var = nl2br($var);
			$body = str_replace( "%$id%", $var, $body );	
		}
			    
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
		$headers .= 'From: '.FROM_NAME.' <'.FROM_EMAIL.'>' . "\r\n" . 'Reply-To: ' . $post_data['email'];

	    $sendmail = mail( TO_EMAIL, SUBJECT, $body, $headers );


		if ( $sendmail ) 
	        if ( $ajax )
	           end_ajax( $msg['success'] );
	        else
    	       redirect( SUCCESS_URL );
	    else
	        if ( $ajax )
	           end_ajax( $msg['not-sent'] );
	        else
    	       redirect( NOTSENT_URL );
	} 
}

function is_email($email) 
{
    if (!preg_match("/[a-z0-9][_.a-z0-9-]+@([a-z0-9][0-9a-z-]+.)+([a-z]{2,4})/" , $email))
    {
        return false;
    }
    else
    {
        return true;
    }
}             

function end_ajax( $msg = '' ) {
    echo $msg;
    die;
}           

function redirect( $redirect = '' ) {
    header( 'Location: ' . $redirect );
    die;
}