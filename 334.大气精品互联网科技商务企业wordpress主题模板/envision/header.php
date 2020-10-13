<?php
/**
 * The header for the theme
 * 
 * @author Orkun GURSEL (support@cloudfw.net)
 * @package WordPress
 * @subpackage CloudFw
 */

/** Get Logo Images */
$logo_image               = cloudfw_get_option('logo', 'image');
$logo_image_retina        = cloudfw_get_option('logo', 'image@2x');
$logo_image_tablet        = cloudfw_get_option('logo-tablet', 'image');
$logo_image_tablet_retina = cloudfw_get_option('logo-tablet', 'image@2x');
$logo_image_phone         = cloudfw_get_option('logo-phone', 'image');
$logo_image_phone_retina  = cloudfw_get_option('logo-phone', 'image@2x');

$sticky_mode_enabled       = cloudfw_check_onoff( 'header', 'sticky' );
$logo_image_sticky         = $sticky_mode_enabled ? cloudfw_get_option('logo-sticky', 'image') : '';
$logo_image_sticky_retina  = $sticky_mode_enabled ? cloudfw_get_option('logo-sticky', 'image@2x') : '';

/**
 * Check the visual set for custom logo image
 */
    /** Desktop */
    if ( $custom_logo = cloudfw_get_visual_option("custom-logo") ) {
        $logo_image = $custom_logo;
    }

    if ( $custom_logo_retina = cloudfw_get_visual_option("custom-logo-retina") ) {
        $logo_image_retina = $custom_logo_retina;
    }

    /** Tablet */
    if ( $custom_logo_tablet = cloudfw_get_visual_option("custom-logo-tablet") ) {
        $logo_image_tablet = $custom_logo_tablet;
    }

    if ( $custom_logo_tablet_retina = cloudfw_get_visual_option("custom-logo-tablet-retina") ) {
        $logo_image_tablet_retina = $custom_logo_tablet_retina;
    }

    /** Phone */
    if ( $custom_logo_phone = cloudfw_get_visual_option("custom-logo-phone") ) {
        $logo_image_phone = $custom_logo_phone;
    }

    if ( $custom_logo_phone_retina = cloudfw_get_visual_option("custom-logo-phone-retina") ) {
        $logo_image_phone_retina = $custom_logo_phone_retina;
    }

/**
 * Logo image callbacks for tablets and phones
 */
    
    /** Tablet */
    if ( ! $logo_image_tablet ) {
        $logo_image_tablet = $logo_image;
    }

    /** Phone */
    if ( ! $logo_image_phone ) {
        $logo_image_phone = $logo_image;
    }

/**
 * Logo image retina callbacks
 */
    
    /** Desktop */
    if ( ! $logo_image_retina ) {
        $logo_image_retina = $logo_image;
    }

    /** Tablet */
    if ( ! $logo_image_tablet_retina ) {
        $logo_image_tablet_retina = $logo_image_retina;
    }

    /** Phone */
    if ( ! $logo_image_phone_retina ) {
        $logo_image_phone_retina = $logo_image_tablet_retina;
    }

    /** Sticky */
    if ( ! $logo_image_sticky_retina ) {
        $logo_image_sticky_retina = $logo_image_sticky;
    }

/**
 * Logo offsets
 */
$logo_margin_top = cloudfw_get_option( 'logo', 'margin-top', NULL, 0 );  
$logo_margin_top_tablet = cloudfw_get_option( 'logo-tablet', 'margin-top', $logo_margin_top, -1 );  
$logo_margin_top_phone = cloudfw_get_option( 'logo-phone', 'margin-top', $logo_margin_top, -1 );  

$logo_margin_bottom = cloudfw_get_option( 'logo', 'margin-bottom', NULL, 0 );  
$logo_margin_bottom_tablet = cloudfw_get_option( 'logo-tablet', 'margin-bottom', $logo_margin_bottom, -1 );  
$logo_margin_bottom_phone = cloudfw_get_option( 'logo-phone', 'margin-bottom', $logo_margin_bottom, -1 ); 

$hide_on_stuck_class = ''; 
if ( ! empty( $logo_image_sticky ) ) {
    $hide_on_stuck_class = 'hide-on-stuck'; 
}

$logo_link = cloudfw_get_option( 'logo', 'link', get_bloginfo("url") );

?><!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js html-loading wf-active ie old-browser lt-ie10 lt-ie9 lt-ie8 lt-ie7" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 7]>         <html class="no-js html-loading wf-active ie old-browser ie7 lt-ie10 lt-ie9 lt-ie8" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 8]>         <html class="no-js html-loading wf-active ie old-browser ie8 lt-ie10 lt-ie9" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 9]>         <html class="no-js html-loading wf-active ie modern-browser ie9 lt-ie10" <?php language_attributes(); ?>> <![endif]-->
<!--[if gt IE 9]><!--> <html class="no-js html-loading wf-active modern-browser" <?php language_attributes(); ?>> <!--<![endif]-->

<head>
<meta http-equiv="content-type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
<?php cloudfw_device_viewport(); ?>

