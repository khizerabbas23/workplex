<?php

defined('ABSPATH') || exit;

class Jobcircle_Meta_Boxes
{

    public function __construct()
    {
        add_action('save_post', array($this, 'save_meta_fields'), 5);
        add_action('add_meta_boxes', array($this, 'post_layout_meta_boxes'));
    }

    public function save_meta_fields($post_id = '')
    {

        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }

        foreach ($_POST as $key => $value) {
            if (strstr($key, 'worplex_field_')) {
                update_post_meta($post_id, $key, $value);
            }
        }
    }

    public function post_layout_meta_boxes()
    {
        add_meta_box('worplex-post-layout', esc_html__('Post Layout', 'worplex-frame'), array($this, 'post_layout_meta'), 'post', 'side');
        add_meta_box('worplex-post-layout', esc_html__('Job Layout', 'worplex-frame'), array($this, 'post_layout_meta'), 'jobs', 'side');
        add_meta_box('worplex-page-layout', esc_html__('Page Layout', 'worplex-frame'), array($this, 'post_layout_meta'), 'page', 'side');
        add_meta_box('worplex-page-subheader', esc_html__('SELELCT SUBHEADER', 'worplex-frame'), array($this, 'sub_header'), 'page', 'side');
        add_meta_box('worplex-list-famous-job', esc_html__('Job Settings', 'worplex-frame'), array($this, 'list_framing_jobs'), 'jobs');
        add_meta_box('worplex-list-famous-job', esc_html__('Candidate Settings', 'worplex-frame'), array($this, 'list_candidate_meta'), 'candidates');
        add_meta_box('worplex-list-famous-job', esc_html__('Top Category Jobs', 'worplex-frame'), array($this, 'employe_jobs'), 'employer');
    }

    public function post_layout_meta()
    {
        global $worplex_framework_options, $post;

        $post_layout = get_post_meta($post->ID, 'worplex_field_post_layout', true);
        $post_sidebar = get_post_meta($post->ID, 'worplex_field_post_sidebar', true);

        $sidebars_array = array();
        $worplex_sidebars = isset($worplex_framework_options['worplex-themes-sidebars']) ? $worplex_framework_options['worplex-themes-sidebars'] : '';
        if (is_array($worplex_sidebars) && sizeof($worplex_sidebars) > 0) {
            foreach ($worplex_sidebars as $sidebar) {
                $sadbar_id = sanitize_title($sidebar);
                $sidebars_array[$sadbar_id] = $sidebar;
            }
        }
?>
        <div class="worplex-post-layout">
            <div class="worplex-element-field">
                <div class="elem-label">
                    <label><?php esc_html_e('Select Layout', 'worplex-frame') ?></label>
                </div>
                <div class="elem-field">
                    <select name="worplex_field_post_layout">
                        <option value="full" <?php echo ($post_layout == 'full' ? ' selected' : '') ?>><?php esc_html_e('Full', 'worplex-frame') ?></option>
                        <option value="right" <?php echo ($post_layout == 'right' ? ' selected' : '') ?>><?php esc_html_e('Right Sidebar', 'worplex-frame') ?></option>
                        <option value="left" <?php echo ($post_layout == 'left' ? ' selected' : '') ?>><?php esc_html_e('Left Sidebar', 'worplex-frame') ?></option>
                    </select>
                </div>
            </div>
            <div class="worplex-element-field">
                <div class="elem-label">
                    <label><?php esc_html_e('Select Sidebar', 'worplex-frame') ?></label>
                </div>
                <div class="elem-field">
                    <select name="worplex_field_post_sidebar">
                        <option value="" <?php echo ($post_sidebar == '' ? ' selected' : '') ?>><?php esc_html_e('Select Sidebar', 'worplex-frame') ?></option>
                        <?php
                        if (!empty($sidebars_array)) {
                            foreach ($sidebars_array as $sidebar_id => $sidebar_title) {
                        ?>
                                <option value="<?php echo ($sidebar_id) ?>" <?php echo ($post_sidebar == $sidebar_id ? ' selected' : '') ?>><?php echo ($sidebar_title) ?></option>
                        <?php
                            }
                        }
                        ?>
                    </select>
                </div>
            </div>
        </div>
    <?php
    }
    public function sub_header()
    {
        global $worplex_framework_options, $post;

        $post_layout = get_post_meta($post->ID, 'worplex_field_sub_header', true);
    ?>
        <div class="mediclf-post-layout">
            <div class="mediclf-element-field">
                <div class="elem-label">
                    <label><?php esc_html_e('subheader ON & OFF', 'mediclf') ?></label>
                </div>
                <div class="elem-field">
                    <select name="worplex_field_sub_header">

                        <option value="on" <?php echo ($post_layout == 'on' ? ' selected' : '') ?>><?php esc_html_e('ON', 'mediclf') ?></option>
                        <option value="off" <?php echo ($post_layout == 'off' ? ' selected' : '') ?>><?php esc_html_e('OFF', 'mediclf') ?></option>
                    </select>
                </div>
            </div>
        </div>
    <?php
    }

    public function list_framing_jobs() {

        global $worplex_countries_list, $post;

        //
        $job_id = $post->ID;

        $job_style_view = get_post_meta($job_id, 'worplex_field_job_detail_view', true);

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

        $job_types_list = worplex_job_types_list();
        $salary_units_list = worplex_salary_units_list();
        
        //
        wp_enqueue_style('worplex-datetimepicker');
        wp_enqueue_script('worplex-datetimepicker-full');
        ?>
        <script>
            jQuery(document).ready(function() {
                if (jQuery('.worplex-datepicker').length > 0) {
                    var todayDate = new Date().getDate();
                    jQuery('.worplex-datepicker').datetimepicker({
                        maxDate: new Date(new Date().setDate(todayDate)),
                        timepicker: false,
                        format: 'd-m-Y',
                        scrollMonth: false,
                        scrollInput: false
                    });
                }
                if (jQuery('.worplex-datepicker-min').length > 0) {
                    jQuery('.worplex-datepicker-min').datetimepicker({
                        minDate: new Date(new Date().setDate(todayDate)),
                        timepicker: false,
                        format: 'd-m-Y',
                        scrollMonth: false,
                        scrollInput: false
                    });
                }
            });
        </script>
        <div class="worplex-list-famous-job">
            <div class="worplex-post-layout">

                <div class="elem-label">
                    <label class="label-detail"><?php esc_html_e('Job Style', 'worplex') ?></label>
                    <div class="input-detail">
                        <select name="worplex_field_job_detail_view">
                            <option value="">Default View</option>
                            <option value="style1"<?php echo ($job_style_view == 'style1' ? ' selected' : '') ?>>Style 1</option>
                            <option value="style2"<?php echo ($job_style_view == 'style2' ? ' selected' : '') ?>>Style 2</option>
                            <option value="style3"<?php echo ($job_style_view == 'style3' ? ' selected' : '') ?>>Style 3</option>
                            <option value="style4"<?php echo ($job_style_view == 'style4' ? ' selected' : '') ?>>Style 4</option>
                        </select>
                    </div>
                </div>
                <div class="elem-label">
                    <label class="label-detail"><?php esc_html_e('Job Type', 'worplex') ?></label>
                    <div class="input-detail">
                        <select name="worplex_field_job_type">
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
                <div class="elem-label">
                    <label class="label-detail"><?php esc_html_e('Application Deadline', 'worplex') ?></label>
                    <div class="input-detail">
                        <input type="text" name="worplex_field_job_deadline" class="worplex-datepicker-min" value="<?php echo ($application_deadline) ?>">
                    </div>
                </div>
                <div class="elem-label">
                    <label class="label-detail"><?php esc_html_e('Minimum Salary', 'worplex') ?></label>
                    <div class="input-detail">
                        <input type="text" name="worplex_field_min_salary" value="<?php echo ($min_salary) ?>">
                    </div>
                </div>
                <div class="elem-label">
                    <label class="label-detail"><?php esc_html_e('Maximum Salary', 'worplex') ?></label>
                    <div class="input-detail">
                        <input type="text" name="worplex_field_max_salary" value="<?php echo ($max_salary) ?>">
                    </div>
                </div>
                <div class="elem-label">
                    <label class="label-detail"><?php esc_html_e('Salary Unit', 'worplex') ?></label>
                    <div class="input-detail">
                        <select name="worplex_field_salary_unit">
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
                <div class="elem-label">
                    <label class="label-detail"><?php esc_html_e('Country', 'worplex') ?></label>
                    <div class="input-detail">
                        <select name="worplex_field_loc_country">
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
                <div class="elem-label">
                    <label class="label-detail"><?php esc_html_e('City', 'worplex') ?></label>
                    <div class="input-detail">
                        <input type="text" name="worplex_field_loc_city" value="<?php echo ($loc_city) ?>">
                    </div>
                </div>
                <div class="elem-label">
                    <label class="label-detail"><?php esc_html_e('Full Address', 'worplex') ?></label>
                    <div class="input-detail">
                        <input type="text" name="worplex_field_loc_address" value="<?php echo ($loc_address) ?>">
                    </div>
                </div>
                <div class="elem-label">
                    <label class="label-detail"><?php esc_html_e('Latitude', 'worplex') ?></label>
                    <div class="input-detail">
                        <input type="text" name="worplex_field_loc_latitude" value="<?php echo ($loc_latitude) ?>">
                    </div>
                </div>
                <div class="elem-label">
                    <label class="label-detail"><?php esc_html_e('Longitude', 'worplex') ?></label>
                    <div class="input-detail">
                        <input type="text" name="worplex_field_loc_longitude" value="<?php echo ($loc_longitude) ?>">
                    </div>
                </div>

            </div>
        </div>
        <?php
    }

    public function list_candidate_meta() {

        global $worplex_countries_list, $post;

        //
        $candidate_id = $post->ID;

        $job_title = get_post_meta($candidate_id, 'worplex_field_job_title', true);
        $phone_number = get_post_meta($candidate_id, 'worplex_field_user_phone', true);
        $dob = get_post_meta($candidate_id, 'worplex_field_dob', true);
        $public_info = get_post_meta($candidate_id, 'worplex_field_public_info', true);
        $salary = get_post_meta($candidate_id, 'worplex_field_salary', true);
        $salary_unit = get_post_meta($candidate_id, 'worplex_field_salary_unit', true);
        $facebook_url = get_post_meta($candidate_id, 'worplex_field_facebook_url', true);
        $twitter_url = get_post_meta($candidate_id, 'worplex_field_twitter_url', true);
        $linkedin_url = get_post_meta($candidate_id, 'worplex_field_linkedin_url', true);
        $google_url = get_post_meta($candidate_id, 'worplex_field_google_url', true);
        $country = get_post_meta($candidate_id, 'worplex_field_loc_country', true);
        $loc_city = get_post_meta($candidate_id, 'worplex_field_loc_city', true);
        $loc_address = get_post_meta($candidate_id, 'worplex_field_loc_address', true);
        $loc_latitude = get_post_meta($candidate_id, 'worplex_field_loc_latitude', true);
        $loc_longitude = get_post_meta($candidate_id, 'worplex_field_loc_longitude', true);

        $salary_units_list = worplex_salary_units_list();
        
        //
        wp_enqueue_style('worplex-datetimepicker');
        wp_enqueue_script('worplex-datetimepicker-full');
        ?>
        <script>
            jQuery(document).ready(function() {
                if (jQuery('.worplex-datepicker').length > 0) {
                    var todayDate = new Date().getDate();
                    jQuery('.worplex-datepicker').datetimepicker({
                        maxDate: new Date(new Date().setDate(todayDate)),
                        timepicker: false,
                        format: 'd-m-Y',
                        scrollMonth: false,
                        scrollInput: false
                    });
                }
                if (jQuery('.worplex-datepicker-min').length > 0) {
                    jQuery('.worplex-datepicker-min').datetimepicker({
                        minDate: new Date(new Date().setDate(todayDate)),
                        timepicker: false,
                        format: 'd-m-Y',
                        scrollMonth: false,
                        scrollInput: false
                    });
                }
            });
        </script>
        <div class="worplex-list-famous-job">
            <div class="worplex-post-layout">

                <div class="elem-label">
                    <label class="label-detail"><?php esc_html_e('Job Title', 'worplex') ?></label>
                    <div class="input-detail">
                        <input type="text" name="worplex_field_job_title" value="<?php echo ($job_title) ?>">
                    </div>
                </div>
                <div class="elem-label">
                    <label class="label-detail"><?php esc_html_e('Phone', 'worplex') ?></label>
                    <div class="input-detail">
                        <input type="text" name="worplex_field_user_phone" value="<?php echo ($phone_number) ?>">
                    </div>
                </div>
                <div class="elem-label">
                    <label class="label-detail"><?php esc_html_e('Date of Birth', 'worplex') ?></label>
                    <div class="input-detail">
                        <input type="text" name="worplex_field_dob" class="worplex-datepicker" value="<?php echo ($dob) ?>">
                    </div>
                </div>
                <div class="elem-label">
                    <label class="label-detail"><?php esc_html_e('Contact info view (for public)', 'worplex') ?></label>
                    <div class="input-detail">
                        <select name="worplex_field_public_info">
                            <option value="yes"<?php echo ($public_info == 'yes' ? ' selected' : '') ?>><?php esc_html_e('Yes', 'worplex-frame') ?></option>
                            <option value="no"<?php echo ($public_info == 'no' ? ' selected' : '') ?>><?php esc_html_e('No', 'worplex-frame') ?></option>
                        </select>
                    </div>
                </div>
                <div class="elem-label">
                    <label class="label-detail"><?php esc_html_e('Salary', 'worplex') ?></label>
                    <div class="input-detail">
                        <input type="text" name="worplex_field_salary" value="<?php echo ($salary) ?>">
                    </div>
                </div>
                <div class="elem-label">
                    <label class="label-detail"><?php esc_html_e('Salary Unit', 'worplex') ?></label>
                    <div class="input-detail">
                        <select name="worplex_field_salary_unit">
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
                <div class="elem-label">
                    <label class="label-detail"><?php esc_html_e('Facebook', 'worplex') ?></label>
                    <div class="input-detail">
                        <input type="text" name="worplex_field_facebook_url" value="<?php echo ($facebook_url) ?>">
                    </div>
                </div>
                <div class="elem-label">
                    <label class="label-detail"><?php esc_html_e('Twitter', 'worplex') ?></label>
                    <div class="input-detail">
                        <input type="text" name="worplex_field_twitter_url" value="<?php echo ($twitter_url) ?>">
                    </div>
                </div>
                <div class="elem-label">
                    <label class="label-detail"><?php esc_html_e('LinkedIn', 'worplex') ?></label>
                    <div class="input-detail">
                        <input type="text" name="worplex_field_linkedin_url" value="<?php echo ($linkedin_url) ?>">
                    </div>
                </div>
                <div class="elem-label">
                    <label class="label-detail"><?php esc_html_e('GooglePlus', 'worplex') ?></label>
                    <div class="input-detail">
                        <input type="text" name="worplex_field_google_url" value="<?php echo ($google_url) ?>">
                    </div>
                </div>
                <div class="elem-label">
                    <label class="label-detail"><?php esc_html_e('Country', 'worplex') ?></label>
                    <div class="input-detail">
                        <select name="worplex_field_loc_country">
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
                <div class="elem-label">
                    <label class="label-detail"><?php esc_html_e('City', 'worplex') ?></label>
                    <div class="input-detail">
                        <input type="text" name="worplex_field_loc_city" value="<?php echo ($loc_city) ?>">
                    </div>
                </div>
                <div class="elem-label">
                    <label class="label-detail"><?php esc_html_e('Full Address', 'worplex') ?></label>
                    <div class="input-detail">
                        <input type="text" name="worplex_field_loc_address" value="<?php echo ($loc_address) ?>">
                    </div>
                </div>
                <div class="elem-label">
                    <label class="label-detail"><?php esc_html_e('Latitude', 'worplex') ?></label>
                    <div class="input-detail">
                        <input type="text" name="worplex_field_loc_latitude" value="<?php echo ($loc_latitude) ?>">
                    </div>
                </div>
                <div class="elem-label">
                    <label class="label-detail"><?php esc_html_e('Longitude', 'worplex') ?></label>
                    <div class="input-detail">
                        <input type="text" name="worplex_field_loc_longitude" value="<?php echo ($loc_longitude) ?>">
                    </div>
                </div>

            </div>
        </div>
        <?php
    }

    public function employe_jobs()
    {
        global $worplex_countries_list, $post;

        $employer_id = $post->ID;

        $phone_number = get_post_meta($employer_id, 'worplex_field_user_phone', true);
        $dob = get_post_meta($employer_id, 'worplex_field_founded_date', true);
        $public_info = get_post_meta($employer_id, 'worplex_field_public_info', true);
        $facebook_url = get_post_meta($employer_id, 'worplex_field_facebook_url', true);
        $twitter_url = get_post_meta($employer_id, 'worplex_field_twitter_url', true);
        $linkedin_url = get_post_meta($employer_id, 'worplex_field_linkedin_url', true);
        $google_url = get_post_meta($employer_id, 'worplex_field_google_url', true);
        $country = get_post_meta($employer_id, 'worplex_field_loc_country', true);
        $loc_city = get_post_meta($employer_id, 'worplex_field_loc_city', true);
        $loc_address = get_post_meta($employer_id, 'worplex_field_loc_address', true);
        $loc_latitude = get_post_meta($employer_id, 'worplex_field_loc_latitude', true);
        $loc_longitude = get_post_meta($employer_id, 'worplex_field_loc_longitude', true);
        
        //
        wp_enqueue_style('worplex-datetimepicker');
        wp_enqueue_script('worplex-datetimepicker-full');
        ?>
        <script>
            jQuery(document).ready(function() {
                if (jQuery('.worplex-datepicker').length > 0) {
                    var todayDate = new Date().getDate();
                    jQuery('.worplex-datepicker').datetimepicker({
                        maxDate: new Date(new Date().setDate(todayDate)),
                        timepicker: false,
                        format: 'd-m-Y',
                        scrollMonth: false,
                        scrollInput: false
                    });
                }
                if (jQuery('.worplex-datepicker-min').length > 0) {
                    jQuery('.worplex-datepicker-min').datetimepicker({
                        minDate: new Date(new Date().setDate(todayDate)),
                        timepicker: false,
                        format: 'd-m-Y',
                        scrollMonth: false,
                        scrollInput: false
                    });
                }
            });
        </script>
        <div class="worplex-list-famous-job">
            <div class="worplex-post-layout">

                <div class="elem-label">
                    <label class="label-detail"><?php esc_html_e('Phone', 'worplex') ?></label>
                    <div class="input-detail">
                        <input type="text" name="worplex_field_user_phone" value="<?php echo ($phone_number) ?>">
                    </div>
                </div>
                <div class="elem-label">
                    <label class="label-detail"><?php esc_html_e('Founded Date', 'worplex') ?></label>
                    <div class="input-detail">
                        <input type="text" name="worplex_field_founded_date" class="worplex-datepicker" value="<?php echo ($dob) ?>">
                    </div>
                </div>
                <div class="elem-label">
                    <label class="label-detail"><?php esc_html_e('Contact info view (for public)', 'worplex') ?></label>
                    <div class="input-detail">
                        <select name="worplex_field_public_info">
                            <option value="yes"<?php echo ($public_info == 'yes' ? ' selected' : '') ?>><?php esc_html_e('Yes', 'worplex-frame') ?></option>
                            <option value="no"<?php echo ($public_info == 'no' ? ' selected' : '') ?>><?php esc_html_e('No', 'worplex-frame') ?></option>
                        </select>
                    </div>
                </div>
                <div class="elem-label">
                    <label class="label-detail"><?php esc_html_e('Facebook', 'worplex') ?></label>
                    <div class="input-detail">
                        <input type="text" name="worplex_field_facebook_url" value="<?php echo ($facebook_url) ?>">
                    </div>
                </div>
                <div class="elem-label">
                    <label class="label-detail"><?php esc_html_e('Twitter', 'worplex') ?></label>
                    <div class="input-detail">
                        <input type="text" name="worplex_field_twitter_url" value="<?php echo ($twitter_url) ?>">
                    </div>
                </div>
                <div class="elem-label">
                    <label class="label-detail"><?php esc_html_e('LinkedIn', 'worplex') ?></label>
                    <div class="input-detail">
                        <input type="text" name="worplex_field_linkedin_url" value="<?php echo ($linkedin_url) ?>">
                    </div>
                </div>
                <div class="elem-label">
                    <label class="label-detail"><?php esc_html_e('GooglePlus', 'worplex') ?></label>
                    <div class="input-detail">
                        <input type="text" name="worplex_field_google_url" value="<?php echo ($google_url) ?>">
                    </div>
                </div>
                <div class="elem-label">
                    <label class="label-detail"><?php esc_html_e('Country', 'worplex') ?></label>
                    <div class="input-detail">
                        <select name="worplex_field_loc_country">
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
                <div class="elem-label">
                    <label class="label-detail"><?php esc_html_e('City', 'worplex') ?></label>
                    <div class="input-detail">
                        <input type="text" name="worplex_field_loc_city" value="<?php echo ($loc_city) ?>">
                    </div>
                </div>
                <div class="elem-label">
                    <label class="label-detail"><?php esc_html_e('Full Address', 'worplex') ?></label>
                    <div class="input-detail">
                        <input type="text" name="worplex_field_loc_address" value="<?php echo ($loc_address) ?>">
                    </div>
                </div>
                <div class="elem-label">
                    <label class="label-detail"><?php esc_html_e('Latitude', 'worplex') ?></label>
                    <div class="input-detail">
                        <input type="text" name="worplex_field_loc_latitude" value="<?php echo ($loc_latitude) ?>">
                    </div>
                </div>
                <div class="elem-label">
                    <label class="label-detail"><?php esc_html_e('Longitude', 'worplex') ?></label>
                    <div class="input-detail">
                        <input type="text" name="worplex_field_loc_longitude" value="<?php echo ($loc_longitude) ?>">
                    </div>
                </div>

            </div>
        </div>
        <?php
    }
    public function top_cate_jobs()
    {
        global $worplex_framework_options, $post;


        $time_tag = get_post_meta($post->ID, 'worplex_field_time_tag', true);

    ?>
        <div class="worplex-list-famous-job">
            <div class="worplex-post-layout">




                <div class="elem-label">
                    <label class="label-detail"><?php esc_html_e('Image', 'worplex') ?></label>
                    <input class="input-detail" type="file" name="worplex_field_time_tag" value="<?php echo $time_tag ?>">
                </div>
            </div>
        </div>

<?php
    }
}

new Jobcircle_Meta_Boxes;
