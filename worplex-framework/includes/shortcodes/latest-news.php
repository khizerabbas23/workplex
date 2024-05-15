<?php
// Home Startup Fresh News
function latest_news_section() {
    
    vc_map(
        
        array(
            'name' => __( 'Latest News Post' ),
            'base' => 'latest_news_section',
            'category' => __( 'Workplex' ),
            'params' => array(

				array(
					'type' => 'dropdown',
					'holder' => 'div',
					'class' => '',
					'heading' => __( 'Latest News Style', 'workplex' ),
					'param_name' => 'latest_news_style',
					'description' => __('Select Blog Update Style ', 'workplex'),
					'value' => array(
						'Select Style' => '',
						'View Style 1' => 'home_one_style',
						'View Style 2' => 'home_two_style',
						'View Style 3' => 'home_three_style',
						'View Style 4' => 'home_four_style',
					),
				   ),
				array(
					'type' => 'textfield',
					'holder' => 'div',
					'class' => '',
					'heading' => __( 'Title' ),
					'param_name' => 'sec_title',
				   ),
				   array(
					'type' => 'textfield',
					'holder' => 'div',
					'class' => '',
					'heading' => __('Short Tagline'),
					'param_name' => 'short_tagline',
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
					'heading' => ( 'Post Type Name' ),
					'param_name' => 'posttypename',
				   ), 	
				   array(
					'type' => 'textfield',
					'holder' => 'div',
					'class' => '',
					'heading' => ( 'Category Slug' ),
					'param_name' => 'categoryslug',
				   ),   
				   array(
					   'type' => 'textfield',
					   'holder' => 'div',
					   'class' => '',
					   'heading' => ( 'Order BY' ),
					   'param_name' => 'orderby',
					  ),			   
				   array(   
					   'type' => 'textfield',
					   'holder' => 'div',
					   'class' => '',
					   'heading' => ( 'Number Of Post' ),
					   'param_name' => 'numofpost',
		      ), 
            )
        )
    );
}
add_action( 'vc_before_init', 'latest_news_section' );

