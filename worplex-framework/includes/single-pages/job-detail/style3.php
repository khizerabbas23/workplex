<?php

/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 */

global $worplex_framework_options;
$post = get_post();
$postid = $job_id = $post->ID;
	$title = get_the_title($postid);
$content = get_the_content($postid);

$location = get_post_meta($post->ID, 'worplex_field_location', true);
$image = wp_get_attachment_image_src(get_post_thumbnail_id($post), 'single-post-thumbnail');
	$job_type = get_post_meta($post->ID, 'worplex_field_job_type', true);
$min_salary = get_post_meta($job_id, 'worplex_field_min_salary', true);
        $max_salary = get_post_meta($job_id, 'worplex_field_max_salary', true);
         $salary_unit = get_post_meta($job_id, 'worplex_field_salary_unit', true);
$country = get_post_meta($candidate_id, 'worplex_field_loc_country', true);
  $facebook_url = get_post_meta($candidate_id, 'worplex_field_facebook_url', true);
        $twitter_url = get_post_meta($candidate_id, 'worplex_field_twitter_url', true);
        $linkedin_url = get_post_meta($candidate_id, 'worplex_field_linkedin_url', true);
        $google_url = get_post_meta($candidate_id, 'worplex_field_google_url', true);

	?>
<div class="bg-cover py-5" style="background:#17b67c url(https://themezhub.net/workplex-demo/workplex/assets/img/bn-2.jpg) no-repeat;" data-overlay="2">
	<div class="ht-200"></div>
</div>

