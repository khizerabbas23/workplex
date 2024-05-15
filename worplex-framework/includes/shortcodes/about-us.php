<?php
function every_thing_you_need()
{

    vc_map(

        array(
            'name' => __('About Us  Page'),
            'base' => 'every_thing_you_need',
            'category' => __('Workplex'),
            'params' => array(
                array(
					'type' => 'dropdown',
					'holder' => 'div',
					'class' => '',
					'heading' => __( 'We Have Everything You Need', 'workplex' ),
					'param_name' => 'attarctive_portfolio',
					'description' => __('Select Blog Column Style ', 'torneo'),
					'value' => array(
						'Select Style' => '',
						'We Have Everything You Need' => 'create_attractive_portfolio',
						'Justin Lisiakir' => 'justin_lisiaker',
						
					),
				   ),
               
                array(
                    'type' => 'textarea',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Heading '),
                    'param_name' => 'heading',
                ),
                array(
                    'type' => 'worplex_browse_img',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Image '),
                    'param_name' => 'image',
                ),
                array(
                    'type' => 'textarea',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Description'),
                    'param_name' => 'desc',
                ),
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Button Tag '),
                    'param_name' => 'button_tag',
                ),
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Button Url '),
                    'param_name' => 'button_url',
                ),
             
             

            )
            )
            );   
}
add_action('vc_before_init', 'every_thing_you_need');

//welcome Massage frontend
function every_thing_you_need_frontend($atts, $content)
{

    $atts = shortcode_atts(
        array(

            'attarctive_portfolio' => '',
            'heading' => '',
            'image' => '',
            'desc' => '',
            'button_tag' => '',
            'button_url' => '',
            
 

        ),
        $atts,
        'every_thing_you_need'
    );
    $im_app_services = vc_param_group_parse_atts($atts['attarctive_portfolio']);

    $heading = isset($atts['heading']) ? $atts['heading'] : '';
    $desc = isset($atts['desc']) ? $atts['desc'] : '';
    $button_tag = isset($atts['button_tag']) ? $atts['button_tag'] : '';
    $button_url = isset($atts['button_url']) ? $atts['button_url'] : '';
$image = $atts["image"];
    //$image = wp_get_attachment_image_src($atts["image"], 'full');

    $output = '';

    $custom_plan_price = isset($atts['nb_medicaltitle']) && !empty($atts['nb_medicaltitle']) ? $atts['nb_medicaltitle'] : '';

    if($atts['attarctive_portfolio'] == 'create_attractive_portfolio'){

    $output .= '						<section class="middle">
    <div class="container">
        <div class="row align-items-center justify-content-between">
        
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                <div class="abt_caption">
                    <h2 class="ft-medium mb-4">'.$heading .'</h2>
                    <p class="mb-4">'.$desc.'</p>
                    <div class="form-group mt-4">
                        <a href="'.$button_url .'" class="btn theme-bg text-white">'. $button_tag.'</a>
                    </div>
                </div>
            </div>
            
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                <div class="abt_caption">
                    <img src="'. $image.'" class="img-fluid rounded" alt="" />
                </div>
            </div>
            
        </div>
    </div>
</section>';
    }elseif($atts['attarctive_portfolio'] == 'justin_lisiaker'){       
        $output .= ' 
        <section class="middle">
				<div class="container">
					<div class="row align-items-center justify-content-between">
						
						<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
							<div class="abt_caption">
								<img src="'. $image.'" class="img-fluid rounded" alt="" />
							</div>
						</div>
						
						<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
							<div class="abt_caption">
								<h2 class="ft-medium mb-4">'.$heading .'</h2>
								<p class="mb-4">'.$desc.'</p>
								<div class="form-group mt-4">
									<a href="'.$button_url .'" class="btn theme-bg text-white">'. $button_tag.'</a>
								</div>
							</div>
						</div>
						
					</div>
				</div>
			</section>';

        }
    return $output;

}
add_shortcode('every_thing_you_need', 'every_thing_you_need_frontend');