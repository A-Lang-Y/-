<?php
include_once ABSPATH . 'wp-includes/class-wp-customize-control.php';

class DW_Timeline_Textarea_Custom_Control extends WP_Customize_Control {

  public $type = 'textarea';
  public $statuses;
  public function __construct( $manager, $id, $args = array() ) {

  $this->statuses = array( '' => __( 'Default', 'dw-timeline' ) );
    parent::__construct( $manager, $id, $args );
  }

  public function render_content() {
    ?>
    <label>
      <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
      <textarea class="large-text" cols="20" rows="5" <?php $this->link(); ?>>
        <?php echo esc_textarea( $this->value() ); ?>
      </textarea>
    </label>
    <?php
  }
}

function dw_timeline_customize_register( $wp_customize ) {

  // GET STATR BUTTON
  $wp_customize->add_setting('dw_timeline_theme_options[get_start]', array(
    'default' => 'Get Start Now',
    'capability' => 'edit_theme_options',
    'type' => 'option'
  ));
  $wp_customize->add_control( new WP_Customize_Control($wp_customize, 'get_start', array(
    'label' => __('Get Start Button', 'dw-timeline'),
    'section' => 'title_tagline',
    'settings' => 'dw_timeline_theme_options[get_start]',
  )));

  // FAVICON 
  $wp_customize->add_setting('dw_timeline_theme_options[favicon]', array(
    'default' => '',
    'capability' => 'edit_theme_options',
    'type' => 'option',
  ));
  $wp_customize->add_control( new WP_Customize_Image_Control($wp_customize, 'favicon', array(
    'label' => __('Site Favicon', 'dw-timeline'),
    'section' => 'title_tagline',
    'settings' => 'dw_timeline_theme_options[favicon]',
  )));

  // CUSTOM HEADER
  $wp_customize->add_section('dw_timeline_cover_image', array(
    'title'    => __('Cover image', 'dw-timeline'),
    'priority' => 50,
  ));

  $wp_customize->add_setting('dw_timeline_theme_options[header_background_image]', array(
    'default' => get_template_directory_uri().'/assets/img/bg.jpg',
    'capability' => 'edit_theme_options',
    'type' => 'option',
  ));
  $wp_customize->add_control( new WP_Customize_Image_Control($wp_customize, 'header_background_image', array(
    'label' => __('Header Image', 'dw-timeline'),
    'section' => 'dw_timeline_cover_image',
    'settings' => 'dw_timeline_theme_options[header_background_image]',
  )));

  $wp_customize->add_setting('dw_timeline_theme_options[header_mask_start]', array(
    'default' => '#a83279',
    'capability' => 'edit_theme_options',
    'type' => 'option',
  ));
  $wp_customize->add_control( new WP_Customize_Color_Control($wp_customize, 'header_mask_start', array(
    'label' => __('Header mask', 'dw-timeline'),
    'section' => 'dw_timeline_cover_image',
    'settings' => 'dw_timeline_theme_options[header_mask_start]',
  )));

  $wp_customize->add_setting('dw_timeline_theme_options[header_mask_end]', array(
    'default' => '#d38312',
    'capability' => 'edit_theme_options',
    'type' => 'option',
  ));
  $wp_customize->add_control( new WP_Customize_Color_Control($wp_customize, 'header_mask_end', array(
    'section' => 'dw_timeline_cover_image',
    'settings' => 'dw_timeline_theme_options[header_mask_end]',
  )));

  $wp_customize->add_setting('dw_timeline_theme_options[site_title_backgournd]', array(
    'default' => '#f2664f',
    'capability' => 'edit_theme_options',
    'type' => 'option'
  ));
  $wp_customize->add_control( new WP_Customize_Color_Control($wp_customize, 'site_title_backgournd', array(
    'label' => __('Site title background', 'dw-timeline'),
    'section' => 'dw_timeline_cover_image',
    'settings' => 'dw_timeline_theme_options[site_title_backgournd]',
  )));

  // FONT SELECTOR
  // -------------------------------------------
  $wp_customize->add_section('dw_timeline_font_selector', array(
    'title'    => __('Font Selector', 'dw-timeline'),
    'priority' => 50,
  ));

  $fonts = dw_timeline_get_gfonts();
  $newarray = array();
  $newarray[] = '';
  foreach ($fonts as $index => $font) {
    foreach ($font->files as $key => $value) {
      $newarray[$font->family . ':dw:' . $value ] = $font->family . ' - ' . $key;
    }
  }

  $wp_customize->add_setting('dw_timeline_theme_options[heading_font]', array(
    'default'        => '',
    'capability'     => 'edit_theme_options',
    'type'           => 'option',
  ));
  $wp_customize->add_control( 'heading_font', array(
    'settings' => 'dw_timeline_theme_options[heading_font]',
    'label'   => __('Headding font', 'dw-timeline'),
    'section' => 'dw_timeline_font_selector',
    'type'    => 'select',
    'choices'    => $newarray
  ));

  $wp_customize->add_setting('dw_timeline_theme_options[body_font]', array(
    'default'        => '',
    'capability'     => 'edit_theme_options',
    'type'           => 'option',
  ));
  $wp_customize->add_control( 'body_font', array(
    'settings' => 'dw_timeline_theme_options[body_font]',
    'label'   => __('Content font', 'dw-timeline'),
    'section' => 'dw_timeline_font_selector',
    'type'    => 'select',
    'choices'    => $newarray
  ));

  // CUSTOM CODE 
  $wp_customize->add_section('dw_timeline_custom_code', array(
    'title'    => __('Custom Code', 'dw-timeline'),
    'priority' => 200,
  ));

  $wp_customize->add_setting('dw_timeline_theme_options[header_code]', array(
      'default' => '',
      'capability' => 'edit_theme_options',
      'type' => 'option',
  ));
  $wp_customize->add_control( new DW_Timeline_Textarea_Custom_Control($wp_customize, 'header_code', array(
    'label'    => __('Header Code (Meta tags, CSS, etc ...)', 'dw-timeline'),
    'section'  => 'dw_timeline_custom_code',
    'settings' => 'dw_timeline_theme_options[header_code]',
  )));

  $wp_customize->add_setting('dw_timeline_theme_options[footer_code]', array(
    'default' => '',
    'capability' => 'edit_theme_options',
    'type' => 'option',
  ));
  $wp_customize->add_control( new DW_Timeline_Textarea_Custom_Control($wp_customize, 'footer_code', array(
    'label'    => __('Footer Code (Analytics, etc ...)', 'dw-timeline'),
    'section'  => 'dw_timeline_custom_code',
    'settings' => 'dw_timeline_theme_options[footer_code]'
  )));
}
add_action( 'customize_register', 'dw_timeline_customize_register' );

