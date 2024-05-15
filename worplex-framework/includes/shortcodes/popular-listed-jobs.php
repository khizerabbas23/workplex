<?php
function project_job_listed()
{

    vc_map(

        array(
            'name' => __('Project Job Listed'),
            'base' => 'project_job_listed',
            'category' => __('Workplex'),
            'params' => array(

                array(
					'type' => 'dropdown',
					'holder' => 'div',
					'class' => '',
					'heading' => __( 'Job Listing', 'workplex' ),
					'param_name' => 'listed_job_cat',
					'description' => __('Select Blog Column Style ', 'workplex'),

					'value' => array(
						'Select Style' => '',
						'Style View 1' => 'view_one',
						'Style View 2' => 'view_two',
						'Style View 3' => 'view_three',
						'Style View 4' => 'view_four',
						'Style View 5' => 'view_five',
						'Style View 6' => 'view_six',
					
						
					),
				   ),
				    array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Tranding Tag'),
                    'param_name' => 'tag_tranding',
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
                    'heading' => __('Color Heading'),
                    'param_name' => 'color_heading',
                      'dependency' => array(
                        'element' => 'listed_job_cat',
                        'value' => array('view_four','view_five','view_six')
                    ),
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
                    'heading' => __('Taxonomy'),
                    'param_name' => 'taxonomy',
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
                    'heading' => __('Button Tag'),
                    'param_name' => 'button_tag',
                ),
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Button  Url'),
                    'param_name' => 'butoon_tag_url',
                ),
            )
        )

    );
}
add_action('vc_before_init', 'project_job_listed');

