<?php
function dw_minion_dynamic_widget_js() {
  wp_enqueue_style( 'dynamic-widget-style', get_template_directory_uri() . '/inc/css/dynamic-widget.css', array(), '20130716' );
  wp_enqueue_script( 'dynamic-widget-js', get_template_directory_uri() . '/inc/js/dynamic-widget.js', array('jquery','jquery-ui-datepicker','jquery-ui-sortable','jquery-ui-sortable', 'jquery-ui-draggable','jquery-ui-droppable','admin-widgets' ), '20130716', true );
}
add_action( 'admin_enqueue_scripts', 'dw_minion_dynamic_widget_js' );

/**
 * Dynamic Widget
 */
class dw_dynamic_Widget extends WP_Widget {
  function widget( $args, $instance ) {
    extract( $args, EXTR_SKIP );
    echo $before_widget;
    $this->dw_display_widgets_front($instance);
    echo $after_widget;
  }
  function update( $new_instance, $old_instance ) {
    $updated_instance = $new_instance;
    return $updated_instance;
  }
  function form( $instance ) {
    global $wp_registered_widgets;
    $instance = wp_parse_args( $instance, array( 
      'widgets'    =>  '',
      'title'     =>  ''
    ) );
    ?>
      <input type="hidden" class="widefat" name="<?php echo $this->get_field_name('widgets') ?>" id="<?php echo $this->get_field_id('widgets') ?>" value="<?php echo htmlentities( $instance['widgets'] ) ?>" >
      <input type="hidden" name="<?php echo $this->get_field_name('title') ?>" id="<?php echo $this->get_field_id('title') ?>" value="<?php echo $instance['title'] ?>" class="widefat">
      <div class="dw-widget-extends" data-setting="#<?php echo $this->get_field_id('widgets') ?>" >
        <p class="description"><?php _e('Drag & Drop Widgets Here','dw_minion') ?></p>
        <?php
          $widgets = explode(':dw-data:', $instance['widgets'] );
          if( !empty($widgets) && is_array($widgets) ){
            $number = 1;
            foreach ($widgets as $widget) {
              if( !empty( $widget ) ) {
                $url = rawurldecode($widget);
                parse_str($widget,$s);
                $this->dw_display_widgets($s, $number);
              }
              $number++;
            }
          }
        ?>
      </div>
    <?php
  }
  function dw_get_widgets( $id_base, $number ){
    global $wp_registered_widgets;
    $widget = false;
    foreach ($wp_registered_widgets as $key => $wdg) {
      if( strpos( $key, $id_base ) === 0 ) {
        if( isset($wp_registered_widgets[ $key ]['callback'][0]) && is_object($wp_registered_widgets[ $key ]['callback'][0]) ) {
          $classname = get_class( $wp_registered_widgets[ $key ]['callback'][0] );
          $widget = new $classname;
          $widget->id_base = $id_base;
          $widget->number = $number;
          break;
        }
      }
    }
    return $widget;
  }
  function dw_display_widgets($s, $number){
    $instance = !empty($s['widget-'.$s['id_base']]) ? array_shift( $s['widget-'.$s['id_base']] ) : array();
    $widget = $this->dw_get_widgets( $s['id_base'], $number );
  ?>  
    <?php if( $widget ) { ?>
    <div id="<?php echo esc_attr($s['widget-id']); ?>" class="widget">
      <div class="widget-top">
        <div class="widget-title-action">
          <a class="widget-action hide-if-no-js" href="#available-widgets"></a>
          <a class="widget-control-edit hide-if-js" href="<?php echo esc_url( add_query_arg( $query_arg ) ); ?>">
            <span class="edit"><?php _ex( 'Edit', 'widget' ); ?></span>
            <span class="add"><?php _ex( 'Add', 'widget' ); ?></span>
            <span class="screen-reader-text"><?php echo $widget->name; ?></span>
          </a>
        </div>
        <div class="widget-title"><h4><?php echo $widget->name; ?><span class="in-widget-title"></span></h4></div>
      </div>
      <div class="widget-inside">
        <div class="widget-content">
          <?php if( isset($s['id_base'] ) ) { 
            $widget->form($instance); 
          } else { 
            echo "\t\t<p>" . __('There are no options for this widget.','dw_minion') . "</p>\n"; 
          } ?>
        </div>
        <input data-dw="true" type="hidden" name="widget-id" class="widget-id" value="<?php echo esc_attr($s['widget-id']); ?>" />
        <input data-dw="true" type="hidden" name="id_base" class="id_base" value="<?php echo esc_attr($s['id_base']); ?>" />
        <input data-dw="true" type="hidden" name="widget-width" class="widget-width" value="<?php echo esc_attr($s['widget-width']); ?>">
        <div class="widget-control-actions">
          <div class="alignleft">
            <a class="widget-control-remove" href="#remove"><?php _e('Delete','dw_minion'); ?></a> |
            <a class="widget-control-close" href="#close"><?php _e('Close','dw_minion'); ?></a>
          </div>
          <div class="alignright widget-control-noform">
            <?php submit_button( __( 'Save', 'dw_minion' ), 'button-primary widget-control-save right', 'savewidget', false, array( 'id' => 'widget-' . esc_attr( $s['widget-id'] ) . '-savewidget' ) ); ?>
            <span class="spinner"></span>
          </div>
          <br class="clear" />
        </div>
      </div>
      <div class="widget-description"><?php echo ( $widget_description = wp_widget_description($widget_id) ) ? "$widget_description\n" : "$widget_title\n"; ?></div>
    </div>
    <?php } ?>
  <?php
  }
}

