<div id="mb_composer_template">
    
    <?php

        require_once(TMP_PATH.'/cloudfw/core/engine.render/core.render.php');

        $form = array( 


                ## Module Item
                array(
                    'type'      =>  'module',
                    'title'     =>  __('Template Name','cloudfw'),
                    'data'      =>  array(
                        array(
                            'type'      =>  'text',
                            'id'        =>  'composer_template_name',
                            'value'     =>  isset($_REQUEST['title']) ? $_REQUEST['title'] : NULL,
                            '_class'    =>  'input_200 bold'
                        ),
                    
                        ## Module Item
                        array(
                            'type'      =>  'submit',
                            'id'        =>  'cloudfw-composer-template-save-button',
                            'text'      =>  __('Save','cloudfw'),
                            'layout'    =>  'onlybutton',
                        ),
                    ),

                ), 

            

        );


        echo cloudfw_render_page( $form );


       
    ?>

</div>