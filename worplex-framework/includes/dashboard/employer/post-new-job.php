<?php

add_filter('worplex_dashboard_employer_post_job_html', 'worplex_dashboard_employer_post_job_html');

function worplex_dashboard_employer_post_job_html() {
    ob_start();
    worplex_employer_job_form();
    $html = ob_get_clean();
    return $html;
}

function worplex_employer_job_form() {

    global $current_user, $worplex_countries_list;

    $rand_num = rand(1000000, 9999999);

    $job_id = 0;
    $employer_id = 0;
    $user_logedin = false;
    $is_emp_job = false;

    $job_form_hding = 'Post Job';

    $display_name = '';
    $job_title = '';
    $desc = '';
    $job_img_url = '';
    $job_type = '';
    $application_deadline = '';
    $min_salary = '';
    $max_salary = '';
    $salary_unit = '';
    $country = '';
    $loc_city = '';
    $loc_address = '';
    $loc_latitude = '';
    $loc_longitude = '';

    if (is_user_logged_in()) {
        
        $user_id = $current_user->ID;
        $display_name = $current_user->display_name;

        $user_logedin = true;
        
        $employer_id = worplex_user_employer_id($user_id);
        if ($employer_id) {
            $display_name = get_the_title($employer_id);

            $job_id = isset($_GET['id']) ? $_GET['id'] : '';
            if ($job_id > 0 && get_post_type($job_id) == 'jobs') {
                $job_upd = true;
            }

            if (isset($job_upd)) {
                $is_emp_job = worplex_is_employer_job($job_id, $user_id);
            }

            //
            if ($is_emp_job) {
                $job_type = get_post_meta($job_id, 'worplex_field_job_type', true);
                $application_deadline = get_post_meta($job_id, 'worplex_field_job_deadline', true);
                $min_salary = get_post_meta($job_id, 'worplex_field_min_salary', true);
                $max_salary = get_post_meta($job_id, 'worplex_field_max_salary', true);
                $salary_unit = get_post_meta($job_id, 'worplex_field_salary_unit', true);
                $country = get_post_meta($job_id, 'worplex_field_loc_country', true);
                $loc_city = get_post_meta($job_id, 'worplex_field_loc_city', true);
                $loc_address = get_post_meta($job_id, 'worplex_field_loc_address', true);
                $loc_latitude = get_post_meta($job_id, 'worplex_field_loc_latitude', true);
                $loc_longitude = get_post_meta($job_id, 'worplex_field_loc_longitude', true);

                $job_obj = get_post($job_id);
                $job_title = isset($job_obj->post_title) ? $job_obj->post_title : '';
                $desc = isset($job_obj->post_content) ? $job_obj->post_content : '';
                $desc = trim(apply_filters('the_content', $desc));

                $img_thumb_id = get_post_thumbnail_id($job_id);
                $job_img_url = wp_get_attachment_image_url($img_thumb_id, 'medium');
                
                $job_form_hding = sprintf(esc_html__('Update job "%s"', 'worplex-frame'), $job_title);
            }
        }
    }

    $job_types_list = worplex_job_types_list();
    $salary_units_list = worplex_salary_units_list();
    ?>
    <div class="dashboard-widg-bar d-block">
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12">
                <div class="_dashboard_content bg-white rounded mb-4">
                    <div class="_dashboard_content_header br-bottom py-3 px-3">
                        <div class="_dashboard__header_flex">
                            <h4 class="mb-0 ft-medium fs-md"><i class="worplex-fa worplex-faicon-file me-1 theme-cl fs-sm"></i><?php echo ($job_form_hding) ?></h4>	
                        </div>
                    </div>
                    
                    <div class="_dashboard_content_body py-3 px-3">
                        <form method="post" class="worplex-dashb-form">
                            <div class="row">
                                <div class="col-xl-12 col-lg-12 col-md-12">
                                    <div class="row">
                                    
                                        <div class="col-xl-12 col-lg-12 col-md-12">
                                            <div class="form-group">
                                                <label class="text-dark ft-medium">Job Title</label>
                                                <input type="text" name="job_title" required class="form-control rounded" placeholder="Title" value="<?php echo worplex_esc_html($job_title) ?>">
                                            </div>
                                        </div>
                                        
                                        <div class="col-xl-12 col-lg-12 col-md-12">
                                            <div class="form-group">
                                                <label class="text-dark ft-medium">Job Description</label>
                                                <?php
                                                $settings = array(
                                                    'media_buttons' => false,
                                                    'editor_class' => 'worplex-editor-field',
                                                    'textarea_name' => 'job_content',
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
                                        <?php
                                        if (!$user_logedin) {
                                            ?>
                                            <div class="col-xl-6 col-lg-6 col-md-6">
                                                <div class="form-group">
                                                    <label class="text-dark ft-medium">Email Address</label>
                                                    <input type="text" name="user_email" class="form-control rounded" placeholder="Email">
                                                </div>
                                            </div>
                                            
                                            <div class="col-xl-6 col-lg-6 col-md-6">
                                                <div class="form-group">
                                                    <label class="text-dark ft-medium">Username</label>
                                                    <input type="text" name="username" class="form-control rounded" placeholder="User">
                                                </div>
                                            </div>
                                            <?php
                                        }
                                        //
                                        $saved_cats = wp_get_post_terms($job_id, 'job_category', array('fields' => 'ids'));
                                        $job_cat = isset($saved_cats[0]) ? $saved_cats[0] : '';
                                        $get_cats = get_terms(array(
                                            'taxonomy' => 'job_category',
                                            'fields' => 'id=>name',
                                            'parent' => 0,
                                            'orderby' => 'name',
                                            'order' => 'ASC',
                                            'hide_empty' => false,
                                        ));
                                        ?>
                                        <div class="col-xl-6 col-lg-6 col-md-6">
                                            <div class="form-group">
                                                <label class="text-dark ft-medium">Industry</label>
                                                <select name="job_cat" class="form-select rounded">
                                                    <option value="">Choose Industry</option>
                                                    <?php
                                                    if (!empty($get_cats)) {
                                                        foreach ($get_cats as $cat_id => $cat_label) {
                                                            ?>
                                                            <option value="<?php echo ($cat_id) ?>"<?php echo ($cat_id == $job_cat ? ' selected' : '') ?>><?php echo ($cat_label) ?></option>
                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        
                                        <div class="col-xl-6 col-lg-6 col-md-6">
                                            <div class="form-group">
                                                <label class="text-dark ft-medium">Job Type</label>
                                                <select name="worplex_field_job_type" class="form-control rounded">
                                                    <?php
                                                    foreach ($job_types_list as $job_type_key => $job_type_ar) {
                                                        ?>
                                                        <option value="<?php echo ($job_type_key) ?>"<?php echo ($job_type_key == $job_type ? ' selected' : '') ?>><?php echo ($job_type_ar['title']) ?></option>
                                                        <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        
                                        <div class="col-xl-12 col-lg-12 col-md-12">
                                            <div class="form-group">
                                                <label class="text-dark ft-medium">Application Deadline</label>
                                                <input type="text" name="worplex_field_job_deadline" class="form-control rounded worplex-datepicker-min" value="<?php echo worplex_esc_html($application_deadline) ?>" placeholder="dd-mm-yyyy">
                                            </div>
                                        </div>

                                        <div class="col-xl-12 col-lg-12 col-md-12">
                                            <div class="row">
                                                <div class="col-xl-4 col-lg-4 col-md-12">
                                                    <div class="form-group">
                                                        <label class="text-dark ft-medium">Minimum Salary</label>
                                                        <input type="text" name="worplex_field_min_salary" class="form-control rounded" value="<?php echo worplex_esc_html($min_salary) ?>" placeholder="5000">
                                                    </div>
                                                </div>
                                                <div class="col-xl-4 col-lg-4 col-md-12">
                                                    <div class="form-group">
                                                        <label class="text-dark ft-medium">Maximum Salary</label>
                                                        <input type="text" name="worplex_field_max_salary" class="form-control rounded" value="<?php echo worplex_esc_html($max_salary) ?>" placeholder="25000">
                                                    </div>
                                                </div>
                                                <div class="col-xl-4 col-lg-4 col-md-12">
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
                                        $saved_skills = wp_get_post_terms($job_id, 'job_skill', array('fields' => 'names'));
                                        $saved_skills_str = '';
                                        if (!empty($saved_skills)) {
                                            $saved_skills_str = implode(', ', $saved_skills);
                                        }
                                        ?>
                                        <div class="col-xl-12 col-lg-12">
                                            <div class="form-group">
                                                <label class="text-dark ft-medium">Skills Required (Comma Separated)</label>
                                                <input type="text" name="job_skills" class="form-control rounded" placeholder="e.x PHP, SEO, Marketing" value="<?php echo ($saved_skills_str) ?>">
                                            </div>
                                        </div>
                                        
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
                                        
                                        <div class="col-12">
                                            <div class="form-group">
                                                <input type="hidden" name="action" value="worplex_dash_job_post_call">
                                                <?php
                                                if ($is_emp_job) {
                                                    ?>
                                                    <input type="hidden" name="job_id" value="<?php echo ($job_id) ?>">
                                                    <button type="submit" class="btn btn-md ft-medium text-light rounded theme-bg">Update Job</button>
                                                    <?php
                                                } else {
                                                    ?>
                                                    <button type="submit" class="btn btn-md ft-medium text-light rounded theme-bg">Publish Job</button>
                                                    <?php
                                                }
                                                ?>
                                            </div>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <?php
}
