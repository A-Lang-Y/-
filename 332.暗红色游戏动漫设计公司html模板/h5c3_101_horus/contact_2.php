<?php
//Set your email address below (the email address that all correspondence should be set there)
//-------------------------------
$your_email = "imon.theme@gmail.com";
//-------------------------------

if (isset($_POST['contact_form'])) {
	$email      	= $_POST['email'];
	$subject    	= $_POST['name'];
} else {
	$email      	= "";
	$subject    	= "";
}

$response   	= '';
$form_submitted = isset($_POST['contact_form']);
$form_success   = TRUE;

if(!eregi("^[a-z0-9]+([_\\.-][a-z0-9]+)*" ."@"."([a-z0-9]+([\.-][a-z0-9]+)*)+"."\\.[a-z]{2,}"."$",$email ))
{
	$response="You entered an invalid e-mail address";
	$form_success   = FALSE;
}
else
{
	$values = array ('name','email','phone','message');
	$required = array('name','email','message');
		
	$email_subject = "Contact the site: ".$subject;
	$email_content = "You received the following message from the contact form in your site:\n";
	
	foreach($values as $value)
	{		
		if( empty($_POST[$value]) && in_array($value, $required)) 
		{ 
			$response = 'please, fill in the required fields'; 					
			$form_success = FALSE;
			break;
		}		
		
		$email_content .= $value.': '.$_POST[$value]."\n";					
	}				
}

if($form_success)
	$response = ((@mail($your_email,$email_subject,$email_content)) ? 'Message sent successfully. thanks!' : 'WARNING! There was an error. Please try again.');			
		
$responseMarkup = '<div class="responseMessage">'.$response.'</div>';
?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	
    <title>Imon Theme </title>
   
<link rel="shortcut icon" href="images/logohead.png" type="images/logohead.png"/>
	<!-- css file-->

<link rel="stylesheet" type="text/css" href="css/reset.css"/>
<link rel="stylesheet" type="text/css" href="css/foundation.css"/>
<link rel="stylesheet" type="text/css" href="style_2.css"/>
<link rel="stylesheet" type="text/css" href="css/ddsmoothmenu.css"/>
<link rel="stylesheet" type="text/css" href="css/responsiveslides.css"/>
<link rel="stylesheet" type="text/css" href="css/prettyphoto.css"/>
<link rel="stylesheet" type="text/css" href="css/queries.css" media="all" />

	<!-- js file-->
	<script type="text/javascript" src="js/jquery-1.js"></script> 
<script type="text/javascript" src="js/ddsmoothmenu.js"></script> 
<script type="text/javascript" src="js/main.js"></script> 
<script type="text/javascript" src="js/jquery_003.js"></script> 
<script type="text/javascript" src="js/foundation.js"></script>
<script type="text/javascript" src="js/jquery_005.js"></script>  
<script type="text/javascript" src="js/app.js"></script> 
<script type="text/javascript" src="js/modernizr.js"></script> 
<script type="text/javascript" src="js/jquery_002.js"></script>
<script type="text/javascript" src="js/html5.js"></script>
<script type="text/javascript" src="js/jquery.fitvids.js"></script>
<script type="text/javascript" src="js/selectnav.js"></script>
<script type="text/javascript" src="js/scripts.js"></script> 
<script type="text/javascript" src="js/jquery.jtweetsanywhere-1.3.1.min.js"></script>
<script type="text/javascript" src="js/responsiveslides.js"></script> 
<script>
	$(function () {
		$("#slider").responsiveSlides({
		manualControls: '#slider-pager',
		maxwidth: 976
		});
	});
	</script> 
<script type="text/javascript" src="js/jquery.js"></script> 
<script type="text/javascript" src="js/jflickrfeed.js"></script> 
<script type="text/javascript" src="js/jquery_004.js"></script> 
<script type="text/javascript">
	$(function(){
		$("a[class^='prettyPhoto']").prettyPhoto({theme:'pp_default'});
	});
	</script>
	</head>


	<body>


<!-- Header wrap -->
<header id="branding" role="banner">
  <h1 id="site-title"> 
  	<a href="index.html" title="Serendipity" rel="home">
    		<img src="images/logo.png" alt="Horus" />
    </a> 
  </h1>
  <div class="social">
    <div class="widget_search">
      <form method="get" class="search-form">
        <input type="submit" value="Search" class="search-submit-button" />
        <input type="text" value="Search" onfocus="this.value=''" onblur="this.value='Search'" name="s" class="search-text-box" />
      </form> 
    </div>
    <ul>
      <li><a href="#" target="_blank"><img src="images/icon-rss.png" alt="RSS" /></a></li>
      <li><a href="#" target="_blank"><img src="images/icon-facebook.png" alt="Facebook" /></a></li>
      <li><a href="#" target="_blank"><img src="images/icon-twitter.png" alt="Twitter" /></a></li>
      <li><a href="#" target="_blank"><img src="images/icon-dribbble.png" alt="Dribbble" /></a></li>
      <li><a href="#" target="_blank"><img src="images/icon-linkedin.png" alt="LinkedIn" /></a></li>
      <li><a href="#" target="_blank"><img src="images/icon-pinterest.png" alt="Pinterest" /></a></li>
    </ul>
  </div>
  <nav id="access" class="access" role="navigation">
        <div id="menu" class="menu">
        	<ul id="tiny">
				<li><a href="index.html">Home</a>
					<ul>
			            <li><a href="index2.html">Home2</a></li>
			            
			        </ul>
				</li>
				<li><a href="gallery.html">Gallery</a>
                <ul>
			            <li><a href="gallery_2.html">Home2</a></li>
			            
			        </ul>
                </li>
				<li><a href="#">Styles</a>
					<ul>
			            <li><a href="#">Misc</a></li>
			            <li><a href="columns.html">Columns</a>
                        <ul>
			            <li><a href="columns_2.html">Columns2</a></li>
			            
			        </ul>
                        </li>
			            <li><a href="#">Typography</a></li>
			        </ul>
				</li>
				<li><a href="about.html">About</a></li>
				<li><a href="contact.php">Contact</a>
                <ul>
			            <li><a href="contact_2.php">Contact</a></li>
			            
			        </ul>
                </li>
			</ul>
		</div>
		
  </nav>
  <!-- #access --> 
