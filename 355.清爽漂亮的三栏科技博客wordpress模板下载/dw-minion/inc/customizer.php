<?php
include_once ABSPATH . 'wp-includes/class-wp-customize-control.php';

class DW_Minion_Textarea_Custom_Control extends WP_Customize_Control {

  public $type = 'textarea';
  public $statuses;
  public function __construct( $manager, $id, $args = array() ) {

  $this->statuses = array( '' => __( 'Default', 'dw-minion' ) );
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

class Layout_Picker_Custom_control extends WP_Customize_Control {

  public function render_content() {

  if ( empty( $this->choices ) ) return;

  $name = '_customize-radio-' . $this->id;

  ?>
  <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
  <table style="margin-top: 10px; text-align: center; width: 100%;">
    <tr>
    <?php foreach ( $this->choices as $value => $label ) : ?>
    <?php 
      $checked = '';
      if($value == 0) $checked = 'checked';
    ?>
    <td>
      <label>
        <img src="<?php echo get_template_directory_uri(); ?>/inc/img/layout-<?php echo esc_attr( $value ); ?>.png" alt="<?php echo esc_attr( $value ); ?>" /><br />
        <input type="radio" value="<?php echo esc_attr( $value ); ?>" name="<?php echo esc_attr( $name ); ?>" <?php $this->link(); checked( $this->value(), $value ); echo $checked ?> />
      </label>
    </td>
    <?php endforeach; ?>
    </tr>
  </table>
    <?php
  }
}

class Color_Picker_Custom_control extends WP_Customize_Control {

  public function render_content() {

    if ( empty( $this->choices ) ) return;
    $name = '_customize-radio-' . $this->id; ?>
    <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
    <table style="margin-top: 10px; text-align: center; width: 100%;">
      <tr>
        <?php foreach ( $this->choices as $value => $label ) {
                $checked = '';
                if($value == 0) $checked = 'checked'; ?>
                <td>
                  <label>
                    <div style="width: 30px; height: 30px; margin: 0 auto; background: <?php echo esc_attr( $label )?> "></div><br />
                    <?php if($value == 0) $label = '' ?>
                    <input type="radio" value="<?php echo esc_attr( $label ); ?>" name="<?php echo esc_attr( $name ); ?>" <?php $this->link(); checked( $this->value(), $value ); echo $checked ?> />
                  </label>
                </td>
          <?php } ?>
      </tr>
    </table><?php

  }
}

function dw_minion_customize_register( $wp_customize ) {

  // SITE LAYOUT --------------------------------------------------------------------------------------
  $wp_customize->add_section('dw_minion_layout', array(
    'title'    => __('Site Alignment', 'dw-minion'),
    'priority' => 10,
  ));

  $wp_customize->add_setting('dw_minion_theme_options[layout]', array(
    'capability' => 'edit_theme_options',
    'type' => 'option'
  ));

  $wp_customize->add_control( new Layout_Picker_Custom_control($wp_customize, 'layout', array(
    'label' => __('Align Left/Center', 'dw-minion'),
    'section' => 'dw_minion_layout',
    'settings' => 'dw_minion_theme_options[layout]',
    'choices' => array('left', 'center')
  )));

  // SITE INFO & FAVICON --------------------------------------------------------------------------------------
  $wp_customize->add_setting('dw_minion_theme_options[about]', array(
    'default'        => '',
    'capability'     => 'edit_theme_options',
    'type'           => 'option',
  ));
  $wp_customize->add_control( new DW_Minion_Textarea_Custom_Control($wp_customize, 'about', array(
    'label'      => __('About', 'dw-minion'),
    'section'    => 'title_tagline',
    'settings'   => 'dw_minion_theme_options[about]',
  )));
  $wp_customize->add_setting('dw_minion_theme_options[logo]', array(
    'capability' => 'edit_theme_options',
    'type' => 'option',
  ));
  $wp_customize->add_control( new WP_Customize_Image_Control($wp_customize, 'logo', array(
    'label' => __('Site Logo', 'dw-minion'),
    'section' => 'title_tagline',
    'settings' => 'dw_minion_theme_options[logo]',
  )));
  $wp_customize->add_setting('dw_minion_theme_options[header_display]', array(
    'default'        => 'site_title',
    'capability'     => 'edit_theme_options',
    'type'           => 'option',
  ));
  $wp_customize->add_control( 'header_display', array(
    'settings' => 'dw_minion_theme_options[header_display]',
    'label'   => 'Display as',
    'section' => 'title_tagline',
    'type'    => 'select',
    'choices'    => array(
      'site_title' => 'Site Title',
      'site_logo' => 'Site Logo',
    ),
  ));
  $wp_customize->add_setting('dw_minion_theme_options[favicon]', array(
    'capability' => 'edit_theme_options',
    'type' => 'option',
  ));
  $wp_customize->add_control( new WP_Customize_Image_Control($wp_customize, 'favicon', array(
    'label' => __('Site Favicon', 'dw-minion'),
    'section' => 'title_tagline',
    'settings' => 'dw_minion_theme_options[favicon]',
  )));

  // SOCIAL LINKS --------------------------------------------------------------------------------------
  $wp_customize->add_section('dw_minion_social_links', array(
    'title'    => __('Social Links', 'dw-minion'),
    'priority' => 108,
  ));
  $wp_customize->add_setting('dw_minion_theme_options[facebook]', array(
    'default'        => '',
    'capability'     => 'edit_theme_options',
    'type'           => 'option',
  ));
  $wp_customize->add_control('facebook', array(
    'label'      => __('Facebook', 'dw-minion'),
    'section'    => 'dw_minion_social_links',
    'settings'   => 'dw_minion_theme_options[facebook]',
  ));
  $wp_customize->add_setting('dw_minion_theme_options[twitter]', array(
    'default'        => '',
    'capability'     => 'edit_theme_options',
    'type'           => 'option',
  ));
  $wp_customize->add_control('twitter', array(
    'label'      => __('Twitter', 'dw-minion'),
    'section'    => 'dw_minion_social_links',
    'settings'   => 'dw_minion_theme_options[twitter]',
  ));
  $wp_customize->add_setting('dw_minion_theme_options[google_plus]', array(
    'default'        => '',
    'capability'     => 'edit_theme_options',
    'type'           => 'option',
  ));
  $wp_customize->add_control('google_plus', array(
    'label'      => __('Google+', 'dw-minion'),
    'section'    => 'dw_minion_social_links',
    'settings'   => 'dw_minion_theme_options[google_plus]',
  ));
  $wp_customize->add_setting('dw_minion_theme_options[youtube]', array(
    'default'        => '',
    'capability'     => 'edit_theme_options',
    'type'           => 'option',
  ));
  $wp_customize->add_control('youtube', array(
    'label'      => __('YouTube', 'dw-minion'),
    'section'    => 'dw_minion_social_links',
    'settings'   => 'dw_minion_theme_options[youtube]',
  ));
  $wp_customize->add_setting('dw_minion_theme_options[linkedin]', array(
    'default'        => '',
    'capability'     => 'edit_theme_options',
    'type'           => 'option',
  ));
  $wp_customize->add_control('linkedin', array(
    'label'      => __('LinkedIn', 'dw-minion'),
    'section'    => 'dw_minion_social_links',
    'settings'   => 'dw_minion_theme_options[linkedin]',
  ));

  // LEFT SIDEBAR COLOR --------------------------------------------------------------------------------------
  $wp_customize->add_section('dw_minion_leftbar', array(
    'title'    => __('Left Sidebar Color', 'dw-minion'),
    'priority' => 109,
  ));
  $wp_customize->add_setting('dw_minion_theme_options[leftbar_bgcolor]', array(
    'capability'     => 'edit_theme_options',
    'type'           => 'option',
  ));
  $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'leftbar_bgcolor', array(
    'label'        => __( 'Background Color', 'dw-minion' ),
    'section'    => 'dw_minion_leftbar',
    'settings'   => 'dw_minion_theme_options[leftbar_bgcolor]',
  )));
  $wp_customize->add_setting('dw_minion_theme_options[leftbar_bghovercolor]', array(
    'capability'     => 'edit_theme_options',
    'type'           => 'option',
  ));
  $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'leftbar_bghovercolor', array(
    'label'        => __( 'Background Hover Color', 'dw-minion' ),
    'section'    => 'dw_minion_leftbar',
    'settings'   => 'dw_minion_theme_options[leftbar_bghovercolor]',
  )));
  $wp_customize->add_setting('dw_minion_theme_options[leftbar_color]', array(
    'capability'     => 'edit_theme_options',
    'type'           => 'option',
  ));
  $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'leftbar_color', array(
    'label'        => __( 'Text Color', 'dw-minion' ),
    'section'    => 'dw_minion_leftbar',
    'settings'   => 'dw_minion_theme_options[leftbar_color]',
  )));
  $wp_customize->add_setting('dw_minion_theme_options[leftbar_hovercolor]', array(
    'capability'     => 'edit_theme_options',
    'type'           => 'option',
  ));
  $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'leftbar_hovercolor', array(
    'label'        => __( 'Text Hover Color', 'dw-minion' ),
    'section'    => 'dw_minion_leftbar',
    'settings'   => 'dw_minion_theme_options[leftbar_hovercolor]',
  )));
  $wp_customize->add_setting('dw_minion_theme_options[leftbar_bordercolor]', array(
    'capability'     => 'edit_theme_options',
    'type'           => 'option',
  ));
  $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'leftbar_bordercolor', array(
    'label'        => __( 'Border Color', 'dw-minion' ),
    'section'    => 'dw_minion_leftbar',
    'settings'   => 'dw_minion_theme_options[leftbar_bordercolor]',
  )));

  // STYLE SELECTOR --------------------------------------------------------------------------------------
  $wp_customize->add_section('dw_minion_primary_color', array(
    'title'    => __('Style Selector', 'dw-minion'),
    'priority' => 110,
  ));
  $wp_customize->add_setting('dw_minion_theme_options[select-color]', array(
    'capability'     => 'edit_theme_options',
    'type'           => 'option',
  ));
  $wp_customize->add_control( new Color_Picker_Custom_control($wp_customize, 'select-color', array(
    'label' => __('Color Schemes', 'dw-minion'),
    'section' => 'dw_minion_primary_color',
    'settings' => 'dw_minion_theme_options[select-color]',
    'choices' => array('#7cc576', '#38B7EA', '#fc615d', '#B39964', '#e07798')
  )));
  $wp_customize->add_setting('dw_minion_theme_options[custom-color]', array(
    'default'        => '',
    'capability'     => 'edit_theme_options',
    'type'           => 'option',
  ));
  $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'link_color', array(
    'label'        => __( 'Custom Color', 'dw-minion' ),
    'section'    => 'dw_minion_primary_color',
    'settings'   => 'dw_minion_theme_options[custom-color]',
  )));

  // FONT SELECTOR --------------------------------------------------------------------------------------
  $fonts = dw_get_gfonts();
  $newarray = array();
  $newarray[] = '';
  foreach ($fonts as $index => $font) {
    foreach ($font->files as $key => $value) {
      $newarray[$font->family . ':dw:' . $value ] = $font->family . ' - ' . $key;
    }
  }
  $wp_customize->add_section('dw_minion_typo', array(
    'title'    => __('Font Selector', 'dw-minion'),
    'priority' => 111,
  ));
  $wp_customize->add_setting('dw_minion_theme_options[heading_font]', array(
    'default'        => '',
    'capability'     => 'edit_theme_options',
    'type'           => 'option',
  ));
  $wp_customize->add_control( 'heading_font', array(
    'settings' => 'dw_minion_theme_options[heading_font]',
    'label'   => __('Select headding font', 'dw-minion'),
    'section' => 'dw_minion_typo',
    'type'    => 'select',
    'choices'    => $newarray
  ));
  $wp_customize->add_setting('dw_minion_theme_options[body_font]', array(
    'default'        => '',
    'capability'     => 'edit_theme_options',
    'type'           => 'option',
  ));
  $wp_customize->add_control( 'body_font', array(
    'settings' => 'dw_minion_theme_options[body_font]',
    'label'   => __('Select body font', 'dw-minion'),
    'section' => 'dw_minion_typo',
    'type'    => 'select',
    'choices'    => $newarray
  ));
  $wp_customize->add_setting('dw_minion_theme_options[article_font_size]', array(
    'default'        => '',
    'capability'     => 'edit_theme_options',
    'type'           => 'option',
  ));
  $wp_customize->add_control('article_font_size', array(
    'label'      => __('Article font size (px)', 'dw-minion'),
    'section'    => 'dw_minion_typo',
    'settings'   => 'dw_minion_theme_options[article_font_size]',
  ));

  // CUSTOM CODE --------------------------------------------------------------------------------------
  $wp_customize->add_section('dw_minion_custom_code', array(
    'title'    => __('Custom Code', 'dw-minion'),
    'priority' => 200,
  ));
  $wp_customize->add_setting('dw_minion_theme_options[header_code]', array(
      'default' => '',
      'capability' => 'edit_theme_options',
      'type' => 'option',
  ));
  $wp_customize->add_control( new DW_Minion_Textarea_Custom_Control($wp_customize, 'header_code', array(
    'label'    => __('Header Code (Meta tags, CSS, etc ...)', 'dw-minion'),
    'section'  => 'dw_minion_custom_code',
    'settings' => 'dw_minion_theme_options[header_code]',
  )));
  $wp_customize->add_setting('dw_minion_theme_options[footer_code]', array(
    'default' => '',
    'capability' => 'edit_theme_options',
    'type' => 'option',
  ));
  $wp_customize->add_control( new DW_Minion_Textarea_Custom_Control($wp_customize, 'footer_code', array(
    'label'    => __('Footer Code (Analytics, etc ...)', 'dw-minion'),
    'section'  => 'dw_minion_custom_code',
    'settings' => 'dw_minion_theme_options[footer_code]'
  )));
}
add_action( 'customize_register', 'dw_minion_customize_register' );