function latest_news_section_frontend( $atts, $content ) {
  
    $atts = shortcode_atts(
    array(
   
        'sec_title' => '',
		'short_tagline' => '',
		'color_word' => '',

		'latest_news_style' => '',

        		
		'posttypename' => '',
        'orderby' => '',
        'categoryslug' => '',
		'numofpost' => '',
       
    ), $atts, 'latest_news_section'
);

$latest_news_style = isset($atts['latest_news_style']) ? $atts['latest_news_style'] : '';

$sec_title  = isset($atts['sec_title']) ? $atts['sec_title'] : '';
$short_tagline = isset($atts['short_tagline']) ? $atts['short_tagline'] : '';
$color_word = isset($atts['color_word']) ? $atts['color_word'] : '';



$output ='';
    
 $custom_plan_price = isset($atts['nb_medicaltitle']) && !empty($atts['nb_medicaltitle']) ? $atts['nb_medicaltitle'] : '';
 
 if($atts['latest_news_style'] == 'home_one_style'){

 $output.='<div class="row justify-content-center">
 <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
     <div class="sec_title position-relative text-center mb-4">
         <h6 class="text-muted mb-0">'.$sec_title.'</h6>
         <h2 class="ft-bold">'.$short_tagline.'</h2>
     </div>
 </div>
</div>

<div class="row justify-content-center g-xl-3 g-lg-3 g-md-3 g-3">';

        $posttypename  = isset($atts['posttypename']) ? $atts['posttypename'] : '';
         $numofpost  = isset($atts['numofpost']) ? $atts['numofpost'] : '';
		 $categoryslug  = isset($atts['categoryslug']) ? $atts['categoryslug'] : '';
		 $orderby  = isset($atts['orderby']) ? $atts['orderby'] : '';
	
 
		 $args = array(
			'post_type' => $posttypename,
			 'post_status' => 'publish',                                                            
			  'posts_per_page' => $numofpost, 
			  'order' => 'DESC',                     
			  'orderby' =>  $orderby,  
			  'tax_query' => array(
				array(
					'taxonomy' =>  'category',
					'field'    => 'slug',
					'terms'    => $categoryslug,
				),
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
                 $contentt = get_the_content($postid);
				$posted = get_the_time('U');
				 $date  =  human_time_diff($posted,current_time( 'U' )). "";
				 $readmorelabel = get_post_meta($post->ID, 'mediclf_field_readmore_label', true);

		         $image = wp_get_attachment_image_src( get_post_thumbnail_id($postid), 'single-post-thumbnail' );
                $author_id = get_post_field('post_author', $postid);
				$posted = get_the_time('U');
                $avatar_imagev = get_avatar( $author_id);
				$timeago =  human_time_diff($posted,current_time( 'U' )). "";
					
					 


	 $output.='<div class="col-xl-4 col-lg-4 col-md-6 col-sm-12">
     <div class="blg_grid_box">
         <div class="blg_grid_thumb">
             <a href="'.$permalinkget.'"><img src="'.$image[0].'" class="img-fluid" alt=""></a>
         </div>
         <div class="blg_grid_caption">
             <div class="blg_tag"><span>'.$excerpt.'</span></div>
             <div class="blg_title"><h4><a href="'.$permalinkget.'">'.$title.'</a></h4></div>
             <div class="blg_desc"><p>'.$contentt.'</p></div>
         </div>
         <div class="crs_grid_foot">
             <div class="crs_flex d-flex align-items-center justify-content-between br-top px-3 py-2">
                 <div class="crs_fl_first">
                     <div class="crs_tutor">
                         <div class="crs_tutor_thumb"><a href="'.$permalinkget.'">'.$avatar_imagev.'</a></div>
                     </div>
                 </div>
                 <div class="crs_fl_last">
                     <div class="foot_list_info">
                         <ul>
                             <li><div class="elsio_ic"><i class="lni lni-eye text-success"></i></div><div class="elsio_tx">10k Views</div></li>
                             <li><div class="elsio_ic"><i class="lni lni-alarm-clock text-warning"></i></div><div class="elsio_tx">'.$date.'</div></li>
                         </ul>
                     </div>
                 </div>
             </div>
         </div>
     </div>
 </div>';
	}         
}		 
// Restore original post data.
wp_reset_postdata();

   $output.='</div>';
 } elseif($atts['latest_news_style'] == 'home_two_style'){


	$output.='<div class="row justify-content-center">
	<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
		<div class="sec_title position-relative text-center mb-4">
			<h6 class="text-muted mb-0">'.$sec_title.'</h6>
			<h2 class="ft-bold">'.$short_tagline.'</h2>
		</div>
	</div>
</div>

<div class="row justify-content-center g-xl-3 g-lg-3 g-md-3 g-3">';
   
		   $posttypename  = isset($atts['posttypename']) ? $atts['posttypename'] : '';
			$numofpost  = isset($atts['numofpost']) ? $atts['numofpost'] : '';
			$categoryslug  = isset($atts['categoryslug']) ? $atts['categoryslug'] : '';
			$orderby  = isset($atts['orderby']) ? $atts['orderby'] : '';
	   
	
			$args = array(
			   'post_type' => $posttypename,
				'post_status' => 'publish',                                                            
				 'posts_per_page' => $numofpost, 
				 'order' => 'DESC',                     
				 'orderby' =>  $orderby,  
				 'tax_query' => array(
				   array(
					   'taxonomy' =>  'category',
					   'field'    => 'slug',
					   'terms'    => $categoryslug,
				   ),
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
				   
				   
					$date  =  human_time_diff($postid,current_time( 'U' )). "";
					$readmorelabel = get_post_meta($post->ID, 'mediclf_field_readmore_label', true);
   
					$image = wp_get_attachment_image_src( get_post_thumbnail_id($postid), 'single-post-thumbnail' );
   
				   $posted = get_the_time('U');
   
				   $timeago =  human_time_diff($posted,current_time( 'U' )). "";
					   
				    
				    $author_id = get_post_field('post_author', $postid);
				    $current_user = wp_get_current_user();
				    $user_avatar = get_avatar($current_user->ID, 96); // Set the desired avatar size
				    $user_avatar_url = get_avatar_url($current_user->ID); // Get the URL of the avatar image
				    $user_edit_link = get_edit_user_link($current_user->ID); // Get the edit user link
				    
				    $author_id = get_post_field('post_author', $postid);
				   
   
		$output.='<div class="col-xl-4 col-lg-4 col-md-6 col-sm-12">
		<div class="blg_grid_box">
			<div class="blg_grid_thumb">
				<a href="'.$permalinkget.'"><img src="'.$image[0].'" class="img-fluid" alt=""></a>
			</div>
			<div class="blg_grid_caption">
				<div class="blg_tag"><span>Marketing</span></div>
				<div class="blg_title"><h4><a href="'.$permalinkget.'">'.$title.'</a></h4></div>
				<div class="blg_desc"><p>'.$excerpt.'</p></div>
			</div>
			<div class="crs_grid_foot">
				<div class="crs_flex d-flex align-items-center justify-content-between br-top px-3 py-2">
					<div class="crs_fl_first">
						<div class="crs_tutor">
							<div class="crs_tutor_thumb"><a href="'.$permalinkget.'"><img src="'.get_avatar_url( $author_id, ['size' => '35']).'" class="img-fluid circle" width="35" alt=""></a></div>
						</div>
					</div>
					<div class="crs_fl_last">
						<div class="foot_list_info">
							<ul>
								<li><div class="elsio_ic"><i class="lni lni lni lni-eye text-success"></i></div><div class="elsio_tx">10k Views</div></li>
								<li><div class="elsio_ic"><i class="worplex-fa worplex-faicon-clock text-warning"></i></div><div class="elsio_tx">'.$date.'</div></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>';
	   }         
   }		 
   // Restore original post data.
   wp_reset_postdata();
   
	  $output.='</div>';

 }elseif($atts['latest_news_style'] == 'home_three_style'){
	$output.='
	<div class="row justify-content-center">
						<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
							<div class="sec_title position-relative text-center mb-4">
								<h6 class="text-muted mb-0">'.$sec_title.'</h6>
								<h2 class="ft-bold">'.$short_tagline.' <span class="text-danger">'.$color_word.'</span></h2>
							</div>
						</div>
					</div>
					
					<div class="row justify-content-center">';
   
		   $posttypename  = isset($atts['posttypename']) ? $atts['posttypename'] : '';
			$numofpost  = isset($atts['numofpost']) ? $atts['numofpost'] : '';
			$categoryslug  = isset($atts['categoryslug']) ? $atts['categoryslug'] : '';
			$orderby  = isset($atts['orderby']) ? $atts['orderby'] : '';
	   
	
			$args = array(
			   'post_type' => $posttypename,
				'post_status' => 'publish',                                                            
				 'posts_per_page' => $numofpost, 
				 'order' => 'DESC',                     
				 'orderby' =>  $orderby,  
				 'tax_query' => array(
				   array(
					   'taxonomy' =>  'category',
					   'field'    => 'slug',
					   'terms'    => $categoryslug,
				   ),
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
				   
					
					$readmorelabel = get_post_meta($post->ID, 'mediclf_field_readmore_label', true);
   
					$image = wp_get_attachment_image_src( get_post_thumbnail_id($postid), 'single-post-thumbnail' );
   
				   $posted = get_the_time('U');
   $date =  human_time_diff($posted,current_time( 'U' )). "";
				   $timeago =  human_time_diff($posted,current_time( 'U' )). "";
					   
				    
				 
				    $current_user = wp_get_current_user();
				    $user_avatar = get_avatar($current_user->ID, 96); // Set the desired avatar size
				    $user_avatar_url = get_avatar_url($current_user->ID); // Get the URL of the avatar image
				    $user_edit_link = get_edit_user_link($current_user->ID); // Get the edit user link
				    $author_id = get_post_field('post_author', $postid);
				   
   
		$output.='<div class="col-xl-4 col-lg-4 col-md-6 col-sm-12">
		<div class="blg_grid_box">
			<div class="blg_grid_thumb">
				<a href="'.$permalinkget.'"><img src="'.$image[0].'" class="img-fluid" alt=""></a>
			</div>
			<div class="blg_grid_caption">
				<div class="blg_tag"><span>Marketing</span></div>
				<div class="blg_title"><h4><a href="'.$permalinkget.'">'.$title.'</a></h4></div>
				<div class="blg_desc"><p>'.$excerpt.'</p></div>
			</div>
			<div class="crs_grid_foot">
				<div class="crs_flex d-flex align-items-center justify-content-between br-top px-3 py-2">
					<div class="crs_fl_first">
						<div class="crs_tutor">
							<div class="crs_tutor_thumb"><a href="'.$permalinkget.'"><img src="'.get_avatar_url( $author_id, ['size' => '35']).'" class="img-fluid circle" width="35" alt=""></a></div>
						</div>
					</div>
					<div class="crs_fl_last">
						<div class="foot_list_info">
							<ul>
								<li><div class="elsio_ic"><i class="lni lni lni lni-eye text-success"></i></div><div class="elsio_tx">10k Views</div></li>
								<li><div class="elsio_ic"><i class="worplex-fa worplex-faicon-clock text-warning"></i></div><div class="elsio_tx">'.$date.'</div></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>';
	   }         
   }		 
   // Restore original post data.
   wp_reset_postdata();
   
	  $output.='</div>';
 }elseif($atts['latest_news_style'] == 'home_four_style'){
	$output.='
	<div class="row justify-content-center">
						<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
							<div class="sec_title position-relative text-center mb-4">
								<h6 class="text-muted mb-0">'.$sec_title.'</h6>
								<h2 class="ft-bold">'.$short_tagline.' <span class="theme-cl">'.$color_word.'</span></h2>
							</div>
						</div>
					</div>
					
					<div class="row justify-content-center">';
   
		   $posttypename  = isset($atts['posttypename']) ? $atts['posttypename'] : '';
			$numofpost  = isset($atts['numofpost']) ? $atts['numofpost'] : '';
			$categoryslug  = isset($atts['categoryslug']) ? $atts['categoryslug'] : '';
			$orderby  = isset($atts['orderby']) ? $atts['orderby'] : '';
	   
	
			$args = array(
			   'post_type' => $posttypename,
				'post_status' => 'publish',                                                            
				 'posts_per_page' => $numofpost, 
				 'order' => 'DESC',                     
				 'orderby' =>  $orderby,  
				 'tax_query' => array(
				   array(
					   'taxonomy' =>  'category',
					   'field'    => 'slug',
					   'terms'    => $categoryslug,
				   ),
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
				   
					
					$readmorelabel = get_post_meta($post->ID, 'mediclf_field_readmore_label', true);
   
					$image = wp_get_attachment_image_src( get_post_thumbnail_id($postid), 'single-post-thumbnail' );
   
				   $posted = get_the_time('U');
   $date =  human_time_diff($posted,current_time( 'U' )). "";
				   $timeago =  human_time_diff($posted,current_time( 'U' )). "";
					   
				    
				 
				    $current_user = wp_get_current_user();
				    $user_avatar = get_avatar($current_user->ID, 96); // Set the desired avatar size
				    $user_avatar_url = get_avatar_url($current_user->ID); // Get the URL of the avatar image
				    $user_edit_link = get_edit_user_link($current_user->ID); // Get the edit user link
				    $author_id = get_post_field('post_author', $postid);
				   
   
		$output.='<div class="col-xl-4 col-lg-4 col-md-6 col-sm-12">
		<div class="blg_grid_box">
			<div class="blg_grid_thumb">
				<a href="'.$permalinkget.'"><img src="'.$image[0].'" class="img-fluid" alt=""></a>
			</div>
			<div class="blg_grid_caption">
				<div class="blg_tag"><span>Marketing</span></div>
				<div class="blg_title"><h4><a href="'.$permalinkget.'">'.$title.'</a></h4></div>
				<div class="blg_desc"><p>'.$excerpt.'</p></div>
			</div>
			<div class="crs_grid_foot">
				<div class="crs_flex d-flex align-items-center justify-content-between br-top px-3 py-2">
					<div class="crs_fl_first">
						<div class="crs_tutor">
							<div class="crs_tutor_thumb"><a href="'.$permalinkget.'"><img src="' . get_avatar_url( $author_id, ['size' => '35']) . '" class="img-fluid circle" width="35" alt=""></a></div>
						</div>
					</div>
					<div class="crs_fl_last">
						<div class="foot_list_info">
							<ul>
								<li><div class="elsio_ic"><i class="lni lni lni lni-eye text-success"></i></div><div class="elsio_tx">10k Views</div></li>
								<li><div class="elsio_ic"><i class="worplex-fa worplex-faicon-clock text-warning"></i></div><div class="elsio_tx">'.$date.'</div></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>';
	   }         
   }		 
   // Restore original post data.
   wp_reset_postdata();
   
	  $output.='</div>';
 }
 
    return $output;
}
add_shortcode( 'latest_news_section', 'latest_news_section_frontend' );
