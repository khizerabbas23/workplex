<?php

function get_app_search_section()
{

    vc_map(

        array(
            'name' => __('Search App'),
            'base' => 'get_app_search_section',
            'category' => __('Workplex'),
            'params' => array(
                 
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Title'),
                    'param_name' => 'title',
                ),
                array(
                    'type' => 'textarea',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Heading '),
                    'param_name' => 'heading',
                ),
                array(
                    'type' => 'textarea',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Description'),
                    'param_name' => 'desc',
                ),
                array(
                    'type' => 'worplex_browse_img',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Main Image '),
                    'param_name' => 'mainimage',
                ),
                array(
                    'type' => 'worplex_browse_img',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Apple Store Image '),
                    'param_name' => 'apple_storeimg',
                ),
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Apple Store Url'),
                    'param_name' => 'applestoreurl',
                ),
                array(
                    'type' => 'worplex_browse_img',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('G+ Store Image '),
                    'param_name' => 'google_storeimg',
                ),
               
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Google Store Url '),
                    'param_name' => 'googlestoreurl',
                ),
            )
        )
    );
}
add_action('vc_before_init', 'get_app_search_section');

//welcome Massage frontend
function get_app_search_section_frontend($atts, $content)
{

    $atts = shortcode_atts(
        array(

            'title' => '',
            'title' => '',
            'heading' => '',
            'mainimage' => '',
            'apple_storeimg' => '',
            'google_storeimg' => '',
            'desc' => '',
            'applestoreurl' => '',
            'googlestoreurl' => '',
            
        ),
        $atts,
        'get_app_search_section'
    );
    $im_app_services = vc_param_group_parse_atts($atts['title']);

    $title = isset($atts['title']) ? $atts['title'] : '';
    $heading = isset($atts['heading']) ? $atts['heading'] : '';
    $desc = isset($atts['desc']) ? $atts['desc'] : '';
    $applestoreurl = isset($atts['applestoreurl']) ? $atts['applestoreurl'] : '';
    $googlestoreurl = isset($atts['googlestoreurl']) ? $atts['googlestoreurl'] : '';

    $mainimage = $atts["mainimage"];
    $apple_storeimg = $atts["apple_storeimg"];
    $google_storeimg = $atts["google_storeimg"];

    $output = '';

    $custom_plan_price = isset($atts['nb_medicaltitle']) && !empty($atts['nb_medicaltitle']) ? $atts['nb_medicaltitle'] : '';
 

    $output .= '<div class="row align-items-center">
						
    <div class="col-lg-6 col-md-12 col-sm-12 content-column">
        <div class="content_block_2 pe-3 py-4">
            <div class="content-box">
                <div class="sec-title light">
                    <p class="theme-cl px-3 py-1 rounded bg-light-success d-inline-flex">'.$title.'</p>
                    <h2 class="ft-bold">'.($heading).'</h2>
                </div>
                <div class="text">
                    <p>'.$desc.'</p>
                </div>
                <div class="btn-box clearfix mt-5">
                    <a href="'.$applestoreurl.'" class="download-btn play-store mb-1 d-inline-flex"><img src="'.$apple_storeimg.'" width="200" alt="" /></a>
                    <a href="'.$googlestoreurl.'" class="download-btn play-store ms-2 mb-1 d-inline-flex"><img src="'.$google_storeimg.'" width="200" alt="" /></a>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-6 col-md-12 col-sm-12 image-column">
        <div class="image-box">
            <figure class="image"><img src="'.$mainimage.'" class="img-fluid" alt=""></figure>
        </div>
    </div>
</div> ';
    
    return $output;

}
add_shortcode('get_app_search_section', 'get_app_search_section_frontend');