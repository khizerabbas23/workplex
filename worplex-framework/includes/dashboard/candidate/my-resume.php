<?php

add_filter('worplex_dashboard_candidate_my_resume_html', 'worplex_dashboard_candidate_my_resume_html');

function worplex_dashboard_candidate_my_resume_html() {
    global $current_user;

    wp_enqueue_script('jquery-ui-sortable');

    $user_id = $current_user->ID;
    $candidate_id = worplex_user_candidate_id($user_id);

    $all_itms = get_post_meta($candidate_id, 'education_record_list', true);
    
    ob_start();
    ?>
    
    <div class="dashboard-widg-bar d-block">
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="_dashboard_content bg-white rounded mb-4">
                    <div class="_dashboard_content_header br-bottom py-3 px-3">
                        <div class="_dashboard__header_flex">
                            <h4 class="mb-0 ft-medium fs-md"><i class="worplex-fas worplex-faicon-graduation-cap me-1 theme-cl fs-sm"></i>Education Details</h4>
                        </div>
                    </div>
                    <div class="worplex-dashb-multilist worplex-dashbcand-edulist">
                        <?php
                        if (!empty($all_itms)) {
                            foreach ($all_itms as $itm_id => $itm_record) {
                                echo worplex_dashresm_add_eduitm_html($itm_record, $itm_id);
                            }
                        }
                        ?>
                    </div>
                    <div class="_dashboard_content_body py-3 px-3">
                        <form method="post" class="worplex-dashb-form candidate-addedu-form">
                            <div class="row">
                                <div class="col-xl-12 col-lg-12">
                                    <div class="gray rounded p-3 mb-3 position-relative">
                                        <div class="form-group">
                                            <label class="text-dark ft-medium">School Name</label>
                                            <input type="text" name="schoolname" class="form-control rounded" required placeholder="School Name">
                                        </div>
                                        <div class="form-group">
                                            <label class="text-dark ft-medium">Qualification</label>
                                            <input type="text" name="qualification" class="form-control rounded" required placeholder="Qualification Title">
                                        </div>
                                        <div class="form-row row">
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label class="text-dark ft-medium">Start Date</label>
                                                    <input type="text" name="startdate" class="form-control rounded worplex-datepicker" required placeholder="dd-mm-yyyy">
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label class="text-dark ft-medium">End Date</label>
                                                    <input type="text" name="enddate" class="form-control rounded worplex-datepicker" required placeholder="dd-mm-yyyy">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="text-dark ft-medium">Note</label>
                                            <textarea name="note" class="form-control ht-80" placeholder="Note Optional"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-12 col-lg-12">
                                    <div class="form-group">
                                        <input type="hidden" name="action" value="worplex_resume_add_education_call">
                                        <button type="submit" class="btn gray ft-medium apply-btn fs-sm rounded"><i class="worplex-fas worplex-faicon-plus me-1"></i>Add Education</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <?php
        $all_itms = get_post_meta($candidate_id, 'experience_record_list', true);
        ?>
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="_dashboard_content bg-white rounded mb-4">
                    <div class="_dashboard_content_header br-bottom py-3 px-3">
                        <div class="_dashboard__header_flex">
                            <h4 class="mb-0 ft-medium fs-md"><i class="worplex-fas worplex-faicon-graduation-cap me-1 theme-cl fs-sm"></i>Experience Details</h4>
                        </div>
                    </div>
                    <div class="worplex-dashb-multilist worplex-dashbcand-experiencelist">
                        <?php
                        if (!empty($all_itms)) {
                            foreach ($all_itms as $itm_id => $itm_record) {
                                echo worplex_dashresm_experience_itm_html($itm_record, $itm_id);
                            }
                        }
                        ?>
                    </div>
                    <div class="_dashboard_content_body py-3 px-3">
                        <form method="post" class="worplex-dashb-form candidate-addexperience-form">
                            <div class="row">
                                <div class="col-xl-12 col-lg-12">
                                    <div class="gray rounded p-3 mb-3 position-relative">
                                        <div class="form-group">
                                            <label class="text-dark ft-medium">Employer/Company Name</label>
                                            <input type="text" name="company" class="form-control rounded" required placeholder="ABC Textile">
                                        </div>
                                        <div class="form-group">
                                            <label class="text-dark ft-medium">Job Title</label>
                                            <input type="text" name="job_title" class="form-control rounded" required placeholder="Graphic Designer">
                                        </div>
                                        <div class="form-row row candash-form-centrow">
                                            <div class="col-4">
                                                <div class="form-group">
                                                    <label class="text-dark ft-medium">Start Date</label>
                                                    <input type="text" name="startdate" class="form-control rounded worplex-datepicker" required placeholder="dd-mm-yyyy">
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="form-group">
                                                    <label class="text-dark ft-medium">End Date</label>
                                                    <input type="text" name="enddate" class="form-control rounded worplex-datepicker" placeholder="dd-mm-yyyy">
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="form-group candash-form-chkbutncon">
                                                    <input id="experience-still-work" type="checkbox" name="still_working" value="on">
                                                    <label for="experience-still-work" class="text-dark ft-medium">Still working here</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="text-dark ft-medium">Note</label>
                                            <textarea name="note" class="form-control ht-80" placeholder="Note Optional"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-12 col-lg-12">
                                    <div class="form-group">
                                        <input type="hidden" name="action" value="worplex_resume_add_experience_call">
                                        <button type="submit" class="btn gray ft-medium apply-btn fs-sm rounded"><i class="worplex-fas worplex-faicon-plus me-1"></i>Add Experience</button>
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
    $html = ob_get_clean();
    return $html;
}

