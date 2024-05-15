<?php
function browse_resumes_section(){
    vc_map(
        array(
            'name' => __('Browse Resume'),
            'base' => 'browse_resumes_section',
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
add_action('vc_before_init', 'browse_resumes_section');

// popular category frontend
function browse_resumes_section_frontend($atts, $content){

    $atts = shortcode_atts(
        array(
            'posttypename' => '',
            'orderby' => '',
            'taxonomy' => '',
            'numofpost' => '',
        ),
        $atts,
        'browse_resumes_section'
    );

    $output = '';
    $custom_plan_price = isset($atts['nb_medicaltitle']) && !empty($atts['nb_medicaltitle']) ? $atts['nb_medicaltitle'] : '';
    $output .= '<div class="worplex-top">
    <div class="worplex-all-listing-con">
    <div class="row">
						<div class="col-lg-4 col-md-12 col-sm-12">
						<form method="post" class="worplex-jobfilter-form">
							<div class="bg-white rounded mb-4">
								<div class="sidebar_header d-flex align-items-center justify-content-between px-4 py-3 br-bottom">
									<h4 class="ft-medium fs-lg mb-0">Search Filter</h4>
									<div class="ssh-header">
										<a href="javascript:void(0);" class="clear_all ft-medium text-muted">Clear All</a>
										<a href="#search_open" data-bs-toggle="collapse" aria-expanded="false" role="button" class="collapsed _filter-ico ms-2"><i class="lni lni-text-align-right"></i></a>
									</div>
								</div>
								<!-- Find New Property -->
								<div class="sidebar-widgets collapse miz_show" id="search_open" data-parent="#search_open">
									<div class="search-inner">
										<div class="filter-search-box px-4 pt-3 pb-0">
											<div class="form-group">
												<input type="text" class="form-control" name="Search" placeholder="Search by keywords...">
											</div>
											<div class="form-group">
												<input type="text" class="form-control" name="Location" placeholder="Location, Zip..">
											</div>
										</div>
										<div class="filter_wraps">
											<!-- Job categories Search -->
											<div class="single_search_boxed px-4 pt-0 br-bottom">
												<div class="widget-boxed-header">
													<h4>
														<a href="#categories" class="ft-medium fs-md pb-0" data-bs-toggle="collapse" aria-expanded="true" role="button">Candidates Categories</a>
													</h4>
												</div>
												<div class="widget-boxed-body collapse show" id="categories" data-parent="#categories">
													<div class="side-list no-border">
														<!-- Single Filter Card -->
														<div class="single_filter_card">
															<div class="card-body p-0">
																<div class="inner_widget_link">
																	<ul class="no-ul-list filter-list">';
																	
	$categories = get_terms([
    'taxonomy' => 'candidate_skill',
    'hide_empty' => false,
]);

foreach ($categories as $category) {
    $term_link = get_term_link($category);

    $args = array(
        'post_type' => 'candidates',
        'tax_query' => array(
            array(
                'taxonomy' => 'candidate_skill',
                'field' => 'slug',
                'terms' => $category->slug,
            ),
        ),
        'posts_per_page' => -1,
    );
 
    $posts = get_posts($args); 
    $post_count = count($posts);

            $output .= '<li>
        <input type="radio" id="' . $category->term_id . '" class="checkbox-custom" name="employer_cat" value="' . $category->slug . '" unchecked="">
        <label for="' . $category->term_id . '" class="checkbox-custom-label">' . $category->name . ' (' . $post_count . ')</label>
    </li>';
}
																$output.='</ul>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="form-group filter_button pt-2 pb-4 px-4">
											<button type="button" id="filter-button" class="btn btn-md theme-bg text-light rounded full-width">22 Results Show</button>
										</div>
									</div>							
								</div>
							</div>
							</form>
							<!-- Sidebar End -->
						</div>
						<!-- Item Wrap Start -->
						<div class="col-lg-8 col-md-12 col-sm-12">
							<div class="row">
								<div class="col-xl-12 col-lg-12 col-md-12 col-12">
									<div class="row align-items-center justify-content-between mx-0 bg-white rounded py-2 mb-4">
										<div class="col-xl-3 col-lg-4 col-md-5 col-sm-12">
											<h6 class="mb-0 ft-medium fs-sm">'.$post_count.' Candidates Found</h6>
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
												<div class="single_fitres ps-2">';
												
												$gridactiveclass = 'active theme-cl';
												$listactiveclass ='';
												
												if(isset($_REQUEST['view']) && $_REQUEST['view'] == 'list'){
												   $gridactiveclass = '';
												$listactiveclass ='active theme-cl';
												}
												$output.='<a href="?veiw=grid" class="simple-button '.$gridactiveclass.'  me-1"><i class="ti-layout-grid2"></i></a>';
												
													$output.='<a href="?view=list" class="'.$listactiveclass.' simple-button"><i class="ti-view-list"></i></a>';
												$output.='</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<!-- row -->
							<div class="row align-items-center g-xl-3 g-lg-3 g-3">';

    $numofpost = isset($atts['numofpost']) ? $atts['numofpost'] : '';
    $taxonomy = isset($atts['taxonomy']) ? $atts['taxonomy'] : '';
    $orderby = isset($atts['orderby']) ? $atts['orderby'] : '';
    $posttypename = isset($atts['posttypename']) ? $atts['posttypename'] : '';

	$page_numbr = get_query_var('paged');

    $args = array(
        'post_type' => $posttypename,
        'post_status' => 'publish',
        'posts_per_page' => $numofpost,
        'paged' => $page_numbr,
        'order' => 'DESC',
        'orderby' => $orderby,
        'tax_query' => array(
            array(
                'taxonomy' => $taxonomy,
                'field' => 'slug',
                'terms' => $category->slug,
                // 'terms' => array($_GET['kuchb']),
            ),
        ),
    );
   $query = new WP_Query($args);

   $total_posts = $query->found_posts;
    // Check that we have query results.
    if ($query->have_posts()) {
         global $current_user;
        $user_id = $current_user->ID;

        // Start looping over the query results.
        while ($query->have_posts()) {

            $query->the_post();
            // dispaly the post content here
            $post = get_post();
            $postid = $post->ID;
            $title = get_the_title($postid);
            $permalinkget = get_the_permalink($postid);
            $location = get_post_meta($post->ID, 'worplex_field_location', true);
            // $excerpt = get_the_excerpt($postid);
            // $content = get_the_content($postid);
            
        $candidate_id = $post->ID;
        
             $job_title = get_post_meta($candidate_id, 'worplex_field_job_title', true);
 
         $terms = get_the_terms($postid, 'candidate_skill'); 
         If (empty($terms)) {
            $terms = array();
        }
        $length = empty($terms) ? 0 : count($terms);
                // $total_lenght = count($terms);
                        $remaining_length = 0;
                        if($length > 5){
                            $remaining_length = 5 - $length;  // 6
                        }
        
            $image = wp_get_attachment_image_src(get_post_thumbnail_id($postid), 'single-post-thumbnail');
            
             $fav_jobs = get_user_meta($user_id, 'fav_jobs_list', true);

            $fav_jobs = !empty($fav_jobs) ? $fav_jobs : array();

            $like_btn_class = 'worplex-favjab-btn';
            $fav_icon_class = 'lni lni-heart';
            if (in_array($postid, $fav_jobs)) {
                $like_btn_class = 'worplex-alrdy-favjab';
                $fav_icon_class = 'lni lni-heart-filled';
            }
            if (isset($_REQUEST['view']) && $_REQUEST['view'] == 'list'){
                
                ob_start();
                ?>
                <div class="job_grid d-block border rounded px-3 pt-3 pb-2 mb-3">
										<div class="jb-list01-flex d-flex align-items-start justify-content-start">
											<div class="jb-list01-thumb">
												<img src="<?php echo $image[0] ?>" class="img-fluid circle" width="90" alt="">
											</div>
											
											<div class="jb-list01 ps-3">
												<div class="jb-list-01-title"><h5 class="ft-medium mb-1"><a href="<?php echo $permalinkget ?>"><?php echo $title ?></a></h5></div>
												<div class="jb-list-01-info d-block mb-3">
													<span class="text-muted me-2"><i class="lni lni-map-marker me-1"></i><?php echo $location ?></span>
													<span class="text-muted me-2"><i class="lni lni-tag me-1"></i><?php echo $job_title ?></span>
													<span class="text-muted me-2"><i class="lni lni-graduation me-1"></i>4 Year Exp.</span>
												</div>
												<div class="jb-list-01-title d-inline">
												    <?php
												    $coutner = 0;
            foreach($terms as $term){
            $coutner++;
            
            $current_term_link = get_term_link( $term->slug, 'candidate_skill' );
            ?>
												
													<span class="me-2 mb-2 d-inline-flex px-2 py-1 rounded theme-cl theme-bg-light"><?php echo $term->name ?></span>
													<?php
            }
            ?>
												
												</div>
											</div>
										</div>
									</div>
                
                
                <?php
                $output .= ob_get_clean();
                
                
            } else{

            $output .= '<div class="col-xl-4 col-lg-6 col-md-6 col-sm-12">
            <div class="job_grid border rounded ">';
            
            $output.='<div class="position-absolute ab-left">
            <button type="button" class="p-3 border circle d-flex align-items-center justify-content-center bg-white text-gray '.$like_btn_class.'" data-id="'.$postid.'">
            <i class="'.$fav_icon_class.' position-absolute"></i></button></div>';
            
            $output.='<div class="job_grid_thumbmb-2 text-center pt-4 px-3 mb-2" >
            <a href="'.$permalinkget.'" class="d-inline-flex text-center m-auto circle border p-2"><img src="'.$image[0].'" class="img-fluid circle" width="70" alt="" /></a>
            </div>
            <div class="job_grid_caption text-center pb-3 px-3">
            <h4 class="mb-0 ft-medium medium"><a href="'.$permalinkget.'" class="text-dark fs-md">'.$title.'</a></h4>
            <div class="jbl_location"><i class="lni lni-map-marker me-1"></i><span>'.$location.'</span></div>
            </div>
            <div class="job_grid_footer px-3">
            <ul class="p-0 skills_tag text-center">';
                                
            $coutner = 0;
            foreach($terms as $term){
            $coutner++;
            
            $current_term_link = get_term_link( $term->slug, 'candidate_skill' );
                          $output.= '<li><span class="px-2 py-1 medium skill-bg rounded text-skill"><a href="'.$current_term_link.'" >'.$term->name.'</a></span></li>';
                          if($coutner > 3){
						$output .= '<li><span class="px-2 py-1 medium theme-bg rounded text-skill">+'.$remaining_length.' More</span></li>';
                            break;
                        } 
                    }
                    $output.='</ul>
							</div>
							<div class="job_grid_footer pb-4 px-3">
								<div class="df-1 text-dark ft-medium col-12 mt-3"><a href="'.$permalinkget.'" class="btn gray apply-btn rounded full-width">'.esc_html__('View Candidate',"worplex-frame").'<i class="lni lni-arrow-right-circle ms-1"></i></a></div>
							</div>
						</div>
					</div>';
            }
        }
    }
	if ($total_posts > $numofpost) {
        $output .= worplex_pagination($query, true);
    }
     // Restore original post data.
        wp_reset_postdata();
            $output .= '</div>
						</div>
							</div>
							</div>
						</div>
					</div>';
					
			 return $output;
}
add_shortcode('browse_resumes_section', 'browse_resumes_section_frontend');