<?php

defined('ABSPATH') || exit;

class Worplex_Dashboard_Job_Save_Class {
    
    public function __construct() {
        add_action('wp_ajax_worplex_dash_job_post_call', array($this, 'job_post_save'));
        add_action('wp_ajax_worplex_dash_empjob_remove_call', array($this, 'job_remove'));
    }

    public function job_remove() {
        global $current_user;
        $user_id = $current_user->ID;

        $job_id = isset($_POST['id']) ? $_POST['id'] : '';

        $is_employer_job = worplex_is_employer_job($job_id, $user_id);

        if (!$is_employer_job) {
            $ret_data = array('error' => '1', 'msg' => esc_html__('You cannot remove this job.', 'worplex-frame'));
            wp_send_json($ret_data);
        }

        wp_delete_post($job_id, true);

        $ret_data = array('error' => '0', 'msg' => esc_html__('Job deleted.', 'worplex-frame'));
        wp_send_json($ret_data);
    }

    public function job_post_save() {
        global $current_user;
        $user_id = $current_user->ID;

        $updatin_job = false;

        $job_id = isset($_POST['job_id']) ? $_POST['job_id'] : '';
        $job_title = isset($_POST['job_title']) ? $_POST['job_title'] : '';

        $desc = $_POST['job_content'];
        $desc = trim(apply_filters('the_content', $desc));

        $employer_id = worplex_user_employer_id($user_id);
        if (!$employer_id) {
            $ret_data = array('error' => '1', 'msg' => esc_html__('You are not an Employer/Company.', 'worplex-frame'));
            wp_send_json($ret_data);
        }

        if ($job_id > 0 && get_post_type($job_id) == 'jobs') {
            $job_upd = true;
        }
        if (isset($job_upd)) {
            $updatin_job = worplex_is_employer_job($job_id, $user_id);
        }

        if ($job_title == '') {
            $ret_data = array('error' => '1', 'msg' => esc_html__('Please fill the job title field first.', 'worplex-frame'));
            wp_send_json($ret_data);
        }

        if (!$updatin_job) {
            $my_post = array(
                'post_title' => worplex_esc_html($job_title),
                'post_content' => worplex_esc_wp_editor($desc),
                'post_type' => 'jobs',
                'post_status' => 'publish',
                'post_author' => $user_id,
            );
            $job_id = wp_insert_post($my_post);
        } else {
            $upd_post = array(
                'ID' => $job_id,
                'post_title' => worplex_esc_html($job_title),
                'post_content' => worplex_esc_wp_editor($desc),
            );
            wp_update_post($upd_post);
        }

        if (isset($_POST['job_cat']) && $_POST['job_cat'] > 0) {
            $cats_to_save = array($_POST['job_cat']);
            wp_set_post_terms($job_id, $cats_to_save, 'job_category', false);
        }

        if (isset($_POST['job_skills']) && $_POST['job_skills'] != '') {
            $job_skills = $_POST['job_skills'];
            $job_skills = str_replace(array(', '), array(','), $job_skills);
            $job_skills = explode(',', $job_skills);
            wp_set_post_terms($job_id, $job_skills, 'job_skill', false);
        }

        $ret_data = array('error' => '0', 'msg' => esc_html__('Job posted successfully.', 'worplex-frame'));
        wp_send_json($ret_data);
    }

}
new Worplex_Dashboard_Job_Save_Class;