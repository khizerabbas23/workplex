<?php

/**
 * Template Name: User Dashboard
 */

wp_enqueue_style('worplex-datetimepicker');
wp_enqueue_style('worplex-dashboard');

get_header();

wp_enqueue_script('worplex-datetimepicker-full');
wp_enqueue_script('worplex-dashboard');

global $worplex_framework_options, $current_user;

$footer_text = isset($worplex_framework_options['worplex-footer-copyright-text']) ? $worplex_framework_options['worplex-footer-copyright-text'] : '';

$account_page_name = isset($worplex_framework_options['user_dashboard_page']) ? $worplex_framework_options['user_dashboard_page'] : '';

$account_page_id = worplex_get_page_id_from_name($account_page_name);

$account_page_url = home_url('/');
if ($account_page_id > 0) {
	$account_page_url = get_permalink($account_page_id);
}

$user_id = get_current_user_id();
$display_name = $current_user->display_name;

$post_type_ext = '';

$candidate_id = worplex_user_candidate_id($user_id);
$employer_id = worplex_user_employer_id($user_id);
if ($candidate_id) {
	$display_name = get_the_title($candidate_id);
	$account_tabs = worplex_candidate_account_menu_items();
	$post_type_ext = 'candidate_';
} else if ($employer_id) {
	$display_name = get_the_title($employer_id);
	$account_tabs = worplex_employer_account_menu_items();
	$post_type_ext = 'employer_';
}

$default_tab = 'profile';

$general_tabs = worplex_general_account_menu_items();
$overall_tabs = $general_tabs;
if ($candidate_id || $employer_id) {
	$overall_tabs += $account_tabs;
	$default_tab = 'dashboard';
}
// echo '<pre>';
// var_dump($overall_tabs);
// echo '</pre>';

$current_tab = isset($_GET['account_tab']) && $_GET['account_tab'] != '' && isset($overall_tabs[$_GET['account_tab']]) ? $_GET['account_tab'] : $default_tab;
?>
<div class="dashboard-wrap bg-light">
	<a class="mobNavigation collapsed" data-bs-toggle="collapse" href="#MobNav" role="button" aria-expanded="false" aria-controls="MobNav">
		<i class="fas fa-bars me-2"></i>Dashboard Navigation
	</a>
	<div class="collapse" id="MobNav">
		<div class="dashboard-nav">
			<div class="dashboard-inner" style="max-height: 408px;">
				<?php
				if ($candidate_id || $employer_id) {
					?>
					<ul data-submenu-title="<?php esc_html_e('Main Navigation', 'worplex-frame') ?>">
						<?php
						foreach ($account_tabs as $acc_tab_key => $acc_tab) {
							?>
							<li<?php echo ($current_tab == $acc_tab_key) ? ' class="active"' : '' ?>><a href="<?php echo add_query_arg(array('account_tab' => $acc_tab_key), $account_page_url) ?>"><i class="<?php echo ($acc_tab['icon']) ?>"></i><?php echo ($acc_tab['title']) ?></a></li>
							<?php
						}
						?>
					</ul>
					<?php
				}
				?>
				<ul data-submenu-title="<?php esc_html_e('My Accounts', 'worplex-frame') ?>">
					<?php
					foreach ($general_tabs as $acc_tab_key => $acc_tab) {
						?>
						<li<?php echo ($current_tab == $acc_tab_key) ? ' class="active"' : '' ?>><a href="<?php echo add_query_arg(array('account_tab' => $acc_tab_key), $account_page_url) ?>"><i class="<?php echo ($acc_tab['icon']) ?>"></i><?php echo ($acc_tab['title']) ?></a></li>
						<?php
					}
					?>
					<li><a href="javascript:void(0);"><i class="lni lni-trash-can me-2"></i>Delete Account</a></li>
					<li><a href="<?php echo worplex_account_logout_url() ?>"><i class="lni lni-power-switch me-2"></i>Log Out</a></li>
				</ul>
			</div>
		</div>
	</div>
	<div class="dashboard-content">
		<div class="dashboard-tlbar d-block mb-5">
			<div class="row">
				<div class="colxl-12 col-lg-12 col-md-12">
					<h1 class="ft-medium"><?php printf(esc_html__('Hello, %s', 'worplex-frame'), $display_name) ?></h1>
					<nav aria-label="breadcrumb">
						<ol class="breadcrumb">
							<li class="breadcrumb-item text-muted"><a href="<?php echo home_url('/') ?>">Home</a></li>
							<?php
							if (($candidate_id || $employer_id) && $current_tab != 'dashboard') {
								?>
								<li class="breadcrumb-item"><a href="<?php echo ($account_page_url) ?>">Dashboard</a></li>
								<?php
							}
							?>
							<li class="breadcrumb-item"><a class="theme-cl"><?php echo ($overall_tabs[$current_tab]['title']) ?></a></li>
						</ol>
					</nav>
				</div>
			</div>
		</div>

		<?php
		if ($candidate_id) {
			$tab_html = worplex_dashb_candidate_dashboard();
		} else if ($employer_id) {
			$tab_html = worplex_dashb_employer_dashboard();
		} else {
			$tab_html = worplex_dashb_general_profile();
		}
		$tab_hook_name = str_replace(array('-'), array('_'), $current_tab);
		echo apply_filters("worplex_dashboard_{$post_type_ext}{$tab_hook_name}_html", $tab_html, $overall_tabs);
		?>
		
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