<title><?php cloudfw('title'); ?></title>

<!-- W3TC-include-js-head -->
<?php do_action( 'cloudfw_head' ); ?>
<?php wp_head();?>
</head>

<body <?php body_class(); ?> itemscope itemtype="http://schema.org/WebPage">

<div id="side-panel-pusher">

<div id="main-container">

    <div id="page-wrap">

        <?php $disable_header = cloudfw( 'get', 'disable_header' ); ?>
        <?php if ( ! isset( $disable_header ) || $disable_header !== true ): ?>

        <header id="page-header" class="clearfix">

            <?php $topbar_sticky = cloudfw_check_onoff( 'topbar', 'sticky' ); ?>
            <?php if ( ! $topbar_sticky ) include( TMP_MODULES . '/module.topbar/topbar.php' ); ?>

            <?php $header_type = cloudfw_get_option('header', 'type'); ?>

            <div id="header-container" class="header-type-<?php echo $header_type; ?> no-stuck clearfix" <?php cloudfw_responsive_options(array( 
                        'css' => array(
                            'padding-bottom' => array( 
                                'phone'         => (int) $logo_margin_bottom_phone,
                                'tablet'        => (int) $logo_margin_bottom_tablet,
                                'widescreen'    => $header_type == 2 ? (int) $logo_margin_bottom_tablet : 0,
                                //'widescreen'    => 0,
                            ),
                        )
                )); ?>>
                <div id="header-container-background"></div>
                <?php if ( $topbar_sticky ) include( TMP_MODULES . '/module.topbar/topbar.php' ); ?>
                <div class="container relative">        
                    <div id="logo" class="pull-left">
                        <a href="<?php echo __url( $logo_link ); ?>">
                            
                            <?php 

                                /** Destop Logo */
                                echo "<img ". 
                                    cloudfw_make_id( 'logo-desktop' ) .
                                    cloudfw_make_class( cloudfw_visible('desktop', $hide_on_stuck_class) , true) .
                                    cloudfw_make_attribute( array( 
                                        'src'           => $logo_image,
                                        'data-at2x'     => $logo_image_retina,
                                        'alt'           => get_bloginfo( 'name', 'display' ),
                                    ), FALSE ) .
                                    cloudfw_make_style_attribute( array(
                                        'margin-top'    => $logo_margin_top,
                                        'margin-bottom' => $logo_margin_bottom
                                    ), FALSE, TRUE )

                                ."/>";

                                /** Tablet Logo */
                                echo "\n<img ". 
                                    cloudfw_make_id( 'logo-tablet' ) .
                                    cloudfw_make_class( cloudfw_visible('tablet', $hide_on_stuck_class) , true) .
                                    cloudfw_make_attribute( array( 
                                        'src'           => $logo_image_tablet,
                                        'data-at2x'     => $logo_image_tablet_retina,
                                        'alt'           => get_bloginfo( 'name', 'display' ),
                                    ), FALSE ) .
                                    cloudfw_make_style_attribute( array(
                                        'margin-top'    => $logo_margin_top_tablet,
                                        'margin-bottom' => $logo_margin_bottom_tablet
                                    ), FALSE, TRUE )

                                ."/>";

                                /** Phone Logo */
                                echo "\n<img ". 
                                    cloudfw_make_id( 'logo-phone' ) .
                                    cloudfw_make_class( cloudfw_visible('phone', $hide_on_stuck_class) , true) .
                                    cloudfw_make_attribute( array( 
                                        'src'           => $logo_image_phone,
                                        'data-at2x'     => $logo_image_phone_retina,
                                        'alt'           => get_bloginfo( 'name', 'display' ),
                                    ), FALSE ) .
                                    cloudfw_make_style_attribute( array(
                                        'margin-top'    => $logo_margin_top_phone,
                                        'margin-bottom' => $logo_margin_bottom_phone
                                    ), FALSE, TRUE )

                                ."/>";


                                if ( !empty( $logo_image_sticky ) ) {

                                    /** Sticky Logo */
                                    echo "\n<img ". 
                                        cloudfw_make_id( 'logo-sticky' ) .
                                        cloudfw_make_class( 'show-on-stuck' , true) .
                                        cloudfw_make_attribute( array( 
                                            'src'           => $logo_image_sticky,
                                            'data-at2x'     => $logo_image_sticky_retina,
                                            'alt'           => get_bloginfo( 'name', 'display' ),
                                        ), FALSE ) .
                                        cloudfw_make_style_attribute( array(
                                            'margin-top'    => $logo_margin_top,
                                            'margin-bottom' => $logo_margin_bottom
                                        ), FALSE, TRUE )

                                    ."/>";
                                }

                             ?>
                        </a>
                    </div><!-- /#logo -->

                    <nav id="navigation" class="pull-right">
                        <?php do_action( 'cloudfw_primary_navigation' ); ?>
                    </nav><!-- /nav#navigation -->

                </div>
            </div><!-- /#header-container -->

        </header>
        <?php endif; ?>
        <?php cloudfw( 'header' ); ?>