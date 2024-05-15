<?php
function partners_section() {
    vc_map(
        array(
            'name' => __('Partnes'),
            'base' => 'partners_section',
            'category' => __('Workplex'),
            'params' => array(
                array(
					'type' => 'dropdown',
					'holder' => 'div',
					'class' => '',
					'heading' => __( 'Partners Style', 'workplex' ),
					'param_name' => 'partner_style',
					'description' => __('Select Partner Style ', 'workplex'),
					'value' => array(
						'Select Style' => '',
						'Style 1' => 'home_style_one',	
						'Style 2' => 'home_style_two',	                      
					),
				),
                array(
                    'type' => 'textfield',
                    'value' => '',
                    'heading' => 'Title',
                    'param_name' => 'title',
                    'value' => ''
                ),
                array(
                    'type' => 'textfield',
                    'value' => '',
                    'heading' => 'Heading ',
                    'param_name' => 'before_heading',
                    'value' => ''
                ),
                array(
                    'type' => 'textfield',
                    'value' => '',
                    'heading' => 'Colored Heading',
                    'param_name' => 'clr_heading',
                    'value' => ''
                ),
                array(
                    'type' => 'textfield',
                    'value' => '',
                    'heading' => 'Heading',
                    'param_name' => 'rem_heading',
                    'value' => ''
                ),
                array(
                    'type' => 'param_group',
                    'value' => '',
                    'param_name' => 'multi_logos',
                    'params' => array(
                        array(
                            'type' => 'worplex_browse_img',
                            'value' => '',
                            'heading' => 'Upload Images',
                            'param_name' => 'logo_img',
                            'value' => ''
                        ),
                        array(
                            'type' => 'textfield',
                            'value' => '',
                            'heading' => 'Images Url',
                            'param_name' => 'img_url',
                            'value' => ''
                        ),
                    )
                ),
            )
        )
    );
}
add_action('vc_before_init', 'partners_section');


function partners_section_frontend($atts, $content)
{

    $atts = shortcode_atts(
        array(

            'title' => '',
            'before_heading' => '',
            'clr_heading' => '',
            'rem_heading' => '',

            'partner_style' => '',
            'multi_logos' => '',
),
   $atts,
 'partners_section'
);

    $im_app_services = vc_param_group_parse_atts($atts['title']);

    $title = isset($atts['title']) ? $atts['title'] : '';
    $before_heading = isset($atts['before_heading']) ? $atts['before_heading'] : '';
    $titclr_headingle = isset($atts['clr_heading']) ? $atts['clr_heading'] : '';
    $rem_heading = isset($atts['rem_heading']) ? $atts['rem_heading'] : '';
    $partner_style = isset($atts['partner_style']) ? $atts['partner_style'] : '';

    $output = '';

    if($atts['partner_style'] == 'home_style_one'){

    $output .= '<div class="row justify-content-center">
            <div class="col-xl-5 col-lg-7 col-md-9 col-sm-12">
                <div class="sec_title position-relative text-center mb-5">
                    <h6 class="text-muted mb-0">'.$title.'</h6>
                    <h2 class="ft-bold">'.$before_heading.' <span class="theme-cl">'.$titclr_headingle.'</span> '.$rem_heading.'</h2>
                </div>
            </div>
        </div> 
        <div class="row justify-content-center">';

    $l_teamlist = vc_param_group_parse_atts($atts['multi_logos']);

    foreach ($l_teamlist as $key => $value) {
        
    $logo_img = ($value["logo_img"]);
    $img_url = isset($value['img_url']) ? $value['img_url'] : '';

  $output .= '<div class="col-xl-2 col-lg-2 col-md-3 col-sm-4 col-6">
  <div class="empl-thumb text-center px-3 py-4">
      <a href="'.$img_url.'">
      <img href="" src="'.$logo_img.'" class="img-fluid mx-auto" alt="" />
      </a>
  </div>
</div>';
    }
    $output .= '</div>';
    
    }
    return $output;

}
add_shortcode('partners_section', 'partners_section_frontend');