/**
 * Get Theme options
 */
function dw_timeline_get_theme_option( $option_name, $default = false ) {
  $options = get_option( 'dw_timeline_theme_options' );
  if( isset($options[$option_name]) && ! empty( $options[$option_name] ) ) {
    return $options[$option_name];
  }
  return $default; 
}

/**
 *  Get google fonts
 */

if( ! function_exists('dw_timeline_get_gfonts') ) {
  function dw_timeline_get_gfonts(){
    $fontsSeraliazed = wp_remote_fopen( get_template_directory_uri() . '/lib/font/gfonts_v2.txt' );
    $fontArray = unserialize( $fontsSeraliazed );
    return $fontArray->items;
  }
}

/**
 * Header code
 */
if( ! function_exists('header_code') ) {
  function header_code(){
    $header_code = dw_timeline_get_theme_option('header_code');
    if ($header_code) {
      echo $header_code;
    }
  }
  add_action( 'wp_head', 'header_code' );
}

/**
 * Footer code
 */
if( ! function_exists('footer_code') ) {
  function footer_code(){
    $footer_code = dw_timeline_get_theme_option('footer_code');
    if ($footer_code) {
      echo $footer_code;
    }
  }
  add_action( 'wp_footer', 'footer_code' );
}

/**
 * Favicon
 */
function dw_timeline_favicon(){
  $favicon = dw_timeline_get_theme_option('favicon');
  if ($favicon) {
    echo '<link rel="shortcut icon" href="'.$favicon.'">';
  }
}
add_action( 'wp_head', 'dw_timeline_favicon' );

/**
 * Custom Header
 */
function dw_timeline_custom_header() {
  $header_image = dw_timeline_get_theme_option('header_background_image');
  $header_mask_start = dw_timeline_get_theme_option('header_mask_start');
  $header_mask_end = dw_timeline_get_theme_option('header_mask_end');
  $site_title_backgournd = dw_timeline_get_theme_option('site_title_backgournd');
    ?>
    <style>
    <?php if ( $header_image ) { ?>
    .banner.cover {
      background-image: url(<?php echo $header_image ?>);
    }
    <?php } ?>

    <?php if ( $header_mask_start || $header_mask_end ) { ?>
    .banner.cover:before {
      background: <?php echo $header_mask_start; ?>
      background-image: -webkit-linear-gradient(-45deg, <?php echo $header_mask_start ?>, <?php echo $header_mask_end ?>);
      background-image: linear-gradient(-45deg, <?php echo $header_mask_start ?>, <?php echo $header_mask_end ?>);
    }
    <?php } ?>
    
    <?php if ( $site_title_backgournd ) { ?>
    .banner hgroup:after {
      background-color: <?php echo $site_title_backgournd; ?>;
    }
    .banner #get-started {
      color: <?php echo $site_title_backgournd; ?>; 
    }
    <?php } ?>

    <?php if ($site_title_backgournd == '') { ?>
      .banner hgroup:after {
        background: none;
      }   
    <?php } ?>

    </style>    
    <?php
}
add_action( 'wp_head', 'dw_timeline_custom_header' );

/**
 * Font Selector
 */
if( ! function_exists('dw_timeline_typo_font') ) {
  function dw_timeline_typo_font(){
    if (dw_timeline_get_theme_option('heading_font') && dw_timeline_get_theme_option('heading_font') != '') {
      $heading_font = explode(':dw:', dw_timeline_get_theme_option('heading_font') );
      ?>
        <style type="text/css" id="heading_font" media="screen">
          @font-face {
            font-family: "<?php echo $heading_font[0] ?>";
            src: url('<?php echo $heading_font[1] ?>');
          } 
          h1,h2,h3,h4,h5,h6, blockquote {
            font-family: "<?php echo $heading_font[0] ?>" !important;
          }
        </style>
      <?php
    }
    if (dw_timeline_get_theme_option( 'body_font') && dw_timeline_get_theme_option( 'body_font') != '') {
      $body_font = explode( ':dw:', dw_timeline_get_theme_option( 'body_font' ));
      ?>
        <style type="text/css" id="body_font" media="screen">
          @font-face {
            font-family: "<?php echo $body_font[0] ?>";
            src: url('<?php echo $body_font[1] ?>');
          } 
          body, .entry-content, blockquote cite{
            font-family: "<?php echo $body_font[0] ?>" !important;
          }
        </style>
      <?php
    }
  }
  add_filter('wp_head','dw_timeline_typo_font');
}