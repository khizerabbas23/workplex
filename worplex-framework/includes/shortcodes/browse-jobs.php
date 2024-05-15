<?php
function browse_jobs_section()
{

    vc_map(

        array(
            'name' => __('Browse Job'),
            'base' => 'browse_jobs_section',
            'category' => __('Workplex'),
            'params' => array(

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
      
            )
        )

    );
}
add_action('vc_before_init', 'browse_jobs_section');

// popular category frontend
function browse_jobs_section_frontend($atts, $content)
{
    global $job_browse_totl_res;

    $atts = shortcode_atts(
        array(

 
            'posttypename' => '',
            'orderby' => '',
            'taxonomy' => '',
            'numofpost' => '',


        ),
        $atts,
        'browse_jobs_section'
    );
    
    $page_id = get_the_id();
    $page_url = get_permalink($page_id);

    $output = '';
  

    $custom_plan_price = isset($atts['nb_medicaltitle']) && !empty($atts['nb_medicaltitle']) ? $atts['nb_medicaltitle'] : '';
    
    $jobs_listing_html = worplex_jobs_simple_list($atts);
    
    $total_posts = $job_browse_totl_res;

	$numofpost = isset($atts['numofpost']) ? $atts['numofpost'] : '';

    $orderby = isset($atts['orderby']) ? $atts['orderby'] : '';
    
    $output .= '<section class="bg-light">
				<div class="container">
					<div class="worplex-all-listing-con">
					<div class="row">
						
						<div class="col-lg-4 col-md-12 col-sm-12">
							<div class="bg-white rounded">							
							
								<div class="sidebar_header d-flex align-items-center justify-content-between px-4 py-3 br-bottom">
									<h4 class="ft-medium fs-lg mb-0">Search Filter</h4>
									<div class="ssh-header">
										<a href="' . $page_url . '" class="clear_all ft-medium text-muted">Clear All</a>
										<a href="#search_open" data-bs-toggle="collapse" aria-expanded="false" role="button" class="collapsed _filter-ico ms-2"><i class="lni lni-text-align-right"></i></a>
									</div>
								</div>
								
								<form method="post" class="worplex-jobfilter-form">
								<div class="sidebar-widgets collapse miz_show" id="search_open" data-parent="#search_open">
									
									<div class="search-inner">
										
										<div class="filter-search-box px-4 pt-3 pb-0">
											<div class="form-group">
												<input type="text" class="form-control" name="keyword" value="" placeholder="Search by keywords...">
											</div>
											<div class="form-group">
												<input type="text" class="form-control" name="location" value="" placeholder="Location, Zip..">
											</div>
										</div>
										
										<div class="filter_wraps">
											
											<!-- Job categories Search -->
											<div class="single_search_boxed px-4 pt-0 br-bottom">
												<div class="widget-boxed-header">
													<h4>
														<a href="#categories" class="ft-medium fs-md pb-0" data-bs-toggle="collapse" aria-expanded="true" role="button">Job Categories</a>
													</h4>
													
												</div>
												<div class="widget-boxed-body collapse show" id="categories" data-parent="#categories">
													<div class="side-list no-border">
														<!-- Single Filter Card -->
														<div class="single_filter_card">
															<div class="card-body p-0">
																<div class="inner_widget_link">
																	<ul class="no-ul-list filter-list">';
																		$cat_terms = get_terms( array(
																			'taxonomy'   => 'job_category',
																			'hide_empty' => 0,
																			'parent' => 0,
																		
																		) );
                                                                          
																		if (!empty($cat_terms)) {
																			foreach ($cat_terms as $cat_term) {
																			  
			                                                                    
																				$output .=
																				'<li>
																					<input id="cat-' . $cat_term->term_id . '" class="radio-custom" name="job_category" value="' . $cat_term->slug . '" type="radio">
																					<label for="cat-' . $cat_term->term_id . '" class="radio-custom-label">' . $cat_term->name . '</label>
																				</li>';
																			}
																		}
																	$output .=	
																	'</ul>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
											
										</div>
										
										<div class="form-group filter_button pt-2 pb-4 px-4">
											<input type="hidden" name="numposts" value="' . $numofpost . '">
											<input type="hidden" name="orderby" value="' . $orderby . '">
											<input type="hidden" name="action" value="worplex_job_filters_submit_call">
											<button type="submit" class="btn btn-md theme-bg text-light rounded full-width">Filter Results</button>
										</div>
									</div>							
								</div>
								</form>
							</div>
							<!-- Sidebar End -->
						
						</div>
						
						<!-- Item Wrap Start -->
						<div class="col-lg-8 col-md-12 col-sm-12">
							
							<div class="row">
								<div class="col-xl-12 col-lg-12 col-md-12 col-12">
									<div class="row align-items-center justify-content-between mx-0 bg-white rounded py-2 mb-4">
										<div class="col-xl-3 col-lg-4 col-md-5 col-sm-12">
											<h6 class="mb-0 ft-medium fs-sm">' . $total_posts . ' Jobs Found</h6>
										</div>
										
										<div class="col-xl-9 col-lg-8 col-md-7 col-sm-12">
											<div class="filter_wraps elspo_wrap d-flex align-items-center justify-content-end">
												<div class="single_fitres pe-3 br-right">
													<select class="form-select">
													  <option value="1" selected="">Default Sorting</option>
													  <option value="2">Recent jobs</option>
													  <option value="3">Featured jobs</option>
													  <option value="4">Trending Jobs</option>
													  <option value="5">Premium jobs</option>
													</select>
												</div>
												<div class="single_fitres ps-2">
													<a href="" class="simple-button active theme-cl me-1"><i class="ti-layout-grid2"></i></a>
													<a href="" class="simple-button"><i class="ti-view-list"></i></a>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
            
            <!-- Item Wrap Start -->
            <div class="row worplex-alljobs-list">';
				$output .= $jobs_listing_html;
			$output .= '</div>
          </div>
        </div>
		</div>
    </section>';

			 return $output;
    }
