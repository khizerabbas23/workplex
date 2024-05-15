<?php
function browse_employers()
{
    vc_map(

        array(
            'name' => __('Browse Employers'),
            'base' => 'browse_employers',
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
add_action('vc_before_init', 'browse_employers');

// popular category frontend
function browse_employers_frontend($atts, $content)
{

    global $employer_browse_totl_res;
    
    $atts = shortcode_atts(
        array(

          
            'posttypename' => '',
            'orderby' => '',
            'taxonomy' => '',
            'numofpost' => '',


        ),
        $atts,
        'browse_employers'
    );
    
    $page_id = get_the_id();
    $page_url = get_permalink($page_id);

    $output = '';
    
    $employers_list_html = worplex_jobs_employer_simple_list($atts);

    $custom_plan_price = isset($atts['nb_medicaltitle']) && !empty($atts['nb_medicaltitle']) ? $atts['nb_medicaltitle'] : '';
    $total_posts = get_total_post_count();

	$numofpost = isset($atts['numofpost']) ? $atts['numofpost'] : '';

    $orderby = isset($atts['orderby']) ? $atts['orderby'] : '';
   
    $output .= '<div class="worplex-all-listing-con">
    <div class="row">
            <div class="col-lg-4 col-md-12 col-sm-12">
            
                <div class="bg-white rounded mb-4">	
                    <div class="sidebar_header d-flex align-items-center justify-content-between px-4 py-3 br-bottom">
                        <h4 class="ft-medium fs-lg mb-0">Search Filter</h4>
                        <div class="ssh-header">
                            <a href="'.$page_url.'" class="clear_all ft-medium text-muted">Clear All</a>
                            <a href="#search_open" data-bs-toggle="collapse" aria-expanded="false" role="button" class="collapsed _filter-ico ms-2"><i class="lni lni-text-align-right"></i></a>
                        </div>
                    </div>
                    
                    <!-- Find New Property -->
                    
					<form method="post" class="worplex-jobfilter-form">
                    <div class="sidebar-widgets collapse miz_show" id="search_open" data-parent="#search_open">
                        
                        <div class="search-inner">
                            
                            <div class="filter-search-box px-4 pt-3 pb-0">
                                <div class="form-group">
                                    <input type="text" name="keyword" class="form-control" placeholder="Search by keywords...">
                                </div>
                                <div class="form-group">
                                    <input type="text" name="location" class="form-control" placeholder="Location, Zip..">
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
                                                            'taxonomy' => 'employer_cat',
                                                            'hide_empty' => false,
                                                        ]);
                                                        foreach ( $categories as $category ) {
                                                            $term_link = get_term_link( $category );
                                                            
                                                            $args = array(
                                                                'post_type' => 'employer',
                                                                'tax_query' => array(
                                                                    array(
                                                                        'taxonomy' => 'employer_cat',
                                                                        'field' => 'slug',
                                                                        'terms' => $category->slug,
                                                                    ),
                                                                ),
                                                                
                                                                 'posts_per_page' => 0,
                                                                 
                                                             );
                                                            
                                                        //   $posts = wp_count_posts($args);
                                                        //   $total_posts = count($posts);

                                                            $output .='
                                                            <li>
                                                                <input id="'.$category->term_id.'" class="checkbox-custom" value="'.$category->slug.'" name="employer_cat" type="radio" unchecked="">
                                                                <label for="'.$category->term_id.'" class="checkbox-custom-label">'.$category->name.' </label>
                                                                
                                                            </li>';
                                                        }
                                                        $output .='</ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Job Locations Search -->
                                <div class="single_search_boxed px-4 pt-0 br-bottom">
                                    <div class="widget-boxed-header">
                                        <h4>
                                            <a href="#locations" data-bs-toggle="collapse" aria-expanded="false" role="button" class="ft-medium fs-md pb-0 collapsed">Job Locations</a>
                                        </h4>
                                        
                                    </div>
                                    <div class="widget-boxed-body collapse" id="locations" data-parent="#locations">
                                        <div class="side-list no-border">
                                            <!-- Single Filter Card -->
                                            <div class="single_filter_card">
                                                <div class="card-body p-0">
                                                    <div class="inner_widget_link">
                                                        <ul class="no-ul-list filter-list">
                                                            <li>
                                                                <input id="b1" class="checkbox-custom" name="ADA" type="checkbox" checked="">
                                                                <label for="b1" class="checkbox-custom-label">Australia (21)</label>
                                                            </li>
                                                            <li>
                                                                <input id="b2" class="checkbox-custom" name="Parking" type="checkbox">
                                                                <label for="b2" class="checkbox-custom-label">New Zeland (12)</label>
                                                            </li>
                                                            <li>
                                                                <input id="b3" class="checkbox-custom" name="Coffee" type="checkbox">
                                                                <label for="b3" class="checkbox-custom-label">United Kingdom (21)</label>
                                                                <ul class="no-ul-list filter-list">
                                                                    <li>
                                                                        <input id="ac1" class="checkbox-custom" name="ADA" type="checkbox">
                                                                        <label for="ac1" class="checkbox-custom-label">London (06)</label>
                                                                    </li>
                                                                    <li>
                                                                        <input id="ac2" class="checkbox-custom" name="Parking" type="checkbox">
                                                                        <label for="ac2" class="checkbox-custom-label">Manchester (07)</label>
                                                                    </li>
                                                                    <li>
                                                                        <input id="ac3" class="checkbox-custom" name="Coffee" type="checkbox">
                                                                        <label for="ac3" class="checkbox-custom-label">Birmingham (08)</label>
                                                                    </li>
                                                                </ul>
                                                            </li>
                                                            <li>
                                                                <input id="b4" class="checkbox-custom" name="Mother" type="checkbox">
                                                                <label for="b4" class="checkbox-custom-label">United State (04)</label>
                                                                <ul class="no-ul-list filter-list">
                                                                    <li>
                                                                        <input id="ad1" class="checkbox-custom" name="ADA" type="checkbox">
                                                                        <label for="ad1" class="checkbox-custom-label">New York (32)</label>
                                                                    </li>
                                                                    <li>
                                                                        <input id="ad2" class="checkbox-custom" name="Parking" type="checkbox">
                                                                        <label for="ad2" class="checkbox-custom-label">Washington (42)</label>
                                                                    </li>
                                                                    <li>
                                                                        <input id="ad3" class="checkbox-custom" name="Coffee" type="checkbox">
                                                                        <label for="ad3" class="checkbox-custom-label">Los Angeles (22)</label>
                                                                    </li>
                                                                </ul>
                                                            </li>
                                                            <li>
                                                                <input id="b5" class="checkbox-custom" name="Outdoor" type="checkbox">
                                                                <label for="b5" class="checkbox-custom-label">India (15)</label>
                                                            </li>
                                                            <li>
                                                                <input id="b6" class="checkbox-custom" name="Pet" type="checkbox">
                                                                <label for="b6" class="checkbox-custom-label">Singapore (09)</label>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Job Skills Search -->
                                <div class="single_search_boxed px-4 pt-0 br-bottom">
                                    <div class="widget-boxed-header">
                                        <h4>
                                            <a href="#skills" data-bs-toggle="collapse" aria-expanded="false" role="button" class="ft-medium fs-md pb-0 collapsed">Skills</a>
                                        </h4>
                                        
                                    </div>
                                    <div class="widget-boxed-body collapse" id="skills" data-parent="#skills">
                                        <div class="side-list no-border">
                                            <!-- Single Filter Card -->
                                            <div class="single_filter_card">
                                                <div class="card-body p-0">
                                                    <div class="inner_widget_link">
                                                        <ul class="no-ul-list filter-list">
                                                          ';
                                                            $categories =  get_terms([
                                                            'taxonomy' => 'job_skill',
                                                            'hide_empty' => false,
                                                        ]);
                                                        foreach ( $categories as $category ) {
                                                            $term_link = get_term_link( $category );
                                                            
                                                            $args = array(
                                                                'post_type' => 'jobs',
                                                                'tax_query' => array(
                                                                    array(
                                                                        'taxonomy' => 'job_skill',
                                                                        'field' => 'slug',
                                                                        'terms' => $category->slug,
                                                                    ),
                                                                ),
                                                                 'posts_per_page' => 0,
                                                                 
                                                             );
                                                            
                                                        //   $posts = wp_count_posts($args);
                                                        //   $total_posts = count($posts);

                                                            $output .='
                                                              <li>
                                                                <input id="'.$category->term_id.'" class="checkbox-custom" value="'.$category->slug.' name="employers_cat" type="radio" unchecked="">
                                                                <label for="'.$category->term_id.'" class="checkbox-custom-label">'.$category->name.'</label>
                                                            </li>
                                                            ';
                                                        }
                                                        $output.='
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Experience Search -->
                                <div class="single_search_boxed px-4 pt-0 br-bottom">
                                    <div class="widget-boxed-header">
                                        <h4>
                                            <a href="#experience" data-bs-toggle="collapse" aria-expanded="false" role="button" class="ft-medium fs-md pb-0 collapsed">Experience</a>
                                        </h4>
                                        
                                    </div>
                                    <div class="widget-boxed-body collapse" id="experience" data-parent="#experience">
                                        <div class="side-list no-border">
                                            <!-- Single Filter Card -->
                                            <div class="single_filter_card">
                                                <div class="card-body p-0">
                                                    <div class="inner_widget_link">
                                                        <ul class="no-ul-list filter-list">
                                                            <li>
                                                                <input id="d1" class="checkbox-custom" name="ADA" type="checkbox" checked="">
                                                                <label for="d1" class="checkbox-custom-label">Beginner (54)</label>
                                                            </li>
                                                            <li>
                                                                <input id="d2" class="checkbox-custom" name="Parking" type="checkbox">
                                                                <label for="d2" class="checkbox-custom-label">1+ Year (32)</label>
                                                            </li>
                                                            <li>
                                                                <input id="d3" class="checkbox-custom" name="Coffee" type="checkbox">
                                                                <label for="d3" class="checkbox-custom-label">2 Year (09)</label>
                                                            </li>
                                                            <li>
                                                                <input id="d4" class="checkbox-custom" name="Mother" type="checkbox">
                                                                <label for="d4" class="checkbox-custom-label">3+ Year (16)</label>
                                                            </li>
                                                            <li>
                                                                <input id="d5" class="checkbox-custom" name="Outdoor" type="checkbox">
                                                                <label for="d5" class="checkbox-custom-label">4+ Year (17)</label>
                                                            </li>
                                                            <li>
                                                                <input id="d6" class="checkbox-custom" name="Pet" type="checkbox">
                                                                <label for="d6" class="checkbox-custom-label">5+ Year (22)</label>
                                                            </li>
                                                            <li>
                                                                <input id="d7" class="checkbox-custom" name="Beauty" type="checkbox">
                                                                <label for="d7" class="checkbox-custom-label">10+ Year (32)</label>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Job types Search -->
                                <div class="single_search_boxed px-4 pt-0 br-bottom">
                                    <div class="widget-boxed-header">
                                        <h4>
                                            <a href="#jbtypes" data-bs-toggle="collapse" aria-expanded="false" role="button" class="ft-medium fs-md pb-0 collapsed">Job Type</a>
                                        </h4>
                                        
                                    </div>
                                    <div class="widget-boxed-body collapse" id="jbtypes" data-parent="#jbtypes">
                                        <div class="side-list no-border">
                                            <!-- Single Filter Card -->
                                            <div class="single_filter_card">
                                                <div class="card-body p-0">
                                                    <div class="inner_widget_link">
                                                        <ul class="no-ul-list filter-list">
                                                            <li>
                                                                <input id="e2" class="radio-custom" name="jtype" type="radio">
                                                                <label for="e2" class="radio-custom-label">Full time</label>
                                                            </li>
                                                            <li>
                                                                <input id="e3" class="radio-custom" name="jtype" type="radio">
                                                                <label for="e3" class="radio-custom-label">Part Time</label>
                                                            </li>
                                                            <li>
                                                                <input id="e4" class="radio-custom" name="jtype" type="radio" checked="">
                                                                <label for="e4" class="radio-custom-label">Contract Base</label>
                                                            </li>
                                                            <li>
                                                                <input id="e5" class="radio-custom" name="jtype" type="radio">
                                                                <label for="e5" class="radio-custom-label">Internship</label>
                                                            </li>
                                                            <li>
                                                                <input id="e6" class="radio-custom" name="jtype" type="radio">
                                                                <label for="e6" class="radio-custom-label">Regular</label>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Job Level Search -->
                                <div class="single_search_boxed px-4 pt-0 br-bottom">
                                    <div class="widget-boxed-header">
                                        <h4>
                                            <a href="#jblevel" data-bs-toggle="collapse" aria-expanded="false" role="button" class="ft-medium fs-md pb-0 collapsed">Job Level</a>
                                        </h4>
                                        
                                    </div>
                                    <div class="widget-boxed-body collapse" id="jblevel" data-parent="#jblevel">
                                        <div class="side-list no-border">
                                            <!-- Single Filter Card -->
                                            <div class="single_filter_card">
                                                <div class="card-body p-0">
                                                    <div class="inner_widget_link">
                                                        <ul class="no-ul-list filter-list">
                                                            <li>
                                                                <input id="f1" class="checkbox-custom" name="ADA" type="checkbox" checked="">
                                                                <label for="f1" class="checkbox-custom-label">Team Leader</label>
                                                            </li>
                                                            <li>
                                                                <input id="f2" class="checkbox-custom" name="Parking" type="checkbox">
                                                                <label for="f2" class="checkbox-custom-label">Manager</label>
                                                            </li>
                                                            <li>
                                                                <input id="f3" class="checkbox-custom" name="Coffee" type="checkbox">
                                                                <label for="f3" class="checkbox-custom-label">Junior</label>
                                                            </li>
                                                            <li>
                                                                <input id="f4" class="checkbox-custom" name="Coffee" type="checkbox">
                                                                <label for="f4" class="checkbox-custom-label">Senior</label>
                                                            </li>
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
                            
                            <input type="hidden" name="numposts" value="' . $numofpost . '">
							<input type="hidden" name="orderby" value="' . $orderby . '">
							<input type="hidden" name="action" value="worplex_employer_job_filters_submit_call">
                            
                            
                                <button type="submit" class="btn btn-md theme-bg text-light rounded full-width">Results Show</button>
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
                                <h6 class="mb-0 ft-medium fs-sm">'.$employer_browse_totl_res.' Employers Found</h6>
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
        
                <!-- row -->
                <div class="row align-items-center worplex-alljobs-list">';
                $output .= $employers_list_html;
                
                    
            $output .= '
            </div>
							</div>
							<!-- row -->
							

							
						</div>
						
					</div>
					</div>
				
			';
			 return $output;
    }
add_shortcode('browse_employers', 'browse_employers_frontend');





// Ajax function

function worplex_jobs_employer_simple_list($list_args) {

    global $employer_browse_totl_res;
    
	$output = '<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">';


    $numofpost = isset($atts['numofpost']) ? $atts['numofpost'] : '';

    $orderby = isset($atts['orderby']) ? $atts['orderby'] : '';
    
    $page_numbr = get_query_var('paged');

    $args = array(
        'post_type' => 'employer',
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
	if (isset($_REQUEST['employer_cat'])) {
		$employer_cat = $_REQUEST['employer_cat'];
		$tax_query[] = array(
			'taxonomy' => 'employer_cat',
			'field' => 'slug',
			'terms' => $employer_cat,
		);
	}
	
	if (isset($_REQUEST['employers_cat'])) {
		$employers_cat = $_REQUEST['employers_cat'];
		$tax_query[] = array(
			'taxonomy' => 'job_skill',
			'field' => 'slug',
			'terms' => $employers_cat,
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
 


   $query = new WP_Query($args);
    // Check that we have query results.
    $total_posts = $employer_browse_totl_res = $query->found_posts;
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
$time_tag = get_post_meta($post->ID, 'worplex_field_time_tag', true);

$company_tag = get_post_meta($post->ID, 'worplex_field_company_tag', true);

$location = get_post_meta($post->ID, 'worplex_field_location', true);
$company_build = get_post_meta($post->ID, 'worplex_field_company_build', true);
$opening_posts = get_post_meta($post->ID, 'worplex_field_opening_posts', true);
$opening_total_employe = get_post_meta($post->ID, 'worplex_field_opening_total_employe', true);
        
            $image = wp_get_attachment_image_src(get_post_thumbnail_id($postid), 'single-post-thumbnail');
            $output .= '
            <div class="job_grid d-block border rounded px-3 pt-3 pb-2 mb-3">
            <div class="jb-list01-flex d-flex align-items-start justify-content-start">
                <div class="jb-list01-thumb">
                    <img src="'.$image[0].'" class="img-fluid" width="90" alt="" />
                </div>
                
                <div class="jb-list01 ps-3">
                    <div class="jb-list-01-title"><h5 class="ft-medium mb-1"><a href="'.$permalinkget.'">'.$title.'<img src="#" class="ms-1" width="12" alt=""></a></h5></div>
                    <div class="jb-list-01-info d-block mb-3">
                        <span class="text-muted me-2"><i class="lni lni-map-marker me-1"></i>'.$location.'</span>
                        <span class="text-muted me-2"><i class="lni lni-home me-1"></i>Buid '.$company_build.'</span>
                        <span class="text-muted me-2"><i class="lni lni-briefcase me-1"></i>'.$opening_posts.' Openings</span>
                        <span class="text-muted me-2"><i class="lni lni-users me-1"></i>'.$opening_total_employe.' Emploies</span>
                    </div>
                    <div class="jb-list-01-title d-inline">
                        <span class="me-2 mb-2 d-inline-flex px-2 py-1 rounded theme-cl theme-bg-light">'.$time_tag.'</span>
                        <span class="me-2 mb-2 d-inline-flex px-2 py-1 rounded text-warning bg-light-warning">'.$company_tag.' Company</span>
                    </div>
                </div>
            </div>
        </div>';
            

        }
    }else {
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

add_action('wp_ajax_worplex_employer_job_filters_submit_call', 'worplex_simple_employer_job_filters_submit_call');
add_action('wp_ajax_nopriv_worplex_employer_job_filters_submit_call', 'worplex_simple_employer_job_filters_submit_call');

function worplex_simple_employer_job_filters_submit_call() {

	$atts = array(
		'numofpost' => $_POST['numposts'],
		'orderby' => $_POST['orderby']
	);

	$html = worplex_jobs_employer_simple_list($atts);

	wp_send_json(array('html' => $html));
}







