<?php

defined('ABSPATH') || exit;

class Worplex_Dashboard_Data_Save_Class {
    
    public function __construct() {
        add_action('wp_ajax_worplex_user_dashb_change_pass_call', array($this, 'change_password'));
        add_action('wp_ajax_worplex_user_dashboard_profile_save_call', array($this, 'user_profile_saving'));
        add_action('wp_ajax_worplex_employer_dashboard_profile_save_call', array($this, 'employer_profile_saving'));

        add_action('wp_ajax_worplex_user_dashboard_social_save_call', array($this, 'user_general_saving'));
        add_action('wp_ajax_worplex_user_dashboard_location_save_call', array($this, 'user_general_saving'));
    }

    public function change_password() {
        global $current_user;

        $old_pass = $_POST['old_pass'];
        $new_pass = $_POST['new_pass'];
        $conf_pass = $_POST['conf_pass'];

        if ($old_pass == '' || $new_pass == '' || $conf_pass == '') {
            $ret_data = array('error' => '1', 'msg' => esc_html__('Please fill all mandatory fields.', 'worplex-frame'));
            wp_send_json($ret_data);
        }
        if (!wp_check_password($old_pass, $current_user->data->user_pass, $current_user->ID)) {
            $ret_data = array('error' => '1', 'msg' => esc_html__('Your old password is not correct.', 'worplex-frame'));
            wp_send_json($ret_data);
        }
        
        if ($new_pass != $conf_pass) {
            $ret_data = array('error' => '1', 'msg' => esc_html__('Password does not match with confirm password.', 'worplex-frame'));
            wp_send_json($ret_data);
        }

        $user_def_array = array('ID' => $current_user->ID);
        $user_def_array['user_pass'] = $new_pass;
        wp_update_user($user_def_array);

        $ret_data = array('error' => '0', 'msg' => esc_html__('Password changed successfully.', 'worplex-frame'));
        wp_send_json($ret_data);
    }

    public static function upload_img_logo($upload_file, $user_id, $member_id) {

        if (isset($upload_file['tmp_name']) && $upload_file['tmp_name'] != '') {
            $file_name = $upload_file['name'];
            $filname_exp = explode('.', $file_name);
            $file_ext = end($filname_exp);
    
            if ($file_ext == 'jpg' || $file_ext == 'png') {
                //
            } else {
                return false;
            }
    
            $max_attachment_size = 10400;
                
            // Get the path to the upload directory.
            $wp_upload_dir = wp_upload_dir();
    
            $file_size = isset($upload_file['size']) && $upload_file['size'] > 0 ? $upload_file['size'] : 1;
            $size_as_kb = round($file_size / 1024);
    
            if ($size_as_kb > $max_attachment_size) {
                $ret_data = array('error' => '1', 'msg' => esc_html__('Error: Image size is too big to upload. Please use optimized image only.', 'worplex-frame'));
                wp_send_json($ret_data);
            }
    
            //
            $emp_post = get_post($member_id);
            if (isset($emp_post->post_title) && $emp_post->post_title != '') {
    
                $upload_file['name'] = sanitize_title($emp_post->post_title) . '-' . $member_id . '.' . $file_ext;
            }
    
            require_once ABSPATH . 'wp-admin/includes/image.php';
            require_once ABSPATH . 'wp-admin/includes/file.php';
            require_once ABSPATH . 'wp-admin/includes/media.php';
    
            $allowed_image_types = array();
            $allowed_image_types['jpg|jpeg|jpe'] = 'image/jpeg';
            $allowed_image_types['png'] = 'image/png';
    
            $status_upload = wp_handle_upload($upload_file, array('test_form' => false, 'mimes' => $allowed_image_types));
    
            if (empty($status_upload['error'])) {
    
                $file_url = isset($status_upload['url']) ? $status_upload['url'] : '';
    
                $upload_file_path = $wp_upload_dir['path'] . '/' . basename($file_url);
    
                // Check the type of file. We'll use this as the 'post_mime_type'.
                $filetype = wp_check_filetype(basename($file_url), null);
    
                // Prepare an array of post data for the attachment.
                $attachment = array(
                    'guid' => $wp_upload_dir['url'] . '/' . basename($upload_file_path),
                    'post_mime_type' => $filetype['type'],
                    'post_title' => preg_replace('/\.[^.]+$/', '', ($upload_file['name'])),
                    'post_author' => $user_id,
                    'post_status' => 'inherit'
                );
    
                // Insert the attachment.
                $attach_id = wp_insert_attachment($attachment, $upload_file_path, $member_id);
    
                // Generate the metadata for the attachment, and update the database record.
                $attach_data = wp_generate_attachment_metadata($attach_id, $upload_file_path);
                wp_update_attachment_metadata($attach_id, $attach_data);
    
                set_post_thumbnail($member_id, $attach_id);
            }
        }
    }

