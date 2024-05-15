<?php

add_filter('worplex_header_mobile_right_btns_html', function($html) {
    global $worplex_framework_options;

    $account_page_name = isset($worplex_framework_options['user_dashboard_page']) ? $worplex_framework_options['user_dashboard_page'] : '';

    $account_page_id = worplex_get_page_id_from_name($account_page_name);

    if ($account_page_id > 0 && is_page()) {
        global $post;
        if ($post->ID == $account_page_id) {
            ob_start();
            ?>
            <li>
                <a href="<?php echo worplex_account_logout_url() ?>" class="crs_yuo12 w-auto text-dark gray">
                    <span class="embos_45"><i class="lni lni-power-switch me-1 me-1"></i>Logout</span>
                </a>
            </li>
            <?php
            $html = ob_get_clean();
        }
    }
    return $html;
});

add_filter('worplex_header_right_btns_html', function($html) {
    global $worplex_framework_options;

    $account_page_name = isset($worplex_framework_options['user_dashboard_page']) ? $worplex_framework_options['user_dashboard_page'] : '';

    $account_page_id = worplex_get_page_id_from_name($account_page_name);

    if ($account_page_id > 0 && is_page()) {
        global $post;
        if ($post->ID == $account_page_id) {
            ob_start();
            ?>
            <li class="add-listing">
                <a href="<?php echo worplex_account_logout_url() ?>">
                    <i class="lni lni-power-switch me-1"></i> Logout
                </a>
            </li>
            <?php
            $html = ob_get_clean();
        }
    }
    return $html;
});

add_action('wp', 'worplex_account_logout_call');

function worplex_account_logout_call() {
    if (isset($_GET['account_action']) && $_GET['account_action'] == 'logout' && isset($_GET['_nonce'])) {
        if (!wp_verify_nonce(sanitize_key(wp_unslash($_GET['_nonce'])), 'user-account-logout')) { // WPCS: input var ok, CSRF ok.
            //wp_die(esc_html__('Action failed. Please refresh the page and retry.', 'worplex'));
        }
        global $worplex_framework_options;

        $login_page_name = isset($worplex_framework_options['user_login_page']) ? $worplex_framework_options['user_login_page'] : '';

        $login_page_id = worplex_get_page_id_from_name($login_page_name);
        
        $login_page_url = home_url('/');
        if ($login_page_id > 0) {
            $login_page_url = get_permalink($login_page_id);
        }
        //
        wp_destroy_current_session();
        wp_clear_auth_cookie();
        wp_set_current_user(0);
        
        wp_safe_redirect($login_page_url);
        exit();
    }
}

function worplex_account_logout_url() {
    $url = esc_url(wp_nonce_url(add_query_arg(array('account_action' => 'logout'), home_url('/')), 'user-account-logout', '_nonce'));
    return $url;
}

add_action('wp', function() {
    global $worplex_framework_options;

    //
    $login_page_name = isset($worplex_framework_options['user_login_page']) ? $worplex_framework_options['user_login_page'] : '';

    $login_page_id = worplex_get_page_id_from_name($login_page_name);
    //

    $account_page_name = isset($worplex_framework_options['user_dashboard_page']) ? $worplex_framework_options['user_dashboard_page'] : '';

    $account_page_id = worplex_get_page_id_from_name($account_page_name);

    $account_page_url = home_url('/');
    if ($account_page_id > 0) {
        $account_page_url = get_permalink($account_page_id);
    }

    if (is_user_logged_in() && ($login_page_id > 0 && is_page($login_page_id))) {
        wp_safe_redirect($account_page_url);
        exit();
    }

    //
    $login_page_url = home_url('/');
    if ($login_page_id > 0) {
        $login_page_url = get_permalink($login_page_id);
    }
    if (!is_user_logged_in() && ($account_page_id > 0 && is_page($account_page_id))) {
        wp_safe_redirect($login_page_url);
        exit();
    }
});

function worplex_user_account_type($user_id) {
    $user_type = get_user_meta($user_id, 'user_account_post_type', true);
    
    return $user_type;
}

function worplex_general_account_menu_items() {
    $items = [
        'profile' => array(
            'icon' => 'lni lni-user me-2',
            'title' => esc_html__('My Profile', 'worplex-frame'),
        ),
        'change_password' => array(
            'icon' => 'lni lni-lock-alt me-2',
            'title' => esc_html__('Change Password', 'worplex-frame'),
        ),
    ];
    
    return $items;
}
