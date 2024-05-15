<?php

add_action('vc_before_init', 'worplex_row_add_view_param');

function worplex_row_add_view_param() {

    $attributes = array(
        'type' => 'dropdown',
        'heading' => esc_html__("Row View", "worplex-frame"),
        'param_name' => 'worplex_container',
        'value' => array(esc_html__("Box", "worplex-frame") => 'box', esc_html__("Wide", "worplex-frame") => 'wide'),
        'description' => ''
    );

    if (function_exists('vc_add_param')) {
        vc_add_param('vc_row', $attributes);
    }
}

require WORPLEX_ABSPATH . 'includes/shortcodes/counters.php';
require WORPLEX_ABSPATH . 'includes/shortcodes/pop-top-categories.php';
require WORPLEX_ABSPATH . 'includes/shortcodes/partners.php';
require WORPLEX_ABSPATH . 'includes/shortcodes/browse-resumes.php';
require WORPLEX_ABSPATH . 'includes/shortcodes/browse-jobs.php';

require WORPLEX_ABSPATH . 'includes/shortcodes/our-pricing-tabel.php';
require WORPLEX_ABSPATH . 'includes/shortcodes/attractive-portfolio.php';
require WORPLEX_ABSPATH . 'includes/shortcodes/jobs_looking_for.php';
require WORPLEX_ABSPATH . 'includes/shortcodes/popular-listed-jobs.php';
require WORPLEX_ABSPATH . 'includes/shortcodes/latest-news.php';
require WORPLEX_ABSPATH . 'includes/shortcodes/testimonials.php';
require WORPLEX_ABSPATH . 'includes/shortcodes/search-app.php';
require WORPLEX_ABSPATH . 'includes/shortcodes/map-style.php';
require WORPLEX_ABSPATH . 'includes/shortcodes/subscribe-newsletter.php';
require WORPLEX_ABSPATH . 'includes/shortcodes/top-candidates-listing.php';
require WORPLEX_ABSPATH . 'includes/shortcodes/latest-news-inner.php';
require WORPLEX_ABSPATH . 'includes/shortcodes/faq-inner.php';
require WORPLEX_ABSPATH . 'includes/shortcodes/about-us.php';
require WORPLEX_ABSPATH . 'includes/shortcodes/contact-us.php';
require WORPLEX_ABSPATH . 'includes/shortcodes/top-search-banner.php';
require WORPLEX_ABSPATH . 'includes/shortcodes/job-search-v1.php';
require WORPLEX_ABSPATH . 'includes/shortcodes/privacy-policy.php';
require WORPLEX_ABSPATH . 'includes/shortcodes/browse-employers-v1.php';
require WORPLEX_ABSPATH . 'includes/shortcodes/browse-emplye-v2.php';
require WORPLEX_ABSPATH . 'includes/shortcodes/banner-logos.php';
require WORPLEX_ABSPATH . 'includes/shortcodes/example-filter-ajax.php';
require WORPLEX_ABSPATH . 'includes/shortcodes/browse-categories.php';
require WORPLEX_ABSPATH . 'includes/shortcodes/dashboard-manage.php';





 
