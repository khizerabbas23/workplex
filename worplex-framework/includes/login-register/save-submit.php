<?php

defined('ABSPATH') || exit;

class Worplex_Login_Register_Saving {

    public function __construct() {
        add_action('wp_ajax_worplex_add_form_referrer_field_call', array($this, 'form_add_referrer'));
        add_action('wp_ajax_nopriv_worplex_add_form_referrer_field_call', array($this, 'form_add_referrer'));

        add_action('wp_ajax_worplex_user_login_action', array($this, 'login_ajax_call'));
        add_action('wp_ajax_nopriv_worplex_user_login_action', array($this, 'login_ajax_call'));

        add_action('wp_ajax_worplex_user_register_action', array($this, 'registration_ajax_call'));
        add_action('wp_ajax_nopriv_worplex_user_register_action', array($this, 'registration_ajax_call'));
        
        //Forget Password 
        add_action('wp_ajax_worplex_user_forget_password_action', array($this, 'forget_pass_ajax_call'));
        add_action('wp_ajax_nopriv_worplex_user_forget_password_action', array($this, 'forget_pass_ajax_call'));

        // For register common hook
        add_action('worplex_user_register_with_fields', array($this, 'user_register_with_fields'));
    }

    public function form_add_referrer() {
        
        ob_start();
        wp_nonce_field('worplex-form-nonce', '_nonce');
        $html = ob_get_clean();
        
        $ret_data = array('html' => $html);
        wp_send_json($ret_data);
    }

    public function login_ajax_call() {

        if (!check_ajax_referer('worplex-form-nonce', '_nonce', false)) {
            $ret_data = array('error' => '1', 'msg' => esc_html__('Session token has expired, please reload the page and try again.', 'worplex-frame'));
            wp_send_json($ret_data);
        }
        
        global $worplex_framework_options;

        $account_page_name = isset($worplex_framework_options['user_dashboard_page']) ? $worplex_framework_options['user_dashboard_page'] : '';

        $account_page_id = worplex_get_page_id_from_name($account_page_name);

        $account_page_url = '';
        if ($account_page_id > 0) {
            $account_page_url = get_permalink($account_page_id);
        }

        $username = isset($_POST['user_email']) ? worplex_esc_html($_POST['user_email']) : '';
        $user_pass = isset($_POST['user_pass']) ? worplex_esc_html($_POST['user_pass']) : '';
        $remember_me = isset($_POST['remember_me']) ? true : false;
        
        if ($username == '') {
            $ret_data = array('error' => '1', 'msg' => esc_html__('Username/Email field cannot be empty.', 'worplex-frame'));
            wp_send_json($ret_data);
        }

        if ($user_pass == '') {
            $ret_data = array('error' => '1', 'msg' => esc_html__('Password field cannot be empty.', 'worplex-frame'));
            wp_send_json($ret_data);
        }
        
        $user_name = sanitize_user($username);
        $user = get_user_by('login', $user_name);
        if (!$user && strpos($username, '@')) {
            $user = get_user_by('email', $username);
        }
        
        $secure_cookie = is_ssl();
        if (!$secure_cookie && $user && !force_ssl_admin()) {
            if (get_user_option('use_ssl', $user->ID)) {
                $secure_cookie = true;
                force_ssl_admin(true);
            }
        }
        
        $user_info = array();
        $user_info['user_login'] = sanitize_text_field(trim($username));
        $user_info['user_password'] = trim($user_pass);
        $user_info['remember'] = $remember_me;
        
        $user_signon = wp_signon($user_info, $secure_cookie);
        
        if (is_wp_error($user_signon)) {
            $errors = implode('<br/>', $user_signon->get_error_messages());
            wp_send_json(array(
                'msg' => wp_kses($errors, array('br' => array(), 'strong' => array(), 'p' => array())),
                'error' => '1'
            ));
        }
        
        wp_send_json(array('msg' => esc_html__('Logged in successfully.', 'worplex-frame'), 'error' => '0', 'redirect' => $account_page_url));
    }

    public function registration_ajax_call() {

        if (!check_ajax_referer('worplex-form-nonce', '_nonce', false)) {
            $ret_data = array('error' => '1', 'msg' => esc_html__('Session token has expired, please reload the page and try again.', 'worplex'));
            wp_send_json($ret_data);
        }
        
        global $worplex_framework_options;

        $account_page_name = isset($worplex_framework_options['user_dashboard_page']) ? $worplex_framework_options['user_dashboard_page'] : '';

        $account_page_id = worplex_get_page_id_from_name($account_page_name);

        $account_page_url = '';
        if ($account_page_id > 0) {
            $account_page_url = get_permalink($account_page_id);
        }

        $user_fname = isset($_POST['first_name']) ? worplex_esc_html($_POST['first_name']) : '';
        $user_lname = isset($_POST['last_name']) ? worplex_esc_html($_POST['last_name']) : '';
        $username = isset($_POST['username']) ? worplex_esc_html($_POST['username']) : '';
        $user_email = isset($_POST['user_email']) ? worplex_esc_html($_POST['user_email']) : '';
        $user_pass = isset($_POST['user_pass']) ? worplex_esc_html($_POST['user_pass']) : '';
        $user_cpass = isset($_POST['confirm_pass']) ? worplex_esc_html($_POST['confirm_pass']) : '';

        if (empty($user_fname) || empty($user_lname) || empty($username) || empty($user_email) || empty($user_pass) || empty($user_cpass)) {
            $ret_data = array('error' => '1', 'msg' => esc_html__('Please fill all form fields.', 'worplex'));
            wp_send_json($ret_data);
        }

        if (!filter_var($user_email, FILTER_VALIDATE_EMAIL)) {
            $ret_data = array('error' => '1', 'msg' => esc_html__('Please use a valid email address.', 'worplex'));
            wp_send_json($ret_data);
        }

        if ($user_pass != $user_cpass) {
            $ret_data = array('error' => '1', 'msg' => esc_html__('Confirm password field does not match with the password field.', 'worplex'));
            wp_send_json($ret_data);
        }
        
        if (email_exists($user_email)) {
            $ret_data = array('error' => '1', 'msg' => esc_html__('This email address is already taken. Please select another one.', 'worplex'));
            wp_send_json($ret_data);
        }

        $user_name = $username;
        if (username_exists($user_name)) {
            $user_name = substr($user_email, 0, strpos($user_email, '@'));
            if (username_exists($user_name)) {
                $user_name = $user_name . rand(10000, 99999);
            }
        }
        
        $atts = array(
            'user_name' => $user_name,
            'email' => $user_email,
            'password' => $user_pass,
            'role' => 'subscriber',
            'is_ajax' => true,
            'set_auth' => true,
        );
        do_action('worplex_user_register_with_fields', $atts);

        $ret_data = array(
            'msg' => esc_html__('Successfully registered an account.', 'worplex'),
            'error' => '0',
            'redirect' => $account_page_url,
        );
        wp_send_json($ret_data);
    }
    