/**
 * Tabs Widget
 */
class dw_tabs_Widget extends dw_dynamic_Widget {
  function dw_tabs_Widget() {
    $widget_ops = array( 'classname' => 'dw_tabs news-tab', 'description' => __('Display widgets inside a tab','dw_minion') );
    $this->WP_Widget( 'dw_tabs', 'DW: Tabs', $widget_ops );
  }
  function dw_display_widgets_front($instance){
    global $wp_registered_widget_updates;
    wp_parse_args($instance, array(
      'widgets' => array()
    ));
    $widgets = explode(':dw-data:', $instance['widgets'] );
    if( !empty($widgets) && is_array($widgets) ){ ?>
      <div class="nav-tab-select-wrap">
        <select name="nav-tabs-<?php echo $this->id ?>" class="nav-tabs-by-select visible-phone" >
          <?php
            $i = 0;
            foreach ($widgets as $widget ) {
              $selected = '';
              if( $i == 0 ){ $active='selected="selected"'; }
              $i++;
              if( !empty( $widget ) ) {
                $url = rawurldecode($widget);
                parse_str($url,$s);
                $instance = !empty($s['widget-'.$s['id_base']]) ? array_shift( $s['widget-'.$s['id_base']] ) : array();
                $widget = $this->dw_get_widgets( $s['id_base'], $i );
                if( $widget ) {
                  $widget_title = isset($instance['title']) ? $instance['title'] : $widget->name;
                  echo '<option data-target="#'.$s['widget-id'].'" '.$selected.' value="#'.$s['widget-id'].'" >'.strtoupper( $widget_title ).'</option>';
                }
              }
            }
          ?>
        </select>
      </div>
      <ul class="nav nav-tabs hidden-phone" id="nav-tabs-<?php echo $this->id ?>">
      <?php
      $i = 0;
      foreach ($widgets as $widget ) {
        $active = '';
        if( $i == 0 ){ $active='active'; } 
        $i++;
        if( !empty( $widget ) ) {
          $url = rawurldecode($widget);
          parse_str($widget,$s);
          $instance = !empty($s['widget-'.$s['id_base']]) ? array_shift( $s['widget-'.$s['id_base']] ) : array();
          $widget = $this->dw_get_widgets( $s['id_base'], $i );
          if( $widget ) {
            $widget_title = isset($instance['title']) ? $instance['title'] : $widget->name;
            echo '<li class="'.$active.'"><a href="#'.$s['widget-id'].'" data-toggle="tab">'.$widget_title.'</a></li>';
          }
        }
      }
      ?>
      </ul>
      <div class="tab-content">
        <?php
          $i=0;
          foreach ($widgets as $widget) {
            $active = '';
            if( $i == 0 ) { $active='active'; }
             $i++;
              if( !empty( $widget ) ) {
                $url = rawurldecode($widget);
                parse_str($widget,$s);
                $instance = isset($s['widget-'.$s['id_base']]) ? array_shift( $s['widget-'.$s['id_base']] ) : array();
                $widget = $this->dw_get_widgets( $s['id_base'], $i );
                if( isset($s['id_base'] ) && $widget ) {
                  $widget_options = $widget->widget_options; 
                ?>
                  <div class="tab-pane <?php echo 'widget_'.$s['widget-id'].' '.$widget_options['classname'] ?> <?php echo $active ?>" id="<?php echo $s['widget-id'] ?>">
                    <?php  
                      $default_args = array( 
                        'before_widget' => '', 
                        'after_widget' => '', 
                        'before_title' => '<h3 class="widget-title">',
                        'after_title' => '</h3>' 
                      );
                      $widget->widget($default_args,$instance);
                    ?>
                  </div>
                <?php
                }
              }
            }
          } 
        ?>
      </div>
  <?php
  }
}
add_action( 'widgets_init', create_function( '', "register_widget('dw_tabs_Widget');" ) );

