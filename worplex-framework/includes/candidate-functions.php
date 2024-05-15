<?php

function worplex_user_candidate_id($user_id) {
    global $wpdb;
    
    if (worplex_user_account_type($user_id) != 'candidate') {
        return false;
    }
    
    $post_query = "SELECT posts.ID FROM $wpdb->posts AS posts";
    $post_query .= " WHERE posts.post_type='candidates' AND posts.post_author={$user_id}";
    $post_query .= " ORDER BY posts.ID DESC LIMIT 1";
    $get_db_res = $wpdb->get_col($post_query);
    
    if (!empty($get_db_res) && isset($get_db_res[0])) {
        return $get_db_res[0];
    }
}

function worplex_candidate_user_id($candidate_id) {
    global $wpdb;
    
    $post_query = "SELECT posts.post_author FROM $wpdb->posts AS posts";
    $post_query .= " WHERE posts.post_type='candidates' AND posts.ID={$candidate_id}";
    $post_query .= " LIMIT 1";
    $get_db_res = $wpdb->get_col($post_query);
    
    if (!empty($get_db_res) && isset($get_db_res[0])) {
        return $get_db_res[0];
    }
}

function worplex_candidate_account_menu_items() {
    $items = [
        'dashboard' => array(
            'icon' => 'lni lni-dashboard me-2',
            'title' => esc_html__('Dashboard', 'worplex-frame'),
        ),
        'my-resume' => array(
            'icon' => 'lni lni-add-files me-2',
            'title' => esc_html__('My Resume', 'worplex-frame'),
        ),
        'applied-jobs' => array(
            'icon' => 'lni lni-briefcase me-2',
            'title' => esc_html__('Applied jobs', 'worplex-frame'),
        ),
        'saved-jobs' => array(
            'icon' => 'lni lni-bookmark me-2',
            'title' => esc_html__('Bookmark Jobs', 'worplex-frame'),
        ),
        'job-alerts' => array(
            'icon' => 'ti-bell me-2',
            'title' => esc_html__('Job Alerts', 'worplex-frame'),
        ),
        'packages' => array(
            'icon' => 'lni lni-mastercard me-2',
            'title' => esc_html__('Packages', 'worplex-frame'),
        ),
    ];
    
    return $items;
}

// For Favrouite Icon Zubair

add_action('wp_ajax_worplex_job_like_favourite_ajax', 'worplex_job_like_favourite_ajax');
 add_action('wp_ajax_nopriv_worplex_job_like_favourite_ajax', 'worplex_job_like_favourite_ajax');
function worplex_job_like_favourite_ajax() {
    global $current_user;
    $user_id = $current_user->ID;
    $post_id = $_POST['post_id'];
    $fav_jobs = get_user_meta($user_id, 'fav_jobs_list', true);
    $fav_jobs = !empty($fav_jobs) ? $fav_jobs : array();
    if (!in_array($post_id, $fav_jobs)) {
        $fav_jobs[] = $post_id;
    }
    update_user_meta($user_id, 'fav_jobs_list', $fav_jobs);
    $data = array('success' => '1');
    wp_send_json_success($data);
    wp_die();
}

// Removing postEmployer dashboard by zubair

add_action('wp_ajax_worplex_delete_post_emply', 'worplex_delete_post_emply');
add_action('wp_ajax_nopriv_worplex_delete_post_emply', 'worplex_delete_post_emply');
function worplex_delete_post_emply() {
    if (isset($_POST['post_id'])) {
        $post_id = intval($_POST['post_id']);
        global $current_user;
        $user_id = $current_user->ID;
        
        // Remove the post from the user's favorite list
        $faver_jobs = get_user_meta($user_id, 'fav_jobs_list', true);
        if (($key = array_search($post_id, $faver_jobs)) !== false) {
            unset($faver_jobs[$key]);
        }
        update_user_meta($user_id, 'fav_jobs_list', $faver_jobs);
    }
    wp_die();
}


add_action('wp_ajax_worplex_candidate_like_favourite_ajax', 'worplex_candidate_like_favourite_ajax');
add_action('wp_ajax_nopriv_worplex_candidate_like_favourite_ajax', 'worplex_candidate_like_favourite_ajax');
function worplex_candidate_like_favourite_ajax() {
    global $current_user;
    $user_id = $current_user->ID;
    $post_id = $_POST['post_id'];

    $faver_jobs = get_user_meta($user_id, 'fav_candidate_list', true);
    $faver_jobs = !empty($faver_jobs) ? $faver_jobs : array();
    if (!in_array($post_id, $faver_jobs)) {
        $faver_jobs[] = $post_id;
    }
    update_user_meta($user_id, 'fav_candidate_list', $faver_jobs);

    $data = array(
        'success' => '1',
        'total_favorites' => count($faver_jobs)
    );

    wp_send_json_success($data);
    wp_die();
}



//candidate function removing jobs
add_action('wp_ajax_worplex_remove_from_favorites_ajax', 'worplex_remove_from_favorites_ajax');
add_action('wp_ajax_nopriv_worplex_remove_from_favorites_ajax', 'worplex_remove_from_favorites_ajax');
function worplex_remove_from_favorites_ajax() {
    global $current_user;
    $user_id = $current_user->ID;
    $post_id = $_POST['post_id'];
    
    // Retrieve the current list of favorite post IDs
    $faver_jobs = get_user_meta($user_id, 'fav_candidate_list', true);
    $faver_jobs = !empty($faver_jobs) ? $faver_jobs : array();
    
    // Remove the post ID from the list
    $updated_faver_jobs = array_diff($faver_jobs, array($post_id));
    
    // Update the user meta with the updated list
    update_user_meta($user_id, 'fav_candidate_list', $updated_faver_jobs);
    
    $data = array('success' => '1');
    wp_send_json_success($data);
    wp_die();
}




add_action('wp_ajax_worplex_filter_category_post_ajax', 'worplex_filter_category_post_ajax');

function worplex_filter_category_post_ajax() {


    
    // global $category;
$category = get_the_term();
// $categoryid = $category->ID;
$post = the_post($category->ID);

    update_user_meta($user_id, 'fav_category_list', $fav_jobs);

    $data = array('success' => '1');
    wp_send_json_success($data);
  wp_die();
}





// function create_user_cpt() {
//     $args = array(
//         'public' => true,
//         'label'  => 'Users',
//         // ... other arguments ...
//     );

//     register_post_type( 'user', $args );
// }
// add_action( 'init', 'create_user_cpt' );



// $user_data = array(
//     'post_title'   => 'John Doe',
//     'post_type'    => 'user',
// );

// $user_id = wp_insert_post( $user_data );
