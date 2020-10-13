<?php

if ( !class_exists('CloudFw_Walker_Primary_Menu') ) {
    /**
     *  CloudFw Primary Navigation Menu Walker
     *
     *  @since 1.0
    **/
    class CloudFw_Walker_Primary_Menu extends Walker_Nav_Menu {
        var $parent_options = array(); 

        function display_element ($element, &$children_elements, $max_depth, $depth = 0, $args, &$output) {
            $element->has_children = isset($children_elements[$element->ID]) && !empty($children_elements[$element->ID]);

            return parent::display_element($element, $children_elements, $max_depth, $depth, $args, $output);
        }



        function start_lvl( &$output, $depth = 0, $args = array() ) {
            $indent = str_repeat("\t", $depth);
            $style = ''; 

            if ( isset($this->parent_options['megamenu']) && $this->parent_options['megamenu'] && ( !isset($this->parent_options['layout']) || $this->parent_options['layout'] !== 'fullwidth' ) ) {
                if ( $depth === 0 ) {
                    $width = isset($this->parent_options['width']) ? $this->parent_options['width'] : NULL;
                    if ( $width )
                        $style = "width: {$width}px;";
                }
            }

            if ( $style )
                $style = ' style="'. $style .'"';

            $output .= "\n$indent<ul class=\"sub-menu\"{$style}>\n";
        }



        function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0) {
            $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

            $link_before = $args->link_before; 
            $link_after = $args->link_after; 

            $link_prepend = ''; 
            $link_append = '';

            $class_names = $link_class_names = '';
            $style = '';
            $link_style = '';
            $link_classes = array();
            $text_align = '';
            $megamenu = false;
            $megamenu_style = '';
            $megamenu_hide_title = false;
            $megamenu_image = '';
            $megamenu_html = '';
            
            $classes = empty( $item->classes ) ? array() : (array) $item->classes;
            $classes[] = 'level-' . $depth;

            if ( $depth === 0 ) {
                $this->parent_options = array();
                $classes[] = 'top-level-item';
            } else {
                $classes[] = 'sub-level-item';
            }

            if ( isset($item->has_children) && $item->has_children ) {
                $classes[] = 'has-child';


            if ( $depth === 0 ) {
                    
                    $megamenu = _check_onoff(cloudfw_get_post_meta($item->ID, 'megamenu', 'FALSE'));
                    
                    if ( $megamenu ) {
                        $classes[] = 'megamenu';
                        $classes[] = 'ui-row';
                        $this->parent_options['megamenu'] = true;
                        $this->parent_options['width'] = cloudfw_get_post_meta($item->ID, 'megamenu_width');
                    } else {
                        $classes[] = 'fallout';
                    }
                }
            }
            
            /** Get the item options */
            $disable_link = _check_onoff(cloudfw_get_post_meta($item->ID, 'disable_link', 'FALSE'));
            if ( $disable_link ) {
                $classes[] = 'link-disabled';
            }

            $dropdown_position = cloudfw_get_post_meta($item->ID, 'dropdown_direction', 'right');
            if ( $dropdown_position ) {
                $classes[] = 'to-' . $dropdown_position;
            }

            $visibility = cloudfw_get_post_meta($item->ID, 'visibility', 'right');
            if ( $visibility ) {
                $classes[] = cloudfw_visible( $visibility );
            }
            
            if ( $depth > 0 ) {
                $text_align = cloudfw_get_post_meta($item->ID, 'dropdown_text_align', '');
                if ( $text_align )
                    $link_classes[] = 'text-' . $text_align;

            }


            if ( isset($this->parent_options['megamenu']) && $this->parent_options['megamenu'] ) {

                if ( $depth === 0 ) {

                    $megamenu_columns = cloudfw_get_post_meta($item->ID, 'megamenu_columns', 4);
                    if ( $megamenu_columns ) {
                        $classes[] = 'columns-' . $megamenu_columns;
                    }

                } elseif ( $depth === 1 ) {

                    $megamenu_divider = _check_onoff(cloudfw_get_post_meta($item->ID, 'megamenu_divider', 'FALSE'));
                    if ( $megamenu_divider ) {
                        $output .= $indent . '<li class="megamenu-divider clearfix"></li>';
                        return;
                    }

                }

                if ( $depth > 0 ) {
                    $megamenu_hide_title = _check_onoff(cloudfw_get_post_meta($item->ID, 'megamenu_hide_title', 'FALSE'));
                    $megamenu_style = cloudfw_get_post_meta($item->ID, 'megamenu_style');
                    $megamenu_html = cloudfw_get_post_meta($item->ID, 'megamenu_html');
                    $megamenu_image = cloudfw_get_post_meta($item->ID, 'megamenu_image');
                    $megamenu_text_color = cloudfw_get_post_meta($item->ID, 'megamenu_text_color');
                    $megamenu_inline_style = cloudfw_get_post_meta($item->ID, 'megamenu_inline_style');
                    $megamenu_inline_style_link = cloudfw_get_post_meta($item->ID, 'megamenu_inline_style_link');

                    if ( $megamenu_text_color )
                        $link_style .= _makeAttr( NULL, 'color', $megamenu_text_color );

                    if ( $megamenu_inline_style )
                        $style .= $megamenu_inline_style;

                    if ( $megamenu_inline_style_link )
                        $link_style .= $megamenu_inline_style_link;
                        
                }
                
            }

            if ( $megamenu ) {            
                $megamenu_layout = cloudfw_get_post_meta($item->ID, 'megamenu_layout');
                if ( $megamenu_layout == 'fullwidth' ) {
                    $this->parent_options['layout'] = 'fullwidth';
                    $classes[] = 'layout-fullwidth';
                }
            }

            if ( $megamenu || ( isset($this->parent_options['megamenu']) && $this->parent_options['megamenu'] ) ) {            
                if ( $megamenu_style ) {
                    $classes[] = 'style--' . $megamenu_style;
                } else {
                    if ( $depth === 1 )
                        $classes[] = 'style--big-title';
                    elseif ( $depth === 2 )
                        $classes[] = 'style--standard';
                    elseif ( $depth === 3 )
                        $classes[] = 'style--list';

                }
    
                if (  ! $disable_link )
                    if ( in_array('style--big-title', $classes) )
                        $classes[] = 'link-enabled';
    
            }


            $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) );
            $class_names = ' class="'. esc_attr( $class_names ) . '"';

            $link_class_names = join( ' ', array_filter( $link_classes ) );


            $output .= $indent . '<li ';
            $output .= $item->ID ? 'id="menu-item-' . $item->ID .'"' : ''; 
            $output .= $style    ? ' style="' . $style .'"' : ''; 
            $output .= $class_names .'>';
            $attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
            $attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
            $attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';

            $attributes .= ! empty( $link_class_names ) ? ' class="'. esc_attr( $link_class_names ) . '"' : '';

            if ( ! $disable_link ) {
                $attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';
            }

            if ( $link_style ) {
                $attributes .= ' style="' . esc_attr( $link_style ) . '"';
            }

            $item_output = $args->before;

            if ( $megamenu_image ) {
                $item_output .= '<div class="megamenu-image">';

                    if ( ! $disable_link ) {
                        $item_output .= '<a href="'. esc_attr( $item->url ) .'">';
                    }

                    $item_output .= '<img src="'. $megamenu_image .'" alt=""/>';
                    
                    if ( ! $disable_link ) {
                        $item_output .= '</a>';
                    }

                $item_output .= '</div>';
            }
            
            if ( !$megamenu_hide_title  )  {
                $item_output .= $link_before;            
                $item_output .= '<a'. $attributes .'>';
                $item_output .= $link_prepend;            

                if ( in_array('style--list', $classes) )
                    $item_output .= $args->sub_level_caret_right;

                $item_output .= apply_filters( 'the_title', $item->title, $item->ID );

                if ( isset($item->has_children) && $item->has_children && $args->caret )
                    if ( $depth === 0 )
                        $item_output .= $args->caret;
                    else {
                        if ( $dropdown_position == 'left' ) 
                            $item_output .= isset($args->sub_level_caret_left) ? $args->sub_level_caret_left : NULL;
                        else
                            $item_output .= isset($args->sub_level_caret_right) ? $args->sub_level_caret_right : NULL;
                    }

                $item_output .= $link_append;            
                $item_output .= '</a>';
            $item_output .= $link_after;
            }

            if ( $megamenu_html )
                $item_output .= '<div class="megamenu-html">' . do_shortcode($megamenu_html) . '</div>';
            
            $item_output .= $args->after;
            
            $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
        }

    }

}