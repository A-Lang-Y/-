<?php

function minty_customize_register( $wp_customize ) {
	$wp_customize->add_setting( 'minty_color_scheme' , array(
		'default'     => 'turquoise',
		'capability'  => 'edit_theme_options',
		'transport'   => 'refresh',
	) );
	
	$wp_customize->add_control( 'color_scheme', array(
		'label'      => '主色调',
		'section'    => 'colors',
		'settings'   => 'minty_color_scheme',
		'priority'   => 1,
		'type'       => 'radio',
        'choices'    => array(
            'turquoise'   => '薄荷',
            'emerland'    => '碧绿',
            'peter-river' => '兰靛',
            'amethyst'    => '紫罗兰',
            'wet-asphalt' => '沥青',
            'sun-flower'  => '缃色',
            'carrot'      => '琥珀',
            'alizarin'    => '茜红'
        )
	) );
}
add_action( 'customize_register', 'minty_customize_register' );

function add_customize_page_css() {
?>
<style>
#customize-control-color_scheme { }
#customize-control-color_scheme label { display: inline-block; border-radius: 50%; width: 40px; height: 40px; border: 3px solid #fff; overflow: hidden; margin: 5px 9px 0 0; position: relative; cursor: pointer; }
#customize-control-color_scheme .turquoise { background: #1abc9c; }
#customize-control-color_scheme .emerland { background: #2ecc71; }
#customize-control-color_scheme .peter-river { background: #3498db; }
#customize-control-color_scheme .amethyst { background: #9b59b6; }
#customize-control-color_scheme .wet-asphalt { background: #34495e; }
#customize-control-color_scheme .sun-flower { background: #f1c40f; }
#customize-control-color_scheme .carrot { background: #e67e22; }
#customize-control-color_scheme .alizarin { background: #e74c3c; }
#customize-control-color_scheme input { margin: 12px; padding: 0; vertical-align: top; opacity: 0; cursor: pointer; }
#customize-control-color_scheme input:checked {opacity: 1; }
</style>
<script>
window.onload = function(){
	jQuery(function($){
		$("#customize-control-color_scheme label").each(function(){
			var $this = $(this);
			$this.addClass($("input", $this).val()).attr("title", $this.text().replace(/^\s*|\s*$/g,""));
		});
	});
}
</script>
<?php
}
add_action('customize_controls_print_styles', 'add_customize_page_css');
?>