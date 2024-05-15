<?php
// Home Startup Recent Portfolio
function browse_info_tech() {
    vc_map(
        array(
            'name' => __('Browse Categories'),
            'base' => 'browse_info_tech',
            'category' => __('Workplex'),
            'params' => array()
        )
    );
}
add_action('vc_before_init', 'browse_info_tech');

function browse_info_tech_frontend($atts, $content) {
 
    $atts = shortcode_atts(
        array(),
        $atts, 'browse_info_tech'
    );

    $output = '';

    $custom_plan_price = isset($atts['nb_medicaltitle']) && !empty($atts['nb_medicaltitle']) ? $atts['nb_medicaltitle'] : '';

    $output .= '<section class="middle bg-light">
    <div class="container">';

    $parent_categories_limit = 4; // Set the default limit of parent categories

    $categories = get_terms([
        'taxonomy' => 'job_category',
        'hide_empty' => false,
        'parent' => 0, // Display only parent categories
    ]);

    $total_child_categories = 0;

    // Count the total number of child categories
    foreach ($categories as $category) {
        $child_categories = get_terms([
            'taxonomy' => 'job_category',
            'hide_empty' => false,
            'parent' => $category->term_id, // Child categories of the parent category
        ]);
        $total_child_categories += count($child_categories);
    }

    // Calculate the dynamic limit of parent categories based on the total child categories
    if ($total_child_categories > 0) {
        $parent_categories_limit = ceil($total_child_categories / $parent_categories_limit);
    }

    // Iterate through each parent category
    $parent_category_counter = 0;
    foreach ($categories as $category) {
        $term_link = get_term_link($category);
        $image = get_template_directory_uri() . '/assets/img/c-9.png';

        $child_categories = get_terms([
            'taxonomy' => 'job_category',
            'hide_empty' => false,
            'parent' => $category->term_id, // Child categories of the parent category
        ]);

        // Display only if the parent category has child categories
        if (!empty($child_categories)) {
            $output .= '
            <div class="row align-items-start mb-5">
                <div class="col-xl-3 col-lg-4 col-md-4 col-sm-12 col-12">
                    <div class="d-block full-width mt-2">
                        <h3 class="ft-medium mb-0">' . $category->name . '</h3>
                    </div>
                </div>
                <div class="col-xl-9 col-lg-8 col-md-8 col-sm-12 col-12">
                    <div class="row g-4">';
                    
                    

            // Iterate through each child category
            foreach ($child_categories as $child_category) {
                
                
         $term_id = $child_category->term_id;
		$term_meta = get_term_meta($term_id, 'job_category_custom_fields', true);

		$cat_image = isset($term_meta['image']) ? $term_meta['image'] : '';
                
                
                $output .= '
                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                        <div class="d-block full-width px-4 py-4 bg-white rounded">
                            <div class="d-block full-width mb-1"><img src="'.$cat_image.'" class="img-fluid" width="45" alt="" /></div>
                            <h4 class="ft-medium mb-0 fs-md">' . $child_category->name . '</h4>
                            <p class="mb-3 p-0 lh-1">' . $child_category->count . ' '.esc_html__('Jobs', 'worplex-frame').'</p>
                            <a href="#" class="theme-cl ft-medium">'.esc_html__('Explore Jobs', 'worplex-frame').'<i class="lni lni-arrow-right-circle ms-1"></i></a>
                        </div>
                    </div>';
            }

            $output .= '
                    </div>
                </div>
            </div>';

            $parent_category_counter++;

            // Break the loop if the dynamic limit of parent categories is reached
            if ($parent_category_counter >= $parent_categories_limit) {
                break;
            }
        }
    }

    $output .= '</div>
               </section>';

    return $output;
}

add_shortcode('browse_info_tech', 'browse_info_tech_frontend');
