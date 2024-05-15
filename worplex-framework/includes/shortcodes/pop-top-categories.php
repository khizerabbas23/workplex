<?php
function pop_top_categories()
{
    vc_map(
        array(
            'name' => __('Popular Top Categories'),
            'base' => 'pop_top_categories',
            'category' => __('Workplex'),
            'params' => array(
                array(
                    'type' => 'dropdown',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Top Categories', 'workplex'),
                    'param_name' => 'pop_top_cate',
                    'description' => __('Select Top Category Style ', 'workplex'),
                    'value' => array(
                        'Select Style' => '',
                        'Top Category Style 1' => 'pop_top_categ',
                        'Top Category Style 2' => 'pop_top_listed_categ',
                    ),
                ),
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Title'),
                    'param_name' => 'title',
                ),
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Heading'),
                    'param_name' => 'heading',
                ),
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Color Word'),
                    'param_name' => 'color_word',
                ),
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Post Type'),
                    'param_name' => 'posttypename',
                ),
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Order By'),
                    'param_name' => 'orderby',
                ),
                array(
                    'type' => 'textarea',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Custom Taxonomy'),
                    'param_name' => 'cust_taxonomy',
                ),
                array(
                    'type' => 'textarea',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Number Of Post'),
                    'param_name' => 'numofpost',
                ),
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('All Category Label'),
                    'param_name' => 'ac_label',
                ),
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('All Category Url'),
                    'param_name' => 'ac_url',
                ),
            )
        )

    );
}
add_action('vc_before_init', 'pop_top_categories');

// popular category frontend
function pop_top_categories_frontend($atts, $content)
{
    $atts = shortcode_atts(
        array(
            'title' => '',
            'heading' => '',
            'color_word' => '',
            'pop_top_cate' => '',
            'posttypename' => '',
            'orderby' => '',
            'cust_taxonomy' => '',
            'numofpost' => '',
            'ac_label' => '',
            'ac_url' => '',
        ),
        $atts,
        'pop_top_categories'
    );
    
    global $worplex_framework_options;

        $select_job_page = isset($worplex_framework_options['job_select_page']) ? $worplex_framework_options['job_select_page'] : '';

        $job_page_id = worplex_get_page_id_from_name($select_job_page);

        $job_page_url = '';
        if ($job_page_id > 0) {
            $job_page_url = get_permalink($job_page_id);
        }

    $output = '';

    $pop_top_cate = isset($atts['pop_top_cate']) ? $atts['pop_top_cate'] : '';
    $title = isset($atts['title']) ? $atts['title'] : '';
    $heading = isset($atts['heading']) ? $atts['heading'] : '';
    $color_word = isset($atts['color_word']) ? $atts['color_word'] : '';
    $ac_label = isset($atts['ac_label']) ? $atts['ac_label'] : '';
    $ac_url = isset($atts['ac_url']) ? $atts['ac_url'] : '';

    $custom_plan_price = isset($atts['nb_medicaltitle']) && !empty($atts['nb_medicaltitle']) ? $atts['nb_medicaltitle'] : '';

    if ($atts['pop_top_cate'] == 'pop_top_categ') {
        $output .= '<div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                    <div class="sec_title position-relative text-center mb-5">
                        <h6 class="text-muted mb-0">'.$title.'</h6>
                        <h2 class="ft-bold">'.$heading.' <span class="theme-cl">'.$color_word.'</span></h2>
                    </div>
                </div>
            </div>
            <div class="row align-items-center g-xl-4 g-lg-3 g-md-3 g-3">';

        // Get 12 categories
        $categories =  get_terms(array(
            'taxonomy' => 'job_category',
            'hide_empty' => false,
            'number' => 12, // Limit the number of categories to 12
        ));

        // Iterate through each term
        foreach ($categories as $category) {
            $term_link = get_term_link($category);
            
             $term_id = $category->term_id;
             
		$term_meta = get_term_meta($term_id, 'job_category_custom_fields', true);
        $cat_icon = isset($term_meta['icon']) ? $term_meta['icon'] : '';    
		$cat_image = isset($term_meta['image']) ? $term_meta['image'] : '';

            $output .= '<div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 col-6">
                <div class="cats-wrap text-center">
                    <a href="'.add_query_arg(array('job_category' => $category->slug), $job_page_url).'" class="cats-box d-block rounded bg-white border px-2 py-4">
                        <div class="text-center mb-2 mx-auto position-relative d-inline-flex align-items-center justify-content-center p-3 theme-bg-light circle">
                        <i class="'.$cat_icon.' fs-lg theme-cl"></i></div>
                        <div class="cats-box-caption">
                            <h4 class="fs-md mb-0 ft-medium m-catrio">'.$category->name.'</h4>
                            <span class="text-muted">'.$category->count.' '.esc_html('Jobs','worplex').'</span>
                        </div>
                    </a>
                </div>
            </div>';
        }

        $output .= '
            </div>
            <div class="row justify-content-center">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 mt-5">
                    <div class="position-relative text-center">
                        <a href="'.$ac_url.'" class="btn btn-md bg-dark rounded text-light hover-theme">'.$ac_label.'<i class="lni lni-arrow-right-circle ms-2"></i></a>
                    </div>
                </div>
            </div>
        </div>';
    }
    elseif ($atts['pop_top_cate'] == 'pop_top_listed_categ') {
        $output .= '<div class="row justify-content-center">
            <div class="col-xl-5 col-lg-7 col-md-9 col-sm-12">
                <div class="sec_title position-relative text-center mb-5">
                    <h6 class="text-light mb-0">Current Openings</h6>
                    <h2 class="ft-bold text-light">We Have Worked with 10,000+ Trusted Companies</h2>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-xl-10 col-lg-11 col-md-12 col-sm-12">
                <div class="row justify-content-center g-xl-4 g-lg-3 g-md-3 g-3">';

        // Get 12 categories
        $categories =  get_terms(array(
            'taxonomy' => 'job_category',
            'hide_empty' => false,
            'number' => 7, // Limit the number of categories to 12
        ));

        // Iterate through each term
        foreach ($categories as $category) {
            $term_link = get_term_link($category);
            
            
             $term_id = $category->term_id;
             
		$term_meta = get_term_meta($term_id, 'job_category_custom_fields', true);
        $cat_icon = isset($term_meta['icon']) ? $term_meta['icon'] : '';    
		$cat_image = isset($term_meta['image']) ? $term_meta['image'] : '';

            $output .= '<div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-12">
                <div class="cats-wrap text-left">
                    <a href="'.$term_link.'" class="cats-box rounded bg-white d-flex align-items-center px-2 py-3">
                        <div class="text-center"><img src="'.$cat_image.'" class="img-fluid" width="55" alt=""></div>
                        <div class="cats-box-caption px-2">
                            <h4 class="fs-md mb-0 ft-medium">'.$category->name.'</h4>
                            <span class="text-muted">'.$category->count.' Jobs</span>
                        </div>
                    </a>
                </div>
            </div>';
        }

        $output .= '</div>
            </div>
        </div>
        <div class="ht-50"></div>';
    } 

    return $output;
}
add_shortcode('pop_top_categories', 'pop_top_categories_frontend');