add_shortcode('browse_jobs_section', 'browse_jobs_section_frontend');


function worplex_jobs_simple_list($list_args) {
    global $job_browse_totl_res;
	$output = '
	<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">';

    $numofpost = isset($list_args['numofpost']) ? $list_args['numofpost'] : '';

    $orderby = isset($list_args['orderby']) ? $list_args['orderby'] : '';

	$page_numbr = get_query_var('paged');
    $args = array(
        'post_type' => 'jobs',
        'post_status' => 'publish',
        'posts_per_page' => $numofpost,
        'paged' => $page_numbr,
        'order' => 'DESC',
        'orderby' => $orderby,
    );

	// Search keyword
	if (isset($_REQUEST['keyword'])) {
		$keyword = $_REQUEST['keyword'];
		$args['s'] = esc_html($keyword);
	}

	// tax query
	$tax_query = array();
	if (isset($_REQUEST['job_category'])) {
		$job_category = $_REQUEST['job_category'];
		$tax_query[] = array(
			'taxonomy' => 'job_category',
			'field' => 'slug',
			'terms' => $job_category,
		);
	}
	if (isset($_REQUEST['job_skills'])) {
		$job_skills = $_REQUEST['job_skills'];
		$tax_query[] = array(
			'taxonomy' => 'job_skill',
			'field' => 'slug',
			'terms' => $job_skills,
		);
	}
	if (!empty($tax_query)) {
		$args['tax_query'] = $tax_query;
	}

	// meta query
	$meta_query = array();
	if (isset($_REQUEST['location']) && $_REQUEST['location'] != '') {
		$location = $_REQUEST['location'];
		$meta_query[] = array(
			'key' => 'worplex_field_location',
			'value' => esc_html($location),
			'compare' => 'LIKE',
		);
	}
	if (isset($_REQUEST['experience']) && $_REQUEST['experience'] != '') {
		$experience = $_REQUEST['experience'];
		$meta_query[] = array(
			'key' => 'worplex_field_experience',
			'value' => esc_html($experience),
		);
	}

	if (!empty($meta_query)) {
		$args['meta_query'] = $meta_query;
	}
	// echo '<pre>';
	// var_dump($args);
	// echo '</pre>';

    $query = new WP_Query($args);
    $job_browse_totl_res = $total_posts = $query->found_posts;
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
            $excerpt = get_the_excerpt($postid);

           
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
                $hiring = get_post_meta($post->ID, 'worplex_field_hiring', true);
                $location = worplex_post_location_str($post->ID);
                
                $jobtype_ar = worplex_job_type_ret_str($job_type);
                $job_type_label = isset($jobtype_ar['title']) ? $jobtype_ar['title'] : '';
                $job_type_clor = isset($jobtype_ar['color']) ? $jobtype_ar['color'] : '';
                $job_type_bgclor = isset($jobtype_ar['bg_color']) ? $jobtype_ar['bg_color'] : '';
   
				$terms = get_the_terms($postid, 'candidate_skill'); 
				If (empty($terms)) {
					$terms = array();
				}
                $total_lenght = count($terms);
                        
                $remaining_length = 0;
                if($total_lenght > 5){
                    $remaining_length = 5 - $total_lenght;  // 6
                }
        
                $image = wp_get_attachment_image_src(get_post_thumbnail_id($postid), 'single-post-thumbnail');
            	global $current_user;

					$user_id = $current_user->ID;

            $faver_jobs = get_user_meta($user_id, 'fav_candidate_list', true);

						$faver_jobs = !empty($faver_jobs) ? $faver_jobs : array();

						$like_btn_class = 'worplex-favcandidate-btn';
						$fav_icon_class = 'lni lni-heart';
						if (in_array($postid, $faver_jobs)) {
							$like_btn_class = 'worplex-alrdy-favjab';
							$fav_icon_class = 'lni lni-heart-filled';
						}
            $output .= '
                    
                   <div class="worplex-post-item job_grid d-block border rounded px-3 pt-3 pb-2 mb-3">
										<div class="jb-list01-flex d-flex align-items-start justify-content-start">
										
											<div class="jb-list01-thumb">
												<img src="'.$image[0].'" class="img-fluid" width="90" alt="" />
											</div>
											
											<div class="jb-list01 ps-3">
												<div class="jb-list-01-title"><h5 class="ft-medium mb-1"><a href="'.$permalinkget.'">'.$title.'</a></h5></div>
												<div class="jb-list-01-info d-block mb-3">
													<span class="text-muted me-2"><i class="lni lni-map-marker me-1"></i>'.$location.'</span>
													<span class="text-muted me-2"><i class="lni lni-briefcase me-1"></i>'.$job_type_label.'</span>
													<span class="text-muted me-2"><i class="lni lni-money-protection me-1"></i>'.$min_salery.' - '.$max_salery.'</span>
												</div>
												
												<div class="jb-list-01-title d-inline">
												<div class="position-absolute ab-left"><button type="button" class="p-3 border circle d-flex align-items-center justify-content-center bg-white text-gray '.$like_btn_class.'" data-id="'.$postid.'"><i class="'.$fav_icon_class.' position-absolute"></i></button></div>';
                                
                        $coutner = 0;
                            foreach($terms as $term){
                                $coutner++;
                               
                           $current_term_link = get_term_link( $term->slug, 'skills_post' );
                          
                                  $output.= '
                            <span style="background:'.$backgropund_color.';"  style="color:'.$font_color.';" class="me-2 mb-2 d-inline-flex px-2 py-1 rounded theme-cl theme-bg-light">'.$term->name.'</span>';
                           if($coutner > 4){
                           break;
                           }
                           }
                            $output.='     
                        </div>
                    </div>
                </div>
                </div>';
            
        }
    } else {
		$output .= '<p>No job found.</p>';
	}
    if ($total_posts > $numofpost) {
        $output .= worplex_pagination($query, true);
    }
     // Restore original post data.
        wp_reset_postdata();
		$output .= '
			
		</div>';

		return $output;
}

add_action('wp_ajax_worplex_job_filters_submit_call', 'worplex_simple_job_filters_submit_call');
add_action('wp_ajax_nopriv_worplex_job_filters_submit_call', 'worplex_simple_job_filters_submit_call');

function worplex_simple_job_filters_submit_call() {

	$atts = array(
		'numofpost' => $_POST['numposts'],
		'orderby' => $_POST['orderby']
	);

	$html = worplex_jobs_simple_list($atts);

	wp_send_json(array('html' => $html));
}