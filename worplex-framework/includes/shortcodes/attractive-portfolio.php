<?php
function create_and_build_your_portfolio()
{

    vc_map(

        array(
            'name' => __('Create and Build Your
            Attractive Profile'),
            'base' => 'create_and_build_your_portfolio',
            'category' => __('Workplex'),
            'params' => array(
                array(
					'type' => 'dropdown',
					'holder' => 'div',
					'class' => '',
					'heading' => __( 'Attractive Portfolio', 'workplex' ),
					'param_name' => 'attarctive_portfolio',
					'description' => __('Select Blog Column Style ', 'torneo'),
					'value' => array(
						'Select Style' => '',
						'Create  Attractive Profile' => 'create_attractive_portfolio',
						'Option One' => 'option_one',
						
					),
				   ),
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('About  Tag'),
                    'param_name' => 'about_tag',
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
             
             

                //group
                array(
                    'type' => 'param_group',
                    'value' => '',
                    'param_name' => 'attarctive_portfolio_multi',
                    'params' => array(
                        array(
                            'type' => 'textfield',
                            'holder' => 'div',
                            'class' => '',
                            'heading' => __('Number Of Jobs'),
                            'param_name' => 'number_of_jobs',
                        ),
                        array(
                            'type' => 'textfield',
                            'holder' => 'div',
                            'class' => '',
                            'heading' => __('Job Type'),
                            'param_name' => 'job_type',
                        ),
                        
                    )
                )
            ),
        )
    );
}
add_action('vc_before_init', 'create_and_build_your_portfolio');

//welcome Massage frontend
function create_and_build_your_portfolio_frontend($atts, $content)
{

    $atts = shortcode_atts(
        array(

            'attarctive_portfolio' => '',
            'about_tag' => '',
            'heading' => '',
            'image' => '',
            'desc' => '',
            'button_tag' => '',
            'button_url' => '',
            
            'attarctive_portfolio_multi' => '',

        ),
        $atts,
        'create_and_build_your_portfolio'
    );
    $im_app_services = vc_param_group_parse_atts($atts['attarctive_portfolio']);

    $attarctive_portfolio = isset($atts['attarctive_portfolio']) ? $atts['attarctive_portfolio'] : '';
    $about_tag = isset($atts['about_tag']) ? $atts['about_tag'] : '';
    $heading = isset($atts['heading']) ? $atts['heading'] : '';
    $desc = isset($atts['desc']) ? $atts['desc'] : '';
    $button_tag = isset($atts['button_tag']) ? $atts['button_tag'] : '';
    $button_url = isset($atts['button_url']) ? $atts['button_url'] : '';
    $image = $atts["image"];
    //$image = wp_get_attachment_image_src($atts["image"], 'full');

    $output = '';

    $custom_plan_price = isset($atts['nb_medicaltitle']) && !empty($atts['nb_medicaltitle']) ? $atts['nb_medicaltitle'] : '';

    if($atts['attarctive_portfolio'] == 'create_attractive_portfolio'){

    $output .= '			<section>
    <div class="container">
        
        <div class="row align-items-center justify-content-between">
            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                <div class="m-spaced">
                    <div class="position-relative">
                        <div class="mb-1"><span class="theme-bg-light theme-cl px-2 py-1 rounded">'.$about_tag.'</span></div>
                        <h2 class="ft-bold mb-3">'.$heading.'</h2>
                        <p class="mb-2">'.$desc.'</p>
                    </div>
                    <div class="position-relative row">';

    $l_teamlist = vc_param_group_parse_atts($atts['attarctive_portfolio_multi']);

    foreach ($l_teamlist as $key => $value) {

        $number_of_jobs = isset($value['number_of_jobs']) ? $value['number_of_jobs'] : '';
        $job_type = isset($value['job_type']) ? $value['job_type'] : '';


        $output .= '<div class="col-lg-4 col-md-4 col-4">
        <h3 class="ft-bold theme-cl mb-0">'.$number_of_jobs .'</h3>
        <p class="ft-medium">'. $job_type.'</p>
    </div>';
    }

    $output .= '<div class="col-lg-12 col-md-12 col-12 mt-3">
    <a href="'.$button_url.'" class="btn btn-md theme-bg-light rounded theme-cl hover-theme">'.$button_tag.'<i class="lni lni-arrow-right-circle ms-2"></i></a>
</div>
</div>
</div>
</div>

<div class="col-xl-5 col-lg-5 col-md-12 col-sm-12">
<div class="position-relative">
<img src="'.$image.'" class="img-fluid" alt="" />
</div>
</div>
</div>

</div>
</section> ';
    }elseif($atts['attarctive_portfolio'] == 'option_one'){       
        $output .= ' ';

        }
    return $output;

}
add_shortcode('create_and_build_your_portfolio', 'create_and_build_your_portfolio_frontend');