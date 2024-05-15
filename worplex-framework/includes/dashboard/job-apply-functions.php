<?php

defined('ABSPATH') || exit;

class Worplex_Job_Applications_Functions {
    
    public function __construct() {
        add_action('wp_footer', array($this, 'apply_job_popup'), 15);
        add_action('wp_head', array($this, 'apply_job_styling'), 15);

        add_action('init', array($this, 'register_applications_post_type'));

        add_action('wp_ajax_worplex_user_applyjob_action', array($this, 'user_applyjob_ajax'));
        add_action('wp_ajax_nopriv_worplex_user_applyjob_action', array($this, 'user_applyjob_ajax'));
    }

    public function apply_job_styling() {
        ?>
        <style>
            #worplex-apply-job-popup .login-pop-form {
                max-width: 650px;
            }
            #worplex-apply-job-popup .form-fields-group {
                display: flex;
                gap: 20px;
            }
            #worplex-apply-job-popup .form-fields-group .form-group {
                flex: 0 0 calc(50% - 10px);
            }
            #worplex-apply-job-popup .custom-file.avater_uploads {
                align-items: flex-start;
                height: 120px;
                width: 100%;
            }
            #worplex-apply-job-popup .custom-file.avater_uploads > div {
                position: relative;
                min-width: 100px;
            }
            #worplex-apply-job-popup .custom-file.avater_uploads input[type="file"] {
                display: none;
            }
            #worplex-apply-job-popup .custom-file.avater_uploads label.custom-file-label {
                height: 100px;
                width: 100px;
            }
            #worplex-apply-job-popup .custom-file.avater_uploads label.custom-file-label img {
                max-width: 98%;
                max-height: 98%;
            }
            #worplex-apply-job-popup .custom-file.avater_uploads label.custom-file-label i {
                font-size: 60px;
            }
            #worplex-apply-job-popup .form-middle-field {
                display: flex;
                justify-content: center;
                width: 100%;
            }
            #worplex-apply-job-popup .applyjob-form-cvfield {
                display: inline-block;
                position: relative;
                width: 100%;
                border: 2px dashed #999;
                border-radius: 10px;
                padding: 25px;
            }
            #worplex-apply-job-popup .applyjob-form-cvfield input[type="file"] {
                position: absolute;
                width: 100%;
                height: 100%;
                top: 0;
                left: 0;
                opacity: 0;
                cursor: pointer;
                z-index: 99;
            }
            #worplex-apply-job-popup .applyjob-form-cvfield > div {
                display: inline-block;
                width: 100%;
                text-align: center;
            }
            #worplex-apply-job-popup .applyjob-form-cvfield > div span {
                color: #333;
                line-height: 28px;
            }
            #worplex-apply-job-popup .applyjob-form-cvfield > div > i {
                font-size: 30px !important;
                margin-top: 15px;
            }
        </style>
        <?php
    }

    public function register_applications_post_type() {
        $labels = array(
            'name'                  => _x( 'Applications', 'Applications General Name', 'worplex' ),
            'singular_name'         => _x( 'Applications', 'Applications Singular Name', 'worplex' ),
            'menu_name'             => __( 'Applications', 'worplex' ),
            'name_admin_bar'        => __( 'Applications', 'worplex' ),
            'archives'              => __( 'Item Archives', 'worplex' ),
            'attributes'            => __( 'Item Attributes', 'worplex' ),
            'parent_item_colon'     => __( 'Parent Item:', 'worplex' ),
            'all_items'             => __( 'All Items', 'worplex' ),
            'add_new_item'          => __( 'Add New Item', 'worplex' ),
            'add_new'               => __( 'Add New', 'worplex' ),
            'new_item'              => __( 'New Item', 'worplex' ),
            'edit_item'             => __( 'Edit Item', 'worplex' ),
            'update_item'           => __( 'Update Item', 'worplex' ),
            'view_item'             => __( 'View Item', 'worplex' ),
            'view_items'            => __( 'View Items', 'worplex' ),
            'search_items'          => __( 'Search Item', 'worplex' ),
            'not_found'             => __( 'Not found', 'worplex' ),
            'not_found_in_trash'    => __( 'Not found in Trash', 'worplex' ),
            'featured_image'        => __( 'Featured Image', 'worplex' ),
            'set_featured_image'    => __( 'Set featured image', 'worplex' ),
            'remove_featured_image' => __( 'Remove featured image', 'worplex' ),
            'use_featured_image'    => __( 'Use as featured image', 'worplex' ),
            'insert_into_item'      => __( 'Insert into item', 'worplex' ),
            'uploaded_to_this_item' => __( 'Uploaded to this item', 'worplex' ),
            'items_list'            => __( 'Items list', 'worplex' ),
            'items_list_navigation' => __( 'Items list navigation', 'worplex' ),
            'filter_items_list'     => __( 'Sectors items list', 'worplex' ),
        );
        $args = array(
            'label'                 => __( 'Applications', 'worplex' ),
            'description'           => __( 'Applications Description', 'worplex' ),
            'labels'                => $labels,
            'supports'            => array( 'title', 'editor' ),
            'hierarchical'          => false,
            'public'                => false,
            'show_ui'               => false,
            'show_in_menu'          => true,
            'show_in_admin_bar'     => true,
            'show_in_nav_menus'     => true,
            'can_export'            => true,
            'has_archive'           => false,
            'exclude_from_search'   => true,
            'publicly_queryable'    => false,
        );
        register_post_type( 'job_applic', $args );
    }

    public function apply_job_popup() {
        global $current_user;

        $user_id = $current_user->ID;

        $user_name = '';
        $user_email = '';
        $job_title = '';

        $candidate_id = worplex_user_candidate_id($user_id);
        if (is_user_logged_in() && $candidate_id) {
            $user_obj = get_user_by('id', $user_id);
            $user_name = get_the_title($candidate_id);
            $user_email = isset($user_obj->user_email) ? $user_obj->user_email : '';
            $job_title = get_post_meta($candidate_id, 'worplex_field_job_title', true);
        }
        ?>
        <div class="modal fade" id="worplex-apply-job-popup" tabindex="-1" role="dialog" aria-labelledby="apply-job-modal" aria-hidden="true">
            <div class="modal-dialog login-pop-form" role="document">
                <div class="modal-content">
                    <div class="modal-headers">
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span class="ti-close"></span>
                        </button>
                    </div>
                
                    <div class="modal-body p-5 popup-loginsec-con">
                        <div class="text-center mb-4">
                            <h2 class="m-0 ft-regular">Apply Job</h2>
                        </div>
                        
                        <form method="post" class="worplex-user-form loding-onall-con">
                            <div id="logofile-name-container" class="custom-file avater_uploads">
                                <div>
                                    <input id="applypic-custom-input" type="file" name="job_apply_pic" onchange="worplex_form_image_file_change(event)" accept="image/png, image/jpg, image/jpeg" class="custom-file-input">
                                    <label class="custom-file-label logo-img-con" for="applypic-custom-input">
                                        <img class="logo-img-con" src="" alt="" style="display: none;">
                                        <i class="worplex-fa worplex-faicon-user"></i>
                                    </label>
                                </div>
                            </div>
                            <div class="form-fields-group">
                                <div class="form-group">
                                    <label>Name</label>
                                    <input type="text" name="user_name" class="form-control" value="<?php echo ($user_name) ?>" placeholder="John Doe" required>
                                </div>
                                <div class="form-group">
                                    <label>Email Address</label>
                                    <input type="email" name="user_email" class="form-control" value="<?php echo ($user_email) ?>" placeholder="example@abc.com" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Job Title</label>
                                <input type="text" name="job_title" class="form-control" value="<?php echo ($job_title) ?>" placeholder="Graphic Designer" required>
                            </div>
                            <div class="form-group">
                                <label>Note</label>
                                <textarea name="aplic_notes" class="form-control" placeholder="Type any message here"></textarea>
                            </div>
                            <div class="form-group">
                                <div class="form-middle-field">
                                    <div class="applyjob-form-cvfield">
                                        <input type="file" name="apply_job_resume" accept="image/png, image/jpg, image/jpeg, application/msword, application/vnd.openxmlformats-officedocument.wordprocessingml.document, application/pdf">
                                        <div class="apljob-file-namecon" style="display: none;"><span></span></div>
                                        <div class="apljob-file-upinfo"><span>Click or drag your file here to upload resume.</span></div>
                                        <div class="apljob-file-upinfo"><span>Suitable file types are .docx, .pdf, .jpg or .png</span></div>
                                        <div><i class="lni lni-upload me-1"></i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-security-fields" style="display: none;"></div>
                                <input type="hidden" name="action" value="worplex_user_applyjob_action">
                                <button type="submit" class="btn btn-md full-width theme-bg text-light fs-md ft-medium">Submit to Apply</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <script>
            jQuery('#worplex-apply-job-popup input[name="apply_job_resume"]').on('change', function() {
                var this_file = jQuery(this);
                var parnt_con = this_file.parents('.applyjob-form-cvfield');
                parnt_con.find('.apljob-file-namecon').html(this_file.val().split('\\').pop()).removeAttr('style');
                parnt_con.find('.apljob-file-upinfo').hide();
            });
        </script>
        <?php
    }

    public function user_applyjob_ajax() {

        global $wpdb;

        $job_id = $_POST['apply_job_id'];
        $aplicant_name = $_POST['user_name'];
        $aplicant_email = $_POST['user_email'];
        $aplicant_job_title = $_POST['job_title'];
        $aplicant_notes = $_POST['aplic_notes'];

        $aplicant_name = worplex_esc_html($aplicant_name);
        $aplicant_email = worplex_esc_html($aplicant_email);
        $aplicant_job_title = worplex_esc_html($aplicant_job_title);
        $aplicant_notes = worplex_esc_wp_editor($aplicant_notes);

        if ($aplicant_name == '') {
            $ret_data = array('error' => '1', 'msg' => esc_html__('Please fill your name field.', 'worplex-frame'));
            wp_send_json($ret_data);
        }
        if ($aplicant_email == '') {
            $ret_data = array('error' => '1', 'msg' => esc_html__('Email field cannot be blank.', 'worplex-frame'));
            wp_send_json($ret_data);
        }

        $post_query = "SELECT posts.ID FROM $wpdb->posts AS posts";
        $post_query .= " LEFT JOIN $wpdb->postmeta AS postmeta ON (posts.ID = postmeta.post_id)";
        $post_query .= " LEFT JOIN $wpdb->postmeta AS mt1 ON (posts.ID = mt1.post_id)";
        $post_query .= " WHERE posts.post_type='job_applic'";
        $post_query .= " AND postmeta.meta_key='applic_user_email' AND postmeta.meta_value='$aplicant_email'";
        $post_query .= " AND mt1.meta_key='applic_job_id' AND mt1.meta_value='$job_id'";
        $get_db_res = $wpdb->get_col($post_query);
        
        if (isset($get_db_res[0])) {
            $ret_data = array('error' => '1', 'msg' => esc_html__('You have already applied this job.', 'worplex-frame'));
            wp_send_json($ret_data);
        }

        $my_post = array(
            'post_title' => $aplicant_name,
            'post_content' => $aplicant_notes,
            'post_type' => 'job_applic',
            'post_status' => 'publish',
        );
        if (is_user_logged_in()) {
            global $current_user;
            $user_id = $current_user->ID;
            $my_post['post_author'] = $user_id;
        }
        $application_id = wp_insert_post($my_post);

        update_post_meta($application_id, 'applic_job_id', $job_id);
        update_post_meta($application_id, 'applic_job_title', $aplicant_job_title);
        update_post_meta($application_id, 'applic_user_email', $aplicant_email);

        //
        $img_urls = self::candupload_attach('job_apply_pic');
        update_post_meta($application_id, 'applic_user_pic_urls', $img_urls);

        if (isset($user_id)) {
            //
            $candidate_id = worplex_user_candidate_id($user_id);
            if ($candidate_id) {
                update_post_meta($application_id, 'user_cand_id', $candidate_id);
            }
        }
        
        $ret_data = array('error' => '0', 'redirect' => 'same', 'msg' => esc_html__('Job applied successfully.', 'worplex-frame'));
        wp_send_json($ret_data);
    }

    public static function candupload_attach($fieldname = 'file') {

        if (isset($_FILES[$fieldname]) && $_FILES[$fieldname] != '') {

            global $worplex__upload_files_extpath;
            $worplex__upload_files_extpath = 'user-files-' . rand(100000, 999999);
    
            add_filter('upload_dir', 'worplex__public_upload_files_path');
            
            $wp_upload_dir = wp_upload_dir();
    
            $upload_file = $_FILES[$fieldname];
    
            require_once ABSPATH . 'wp-admin/includes/image.php';
            require_once ABSPATH . 'wp-admin/includes/file.php';
            require_once ABSPATH . 'wp-admin/includes/media.php';
    
            $allowed_image_types = array(
                'jpg|jpeg' => 'image/jpeg',
                'png' => 'image/png',
                'gif' => 'image/gif',
            );
    
            $status_upload = wp_handle_upload($upload_file, array('test_form' => false, 'mimes' => $allowed_image_types));
    
            if (empty($status_upload['error'])) {
    
                $file_url = isset($status_upload['url']) ? $status_upload['url'] : '';
                $upload_file_path = $wp_upload_dir['path'] . '/' . basename($file_url);
    
                $folder_path = $wp_upload_dir['path'];
    
                $image = wp_get_image_editor($upload_file_path);
    
                if (!is_wp_error($image)) {
                    $file_name = basename($file_url);

                    $file_ext_strs = explode('.', $file_name);
                    $file_ext = end($file_ext_strs);
                    $image->resize(150, 150, true);

                    $crop_file_name = $wp_upload_dir['path'] . '/user-img-150.' . $file_ext;
                    $image->save($crop_file_name);

                    $crop_file_url = $wp_upload_dir['url'] . '/user-img-150.' . $file_ext;

                    $file_urls = array(
                        'path' => $folder_path,
                        'orig' => $file_url,
                        'crop' => $crop_file_url,
                    );
    
                    return $file_urls;
                }
            }
    
            remove_filter('upload_dir', 'worplex__public_upload_files_path');
        }
    
        return false;
    }

}
new Worplex_Job_Applications_Functions;