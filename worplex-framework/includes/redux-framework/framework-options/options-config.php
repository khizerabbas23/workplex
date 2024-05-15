<?php

defined('ABSPATH') || exit;

if (!class_exists('ReduxFramework')) {
    return;
}

// This is your option name where all the Redux data is stored.
$opt_name = 'worplex_framework_options';

$theme = wp_get_theme();
$args = array(
    // This is where your data is stored in the database and also becomes your global variable name.
    'opt_name' => $opt_name,
    // Name that appears at the top of your panel.
    'display_name' => $theme->get('Name'),
    // Version that appears at the top of your panel.
    'display_version' => $theme->get('Version'),
    // Specify if the admin menu should appear or not. Options: menu or submenu (Under appearance only).
    'menu_type' => 'menu',
    // Show the sections below the admin menu item or not.
    'allow_sub_menu' => true,
    // The text to appear in the admin menu.
    'menu_title' => __('Theme Options', 'worplex-frame'),
    // The text to appear on the page title.
    'page_title' => __('Theme Options', 'worplex-frame'),
    // Enabled the Webfonts typography module to use asynchronous fonts.
    'async_typography' => false,
    // Disable to create your own google fonts loader.
    'disable_google_fonts_link' => false,
    // Show the panel pages on the admin bar.
    'admin_bar' => true,
    // Icon for the admin bar menu.
    'admin_bar_icon' => 'dashicons-portfolio',
    // Priority for the admin bar menu.
    'admin_bar_priority' => 50,
    // Sets a different name for your global variable other than the opt_name.
    'global_variable' => '',
    // Show the time the page took to load, etc (forced on while on localhost or when WP_DEBUG is enabled).
    'dev_mode' => false,
    // Enable basic customizer support.
    'customizer' => true,
    // Allow the panel to opened expanded.
    'open_expanded' => false,
    // Disable the save warning when a user changes a field.
    'disable_save_warn' => false,
    // Order where the menu appears in the admin area. If there is any conflict, something will not show. Warning.
    'page_priority' => null,
    // For a full list of options, visit: http://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters.
    'page_parent' => 'themes.php',
    // Permissions needed to access the options panel.
    'page_permissions' => 'manage_options',
    // Specify a custom URL to an icon.
    'menu_icon' => '',
    // Force your panel to always open to a specific tab (by id).
    'last_tab' => '',
    // Icon displayed in the admin panel next to your menu_title.
    'page_icon' => 'icon-themes',
    // Page slug used to denote the panel, will be based off page title, then menu title, then opt_name if not provided.
    'page_slug' => $opt_name,
    // On load save the defaults to DB before user clicks save.
    'save_defaults' => true,
    // Display the default value next to each field when not set to the default value.
    'default_show' => false,
    // What to print by the field's title if the value shown is default.
    'default_mark' => '*',
    // Shows the Import/Export panel when not used as a field.
    'show_import_export' => true,
    // The time transinets will expire when the 'database' arg is set.
    'transient_time' => 60 * MINUTE_IN_SECONDS,
    // Global shut-off for dynamic CSS output by the framework. Will also disable google fonts output.
    'output' => true,
    // Allows dynamic CSS to be generated for customizer and google fonts,
    // but stops the dynamic CSS from going to the page head.
    'output_tag' => true,
    // Disable the footer credit of Redux. Please leave if you can help it.
    'footer_credit' => '',
    // If you prefer not to use the CDN for ACE Editor.
    // You may download the Redux Vendor Support plugin to run locally or embed it in your code.
    'use_cdn' => true,
    // Set the theme of the option panel.  Use 'wp' to use a more modern style, default is classic.
    'admin_theme' => 'wp',
    // HINTS.
    'hints' => array(
        'icon' => 'el el-question-sign',
        'icon_position' => 'right',
        'icon_color' => 'lightgray',
        'icon_size' => 'normal',
        'tip_style' => array(
            'color' => 'red',
            'shadow' => true,
            'rounded' => false,
            'style' => '',
        ),
        'tip_position' => array(
            'my' => 'top left',
            'at' => 'bottom right',
        ),
        'tip_effect' => array(
            'show' => array(
                'effect' => 'slide',
                'duration' => '500',
                'event' => 'mouseover',
            ),
            'hide' => array(
                'effect' => 'slide',
                'duration' => '500',
                'event' => 'click mouseleave',
            ),
        ),
    ),
    // FUTURE -> Not in use yet, but reserved or partially implemented. Use at your own risk.
    // possible: options, theme_mods, theme_mods_expanded, transient. Not fully functional, warning!
    'database' => '',
    'network_admin' => true,
);

$redux_class = new Redux;