    public function user_profile_saving() {
        global $current_user;

        $user_id = $current_user->ID;
        $candidate_id = worplex_user_candidate_id($user_id);

        $full_name = $_POST['user_full_name'];

        if ($full_name == '') {
            $ret_data = array('error' => '1', 'msg' => esc_html__('Please fill mandatory fields.', 'worplex-frame'));
            wp_send_json($ret_data);
        }

        $desc = $_POST['info_content'];
        $desc = trim(apply_filters('the_content', $desc));

        $to_redirect = '';
        if (!$candidate_id) {
            $to_redirect = 'same';
            $my_post = array(
                'post_title' => $full_name,
                'post_content' => $desc,
                'post_type' => 'candidates',
                'post_status' => 'publish',
                'post_author' => $user_id,
            );
            $candidate_id = wp_insert_post($my_post);
            update_user_meta($user_id, 'user_account_post_type', 'candidate');
        } else {
            $upd_post = array(
                'ID' => $candidate_id,
                'post_title' => $full_name,
                'post_content' => $desc,
            );
            wp_update_post($upd_post);
        }

        if (isset($_POST['sec_category']) && $_POST['sec_category'] > 0) {
            $cats_to_save = array($_POST['sec_category']);
            wp_set_post_terms($candidate_id, $cats_to_save, 'candidate_cat', false);
        }

        if (isset($_POST['user_skills']) && $_POST['user_skills'] != '') {
            $user_skills = $_POST['user_skills'];
            $user_skills = str_replace(array(', '), array(','), $user_skills);
            $user_skills = explode(',', $user_skills);
            wp_set_post_terms($candidate_id, $user_skills, 'candidate_skill', false);
        }

        $upload_file = isset($_FILES['user_profile_pic']) ? $_FILES['user_profile_pic'] : '';
        self::upload_img_logo($upload_file, $user_id, $candidate_id);

        $ret_data = array('error' => '0', 'redirect' => $to_redirect, 'msg' => esc_html__('Profile changes saved successfully.', 'worplex-frame'));
        wp_send_json($ret_data);
    }

    public function employer_profile_saving() {
        global $current_user;

        $user_id = $current_user->ID;
        $employer_id = worplex_user_employer_id($user_id);

        $full_name = worplex_esc_html($_POST['company_name']);

        if ($full_name == '') {
            $ret_data = array('error' => '1', 'msg' => esc_html__('Please fill mandatory fields.', 'worplex-frame'));
            wp_send_json($ret_data);
        }

        $desc = $_POST['info_content'];
        $desc = trim(apply_filters('the_content', $desc));

        //
        $upd_post = array(
            'ID' => $employer_id,
            'post_title' => $full_name,
            'post_content' => $desc,
        );
        wp_update_post($upd_post);

        $website_url = isset($_POST['web_url']) ? $_POST['web_url'] : '';
        $user_upd = array(
            'ID' => $user_id,
            'display_name' => $full_name,
            'user_url' => $website_url
        );
        wp_update_user($user_upd);

        if (isset($_POST['employer_cat']) && $_POST['employer_cat'] > 0) {
            $cats_to_save = array($_POST['employer_cat']);
            wp_set_post_terms($employer_id, $cats_to_save, 'employer_cat', false);
        }

        $upload_file = isset($_FILES['user_profile_pic']) ? $_FILES['user_profile_pic'] : '';
        self::upload_img_logo($upload_file, $user_id, $employer_id);

        $ret_data = array('error' => '0', 'redirect' => '', 'msg' => esc_html__('Profile changes saved successfully.', 'worplex-frame'));
        wp_send_json($ret_data);
    }

    public function user_general_saving() {
        global $current_user;

        $user_id = $current_user->ID;

        $member_id = 0;
        $candidate_id = worplex_user_candidate_id($user_id);
        $employer_id = worplex_user_employer_id($user_id);
        if ($candidate_id) {
            $member_id = $candidate_id;
            $display_name = get_the_title($candidate_id);
        } else if ($employer_id) {
            $member_id = $employer_id;
            $display_name = get_the_title($employer_id);
        }

        if ($member_id > 0) {
            $upd_post = array(
                'ID' => $member_id,
                'post_title' => $display_name,
            );
            wp_update_post($upd_post);

            $ret_data = array('error' => '0', 'redirect' => '', 'msg' => esc_html__('Changes saved successfully.', 'worplex-frame'));
            wp_send_json($ret_data);
        }

        $ret_data = array('error' => '1', 'redirect' => '', 'msg' => esc_html__('There is some error while updating profile settings.', 'worplex-frame'));
        wp_send_json($ret_data);
    }

}
new Worplex_Dashboard_Data_Save_Class;