// popular category frontend
function project_job_listed_frontend($atts, $content)
{

    $atts = shortcode_atts(
        array(

            'tag_tranding' => '',
            'heading' => '',
            'color_heading' => '',
            'listed_job_cat' => '',
            'posttypename' => '',
            'orderby' => '',
            'taxonomy' => '',
            'numofpost' => '',
            'button_tag' => '',
            'butoon_tag_url' => '',

        ),
        $atts,
        'project_job_listed'
    );

    $output = '';

$listed_job_cat = isset($atts['listed_job_cat']) ? $atts['listed_job_cat'] : '';
$tag_tranding  = isset($atts['tag_tranding']) ? $atts['tag_tranding'] : '';
$color_heading  = isset($atts['color_heading']) ? $atts['color_heading'] : '';
$heading  = isset($atts['heading']) ? $atts['heading'] : '';
$button_tag  = isset($atts['button_tag']) ? $atts['button_tag'] : '';
$butoon_tag_url  = isset($atts['butoon_tag_url']) ? $atts['butoon_tag_url'] : '';

    $custom_plan_price = isset($atts['nb_medicaltitle']) && !empty($atts['nb_medicaltitle']) ? $atts['nb_medicaltitle'] : '';

    if($atts['listed_job_cat'] == 'view_one'){

    $output .= '			
				
				
					<div class="row justify-content-center">
						<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
							<div class="sec_title position-relative text-center mb-5">
								<h6 class="text-muted mb-0">'.$tag_tranding.'</h6>
								<h2 class="ft-bold">'.$heading.'</h2>
							</div>
						</div>
					</div>
					
					<!-- row -->
					<div class="row align-items-center g-xl-3 g-lg-3 g-md-3 g-3">';

    $numofpost = isset($atts['numofpost']) ? $atts['numofpost'] : '';
    $taxonomy = isset($atts['taxonomy']) ? $atts['taxonomy'] : '';
    $orderby = isset($atts['orderby']) ? $atts['orderby'] : '';
    $posttypename = isset($atts['posttypename']) ? $atts['posttypename'] : '';

    $args = array(
        'post_type' => 'jobs',
        'post_status' => 'publish',
        'posts_per_page' => $numofpost,
        
        'order' => 'DESC',
        'orderby' => $orderby,
 
    );

   $query = new WP_Query($args);
    // Check that we have query results.
    if ($query->have_posts()) {

        // Start looping over the query results.
        while ($query->have_posts()) {

            $query->the_post();
            // dispaly the post content here
            $post = get_post();
            $postid = $post->ID;

            $title = get_the_title($postid);
            $permalinkget = get_the_permalink($postid);
           
           
            $posted = get_the_time('U');
				$minut =  human_time_diff($posted,current_time( 'U' )). "";

$job_type = get_post_meta($post->ID, 'worplex_field_job_type', true);
                $location = worplex_post_location_str($post->ID);
                
                $jobtype_ar = worplex_job_type_ret_str($job_type);
                $job_type_label = isset($jobtype_ar['title']) ? $jobtype_ar['title'] : '';
                $job_type_clor = isset($jobtype_ar['color']) ? $jobtype_ar['color'] : '';
                $job_type_bgclor = isset($jobtype_ar['bg_color']) ? $jobtype_ar['bg_color'] : '';
   
 $terms = get_the_terms($postid, 'job_skill'); 
if (empty($terms)) {
    $terms = array();
}
                         $total_lenght = count($terms);
                         
                        
                        $remaining_length = 0;
                        if($total_lenght > 5){
                            $remaining_length = 5 - $total_lenght;  // 6
                        }
        
            $image = wp_get_attachment_image_src(get_post_thumbnail_id($postid), 'single-post-thumbnail');
            $output .= '

          <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12">
							<div class="job_grid border rounded ">
								<div class="position-absolute ab-left"><button type="button" class="p-3 border circle d-flex align-items-center justify-content-center bg-white text-gray"><i class="lni lni-heart-filled position-absolute snackbar-wishlist"></i></button></div>
								<div class="position-absolute ab-right" style="background:'.$job_type_bgclor.';"><span style="color:'.$job_type_clor.';" class="medium theme-bg-red px-2 py-1 rounded">'.$job_type_label .'</span></div>
								<div class="job_grid_thumb mb-2 pt-5 px-3">
									<a href="'.$permalinkget.'" class="d-block text-center m-auto"><img src="'.$image[0].'" class="img-fluid" width="70" alt="" /></a>
								</div>
								<div class="job_grid_caption text-center pb-3 px-3">
									<h4 class="mb-0 ft-medium medium"><a href="'.$permalinkget.'" class="text-dark fs-md">'.$title.'</a></h4>
									<div class="jbl_location"><i class="lni lni-map-marker me-1"></i><span>'.$location.'</span></div>
								</div>
								<div class="job_grid_footer pb-4 px-3">
									<ul class="p-0 skills_tag text-center">';
                                
                                $coutner = 0;
                                    foreach($terms as $term){
                                        $coutner++;
                                       
                                   $current_term_link = get_term_link( $term->slug, 'job_skill' );
                                          $output.= '<li><span class="px-2 py-1 medium skill-bg rounded text-skill"><a href="'.$current_term_link.'" >'.$term->name.'</a></span></li>';
                                          if($coutner > 4){
										$output .= '<li><span class="px-2 py-1 medium theme-bg rounded text-light">+'.$remaining_length.' More</span></li>';
                                            break;
                                        } 
                                    }

                            $output.='        
										
									</ul>
								</div>
							</div>
						</div>';

        }
    }
     // Restore original post data.
        wp_reset_postdata();
            $output .= '
<div class="row justify-content-center">
						<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 mt-5">
							<div class="position-relative text-center">
								<a href="'.$butoon_tag_url.'" class="btn btn-md theme-bg rounded text-white hover-theme">'.$button_tag.'<i class="lni lni-arrow-right-circle ms-2"></i></a>
							</div>
						</div>
					</div>
                    </div>
			';
			 return $output;
    }elseif($atts['listed_job_cat'] == 'view_two'){
    $output .= ' 		
    <div class="row justify-content-center">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
        <div class="sec_title position-relative text-center mb-5">
            <h6 class="text-muted mb-0">'.$tag_tranding.'</h6>
            <h2 class="ft-bold">'.$heading.'</h2>
        </div>
    </div>
</div>

<div class="row align-items-center g-xl-3 g-lg-3 g-md-3 g-3">';

$numofpost = isset($atts['numofpost']) ? $atts['numofpost'] : '';
$taxonomy = isset($atts['taxonomy']) ? $atts['taxonomy'] : '';
$orderby = isset($atts['orderby']) ? $atts['orderby'] : '';
$posttypename = isset($atts['posttypename']) ? $atts['posttypename'] : '';

$args = array(
'post_type' => 'jobs',
'post_status' => 'publish',
'posts_per_page' => $numofpost,

'order' => 'DESC',
'orderby' => $orderby,

);

$query = new WP_Query($args);
// Check that we have query results.
if ($query->have_posts()) {

// Start looping over the query results.
while ($query->have_posts()) {

$query->the_post();
// dispaly the post content here
$post = get_post();
$postid = $post->ID;

$title = get_the_title($postid);
$permalinkget = get_the_permalink($postid);


// 
$current_user = wp_get_current_user();
$comment = sprintf(esc_html__('%s Comment', 'adhividayam'), get_comments_number($postid));

$date = date('M d Y');

$posted = get_the_time('U');
$minut =  human_time_diff($posted,current_time( 'U' )). "";

$time_tag = get_post_meta($post->ID, 'worplex_field_time_tag', true);
$backgropund_color = get_post_meta($post->ID, 'worplex_field_background_color', true);
$font_color = get_post_meta($post->ID, 'worplex_field_font_color', true);
$resorce_tag = get_post_meta($post->ID, 'worplex_field_resorce_tag', true);
$salery_type = get_post_meta($post->ID, 'worplex_field_salary_unit', true);
$min_salery = get_post_meta($post->ID, 'worplex_field_min_salary', true);
$max_salery = get_post_meta($post->ID, 'worplex_field_max_salary', true);
$vocansies = get_post_meta($post->ID, 'worplex_field_vocansies', true);

$job_type = get_post_meta($post->ID, 'worplex_field_job_type', true);
                $location = worplex_post_location_str($post->ID);
                
                $jobtype_ar = worplex_job_type_ret_str($job_type);
                $job_type_label = isset($jobtype_ar['title']) ? $jobtype_ar['title'] : '';
                $job_type_clor = isset($jobtype_ar['color']) ? $jobtype_ar['color'] : '';
                $job_type_bgclor = isset($jobtype_ar['bg_color']) ? $jobtype_ar['bg_color'] : '';

$image = wp_get_attachment_image_src(get_post_thumbnail_id($postid), 'single-post-thumbnail');
$output .= '

                        <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12">
							<div class="job_grid border rounded ">
								<div class="position-absolute ab-left"><button type="button" class="p-3 border circle d-flex align-items-center justify-content-center bg-white text-gray"><i class="lni lni-heart-filled position-absolute snackbar-wishlist"></i></button></div>
								<div class="position-absolute ab-right" style="background:'.$job_type_bgclor.';"><span style="color:'.$job_type_clor.';" class="medium theme-cl theme-bg-light px-2 py-1 rounded">'.$job_type_label.'</span></div>
								<div class="job_grid_thumb mb-3 pt-5 px-3">
									<a href="'.$permalinkget.'" class="d-block text-center m-auto"><img src="'.$image[0].'" class="img-fluid" width="70" alt="" /></a>
								</div>
								<div class="job_grid_caption text-center pb-5 px-3">
									<h6 class="mb-0 lh-1 ft-medium medium"><a href="'.$permalinkget.'" class="text-muted medium">'.$resorce_tag.'</a></h6>
									<h4 class="mb-0 ft-medium medium"><a href="'.$permalinkget.'" class="text-dark fs-md">'.$title.'</a></h4>
									<div class="jbl_location"><i class="lni lni-map-marker me-1"></i><span>'.$location.'</span></div>
								</div>
								<div class="job_grid_footer pb-4 px-3 d-flex align-items-center justify-content-between">
									<div class="df-1 text-muted"><i class="lni lni-wallet me-1"></i>'.$min_salery .'$ - '.$max_salery .'$  '.$salery_type.'.</div>
									<div class="df-1 text-muted"><i class="lni lni-timer me-1"></i>'.$minut.' ago</div>
								</div>
							</div>
						</div>';
               


}
}
// Restore original post data.
wp_reset_postdata();
$output .= '
</div>
<div class="row justify-content-center">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 mt-5">
            <div class="position-relative text-center">
                <a href="'.$butoon_tag_url.'" class="btn btn-md theme-bg rounded text-white hover-theme">'.esc_html__("Apply Job", "worplex-frame").'<i class="lni lni-arrow-right-circle ms-2"></i></a>
            </div>
        </div>
    </div>
</div>

';
return $output;
         }
         elseif($atts['listed_job_cat'] == 'view_three'){
    $output .= ' 		
	<div class="row justify-content-center">
						<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
							<div class="sec_title position-relative text-center mb-5">
								<h6 class="text-muted mb-0">'.$tag_tranding.'</h6>
								<h2 class="ft-bold">'.$heading.'</h2>
							</div>
						</div>
					</div>
					
					<!-- row -->
					<div class="row align-items-center g-xl-4 g-lg-3 g-md-3 g-3">';

$numofpost = isset($atts['numofpost']) ? $atts['numofpost'] : '';
$taxonomy = isset($atts['taxonomy']) ? $atts['taxonomy'] : '';
$orderby = isset($atts['orderby']) ? $atts['orderby'] : '';
$posttypename = isset($atts['posttypename']) ? $atts['posttypename'] : '';

$args = array(
'post_type' => 'jobs',
'post_status' => 'publish',
'posts_per_page' => $numofpost,

'order' => 'DESC',
'orderby' => $orderby,

);

$query = new WP_Query($args);
// Check that we have query results.
if ($query->have_posts()) {

// Start looping over the query results.
while ($query->have_posts()) {

$query->the_post();
// dispaly the post content here
$post = get_post();
$postid = $post->ID;

$title = get_the_title($postid);
$permalinkget = get_the_permalink($postid);

// 
$current_user = wp_get_current_user();
$comment = sprintf(esc_html__('%s Comment', 'adhividayam'), get_comments_number($postid));

$date = date('M d Y');

$posted = get_the_time('U');
$minut =  human_time_diff($posted,current_time( 'U' )). "";

$time_tag = get_post_meta($post->ID, 'worplex_field_time_tag', true);
$backgropund_color = get_post_meta($post->ID, 'worplex_field_background_color', true);
$font_color = get_post_meta($post->ID, 'worplex_field_font_color', true);
$resorce_tag = get_post_meta($post->ID, 'worplex_field_resorce_tag', true);
$salery_type = get_post_meta($post->ID, 'worplex_field_salary_unit', true);
$min_salery = get_post_meta($post->ID, 'worplex_field_min_salary', true);
$max_salery = get_post_meta($post->ID, 'worplex_field_max_salary', true);
$vocansies = get_post_meta($post->ID, 'worplex_field_vocansies', true);

$job_type = get_post_meta($post->ID, 'worplex_field_job_type', true);
                $location = worplex_post_location_str($post->ID);
                
                $jobtype_ar = worplex_job_type_ret_str($job_type);
                $job_type_label = isset($jobtype_ar['title']) ? $jobtype_ar['title'] : '';
                $job_type_clor = isset($jobtype_ar['color']) ? $jobtype_ar['color'] : '';
                $job_type_bgclor = isset($jobtype_ar['bg_color']) ? $jobtype_ar['bg_color'] : '';


$image = wp_get_attachment_image_src(get_post_thumbnail_id($postid), 'single-post-thumbnail');
$output .= '

<div class="col-xl-3 col-lg-4 col-md-6 col-sm-12">
							<div class="job_grid border rounded ">
								<div class="position-absolute ab-left"><button type="button" class="p-3 border circle d-flex align-items-center justify-content-center bg-white text-gray"><i class="lni lni-heart-filled position-absolute snackbar-wishlist"></i></button></div>
								<div class="position-absolute ab-right" style="background:'.$job_type_bgclor.';"><span style="color:'.$job_type_clor.';" class="medium theme-cl theme-bg-light px-2 py-1 rounded">'.$job_type_label .'</span></div>
								<div class="job_grid_thumb mb-2 pt-4 px-3">
									<a href="'.$permalinkget.'" class="d-block text-center m-auto"><img src="'.$image[0].'" class="img-fluid" width="70" alt="" /></a>
								</div>
								<div class="job_grid_caption text-center pb-3 px-3">
									<h4 class="mb-0 ft-medium medium"><a href="'.$permalinkget.'" class="text-dark fs-md">'.$title.'</a></h4>
									<div class="jbl_location"><i class="lni lni-map-marker me-1"></i><span>'.$location.'</span></div>
								</div>
								<div class="job_grid_footer pt-2 pb-4 px-3 d-flex align-items-center justify-content-between">
									<div class="row">
										<div class="df-1 text-muted col-6 mb-2"><i class="lni lni-briefcase me-1"></i>'.$job_type_label .'</div>
										<div class="df-1 text-muted col-6 mb-2"><i class="lni lni-wallet me-1"></i>'.$min_salery .'$ - '.$max_salery .'$  '.$salery_type.'.</div>
										<div class="df-1 text-muted col-6"><i class="lni lni-users me-1"></i>'.$vocansies.' Vacancy</div>
										<div class="df-1 text-muted col-6"><i class="lni lni-timer me-1"></i>'.$minut.' ago</div>
										<div class="df-1 text-dark ft-medium col-12 mt-3"><a href="'.$permalinkget.'" class="btn gray apply-btn rounded full-width">'.esc_html__('Apply Job',"worplex-frame").'<i class="lni lni-arrow-right-circle ms-1"></i></a></div>
									</div>
								</div>
							</div>
						</div>';
               


}
}
// Restore original post data.
wp_reset_postdata();
$output .= '
<div class="row justify-content-center">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 mt-5">
            <div class="position-relative text-center">
                <a href="'.$butoon_tag_url.'" class="btn btn-md theme-bg rounded text-white hover-theme">'.esc_html__("Apply Job", "worplex-frame").'<i class="lni lni-arrow-right-circle ms-2"></i></a>
            </div>`
        </div>
    </div>
    </div>

';
return $output;
         }
         elseif($atts['listed_job_cat'] == 'view_four'){
    $output .= ' 		
	<div class="row justify-content-center">
						<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
							<div class="sec_title position-relative text-center mb-5">
								<h6 class="text-muted mb-0">'.$tag_tranding.'</h6>
								<h2 class="ft-bold">'.$heading.'<span class="theme-cl">'.$color_heading.'</span></h2>
							</div>
						</div>
					</div>
					
					<!-- row -->
					<div class="row align-items-center g-xl-4 g-lg-3 g-md-3 g-3">';

$numofpost = isset($atts['numofpost']) ? $atts['numofpost'] : '';
$taxonomy = isset($atts['taxonomy']) ? $atts['taxonomy'] : '';
$orderby = isset($atts['orderby']) ? $atts['orderby'] : '';
$posttypename = isset($atts['posttypename']) ? $atts['posttypename'] : '';

$args = array(
'post_type' => 'jobs',
'post_status' => 'publish',
'posts_per_page' => $numofpost,

'order' => 'DESC',
'orderby' => $orderby,

);

$query = new WP_Query($args);
// Check that we have query results.
if ($query->have_posts()) {

// Start looping over the query results.
while ($query->have_posts()) {

$query->the_post();
// dispaly the post content here
$post = get_post();
$postid = $post->ID;

$title = get_the_title($postid);
$permalinkget = get_the_permalink($postid);


// 
$current_user = wp_get_current_user();
$comment = sprintf(esc_html__('%s Comment', 'adhividayam'), get_comments_number($postid));

$date = date('M d Y');

$posted = get_the_time('U');
$minut =  human_time_diff($posted,current_time( 'U' )). "";

$time_tag = get_post_meta($post->ID, 'worplex_field_time_tag', true);
$backgropund_color = get_post_meta($post->ID, 'worplex_field_background_color', true);
$font_color = get_post_meta($post->ID, 'worplex_field_font_color', true);
$resorce_tag = get_post_meta($post->ID, 'worplex_field_resorce_tag', true);
$salery_type = get_post_meta($post->ID, 'worplex_field_salary_unit', true);
$min_salery = get_post_meta($post->ID, 'worplex_field_min_salary', true);
$max_salery = get_post_meta($post->ID, 'worplex_field_max_salary', true);
$vocansies = get_post_meta($post->ID, 'worplex_field_vocansies', true);

$job_type = get_post_meta($post->ID, 'worplex_field_job_type', true);
                $location = worplex_post_location_str($post->ID);
                
                $jobtype_ar = worplex_job_type_ret_str($job_type);
                $job_type_label = isset($jobtype_ar['title']) ? $jobtype_ar['title'] : '';
                $job_type_clor = isset($jobtype_ar['color']) ? $jobtype_ar['color'] : '';
                $job_type_bgclor = isset($jobtype_ar['bg_color']) ? $jobtype_ar['bg_color'] : '';


$image = wp_get_attachment_image_src(get_post_thumbnail_id($postid), 'single-post-thumbnail');
$output .= '

<div class="col-xl-3 col-lg-4 col-md-6 col-sm-12">
							<div class="job_grid border rounded ">
								<div class="position-absolute ab-left"><button type="button" class="p-3 border circle d-flex align-items-center justify-content-center bg-white text-gray"><i class="lni lni-heart-filled position-absolute snackbar-wishlist"></i></button></div>
								<div class="position-absolute ab-right" style="background:'.$job_type_bgclor.';"><span style="color:'.$job_type_clor.';" class="medium theme-cl theme-bg-light px-2 py-1 rounded">'.$job_type_label .'</span></div>
								<div class="job_grid_thumb mb-2 pt-4 px-3">
									<a href="job-detail.html" class="d-block text-center m-auto"><img src="'.$image[0].'" class="img-fluid" width="70" alt="" /></a>
								</div>
								<div class="job_grid_caption text-center pb-3 px-3">
									<h4 class="mb-0 ft-medium medium"><a href="employer-detail.html" class="text-dark fs-md">'.$title.'</a></h4>
									<div class="jbl_location"><i class="lni lni-map-marker me-1"></i><span>'.$location.'</span></div>
								</div>
								<div class="job_grid_footer pt-2 pb-4 px-3 d-flex align-items-center justify-content-between">
									<div class="row">
										<div class="df-1 text-muted col-6 mb-2"><i class="lni lni-briefcase me-1"></i>'.$time_tag .'</div>
										<div class="df-1 text-muted col-6 mb-2"><i class="lni lni-wallet me-1"></i>'.$min_salery .'$ - '.$max_salery .'$  '.$salery_type.'.</div>
										<div class="df-1 text-muted col-6"><i class="lni lni-users me-1"></i>'.$vocansies.' Vacancy</div>
										<div class="df-1 text-muted col-6"><i class="lni lni-timer me-1"></i>'.$minut.' ago</div>
										
									</div>
								</div>
							</div>
						</div>';
               


}
}
// Restore original post data.
wp_reset_postdata();
$output .= '
<div class="row justify-content-center">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 mt-5">
            <div class="position-relative text-center">
                <a href="'.$butoon_tag_url.'" class="btn btn-md theme-bg rounded text-white hover-theme">'.esc_html__("Apply Job", "worplex-frame").'<i class="lni lni-arrow-right-circle ms-2"></i></a>
            </div>
        </div>
    </div>
    </div>

';
return $output;
         }
          elseif($atts['listed_job_cat'] == 'view_five'){
    $output .= '<div class="row justify-content-center">
						<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
							<div class="sec_title position-relative text-center mb-5">
								<h6 class="text-muted mb-0">'.$tag_tranding.'</h6>
								<h2 class="ft-bold">'.$heading.' <span class="theme-cl">'.$color_heading.'</span></h2>
							</div>
						</div>
					</div>
					
					<!-- row -->
					<div class="row align-items-center g-xl-4 g-lg-3 g-md-3 g-3">';

$numofpost = isset($atts['numofpost']) ? $atts['numofpost'] : '';
$taxonomy = isset($atts['taxonomy']) ? $atts['taxonomy'] : '';
$orderby = isset($atts['orderby']) ? $atts['orderby'] : '';
$posttypename = isset($atts['posttypename']) ? $atts['posttypename'] : '';

$args = array(
'post_type' => 'jobs',
'post_status' => 'publish',
'posts_per_page' => $numofpost,

'order' => 'DESC',
'orderby' => $orderby,

);

$query = new WP_Query($args);
// Check that we have query results.
if ($query->have_posts()) {

// Start looping over the query results.
while ($query->have_posts()) {

$query->the_post();
// dispaly the post content here
$post = get_post();
$postid = $post->ID;

$title = get_the_title($postid);
$permalinkget = get_the_permalink($postid);


// 
$current_user = wp_get_current_user();
$comment = sprintf(esc_html__('%s Comment', 'adhividayam'), get_comments_number($postid));

$date = date('M d Y');

$posted = get_the_time('U');
$minut =  human_time_diff($posted,current_time( 'U' )). "";

$time_tag = get_post_meta($post->ID, 'worplex_field_time_tag', true);
$backgropund_color = get_post_meta($post->ID, 'worplex_field_background_color', true);
$font_color = get_post_meta($post->ID, 'worplex_field_font_color', true);
$resorce_tag = get_post_meta($post->ID, 'worplex_field_resorce_tag', true);
$salery_type = get_post_meta($post->ID, 'worplex_field_salary_unit', true);
$min_salery = get_post_meta($post->ID, 'worplex_field_min_salary', true);
$max_salery = get_post_meta($post->ID, 'worplex_field_max_salary', true);
$vocansies = get_post_meta($post->ID, 'worplex_field_vocansies', true);
$experiance = get_post_meta($post->ID, 'worplex_field_experiance', true);

$job_type = get_post_meta($post->ID, 'worplex_field_job_type', true);
                $location = worplex_post_location_str($post->ID);
                
                $jobtype_ar = worplex_job_type_ret_str($job_type);
                $job_type_label = isset($jobtype_ar['title']) ? $jobtype_ar['title'] : '';
                $job_type_clor = isset($jobtype_ar['color']) ? $jobtype_ar['color'] : '';
                $job_type_bgclor = isset($jobtype_ar['bg_color']) ? $jobtype_ar['bg_color'] : '';

$image = wp_get_attachment_image_src(get_post_thumbnail_id($postid), 'single-post-thumbnail');
$output .= '

<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
							<div class="jbr-wrap text-left border rounded">
								<div class="cats-box mlb-res rounded bg-white d-flex align-items-center justify-content-between px-3 py-3">
									<div class="cats-box rounded bg-white d-flex align-items-center">
										<div class="text-center"><img src="'.$image[0].'" class="img-fluid" width="55" alt=""></div>
										<div class="cats-box-caption px-2">
											<h4 class="fs-md mb-0 ft-medium">'.$title.' ('.$experiance.' Exp.)</h4>
											<div class="d-block mb-2 position-relative">
												<span class="text-muted medium"><i class="lni lni-map-marker me-1"></i>'.$location.'</span>
												<span class="muted medium ms-2" style="color:'.$job_type_clor.';"><i class="lni lni-briefcase me-1"></i>'.$job_type_label.'</span>
											</div>
										</div>
									</div>
									<div class="text-center mlb-last"><a href="'.$permalinkget.'" class="btn gray ft-medium apply-btn fs-sm rounded">'.esc_html__('Apply Job',"worplex-frame").'<i class="lni lni-arrow-right-circle ms-1"></i></a></div>
								</div>
							</div>
						</div>';
               


}
}
// Restore original post data.
wp_reset_postdata();
$output .= '
<div class="row justify-content-center">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 mt-5">
            <div class="position-relative text-center">
                <a href="'.$butoon_tag_url.'" class="btn btn-md theme-bg rounded text-white hover-theme">'.esc_html__("Apply Job", "worplex-frame").'<i class="lni lni-arrow-right-circle ms-2"></i></a>
            </div>
        </div>
    </div>
    </div>

';
return $output;
         }
         elseif($atts['listed_job_cat'] == 'view_six'){
    $output .= '<div class="row justify-content-center">
						<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
							<div class="sec_title position-relative text-center mb-5">
								<h6 class="text-muted mb-0">'.$tag_tranding.'</h6>
								<h2 class="ft-bold">'.$heading.' <span class="text-danger">'.$color_heading.'</span></h2>
							</div>
						</div>
					</div>
					
					<!-- row -->
					<div class="row align-items-center g-xl-4 g-lg-3 g-md-3 g-3">';

$numofpost = isset($atts['numofpost']) ? $atts['numofpost'] : '';
$taxonomy = isset($atts['taxonomy']) ? $atts['taxonomy'] : '';
$orderby = isset($atts['orderby']) ? $atts['orderby'] : '';
$posttypename = isset($atts['posttypename']) ? $atts['posttypename'] : '';

$args = array(
'post_type' => 'jobs',
'post_status' => 'publish',
'posts_per_page' => $numofpost,

'order' => 'DESC',
'orderby' => $orderby,

);

$query = new WP_Query($args);
// Check that we have query results.
if ($query->have_posts()) {

// Start looping over the query results.
while ($query->have_posts()) {

$query->the_post();
// dispaly the post content here
$post = get_post();
$postid = $post->ID;

$title = get_the_title($postid);
$permalinkget = get_the_permalink($postid);


// 
$current_user = wp_get_current_user();
$comment = sprintf(esc_html__('%s Comment', 'adhividayam'), get_comments_number($postid));

$date = date('M d Y');

$posted = get_the_time('U');
$minut =  human_time_diff($posted,current_time( 'U' )). "";

$time_tag = get_post_meta($post->ID, 'worplex_field_time_tag', true);
$backgropund_color = get_post_meta($post->ID, 'worplex_field_background_color', true);
$font_color = get_post_meta($post->ID, 'worplex_field_font_color', true);
$resorce_tag = get_post_meta($post->ID, 'worplex_field_resorce_tag', true);
$salery_type = get_post_meta($post->ID, 'worplex_field_salary_unit', true);
$min_salery = get_post_meta($post->ID, 'worplex_field_min_salary', true);
$max_salery = get_post_meta($post->ID, 'worplex_field_max_salary', true);
$vocansies = get_post_meta($post->ID, 'worplex_field_vocansies', true);
$experiance = get_post_meta($post->ID, 'worplex_field_experiance', true);

$job_type = get_post_meta($post->ID, 'worplex_field_job_type', true);
                $location = worplex_post_location_str($post->ID);
                
                $jobtype_ar = worplex_job_type_ret_str($job_type);
                $job_type_label = isset($jobtype_ar['title']) ? $jobtype_ar['title'] : '';
                $job_type_clor = isset($jobtype_ar['color']) ? $jobtype_ar['color'] : '';
                $job_type_bgclor = isset($jobtype_ar['bg_color']) ? $jobtype_ar['bg_color'] : '';

$image = wp_get_attachment_image_src(get_post_thumbnail_id($postid), 'single-post-thumbnail');
$output .= '

<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
							<div class="jbr-wrap text-left border rounded">
								<div class="cats-box mlb-res rounded bg-white d-flex align-items-center justify-content-between px-3 py-3">
									<div class="cats-box rounded bg-white d-flex align-items-center">
										<div class="text-center"><img src="'.$image[0].'" class="img-fluid" width="55" alt=""></div>
										<div class="cats-box-caption px-2">
											<h4 class="fs-md mb-0 ft-medium">'.$title.' ('.$experiance.' Exp.)</h4>
											<div class="d-block mb-2 position-relative">
												<span class="text-muted medium"><i class="lni lni-map-marker me-1"></i>'.$location.'</span>
												<span class="muted medium ms-2" style="color:'.$job_type_clor.';"><i class="lni lni-briefcase me-1"></i>'.$job_type_label.'</span>
											</div>
										</div>
									</div>
									<div class="text-center mlb-last"><a href="'.$permalinkget.'" class="btn gray ft-medium apply-btn fs-sm rounded">'.esc_html__('Apply Job',"worplex-frame").'<i class="lni lni-arrow-right-circle ms-1"></i></a></div>
								</div>
							</div>
						</div>';
               


}
}
// Restore original post data.
wp_reset_postdata();
$output .= '
<div class="row justify-content-center">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 mt-4">
            <div class="position-relative text-center">
                <a href="'.$butoon_tag_url.'" class="btn btn-md bg-dark rounded text-light">'.esc_html__("Apply Job", "worplex-frame").'<i class="lni lni-arrow-right-circle ms-2"></i></a>
            </div>
        </div>
    </div>
</div>
';
return $output;
         }
}
add_shortcode('project_job_listed', 'project_job_listed_frontend');
