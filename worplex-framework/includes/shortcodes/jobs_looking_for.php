<?php

function looking_for_job_detail()
{

    vc_map(

        array(
            'name' => __('Get All The Jobs Details
            Your Looking For'),
            'base' => 'looking_for_job_detail',
            'category' => __('Workplex'),
            'params' => array(
                array(
					'type' => 'dropdown',
					'holder' => 'div',
					'class' => '',
					'heading' => __( 'JObs Details', 'workplex' ),
					'param_name' => 'jobs_detail',
					'description' => __('Select Blog Column Style ', 'workplex'),
					'value' => array(
						'Select Style' => '',
						'Get All The Jobs Details
                        ' => 'get_all_jobs_details',
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
                    'param_name' => 'looking_job_multi',
                    'params' => array(
                    
                        array(
                            'type' => 'textfield',
                            'holder' => 'div',
                            'class' => '',
                            'heading' => __('Feature Jobs'),
                            'param_name' => 'feature_jobs',
                        ),
                        
                    )
                )
            ),
        )
    );
}
add_action('vc_before_init', 'looking_for_job_detail');

//welcome Massage frontend
function looking_for_job_detail_frontend($atts, $content)
{

    $atts = shortcode_atts(
        array(

            'jobs_detail' => '',
            'about_tag' => '',
            'heading' => '',
            'image' => '',
            'desc' => '',
            'button_tag' => '',
            'button_url' => '',
            
            'looking_job_multi' => '',

        ),
        $atts,
        'looking_for_job_detail'
    );
    $im_app_services = vc_param_group_parse_atts($atts['jobs_detail']);

    $jobs_detail = isset($atts['jobs_detail']) ? $atts['jobs_detail'] : '';
    $about_tag = isset($atts['about_tag']) ? $atts['about_tag'] : '';
    $heading = isset($atts['heading']) ? $atts['heading'] : '';
    $desc = isset($atts['desc']) ? $atts['desc'] : '';
    $button_tag = isset($atts['button_tag']) ? $atts['button_tag'] : '';
    $button_url = isset($atts['button_url']) ? $atts['button_url'] : '';

    $image = $atts["image"];

    $output = '';

    $custom_plan_price = isset($atts['nb_medicaltitle']) && !empty($atts['nb_medicaltitle']) ? $atts['nb_medicaltitle'] : '';

    if($atts['jobs_detail'] == 'get_all_jobs_details'){

    $output .= '			<section class="pt-0">
    <div class="container">
        
        <div class="row align-items-center justify-content-between">
        
            <div class="col-xl-5 col-lg-5 col-md-12 col-sm-12">
                <div class="position-relative">
                    <img src="'.$image.'" class="img-fluid" alt="" />
                </div>
            </div>
            
            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">	
                <div class="m-spaced">
                    <div class="position-relative">
                        <div class="mb-1"><span class="theme-bg-light theme-cl px-2 py-1 rounded">'.$about_tag.'</span></div>
                        <h2 class="ft-bold mb-3">'. $heading.'</h2>
                        <p class="mb-3">'.$desc .'</p>
                    </div>
                    <div class="position-relative row">
                        <div class="col-lg-12 col-md-12 col-12">';

    $l_teamlist = vc_param_group_parse_atts($atts['looking_job_multi']);

    foreach ($l_teamlist as $key => $value) {

        $feature_jobs = isset($value['feature_jobs']) ? $value['feature_jobs'] : '';


        $output .= '<div class="mb-3 me-4 ml-lg-0 mr-lg-4">
        <div class="d-flex align-items-center">
          <div class="rounded-circle bg-light-success theme-cl p-2 small d-flex align-items-center justify-content-center">
            <i class="fas fa-check"></i>
          </div>
          <h6 class="mb-0 ms-3">'.$feature_jobs.'</h6>
        </div>
    </div>';
    }

    $output .= '
    </div>
    <div class="col-lg-12 col-md-12 col-12 mt-4">
        <a href="'.$button_url.'" class="btn btn-md theme-bg rounded text-white hover-theme">'.$button_tag.'<i class="lni lni-arrow-right-circle ms-2"></i></a>
    </div>
</div>
</div>
</div>

</div>

</div>
</section>    ';
    }elseif($atts['jobs_detail'] == 'option_one'){       
        $output .= ' ';

        }
    return $output;

}
add_shortcode('looking_for_job_detail', 'looking_for_job_detail_frontend');