<section class="pb-5 pt-0">
	<div class="container">
		<div class="row">

			<div class="col-xl-8 col-lg-8 col-md-8 col-sm-12">

				<div class="d-block ovr_top">
					<div class="jbd-flex d-flex align-items-center justify-content-start mb-4">
						<div class="jbd-01-thumb position-relative z-index-1">
							<img src="<?php echo $image[0] ?>" class="img-fluid" width="90" alt="">
						</div>
					</div>
				</div>

				<div class="rounded mb-4">
					<div class="jbd-01">

						<div class="jbd-01-caption mb-4">
							<div class="tbd-title">
								<div class="ft-medium medium"><span><?php echo $country ?></span></div>
								<h4 class="mb-3 ft-medium fs-lg"><?php echo $title ?> in <?php echo $location ?><img src="https://themezhub.net/workplex-demo/workplex/assets/img/verify.svg" class="ms-1" width="12" alt=""></h4>
							</div>
							<div class="jbd-list">
								<span class="px-2 py-1 rounded theme-cl theme-bg-light me-2"><i class="lni lni-briefcase me-1"></i><?php echo $job_type ?></span>
								<span><i class="lni lni-map-marker me-1"></i><?php echo $location ?></span>
								<span class="px-2 py-1 rounded text-warning bg-light-warning ms-2"><i class="lni lni-star me-1"></i>Featured</span>
								<span class="rounded ms-2"><i class="lni lni-money-protection me-1"></i><?php echo $min_salary ?>-<?php echo $max_salary ?> <?php echo $salary_unit ?></span>
							</div>
						</div>

						<div class="jbd-details mb-4">
							
							<p><?php echo $content ?></p>
						</div>

					</div>

					<div class="jbd-02 mt-4">
						<div class="jbd-02-flex d-flex align-items-center justify-content-between">
							<div class="jbl_button mb-2">
								<a href="#" class="btn btn-md rounded gray fs-sm ft-medium me-2">Save This Job</a>
								<a href="javascript:;" class="btn btn-md rounded theme-bg text-light fs-sm ft-medium jobdet-applybtn-act" data-bs-toggle="modal" data-bs-target="#worplex-apply-job-popup" data-id="<?php echo ($job_id) ?>">Apply Job</a>
							</div>
						</div>
					</div>
				</div>

			</div>

			<!-- Sidebar -->
			<div class="col-xl-4 col-lg-4 col-md-4 col-sm-12">
			    	<?php
				$args = array(
					'post_type' => 'jobs',
					'post_status' => 'publish',
					'posts_per_page' => '1',

					'order' => 'rend',
					'orderby' => 'ID',

				);

				$query = new WP_Query($args);
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

						$location = get_post_meta($post->ID, 'worplex_field_location', true);
						$country = get_post_meta($candidate_id, 'worplex_field_loc_country', true);


						$image = wp_get_attachment_image_src(get_post_thumbnail_id($postid), 'single-post-thumbnail');
						?>
				<div class="mt-5 rounded border p-4 z-index-1 bg-white">
					<div class="drt-block text-center mb-2">
						<div class="d-inline-flex align-items-center justify-content-center p-2 rounded border">
							<img src="<?php echo $image[0] ?>" class="img-fluid" width="80" alt="">
						</div>
					</div>
					
					<div class="drt-block-caption">
						<div class="drt-soc-caption text-center mb-3">
							<h4 class="ft-medium mb-0 fs-md"><?php echo $title ?></h4>
							<span><i class="lni lni-map-marker me-1"></i><?php echo $country ?></span>
						</div>
						<div class="drt-soc-block text-center mb-4">
							<ul class="jbd-social">
								<li><a href="<?php echo $facebook_url ?>"><i class="ti-facebook"></i></a></li>
								<li><a href="<?php echo $twitter_url ?>"><i class="ti-twitter"></i></a></li>
								<li><a href="<?php echo $linkedin_url ?>"><i class="ti-linkedin"></i></a></li>
								<li><a href="<?php echo $google_url ?>"><i class="ti-google"></i></a></li>
							</ul>
						</div>
						<div class="drt-btn-block">
							<a href="javascript:;" class="btn btn-md theme-bg text-light full-width rounded jobdet-applybtn-act" data-bs-toggle="modal" data-bs-target="#worplex-apply-job-popup" data-id="<?php echo ($job_id) ?>">Apply Job</a>
						</div>
					</div>
					
				</div>
					<?php }
				} ?>

				<div class="mt-4">
					<div class="dty-425">
						<h4 class="mb-3 ft-medium fs-md">Featured Employers</h4>
					</div>

					<div class="row">
						<div class="col-6">
							<div class="empl-box rounded bg-white d-flex justify-content-center px-4 py-3 shadow mb-3">
								<div class="text-center"><img src="https://themezhub.net/workplex-demo/workplex/assets/img/l-2.png" class="img-fluid" alt=""></div>
							</div>
						</div>
						<div class="col-6">
							<div class="empl-box rounded bg-white d-flex justify-content-center px-4 py-3 shadow mb-3">
								<div class="text-center"><img src="https://themezhub.net/workplex-demo/workplex/assets/img/l-3.png" class="img-fluid" alt=""></div>
							</div>
						</div>
						<div class="col-6">
							<div class="empl-box rounded bg-white d-flex justify-content-center px-4 py-3 shadow mb-3">
								<div class="text-center"><img src="https://themezhub.net/workplex-demo/workplex/assets/img/l-4.png" class="img-fluid" alt=""></div>
							</div>
						</div>
						<div class="col-6">
							<div class="empl-box rounded bg-white d-flex justify-content-center px-4 py-3 shadow mb-3">
								<div class="text-center"><img src="https://themezhub.net/workplex-demo/workplex/assets/img/l-5.png" class="img-fluid" alt=""></div>
							</div>
						</div>
						<div class="col-6">
							<div class="empl-box rounded bg-white d-flex justify-content-center px-4 py-3 shadow mb-3">
								<div class="text-center"><img src="https://themezhub.net/workplex-demo/workplex/assets/img/l-6.png" class="img-fluid" alt=""></div>
							</div>
						</div>
						<div class="col-6">
							<div class="empl-box rounded bg-white d-flex justify-content-center px-4 py-3 shadow mb-3">
								<div class="text-center"><img src="https://themezhub.net/workplex-demo/workplex/assets/img/l-7.png" class="img-fluid" alt=""></div>
							</div>
						</div>
					</div>
				</div>

			</div>

		</div>
	</div>
