<?php

include_once WORPLEX_ABSPATH . 'includes/dashboard/data-submit.php';
include_once WORPLEX_ABSPATH . 'includes/dashboard/job-submit.php';
include_once WORPLEX_ABSPATH . 'includes/dashboard/package-functions.php';
include_once WORPLEX_ABSPATH . 'includes/dashboard/job-apply-functions.php';

include_once WORPLEX_ABSPATH . 'includes/dashboard/change-password.php';

include_once WORPLEX_ABSPATH . 'includes/dashboard/candidate/dashboard.php';
include_once WORPLEX_ABSPATH . 'includes/dashboard/candidate/applied-jobs.php';
include_once WORPLEX_ABSPATH . 'includes/dashboard/candidate/my-resume.php';
include_once WORPLEX_ABSPATH . 'includes/dashboard/candidate/saved-jobs.php';
include_once WORPLEX_ABSPATH . 'includes/dashboard/candidate/job-alerts.php';
include_once WORPLEX_ABSPATH . 'includes/dashboard/candidate/packages.php';
include_once WORPLEX_ABSPATH . 'includes/dashboard/employer/dashboard.php';
include_once WORPLEX_ABSPATH . 'includes/dashboard/employer/post-new-job.php';
include_once WORPLEX_ABSPATH . 'includes/dashboard/employer/manage-jobs.php';
include_once WORPLEX_ABSPATH . 'includes/dashboard/employer/manage-applicants.php';
include_once WORPLEX_ABSPATH . 'includes/dashboard/employer/saved-resumes.php';
include_once WORPLEX_ABSPATH . 'includes/dashboard/employer/packages.php';

add_action('wp_ajax_worplex_user_account_type_selection_call', 'worplex_user_account_type_selection_call');

function worplex_user_account_type_selection_call() {
    global $worplex_framework_options, $current_user;

    $account_page_name = isset($worplex_framework_options['user_dashboard_page']) ? $worplex_framework_options['user_dashboard_page'] : '';

    $account_page_id = worplex_get_page_id_from_name($account_page_name);

    $account_page_url = home_url('/');
    if ($account_page_id > 0) {
        $account_page_url = get_permalink($account_page_id);
    }

    $user_id = $current_user->ID;

    $display_name = $current_user->display_name;

    $user_type = $_POST['acc_type'];
    if ($user_type == 'employer') {
        $acc_type = 'employer';
    } else {
        $acc_type = 'candidate';
    }

    update_user_meta($user_id, 'user_account_post_type', $acc_type);

    if ($user_type == 'employer') {
        $employer_id = worplex_user_employer_id($user_id);
        if (!$employer_id) {
            $my_post = array(
                'post_title' => $display_name,
                'post_type' => 'employer',
                'post_status' => 'publish',
                'post_author' => $user_id,
            );
            wp_insert_post($my_post);
        }
    } else {
        $candidate_id = worplex_user_candidate_id($user_id);
        if (!$candidate_id) {
            $my_post = array(
                'post_title' => $display_name,
                'post_type' => 'candidates',
                'post_status' => 'publish',
                'post_author' => $user_id,
            );
            wp_insert_post($my_post);
        }
    }
    wp_send_json(array('url' => $account_page_url));
}

add_filter('worplex_dashboard_candidate_profile_html', 'worplex_dashb_general_profile');
add_filter('worplex_dashboard_employer_profile_html', 'worplex_dashb_general_profile');

