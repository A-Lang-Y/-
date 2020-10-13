<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package Sixteen
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php wp_title( '|', true, 'right' ); ?></title>
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	<?php if ( get_header_image() ) : ?>
		<div id="header-image"></div>
	<?php endif; // End header image check. ?>
<div id="page" class="hfeed site">
	<?php do_action( 'before' ); ?>
    
    <div id="top-section">	
		<header id="masthead" class="site-header" role="banner">
		
			<div class="site-branding">
				<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
				<h2 class="site-description"><?php bloginfo( 'description' ); ?></h2>
			</div>
			
			<div id="social-icons">
			<div class="container">
			    <?php if ( of_get_option('facebook', true) != "") { ?>
				 <a target="_blank" href="<?php echo esc_url(of_get_option('facebook', true)); ?>" title="Facebook" ><img src="<?php echo get_template_directory_uri()."/images/facebook.png"; ?>"></a>
	             <?php } ?>
	            <?php if ( of_get_option('twitter', true) != "") { ?>
				 <a target="_blank" href="<?php echo esc_url("http://twitter.com/".of_get_option('twitter', true)); ?>" title="Twitter" ><img src="<?php echo get_template_directory_uri()."/images/twitter.png"; ?>"></a>
	             <?php } ?>
	             <?php if ( of_get_option('google', true) != "") { ?>
				 <a target="_blank" href="<?php echo esc_url(of_get_option('google', true)); ?>" title="Google Plus" ><img src="<?php echo get_template_directory_uri()."/images/google.png"; ?>"></a>
	             <?php } ?>
	             <?php if ( of_get_option('feedburner', true) != "") { ?>
				 <a target="_blank" href="<?php echo esc_url(of_get_option('feedburner', true)); ?>" title="RSS Feeds" ><img src="<?php echo get_template_directory_uri()."/images/rss.png"; ?>"></a>
	             <?php } ?>
	             <?php if ( of_get_option('instagram', true) != "") { ?>
				 <a target="_blank" href="<?php echo esc_url(of_get_option('instagram', true)); ?>" title="Instagram" ><img src="<?php echo get_template_directory_uri()."/images/instagram.png"; ?>"></a>
	             <?php } ?>
	             <?php if ( of_get_option('flickr', true) != "") { ?>
				 <a target="_blank" href="<?php echo esc_url(of_get_option('flickr', true)); ?>" title="Flickr" ><img src="<?php echo get_template_directory_uri()."/images/flickr.png"; ?>"></a>
	             <?php } ?>
			</div>
            </div>
		</header><!-- #masthead -->
		
		<div id="nav-wrapper">
				<nav id="site-navigation" class="main-navigation" role="navigation">
					
						<h1 class="menu-toggle"><?php _e( 'Menu', 'sixteen' ); ?></h1>
						<div class="screen-reader-text skip-link"><a href="#content"><?php _e( 'Skip to content', 'sixteen' ); ?></a></div>
			
						<?php wp_nav_menu( array( 'theme_location' => 'primary' ) ); ?>
					
				</nav><!-- #site-navigation -->
		</div>	
		
		<?php
		if ( (function_exists( 'of_get_option' )) && (of_get_option('slidetitle5',true) !=1) ) {
		if ( ( of_get_option('slider_enabled') != 0 ) && ( (is_home() == true) || (is_front_page() == true) ) )  
			{ ?>
		<div class="slider-parent">	
		<div class="slider-wrapper theme-default container"> 
	    	<div class="ribbon"></div>    
	    		<div id="slider" class="nivoSlider">
	    			<?php
			  		$slider_flag = false;
			  		for ($i=1;$i<6;$i++) {
			  			$caption = ((of_get_option('slidetitle'.$i, true)=="")?"":"#caption_".$i);
						if ( of_get_option('slide'.$i, true) != "" ) {
							echo "<div class='slide'><a href='".of_get_option('slideurl'.$i, true)."'><img src='".of_get_option('slide'.$i, true)."' title='".$caption."'></a></div>"; 
							$slider_flag = true;
						}
					}
					?>  
	    		</div><!--#slider-->
	    		<?php for ($i=1;$i<6;$i++) {
	    				$caption = ((of_get_option('slidetitle'.$i, true)=="")?"":"#caption_".$i);
	    				if ($caption != "")
	    				{
		    				echo "<div id='caption_".$i."' class='nivo-html-caption'>";
		    				echo "<a href='".of_get_option('slideurl'.$i, true)."'><div class='slide-title'>".of_get_option('slidetitle'.$i, true)."</div></a>";
		    				echo "<div class='slide-description'>".of_get_option('slidedesc'.$i, true)."</div>";
		    				echo "</div>";
	    				}
	    			}	
	    	    
				?>
	    </div><!--.container-->	
		</div><!--.slider-parent-->
		<?php 
				}
			}
			?>	
		</div><!--#top-section-->
	
		<div id="content" class="site-content container">	