/**
 * Accordion Widget
 */
class dw_accordion_Widget extends dw_dynamic_Widget {
  function dw_accordion_Widget() {
    $widget_ops = array( 'classname' => 'dw_accordion news-accordion', 'description' => __('Display widgets inside an accordion','dw_minion') );
    $this->WP_Widget( 'dw_accordions', 'DW: Accordion', $widget_ops );
  }
  function dw_display_widgets_front($instance){
    global $wp_registered_widget_updates;
    wp_parse_args($instance, array(
      'widgets' => array()
    ));
    $widgets = explode(':dw-data:', $instance['widgets'] );
    if( !empty($widgets) && is_array($widgets) ) {
      echo '<div class="accordion" id="accordion-'.$this->id.'">';
      $collapse = ''; $i = 0;
      foreach ($widgets as $widget) {
        $collapse = ( $i == 0 ) ? 'active' : 'collapsed';
        if( !empty( $widget ) ) {
          $url = rawurldecode($widget);
          parse_str($url,$s);
          $instance = !empty($s['widget-'.$s['id_base']]) ? array_shift( $s['widget-'.$s['id_base']] ) : array();
          $widget = $this->dw_get_widgets( $s['id_base'], $i );
          if( isset($s['id_base'] ) && $widget ){ ?>
            <?php $widget_options = $widget->widget_options; ?>
            <div class="accordion-group">
              <div class="accordion-heading"><a class="accordion-toggle <?php echo $collapse ?>" data-toggle="collapse" data-parent="#accordion-<?php echo $this->id ?>" href="#<?php echo $this->id ?>-<?php echo $s['widget-id'] ?>"><?php echo ( isset($instance['title']) ) ? $instance['title'] : $widget->name; ?></a></div>
              <div id="<?php echo $this->id ?>-<?php echo $s['widget-id'] ?>" class="<?php echo 'widget_'.$s['widget-id'].' ' ?> accordion-body collapse <?php echo $collapse == 'active' ? 'in' : ''; ?> <?php echo $widget_options['classname'] ?>">
                <div class="accordion-inner">
                <?php  
                $default_args = array( 
                    'before_widget' => '', 
                    'after_widget' => '', 
                    'before_title' => '<h3 class="widget-title">', 
                    'after_title' => '</h3>' 
                );
                $widget->widget($default_args,$instance);
                ?>
                </div>
              </div>
            </div>
          <?php
          }
        }
        $i++;
      }
      echo '</div>';
    }
  }
}
add_action( 'widgets_init', create_function( '', "register_widget('dw_accordion_Widget');" ) );