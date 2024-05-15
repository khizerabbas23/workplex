<?php
function map_search_two()
{

    vc_map(

        array(
            'name' => __('Map Job Search'),
            'base' => 'map_search_two',
            'category' => __('Workplex'),
            'params' => array(
                array(
					'type' => 'dropdown',
					'holder' => 'div',
					'class' => '',
					'heading' => __( 'Map Job Search', 'workplex' ),
					'param_name' => 'map_search_cat',
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
add_action('vc_before_init', 'map_search_two');

// popular category frontend
function map_search_two_frontend($atts, $content)
{

    $atts = shortcode_atts(
        array(

            
            'map_search_cat' => '',
            'posttypename' => '',
            'orderby' => '',
            'taxonomy' => '',
            'numofpost' => '',


        ),
        $atts,
        'map_search_two'
    );
    
            wp_enqueue_script('worplex-google-map');
       
        wp_enqueue_script('worplex-map-infobox');
        wp_enqueue_script('worplex-markerclusterer');
         wp_enqueue_script('worplex-map');

    $output = '';
    $map_search_cat = isset($atts['map_search_cat']) ? $atts['map_search_cat'] : '';

    $custom_plan_price = isset($atts['nb_medicaltitle']) && !empty($atts['nb_medicaltitle']) ? $atts['nb_medicaltitle'] : '';
    $total_posts = get_total_post_count();
    if($atts['map_search_cat'] == 'view_one'){
    $output .='<div class="home-map-banner half-map">
				
    <div class="fs-left-map-box">
					<div class="home-map fl-wrap">
						<div class="hm-map-container fw-map">
							<div id="map"></div>
						</div>
					</div>
				</div>
               
    
    <div class="fs-inner-container">
        <div class="fs-content">
        
            <div class="row">
                <div class="col-xl-12 col-md-12 col-sm-12">
                    <div class="cl-justify">
                        
                        <div class="cl-justify-first">
                            <a class="ht-40 d-inline-flex align-items-center justify-content-center px-3 theme-bg text-light rounded" href="#" onclick="openSearch()"><i class="fa fa-sliders-h me-2"></i>Job Filter</a>
                        </div>
                        
                        <div class="cl-justify-last">
                            <div class="d-flex align-items-center justify-content-left">
                                <div class="dlc-list">
                                    <select class="form-select sm rounded">
                                        <option>All Jobs</option>
                                        <option>Full Time</option>
                                        <option>Part Time</option>
                                        <option>Freelancing</option>
                                        <option>Internship</option>
                                        <option>Contract</option>
                                    </select>
                                </div>
                                <div class="dlc-list ms-2">
                                    <select class="form-select sm rounded">
                                        <option>Show 20</option>
                                        <option>Show 30</option>
                                        <option>Show 40</option>
                                        <option>Show 50</option>
                                        <option>Show 100</option>
                                        <option>Show 250</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
            
            <!-- row -->
            <div class="row align-items-center">
            
                <!-- Single -->
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">';

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
 
    );

   $query = new WP_Query($args);
    $total_posts = $query->found_posts;
    // Check that we have query results.
    if ($query->have_posts()) {
        $jobs_array = array();
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
$location = get_post_meta($post->ID, 'worplex_field_location', true);
$latitude = get_post_meta($post->ID, 'worplex_field_latitude', true);
$longitude = get_post_meta($post->ID, 'worplex_field_longitude', true);
$job_type = get_post_meta($post->ID, 'worplex_field_job_type', true);
$hiring = get_post_meta($post->ID, 'worplex_field_hiring', true);
$min_salery = get_post_meta($post->ID, 'worplex_field_min_salery', true);
$max_salery = get_post_meta($post->ID, 'worplex_field_max_salery', true);

   
 $terms = get_the_terms($postid, 'skills_post'); 
 If (empty($terms)) {
    $terms = array();
}
                         $total_lenght = count($terms);
                        
                        $remaining_length = 0;
                        if($total_lenght > 5){
                            $remaining_length = 5 - $total_lenght;  // 6
                        }
        
            $image = wp_get_attachment_image_src(get_post_thumbnail_id($postid), 'single-post-thumbnail');
            $jobs_array[] = array(
                'title' => $title,
                'image' => $image,
                'location' => $location,
                'permalink' => $permalinkget,
                'latitude' => $latitude,
                'longitude' => $longitude,
                'jobtype' => $job_type,
            );
            $output .= '

            <div class="jbr-wrap text-left border rounded mb-3">
            <div class="cats-box rounded bg-white d-flex align-items-start justify-content-between px-3 py-3">
                <div class="cats-box rounded bg-white d-flex align-items-start">
                    <div class="text-center"><img src="'.$image[0].'" class="img-fluid" width="70" alt=""></div>
                    <div class="cats-box-caption ps-3">
                        <div class="jb-list01">
                            <div class="jb-list-01-title"><h5 class="ft-medium mb-1"><a href="'.$permalinkget.'">'.$title.'</a></h5></div>
                            <div class="jb-list-01-info d-block mb-2">
                                <span class="text-muted me-2"><i class="lni lni-map-marker me-1"></i>'.$location .'</span>
                                <span class="text-muted me-2"><i class="lni lni-briefcase me-1"></i>'.$job_type.'</span>
                                <span class="text-muted me-2"><i class="lni lni-star-filled me-1"></i>'.$hiring.'</span>
                                <span class="text-muted me-2"><i class="lni lni-money-protection me-1"></i>$'.$min_salery.'- $'.$max_salery.'</span>
                            </div>
                        </div>
                        <div class="jb-list-01-title fs-sm">                     
                      
        ';
                                
                                $coutner = 0;
                                    foreach($terms as $term){
                                        $coutner++;
                                 
                                          $output.= ' <span class="me-2 mb-2 d-inline-flex px-2 py-1 rounded text-info bg-light-info" style="background:'.$backgropund_color.';">'.$term->name.'</span>';
                                          if($coutner > 2){
										           break;
                                        } 
                                    }

                            $output.='        
                            </div>
                            </div>
                        </div>
                        <div class="text-center"><button type="button" class="p-3 border circle d-flex align-items-center justify-content-center bg-white text-gray"><i class="lni lni-heart-filled position-absolute snackbar-wishlist"></i></button></div>
                    </div>
                </div>';

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
				
			</div>
			<div class="clearfix"></div>
			<!-- ============================ Hero Banner End ================================== -->
			
		
			
			<!-- Search -->
			<div class="w3-ch-sideBar w3-bar-block w3-card-2 w3-animate-right" style="display:none;right:0;" id="Search">
				<div class="rightMenu-scroll">
					<div class="d-flex align-items-center justify-content-between slide-head py-3 px-3">
						<h4 class="cart_heading fs-md ft-medium mb-0">Job Filter Option</h4>
						<button onclick="closeSearch()" class="close_slide"><i class="ti-close"></i></button>
					</div>
						
					<div class="search-inner">
										
						<div class="filter-search-box px-4 pt-3 pb-0">
							<div class="form-group">
								<input type="text" class="form-control" placeholder="Search by keywords...">
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
													<ul class="no-ul-list filter-list">
														<li>
															<input id="a1" class="checkbox-custom" name="ADA" type="checkbox" checked="">
															<label for="a1" class="checkbox-custom-label">IT Computers (62)</label>
															<ul class="no-ul-list filter-list">
																<li>
																	<input id="aa1" class="checkbox-custom" name="ADA" type="checkbox">
																	<label for="aa1" class="checkbox-custom-label">Web Design (31)</label>
																</li>
																<li>
																	<input id="aa2" class="checkbox-custom" name="Parking" type="checkbox">
																	<label for="aa2" class="checkbox-custom-label">Web development (20)</label>
																</li>
																<li>
																	<input id="aa3" class="checkbox-custom" name="Coffee" type="checkbox">
																	<label for="aa3" class="checkbox-custom-label">SEO Services (43)</label>
																</li>
															</ul>
														</li>
														<li>
															<input id="a2" class="checkbox-custom" name="Parking" type="checkbox">
															<label for="a2" class="checkbox-custom-label">Financial Service (16)</label>
														</li>
														<li>
															<input id="a3" class="checkbox-custom" name="Coffee" type="checkbox">
															<label for="a3" class="checkbox-custom-label">Art, Design, Media (22)</label>
														</li>
														<li>
															<input id="a4" class="checkbox-custom" name="Mother" type="checkbox">
															<label for="a4" class="checkbox-custom-label">Coach &amp; Education (21)</label>
														</li>
														<li>
															<input id="a5" class="checkbox-custom" name="Outdoor" type="checkbox">
															<label for="a5" class="checkbox-custom-label">Apps Developements (17)</label>
															<ul class="no-ul-list filter-list">
																<li>
																	<input id="ab1" class="checkbox-custom" name="ADA" type="checkbox">
																	<label for="ab1" class="checkbox-custom-label">IOS Development (12)</label>
																</li>
																<li>
																	<input id="ab2" class="checkbox-custom" name="Parking" type="checkbox">
																	<label for="ab2" class="checkbox-custom-label">Android Development (04)</label>
																</li>
															</ul>
														</li>
														<li>
															<input id="a6" class="checkbox-custom" name="Pet" type="checkbox">
															<label for="a6" class="checkbox-custom-label">Writing &amp; Translation (04)</label>
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
							<button type="button" class="btn btn-md theme-bg text-light rounded full-width">22 Results Show</button>
						</div>
					</div>
					
				</div>
			</div>
			
			<a id="back2Top" class="top-scroll" title="Back to top" href="#"><i class="ti-arrow-up"></i></a>
			

		</div>
		 '.worplex_listing_map_js($jobs_array).';
			';
}


			 return $output;
    }

add_shortcode('map_search_two', 'map_search_two_frontend');



function worplex_listing_map_js($jobs_array){
    
?>
<script>
jQuery( document ).ready(function() {
!(function (o) {
    Array.prototype.forEach ||
        (o.forEach =
            o.forEach ||
            function (o, e) {
                for (var t = 0, r = this.length; t < r; t++) t in this && o.call(e, this[t], t, this);
            });
})(Array.prototype);
var mapObject,
    marker,
    markers = [],
    markersData = {
        Marker: [

            <?php 
    

                foreach ($jobs_array as $job_item) {  
                    
                    $title = $job_item['title'];
                    $image = $job_item['image'];
                    $location = $job_item['location'];
                    $permalink = $job_item['permalink'];
                    $latitude = $job_item['latitude'];
                    $longitude = $job_item['longitude'];
                    $jobtype = $job_item['jobtype'];
 
   
                    ?>
            
            {
                location_latitude: <?php echo $latitude ?>,
                location_longitude: <?php echo $longitude ?>,
                imgURL: "<?php echo $image [0] ?>",
                jobURL: "<?php echo $permalink ?>",
                jobTitle: "<?php echo $title  ?>",
                jobLocation: "<?php echo $location ?>",
                jobType: "<?php echo $jobtype ?>",
            }, 
         <?php } ?>
        ],
    },
    mapOptions = {
        zoom: 15,
        center: new google.maps.LatLng(48.867236, 2.34361),
        mapTypeId: google.maps.MapTypeId.satellite,
        mapTypeControl: !1,
        mapTypeControlOptions: { style: google.maps.MapTypeControlStyle.DROPDOWN_MENU, position: google.maps.ControlPosition.LEFT_CENTER },
        panControl: !1,
        panControlOptions: { position: google.maps.ControlPosition.TOP_RIGHT },
        zoomControl: !0,
        zoomControlOptions: { position: google.maps.ControlPosition.RIGHT_BOTTOM },
        scrollwheel: !1,
        scaleControl: !1,
        scaleControlOptions: { position: google.maps.ControlPosition.TOP_LEFT },
        streetViewControl: !0,
        streetViewControlOptions: { position: google.maps.ControlPosition.LEFT_TOP },
    };
for (var key in ((mapObject = new google.maps.Map(document.getElementById("map"), mapOptions)), markersData))
    markersData[key].forEach(function (o) {
        (marker = new google.maps.Marker({ position: new google.maps.LatLng(o.location_latitude, o.location_longitude), map: mapObject, icon: "assets/img/marker.png" })),
            void 0 === markers[key] && (markers[key] = []),
            markers[key].push(marker),
            google.maps.event.addListener(marker, "click", function () {
                closeInfoBox(), getInfoBox(o).open(mapObject, this), mapObject.setCenter(new google.maps.LatLng(o.location_latitude, o.location_longitude));
            });
    });
function hideAllMarkers() {
    for (var o in markers)
        markers[o].forEach(function (o) {
            o.setMap(null);
        });
}
function closeInfoBox() {
    $("div.infoBox").remove();
}
function getInfoBox(o) {
    return new InfoBox({
        content:
            '<div class="map-popup-wrap"><div class="map-popup"><div class="jbr-wrap text-left border rounded"><div class="cats-box rounded bg-white d-flex align-items-start justify-content-between px-3 py-4"><div class="cats-box rounded bg-white d-flex align-items-start"><div class="text-center"><img src="' +o.imgURL +'" class="img-fluid" width="45" alt=""></div><div class="cats-box-caption px-2"><h4 class="fs-sm mb-0 ft-medium"><a href="' +o.jobURL +'">' +o.jobTitle +'</a></h4><div class="d-block mb-2 position-relative"><span class="text-muted medium"><i class="lni lni-map-marker me-1"></i>' +o.jobLocation +'</span><span class="muted medium ms-2 text-warning"><i class="lni lni-briefcase me-1"></i>' +o.jobType +'</span></div></div></div></div></div></div></div>',
        disableAutoPan: !1,
        maxWidth: 0,
        pixelOffset: new google.maps.Size(10, 92),
        closeBoxMargin: "",
        closeBoxURL: "assets/img/close.png",
        isHidden: !1,
        alignBottom: !0,
        pane: "floatPane",
        enableEventPropagation: !0,
    });
}
function onHtmlClick(o, e) {
    google.maps.event.trigger(markers[o][e], "click");
}
new MarkerClusterer(mapObject, markers[key]);
});
</script>

<?php
}