add_action('wp_head', function() {
    ?>
    <style>
        .worplex-dashb-multilist {
            position: relative;
            display: inline-block;
            width: 100%;
            padding: 20px;
            margin: 20px 0 0;
        }
        .worplex-dashb-multilitm {
            display: inline-block;
            width: 100%;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        .worplex-dashb-multilitm .multilitm-hder {
            display: flex;
            width: 100%;
            background-color: #e9f8ef;
            justify-content: space-between;
        }
        .multilitm-hder .hder-inititle-con {
            display: flex;
            flex: 0 0 calc(100% - 150px);
            gap: 15px;
            align-items: center;
        }
        .hder-inititle-con .multili-sorter {
            display: flex;
            margin: 0px 0 0 15px;
            padding: 3px 7px;
            background-color: #17b67c;
            color: #fff;
            border-radius: 4px;
            cursor: pointer;
        }
        .hder-inititle-con .multili-sorter i {
            font-size: 18px;
            line-height: 20px;
        }
        .hder-inititle-con .multili-titltxt {
            display: inline-block;
            flex: 0 0 100%;
            padding: 15px 0;
            cursor: pointer;
        }
        .hder-inititle-con .multili-titltxt strong {
            color: #172228;
        }
        .multilitm-hder .hder-iniactions-con {
            display: flex;
            flex: 0 0 85px;
            justify-content: end;
            align-items: center;
            gap: 10px;
        }
        .multilitm-hder .hder-iniactions-con a {
            display: flex;
            flex: 0 0 25px;
            height: 25px;
            align-items: center;
            justify-content: center;
            color: #fff;
            border-radius: 4px;
        }
        .hder-iniactions-con a.multili-act-remove {
            background-color: #f02727;
            margin: 0 15px 0 0;
        }
        .hder-iniactions-con a.multili-act-edit {
            background-color: #17b67c;
        }
        .worplex-dashb-multilist .ui-state-highlight {
            display: inline-block;
            width: 100%;
            height: 50px;
            background-color: #fffff0;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        .candash-form-centrow {
            align-items: center;
        }
        .candash-form-centrow .candash-form-chkbutncon {
            display: flex;
            align-items: center;
            gap: 4px;
            margin-top: 25px;
        }
        .candash-form-centrow .candash-form-chkbutncon label {
            line-height: 20px;
            margin: 0;
            cursor: pointer;
        }
    </style>
    <?php
}, 25);

function worplex_dashresm_add_eduitm_html($atts, $rand_id) {
    
    $schoolname = isset($atts['schoolname']) ? $atts['schoolname'] : '';
    $qualification = isset($atts['qualification']) ? $atts['qualification'] : '';
    $startdate = isset($atts['startdate']) ? $atts['startdate'] : '';
    $enddate = isset($atts['enddate']) ? $atts['enddate'] : '';
    $note = isset($atts['note']) ? $atts['note'] : '';

    $dates_str = date_i18n(get_option('date_format'), strtotime($startdate)) . ' - ' . date_i18n(get_option('date_format'), strtotime($enddate));

    ob_start();
    ?>
    <div class="worplex-dashb-multilitm" data-id="<?php echo ($rand_id) ?>">
        <div class="multilitm-hder">
            <div class="hder-inititle-con">
                <div class="multili-sorter"><i class="worplex-fas worplex-faicon-bars"></i></div>
                <div class="multili-titltxt"><strong><?php echo ($qualification) ?></strong> <span>(<?php echo ($dates_str) ?>)</span></div>
            </div>
            <div class="hder-iniactions-con">
                <a href="javascript:;" class="multili-act-edit"><i class="worplex-fas worplex-faicon-pencil-alt"></i></a>
                <a href="javascript:;" class="multili-act-remove"><i class="worplex-fas worplex-faicon-trash-alt"></i></a>
            </div>
        </div>
    </div>
    <?php
    $html = ob_get_clean();

    return $html;
}

add_action('wp_ajax_worplex_resume_add_education_call', function () {
    global $current_user;

    $rand_id = rand(10000000, 99999999);
    $schoolname = worplex_esc_html($_POST['schoolname']);
    $qualification = worplex_esc_html($_POST['qualification']);
    $startdate = worplex_esc_html($_POST['startdate']);
    $enddate = worplex_esc_html($_POST['enddate']);
    $note = worplex_esc_html($_POST['note']);

    if ($schoolname == '' || $qualification == '' || $startdate == '' || $enddate == '') {
        $ret_data = array('error' => '1', 'msg' => esc_html__('Please fill all mandatory fields.', 'worplex-frame'));
        wp_send_json($ret_data);
    }

    $atts = array(
        'schoolname' => $schoolname,
        'qualification' => $qualification,
        'startdate' => $startdate,
        'enddate' => $enddate,
        'note' => $note,
    );

    $html = worplex_dashresm_add_eduitm_html($atts, $rand_id);

    $user_id = $current_user->ID;
    $candidate_id = worplex_user_candidate_id($user_id);
    if ($candidate_id) {
        $all_itms = get_post_meta($candidate_id, 'education_record_list', true);
        $all_itms = !empty($all_itms) ? $all_itms : array();

        $all_itms[$rand_id] = $atts;
        update_post_meta($candidate_id, 'education_record_list', $all_itms);
    } else {
        $ret_data = array('error' => '1', 'msg' => esc_html__('You are not allowed.', 'worplex-frame'));
        wp_send_json($ret_data);
    }

    $ret_data = array('error' => '0', 'id' => $rand_id, 'html' => $html, 'msg' => esc_html__('New record added successfully.', 'worplex-frame'));
    wp_send_json($ret_data);
});

add_action('wp_ajax_worplex_dashcand_eduitm_remove_call', function() {
    global $current_user;

    $user_id = $current_user->ID;
    $candidate_id = worplex_user_candidate_id($user_id);
    if ($candidate_id) {
        $all_itms = get_post_meta($candidate_id, 'education_record_list', true);
        
        $itm_id = $_POST['id'];
        if (isset($all_itms[$itm_id])) {
            unset($all_itms[$itm_id]);
            update_post_meta($candidate_id, 'education_record_list', $all_itms);
        }
    } else {
        $ret_data = array('error' => '1', 'msg' => esc_html__('You are not allowed.', 'worplex-frame'));
        wp_send_json($ret_data);
    }

    $ret_data = array('error' => '0', 'msg' => esc_html__('Record removed successfully.', 'worplex-frame'));
    wp_send_json($ret_data);
});

function worplex_dashresm_experience_itm_html($atts, $rand_id) {
    
    $company = isset($atts['company']) ? $atts['company'] : '';
    $job_title = isset($atts['job_title']) ? $atts['job_title'] : '';
    $startdate = isset($atts['startdate']) ? $atts['startdate'] : '';
    $enddate = isset($atts['enddate']) ? $atts['enddate'] : '';
    $still_working = isset($atts['still_working']) ? $atts['still_working'] : '';
    $note = isset($atts['note']) ? $atts['note'] : '';

    $enddate_str = esc_html__('Still Working', 'worplex-frame');
    if ($still_working != 'on' && $enddate != '') {
        $enddate_str = date_i18n(get_option('date_format'), strtotime($enddate));
    }
    $dates_str = date_i18n(get_option('date_format'), strtotime($startdate)) . ' - ' . $enddate_str;

    ob_start();
    ?>
    <div class="worplex-dashb-multilitm" data-id="<?php echo ($rand_id) ?>">
        <div class="multilitm-hder">
            <div class="hder-inititle-con">
                <div class="multili-sorter"><i class="worplex-fas worplex-faicon-bars"></i></div>
                <div class="multili-titltxt"><strong><?php echo ($job_title) ?></strong> <span>(<?php echo ($dates_str) ?>)</span></div>
            </div>
            <div class="hder-iniactions-con">
                <a href="javascript:;" class="multili-act-edit"><i class="worplex-fas worplex-faicon-pencil-alt"></i></a>
                <a href="javascript:;" class="multili-act-remove"><i class="worplex-fas worplex-faicon-trash-alt"></i></a>
            </div>
        </div>
    </div>
    <?php
    $html = ob_get_clean();

    return $html;
}

add_action('wp_ajax_worplex_resume_add_experience_call', function () {
    global $current_user;

    $rand_id = rand(10000000, 99999999);
    $company = worplex_esc_html($_POST['company']);
    $job_title = worplex_esc_html($_POST['job_title']);
    $startdate = worplex_esc_html($_POST['startdate']);
    $enddate = worplex_esc_html($_POST['enddate']);
    $note = worplex_esc_html($_POST['note']);

    if ($company == '' || $job_title == '' || $startdate == '') {
        $ret_data = array('error' => '1', 'msg' => esc_html__('Please fill all mandatory fields.', 'worplex-frame'));
        wp_send_json($ret_data);
    }

    $still_working = '';
    if (isset($_POST['still_working']) && $_POST['still_working'] == 'on') {
        $still_working = 'on';
    }

    $atts = array(
        'company' => $company,
        'job_title' => $job_title,
        'startdate' => $startdate,
        'enddate' => $enddate,
        'still_working' => $still_working,
        'note' => $note,
    );

    $html = worplex_dashresm_experience_itm_html($atts, $rand_id);

    $user_id = $current_user->ID;
    $candidate_id = worplex_user_candidate_id($user_id);
    if ($candidate_id) {
        $all_itms = get_post_meta($candidate_id, 'experience_record_list', true);
        $all_itms = !empty($all_itms) ? $all_itms : array();

        $all_itms[$rand_id] = $atts;
        update_post_meta($candidate_id, 'experience_record_list', $all_itms);
    } else {
        $ret_data = array('error' => '1', 'msg' => esc_html__('You are not allowed.', 'worplex-frame'));
        wp_send_json($ret_data);
    }

    $ret_data = array('error' => '0', 'id' => $rand_id, 'html' => $html, 'msg' => esc_html__('New record added successfully.', 'worplex-frame'));
    wp_send_json($ret_data);
});

add_action('wp_ajax_worplex_dashcand_experienceitm_remove_call', function() {
    global $current_user;

    $user_id = $current_user->ID;
    $candidate_id = worplex_user_candidate_id($user_id);
    if ($candidate_id) {
        $all_itms = get_post_meta($candidate_id, 'experience_record_list', true);
        
        $itm_id = $_POST['id'];
        if (isset($all_itms[$itm_id])) {
            unset($all_itms[$itm_id]);
            update_post_meta($candidate_id, 'experience_record_list', $all_itms);
        }
    } else {
        $ret_data = array('error' => '1', 'msg' => esc_html__('You are not allowed.', 'worplex-frame'));
        wp_send_json($ret_data);
    }

    $ret_data = array('error' => '0', 'msg' => esc_html__('Record removed successfully.', 'worplex-frame'));
    wp_send_json($ret_data);
});
