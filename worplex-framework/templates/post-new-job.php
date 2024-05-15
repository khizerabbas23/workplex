<?php

/**
 * Template Name: Post New Job
 */
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

get_header();
global $worplex_framework_options, $current_user;

$footer_text = isset($worplex_framework_options['worplex-footer-copyright-text']) ? $worplex_framework_options['worplex-footer-copyright-text'] : '';
?>
<div class="worplex-section-tbpading bg-light">

	<div class="container">
		<div class="dashboard-tlbar d-block mb-5">
			<div class="row">
				<div class="colxl-12 col-lg-12 col-md-12">
					<h1 class="ft-medium">Post A New Job</h1>
					<nav aria-label="breadcrumb">
						<ol class="breadcrumb">
							<li class="breadcrumb-item text-muted"><a href="<?php echo home_url('/') ?>">Home</a></li>
							<li class="breadcrumb-item"><a class="theme-cl">Post Job</a></li>
						</ol>
					</nav>
				</div>
			</div>
		</div>

		<?php worplex_employer_job_form() ?>

		<!-- footer -->
		<div class="row">
			<div class="col-md-12">
				<div class="py-3"><?php echo ($footer_text) ?></div>
			</div>
		</div>

	</div>

</div>

</div>
<?php wp_footer() ?>
</body>

</html>