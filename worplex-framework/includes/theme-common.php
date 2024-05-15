<?php

include_once WORPLEX_ABSPATH . 'includes/theme-structure/header.php';
include_once WORPLEX_ABSPATH . 'includes/theme-structure/footer.php';
include_once WORPLEX_ABSPATH . 'includes/theme-structure/single-post.php';
include_once WORPLEX_ABSPATH . 'includes/theme-structure/content.php';
include_once WORPLEX_ABSPATH . 'includes/theme-structure/page-content.php';
include_once WORPLEX_ABSPATH . 'includes/theme-structure/404.php';
include_once WORPLEX_ABSPATH . 'includes/theme-structure/comments.php';

add_filter('worplex_comments_default_theme_structure_all', '__return_false');
add_filter('worplex_theme_style_scripts', '__return_false');
add_filter('worplex_comments_template_html_con', '__return_false');

add_filter('worplex_enable_theme_sidebar', '__return_false');

add_filter('worplex_site_main_container_start', function($html = '') {
    $html = '<div class="worplex-site-wrapper">';
    return $html;
});

add_filter('worplex_site_main_innercon_start', '__return_false');
add_filter('worplex_site_main_innercon_end', '__return_false');

add_filter('worplex_before_page_container_markup', function($html = '', $page_type = 'page') {
    $html = '';
    $page_subheader_switch = '';
    $post = get_the_id();
    if(is_page() ){
        $page_subheader_switch = get_post_meta($post, 'worplex_field_sub_header', true);
    }
    if (!is_home() && !is_front_page() && $page_subheader_switch != 'off') {
        ob_start();
        ?>
        <div class="bg-title py-5" data-overlay="0">
				<div class="ht-30"></div>
				<div class="container">
					<div class="row">
						<div class="colxl-12 col-lg-12 col-md-12">
							<h1 class="ft-medium"><?php worplex_post_page_title() ?></h1>
							<nav aria-label="breadcrumb">
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="<?php echo home_url(); ?>" class="text-light"><?php esc_html_e('Home', 'worplex') ?></a></li>
									<li class="breadcrumb-item"><a href="<?php echo home_url(); ?>" class="text-light"><?php esc_html_e('Job', 'worplex') ?></a></li>
									<li class="breadcrumb-item active theme-cl" aria-current="page"><?php worplex_post_page_title() ?></li>
								</ol>
							</nav>
						</div>
					</div>
				</div>
				<div class="ht-30"></div>
			</div>
        <?php
        $html .= ob_get_clean();
    }
    
    if ($page_type != 'page_full_width') {
        if (function_exists('is_checkout')) {
            if (is_checkout()) {
                echo '<div class="bg-light">';
            }
        }
        $html .= '<div class="container">';
    }
    return $html;
}, 10, 2);

add_filter('worplex_after_page_container_markup', function($html = '', $page_type = 'page') {
    $html = '';
    if ($page_type != 'page_full_width') {
        $html = '</div>';
        if (function_exists('is_checkout')) {
            if (is_checkout()) {
                echo '</div>';
            }
        }
    }
    return $html;
}, 10, 2);

add_action('worplex_before_main_content', function($page_type = 'page') {

    $html = '';
    $has_sidebar = false;
    $content_class = '';
    if ($page_type == 'page' || $page_type == 'single') {
        $post_id = get_the_id();

        if (metadata_exists('post', $post_id, 'worplex_field_post_layout')) {
            $layout = get_post_meta($post_id, 'worplex_field_post_layout', true);
            $sidebar = get_post_meta($post_id, 'worplex_field_post_sidebar', true);
        }
    }
    if (!isset($layout)) {
        global $worplex_framework_options;
        $layout = isset($worplex_framework_options['worplex-default-layout']) ? $worplex_framework_options['worplex-default-layout'] : '';
        $sidebar = isset($worplex_framework_options['worplex-default-sidebar']) ? $worplex_framework_options['worplex-default-sidebar'] : '';
    }

    if (($layout == 'right' || $layout == 'left') && $sidebar != '' && is_active_sidebar($sidebar)) {
        $has_sidebar = true;
        $content_class = $layout == 'left' ? ' pull-right' : ' pull-left';
    } else if (is_active_sidebar('sidebar-1') && $layout == '') {
        $has_sidebar = true;
    }

    if ($page_type == '404') {
        $html = '<div class="worplex-404-page">' . "\n";
    } else {
        if ($has_sidebar) {
            $html = '<div class="row"><div class="col-md-8 col-sm-8 col-xs-12' . $content_class . '">';
        }
    }
    echo ($html);
});