</section>

<section class="gray worplex-section-tbpading">
	<div class="container">

		<div class="row justify-content-center">
			<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
				<div class="sec_title position-relative text-center mb-5">
					<h6 class="text-muted mb-0">Related Jobs</h6>
					<h2 class="ft-bold">All Related Listed jobs</h2>
				</div>
			</div>
		</div>

		<!-- row -->
		<div class="row align-items-center">
			<?php
			$args = array(
				'post_type' => 'jobs',
				'post_status' => 'publish',
				'posts_per_page' => '4',

				'order' => 'DESC',
				'orderby' => 'ID',

			);

			$query = new WP_Query($args);
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


					$posted = get_the_time('U');
					$minut =  human_time_diff($posted, current_time('U')) . "";

					$time_tag = get_post_meta($post->ID, 'worplex_field_time_tag', true);
					$job_type = get_post_meta($post->ID, 'worplex_field_job_type', true);
					$jobtype_ar = worplex_job_type_ret_str($job_type);
					$job_type_label = isset($jobtype_ar['title']) ? $jobtype_ar['title'] : '';
					$job_type_clor = isset($jobtype_ar['color']) ? $jobtype_ar['color'] : '';
					$job_type_bgclor = isset($jobtype_ar['bg_color']) ? $jobtype_ar['bg_color'] : '';
					$backgropund_color = get_post_meta($post->ID, 'worplex_field_background_color', true);
					$font_color = get_post_meta($post->ID, 'worplex_field_font_color', true);
					$resorce_tag = get_post_meta($post->ID, 'worplex_field_resorce_tag', true);
					$salery_type = get_post_meta($post->ID, 'worplex_field_salary_unit', true);
					$min_salery = get_post_meta($post->ID, 'worplex_field_min_salary', true);
					$max_salery = get_post_meta($post->ID, 'worplex_field_max_salary', true);
					$vocansies = get_post_meta($post->ID, 'worplex_field_vocansies', true);
					$location = worplex_post_location_str($post->ID);


					$image = wp_get_attachment_image_src(get_post_thumbnail_id($postid), 'single-post-thumbnail');
					?>

					<!-- Single -->
					<div class="col-xl-3 col-lg-4 col-md-6 col-sm-12">
						<div class="job_grid border rounded ">
							<div class="position-absolute ab-left"><button type="button" class="p-3 border circle d-flex align-items-center justify-content-center bg-white text-gray"><i class="lni lni-heart-filled position-absolute snackbar-wishlist"></i></button></div>
							<div class="position-absolute ab-right"><span class="medium theme-cl theme-bg-light px-2 py-1 rounded" style="color: <?php echo ($job_type_clor) ?>!important; background-color: <?php echo ($job_type_bgclor) ?>!important;"><?php echo $job_type_label ?></span></div>
							<div class="job_grid_thumb mb-3 pt-5 px-3">
								<a href="job-detail.html" class="d-block text-center m-auto"><img src="<?php echo $image[0] ?>" class="img-fluid" width="70" alt="" /></a>
							</div>
							<div class="job_grid_caption text-center pb-5 px-3">
								<h6 class="mb-0 lh-1 ft-medium medium"><a href="employer-detail.html" class="text-muted medium"><?php echo $location ?></a></h6>
								<h4 class="mb-0 ft-medium medium"><a href="job-detail.html" class="text-dark fs-md"><?php echo $title ?></a></h4>
								<div class="jbl_location"><i class="lni lni-map-marker me-1"></i><span><?php echo $location ?></span></div>
							</div>
							<div class="job_grid_footer pb-4 px-3 d-flex align-items-center justify-content-between">
								<div class="df-1 text-muted"><i class="lni lni-wallet me-1"></i><?php echo $min_salery ?> - <?php echo $max_salery ?></div>
								<div class="df-1 text-muted"><i class="lni lni-timer me-1"></i><?php echo $minut ?></div>
							</div>
						</div>
					</div>
			<?php }
			} ?>
		</div>
		<!-- row -->


	</div>
</section>