function worplex_dashb_general_profile($html = '') {
    global $current_user, $worplex_countries_list;

    $rand_num = rand(1000000, 9999999);

    $user_id = $current_user->ID;
    $display_name = $current_user->display_name;
    
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

    ob_start();

    if (!$candidate_id && !$employer_id) {
        ?>
        <div class="dashboard-widg-bar d-block">
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12">
                    <div class="_dashboard_content bg-white rounded mb-4">
                        <div class="_dashboard_content_header br-bottom py-3 px-3">
                            <div class="choos-acctype-maincon">
                                <div class="acctype-hding-con"><strong>Choose your account type</strong></div>
                                <div class="acctype-boxes-con">
                                    <div class="acctype-box-itm candidate-box-item">
                                        <div><i class="worplex-fa worplex-faicon-user"></i></div>
                                        <div>
                                            <strong>Candidate</strong>
                                            <span>(Browse Jobs)</span>
                                        </div>
                                    </div>
                                    <div class="acctype-box-itm employer-box-item">
                                        <div><i class="worplex-fa worplex-faicon-briefcase"></i></div>
                                        <div>
                                            <strong>Employer</strong>
                                            <span>(Hire Talent)</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
    ?>
    <div class="dashboard-widg-bar d-block">
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12">
                <div class="_dashboard_content bg-white rounded mb-4">
                    <div class="_dashboard_content_header br-bottom py-3 px-3">
                        <div class="_dashboard__header_flex">
                            <h4 class="mb-0 ft-medium fs-md"><i class="worplex-fa worplex-faicon-user me-1 theme-cl fs-sm"></i>My Account</h4>	
                        </div>
                    </div>
                    
                    <div class="_dashboard_content_body py-3 px-3">
                        <form method="post" class="worplex-dashb-form">
                            <div class="row">
                                <?php
                                if ($employer_id) {
                                    $desc = '';
                                    $profile_img_url = '';
                                    if ($employer_id) {
                                        $employer_obj = get_post($employer_id);
                                        $desc = isset($employer_obj->post_content) ? $employer_obj->post_content : '';
                                        if ($desc != '') {
                                            $desc = trim(apply_filters('the_content', $desc));
                                        }

                                        $img_thumb_id = get_post_thumbnail_id($employer_id);
                                        $profile_img_url = wp_get_attachment_image_url($img_thumb_id, 'medium');
                                    }
                                    $job_title = get_post_meta($employer_id, 'worplex_field_job_title', true);
                                    $phone_number = get_post_meta($employer_id, 'worplex_field_user_phone', true);
                                    $found_date = get_post_meta($employer_id, 'worplex_field_founded_date', true);
                                    $public_info = get_post_meta($employer_id, 'worplex_field_public_info', true);
                                    ?>
                                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12">
                                        <div id="logofile-name-container" class="custom-file avater_uploads">
                                            <input id="logofile-custom-input" type="file" name="user_profile_pic" onchange="worplex_dashb_image_file_change(event)" accept="image/png, image/jpg, image/jpeg" class="custom-file-input">
                                            <label class="custom-file-label logo-img-con" for="logofile-custom-input">
                                                <img src="<?php echo ($profile_img_url) ?>" alt=""<?php echo ($profile_img_url != '' ? '' : ' style="display: none;"') ?>>
                                                <i class="worplex-fa worplex-faicon-user"<?php echo ($profile_img_url != '' ? ' style="display: none;"' : '') ?>></i>
                                            </label>
                                        </div>
                                    </div>
                                    
                                    <div class="col-xl-9 col-lg-9 col-md-9 col-sm-12">
                                        <div class="row">
                                            <div class="col-xl-6 col-lg-6">
                                                <div class="form-group">
                                                    <label class="text-dark ft-medium">Company Name</label>
                                                    <input type="text" name="company_name" class="form-control rounded" placeholder="Company Name" value="<?php echo ($display_name) ?>">
                                                </div>
                                            </div>
                                            <div class="col-xl-6 col-lg-6">
                                                <div class="form-group">
                                                    <label class="text-dark ft-medium">Email</label>
                                                    <input type="email" class="form-control rounded" readonly value="<?php echo ($current_user->user_email) ?>">
                                                </div>
                                            </div>
                                            <div class="col-xl-6 col-lg-6">
                                                <div class="form-group">
                                                    <label class="text-dark ft-medium">Phone</label>
                                                    <input type="text" name="worplex_field_user_phone" class="form-control rounded" value="<?php echo worplex_esc_html($phone_number) ?>">
                                                </div>
                                            </div>
                                            <?php
                                            $saved_cats = wp_get_post_terms($employer_id, 'employer_cat', array('fields' => 'ids'));
                                            $employer_cat = isset($saved_cats[0]) ? $saved_cats[0] : '';
                                            $get_cats = get_terms(array(
                                                'taxonomy' => 'employer_cat',
                                                'fields' => 'id=>name',
                                                'parent' => 0,
                                                'orderby' => 'name',
                                                'order' => 'ASC',
                                                'hide_empty' => false,
                                            ));
                                            ?>
                                            <div class="col-xl-6 col-lg-6">
                                                <div class="form-group">
                                                    <label class="text-dark ft-medium">Category</label>
                                                    <select name="employer_cat" class="form-select rounded">
                                                        <option value="">Choose Category</option>
                                                        <?php
                                                        if (!empty($get_cats)) {
                                                            foreach ($get_cats as $cat_id => $cat_label) {
                                                                ?>
                                                                <option value="<?php echo ($cat_id) ?>"<?php echo ($cat_id == $employer_cat ? ' selected' : '') ?>><?php echo ($cat_label) ?></option>
                                                                <?php
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-xl-6 col-lg-6">
                                                <div class="form-group">
                                                    <label class="text-dark ft-medium">Contact info view (for public)</label>
                                                    <select name="worplex_field_public_info" class="form-select rounded">
                                                        <option value="yes">Yes</option>
                                                        <option value="no"<?php echo ($public_info == 'no' ? ' selected' : '') ?>>No</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-xl-6 col-lg-6">
                                                <div class="form-group">
                                                    <label class="text-dark ft-medium">Founded Date</label>
                                                    <input type="text" name="worplex_field_founded_date" class="form-control rounded worplex-datepicker" placeholder="18-06-1989" value="<?php echo worplex_esc_html($found_date) ?>">
                                                </div>
                                            </div>
                                            <div class="col-xl-6 col-lg-6">
                                                <div class="form-group">
                                                    <label class="text-dark ft-medium">Website URL</label>
                                                    <input type="url" name="web_url" class="form-control rounded" placeholder="https://my-site.com/" value="<?php echo ($current_user->user_url) ?>">
                                                </div>
                                            </div>
                                            <div class="col-xl-12 col-lg-12">
                                                <div class="form-group">
                                                    <label class="text-dark ft-medium">Company Info</label>
                                                    <?php
                                                    $settings = array(
                                                        'media_buttons' => false,
                                                        'editor_class' => 'worplex-editor-field',
                                                        'textarea_name' => 'info_content',
                                                        'quicktags' => false,
                                                        'textarea_rows' => 10,
                                                        'tinymce' => array(
                                                            'toolbar1' => 'bold,bullist,numlist,italic,underline,alignleft,aligncenter,alignright,separator,link,unlink,undo,redo',
                                                            'toolbar2' => '',
                                                            'toolbar3' => '',
                                                        ),
                                                    );
                                                    $desc = worplex_esc_wp_editor($desc);
                                                    wp_editor($desc, 'short-desc-' . $rand_num, $settings);
                                                    ?>
                                                </div>
                                            </div>
                                            
                                            <div class="col-xl-12 col-lg-12">
                                                <div class="form-group">
                                                    <input type="hidden" name="action" value="worplex_employer_dashboard_profile_save_call">
                                                    <button type="submit" class="btn btn-md ft-medium text-light rounded theme-bg">Save Changes</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                } else {
                                    $desc = '';
                                    $profile_img_url = '';
                                    if ($candidate_id) {
                                        $candidate_obj = get_post($candidate_id);
                                        $desc = isset($candidate_obj->post_content) ? $candidate_obj->post_content : '';
                                        $desc = trim(apply_filters('the_content', $desc));

                                        $img_thumb_id = get_post_thumbnail_id($candidate_id);
                                        $profile_img_url = wp_get_attachment_image_url($img_thumb_id, 'medium');
                                    }
                                    $job_title = get_post_meta($candidate_id, 'worplex_field_job_title', true);
                                    $phone_number = get_post_meta($candidate_id, 'worplex_field_user_phone', true);
                                    $dob = get_post_meta($candidate_id, 'worplex_field_dob', true);
                                    $public_info = get_post_meta($candidate_id, 'worplex_field_public_info', true);
                                    $salary = get_post_meta($candidate_id, 'worplex_field_salary', true);
                                    $salary_unit = get_post_meta($candidate_id, 'worplex_field_salary_unit', true);
                                    ?>
                                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12">
                                        <div id="logofile-name-container" class="custom-file avater_uploads">
                                            <input id="logofile-custom-input" type="file" name="user_profile_pic" onchange="worplex_dashb_image_file_change(event)" accept="image/png, image/jpg, image/jpeg" class="custom-file-input">
                                            <label class="custom-file-label logo-img-con" for="logofile-custom-input">
                                                <img src="<?php echo ($profile_img_url) ?>" alt=""<?php echo ($profile_img_url != '' ? '' : ' style="display: none;"') ?>>
                                                <i class="worplex-fa worplex-faicon-user"<?php echo ($profile_img_url != '' ? ' style="display: none;"' : '') ?>></i>
                                            </label>
                                        </div>
                                    </div>
                                    
                                    <div class="col-xl-9 col-lg-9 col-md-9 col-sm-12">
                                        <div class="row">
                                            <div class="col-xl-6 col-lg-6">
                                                <div class="form-group">
                                                    <label class="text-dark ft-medium">Full Name</label>
                                                    <input type="text" name="user_full_name" class="form-control rounded" placeholder="Full Name" value="<?php echo worplex_esc_html($display_name) ?>">
                                                </div>
                                            </div>
                                            <div class="col-xl-6 col-lg-6">
                                                <div class="form-group">
                                                    <label class="text-dark ft-medium">Job Title</label>
                                                    <input type="text" name="worplex_field_job_title" class="form-control rounded" value="<?php echo worplex_esc_html($job_title) ?>" placeholder="Graphic Designer">
                                                </div>
                                            </div>
                                            <div class="col-xl-6 col-lg-6">
                                                <div class="form-group">
                                                    <label class="text-dark ft-medium">Email</label>
                                                    <input type="email" class="form-control rounded" readonly value="<?php echo ($current_user->user_email) ?>">
                                                </div>
                                            </div>
                                            <div class="col-xl-6 col-lg-6">
                                                <div class="form-group">
                                                    <label class="text-dark ft-medium">Phone</label>
                                                    <input type="text" name="worplex_field_user_phone" class="form-control rounded" value="<?php echo worplex_esc_html($phone_number) ?>">
                                                </div>
                                            </div>
                                            <div class="col-xl-6 col-lg-6">
                                                <div class="form-group">
                                                    <label class="text-dark ft-medium">Date of Birth</label>
                                                    <input type="text" name="worplex_field_dob" class="form-control rounded worplex-datepicker" placeholder="18-06-1992" value="<?php echo worplex_esc_html($dob) ?>">
                                                </div>
                                            </div>
                                            <?php
                                            $saved_cats = wp_get_post_terms($candidate_id, 'candidate_cat', array('fields' => 'ids'));
                                            $candidate_cat = isset($saved_cats[0]) ? $saved_cats[0] : '';
                                            $get_cats = get_terms(array(
                                                'taxonomy' => 'candidate_cat',
                                                'fields' => 'id=>name',
                                                'parent' => 0,
                                                'orderby' => 'name',
                                                'order' => 'ASC',
                                                'hide_empty' => false,
                                            ));
                                            ?>
                                            <div class="col-xl-6 col-lg-6">
                                                <div class="form-group">
                                                    <label class="text-dark ft-medium">Category</label>
                                                    <select name="sec_category" class="form-select rounded">
                                                        <option value="">Choose Category</option>
                                                        <?php
                                                        if (!empty($get_cats)) {
                                                            foreach ($get_cats as $cat_id => $cat_label) {
                                                                ?>
                                                                <option value="<?php echo ($cat_id) ?>"<?php echo ($cat_id == $candidate_cat ? ' selected' : '') ?>><?php echo ($cat_label) ?></option>
                                                                <?php
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-xl-6 col-lg-6">
                                                <div class="form-group">
                                                    <label class="text-dark ft-medium">Contact info view (for public)</label>
                                                    <select name="worplex_field_public_info" class="form-select rounded">
                                                        <option value="yes">Yes</option>
                                                        <option value="no"<?php echo ($public_info == 'no' ? ' selected' : '') ?>>No</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-xl-6 col-lg-6">
                                                <div class="row">
                                                    <div class="col-xl-6 col-lg-6">
                                                        <div class="form-group">
                                                            <label class="text-dark ft-medium">Current Salary</label>
                                                            <input type="number" name="worplex_field_salary" min="1" class="form-control rounded" placeholder="60000" value="<?php echo worplex_esc_html($salary) ?>">
                                                        </div>
                                                    </div>
                                                    <?php
                                                    $salary_units_list = worplex_salary_units_list();
                                                    ?>
                                                    <div class="col-xl-6 col-lg-6">
                                                        <div class="form-group">
                                                            <label class="text-dark ft-medium">Salary Unit</label>
                                                            <select name="worplex_field_salary_unit" class="form-select rounded">
                                                                <?php
                                                                foreach ($salary_units_list as $salary_unit_key => $salary_unit_label) {
                                                                    ?>
                                                                    <option value="<?php echo ($salary_unit_key) ?>"<?php echo ($salary_unit == $salary_unit_key ? ' selected' : '') ?>><?php echo ($salary_unit_label) ?></option>
                                                                    <?php
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php
                                            $saved_skills = wp_get_post_terms($candidate_id, 'candidate_skill', array('fields' => 'names'));
                                            $saved_skills_str = '';
                                            if (!empty($saved_skills)) {
                                                $saved_skills_str = implode(', ', $saved_skills);
                                            }
                                            ?>
                                            <div class="col-xl-12 col-lg-12">
                                                <div class="form-group">
                                                    <label class="text-dark ft-medium">Skills (Comma Separated)</label>
                                                    <input type="text" name="user_skills" class="form-control rounded" placeholder="e.x PHP, SEO, Marketing" value="<?php echo ($saved_skills_str) ?>">
                                                </div>
                                            </div>
                                            <div class="col-xl-12 col-lg-12">
                                                <div class="form-group">
                                                    <label class="text-dark ft-medium">About Info</label>
                                                    <?php
                                                    $settings = array(
                                                        'media_buttons' => false,
                                                        'editor_class' => 'worplex-editor-field',
                                                        'textarea_name' => 'info_content',
                                                        'quicktags' => false,
                                                        'textarea_rows' => 10,
                                                        'tinymce' => array(
                                                            'toolbar1' => 'bold,bullist,numlist,italic,underline,alignleft,aligncenter,alignright,separator,link,unlink,undo,redo',
                                                            'toolbar2' => '',
                                                            'toolbar3' => '',
                                                        ),
                                                    );
                                                    $desc = worplex_esc_wp_editor($desc);
                                                    wp_editor($desc, 'short-desc-' . $rand_num, $settings);
                                                    ?>
                                                </div>
                                            </div>
                                            
                                            <div class="col-xl-12 col-lg-12">
                                                <div class="form-group">
                                                    <input type="hidden" name="action" value="worplex_user_dashboard_profile_save_call">
                                                    <button type="submit" class="btn btn-md ft-medium text-light rounded theme-bg">Save Changes</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                }
                                ?>
                            </div>    
                        </form>
                        
                    </div>
                </div>
            </div>
        </div>
        
        <?php
        if ($candidate_id || $employer_id) {
            $facebook_url = get_post_meta($member_id, 'worplex_field_facebook_url', true);
            $twitter_url = get_post_meta($member_id, 'worplex_field_twitter_url', true);
            $linkedin_url = get_post_meta($member_id, 'worplex_field_linkedin_url', true);
            $google_url = get_post_meta($member_id, 'worplex_field_google_url', true);
            ?>
            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <div class="_dashboard_content bg-white rounded mb-4">
                        <div class="_dashboard_content_header br-bottom py-3 px-3">
                            <div class="_dashboard__header_flex">
                                <h4 class="mb-0 ft-medium fs-md"><i class="ti-facebook me-1 theme-cl fs-sm"></i>Social Accounts</h4>	
                            </div>
                        </div>
                        
                        <div class="_dashboard_content_body py-3 px-3">
                            <form method="post" class="worplex-dashb-form">
                                <div class="row">
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
                                        <div class="form-group">
                                            <label class="text-dark ft-medium">Facebook</label>
                                            <input type="text" name="worplex_field_facebook_url" value="<?php echo worplex_esc_html($facebook_url) ?>" class="form-control rounded" placeholder="https://www.facebook.com/">
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
                                        <div class="form-group">
                                            <label class="text-dark ft-medium">Twitter</label>
                                            <input type="text" name="worplex_field_twitter_url" value="<?php echo worplex_esc_html($twitter_url) ?>" class="form-control rounded" placeholder="https://www.twitter.com/">
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
                                        <div class="form-group">
                                            <label class="text-dark ft-medium">LinkedIn</label>
                                            <input type="text" name="worplex_field_linkedin_url" value="<?php echo worplex_esc_html($linkedin_url) ?>" class="form-control rounded" placeholder="https://www.linkedin.com/">
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
                                        <div class="form-group">
                                            <label class="text-dark ft-medium">GooglePlus</label>
                                            <input type="text" name="worplex_field_google_url" value="<?php echo worplex_esc_html($google_url) ?>" class="form-control rounded" placeholder="https://www.gplus.com/">
                                        </div>
                                    </div>
                                    <div class="col-xl-12 col-lg-12">
                                        <div class="form-group">
                                            <input type="hidden" name="action" value="worplex_user_dashboard_social_save_call">
                                            <button type="submit" class="btn btn-md ft-medium text-light rounded theme-bg">Save Changes</button>
                                        </div>
                                    </div>
                                    
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-12 col-md-12">
                    <div class="_dashboard_content bg-white rounded mb-4">
                        <div class="_dashboard_content_header br-bottom py-3 px-3">
                            <div class="_dashboard__header_flex">
                                <h4 class="mb-0 ft-medium fs-md"><i class="worplex-fas worplex-faicon-lock me-1 theme-cl fs-sm"></i>Contact Information</h4>	
                            </div>
                        </div>
                        <?php
                        $country = get_post_meta($member_id, 'worplex_field_loc_country', true);
                        $loc_city = get_post_meta($member_id, 'worplex_field_loc_city', true);
                        $loc_address = get_post_meta($member_id, 'worplex_field_loc_address', true);
                        $loc_latitude = get_post_meta($member_id, 'worplex_field_loc_latitude', true);
                        $loc_longitude = get_post_meta($member_id, 'worplex_field_loc_longitude', true);
                        ?>
                        <div class="_dashboard_content_body py-3 px-3">
                            <form method="post" class="worplex-dashb-form">
                                <div class="row">	
                                    <div class="col-xl-6 col-lg-6 col-md-12">
                                        <div class="form-group">
                                            <label class="text-dark ft-medium">Country</label>
                                            <select name="worplex_field_loc_country" class="form-select rounded">
                                                <option value="">Select Country</option>
                                                <?php
                                                foreach ($worplex_countries_list as $country_code => $contry_name) {
                                                    ?>
                                                    <option value="<?php echo ($contry_name) ?>"<?php echo ($country == $contry_name ? ' selected' : '') ?>><?php echo ($contry_name) ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-6 col-md-12">
                                        <div class="form-group">
                                            <label class="text-dark ft-medium">City</label>
                                            <input type="text" class="form-control rounded" name="worplex_field_loc_city" value="<?php echo worplex_esc_html($loc_city) ?>" placeholder="City Name">
                                        </div>
                                    </div>
                                    <div class="col-xl-12 col-lg-12 col-md-12">
                                        <div class="form-group">
                                            <label class="text-dark ft-medium">Full Address</label>
                                            <input type="text" class="form-control rounded" name="worplex_field_loc_address" value="<?php echo worplex_esc_html($loc_address) ?>" placeholder="H#10 Marke Juger, SBI Road">
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-6 col-md-12">
                                        <div class="form-group">
                                            <label class="text-dark ft-medium">Latitude</label>
                                            <input type="text" class="form-control rounded" name="worplex_field_loc_latitude" value="<?php echo worplex_esc_html($loc_latitude) ?>" placeholder="51.5">
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-6 col-md-12">
                                        <div class="form-group">
                                            <label class="text-dark ft-medium">Longitude</label>
                                            <input type="text" class="form-control rounded" name="worplex_field_loc_longitude" value="<?php echo worplex_esc_html($loc_longitude) ?>" placeholder="0.12">
                                        </div>
                                    </div>
                                    <div class="col-xl-12 col-lg-12">
                                        <div class="form-group">
                                            <input type="hidden" name="action" value="worplex_user_dashboard_location_save_call">
                                            <button type="submit" class="btn btn-md ft-medium text-light rounded theme-bg">Save Changes</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>	
            </div>	
            <?php
        }
        ?>
    </div>
    <?php
    $html = ob_get_clean();
    return $html;
}
