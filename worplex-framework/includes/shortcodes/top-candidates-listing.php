<?php
function top_candidates_listing()
{
    vc_map(
        array(
            'name' => __('Top Candidates Listed'),
            'base' => 'top_candidates_listing',
            'category' => __('Workplex'),
            'params' => array(

                array(
					'type' => 'dropdown',
					'holder' => 'div',
					'class' => '',
					'heading' => __( 'Candidates Listing', 'workplex' ),
					'param_name' => 'candiates_listing_style',
					'description' => __('Select Candidats Style ', 'workplex'),
					'value' => array(
						'Select Style' => '',
						'Veiw 1' => 'view_1',
						'Veiw 2' => 'view_2',
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
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Taxonomy'),
                    'param_name' => 'taxonomy',
                ),
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => __('Number Of Post'),
                    'param_name' => 'numofpost',
                ),
              
            )
        )

    );
}
add_action('vc_before_init', 'top_candidates_listing');

// popular category frontend
function top_candidates_listing_frontend($atts, $content)
{

    $atts = shortcode_atts(
        array(

            'candiates_listing_style' => '',

            'title' => '',
            'heading' => '',
            'color_word' => '',
            
            'posttypename' => '',
            'orderby' => '',
            'taxonomy' => '',
            'numofpost' => '',
           
        ),
        $atts,
        'top_candidates_listing'
    );

    $output = '';

$candiates_listing_style = isset($atts['candiates_listing_style']) ? $atts['candiates_listing_style'] : '';

$title  = isset($atts['title']) ? $atts['title'] : '';
$heading  = isset($atts['heading']) ? $atts['heading'] : '';
$color_word  = isset($atts['color_word']) ? $atts['color_word'] : '';


    $custom_plan_price = isset($atts['nb_medicaltitle']) && !empty($atts['nb_medicaltitle']) ? $atts['nb_medicaltitle'] : '';

    if($atts['candiates_listing_style'] == 'view_1'){

        $output.='<div class="row justify-content-center">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
            <div class="sec_title position-relative text-center mb-5">
                <h6 class="text-muted mb-0">'.$title.'</h6>
                <h2 class="ft-bold">'.$heading.' <span class="theme-cl">'.$color_word.'</span></h2>
            </div>
        </div>
    </div>
    
    <!-- row -->
    <div class="row align-items-center g-xl-4 g-lg-3 g-md-3 g-3">';
                       
                $numofpost  = isset($atts['numofpost']) ? $atts['numofpost'] : '';
                $categoryslug  = isset($atts['categoryslug']) ? $atts['categoryslug'] : '';
                $orderby  = isset($atts['orderby']) ? $atts['orderby'] : '';
                $posttypename  = isset($atts['posttypename']) ? $atts['posttypename'] : '';
        
        
                $args = array(
                    'post_type' => $posttypename,
                     'post_status' => 'publish',                                                                                                                                                                                             
                      'posts_per_page' => $numofpost, 
                      'order' => 'DESC',                     
                      'orderby' =>  $orderby,  
                      array(
                         'taxonomy' => 'category',
                         'field'    => 'slug',
                         'terms'    => $categoryslug,
                     ),
                    
                 );
                 
                // Custom query.
                $query = new WP_Query( $args );
                 
                
        
                // Check that we have query results.
                if ( $query->have_posts() ) {
                 
                    // Start looping over the query results.
                    while ( $query->have_posts() ) {
        
                        $query->the_post();
                        $post= get_post();        
                        $postid = $post->ID;
        
                        $title = get_the_title($postid);
                        $permalinkget = get_the_permalink($postid);
                        $excerpt = get_the_excerpt($postid);
                        
                        $terms = get_the_terms($postid, 'candidate_skill'); 
                         If (empty($terms)) {
            $terms = array();
        }
                        $total_lenght = count($terms);

                        $remaining_length = 0;
                        
                        if($total_lenght >5){
                            $remaining_length = $total_lenght - 5;  // 6
                        }

                    
                        $image = wp_get_attachment_image_src(get_post_thumbnail_id($postid), 'single-post-thumbnail');
                        $output .= '
                        <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12">
                        <div class="job_grid border rounded ">
                            <div class="position-absolute ab-left"><button type="button" class="p-3 border circle d-flex align-items-center justify-content-center bg-white text-gray"><i class="lni lni-heart-filled position-absolute snackbar-wishlist"></i></button></div>
                            <div class="job_grid_thumbmb-2 text-center pt-4 px-3 mb-2">
                                <a href="'.$permalinkget.'" class="d-inline-flex text-center m-auto circle border p-2"><img src="'.$image[0].'" class="img-fluid circle" width="70" alt="" /></a>
                            </div>
                            <div class="job_grid_caption text-center pb-3 px-3">
                                <h4 class="mb-0 ft-medium medium"><a href="'.$permalinkget.'" class="text-dark fs-md">'.$title.'</a></h4>
                                <div class="jbl_location"><i class="lni lni-map-marker me-1"></i><span>San Francisco</span></div>
                            </div>
                            <div class="job_grid_footer px-3">
                                <ul class="p-0 skills_tag text-center">';
                                
                                $coutner = 0;
                                    foreach($terms as $term){
                                        $coutner++;
                                       
                                   $current_term_link = get_term_link( $term->slug, 'candidate_skill' );
                                        $output.= '<li><span class="px-2 py-1 medium skill-bg rounded text-skill"><a href="'.$current_term_link.'" >'.$term->name.'</a></span></li>';  
                                        if($coutner >5){
                                           $output .= '<li><span class="px-2 py-1 medium theme-bg rounded text-light">+'.$remaining_length.' More</span></li>';
                                            break;
                                        } 
                                    }

                            $output.='        
                                </ul>
                            </div>
                            <div class="job_grid_footer pb-4 px-3">
                                <div class="df-1 text-dark ft-medium col-12 mt-3"><a href="'.$permalinkget.'" class="btn gray apply-btn rounded full-width">View Candidate<i class="lni lni-arrow-right-circle ms-1"></i></a></div>
                            </div>
                        </div>
                    </div>';
                    }
                 
                }
                 
                // Restore original post data.
                wp_reset_postdata();
        
                $output.='';
        
                       
        $output.='</div>
        ';
}elseif($atts['candiates_listing_style'] == 'view_2'){

    $output.='<div class="row justify-content-center">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
        <div class="sec_title position-relative text-center mb-5">
            <h6 class="text-muted mb-0">'.$title.'</h6>
            <h2 class="ft-bold">'.$heading.' <span class="text-danger">'.$color_word.'</span></h2>
        </div>
    </div>
</div>
<!-- row -->
<div class="row align-items-center g-xl-4 g-lg-3 g-md-3 g-3">';
                   
            $numofpost  = isset($atts['numofpost']) ? $atts['numofpost'] : '';
            $categoryslug  = isset($atts['categoryslug']) ? $atts['categoryslug'] : '';
            $orderby  = isset($atts['orderby']) ? $atts['orderby'] : '';
            $posttypename  = isset($atts['posttypename']) ? $atts['posttypename'] : '';
    
    
            $args = array(
                'post_type' => $posttypename,
                 'post_status' => 'publish',                                                                                                                                                                                             
                  'posts_per_page' => $numofpost, 
                  'order' => 'DESC',                     
                  'orderby' =>  $orderby,  
                  array(
                     'taxonomy' => 'category',
                     'field'    => 'slug',
                     'terms'    => $categoryslug,
                 ),
                
             );
             
            // Custom query.
            $query = new WP_Query( $args );
             
            
    
            // Check that we have query results.
            if ( $query->have_posts() ) {
             
                // Start looping over the query results.
                while ( $query->have_posts() ) {
    
                    $query->the_post();
                    $post= get_post();        
                    $postid = $post->ID;
    
                    $title = get_the_title($postid);
                    $permalinkget = get_the_permalink($postid);
                    $excerpt = get_the_excerpt($postid);
                    
                    $terms = get_the_terms($postid, 'candidate_skill'); 
                    
                    // $total_lenght = count($terms);

                    // $remaining_length = 0;
                    
                    // if($total_lenght >5){
                    //     $remaining_length = $total_lenght - 5;  // 6
                    // }

                
                    $image = wp_get_attachment_image_src(get_post_thumbnail_id($postid), 'single-post-thumbnail');
                    $output .= '
                    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12">
							<div class="job_grid border rounded ">
								<div class="position-absolute ab-left"><button type="button" class="p-3 border circle d-flex align-items-center justify-content-center bg-white text-gray"><i class="lni lni-heart-filled position-absolute snackbar-wishlist"></i></button></div>
								<div class="job_grid_thumbmb-2 text-center pt-4 px-3 mb-2">
									<a href="'.$permalinkget.'" class="d-inline-flex text-center m-auto circle border p-2"><img src="'.$image[0].'" class="img-fluid circle" width="70" alt="" /></a>
								</div>
								<div class="job_grid_caption text-center pb-3 px-3">
									<h4 class="mb-0 ft-medium medium"><a href="'.$permalinkget.'" class="text-dark fs-md">'.$title.'</a></h4>
									<div class="jbl_location"><i class="lni lni-map-marker me-1"></i><span>San Francisco</span></div>
								</div>
								<div class="job_grid_footer px-3">
									<ul class="p-0 skills_tag text-center">';
                                    $coutner = 0;
                                    if($terms != ''){
                                    foreach($terms as $term){
                                        $coutner++;
                                       
                                   $current_term_link = get_term_link( $term->slug, 'candidate_skill' );
                                        $output.= '<li><span class="px-2 py-1 medium skill-bg rounded text-skill"><a href="'.$current_term_link.'" >'.$term->name.'</a></span></li>';  
                                        if($coutner >5){
                                           $output .= '<li><span class="px-2 py-1 medium bg-danger rounded text-light">+'.$remaining_length.' More</span></li>';
                                            break;
                                        } 
                                    }
                                    }
								$output.='	
									</ul>
								</div>
								<div class="job_grid_footer pb-4 px-3">
									<div class="df-1 text-dark ft-medium col-12 mt-3"><a href="'.$permalinkget.'" class="btn gray apply-btn rounded full-width">View Candidate<i class="lni lni-arrow-right-circle ms-1"></i></a></div>
								</div>
							</div>
						</div>';
                }
                
             
            }
             
            // Restore original post data.
            wp_reset_postdata();
    
            $output.='';
    
                   
    $output.='</div>
    ';
}

    return $output;
}
add_shortcode('top_candidates_listing', 'top_candidates_listing_frontend');
