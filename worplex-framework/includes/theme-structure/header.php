<?php

add_filter('worplex_header_content_markup', function () {
    ob_start();
    global $worplex_framework_options, $current_user;

	$user_id = $current_user->ID;
	$candidate_id = worplex_user_candidate_id($user_id);

	$show_postjob_btn = true;
	if ($candidate_id) {
		$show_postjob_btn = false;
	}

    $post_new_job_page = isset($worplex_framework_options['post_new_job_page']) ? $worplex_framework_options['post_new_job_page'] : '';
    
	$postjob_page_id = worplex_get_page_id_from_name($post_new_job_page);
	$post_job_page_url = '';
	if ($postjob_page_id > 0) {
        $post_job_page_url = get_permalink($postjob_page_id);
    }
    ?>
	<div id="main-wrapper">
	
		<div class="header header-light dark-text">
			<div class="container">
				<nav id="navigation" class="navigation navigation-landscape">
					<div class="nav-header">
						
						<?php worplex_site_logo() ?>
						
						<div class="nav-toggle"></div>
						<div class="mobile_nav">
							<ul>
								<?php
								ob_start();
								if (!is_user_logged_in()) {
									?>
									<li>
										<a href="#" data-bs-toggle="modal" data-bs-target="#login" class="theme-cl fs-lg">
											<i class="lni lni-user"></i>
										</a>
									</li>
									<?php
								} else {
									global $worplex_framework_options;

									$account_page_name = isset($worplex_framework_options['user_dashboard_page']) ? $worplex_framework_options['user_dashboard_page'] : '';

									$account_page_id = worplex_get_page_id_from_name($account_page_name);

									$account_page_url = '';
									if ($account_page_id > 0) {
										$account_page_url = get_permalink($account_page_id);
									}
									?>
									<li>
										<a href="<?php echo ($account_page_url) ?>" class="theme-cl fs-lg">
											<i class="lni lni-user"></i>
										</a>
									</li>
									<?php
								}
								if ($show_postjob_btn) {
									?>
									<li>
										<a href="<?php echo ($post_job_page_url) ?>" class="crs_yuo12 w-auto text-white theme-bg">
											<span class="embos_45"><i class="fas fa-plus-circle me-1 me-1"></i>Post Job</span>
										</a>
									</li>
									<?php
								}
								$btns_html = ob_get_clean();
								echo apply_filters('worplex_header_mobile_right_btns_html', $btns_html);
								?>
							</ul>
						</div>
					</div>
					
					<div class="nav-menus-wrapper" style="transition-property: none;">
						<?php worplex_header_navigation() ?>
					
						<ul class="nav-menu nav-menu-social align-to-right">
							<?php
							ob_start();
							if (!is_user_logged_in()) {
								?>
								<li>
									<a href="#" data-bs-toggle="modal" data-bs-target="#login" class="theme-cl ft-medium">
										<i class="lni lni-user me-2"></i>Sign In
									</a>
								</li>
								<?php
							} else {
								global $worplex_framework_options;

								$account_page_name = isset($worplex_framework_options['user_dashboard_page']) ? $worplex_framework_options['user_dashboard_page'] : '';

								$account_page_id = worplex_get_page_id_from_name($account_page_name);

								$account_page_url = '';
								if ($account_page_id > 0) {
									$account_page_url = get_permalink($account_page_id);
								}
								?>
								<li>
									<a href="<?php echo ($account_page_url) ?>" class="theme-cl ft-medium">
										<i class="lni lni-user"></i> My Account
									</a>
								</li>
								<?php
							}
							if ($show_postjob_btn) {
								?>
								<li class="add-listing">
									<a href="<?php echo ($post_job_page_url) ?>">
										<i class="lni lni-circle-plus me-1"></i> Post a Job
									</a>
								</li>
								<?php
							}
							$btns_html = ob_get_clean();
							echo apply_filters('worplex_header_right_btns_html', $btns_html);
							?>
						</ul>
					</div>
				</nav>
			</div>
		</div>
		<div class="clearfix"></div>
	</div>
    <?php
    $html = ob_get_clean();
    return $html;
});

function worplex_site_logo() {
    global $worplex_framework_options;
    $logo_default_val = '';
    $worplex_theme_options = get_option('worplex_framework_options');

    if (empty($worplex_theme_options)) {
        $logo_default_val = get_template_directory_uri() . '/images/logo.png';
    }

    $site_logo_key = 'worplex-site-logo';
    $worplex_logo = isset($worplex_framework_options[$site_logo_key]['url']) && $worplex_framework_options[$site_logo_key]['url'] != '' ? $worplex_framework_options[$site_logo_key]['url'] : $logo_default_val;
    $logo_width = isset($worplex_framework_options['worplex-logo-width']) && $worplex_framework_options['worplex-logo-width'] > 0 ? ' width="' . $worplex_framework_options['worplex-logo-width'] . '"' : '';
    $logo_height = isset($worplex_framework_options['worplex-logo-height']) && $worplex_framework_options['worplex-logo-height'] > 0 ? ' height="' . $worplex_framework_options['worplex-logo-height'] . '"' : '';

    echo '<a class="worplex-logo nav-brand" title="' . get_bloginfo('name') . '" href="' . esc_url(home_url('/')) . '">';
    if ($worplex_logo != '') {
        echo '<img src="' . esc_url($worplex_logo) . '" class="logo"' . $logo_width . $logo_height . ' alt="' . get_bloginfo('name') . '">';
    } else {
        echo get_bloginfo('name');
    }
    echo '</a>';
}

function worplex_header_navigation() {

	$args = array(
		'theme_location' => 'primary',
		'menu_class' => 'nav-menu',
		'container' => '',
		'fallback_cb' => 'worplex_nav_menu_fallback',
		'walker' => new worplex_theme_menu_walker,
	);
	wp_nav_menu($args);
}

function worplex_nav_menu_fallback() {
	$pages = wp_list_pages(array('title_li' => '', 'echo' => false));

	echo '
	<ul class="nav-menu">
		' . $pages . '
	</ul>';
}
