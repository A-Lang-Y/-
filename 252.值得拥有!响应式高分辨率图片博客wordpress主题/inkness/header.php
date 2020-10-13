<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package Inkness
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
<div id="parallax-bg"></div>
<div id="page" class="hfeed site">
	<?php do_action( 'inkness_before' ); ?>
	<div id="header-top">
		<header id="masthead" class="site-header row container" role="banner">
			<div class="site-branding col-md-6 col-xs-12">
			<?php if((of_get_option('logo', true) != "") && (of_get_option('logo', true) != 1) ) { ?>
				<h1 class="site-title logo-container"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
				<?php
				echo "<img class='main_logo' src='".of_get_option('logo', true)."' title='".esc_attr(get_bloginfo( 'name','display' ) )."'></a></h1>";	
				}
			else { ?>
				<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1> 
			<?php	
			}
			?>
			</div>	
			
			<div id="social-icons" class="col-md-5 col-xs-12">
			    <?php if ( of_get_option('facebook', true) != "") { ?>
				 <a href="<?php echo esc_url(of_get_option('facebook', true)); ?>" title="Facebook" ><i class="social-icon fa fa-facebook-square"></i></a>
	             <?php } ?>
	            <?php if ( of_get_option('twitter', true) != "") { ?>
				 <a href="<?php echo esc_url("http://twitter.com/".of_get_option('twitter', true)); ?>" title="Twitter" ><i class="social-icon fa fa-twitter-square"></i></a>
	             <?php } ?>
	             <?php if ( of_get_option('google', true) != "") { ?>
				 <a href="<?php echo esc_url(of_get_option('google', true)); ?>" title="Google Plus" ><i class="social-icon fa fa-google-plus-square"></i></a>
	             <?php } ?>
	             <?php if ( of_get_option('feedburner', true) != "") { ?>
				 <a href="<?php echo esc_url(of_get_option('feedburner', true)); ?>" title="RSS Feeds" ><i class="social-icon fa fa-rss-square"></i></a>
	             <?php } ?>
	             <?php if ( of_get_option('pinterest', true) != "") { ?>
				 <a href="<?php echo esc_url(of_get_option('pinterest', true)); ?>" title="Pinterest" ><i class="social-icon fa fa-pinterest-square"></i></a>
	             <?php } ?>
	             <?php if ( of_get_option('instagram', true) != "") { ?>
				 <a href="<?php echo esc_url(of_get_option('instagram', true)); ?>" title="Instagram" ><i class="social-icon fa fa-instagram"></i></a>
	             <?php } ?>
	             <?php if ( of_get_option('linkedin', true) != "") { ?>
				 <a href="<?php echo esc_url(of_get_option('linkedin', true)); ?>" title="LinkedIn" ><i class="social-icon fa fa-linkedin-square"></i></a>
	             <?php } ?>
	             <?php if ( of_get_option('youtube', true) != "") { ?>
				 <a href="<?php echo esc_url(of_get_option('youtube', true)); ?>" title="YouTube" ><i class="social-icon fa fa-youtube-square"></i></a>
	             <?php } ?>
	             <?php if ( of_get_option('flickr', true) != "") { ?>
				 <a href="<?php echo esc_url(of_get_option('flickr', true)); ?>" title="Flickr" ><i class="social-icon fa fa-flickr"></i></a>
	             <?php } ?>
         
	</div>
			
		</header><!-- #masthead -->
	</div>
	
	<div id="header-2">
		<div class="container">
		<div class="default-nav-wrapper col-md-8 col-xs-12"> 	
		   <nav id="site-navigation" class="main-navigation" role="navigation">
	         <div id="nav-container">
				<h1 class="menu-toggle"></h1>
				<div class="screen-reader-text skip-link"><a href="#content" title="<?php esc_attr_e( 'Skip to content', 'inkness' ); ?>"><?php _e( 'Skip to content', 'inkness' ); ?></a></div>
	
				<?php wp_nav_menu( array( 'theme_location' => 'primary' ) ); ?>
	          </div>  
			</nav><!-- #site-navigation -->
		  </div>
		  
		<div id="top-search" class="col-md-4 col-xs-12">
			<?php get_search_form(); ?>
		</div>
		</div>
	</div>
	
	<?php
	if ( (function_exists( 'of_get_option' )) && (of_get_option('slidetitle5',true) !=1) ) {
	if ( ( of_get_option('slider_enabled') != 0 ) && (is_home())  )  
		{ ?>
	<div class="slider-wrapper theme-default"> 
    	<div class="ribbon"></div>    
    		<div id="slider" class="nivoSlider">
    			<?php
		  		$slider_flag = false;
		  		for ($i=1;$i<6;$i++) {
		  			$caption = ((of_get_option('slidetitle'.$i, true)=="")?"":"#caption_".$i);
					if ( of_get_option('slide'.$i, true) != "" ) {
						echo "<a href='".of_get_option('slideurl'.$i, true)."'><img src='".of_get_option('slide'.$i, true)."' title='".$caption."'></a>"; 
						$slider_flag = true;
					}
				}
				?>  
    		</div><!--#slider-->
    		<?php for ($i=1;$i<6;$i++) {
    				$caption = ((of_get_option('slidetitle'.$i, true)=="")?"":"#caption_".$i);
    				if ($caption != "")
    				{
	    				echo "<div id='caption_".$i."' class='nivo-html-caption'><div class='nivocapper'>";
	    				echo "<a href='".of_get_option('slideurl'.$i, true)."'><div class='slide-title'>".of_get_option('slidetitle'.$i, true)."</div></a>";
	    				echo "<div class='slide-description'>".of_get_option('slidedesc'.$i, true)."</div>";
	    				echo "</div></div>";
    				}
    			}	
    	    
			?>
    </div>	
	<?php 
			}
		}
		?>
		<div id="content" class="site-content row clearfix clear">
		<div class="container col-md-12"> 
