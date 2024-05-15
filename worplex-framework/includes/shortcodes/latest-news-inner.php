<?php

function latnwsin_nesupdt() {
    
    vc_map(
        
        array(
            'name' => __( 'Latest News Inner' ),
            'base' => 'latnwsin_nesupdt',
            'category' => __( 'Workplex' ),
            'params' => array(
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
		      array(   
					   'type' => 'textfield',
					   'holder' => 'div',
					   'class' => '',
					   'heading' => ( 'More Blogs' ),
					   'param_name' => 'more_blogs',
		      ), 
		      array(   
					   'type' => 'textfield',
					   'holder' => 'div',
					   'class' => '',
					   'heading' => ( 'More Blogs Url' ),
					   'param_name' => 'more_blogs_url',
		      ), 
		      
            )
        )
    );
}
add_action( 'vc_before_init', 'latnwsin_nesupdt' );

function latnwsin_nesupdt_frontend( $atts, $content ) {
  
    $atts = shortcode_atts(
    array(
   
        'sec_title' => '',
		'short_tagline' => '',
		'posttypename' => '',
        'orderby' => '',
        'categoryslug' => '',
		'numofpost' => '',
		'more_blogs' => '',
		'more_blogs_url' => '',
       
    ), $atts, 'latnwsin_nesupdt'
);

$sec_title  = isset($atts['sec_title']) ? $atts['sec_title'] : '';
$short_tagline = isset($atts['short_tagline']) ? $atts['short_tagline'] : '';
$more_blogs = isset($atts['more_blogs']) ? $atts['more_blogs'] : '';
$more_blogs_url = isset($atts['more_blogs_url']) ? $atts['more_blogs_url'] : '';


$output ='';
    
 $custom_plan_price = isset($atts['nb_medicaltitle']) && !empty($atts['nb_medicaltitle']) ? $atts['nb_medicaltitle'] : '';
 

 $output.='<div class="row justify-content-center">
						<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
							<div class="sec_title position-relative text-center">
								<h2 class="off_title">'.$sec_title.'</h2>
								<h3 class="ft-bold pt-3">'.$short_tagline.'</h3>
							</div>
						</div>
					</div>
					
					<div class="row">';

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
				$posted = get_the_time('U');
				 $date =  human_time_diff($posted,current_time( 'U' )). "";

		         $image = wp_get_attachment_image_src( get_post_thumbnail_id($postid), 'single-post-thumbnail' );

	 $output.='<div class="col-xl-4 col-lg-4 col-md-4 col-sm-12">
							<div class="_blog_wrap">
								<div class="_blog_thumb mb-2">
									<a href="'.$permalinkget.'" class="d-block"><img src="'.$image[0].'" class="img-fluid rounded" alt="" /></a>
								</div>
								<div class="_blog_caption">
									<span class="text-muted">'.$date.'</span>
									<h5 class="bl_title lh-1"><a href="'.$permalinkget.'">'.$title.'</a></h5>
									<p>'.$excerpt.'</p>
								</div>
							</div>
						</div>';
	}         
}		 
// Restore original post data.
wp_reset_postdata();

   $output.='</div>
					
					<div class="row justify-content-center">
						<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
							<div class="position-relative text-center">
								<a href="'.$more_blogs_url.'" class="btn stretched-link borders">'.$more_blogs.'<i class="lni lni-arrow-right ms-2"></i></a>
							</div>
						</div>
					</div>';
    return $output;
}
add_shortcode( 'latnwsin_nesupdt', 'latnwsin_nesupdt_frontend' );
