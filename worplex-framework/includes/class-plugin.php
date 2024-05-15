<?php

defined('ABSPATH') || exit;

class Worplex_Plugin {
    
    public $version = '1.0';
    
    public function __construct() {
        $this->define_constants();
        $this->includes();
        $this->init_hooks();
    }

    private function set_locale() {

        if (function_exists('determine_locale')) {
            $locale = determine_locale();
        } else {
            // @todo Remove when start supporting WP 5.0 or later.
            $locale = is_admin() ? get_user_locale() : get_locale();
        }
        $locale = apply_filters('plugin_locale', $locale, 'worplex-frame');
        unload_textdomain('worplex-frame');
        load_textdomain('worplex-frame', WP_LANG_DIR . '/plugins/worplex-frame-' . $locale . '.mo');
        load_plugin_textdomain('worplex-frame', false, dirname(dirname(plugin_basename(__FILE__))) . '/languages');
    }

    public function set_plugin_locale() {
        $this->set_locale();
    }
    
    private function define_const($name, $value) {
        if (!defined($name)) {
            define($name, $value);
        }
    }
    
    private function define_constants() {
        $this->define_const('WORPLEX_ABSPATH', dirname(WORPLEX_PLUGIN_FILE) . '/');
        $this->define_const('WORPLEX_PLUGIN_VERSION', $this->version);
    }

    private function includes() {
        include_once WORPLEX_ABSPATH . 'envato_setup/setup.php';
        include_once WORPLEX_ABSPATH . 'envato_setup/setup-init.php';
        include_once WORPLEX_ABSPATH . 'includes/data-files/countries.php';
        include_once WORPLEX_ABSPATH . 'includes/common-functions.php';
        include_once WORPLEX_ABSPATH . 'includes/theme-common.php';
        include_once WORPLEX_ABSPATH . 'includes/redux-framework/redux-ext/loader.php';
        include_once WORPLEX_ABSPATH . 'includes/redux-framework/class-redux-framework-plugin.php';
        include_once WORPLEX_ABSPATH . 'includes/redux-framework/framework-options/options-config.php';
        include_once WORPLEX_ABSPATH . 'includes/custom-menu/custom-menu-walker.php';

        // Page Templates
        include_once WORPLEX_ABSPATH . 'includes/class-page-templates.php';

        // User Account/Dashboard Functions
        include_once WORPLEX_ABSPATH . 'includes/account-functions.php';
        include_once WORPLEX_ABSPATH . 'includes/candidate-functions.php';
        include_once WORPLEX_ABSPATH . 'includes/employer-functions.php';

        // User Dashboard File
        include_once WORPLEX_ABSPATH . 'includes/dashboard/account-profile.php';

        // taxonomy custom meta
        include_once WORPLEX_ABSPATH . 'includes/custom-taxonomy-meta.php';

        //
        include_once WORPLEX_ABSPATH . 'includes/meta-boxes.php';
        
        include_once WORPLEX_ABSPATH . 'includes/custom-post-type.php';

        //
        include_once WORPLEX_ABSPATH . 'includes/vc-shortcodes.php';

        //
        include_once WORPLEX_ABSPATH . 'includes/class-elementor.php';
        
        // custom fields
        include_once WORPLEX_ABSPATH . 'includes/custom-fields/custom-fields.php';
        
        // Widgets
        include_once WORPLEX_ABSPATH . 'includes/widgets/about-info.php';
        include_once WORPLEX_ABSPATH . 'includes/widgets/usefull-links.php';
        include_once WORPLEX_ABSPATH . 'includes/widgets/tranding-post.php';
        include_once WORPLEX_ABSPATH . 'includes/widgets/category.php';
        include_once WORPLEX_ABSPATH . 'includes/widgets/tags.php';

        // Login Register
        include_once WORPLEX_ABSPATH . 'includes/login-register/frontend.php';
        include_once WORPLEX_ABSPATH . 'includes/login-register/save-submit.php';
        
        
    }
    
    private function init_hooks() {
        add_filter('template_include', array($this, 'single_template'));
        add_action('wp_enqueue_scripts', array($this, 'front_enqueues'));
        add_action('admin_enqueue_scripts', array($this, 'admin_enqueues'));
    }
    
