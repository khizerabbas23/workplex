<?php
function job_search_v_one()
			{
				vc_map(
					array(
						'name' => __('Job Search'),
						'base' => 'job_search_v_one',
						'category' => __('Worplex'),
						'params' => array(
							array(
								'type' => 'dropdown',
								'holder' => 'div',
								'class' => '',
								'heading' => __( 'Job Search', 'Worplex' ),
								'param_name' => 'job_search_cat',
								'description' => __('Select Blog Column Style ', 'Worplex'),

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
add_action('vc_before_init', 'job_search_v_one');

// popular category frontend
function job_search_v_one_frontend($atts, $content)
            {
            
            $atts = shortcode_atts(
            array(
            
            
            'job_search_cat' => '',
            'posttypename' => '',
            'orderby' => '',
            'taxonomy' => '',
            'numofpost' => '',
            
            
            ),
$atts,
'job_search_v_one'
);

$page_id = get_the_id();
$page_url = get_permalink($page_id);

    $numofpost = isset($atts['numofpost']) ? $atts['numofpost'] : '';
    $taxonomy = isset($atts['taxonomy']) ? $atts['taxonomy'] : '';
    $orderby = isset($atts['orderby']) ? $atts['orderby'] : '';
    $posttypename = isset($atts['posttypename']) ? $atts['posttypename'] : '';
    $page_numbr = get_query_var('paged');
    $args = array(
    'post_type' => 'jobs',
    'post_status' => 'publish',
    'posts_per_page' => $numofpost,
    'paged' => $page_numbr,
    'order' => 'DESC',
    'orderby' => $orderby,
    
    );
    
    $query = new WP_Query($args);
    $total_posts = $query->found_posts;

    $output = '';
    $job_search_cat = isset($atts['job_search_cat']) ? $atts['job_search_cat'] : '';

 

				$numofpost = isset($atts['numofpost']) ? $atts['numofpost'] : '';
				$orderby = isset($atts['orderby']) ? $atts['orderby'] : '';


				$custom_plan_price = isset($atts['nb_medicaltitle']) && !empty($atts['nb_medicaltitle']) ? $atts['nb_medicaltitle'] : '';
				
				if($atts['job_search_cat'] == 'view_one'){
				$output .= '
				<section class="py-2 br-bottom br-top">
				<div class="container">
				
					<div class="row align-items-center justify-content-between">
						<div class="col-xl-3 col-lg-4 col-md-5 col-sm-12">
							<h6 class="mb-0 ft-medium fs-sm">'.$total_posts.' Jobs Found</h6>
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
								$output.='<a href="?view=grid" class="simple-button '.$gridactiveclass.' me-1"><i class="ti-layout-grid2"></i></a>
									<a href="https:?view=list"><i class="ti-view-list '.$listactiveclass.'"></i></a>
								</div>
							</div>
						</div>
					</div>
					
				</div>
			</section>
			<!-- ============================= Filter Wrap ============================== -->

			<!-- ============================ Main Section Start ================================== -->
		
			<section class="bg-light worplex-section-tbpading">
				<div class="container">
				<div class="worplex-all-listing-con">
					<div class="row">
						
						<div class="col-lg-4 col-md-12 col-sm-12">
						
							<div class="bg-white rounded mb-4">							
							
								<div class="sidebar_header d-flex align-items-center justify-content-between px-4 py-3 br-bottom">
									<h4 class="ft-medium fs-lg mb-0">Search Filter</h4>
									<div class="ssh-header">
										<a href="' . $page_url . 'javascript:void(0);ft-medium text-muted">Clear All</a>
										<a href="#search_open" data-bs-toggle="collapse" aria-expanded="false" role="button" class="collapsed _filter-ico ms-2"><i class="lni lni-text-align-right"></i></a>
									</div>
								</div>
								
								<form method="post" class="worplex-jobfilter-form">
								
								<div class="sidebar-widgets collapse miz_show" id="search_open" data-parent="#search_open">
									
									<div class="search-inner">
										
										<div class="filter-search-box px-4 pt-3 pb-0">
											<div class="form-group">
												<input type="text" class="form-control" name="keyword" placeholder="Search by keywords...">
											</div>
											<div class="form-group">
												<input type="text"  class="form-control" name="location" placeholder="Location, Zip..">
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
																   
                                                        			  $categories = get_terms([
                                                        				'taxonomy' => 'job_category',
                                                        				'hide_empty' => false,
                                                        			   	'parent' => 0,
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
                                                                        $output .= '
                                                        				<li>
                                                        				
                                                        					<input type="radio" id="jobs' . $category->term_id . '" value="' . $category->slug . '" name="jobs_category" />
                                                        					<label for="jobs' . $category->term_id . '" class="checkbox-custom-label">' . $category->name . ' (' . $post_count . ')</label>
                                                        				</li>';
                                                        			}

			                                                	$output .= '</ul>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
							   
											<!-- Expected Salary Search -->
											<div class="single_search_boxed px-4 pt-0">
												<div class="widget-boxed-header">
													<h4>
														<a href="#salary" data-bs-toggle="collapse" aria-expanded="false" role="button" class="ft-medium fs-md pb-0 collapsed">Expected Salary</a>
													</h4>
													
												</div>
												<div class="widget-boxed-body collapse" id="salary" data-parent="#salary">
													<div class="side-list no-border">
														<!-- Single Filter Card -->
														<div class="single_filter_card">
															<div class="card-body p-0">
																<div class="inner_widget_link">
																	<ul class="no-ul-list filter-list">
																		<li>
																			<input id="g1" class="checkbox-custom" name="ADA" type="checkbox" checked="">
																			<label for="g1" class="checkbox-custom-label">$120k - $140k PA</label>
																		</li>
																		<li>
																			<input id="g2" class="checkbox-custom" name="Parking" type="checkbox">
																			<label for="g2" class="checkbox-custom-label">$140k - $150k PA</label>
																		</li>
																		<li>
																			<input id="g3" class="checkbox-custom" name="Coffee" type="checkbox">
																			<label for="g3" class="checkbox-custom-label">$150k - $170k PA</label>
																		</li>
																		<li>
																			<input id="g4" class="checkbox-custom" name="Mother" type="checkbox">
																			<label for="g4" class="checkbox-custom-label">$170k - $190k PA</label>
																		</li>
																		<li>
																			<input id="g5" class="checkbox-custom" name="Outdoor" type="checkbox">
																			<label for="g5" class="checkbox-custom-label">$200k - $250k PA</label>
																		</li>
																		<li>
																			<input id="g6" class="checkbox-custom" name="Pet" type="checkbox">
																			<label for="g6" class="checkbox-custom-label">$250k - $300k PA</label>
																		</li>
																	</ul>
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
				                    	<button type="submit" class="btn btn-md theme-bg text-light rounded full-width">Show Results</button>
			                        	</div>
									   
									</div>							
								</div>
									</form>
							</div>
						
							<!-- Sidebar End -->
						
						</div>
	<div class="col-lg-8 col-md-12 col-sm-12">
	<div class="row  worplex-alljobs-lists align-items-center g-xl-3 g-lg-3 g-md-3 g-3">
';

  
	$output .= worplex_jobs_simples_list($atts);
				
			 	$output .='	</div>
		</div> 
				</div>
				</div>
				</div>
			</div>
			</div>
			</section>';
		
}
			elseif($atts['job_search_cat'] == 'view_two'){
$output.='<section class="bg-light middle">
				<div class="container">
				
					<div class="row">
						<div class="col-xl-12 col-lg-12 col-md-12 col-12">
							<div class="row align-items-center justify-content-between mx-0 bg-white rounded py-2 mb-4">
								<div class="col-xl-3 col-lg-4 col-md-5 col-sm-12">
									<h6 class="mb-0 ft-medium fs-sm">'.$total_posts.' Jobs Found</h6>
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
												
										$output.='<a href="?view=grid" class="simple-button '.$gridactiveclass.'"><i class="ti-layout-grid2"></i></a>
										          <a href="?view=list" class="simple-button '.$listactiveclass.'"><i class="ti-view-list"></i></a>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					
					<!-- row -->
					<div class="row align-items-center g-xl-3 g-lg-3 g-md-3 g-3">';

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
$experiance = get_post_meta($post->ID, 'worplex_field_experiance', true);
$vocansies = get_post_meta($post->ID, 'worplex_field_vocansies', true);
$location = worplex_post_location_str($post->ID);

$job_type = get_post_meta($post->ID, 'worplex_field_job_type', true);
$jobtype_ar = worplex_job_type_ret_str($job_type);
$job_type_label = isset($jobtype_ar['title']) ? $jobtype_ar['title'] : '';
$job_type_clor = isset($jobtype_ar['color']) ? $jobtype_ar['color'] : '';
$job_type_bgclor = isset($jobtype_ar['bg_color']) ? $jobtype_ar['bg_color'] : '';

$image = wp_get_attachment_image_src(get_post_thumbnail_id($postid), 'single-post-thumbnail');


if (isset($_REQUEST['view']) && $_REQUEST['view'] == 'list'){
                
                ob_start();
                ?>
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="jbr-wrap text-left border rounded">
            <div class="cats-box mlb-res rounded bg-white d-flex align-items-center justify-content-between px-3 py-3">
                <div class="cats-box rounded bg-white d-flex align-items-center">
                    <div class="text-center"><img src="<?php echo $image[0] ?>" class="img-fluid" width="55" alt=""></div>
                    <div class="cats-box-caption px-2">
                        <h4 class="fs-md mb-0 ft-medium"><?php echo $title ?> (<?php echo $experiance?> Exp.)</h4>
                        <div class="d-block mb-2 position-relative">
                            <span class="text-muted medium"><i class="lni lni-map-marker me-1"></i><?php echo $location ?></span>
                            <span class="muted medium ms-2 theme-cl" style="color:<?php echo $job_type_clor ?> !important;" ><i class="lni lni-briefcase me-1"></i><?php echo $job_type_label ?></span>
                        </div>
                    </div>
                </div>
                <div class="text-center mlb-last"><a href="<?php echo $permalinkget ?>" class="btn gray ft-medium apply-btn fs-sm rounded"><?php echo esc_html('Apply Job', 'worplex-frame')?><i class="lni lni-arrow-right-circle ms-1"></i></a></div>
            </div>
        </div>
    </div>
         <?php
        $output .= ob_get_clean();
            }else{
$output .= '

<div class="col-xl-3 col-lg-4 col-md-6 col-sm-12">
							<div class="job_grid border rounded ">
								<div class="position-absolute ab-left"><button type="button" class="p-3 border circle d-flex align-items-center justify-content-center bg-white text-gray"><i class="lni lni-heart-filled position-absolute snackbar-wishlist"></i></button></div>
								<div class="position-absolute ab-right"><span style="color:'.$job_type_clor.' !important;background:'.$job_type_bgclor.' !important;" class="medium theme-cl theme-bg-light px-2 py-1 rounded">'.$job_type_label.'</span></div>
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
}

if ($total_posts > $numofpost) {
    $output .= worplex_pagination($query, true);
}
// Restore original post data.
wp_reset_postdata();
$output .= '
</div>
</section>';
}
elseif($atts['job_search_cat'] == 'view_three'){
    $output .= '<section class="py-2 br-bottom br-top">
    <div class="container">
    <div class="row align-items-center justify-content-between">
    <div class="col-xl-3 col-lg-4 col-md-5 col-sm-12">
        <h6 class="mb-0 ft-medium fs-sm">'.$total_posts.' Jobs Found</h6>
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
            
            
                $output.='<a href="?view=grid" class="simple-button '.$gridactiveclass.' me-1"><i class="ti-layout-grid2"></i></a>
                <a href="?view=list"><i class="ti-view-list '.$listactiveclass.'"></i></a>
            </div>
        </div>
    </div>
</div>

</div>
</section>
<!-- ============================= Filter Wrap ============================== -->

<!-- ============================ Main Section Start ================================== -->

<section class="bg-light worplex-section-tbpading">
<div class="container">
<div class="worplex-all-listing-con">
<div class="row">
    
    <div class="col-lg-4 col-md-12 col-sm-12">
    
        <div class="bg-white rounded mb-4">							
        
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
                            <input type="text" class="form-control" name="keyword" placeholder="Search by keywords...">
                        </div>
                        <div class="form-group">
                            <input type="text"  class="form-control" name="location" placeholder="Location, Zip..">
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
                                                  $categories = get_terms([
                                                    'taxonomy' => 'job_category',
                                                    'hide_empty' => false,
                                                       'parent' => 0,
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
                                    
                                                    $output .= '
                                                    <li>
                                                    
                                                        <input type="radio" id="jobs' . $category->term_id . '" value="' . $category->slug . '" name="jobs_category" />
                                                        <label for="jobs' . $category->term_id . '" class="checkbox-custom-label">' . $category->name . ' (' . $post_count . ')</label>
                                                    </li>';
                                                }

                                            $output .= '</ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
           
                        <!-- Expected Salary Search -->
                        <div class="single_search_boxed px-4 pt-0">
                            <div class="widget-boxed-header">
                                <h4>
                                    <a href="#salary" data-bs-toggle="collapse" aria-expanded="false" role="button" class="ft-medium fs-md pb-0 collapsed">Expected Salary</a>
                                </h4>
                                
                            </div>
                            <div class="widget-boxed-body collapse" id="salary" data-parent="#salary">
                                <div class="side-list no-border">
                                    <!-- Single Filter Card -->
                                    <div class="single_filter_card">
                                        <div class="card-body p-0">
                                            <div class="inner_widget_link">
                                                <ul class="no-ul-list filter-list">
                                                    <li>
                                                        <input id="g1" class="checkbox-custom" name="ADA" type="checkbox" checked="">
                                                        <label for="g1" class="checkbox-custom-label">$120k - $140k PA</label>
                                                    </li>
                                                    <li>
                                                        <input id="g2" class="checkbox-custom" name="Parking" type="checkbox">
                                                        <label for="g2" class="checkbox-custom-label">$140k - $150k PA</label>
                                                    </li>
                                                    <li>
                                                        <input id="g3" class="checkbox-custom" name="Coffee" type="checkbox">
                                                        <label for="g3" class="checkbox-custom-label">$150k - $170k PA</label>
                                                    </li>
                                                    <li>
                                                        <input id="g4" class="checkbox-custom" name="Mother" type="checkbox">
                                                        <label for="g4" class="checkbox-custom-label">$170k - $190k PA</label>
                                                    </li>
                                                    <li>
                                                        <input id="g5" class="checkbox-custom" name="Outdoor" type="checkbox">
                                                        <label for="g5" class="checkbox-custom-label">$200k - $250k PA</label>
                                                    </li>
                                                    <li>
                                                        <input id="g6" class="checkbox-custom" name="Pet" type="checkbox">
                                                        <label for="g6" class="checkbox-custom-label">$250k - $300k PA</label>
                                                    </li>
                                                </ul>
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
                    <button type="submit" class="btn btn-md theme-bg text-light rounded full-width">Show Results</button>
                    </div>
                   
                </div>							
            </div>
                </form>
        </div>
    
        <!-- Sidebar End -->
            </div>
            
            <!-- Item Wrap Start -->
            <div class="col-lg-8 col-md-12 col-sm-12">
                
                <!-- row -->
                <div class="row align-items-center g-xl-3 g-lg-3 g-md-3 g-3">';

    $numofpost = isset($atts['numofpost']) ? $atts['numofpost'] : '';
    $taxonomy = isset($atts['taxonomy']) ? $atts['taxonomy'] : '';
    $orderby = isset($atts['orderby']) ? $atts['orderby'] : '';
    $posttypename = isset($atts['posttypename']) ? $atts['posttypename'] : '';
$page_numbr = get_query_var('paged');
    $args = array(
        'post_type' => 'jobs',
        'post_status' => 'publish',
        'posts_per_page' => $numofpost,
         'paged' => $page_numbr,
        'order' => 'DESC',
        'orderby' => $orderby,
 
    );

   $query = new WP_Query($args);
    $total_posts = $query->found_posts;
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
            $location = worplex_post_location_str($post->ID);
            
            $job_type = get_post_meta($post->ID, 'worplex_field_job_type', true);
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
            
            
            
            
            if (isset($_REQUEST['view']) && $_REQUEST['view'] == 'list'){
                
                ob_start();
                ?>
                
                 <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
									<div class="jbr-wrap text-left border rounded">
										<div class="cats-box mlb-res rounded bg-white d-flex align-items-center justify-content-between px-3 py-3">
											<div class="cats-box rounded bg-white d-flex align-items-center">
												<div class="text-center"><img src="<?php echo $image[0] ?>" class="img-fluid" width="55" alt=""></div>
												<div class="cats-box-caption px-2">
													<h4 class="fs-md mb-0 ft-medium"><?php echo $title ?> (<?php echo $experiance ?> Exp.)</h4>
													<div class="d-block mb-2 position-relative">
														<span class="text-muted medium"><i class="lni lni-map-marker me-1"></i><?php echo $location ?></span>
														<span class="muted medium ms-2 theme-cl"><i class="lni lni-briefcase me-1" style="color:<?php echo $job_type_clor ?>"></i><?php echo $job_type_label ?></span>
													</div>
												</div>
											</div>
											<div class="text-center mlb-last"><a href="<?php echo $permalinkget?> " class="btn gray ft-medium apply-btn fs-sm rounded">Apply Job<i class="lni lni-arrow-right-circle ms-1"></i></a></div>
										</div>
									</div>
								</div>
                
                 <?php
                $output .= ob_get_clean();
                
                
            } else{

            $output .= '    
            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12">
									<div class="job_grid border rounded ">
										<div class="position-absolute ab-left"><button type="button" class="p-3 border circle d-flex align-items-center justify-content-center bg-white text-gray"><i class="lni lni-heart-filled position-absolute snackbar-wishlist"></i></button></div>
										<div class="position-absolute ab-right"><span class="medium bg-light-purple text-purple px-2 py-1 rounded" style="color:'.$job_type_clor.' !important;background:'.$job_type_bgclor.' !important;">'.$job_type_label .'</span></div>
										<div class="job_grid_thumb mb-2 pt-4 px-3">
											<a href="'.$permalinkget.'" class="d-block text-center m-auto"><img src="'.$image[0].'" class="img-fluid" width="70" alt="" /></a>
										</div>
										<div class="job_grid_caption text-center pb-3 px-3">
											<h4 class="mb-0 ft-medium medium"><a href="'.$permalinkget.'" class="text-dark fs-md">'.$title.'</a></h4>
											<div class="jbl_location"><i class="lni lni-map-marker me-1"></i><span>'.$location.'</span></div>
										</div>
										<div class="job_grid_footer pt-2 pb-4 px-3 d-flex align-items-center justify-content-between">
											<div class="row">
												<div class="df-1 text-muted col-6 mb-2"  style="color:'.$font_color.';"><i class="lni lni-briefcase me-1"></i>'.$time_tag .'</div>
												<div class="df-1 text-muted col-6 mb-2"><i class="lni lni-wallet me-1"></i>'.$min_salery .'$ - '.$max_salery .'$  '.$salery_type.'</div>
												<div class="df-1 text-muted col-6"><i class="lni lni-users me-1"></i>'.$vocansies.' Opp.</div>
												<div class="df-1 text-muted col-6"><i class="lni lni-timer me-1"></i>'.$minut.' ago</div>
												<div class="df-1 text-dark ft-medium col-12 mt-3"><a href="j'.$permalinkget.'" class="btn gray apply-btn rounded full-width">Apply Job<i class="lni lni-arrow-right-circle ms-1"></i></a></div>
											</div>
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
            $output .= '

    </div>  
</div>
</div>
</section>
			';

}


elseif($atts['job_search_cat'] == 'view_four'){
    $output .= '<section class="py-2 br-bottom br-top">
    <div class="container">
    <div class="row align-items-center justify-content-between">
    <div class="col-xl-3 col-lg-4 col-md-5 col-sm-12">
        <h6 class="mb-0 ft-medium fs-sm">'.$total_posts.' Jobs Found</h6>
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
            
            
            $gridactiveclass = '';
												$listactiveclass ='active theme-cl';
												
												if(isset($_REQUEST['view']) && $_REQUEST['view'] == 'grid'){
												   $gridactiveclass = 'active theme-cl';
												$listactiveclass ='';
												}
              $output.='<a href="?view=grid" class="simple-button '.$gridactiveclass.' me-1"><i class="ti-layout-grid2"></i></a>
                <a href="?view=list"><i class="ti-view-list '.$listactiveclass.'"></i></a>
            </div>
        </div>
    </div>
</div>

</div>
</section>
<!-- ============================= Filter Wrap ============================== -->

<!-- ============================ Main Section Start ================================== -->

<section class="bg-light worplex-section-tbpading">
<div class="container">
<div class="worplex-all-listing-con">
<div class="row">
    
    <div class="col-lg-4 col-md-12 col-sm-12">
    
        <div class="bg-white rounded mb-4">							
        
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
                            <input type="text" class="form-control" name="keyword" placeholder="Search by keywords...">
                        </div>
                        <div class="form-group">
                            <input type="text"  class="form-control" name="location" placeholder="Location, Zip..">
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
                                                  $categories = get_terms([
                                                    'taxonomy' => 'job_category',
                                                    'hide_empty' => false,
                                                       'parent' => 0,
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
                                    
                                                    $output .= '
                                                    <li>
                                                    
                                                        <input type="radio" id="jobs' . $category->term_id . '" value="' . $category->slug . '" name="jobs_category" />
                                                        <label for="jobs' . $category->term_id . '" class="checkbox-custom-label">' . $category->name . ' (' . $post_count . ')</label>
                                                    </li>';
                                                }

                                            $output .= '</ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
           
                        <!-- Expected Salary Search -->
                        <div class="single_search_boxed px-4 pt-0">
                            <div class="widget-boxed-header">
                                <h4>
                                    <a href="#salary" data-bs-toggle="collapse" aria-expanded="false" role="button" class="ft-medium fs-md pb-0 collapsed">Expected Salary</a>
                                </h4>
                                
                            </div>
                            <div class="widget-boxed-body collapse" id="salary" data-parent="#salary">
                                <div class="side-list no-border">
                                    <!-- Single Filter Card -->
                                    <div class="single_filter_card">
                                        <div class="card-body p-0">
                                            <div class="inner_widget_link">
                                                <ul class="no-ul-list filter-list">
                                                    <li>
                                                        <input id="g1" class="checkbox-custom" name="ADA" type="checkbox" checked="">
                                                        <label for="g1" class="checkbox-custom-label">$120k - $140k PA</label>
                                                    </li>
                                                    <li>
                                                        <input id="g2" class="checkbox-custom" name="Parking" type="checkbox">
                                                        <label for="g2" class="checkbox-custom-label">$140k - $150k PA</label>
                                                    </li>
                                                    <li>
                                                        <input id="g3" class="checkbox-custom" name="Coffee" type="checkbox">
                                                        <label for="g3" class="checkbox-custom-label">$150k - $170k PA</label>
                                                    </li>
                                                    <li>
                                                        <input id="g4" class="checkbox-custom" name="Mother" type="checkbox">
                                                        <label for="g4" class="checkbox-custom-label">$170k - $190k PA</label>
                                                    </li>
                                                    <li>
                                                        <input id="g5" class="checkbox-custom" name="Outdoor" type="checkbox">
                                                        <label for="g5" class="checkbox-custom-label">$200k - $250k PA</label>
                                                    </li>
                                                    <li>
                                                        <input id="g6" class="checkbox-custom" name="Pet" type="checkbox">
                                                        <label for="g6" class="checkbox-custom-label">$250k - $300k PA</label>
                                                    </li>
                                                </ul>
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
                    <button type="submit" class="btn btn-md theme-bg text-light rounded full-width">Show Results</button>
                    </div>
                   
                </div>							
            </div>
                </form>
        </div>
    
        <!-- Sidebar End -->
            
            </div>
            
            <!-- Item Wrap Start -->
            <div class="col-lg-8 col-md-12 col-sm-12">
                
                <!-- row -->
                <div class="row align-items-center g-xl-3 g-lg-3 g-md-3 g-3">';

    $numofpost = isset($atts['numofpost']) ? $atts['numofpost'] : '';
    $taxonomy = isset($atts['taxonomy']) ? $atts['taxonomy'] : '';
    $orderby = isset($atts['orderby']) ? $atts['orderby'] : '';
    $posttypename = isset($atts['posttypename']) ? $atts['posttypename'] : '';
$page_numbr = get_query_var('paged');
    $args = array(
        'post_type' => 'jobs',
        'post_status' => 'publish',
        'posts_per_page' => $numofpost,
         'paged' => $page_numbr,
        'order' => 'DESC',
        'orderby' => $orderby,
 
    );

   $query = new WP_Query($args);
    $total_posts = $query->found_posts;
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
                $location = worplex_post_location_str($post->ID);

            $job_type = get_post_meta($post->ID, 'worplex_field_job_type', true);
            $jobtype_ar = worplex_job_type_ret_str($job_type);
            $job_type_label = isset($jobtype_ar['title']) ? $jobtype_ar['title'] : '';
            $job_type_clor = isset($jobtype_ar['color']) ? $jobtype_ar['color'] : '';
            $job_type_bgclor = isset($jobtype_ar['bg_color']) ? $jobtype_ar['bg_color'] : '';
   
 $terms = get_the_terms($postid, 'job_skill'); 
 If (empty($terms)) {
    $terms = array();
}
                         $total_lenght = count($terms);
                        
                        $remaining_length = 0;
                        if($total_lenght > 5){
                            $remaining_length = 5 - $total_lenght;  // 6
                        }
        
            $image = wp_get_attachment_image_src(get_post_thumbnail_id($postid), 'single-post-thumbnail');
            
             if (isset($_REQUEST['view']) && $_REQUEST['view'] == 'grid'){
                
                ob_start();
                ?>
                 <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12">
									<div class="job_grid border rounded ">
										<div class="position-absolute ab-left"><button type="button" class="p-3 border circle d-flex align-items-center justify-content-center bg-white text-gray"><i class="lni lni-heart-filled position-absolute snackbar-wishlist"></i></button></div>
										<div class="position-absolute ab-right"><span class="medium bg-light-purple text-purple px-2 py-1 rounded" style="background:<?php echo $job_type_bgclor; ?> !important; color:<?php echo $job_type_clor ?> !important;"><?php echo $job_type_label ?></span></div>
										<div class="job_grid_thumb mb-2 pt-4 px-3">
											<a href="<?php echo $permalinkget ?>" class="d-block text-center m-auto"><img src="<?php echo $image[0] ?>" class="img-fluid" width="70" alt="" /></a>
										</div>
										<div class="job_grid_caption text-center pb-3 px-3">
											<h4 class="mb-0 ft-medium medium"><a href="<?php echo $permalinkget ?>" class="text-dark fs-md"><?php echo $title ?></a></h4>
											<div class="jbl_location"><i class="lni lni-map-marker me-1"></i><span><?php echo $location ?></span></div>
										</div>
										<div class="job_grid_footer pt-2 pb-4 px-3 d-flex align-items-center justify-content-between">
											<div class="row">
												<div class="df-1 text-muted col-6 mb-2"  style="color:<?php echo $font_color ?>;"><i class="lni lni-briefcase me-1"></i><?php echo $time_tag ?></div>
												<div class="df-1 text-muted col-6 mb-2"><i class="lni lni-wallet me-1"></i><?php echo $min_salery ?>$ - <?php echo $max_salery ?>$  <?php echo $salery_type ?></div>
												<div class="df-1 text-muted col-6"><i class="lni lni-users me-1"></i><?php echo $vocansies ?> Opp.</div>
												<div class="df-1 text-muted col-6"><i class="lni lni-timer me-1"></i><?php echo $minut ?> ago</div>
												<div class="df-1 text-dark ft-medium col-12 mt-3"><a href="<?php echo $permalinkget ?>" class="btn gray apply-btn rounded full-width">Apply Job<i class="lni lni-arrow-right-circle ms-1"></i></a></div>
											</div>
										</div>
									</div>
								</div>
                  <?php
                $output .= ob_get_clean();
                
                
            } else{
            
            
            $output .= '<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="jbr-wrap text-left border rounded">
            <div class="cats-box mlb-res rounded bg-white d-flex align-items-center justify-content-between px-3 py-3">
                <div class="cats-box rounded bg-white d-flex align-items-center">
                    <div class="text-center"><img src="'.$image[0].'" class="img-fluid" width="55" alt=""></div>
                    <div class="cats-box-caption px-2">
                        <h4 class="fs-md mb-0 ft-medium">'.$title.' ('.$experiance.' Exp.)</h4>
                        <div class="d-block mb-2 position-relative">
                            <span class="text-muted medium"><i class="lni lni-map-marker me-1"></i>'.$location.'</span>
                            <span class="muted medium ms-2 theme-cl" style="color:'.$job_type_clor.' !important;" ><i class="lni lni-briefcase me-1"></i>'.$job_type_label.'</span>
                        </div>
                    </div>
                </div>
                <div class="text-center mlb-last"><a href="'.$permalinkget.'" class="btn gray ft-medium apply-btn fs-sm rounded">'.esc_html('Apply Job', 'worplex-frame').'<i class="lni lni-arrow-right-circle ms-1"></i></a></div>
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
            $output .= '

    </div>  
</div>
</div>
</section>
			';
}
		elseif($atts['job_search_cat'] == 'view_five'){
		    
		    
		$numofpost = isset($atts['numofpost']) ? $atts['numofpost'] : '';
        $taxonomy = isset($atts['taxonomy']) ? $atts['taxonomy'] : '';
        $orderby = isset($atts['orderby']) ? $atts['orderby'] : '';
        $posttypename = isset($atts['posttypename']) ? $atts['posttypename'] : '';
        $page_numbr = get_query_var('paged');
        
        $args = array(
        'post_type' => 'jobs',
        'post_status' => 'publish',
        'posts_per_page' => $numofpost,
        'paged' => $page_numbr,
        'order' => 'DESC',
        'orderby' => $orderby,
        
        );
        
        $query = new WP_Query($args);
        $total_posts = $query->found_posts;
    $output.='	<section class="bg-light middle">
    <div class="container">
        
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-12">
                <div class="row align-items-center justify-content-between mx-0 bg-white rounded py-2 mb-4">
                    <div class="col-xl-3 col-lg-4 col-md-5 col-sm-12">
                        <h6 class="mb-0 ft-medium fs-sm">'. $total_posts .' Jobs Found</h6>
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
                            
                              $output.='<a href="?view=grid" class="simple-button '.$gridactiveclass.' me-1"><i class="ti-layout-grid2"></i></a>
                                <a href="?view=list" class="simple-button"><i class="ti-view-list '.$listactiveclass.'"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- row -->
        <div class="row align-items-center g-xl-3 g-lg-3 g-md-3 g-3">';

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

$location = worplex_post_location_str($post->ID);

$job_type = get_post_meta($post->ID, 'worplex_field_job_type', true);
$jobtype_ar = worplex_job_type_ret_str($job_type);
$job_type_label = isset($jobtype_ar['title']) ? $jobtype_ar['title'] : '';
$job_type_clor = isset($jobtype_ar['color']) ? $jobtype_ar['color'] : '';
$job_type_bgclor = isset($jobtype_ar['bg_color']) ? $jobtype_ar['bg_color'] : '';

$image = wp_get_attachment_image_src(get_post_thumbnail_id($postid), 'single-post-thumbnail');

if (isset($_REQUEST['view']) && $_REQUEST['view'] == 'list'){
                
                ob_start();
                ?>
                
                 <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="jbr-wrap text-left border rounded">
            <div class="cats-box mlb-res rounded bg-white d-flex align-items-center justify-content-between px-3 py-3">
                <div class="cats-box rounded bg-white d-flex align-items-center">
                    <div class="text-center"><img src="<?php echo $image[0] ?>" class="img-fluid" width="55" alt=""></div>
                    <div class="cats-box-caption px-2">
                        <h4 class="fs-md mb-0 ft-medium"><?php echo $title ?> (<?php echo $experiance?> Exp.)</h4>
                        <div class="d-block mb-2 position-relative">
                            <span class="text-muted medium"><i class="lni lni-map-marker me-1"></i><?php echo $location ?></span>
                            <span class="muted medium ms-2 theme-cl" style="color:<?php echo $job_type_clor ?> !important;" ><i class="lni lni-briefcase me-1"></i><?php echo $job_type_label ?></span>
                        </div>
                    </div>
                </div>
                <div class="text-center mlb-last"><a href="<?php echo $permalinkget ?>" class="btn gray ft-medium apply-btn fs-sm rounded"><?php echo esc_html('Apply Job', 'worplex-frame')?><i class="lni lni-arrow-right-circle ms-1"></i></a></div>
            </div>
        </div>
    </div>
                
                
                
                 <?php
                $output .= ob_get_clean();
                
                
            } else{

$output .= ' <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
							<div class="jbr-wrap text-left border rounded">
								<div class="cats-box mlb-res rounded bg-white d-flex align-items-center justify-content-between px-3 py-3">
									<div class="cats-box rounded bg-white d-flex align-items-center">
										<div class="text-center"><img src="'.$image[0].'" class="img-fluid" width="55" alt=""></div>
										<div class="cats-box-caption px-2">
											<h4 class="fs-md mb-0 ft-medium">'.$title.' ('.$experiance.' Exp.)</h4>
											<div class="d-block mb-2 position-relative">
												<span class="text-muted medium"><i class="lni lni-map-marker me-1"></i>'.$location.'</span>
												<span style="background:'.$job_type_bgclor.' !important;" style="color:'.$job_type_clor.';" class="muted medium ms-2 theme-cl"><i class="lni lni-briefcase me-1"></i>'.$job_type_label.'</span>
											</div>
										</div>
									</div>
									<div class="text-center mlb-last"><a href="'.$permalinkget.'" class="btn gray ft-medium apply-btn fs-sm rounded">'.esc_html__('Apply Job','worplex-frame').'<i class="lni lni-arrow-right-circle ms-1"></i></a></div>
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
$output .= '
</div>
</section>';
}	

elseif($atts['job_search_cat'] == 'view_six'){ 
    $output .= '<section class="py-2 br-bottom br-top">
    <div class="container">
        <div class="row align-items-center justify-content-between">
            <div class="col-xl-3 col-lg-4 col-md-5 col-sm-12">
                <h6 class="mb-0 ft-medium fs-sm">'.$total_posts.' Jobs Found</h6>
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
                       $output.='<a href="?view=grid" class="simple-button '.$gridactiveclass.' me-1"><i class="ti-layout-grid2"></i></a>
                        <a href="?view=list" class="simple-button"><i class="ti-view-list '.$listactiveclass.'"></i></a>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
</section>
<!-- ============================= Filter Wrap ============================== -->

<!-- ============================ Main Section Start ================================== -->
<section class="bg-light worplex-section-tbpading">
    <div class="container">
        <div class="row">
            
            <div class="col-lg-4 col-md-12 col-sm-12">
                <div class="bg-white rounded mb-4">							
                
                    <div class="sidebar_header d-flex align-items-center justify-content-between px-4 py-3 br-bottom">
                        <h4 class="ft-medium fs-lg mb-0">Search Filter</h4>
                        <div class="ssh-header">
                            <a href="' . $page_url . '" class="clear_all ft-medium text-muted">Clear All</a>
                            <a href="#search_open" data-bs-toggle="collapse" aria-expanded="false" role="button" class="collapsed _filter-ico ms-2"><i class="lni lni-text-align-right"></i></a>
                        </div>
                    </div>
                    
                    <!-- Find New Property -->
                    <div class="sidebar-widgets collapse miz_show" id="search_open" data-parent="#search_open">
                        
                        <div class="search-inner">
                            
                            <div class="filter-search-box px-4 pt-3 pb-0">
                                <div class="form-group">
                                    <input type="text" class="form-control" name="s" placeholder="Search by keywords...">
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control" placeholder="Location, Zip..">
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

                                                        $categories =  get_terms([
                                                            'taxonomy' => 'job_category',
                                                            'hide_empty' => false,
                                                        ]);
                                                        foreach ( $categories as $category ) {
                                                            $term_link = get_term_link( $category );
   

                                                            $output .='

                                                            <li>
                                                                <input id="a1" class="checkbox-custom" name="ADA" type="checkbox" checked="">
                                                                <label for="a1" class="checkbox-custom-label">'.$category->name.'</label>
                                                           </li>';
                                                              
                                                            }
                                                        
                                                        $output .='                                        
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                   
                                <!-- Expected Salary Search -->
                                <div class="single_search_boxed px-4 pt-0">
                                    <div class="widget-boxed-header">
                                        <h4>
                                            <a href="#salary" data-bs-toggle="collapse" aria-expanded="false" role="button" class="ft-medium fs-md pb-0 collapsed">Expected Salary</a>
                                        </h4>
                                        
                                    </div>
                                    <div class="widget-boxed-body collapse" id="salary" data-parent="#salary">
                                        <div class="side-list no-border">
                                            <!-- Single Filter Card -->
                                            <div class="single_filter_card">
                                                <div class="card-body p-0">
                                                    <div class="inner_widget_link">
                                                        <ul class="no-ul-list filter-list">
                                                            <li>
                                                                <input id="g1" class="checkbox-custom" name="ADA" type="checkbox" checked="">
                                                                <label for="g1" class="checkbox-custom-label">$120k - $140k PA</label>
                                                            </li>
                                                            <li>
                                                                <input id="g2" class="checkbox-custom" name="Parking" type="checkbox">
                                                                <label for="g2" class="checkbox-custom-label">$140k - $150k PA</label>
                                                            </li>
                                                            <li>
                                                                <input id="g3" class="checkbox-custom" name="Coffee" type="checkbox">
                                                                <label for="g3" class="checkbox-custom-label">$150k - $170k PA</label>
                                                            </li>
                                                            <li>
                                                                <input id="g4" class="checkbox-custom" name="Mother" type="checkbox">
                                                                <label for="g4" class="checkbox-custom-label">$170k - $190k PA</label>
                                                            </li>
                                                            <li>
                                                                <input id="g5" class="checkbox-custom" name="Outdoor" type="checkbox">
                                                                <label for="g5" class="checkbox-custom-label">$200k - $250k PA</label>
                                                            </li>
                                                            <li>
                                                                <input id="g6" class="checkbox-custom" name="Pet" type="checkbox">
                                                                <label for="g6" class="checkbox-custom-label">$250k - $300k PA</label>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                            
                            <div class="form-group filter_button pt-2 pb-4 px-4">
                                <button type="button" class="btn btn-md theme-bg text-light rounded full-width">22 Results Show</button>
                            </div>
                        </div>							
                    </div>
                </div>
                <!-- Sidebar End -->
            
            </div>
            
            <!-- Item Wrap Start -->
            <div class="col-lg-8 col-md-12 col-sm-12">
                
                <!-- row -->
                <div class="row align-items-center g-xl-3 g-lg-3 g-md-3 g-3">';

    $numofpost = isset($atts['numofpost']) ? $atts['numofpost'] : '';
    $taxonomy = isset($atts['taxonomy']) ? $atts['taxonomy'] : '';
    $orderby = isset($atts['orderby']) ? $atts['orderby'] : '';
    $posttypename = isset($atts['posttypename']) ? $atts['posttypename'] : '';
$page_numbr = get_query_var('paged');
    $args = array(
        'post_type' => 'jobs',
        'post_status' => 'publish',
        'posts_per_page' => $numofpost,
         'paged' => $page_numbr,
        'order' => 'DESC',
        'orderby' => $orderby,
 
    );

   $query = new WP_Query($args);
    $total_posts = $query->found_posts;
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
           
             if (isset($_REQUEST['view']) && $_REQUEST['view'] == 'list'){
                
                ob_start();
                ?>
                   <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
									<div class="jbr-wrap text-left border rounded">
										<div class="cats-box mlb-res rounded bg-white d-flex align-items-center justify-content-between px-3 py-3">
											<div class="cats-box rounded bg-white d-flex align-items-center">
												<div class="text-center"><img src="<?php echo $image[0] ?>" class="img-fluid" width="55" alt=""></div>
												<div class="cats-box-caption px-2">
													<h4 class="fs-md mb-0 ft-medium"><?php echo $title ?> (<?php echo $experiance ?> Exp.)</h4>
													<div class="d-block mb-2 position-relative">
														<span class="text-muted medium"><i class="lni lni-map-marker me-1"></i><?php echo $location ?></span>
														<span class="muted medium ms-2 theme-cl"><i class="lni lni-briefcase me-1" style="color:<?php echo $job_type_clor ?>"></i><?php echo $job_type_label ?></span>
													</div>
												</div>
											</div>
											<div class="text-center mlb-last"><a href="<?php echo $permalinkget?> " class="btn gray ft-medium apply-btn fs-sm rounded">Apply Job<i class="lni lni-arrow-right-circle ms-1"></i></a></div>
										</div>
									</div>
								</div>
                
                
                <?php
                   $output .= ob_get_clean();
                
                
            } else{
                $output .= '
                    
                    <div class="job_grid d-block border rounded px-3 pt-3 pb-2 mb-3">
                    <div class="jb-list01">
                        <div class="jb-list-01-title"><h5 class="ft-medium mb-1"><a href="' . get_permalink(get_the_id()) . '">'.$title.'</a></h5></div>
                        <div class="jb-list-01-info d-block mb-3">
                            <span class="text-muted me-2"><i class="lni lni-map-marker me-1"></i>'. $location.'</span>
                            <span class="text-muted me-2"><i class="lni lni-briefcase me-1"></i>'.$job_type_label.'</span>
                            <span class="text-muted me-2"><i class="lni lni-money-protection me-1"></i>$'.$min_salery.' - $'.$max_salery.'</span>
                        </div>
                        <div class="jb-list-01-title">';
                                
                        $coutner = 0;
                            foreach($terms as $term){
                                $coutner++;
                               
                           $current_term_link = get_term_link( $term->slug, 'job_category' );
                                  $output.= '
                            <span  class="me-2 mb-2 d-inline-flex px-2 py-1 rounded theme-cl theme-bg-light">'.$term->name.'</span>';
                            }
                            $output.='     
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
            $output .= '
       			
            </div>
            </div>
          </div>
        </div>
    </section>';
}
						 return $output;
				}
			add_shortcode('job_search_v_one', 'job_search_v_one_frontend');
			
			
			
			
// 			Function for get Post By Category 



function worplex_jobs_simples_list($list_args) {

 
    $output = '';
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
	if (isset($_REQUEST['jobs_category'])) {
		$job_category = $_REQUEST['jobs_category'];
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
			'key' => 'worplex_field_loc_address',
			'value' => esc_html($location),
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
						$excerpt = get_the_excerpt($postid);

						// 
						$current_user = wp_get_current_user();
						$comment = sprintf(esc_html__('%s Comment', 'adhividayam'), get_comments_number($postid));
						
						$date = date('M d Y');
					   
						$posted = get_the_time('U');
							$minut =  human_time_diff($posted,current_time( 'U' )). "";

			$time_tag = get_post_meta($post->ID, 'worplex_field_time_tag', true);
			$backgropund_color = get_post_meta($post->ID, 'worplex_field_background_color', true);
			$font_color = get_post_meta($post->ID, 'worplex_field_font_color', true);
			$location = worplex_post_location_str($post->ID);

			$job_type = get_post_meta($post->ID, 'worplex_field_job_type', true);
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


						$fav_jobs = get_user_meta($user_id, 'fav_jobs_list', true);

						$fav_jobs = !empty($fav_jobs) ? $fav_jobs : array();

						$like_btn_class = 'worplex-favjab-btn';
						$fav_icon_class = 'lni lni-heart';
						if (in_array($postid, $fav_jobs)) {
							$like_btn_class = 'worplex-alrdy-favjab';
							$fav_icon_class = 'lni lni-heart-filled';
						}

						

						$output .='<div class="col-xl-4 col-lg-6 col-md-6 col-sm-12">
						<div class="job_grid border rounded ">
					 <div class="position-absolute ab-left"><button type="button" 
					 class="p-3 border circle d-flex align-items-center justify-content-center bg-white text-gray '.$like_btn_class.'" data-id="'.$postid.'">
					 <i class="'.$fav_icon_class.' position-absolute"></i></button></div>
						<div class="position-absolute ab-right"><span style="color:'.$job_type_clor.' !important;background:'.$job_type_bgclor.' !important;" class="medium theme-cl theme-bg-light px-2 py-1 rounded">'.$job_type_label.'</span></div>
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
													  $output.= ' <li><span class="px-2 py-1 medium skill-bg rounded text-skill"><a href="'.$current_term_link.'" >'.$term->name.'</a></span></li>';
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
    
    else {$output .= '<p>No job found.</p>';
	}
   	if ($total_posts > $numofpost) {
		$output .= worplex_pagination($query, true);
		}
	 // Restore original post data.
		wp_reset_postdata();
	 
		

		return $output;
}


add_action('wp_ajax_worplex_job_filters_submit_call', 'worplex_simple_jobs_filters_submit_call');
add_action('wp_ajax_nopriv_worplex_job_filters_submit_call', 'worplex_simple_jobs_filters_submit_call');

function worplex_simple_jobs_filters_submit_call() {

	$atts = array(
		'numofpost' => $_POST['numposts'],
		'orderby' => $_POST['orderby']
	);

	$html = worplex_jobs_simples_list($atts);

	wp_send_json(array('html' => $html));
}			