</header>

<div class="slider_shadow"></div>
<div class="row"
 <p><h3>CONTACT FORM</h3></p>
				<p>Use this contact form to get in touch with us.</p>
                <p id="sent-form-msg" class="success">Thanks for your comments.</p>
				<!-- form -->
      
				<?php echo (($form_submitted) ? $responseMarkup : ''); ?>
					
				<form id="contactForm" action="" method="post">					
					<div class="formContent">
                    <a>Your name (required)*</a>
						<label for="name">Your name<span class="name">(required)*</span></label>					
						<input type="text" name="name" id="name" class="input required" value="" />	
                         <a>Your Email (required)*</a>		
						<label for="email">Your email.<span class="email">(required)*</span></label>
						<input type="text" name="email" id="email" class="input required" value="" />
												
						 <a>Comment</a>				
				
						<textarea class="textarea" name="message" rows="10" cols="10"></textarea>
						<input type="hidden" name="contact_form" value="1" />
						<input type="submit" class="submit" value="send message" />									
					</div>
				</form>				

    </div>
</div>
<div class="space90"></div>

 <!-- start footer -->
    <div id="footer" class="boxed">
    <div class="row">
    	<div class="footer-wrap">
        	
            <!-- Pages -->
        	<div class="outerOneFourth">
                <div class="title"><h4>Pages</h4></div>
                <div class="clear20"></div>
                <ul>
                    <li><p><a href="#">Lorem ipsum dolor sit amet</a></p></li>
                    <li><p><a href="#">Fusce accumsan mollis eros</a></p></li>
                    <li><p><a href="#">Nullam quis massa</a></p></li>
                    <li><p><a href="#">Ut scelerisque hendrerit</a></p></li>
                    <li><p><a href="#">Vivamus imperdiet nibh feugiat</a></p></li>
                    <li><p><a href="#">Integer eu magna sit amet</a></p></li>
                    <li><p><a href="#">Cum sociis natoque penatibus</a></p></li>
                </ul>
            </div><!-- end pages -->
            
            <!-- twitter -->
        	<div class="outerOneFourth">
                <div class="title"><h4>Twitter</h4></div>
                <div class="clear2"></div>
                
                <div id="twitter">
                </div>
                
                <script type="text/javascript">
                $('#twitter').jTweetsAnywhere({
                    username: 'envato',
                    count: 3,
                    showFollowButton: false
                });
                </script>
               
            </div><!-- end twitter -->
            
           	<!-- about us -->
        	<div class="outerOneFourth">
                <div class="title"><h4>About Us</h4></div>
                <div class="clear2"></div>
                <div id="about-us">
                    <p><img src="images/building.png" alt="" class="fl">Sed fringilla dui id ante volutpat ut pellentesque lacus semper. 
                    Duis laoreet congue consectetur. Aliquam volutpat scelerisque dui ac fringilla. 
                    Praesent et volutpat urna. Sed ipsum dolor.</p><br>
                    <p>Praesent et volutpat urna. Sed ipsum dolor, dapibus a ultrices a, 
                    pellentesque eget metus.</p><br>
                    <ul class="socialNav">
                        <li><a href="#" title="Facebook"><img src="images/facebook_icon.png" alt="Delicious"></a></li>
                        <li><a href="#" title="Twitter"><img src="images/twitter_icon.png" alt="Twitter"></a></li>
                        <li><a href="#" title="Dribble"><img src="images/dribble_icon.png" alt="Drible"></a></li>
                        <li><a href="#" title="StumbleUpon"><img src="images/su_icon.png" alt="StumbleUpon"></a></li>
                        <li><a href="#" title="RSS"><img src="images/rss_icon.png" alt="Rss"></a></li>
					</ul>
                </div>
            </div><!-- end about us -->
            
            <!-- contact -->
        	<div class="outerOneFourth last">
                <div class="title"><h4>Contact</h4></div>
                <div class="clear2"></div>
                <div id="contactWrap">
                    <form class="contactForm">
                        <label>Name: </label>
                        <input class="nameInput" title="Name" type="text">
                        <label>Email: </label>
                        <input class="emailInput" title="Email Address" type="text">
                        <label>Message: </label>
                        <textarea class="messageInput" title="Message"></textarea>
                        <input class="buttonPro submitBtn" value="Send Message" type="submit">
                    </form>
                </div>
                <div class="clear2"></div>
            <!-- end contact -->
            </div>
        
           </div>
        
		</div>
        
        <!-- start post footer -->
        <div class="post-footer">
        <div class="row">
            <div class="post-footer-wrap">
            <div class="fl">
            <p >More Templates <a href="http://www.cssmoban.com/" target="_blank" title="模板之家">模板之家</a> . All the themes, icons are released under GNU GPL v2.</p></div>
            <div class="fr">
            <p>
                <a href="#">Home </a>
                <a href="#">About Us </a> 
                <a href="#">Sitemap </a> 
                <a href="#">FAQ's </a> 
                <a href="#">Contact Us</a></p>
                </div>
            </div>
        </div><!-- end post footer -->
    </div><!-- end footer -->
    </div>
</div>

</body>
</html>
