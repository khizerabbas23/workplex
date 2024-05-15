<?php

/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Workplex
 */

get_header();
?>



  <section class="middle">
				<div class="container">
				    <div class="row align-items-start justify-content-between">
<?php 
		while (have_posts()) :
			the_post();
			$post = get_post();
			$postid = $post->ID;

			$terms = get_the_terms($postid, 'candidate_skill'); 
			If (empty($terms)) {
			   $terms = array();
		   }
					$total_lenght = count($terms);
			
			$remaining_length = 0;
			if($total_lenght > 5){
				$remaining_length = 5 - $total_lenght;  // 6
			}
 $image = wp_get_attachment_image_src( get_post_thumbnail_id($post), 'single-post-thumbnail' ); 
 $time_tag = get_post_meta($post->ID, 'worplex_field_time_tag', true);
?>

	  
					
					
						<div class="col-12 col-md-12 col-lg-4 col-xl-4 text-center miliods">
							<div class="d-block border rounded mfliud-bot mb-4">



								<div class="cdt_author px-2 pt-5 pb-4">
									<div class="dash_auth_thumb circle p-1 border d-inline-flex mx-auto mb-2">
										<img src="<?php echo $image[0] ?>" class="img-fluid circle" width="100" alt="" />
									</div>
									<div class="dash_caption mb-3">
										<h4 class="fs-lg ft-medium mb-0 lh-1"><?php echo the_title(); ?></h4>
										<p class="m-0 p-0"><?php echo the_excerpt(); ?></p>
										<span class="text-muted smalls"><i class="lni lni-map-marker me-1"></i>Denver, USA</span>
									</div>
									<div class="jb-list-01-title px-2">
										<?php
									$coutner = 0;
                                    foreach($terms as $term){
                                        $coutner++;
                                       
                                   $current_term_link = get_term_link( $term->slug, 'candidate_post' );
									?>

										<span class="me-2 mb-2 d-inline-flex px-2 py-1 rounded theme-cl theme-bg-light"><?php echo $term->name ?></span>
										<?php
										if($coutner > 4){
										 
										 
											break;
										}
									}
									?>
									</div>
								</div>

								
								<div class="cdt_caps">
									<div class="job_grid_footer pb-3 px-3 d-flex align-items-center justify-content-between">
										<div class="df-1 text-muted"><i class="lni lni-briefcase me-1"></i><?php echo $time_tag ?></div>
										<div class="df-1 text-muted"><i class="lni lni-laptop-phone me-1"></i>Web Designer</div>
									</div>	
									<div class="job_grid_footer px-3 d-flex align-items-center justify-content-between">
										<div class="df-1 text-muted"><i class="lni lni-envelope me-1"></i>themezhub@gmail.com</div>
										<div class="df-1 text-muted"><i class="lni lni-graduation me-1"></i>3 Year Exp.</div>
									</div>
								</div>
								
								<div class="cdt_caps py-5 px-3">
									<a href="#" class="btn btn-md theme-bg text-light rounded full-width">Download Resume</a>
								</div>
								
							</div>
						</div>
						
						<div class="col-12 col-md-12 col-lg-8 col-xl-8">
						
							<!-- row -->
							<div class="row align-items-start">

									<?php
									the_content();
									?>

							</div>
							<!-- row -->
							
						</div>
						<?php
					endwhile; // End of the loop.
					?>
					</div>
				</div>
			</section>
 
 <?php
get_footer();
