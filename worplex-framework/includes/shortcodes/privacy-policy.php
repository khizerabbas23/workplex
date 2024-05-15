<?php
function wrkplx_prvplcy() {
    vc_map(
        array(
            'name' => __('Privacy Policy'),
            'base' => 'wrkplx_prvplcy',
            'category' => __('Workplex'),
            'params' => array(
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Title '),
                    'param_name' => 'title',
                ),
                array(
                    'type' => 'textarea',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Description '),
                    'param_name' => 'description',
                ),
            )
        )
    );
}
add_action('vc_before_init', 'wrkplx_prvplcy');


function wrkplx_prvplcy_frontend($atts, $content){

    $atts = shortcode_atts(
        array(
            'title' => '',
            'description' => '',
),
   $atts,'wrkplx_prvplcy'
);
  
    $title = isset($atts['title']) ? $atts['title'] : '';
    $description = isset($atts['description']) ? $atts['description'] : '';
  
    $output = '';

    $output.='<div class="row align-items-center justify-content-between">					
						<div class="col-xl-11 col-lg-12 col-md-6 col-sm-12">
							<div class="abt_caption">';
							if(!empty($title)){
								$output.='<h2 class="ft-medium mb-4">'.$title.'</h2>';
								}
						if(!empty($description)){
								$output.='<p class="mb-4">'.nl2br($description).'</p>';
						}
							$output.='</div>
						</div>						
					</div>';
    return $output;
}
add_shortcode('wrkplx_prvplcy', 'wrkplx_prvplcy_frontend');