    public function front_enqueues() {
        global $worplex_framework_options;
        $google_api_keys = isset($worplex_framework_options['google_api_keys']) ? $worplex_framework_options['google_api_keys'] : '';
        wp_enqueue_style('worplex-bootstrap', self::root_url() . 'css/bootstrap.min.css', array(), WORPLEX_PLUGIN_VERSION);
        wp_enqueue_style('worplex-main', self::root_url() . 'css/main.css', array(), WORPLEX_PLUGIN_VERSION);
        wp_register_style('worplex-datetimepicker', self::root_url() . 'css/jquery.datetimepicker.css', array(), WORPLEX_PLUGIN_VERSION);
        wp_register_style('worplex-dashboard', self::root_url() . 'css/dashboard.css', array(), WORPLEX_PLUGIN_VERSION);
        
        // JS File Enques
        wp_enqueue_script('worplex-bootstrap.min', self::root_url() . 'js/bootstrap.min.js', array('jquery'), WORPLEX_PLUGIN_VERSION, true);
        wp_register_script('worplex-google-map', 'https://maps.google.com/maps/api/js?key='.$google_api_keys.'', array(), WORPLEX_PLUGIN_VERSION, true);
        wp_register_script('worplex-map', self::root_url() . 'js/map.js', array(), WORPLEX_PLUGIN_VERSION, true);
        wp_register_script('worplex-map-infobox', self::root_url() . 'js/map_infobox.js', array(), WORPLEX_PLUGIN_VERSION, true);
        wp_register_script('worplex-markerclusterer', self::root_url() . 'js/markerclusterer.js', array(), WORPLEX_PLUGIN_VERSION, true);
        wp_enqueue_script('worplex-popper.min', self::root_url() . 'js/popper.min.js', array(), WORPLEX_PLUGIN_VERSION, true);
        wp_enqueue_script('worplex-slick', self::root_url() . 'js/slick.js', array(), WORPLEX_PLUGIN_VERSION, true);
        wp_enqueue_script('worplex-smoothproducts', self::root_url() . 'js/smoothproducts.js', array(), WORPLEX_PLUGIN_VERSION, true);
        wp_enqueue_script('worplex-snackbar.min', self::root_url() . 'js/snackbar.min.js', array(), WORPLEX_PLUGIN_VERSION, true);
        wp_enqueue_script('worplex-custom-scripts', self::root_url() . 'js/custom.js', array(), WORPLEX_PLUGIN_VERSION, true);
        $js_arr = array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'submiting' => esc_html__('Submitting...', 'worplex-frame'),
            'alredy_saved' => esc_html__('You have already saved this job.', 'worplex-frame'), 
        );
        wp_localize_script('worplex-custom-scripts', 'worplex_cscript_vars', $js_arr);

        //
        wp_register_script('worplex-datetimepicker-full', self::root_url() . 'js/jquery.datetimepicker.full.min.js', array(), WORPLEX_PLUGIN_VERSION, true);

        wp_register_script('worplex-dashboard', self::root_url() . 'js/dashboard.js', array(), WORPLEX_PLUGIN_VERSION, true);
        $js_arr = array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'submiting' => esc_html__('Submitting...', 'worplex-frame'),
        );
        wp_localize_script('worplex-dashboard', 'worplex_dashb_vars', $js_arr);
    }
    
    public function admin_enqueues() {
        wp_enqueue_style('worplex-font-awesome', self::root_url() . 'css/font-awesome.css', array(), WORPLEX_PLUGIN_VERSION);
        wp_enqueue_style('worplex-line-icons', self::root_url() . 'css/line-icons.css', array(), WORPLEX_PLUGIN_VERSION);

        wp_register_style('worplex-datetimepicker', self::root_url() . 'css/jquery.datetimepicker.css', array(), WORPLEX_PLUGIN_VERSION);
        wp_enqueue_style('fonticonpicker', self::root_url() . 'includes/icon-picker/font/jquery.fonticonpicker.min.css', array(), WORPLEX_PLUGIN_VERSION);
        wp_enqueue_style('fonticonpicker-bootstrap', self::root_url() . 'includes/icon-picker/theme/bootstrap-theme/jquery.fonticonpicker.bootstrap.css', array(), WORPLEX_PLUGIN_VERSION);
        wp_enqueue_style('worplex-admin-styles', self::root_url() . 'css/admin/admin-styles.css', array(), WORPLEX_PLUGIN_VERSION);

        wp_register_script('worplex-icons-loader', self::root_url() . 'includes/icon-picker/js/icons-load.js', array('jquery'), WORPLEX_PLUGIN_VERSION, false);
        $icons_arr = array(
            'plugin_url' => self::root_url(),
        );
        wp_localize_script('worplex-icons-loader', 'worplex_icons_vars', $icons_arr);
        wp_enqueue_script('worplex-icons-loader');
        
        wp_register_script('worplex-datetimepicker-full', self::root_url() . 'js/jquery.datetimepicker.full.min.js', array(), WORPLEX_PLUGIN_VERSION, true);

        wp_enqueue_script('worplex-admin', self::root_url() . 'js/admin/admin.js', array('jquery'), WORPLEX_PLUGIN_VERSION, true);

        wp_enqueue_script('fonticonpicker', self::root_url() . 'includes/icon-picker/js/jquery.fonticonpicker.min.js', array('worplex-icons-loader'), WORPLEX_PLUGIN_VERSION, true);
    }
    
    public static function root_url() {
        return trailingslashit(plugins_url('/', WORPLEX_PLUGIN_FILE));
    }
    
    /*Function for detail pages*/
    public function single_template($single_template) 
    {
        global $post;
        if (is_single()) {
            
            if (get_post_type() == 'candidates') {
                $theme_template = locate_template(array('candidate-detail.php'));
                if (!empty($theme_template)) {
                    $single_template = $theme_template;
                } else {
                    $single_template = plugin_dir_path(__FILE__) . 'single-pages/candidate-detail.php';
                }
            }
            if (get_post_type() == 'employer') {
                $theme_template = locate_template(array('employer-detail.php'));
                if (!empty($theme_template)) {
                    $single_template = $theme_template;
                } else {
                    $single_template = plugin_dir_path(__FILE__) . 'single-pages/employer-detail.php';
                }
            }
             if (get_post_type() == 'jobs') {
                $theme_template = locate_template(array('job-detail.php'));
                if (!empty($theme_template)) {
                    $single_template = $theme_template;
                } else {
                    $single_template = plugin_dir_path(__FILE__) . 'single-pages/job-detail.php';
                }
            }
        }
        
        return $single_template;
    }
    
    
}

new Worplex_Plugin;