    public function user_register_with_fields($atts) {
        $user_name = isset($atts['user_name']) ? $atts['user_name'] : '';
        $user_email = isset($atts['email']) ? $atts['email'] : '';
        $user_pass = isset($atts['password']) ? $atts['password'] : '';
        $user_role = isset($atts['role']) ? $atts['role'] : '';
        $is_ajax = isset($atts['is_ajax']) ? $atts['is_ajax'] : '';

        $create_user = wp_create_user($user_name, $user_pass, $user_email);
        if (is_wp_error($create_user)) {
            $reg_error_msgs = $create_user->errors;
            
            $error_msg_str = '';
            if (!empty($reg_error_msgs)) {
                foreach ($reg_error_msgs as $error_msg) {
                    $error_msg_str = $error_msg[0];
                }
            }

            if ($is_ajax && $error_msg_str != '') {
                $ret_data = array('error' => '1', 'msg' => wp_kses($error_msg_str, array('strong' => array(), 'p' => array())));
                wp_send_json($ret_data);
            }
        } else {
            $user_id = $create_user;
            $update_user_data = array(
                'ID' => $user_id,
                'role' => $user_role
            );

            $firstname = $lastname = '';
            if (isset($atts['first_name'])) {
                $firstname = $atts['first_name'];
            } else if (isset($_POST['first_name'])) {
                $firstname = $_POST['first_name'];
            }
            if (isset($atts['last_name'])) {
                $lastname = $atts['last_name'];
            } else if (isset($_POST['last_name'])) {
                $lastname = $_POST['last_name'];
            }

            $display_name = '';
            if ($firstname != '') {
                $first_name = worplex_esc_html($firstname);
                $update_user_data['first_name'] = $first_name;
                $display_name = $first_name;
            }
            if ($lastname != '') {
                $last_name = worplex_esc_html($lastname);
                $update_user_data['last_name'] = $last_name;
                $display_name = $display_name != '' ? $display_name . ' ' . $last_name : '';
            }
            
            if ($display_name != '') {
                $update_user_data['display_name'] = $display_name;
            }

            wp_update_user($update_user_data);
            //
            
            update_user_option($user_id, 'show_admin_bar_front', false);
            
            if (isset($atts['set_auth']) && $atts['set_auth'] === true) {
                $_user_obj = get_user_by('id', $user_id);
                wp_set_current_user($_user_obj->ID, $_user_obj->user_login);
                wp_set_auth_cookie($user_id);
            }
        }
    }
    public function forget_pass_ajax_call() {

    if (!check_ajax_referer('worplex-form-nonce', '_nonce', false)) {
        $ret_data = array('error' => '1', 'msg' => esc_html__('Session token has expired, please reload the page and try again.', 'worplex'));
        wp_send_json($ret_data);
    }
    
    global $worplex_framework_options;

    $account_page_name = isset($worplex_framework_options['user_dashboard_page']) ? $worplex_framework_options['user_dashboard_page'] : '';

    $account_page_id = worplex_get_page_id_from_name($account_page_name);

    $account_page_url = '';
    if ($account_page_id > 0) {
        $account_page_url = get_permalink($account_page_id);
    }
    $user_email = isset($_POST['user_email']) ? worplex_esc_html($_POST['user_email']) : '';
   
   
    if (email_exists($user_email)) {
        $ret_data = array('error' => '1', 'msg' => esc_html__('This email address is already taken. Please select another one.', 'worplex'));
        wp_send_json($ret_data);
    }

    $user_name = $username;
    if (username_exists($user_name)) {
        $user_name = substr($user_email, 0, strpos($user_email, '@'));
        if (username_exists($user_name)) {
            $user_name = $user_name . rand(10000, 99999);
        }
    }
    
    $atts = array(
        'email' => $user_email,
    );
    
    // Send email to the user
    $subject = 'Password Reset';
    $message = 'Dear user, your password reset request has been received.';
    $headers = array('Content-Type: text/html; charset=UTF-8');
    $message .= admin_url( '/' ) . "\r\n\r\n";
    $message .= '<' . admin_url("wp-login.php?action=rp&key=$key&login=" . rawurlencode($user_login), 'login') . ">\r\n";

    wp_mail($user_email, $subject, $message, $headers);

    $ret_data = array(
        'msg' => esc_html__('Successfully Email Sent To You', 'worplex'),
        'error' => '0',
        'redirect' => $account_page_url,
    );
    wp_send_json($ret_data);
}
    
}

new Worplex_Login_Register_Saving;
