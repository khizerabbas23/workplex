<?php

/**
 * Plugin Name:       Worplex Framework
 * Plugin URI:        https://wordpress.org
 * Description:       Framework plugin for worplex theme.
 * Version:           1.0
 * Author:            WordPress
 * Author URI:        https://wordpress.org
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       worplex-frame
 * Domain Path:       /languages
 */

defined('ABSPATH') || exit;

if (!defined('WORPLEX_PLUGIN_FILE')) {
    define('WORPLEX_PLUGIN_FILE', __FILE__);
}

function WORPLEX__activate_plugin() {
    require_once plugin_dir_path(__FILE__) . 'includes/classes/class-activator.php';
    $activate = new WORPLEX_Plugin_Activator();
}

register_activation_hook(__FILE__, 'WORPLEX__activate_plugin');

function worplex_framework_get_url($path = '') {
    return plugin_dir_url(__FILE__) . $path;
}

function worplex_framework_get_path($path = '') {
    return plugin_dir_path(__FILE__) . $path;
}

include_once dirname(WORPLEX_PLUGIN_FILE) . '/includes/class-plugin.php';