<?php

/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 */

get_header();

$post = get_post();
$postid = $job_id = $post->ID;

global $worplex_framework_options;

$default_job_view = isset($worplex_framework_options['job_select_detail_view']) ? $worplex_framework_options['job_select_detail_view'] : '';

$job_style_view = get_post_meta($post->ID, 'worplex_field_job_detail_view', true);
if ($job_style_view != '') {
	$job_slected_style = $job_style_view;
} else {
	$job_slected_style = $default_job_view;
}

if ($job_slected_style == 'style4') {
	include 'job-detail/style4.php';
} else if ($job_slected_style == 'style3') {
	include 'job-detail/style3.php';
} else if ($job_slected_style == 'style2') {
	include 'job-detail/style2.php';
} else {

	$image = wp_get_attachment_image_src(get_post_thumbnail_id($post), 'single-post-thumbnail');
	$job_type = get_post_meta($post->ID, 'worplex_field_job_type', true);
	$jobtype_ar = worplex_job_type_ret_str($job_type);
	$job_type_label = isset($jobtype_ar['title']) ? $jobtype_ar['title'] : '';
	$job_type_clor = isset($jobtype_ar['color']) ? $jobtype_ar['color'] : '';
	$job_type_bgclor = isset($jobtype_ar['bg_color']) ? $jobtype_ar['bg_color'] : '';
	$location = worplex_post_location_str($post->ID);
	$title = get_the_title($postid);
	$view_company = get_post_meta($post->ID, 'worplex_field_company_vies', true);
	function open_link_in_new_tab($content)
	{
		// Find all anchor tags in the content
		$pattern = '/<a(.*?)href=["\'](.*?)["\'](.*?)>/i';
		$replacement = '<a$1href="$2"$3 target="_blank">';
		$content = preg_replace($pattern, $replacement, $content);
		return $content;
	}
	add_filter('the_content', 'open_link_in_new_tab'); // Apply the filter to the content

	?>

	<section class="bg-light py-5 position-relative">
		<div class="container">

			<div class="row">
				<div class="col-md-8 col-sm-8 col-xs-12">

					<div class="bg-white rounded px-3 py-4 mb-4">
						<div class="jbd-01 d-flex align-items-center justify-content-between">
							<div class="jbd-flex d-flex align-items-center justify-content-start">
								<div class="jbd-01-thumb">
									<img src="<?php echo $image[0] ?>" class="img-fluid" width="90" alt="">
								</div>
								<div class="jbd-01-caption ps-3">
									<div class="tbd-title">
										<h4 class="mb-0 ft-medium fs-md">
											<?php echo $title ?>
										</h4>
									</div>
									<div class="jbl_location mb-3">
										<span><i class="lni lni-map-marker me-1"></i>
											<?php echo $location ?>
										</span>
										<span class="medium ft-medium ms-3" style="color: <?php echo ($job_type_clor) ?>">
											<?php echo $job_type_label ?>
										</span>
									</div>
									<div class="jbl_info01">
										<span class="px-2 py-1 ft-medium medium rounded theme-cl theme-bg-light me-2">Magento</span>
										<span class="px-2 py-1 ft-medium medium rounded text-danger bg-light-danger me-2">WordPress</span>
										<span class="px-2 py-1 ft-medium medium rounded text-purple bg-light-purple">Laravel</span>
									</div>
								</div>
							</div>
							<div class="jbd-01-right text-right hide-1023">
								<div class="jbl_button mb-2"><a href="javascript:;" class="btn rounded theme-bg-light theme-cl fs-sm ft-medium jobdet-applybtn-act" data-bs-toggle="modal" data-bs-target="#worplex-apply-job-popup" data-id="<?php echo ($job_id) ?>">Apply This Job</a></div>
								<div class="jbl_button"><a href="<?php echo $view_company ?>" target="_blank" class="btn rounded bg-white border fs-sm ft-medium">View Company</a></div>
							</div>
						</div>
					</div>

					<div class="bg-white rounded mb-4">
						<div class="jbd-01 px-3 py-4">
							<?php echo get_the_content() ?>
							<div class="jbd-02 px-3 py-3 br-top">
								<div class="jbd-02-flex d-flex align-items-center justify-content-between">
									<div class="jbd-02-social">
										<ul class="jbd-social">
											<li><i class="ti-sharethis"></i></li>
											<li><a href="javascript:void(0);"><i class="ti-facebook"></i></a></li>
											<li><a href="javascript:void(0);"><i class="ti-twitter"></i></a></li>
											<li><a href="javascript:void(0);"><i class="ti-linkedin"></i></a></li>
											<li><a href="javascript:void(0);"><i class="ti-instagram"></i></a></li>
										</ul>
									</div>
									<div class="jbd-02-aply">
										<div class="jbl_button mb-2">
											<a href="#" class="btn btn-md rounded gray fs-sm ft-medium me-2">Save This Job</a>
											<a class="btn btn-md rounded theme-bg text-light fs-sm ft-medium apply-job jobdet-applybtn-act" data-bs-toggle="modal" data-bs-target="#worplex-apply-job-popup" data-id="<?php echo ($job_id) ?>">Apply Job</a>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>

				</div>
				<div class="col-md-4 col-sm-4 col-xs-12">
					<div class="jb-apply-form bg-white rounded py-3 px-4 box-static">
						<h4 class="ft-medium fs-md mb-3">Intrested in this job?</h4>
						
						<form class="_apply_form_form worplex-user-form loding-onall-con" method="post">
						
							<div class="form-group">
								<label class="text-dark mb-1 ft-medium medium">First Name</label>
								<input type="text" class="form-control" required placeholder="First Name">
							</div>
							
							<div class="form-group">
								<label class="text-dark mb-1 ft-medium medium">Your Email</label>
								<input type="email" class="form-control" required placeholder="example@gmail.com">
							</div>
							
							<div class="form-group">
								<label class="text-dark mb-1 ft-medium medium">Phone Number:</label>
								<input type="text" class="form-control" placeholder="+91 245 256 2548">
							</div>
							
							<div class="form-group">
								<label class="text-dark mb-1 ft-medium medium">Message:</label>
								<textarea class="form-control"></textarea>
							</div>
							
							<div class="form-group">
								<div class="terms_con">
									<input id="jobside-form-agree" class="checkbox-custom" name="agree_terms" type="checkbox">
									<label for="jobside-form-agree" class="checkbox-custom-label">I agree to pirvacy policy</label>
								</div>
							</div>
							
							<div class="form-group">
								<button type="submit" class="btn btn-md rounded theme-bg text-light ft-medium fs-sm full-width">Send Message</button>
							</div>
							
						</form>
					</div>
				</div>
			</div>
		</div>
	</section>
	<section class="space min">
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
	<?php
}
get_footer();
