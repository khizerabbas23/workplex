<?php

/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package adhividayam
 */

get_header();
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
$email = get_post_meta($post->ID, 'worplex_field_email', true);
$contact_company_link = get_post_meta($post->ID, 'worplex_field_email', true);
        
            $image = wp_get_attachment_image_src(get_post_thumbnail_id($postid), 'single-post-thumbnail');
            
            $terms = get_the_terms($postid, 'employer_cat'); 
 If (empty($terms)) {
    $terms = array();
}
?>
<section class="middle">
				<div class="container">
					<div class="row align-items-start justify-content-between">
					
						<div class="col-12 col-md-12 col-lg-4 col-xl-4 text-center miliods">
							<div class="d-block border rounded mfliud-bot mb-4">
								<div class="cdt_author px-2 pt-5 pb-4">
									<div class="dash_auth_thumb rounded p-1 border d-inline-flex mx-auto mb-3">
										<img src="<?php echo $image[0]?>" class="img-fluid" width="100" alt="" />
									</div>
									<div class="dash_caption mb-4">
										<h4 class="fs-lg ft-medium mb-0 lh-1"><?php echo $title ?></h4>
										<span class="text-muted smalls"><i class="lni lni-map-marker me-1"></i><?php echo $location ?></span>
									</div>
									<div class="jb-list-01-title px-2">
									    <?php 
									     $coutner = 0;
                                    foreach($terms as $term){
                                        $coutner++;
                                       
                                   $current_term_link = get_term_link( $term->slug, 'employer_cat' );
                                   ?>
										<span class="me-2 mb-2 d-inline-flex px-2 py-1 rounded theme-cl theme-bg-light"><?php echo $term->name ?></span>
									<?php }?>
									</div>
								</div>
								
								<div class="cdt_caps">
									<div class="job_grid_footer pb-3 px-3 d-flex align-items-center justify-content-between">
										<div class="df-1 text-muted"><i class="lni lni-briefcase me-1"></i><?php echo $opening_posts?> Openings</div>
										<div class="df-1 text-muted"><i class="lni lni-laptop-phone me-1"></i><?php echo $company_tag ?></div>
									</div>	
									<div class="job_grid_footer px-3 d-flex align-items-center justify-content-between">
										<div class="df-1 text-muted"><i class="lni lni-envelope me-1"></i><?php echo $email ?></div>
										<div class="df-1 text-muted"><i class="lni lni-calendar me-1"></i>Build <?php echo $company_build ?></div>
									</div>
								</div>
								
								<div class="cdt_caps py-5 px-3">
									<a href="<?php echo $contact_company_link ?>" class="btn btn-md theme-bg text-light rounded full-width">Contact Company</a>
								</div>
								
							</div>
						</div>
						
						<div class="col-12 col-md-12 col-lg-8 col-xl-8">
						
							<!-- row -->
							<div class="row align-items-start">
							<?php echo get_the_content() ?>
							<!-- row -->
							
						</div>
						
					</div>
				</div>
			</section>
 <?php
get_footer();