if (class_exists('Redux') && method_exists($redux_class, 'set_args')) {
    Redux::set_args($opt_name, $args);

    $gen_opts_atts = array();
    $gen_opts_atts[] = array(
        'id' => 'worplex-site-logo',
        'type' => 'media',
        'url' => true,
        'title' => __('Site Logo', 'worplex-frame'),
        'compiler' => 'true',
        'desc' => __('Site Logo media uploader.', 'worplex-frame'),
        'subtitle' => __('Site Logo media uploader.', 'worplex-frame'),
        'default' => array('url' => trailingslashit(get_template_directory_uri()) . 'images/logo.png'),
    );
    $gen_opts_atts[] = array(
        'id' => 'worplex-logo-width',
        'type' => 'slider',
        'title' => __('Logo Width', 'worplex-frame'),
        'subtitle' => __('Set Logo Width', 'worplex-frame'),
        'desc' => __('Set Logo Width in (px)', 'worplex-frame'),
        "default" => 0,
        "min" => 0,
        "step" => 1,
        "max" => 500,
        'display_value' => 'text'
    );
    $gen_opts_atts[] = array(
        'id' => 'worplex-logo-height',
        'type' => 'slider',
        'title' => __('Logo Height', 'worplex-frame'),
        'subtitle' => __('Set Logo Height', 'worplex-frame'),
        'desc' => __('Set Logo Height in (px)', 'worplex-frame'),
        "default" => 0,
        "min" => 0,
        "step" => 1,
        "max" => 500,
        'display_value' => 'text'
    );
    $gen_opts_atts[] = array(
        'id' => 'worplex-site-loader',
        'type' => 'button_set',
        'title' => __('Site loader', 'worplex-frame'),
        'subtitle' => __('Site loader on page loading.', 'worplex-frame'),
        'desc' => '',
        'options' => array(
            'on' => __('On', 'worplex-frame'),
            'off' => __('Off', 'worplex-frame'),
        ),
        'default' => 'on',
    );

    $redux_genral_options = array(
        'title' => __('General Options', 'worplex-frame'),
        'id' => 'general-options',
        'desc' => __('These are really basic options!', 'worplex-frame'),
        'icon' => 'el el-home',
        'fields' => apply_filters('worplex_framewrok_options_general', $gen_opts_atts)
    );
    Redux::set_section($opt_name, $redux_genral_options);

    add_filter('redux/options/worplex_framework_options/sections', 'worplex_frame_plugin_core_settings', 1);

    function worplex_frame_plugin_core_settings($setting_sections)
    {
        global $worplex_framework_options, $wpdb;
        //
        $worplex_framework_options = get_option('worplex_framework_options');

        $header_opt_settings = array(
            'title' => __('Header', 'worplex-frame'),
            'id' => 'general-options-header',
            'desc' => __('Set Header Fields.', 'worplex-frame'),
            'icon' => 'el el-credit-card',
            'fields' => array()
        );

        $all_page = array('', __('Select Page', 'worplex-frame'));

        $args = array(
            'sort_order' => 'asc',
            'sort_column' => 'post_title',
            'hierarchical' => 1,
            'exclude' => '',
            'include' => '',
            'meta_key' => '',
            'meta_value' => '',
            'authors' => '',
            'child_of' => 0,
            'parent' => -1,
            'exclude_tree' => '',
            'number' => '',
            'offset' => 0,
            'post_type' => 'page',
            'post_status' => 'publish'
        );
        $pages = get_pages($args);
        if (!empty($pages)) {
            foreach ($pages as $page) {
                $all_page[$page->post_name] = $page->post_title;
            }
        }

        $header_opt_settings['fields'][] = array(
            'id' => 'header-style',
            'type' => 'select',
            'title' => __('Header Styles', 'worplex-frame'),
            'subtitle' => '',
            'desc' => '',
            'options' => array(
                'style1' => __('Header Style 1', 'worplex-frame'),
                'style2' => __('Header Style 2', 'worplex-frame'),
            ),
            'default' => 'style1',
        );
        $header_opt_settings['fields'][] = array(
            'id' => 'header_email',
            'type' => 'text',
            'title' => __('Header Email', 'worplex-frame'),
            'subtitle' => __('Put email address here to show on header left', 'worplex-frame'),
            'desc' => '',
            'default' => '',
        );
        $header_opt_settings['fields'][] = array(
            'id' => 'header_phone',
            'type' => 'text',
            'title' => __('Header Phone', 'worplex-frame'),
            'subtitle' => __('Put phone number  here to show on header left', 'worplex-frame'),
            'desc' => '',
            'default' => '',
        );
        $header_opt_settings['fields'][] = array(
            'id' => 'worplex-top-header',
            'type' => 'button_set',
            'title' => __('Top Header', 'worplex-frame'),
            'subtitle' => __('Top Header on/off.', 'worplex-frame'),
            'desc' => '',
            'options' => array(
                'on' => __('On', 'worplex-frame'),
                'off' => __('Off', 'worplex-frame'),
            ),
            'default' => 'off',
        );
        $header_opt_settings['fields'] = apply_filters('worplex_framewrok_options_headers', $header_opt_settings['fields']);
        $setting_sections[] = $header_opt_settings;
        $section_settings = array(
            'title' => __('Sub Header', 'worplex-frame'),
            'id' => 'subheader-options',
            'desc' => __('Default Sub Header settings.', 'worplex-frame'),
            'icon' => 'el el-lines',
            'fields' => array(
                array(
                    'id' => 'worplex-subheader',
                    'type' => 'button_set',
                    'title' => __('Sub Header', 'worplex-frame'),
                    'subtitle' => __('Sub Header on/off.', 'worplex-frame'),
                    'desc' => '',
                    'options' => array(
                        'on' => __('On', 'worplex-frame'),
                        'off' => __('Off', 'worplex-frame'),
                    ),
                    'default' => 'on',
                ),
                array(
                    'id' => 'worplex-subheader-height',
                    'type' => 'slider',
                    'title' => __('Sub Header Height', 'worplex-frame'),
                    'required' => array('worplex-subheader', 'equals', 'on'),
                    'subtitle' => __('Set Sub Header Height', 'worplex-frame'),
                    'desc' => __('Set Sub Header Height in (px)', 'worplex-frame'),
                    "default" => 0,
                    "min" => 0,
                    "step" => 1,
                    "max" => 1000,
                    'display_value' => 'text'
                ),
                array(
                    'id' => 'worplex-subheader-pading-top',
                    'type' => 'slider',
                    'title' => __('Padding Top', 'worplex-frame'),
                    'required' => array('worplex-subheader', 'equals', 'on'),
                    'subtitle' => __('Set Sub Header Padding Top', 'worplex-frame'),
                    'desc' => __('Set Sub Header Padding Top', 'worplex-frame'),
                    "default" => 0,
                    "min" => 0,
                    "step" => 1,
                    "max" => 1000,
                    'display_value' => 'text'
                ),
                array(
                    'id' => 'worplex-subheader-pading-bottom',
                    'type' => 'slider',
                    'title' => __('Padding Bottom', 'worplex-frame'),
                    'required' => array('worplex-subheader', 'equals', 'on'),
                    'subtitle' => __('Set Sub Header Padding Bottom', 'worplex-frame'),
                    'desc' => __('Set Sub Header Padding Bottom', 'worplex-frame'),
                    "default" => 0,
                    "min" => 0,
                    "step" => 1,
                    "max" => 1000,
                    'display_value' => 'text'
                ),
                array(
                    'id' => 'worplex-subheader-title',
                    'type' => 'button_set',
                    'title' => __('Sub Header Title', 'worplex-frame'),
                    'required' => array('worplex-subheader', 'equals', 'on'),
                    'subtitle' => __('Sub Header Title on/off.', 'worplex-frame'),
                    'desc' => '',
                    'options' => array(
                        'on' => __('On', 'worplex-frame'),
                        'off' => __('Off', 'worplex-frame'),
                    ),
                    'default' => 'on',
                ),
                array(
                    'id' => 'worplex-subheader-breadcrumb',
                    'type' => 'button_set',
                    'title' => __('Sub Header Breadcrumb', 'worplex-frame'),
                    'required' => array('worplex-subheader', 'equals', 'on'),
                    'subtitle' => __('Sub Header Breadcrumb on/off.', 'worplex-frame'),
                    'desc' => '',
                    'options' => array(
                        'on' => __('On', 'worplex-frame'),
                        'off' => __('Off', 'worplex-frame'),
                    ),
                    'default' => 'on',
                ),
                array(
                    'id' => 'worplex-subheader-bg-img',
                    'type' => 'media',
                    'url' => true,
                    'title' => __('Sub Header Background Image', 'worplex-frame'),
                    'required' => array('worplex-subheader', 'equals', 'on'),
                    'compiler' => 'true',
                    'desc' => '',
                    'subtitle' => __('Sub Header media uploader.', 'worplex-frame'),
                    'default' => '',
                ),
                array(
                    'id' => 'worplex-subheader-bg-color',
                    'type' => 'color_rgba',
                    'transparent' => false,
                    'title' => __('Sub Header Background Color', 'worplex-frame'),
                    'required' => array('worplex-subheader', 'equals', 'on'),
                    'subtitle' => __('Set Sub Header Background Color.', 'worplex-frame'),
                    'desc' => '',
                    'default' => 'rgba(17,22,44,0.66)'
                ),

            )
        );

        $setting_sections[] = $section_settings;
        
        // footer section start
        $header_opt_settings = array(
            'title' => __('Footer', 'worplex-frame'),
            'id' => 'general-options-footer',
            'desc' => __('Set Footer Fields.', 'worplex-frame'),
            'icon' => 'el el-tasks',
            'fields' => array(
                array(
                    'id' => 'footer-style',
                    'type' => 'select',
                    'title' => __('Footer Style', 'worplex-frame'),
                    'subtitle' => '',
                    'desc' => '',
                    'options' => array(
                        'style1' => __('Footer Style 1', 'worplex-frame'),
                        'style2' => __('Footer Style 2', 'worplex-frame'),
                    ),
                    'default' => 'style1',
                ),
                array(
                    'id' => 'worplex-footer-copyright-text',
                    'type' => 'textarea',
                    'title' => __('Copyright Text', 'worplex-frame'),
                    'subtitle' => __('Set Copyright Text here.', 'worplex-frame'),
                    'desc' => '',
                    'default' => sprintf(__('&copy; Copyrights %s. %s All rights reserved.', 'worplex-frame'), date('Y'), get_bloginfo('name')),
                ),
                array(
                    'id' => 'footer-background',
                    'type' => 'media',
                    'url' => true,
                    'title' => __('Footer Background', 'worplex-frame'),
                    'compiler' => 'true',
                    'desc' => __('Footer Background media uploader.', 'worplex-frame'),
                    'subtitle' => __('Footer Background media uploader.', 'worplex-frame'),
                    'default' => array('url' => ''),
                ),
            )
        );
        $setting_sections[] = $header_opt_settings;

        // footer sidebars section start
        $footer_sidebar_settings = array(
            'title' => __('Footer Sidebars', 'worplex-frame'),
            'id' => 'footer-sidebar-options',
            'desc' => __('Set Footer Sidebars.', 'worplex-frame'),
            'icon' => 'el el-th',
            'fields' => array(
                array(
                    'id' => 'worplex-footer-sidebar-switch',
                    'type' => 'button_set',
                    'title' => __('Footer Widgets Area', 'worplex-frame'),
                    'subtitle' => __('Footer Widgets Area on/off', 'worplex-frame'),
                    'desc' => '',
                    'options' => array(
                        'on' => __('On', 'worplex-frame'),
                        'off' => __('Off', 'worplex-frame'),
                    ),
                    'default' => 'off',
                ),
                array(
                    'id' => 'worplex-footer-sidebars',
                    'type' => 'worplex_multi_select',
                    'select_title' => __('Select Column Width', 'worplex-frame'),
                    'input_title' => __('Sidebar Name', 'worplex-frame'),
                    'select_name' => 'col_width',
                    'input_name' => 'sidebar_name',
                    'add_more_text' => __('Add Sidebar', 'worplex-frame'),
                    'select_options' => array(
                        '12_12' => '12/12',
                        '6_12' => '6/12',
                        '4_12' => '4/12',
                        '3_12' => '3/12',
                        '9_12' => '9/12',
                        '2_12' => '2/12',
                        '10_12' => '10/12',
                        '8_12' => '8/12',
                        '5_12' => '5/12',
                        '7_12' => '7/12',
                    ),
                    'title' => __('Footer Sidebars', 'worplex-frame'),
                    'required' => array('worplex-footer-sidebar-switch', 'equals', 'on'),
                    'subtitle' => __('Set Footer Sidebars here.', 'worplex-frame'),
                    'desc' => '',
                    'default' => '',
                ),
            )
        );
        $setting_sections[] = $footer_sidebar_settings;

        $section_settings = array(
            'title' => __('Color', 'worplex-frame'),
            'id' => 'theme-all-colors',
            'desc' => __('Set the First color for theme.', 'worplex-frame'),
            'icon' => 'el el-brush',
            'fields' => array(
                array(
                    'id' => 'worplex-main-color',
                    'type' => 'color',
                    'transparent' => false,
                    'title' => __('Theme Color', 'worplex-frame'),
                    'subtitle' => __('Set Main Theme Color.', 'worplex-frame'),
                    'desc' => '',
                    'default' => ''
                ),
                array(
                    'id' => 'worplex-body-color',
                    'type' => 'color',
                    'transparent' => false,
                    'title' => __('Body Background Color', 'worplex-frame'),
                    'subtitle' => __('Set Body Background Color.', 'worplex-frame'),
                    'desc' => '',
                    'default' => ''
                ),
                array(
                    'id' => 'header-colors-section',
                    'type' => 'section',
                    'title' => __('Header Colors', 'worplex-frame'),
                    'subtitle' => '',
                    'indent' => true,
                ),
                array(
                    'id' => 'header-bg-color',
                    'type' => 'color_rgba',
                    'transparent' => true,
                    'title' => __('Header Background Color', 'worplex-frame'),
                    'subtitle' => '',
                    'desc' => __('This color will apply to Header Background.', 'worplex-frame'),
                    'default' => '#ffffff',
                ),
                array(
                    'id' => 'header-links-color',
                    'type' => 'color_rgba',
                    'transparent' => true,
                    'title' => __('Link Color', 'worplex-frame'),
                    'subtitle' => '',
                    'desc' => __('This color will apply to the header links.', 'worplex-frame'),
                    'default' => '#6a6a6a',
                ),
                array(
                    'id' => 'header-txts-color',
                    'type' => 'color_rgba',
                    'transparent' => true,
                    'title' => __('Text Color', 'worplex-frame'),
                    'subtitle' => '',
                    'desc' => __('This color will apply to the header text.', 'worplex-frame'),
                    'default' => '#6a6a6a',
                ),
                array(
                    'id' => 'header-icons-color',
                    'type' => 'color_rgba',
                    'transparent' => true,
                    'title' => __('Icons Color', 'worplex-frame'),
                    'subtitle' => '',
                    'desc' => __('This color will apply to the header icons.', 'worplex-frame'),
                    'default' => '#00adef',
                ),
                array(
                    'id' => 'header-btn-bg-color',
                    'type' => 'color_rgba',
                    'transparent' => true,
                    'title' => __('Buttons Background Color', 'worplex-frame'),
                    'subtitle' => '',
                    'desc' => __('This color will apply to Header Background Buttons.', 'worplex-frame'),
                    'default' => '#ffffff',
                ),
                array(
                    'id' => 'header-btn-text-color',
                    'type' => 'color_rgba',
                    'transparent' => true,
                    'title' => __('Buttons Text Color', 'worplex-frame'),
                    'subtitle' => '',
                    'desc' => __('This color will apply to the header buttons text.', 'worplex-frame'),
                    'default' => '#6a6a6a',
                ),
                array(
                    'id' => 'menu-colors-section',
                    'type' => 'section',
                    'title' => __('Header Menu Colors', 'worplex-frame'),
                    'subtitle' => '',
                    'indent' => true,
                ),
                array(
                    'id' => 'menu-link-color',
                    'type' => 'link_color',
                    'title' => __('Menu Links Color', 'worplex-frame'),
                    'subtitle' => '',
                    'visited' => true,
                    'desc' => __('These colors will apply to header navigation menu items.', 'worplex-frame'),
                    'default' => array(
                        'regular' => '#656c6c',
                        'hover' => '#13b5ea',
                        'active' => '#13b5ea',
                        'visited' => '',
                    )
                ),
                array(
                    'id' => 'submenu-bg-color',
                    'type' => 'color',
                    'transparent' => false,
                    'title' => __('SubMenu Background Color', 'worplex-frame'),
                    'subtitle' => '',
                    'desc' => __('This color will apply to SubMenu Background.', 'worplex-frame'),
                    'default' => '#ffffff',
                ),
                array(
                    'id' => 'submenu-link-color',
                    'type' => 'link_color',
                    'title' => __('SubMenu Links Color', 'worplex-frame'),
                    'subtitle' => '',
                    'visited' => true,
                    'desc' => __('These colors will apply to header navigation sub-menu items.', 'worplex-frame'),
                    'default' => array(
                        'regular' => '#656c6c',
                        'hover' => '#13b5ea',
                        'active' => '#13b5ea',
                        'visited' => '',
                    )
                ),

                array(
                    'id' => 'footer-colors-section',
                    'type' => 'section',
                    'title' => __('Footer Colors', 'worplex-frame'),
                    'subtitle' => '',
                    'indent' => true,
                ),
                array(
                    'id' => 'footer-bg-color',
                    'type' => 'color',
                    'transparent' => false,
                    'title' => __('Footer Background Color', 'worplex-frame'),
                    'subtitle' => '',
                    'desc' => __('This color will apply on the Footer Background.', 'worplex-frame'),
                    'default' => '#26272b',
                ),
                array(
                    'id' => 'footer-text-color',
                    'type' => 'color',
                    'transparent' => false,
                    'title' => __('Footer Text Color', 'worplex-frame'),
                    'subtitle' => '',
                    'desc' => __('This color will apply to Footer Text.', 'worplex-frame'),
                    'default' => '#999999',
                ),
                array(
                    'id' => 'footer-link-color',
                    'type' => 'link_color',
                    'title' => __('Footer Links Color Option', 'worplex-frame'),
                    'subtitle' => '',
                    'visited' => true,
                    'desc' => __('These colors will apply to Footer links.', 'worplex-frame'),
                    'default' => array(
                        'regular' => '#999999',
                        'hover' => '#ffffff',
                        'active' => '#999999',
                        'visited' => '#ffffff',
                    )
                ),
                array(
                    'id' => 'footer-border-color',
                    'type' => 'color',
                    'transparent' => false,
                    'title' => __('Footer Borders Color', 'worplex-frame'),
                    'subtitle' => '',
                    'desc' => __('This color will apply on Footer all Borders like widgets etc.', 'worplex-frame'),
                    'default' => '#2e2e2e',
                ),
                array(
                    'id' => 'footer-copyright-bgcolor',
                    'type' => 'color',
                    'transparent' => false,
                    'title' => __('Footer copyright Background', 'worplex-frame'),
                    'subtitle' => '',
                    'desc' => __('This color will apply to Footer copyright Background.', 'worplex-frame'),
                    'default' => '#26272b',
                ),
                array(
                    'id' => 'footer-copyright-color',
                    'type' => 'color',
                    'transparent' => false,
                    'title' => __('Footer copyright Text Color', 'worplex-frame'),
                    'subtitle' => '',
                    'desc' => __('This color will apply to Footer copyright Text.', 'worplex-frame'),
                    'default' => '#999999',
                ),
            ),
        );
        $setting_sections[] = $section_settings;

        $footer_sidebar_settings = array(
            'title' => __('Typography', 'worplex-frame'),
            'id' => 'custom-typo-sec',
            'desc' => '',
            'icon' => 'el el-font',
            'fields' => array(
                array(
                    'id' => 'body-typo',
                    'type' => 'typography',
                    'title' => __('Body Typography', 'worplex-frame'),
                    'google' => true,
                    'text-transform' => true,
                    'letter-spacing' => true,
                    'word-spacing' => true,
                    'text-align' => false,
                    'font-backup' => true,
                    'output' => array('body', 'p', 'li'),
                    'units' => 'px',
                    'subtitle' => __('Typography options with each property can be called individually.', 'worplex-frame'),
                    'default' => array(
                        'color' => '',
                        'font-style' => '',
                        'font-family' => '',
                        'google' => true,
                        'font-size' => '',
                        'line-height' => ''
                    ),
                ),
                array(
                    'id' => 'menu-typo',
                    'type' => 'typography',
                    'title' => __('Menu Typography', 'worplex-frame'),
                    'google' => true,
                    'color' => false,
                    'text-transform' => true,
                    'letter-spacing' => true,
                    'word-spacing' => true,
                    'text-align' => false,
                    'font-backup' => true,
                    'output' => array('.navbar-nav > li > a'),
                    'units' => 'px',
                    'subtitle' => __('Typography options with each property can be called individually.', 'worplex-frame'),
                    'default' => array(
                        'color' => '',
                        'font-style' => '',
                        'font-family' => '',
                        'google' => true,
                        'font-size' => '',
                        'line-height' => ''
                    ),
                ),
                array(
                    'id' => 'submenu-typo',
                    'type' => 'typography',
                    'title' => __('SubMenu Typography', 'worplex-frame'),
                    'google' => true,
                    'text-transform' => true,
                    'letter-spacing' => true,
                    'word-spacing' => true,
                    'text-align' => false,
                    'color' => false,
                    'font-backup' => true,
                    'output' => array('.navbar-nav .sub-menu li a'),
                    'units' => 'px',
                    'subtitle' => __('Typography options with each property can be called individually.', 'worplex-frame'),
                    'default' => array(
                        'color' => '',
                        'font-style' => '',
                        'font-family' => '',
                        'google' => true,
                        'font-size' => '',
                        'line-height' => ''
                    ),
                ),
                array(
                    'id' => 'h1-typo',
                    'type' => 'typography',
                    'title' => __('H1 Typography', 'worplex-frame'),
                    'google' => true,
                    'text-transform' => true,
                    'letter-spacing' => true,
                    'word-spacing' => true,
                    'text-align' => false,
                    'font-backup' => true,
                    'output' => array('h1', 'body h1'),
                    'units' => 'px',
                    'subtitle' => __('Typography options with each property can be called individually.', 'worplex-frame'),
                    'default' => array(
                        'color' => '',
                        'font-style' => '',
                        'font-family' => '',
                        'google' => true,
                        'font-size' => '',
                        'line-height' => ''
                    ),
                ),
                array(
                    'id' => 'h2-typo',
                    'type' => 'typography',
                    'title' => __('H2 Typography', 'worplex-frame'),
                    'google' => true,
                    'text-transform' => true,
                    'letter-spacing' => true,
                    'word-spacing' => true,
                    'text-align' => false,
                    'font-backup' => true,
                    'output' => array('h2', 'body h2'),
                    'units' => 'px',
                    'subtitle' => __('Typography options with each property can be called individually.', 'worplex-frame'),
                    'default' => array(
                        'color' => '',
                        'font-style' => '',
                        'font-family' => '',
                        'google' => true,
                        'font-size' => '',
                        'line-height' => ''
                    ),
                ),
                array(
                    'id' => 'h3-typo',
                    'type' => 'typography',
                    'title' => __('H3 Typography', 'worplex-frame'),
                    'google' => true,
                    'text-transform' => true,
                    'letter-spacing' => true,
                    'word-spacing' => true,
                    'text-align' => false,
                    'font-backup' => true,
                    'output' => array('h3', 'body h3'),
                    'units' => 'px',
                    'subtitle' => __('Typography options with each property can be called individually.', 'worplex-frame'),
                    'default' => array(
                        'color' => '',
                        'font-style' => '',
                        'font-family' => '',
                        'google' => true,
                        'font-size' => '',
                        'line-height' => ''
                    ),
                ),
                array(
                    'id' => 'h4-typo',
                    'type' => 'typography',
                    'title' => __('H4 Typography', 'worplex-frame'),
                    'google' => true,
                    'text-transform' => true,
                    'letter-spacing' => true,
                    'word-spacing' => true,
                    'text-align' => false,
                    'font-backup' => true,
                    'output' => array('h4', 'body h4'),
                    'units' => 'px',
                    'subtitle' => __('Typography options with each property can be called individually.', 'worplex-frame'),
                    'default' => array(
                        'color' => '',
                        'font-style' => '',
                        'font-family' => '',
                        'google' => true,
                        'font-size' => '',
                        'line-height' => ''
                    ),
                ),
                array(
                    'id' => 'h5-typo',
                    'type' => 'typography',
                    'title' => __('H5 Typography', 'worplex-frame'),
                    'google' => true,
                    'text-transform' => true,
                    'letter-spacing' => true,
                    'word-spacing' => true,
                    'text-align' => false,
                    'font-backup' => true,
                    'output' => array('h5', 'body h5'),
                    'units' => 'px',
                    'subtitle' => __('Typography options with each property can be called individually.', 'worplex-frame'),
                    'default' => array(
                        'color' => '',
                        'font-style' => '',
                        'font-family' => '',
                        'google' => true,
                        'font-size' => '',
                        'line-height' => ''
                    ),
                ),
                array(
                    'id' => 'h6-typo',
                    'type' => 'typography',
                    'title' => __('H6 Typography', 'worplex-frame'),
                    'google' => true,
                    'text-transform' => true,
                    'letter-spacing' => true,
                    'word-spacing' => true,
                    'text-align' => false,
                    'font-backup' => true,
                    'output' => array('h6', 'body h6'),
                    'units' => 'px',
                    'subtitle' => __('Typography options with each property can be called individually.', 'worplex-frame'),
                    'default' => array(
                        'color' => '',
                        'font-style' => '',
                        'font-family' => '',
                        'google' => true,
                        'font-size' => '',
                        'line-height' => ''
                    ),
                ),
                array(
                    'id' => 'fancy-title-typo',
                    'type' => 'typography',
                    'title' => __('Fancy Title Typography', 'worplex-frame'),
                    'google' => true,
                    'text-transform' => true,
                    'letter-spacing' => true,
                    'word-spacing' => true,
                    'text-align' => false,
                    'font-backup' => true,
                    'output' => array('.worplex-fancy-title h2'),
                    'units' => 'px',
                    'subtitle' => __('Typography options with each property can be called individually.', 'worplex-frame'),
                    'default' => array(
                        'color' => '#333333',
                        'font-style' => 'normal',
                        'font-family' => 'Roboto',
                        'google' => true,
                        'font-size' => '24px',
                        'line-height' => '28px'
                    ),
                ),
                array(
                    'id' => 'page-title-typo',
                    'type' => 'typography',
                    'title' => __('Page Title Typography', 'worplex-frame'),
                    'google' => true,
                    'text-transform' => true,
                    'letter-spacing' => true,
                    'word-spacing' => true,
                    'text-align' => false,
                    'font-backup' => true,
                    'output' => array('.worplex-page-title h1'),
                    'units' => 'px',
                    'subtitle' => __('Typography options with each property can be called individually.', 'worplex-frame'),
                    'default' => array(
                        'color' => '#ffffff',
                        'font-style' => '600',
                        'font-family' => 'Roboto',
                        'google' => true,
                        'font-size' => '30px',
                        'line-height' => '34px'
                    ),
                ),
                array(
                    'id' => 'sidebar-widget-typo',
                    'type' => 'typography',
                    'title' => __('Sidebar widget title Typography', 'worplex-frame'),
                    'google' => true,
                    'text-transform' => true,
                    'letter-spacing' => true,
                    'word-spacing' => true,
                    'text-align' => false,
                    'font-backup' => true,
                    'output' => array('.worplex-widget-title h2'),
                    'units' => 'px',
                    'subtitle' => __('Typography options with each property can be called individually.', 'worplex-frame'),
                    'default' => array(
                        'color' => '#333333',
                        'font-style' => 'normal',
                        'font-family' => 'Roboto',
                        'google' => true,
                        'font-size' => '20px',
                        'line-height' => '24px'
                    ),
                ),
                array(
                    'id' => 'footer-widget-typo',
                    'type' => 'typography',
                    'title' => __('Footer widget title Typography', 'worplex-frame'),
                    'google' => true,
                    'text-transform' => true,
                    'letter-spacing' => true,
                    'word-spacing' => true,
                    'text-align' => false,
                    'font-backup' => true,
                    'output' => array('.footer-widget-title h2'),
                    'units' => 'px',
                    'subtitle' => __('Typography options with each property can be called individually.', 'worplex-frame'),
                    'default' => array(
                        'color' => '#ffffff',
                        'font-style' => 'normal',
                        'font-family' => 'Roboto',
                        'google' => true,
                        'font-size' => '18px',
                        'line-height' => '22px'
                    ),
                ),
            )
        );
        $setting_sections[] = $footer_sidebar_settings;

        $section_settings = array(
            'title' => __('Social Sharing', 'worplex-frame'),
            'id' => 'social-sharing',
            'desc' => __('Select platforms to share your posts.', 'worplex-frame'),
            'icon' => 'el el-share',
            'fields' => array(
                array(
                    'id' => 'worplex-social-sharing-facebook',
                    'type' => 'button_set',
                    'title' => __('Facebook', 'worplex-frame'),
                    'subtitle' => __('Social Sharing on Facebook.', 'worplex-frame'),
                    'desc' => '',
                    'options' => array(
                        'on' => __('On', 'worplex-frame'),
                        'off' => __('Off', 'worplex-frame'),
                    ),
                    'default' => 'on',
                ),
                array(
                    'id' => 'worplex-social-sharing-twitter',
                    'type' => 'button_set',
                    'title' => __('Twitter', 'worplex-frame'),
                    'subtitle' => __('Social Sharing on Twitter.', 'worplex-frame'),
                    'desc' => '',
                    'options' => array(
                        'on' => __('On', 'worplex-frame'),
                        'off' => __('Off', 'worplex-frame'),
                    ),
                    'default' => 'on',
                ),
                array(
                    'id' => 'worplex-social-sharing-tumblr',
                    'type' => 'button_set',
                    'title' => __('Tumblr', 'worplex-frame'),
                    'subtitle' => __('Social Sharing on Tumblr.', 'worplex-frame'),
                    'desc' => '',
                    'options' => array(
                        'on' => __('On', 'worplex-frame'),
                        'off' => __('Off', 'worplex-frame'),
                    ),
                    'default' => 'on',
                ),
                array(
                    'id' => 'worplex-social-sharing-dribbble',
                    'type' => 'button_set',
                    'title' => __('Dribbble', 'worplex-frame'),
                    'subtitle' => __('Social Sharing on Dribbble.', 'worplex-frame'),
                    'desc' => '',
                    'options' => array(
                        'on' => __('On', 'worplex-frame'),
                        'off' => __('Off', 'worplex-frame'),
                    ),
                    'default' => 'on',
                ),
                array(
                    'id' => 'worplex-social-sharing-stumbleupon',
                    'type' => 'button_set',
                    'title' => __('StumbleUpon', 'worplex-frame'),
                    'subtitle' => __('Social Sharing on StumbleUpon.', 'worplex-frame'),
                    'desc' => '',
                    'options' => array(
                        'on' => __('On', 'worplex-frame'),
                        'off' => __('Off', 'worplex-frame'),
                    ),
                    'default' => 'on',
                ),
                array(
                    'id' => 'worplex-social-sharing-youtube',
                    'type' => 'button_set',
                    'title' => __('Youtube', 'worplex-frame'),
                    'subtitle' => __('Social Sharing on Youtube.', 'worplex-frame'),
                    'desc' => '',
                    'options' => array(
                        'on' => __('On', 'worplex-frame'),
                        'off' => __('Off', 'worplex-frame'),
                    ),
                    'default' => 'on',
                ),
                array(
                    'id' => 'worplex-social-sharing-more',
                    'type' => 'button_set',
                    'title' => __('Share More', 'worplex-frame'),
                    'subtitle' => __('Social Sharing on other platforms.', 'worplex-frame'),
                    'desc' => '',
                    'options' => array(
                        'on' => __('On', 'worplex-frame'),
                        'off' => __('Off', 'worplex-frame'),
                    ),
                    'default' => 'on',
                ),
            )
        );
        $setting_sections[] = $section_settings;

        $section_settings = array(
            'title' => __('Social Networking', 'worplex-frame'),
            'id' => 'social-networking',
            'desc' => __('Set profile links for your Social Networking platforms.', 'worplex-frame'),
            'icon' => 'el el-random',
            'fields' => array(
                array(
                    'id' => 'worplex-social-networking-twitter',
                    'type' => 'text',
                    'title' => __('Twitter', 'worplex-frame'),
                    'subtitle' => __('Set a profile link for Twitter.', 'worplex-frame'),
                    'desc' => '',
                    'default' => '',
                ),
                array(
                    'id' => 'worplex-social-networking-facebook',
                    'type' => 'text',
                    'title' => __('Facebook', 'worplex-frame'),
                    'subtitle' => __('Set a profile link for Facebook.', 'worplex-frame'),
                    'desc' => '',
                    'default' => '',
                ),
                array(
                    'id' => 'worplex-social-networking-youtube',
                    'type' => 'text',
                    'title' => __('YouTube', 'worplex-frame'),
                    'subtitle' => __('Set a profile link for youtube.', 'worplex-frame'),
                    'desc' => '',
                    'default' => '',
                ),
                array(
                    'id' => 'worplex-social-networking-vimeo',
                    'type' => 'text',
                    'title' => __('Vimeo', 'worplex-frame'),
                    'subtitle' => __('Set a profile link for Vimeo.', 'worplex-frame'),
                    'desc' => '',
                    'default' => '',
                ),
                array(
                    'id' => 'worplex-social-networking-linkedin',
                    'type' => 'text',
                    'title' => __('Linkedin', 'worplex-frame'),
                    'subtitle' => __('Set a profile link for linkedin.', 'worplex-frame'),
                    'desc' => '',
                    'default' => '',
                ),
                array(
                    'id' => 'worplex-social-networking-pinterest',
                    'type' => 'text',
                    'title' => __('Pinterest', 'worplex-frame'),
                    'subtitle' => __('Set a profile link for Pinterest.', 'worplex-frame'),
                    'desc' => '',
                    'default' => '',
                ),
                array(
                    'id' => 'worplex-social-networking-instagram',
                    'type' => 'text',
                    'title' => __('Instagram', 'worplex-frame'),
                    'subtitle' => __('Set a profile link for Instagram.', 'worplex-frame'),
                    'desc' => '',
                    'default' => '',
                ),
            )
        );
        $setting_sections[] = $section_settings;

        // footer section start
        $sidebars_array = array('' => esc_html__('Select Sidebar', 'worplex-frame'));
        $worplex_framework_sidebars = isset($worplex_framework_options['worplex-themes-sidebars']) ? $worplex_framework_options['worplex-themes-sidebars'] : '';
        if (is_array($worplex_framework_sidebars) && sizeof($worplex_framework_sidebars) > 0) {
            foreach ($worplex_framework_sidebars as $sidebar) {
                $sidebars_array[sanitize_title($sidebar)] = $sidebar;
            }
        }
        $sidebar_opt_settings = array(
            'title' => __('Layouts', 'worplex-frame'),
            'id' => 'themes-layouts',
            'desc' => __('Set Theme layouts and sidebars list.', 'worplex-frame'),
            'icon' => 'el el-pause',
            'fields' => array(
                array(
                    'id' => 'worplex-themes-sidebars',
                    'type' => 'multi_text',
                    'title' => __('Sidebars', 'worplex-frame'),
                    'subtitle' => __('Create a Dynamic List of Sidebars.', 'worplex-frame'),
                    'desc' => __('These Sidebars will list in Theme Appearance >> Widgets.', 'worplex-frame'),
                    'default' => '',
                ),
                array(
                    'id' => 'worplex-default-layout',
                    'type' => 'image_select',
                    'title' => __('Select Layout', 'worplex-frame'),
                    'subtitle' => '',
                    'desc' => __('Select default Layout for default pages.', 'worplex-frame'),
                    'options' => array(
                        'full' => array(
                            'alt' => __('Full Width', 'worplex-frame'),
                            'img' => ReduxFramework::$_url . 'assets/img/1col.png'
                        ),
                        'right' => array(
                            'alt' => __('Right Sidebar', 'worplex-frame'),
                            'img' => ReduxFramework::$_url . 'assets/img/2cr.png'
                        ),
                        'left' => array(
                            'alt' => __('Left Sidebar', 'worplex-frame'),
                            'img' => ReduxFramework::$_url . 'assets/img/2cl.png'
                        ),
                    ),
                    'default' => ''
                ),
                array(
                    'id' => 'worplex-default-sidebar',
                    'type' => 'select',
                    'title' => __('Select Sidebar', 'worplex-frame'),
                    'required' => array('worplex-default-layout', '!=', 'full'),
                    'subtitle' => '',
                    'desc' => __('Select default Sidebars for default pages.', 'worplex-frame'),
                    'options' => $sidebars_array,
                    'default' => ''
                ),
            )
        );
        
        

        $setting_sections[] = $sidebar_opt_settings;

        $account_settings = array(
            'title' => __('User Account', 'worplex-frame'),
            'id' => 'custom-accon-setting',
            'desc' => __('Account Settings.', 'worplex-frame'),
            'icon' => 'el el-group',
            'fields' => array(
                array(
                    'id' => 'user_login_page',
                    'type' => 'select',
                    'title' => __('User Login Page', 'worplex-frame'),
                    'subtitle' => __('Select the User Login Page.', 'worplex-frame'),
                    'desc' => '',
                    'options' => $all_page,
                    'default' => '',
                ),
                array(
                    'id' => 'user_dashboard_page',
                    'type' => 'select',
                    'title' => __('User Dashboard Page', 'worplex-frame'),
                    'subtitle' => __('Select the User Dashboard Page.', 'worplex-frame'),
                    'desc' => '',
                    'options' => $all_page,
                    'default' => '',
                ),
            )
        );
        $setting_sections[] = $account_settings;

        $job_page_setting = array(
            'title' => __('Jobs', 'worplex-frame'),
            'id' => 'job-page-setting',
            'desc' => __('Job Page Settings.', 'worplex-frame'),
            'icon' => 'el el-cogs',
            'fields' => array(
                array(
                    'id' => 'post_new_job_page',
                    'type' => 'select',
                    'title' => __('Post New Job', 'worplex-frame'),
                    'subtitle' => __('Select the User post New Job Page.', 'worplex-frame'),
                    'desc' => '',
                    'options' => $all_page,
                    'default' => '',
                ),
                array(
                    'id' => 'job_select_page',
                    'type' => 'select',
                    'title' => __('Job Select Page', 'worplex-frame'),
                    'subtitle' => __('Select the Job Search Page.', 'worplex-frame'),
                    'desc' => '',
                    'options' => $all_page,
                    'default' => '',
                ),
                array(
                    'id' => 'job_select_detail_view',
                    'type' => 'select',
                    'title' => __('Job Detail Style', 'worplex-frame'),
                    'subtitle' => __('Select default Job Detail Page Style.', 'worplex-frame'),
                    'desc' => '',
                    'options' => array(
                        'style1' => __('Style 1', 'worplex-frame'),
                        'style2' => __('Style 2', 'worplex-frame'),
                        'style3' => __('Style 3', 'worplex-frame'),
                        'style4' => __('Style 4', 'worplex-frame'),
                    ),
                    'default' => 'style1',
                ),
            )
        );
        $setting_sections[] = $job_page_setting;

        $footer_sidebar_settings = array(
            'title' => __('Custom Js', 'worplex-frame'),
            'id' => 'custom-css-js',
            'desc' => __('Add Custom Js code.', 'worplex-frame'),
            'icon' => 'el el-edit',
            'fields' => array(
                array(
                    'id' => 'javascript_editor',
                    'type' => 'ace_editor',
                    'title' => __('Js Code', 'worplex-frame'),
                    'subtitle' => __('Paste your Js code here.', 'worplex-frame'),
                    'mode' => 'javascript',
                    'theme' => 'chrome',
                    'desc' => __('Possible modes can be found at <a href="http://ace.c9.io" target="_blank">http://ace.c9.io/</a>.', 'worplex-frame'),
                    'default' => "jQuery(document).ready(function(){\n\n});"
                ),
            )
        );
        $setting_sections[] = $footer_sidebar_settings;
        $footer_sidebar_settings = array(
            'title' => __('Api Keys', 'worplex-frame'),
            'id' => 'custom-css-js-keys',
            'desc' => __('Add Custom Js code.', 'worplex-frame'),
            'icon' => 'el el-cogs',
            'fields' => array(
                 array(
                     'id' => 'google_api_keys',
            'type' => 'text',
            'title' => __('Google Api Key', 'worplex-frame'),
            'subtitle' => __('Put Api Key here to show on Any map', 'worplex-frame'),
            'desc' => '',
            'default' => '',
                ),
            )
        );
        $setting_sections[] = $footer_sidebar_settings;

        return $setting_sections;
    }
}