add_action('worplex_after_main_content', function($page_type = 'page') {

    $html = '';
    $has_sidebar = false;
    $sidebar_class = '';
    if ($page_type == 'page' || $page_type == 'single') {
        $post_id = get_the_id();

        if (metadata_exists('post', $post_id, 'worplex_field_post_layout')) {
            $layout = get_post_meta($post_id, 'worplex_field_post_layout', true);
            $sidebar = get_post_meta($post_id, 'worplex_field_post_sidebar', true);
        }
    }
    if (!isset($layout)) {
        global $worplex_framework_options;
        $layout = isset($worplex_framework_options['worplex-default-layout']) ? $worplex_framework_options['worplex-default-layout'] : '';
        $sidebar = isset($worplex_framework_options['worplex-default-sidebar']) ? $worplex_framework_options['worplex-default-sidebar'] : '';
    }

    if (($layout == 'right' || $layout == 'left') && $sidebar != '' && is_active_sidebar($sidebar)) {
        $has_sidebar = true;
        $sidebar_class = $layout == 'left' ? ' pull-left' : ' pull-right';
    } else if (is_active_sidebar('sidebar-1') && $layout == '') {
        $has_sidebar = true;
        $sidebar = 'sidebar-1';
    }

    if ($page_type == '404') {
        $html = '</div>' . "\n";
    } else {
        if ($has_sidebar) {
            $html = '</div>';
            ob_start();
            echo '<div class="col-md-4 col-sm-4 col-xs-12' . $sidebar_class . '">';
            dynamic_sidebar($sidebar);
            echo '</div>';
            $html .= ob_get_clean();
            $html .= '</div>';
        }
    }
    echo ($html);
});

// Default Layouts Sidebars Register
add_action('widgets_init', 'worplex_dynamic_sidebars');

function worplex_dynamic_sidebars() {
	global $worplex_framework_options;

	$worplex_sidebars = isset($worplex_framework_options['worplex-themes-sidebars']) ? $worplex_framework_options['worplex-themes-sidebars'] : '';
	if (is_array($worplex_sidebars) && sizeof($worplex_sidebars) > 0) {
		foreach ($worplex_sidebars as $sidebar) {
			if ($sidebar != '') {
				$sidebar_id = urldecode(sanitize_title($sidebar));
				register_sidebar(array(
					'name' => $sidebar,
					'id' => $sidebar_id,
					'description' => esc_html__('Add widgets here.', "worplex-frame"),
					'before_widget' => '<div id="%1$s" class="widget worplex-widget %2$s">',
					'after_widget' => '</div>',
					'before_title' => '<div class="widget-header"><h2>',
					'after_title' => '</h2></div>',
				));
			}
		}
	}
}

// Footer Sidebars Register
add_action('widgets_init', 'worplex_footer_dynamic_sidebars');

function worplex_footer_dynamic_sidebars() {
	global $worplex_framework_options;

	$before_title = '<div class="widget-header"><h2>';
	$after_title = '</h2></div>';

	$worplex_sidebars = isset($worplex_framework_options['worplex-footer-sidebars']) ? $worplex_framework_options['worplex-footer-sidebars'] : '';
	if (isset($worplex_sidebars['col_width']) && is_array($worplex_sidebars['col_width']) && sizeof($worplex_sidebars['col_width']) > 0) {
		$sidebar_counter = 0;
		foreach ($worplex_sidebars['col_width'] as $sidebar_col) {
			$sidebar = isset($worplex_sidebars['sidebar_name'][$sidebar_counter]) ? $worplex_sidebars['sidebar_name'][$sidebar_counter] : '';
			if ($sidebar != '') {
				$sidebar_id = urldecode(sanitize_title($sidebar));
				register_sidebar(array(
					'name' => $sidebar,
					'id' => $sidebar_id,
					'description' => esc_html__('Add only one widget here.', "worplex-frame"),
					'before_widget' => '<div id="%1$s" class="widget footer-widget %2$s">',
					'after_widget' => '</div>',
					'before_title' => $before_title,
					'after_title' => $after_title,
				));
			}
			$sidebar_counter++;
		}
	}
}

add_filter('worplex_archive_page_title_markup', function($html) {
    ob_start();
    ?>
    <div class="worplex-archive-header">
        <h1><?php the_archive_title(); ?></h1>
    </div>
    <?php
    $html = ob_get_clean();
    $html = '';

    return $html;
});

add_filter('worplex_search_title_output', function($html) {
    ob_start();
    ?>
    <div class="worplex-search-header">
        <h1>
            <?php
            printf(
                __( 'Search Results for: %s', 'worplex-frame' ),
                '<span>' . get_search_query() . '</span>'
            );
            ?>
        </h1>
    </div>
    <?php
    $html = ob_get_clean();
    $html = '';

    return $html;
});