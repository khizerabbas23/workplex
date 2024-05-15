<?php

/**
 * Page templates class
 * 
 * @return object
 */
class Worplex_Page_Templates {

    public function __construct() {

        $this->templates = array();

        add_filter('theme_page_templates', array($this, 'custom_page_templates_callback'), 1, 1);
        add_filter('template_include', array($this, 'user_dashboard_page_templates'));
        add_action('init', array($this, 'all_templates_list_callback'), 3, 0);
    }

    public function all_templates_list_callback() {
        $all_templates = array(
            'user-login-template.php' => __('User Login', 'worplex-frame'),
            'user-dashboard-template.php' => __('User Dashboard', 'worplex-frame'),
            'post-new-job.php' => __('Post New Job', 'worplex-frame'),
        );
        $this->templates = apply_filters('worplex_templates_list_set', $all_templates);
    }

    public function custom_page_templates_callback($post_templates) {
        $post_templates = array_merge($this->templates, $post_templates);
        return $post_templates;
    }

    public function user_dashboard_page_templates($template) {
        global $post;
        if (!isset($post)) {
            return $template;
        }
        if (!isset($this->templates[get_post_meta($post->ID, '_wp_page_template', true)])) {
            return $template;
        }
        if ('user-login-template.php' === get_post_meta($post->ID, '_wp_page_template', true)) {

            $file = WORPLEX_ABSPATH . 'templates/' . get_post_meta($post->ID, '_wp_page_template', true);
            if (file_exists($file)) {
                return $file;
            }
        }
        if ('user-dashboard-template.php' === get_post_meta($post->ID, '_wp_page_template', true)) {

            $file = WORPLEX_ABSPATH . 'templates/' . get_post_meta($post->ID, '_wp_page_template', true);
            if (file_exists($file)) {
                return $file;
            }
        }
        if ('post-new-job.php' === get_post_meta($post->ID, '_wp_page_template', true)) {

            $file = WORPLEX_ABSPATH . 'templates/' . get_post_meta($post->ID, '_wp_page_template', true);
            if (file_exists($file)) {
                return $file;
            }
        }
        return apply_filters('worplex_template_page_file', $template);
    }

}

$Worplex_page_templates = new Worplex_Page_Templates();
