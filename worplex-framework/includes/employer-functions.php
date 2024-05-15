<?php

function worplex_user_employer_id($user_id) {
    global $wpdb;
    
    if (worplex_user_account_type($user_id) != 'employer') {
        return false;
    }
    
    $post_query = "SELECT posts.ID FROM $wpdb->posts AS posts";
    $post_query .= " WHERE posts.post_type='employer' AND posts.post_author={$user_id}";
    $post_query .= " ORDER BY posts.ID DESC LIMIT 1";
    $get_db_res = $wpdb->get_col($post_query);
    
    if (!empty($get_db_res) && isset($get_db_res[0])) {
        return $get_db_res[0];
    }
}

function worplex_employer_user_id($employer_id) {
    global $wpdb;
    
    $post_query = "SELECT posts.post_author FROM $wpdb->posts AS posts";
    $post_query .= " WHERE posts.post_type='employer' AND posts.ID={$employer_id}";
    $post_query .= " LIMIT 1";
    $get_db_res = $wpdb->get_col($post_query);
    
    if (!empty($get_db_res) && isset($get_db_res[0])) {
        return $get_db_res[0];
    }
}

function worplex_employer_account_menu_items() {
    $items = [
        'dashboard' => array(
            'icon' => 'lni lni-dashboard me-2',
            'title' => esc_html__('Dashboard', 'worplex-frame'),
        ),
        'post-job' => array(
            'icon' => 'lni lni-files me-2',
            'title' => esc_html__('Post New Job', 'worplex-frame'),
        ),
        'manage-jobs' => array(
            'icon' => 'lni lni-add-files me-2',
            'title' => esc_html__('Manage Jobs', 'worplex-frame'),
        ),
        'manage-applicants' => array(
            'icon' => 'lni lni-briefcase me-2',
            'title' => esc_html__('Manage Applicants', 'worplex-frame'),
        ),
        'saved-resumes' => array(
            'icon' => 'lni lni-bookmark me-2',
            'title' => esc_html__('Bookmark Resumes', 'worplex-frame'),
        ),
        'packages' => array(
            'icon' => 'lni lni-mastercard me-2',
            'title' => esc_html__('Packages', 'worplex-frame'),
        ),
    ];
    
    return $items;
}

function worplex_job_types_list() {
    $list = array(
        'full_time' => array(
            'title' => esc_html__('Full Time', 'worplex-frame'),
            'color' => '#17b67c',
            'bg_color' => 'rgba(40, 182, 97,0.11)'
        ),
        'part_time' => array(
            'title' => esc_html__('Part Time', 'worplex-frame'),
            'color' => '#ff9b20',
            'bg_color' => '#fff8ec'
        ),
        'internship' => array(
            'title' => esc_html__('Internship', 'worplex-frame'),
            'color' => '#ea2b33',
            'bg_color' => '#ffeced'
        ),
        'contract' => array(
            'title' => esc_html__('Contract', 'worplex-frame'),
            'color' => '#7460ee',
            'bg_color' => '#eeebff'
        ),
        'freelancing' => array(
            'title' => esc_html__('Freelancing', 'worplex-frame'),
            'color' => '#ff9b20',
            'bg_color' => '#fff8ec'
        )
    );
    return $list;
}

function worplex_job_type_ret_str($job_type) {
    if ($job_type == '') {
        $job_type = 'full_time';
    }
    $all_types = worplex_job_types_list();
    $type_ar = isset($all_types[$job_type]) ? $all_types[$job_type] : array();

    return $type_ar;
}

function worplex_is_employer_job($job_id, $user_id) {
    global $wpdb;
    
    $post_query = "SELECT posts.ID FROM $wpdb->posts AS posts";
    $post_query .= " WHERE posts.post_type='jobs' AND posts.ID='{$job_id}' AND posts.post_author='{$user_id}'";
    $post_query .= " ORDER BY posts.ID DESC LIMIT 1";
    $get_db_res = $wpdb->get_col($post_query);
    
    if (!empty($get_db_res) && isset($get_db_res[0])) {
        return $get_db_res[0];
    }
}
