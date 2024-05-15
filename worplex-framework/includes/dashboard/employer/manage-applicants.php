<?php

add_filter('worplex_dashboard_employer_manage_applicants_html', 'worplex_dashboard_employer_manage_applicants_html');

function worplex_dashboard_employer_manage_applicants_html() {

    global $wpdb, $current_user, $worplex_framework_options;

    $user_id = $current_user->ID;

    $account_page_name = isset($worplex_framework_options['user_dashboard_page']) ? $worplex_framework_options['user_dashboard_page'] : '';

    $account_page_id = worplex_get_page_id_from_name($account_page_name);

    $account_page_url = home_url('/');
    if ($account_page_id > 0) {
        $account_page_url = get_permalink($account_page_id);
    }

    $no_res_found = true;

    ob_start();

    $post_query = "SELECT posts.ID FROM $wpdb->posts AS posts";
    $post_query .= " WHERE posts.post_type='jobs' AND post_author='$user_id'";
    $get_db_res = $wpdb->get_col($post_query);
    ?>
    <div class="dashboard-widg-bar d-block">
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12">

                <?php
                if (isset($get_db_res[0])) {
                    $args = array(
                        'post_type' => 'job_applic',
                        'posts_per_page' => '50',
                        'post_status' => 'publish',
                        'meta_query' => array(
                            array(
                                'key' => 'applic_job_id',
                                'value' => $get_db_res,
                                'compare' => 'IN'
                            )
                        ),
                        'order' => 'DESC',
                        'orderby' => 'ID',
                    );
            
                    $posts_query = new WP_Query($args);
            
                    if ($posts_query->have_posts()) {
                        ?>
                        <div class="px-3 py-2 br-bottom br-top bg-white rounded mb-3">
                            <div class="flixors">
                                <div class="row align-items-center justify-content-between">
                                    <div class="col-xl-3 col-lg-4 col-md-5 col-sm-12">
                                        <h6 class="mb-0 ft-medium fs-sm"><?php printf(esc_html__('%s Applicants Found', 'worplex-frame'), $posts_query->found_posts) ?></h6>
                                    </div>
                                    
                                    <div class="col-xl-9 col-lg-8 col-md-7 col-sm-12">
                                        <div class="filter_wraps elspo_wrap d-flex align-items-center justify-content-end">
                                            <div class="single_fitres me-2">
                                                <select class="form-select simple" name="sort_by">
                                                    <option value="">Default Sorting</option>
                                                    <option value="name">Short By Name</option>
                                                    <option value="recent">Shot By Recent</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                        <?php
                        echo '<div class="data-responsive">';
                        while ($posts_query->have_posts()) : $posts_query->the_post();
                            $applic_id = get_the_id();
                            $applic_obj = get_post($applic_id);
                            $applic_post_date = $applic_obj->post_date;
                            
                            $job_id = get_post_meta($applic_id, 'applic_job_id', true);
                            $aplicant_job_title = get_post_meta($applic_id, 'applic_job_title', true);
                            $aplicant_email = get_post_meta($applic_id, 'applic_user_email', true);

                            $img_url = Worplex_Plugin::root_url() . 'images/user.png';
                            $img_urls = get_post_meta($applic_id, 'applic_user_pic_urls', true);
                            if (isset($img_urls['crop']) && $img_urls['crop'] != '') {
                                $img_url = $img_urls['crop'];
                            }
                            ?> 
                            <div class="dashed-list-wrap bg-white rounded mb-3">
                                <div class="dashed-list-full bg-white rounded p-3 mb-3">
                                    <div class="dashed-list-short d-flex align-items-center">
                                        <div class="dashed-list-short-first">
                                            <div class="dashed-avater"><img src="<?php echo ($img_url) ?>" class="img-fluid circle" width="70" alt=""></div>
                                        </div>
                                        <div class="dashed-list-short-last">
                                            <div class="cats-box-caption px-2">
                                                <h4 class="fs-lg mb-0 ft-medium theme-cl"><?php echo get_the_title($applic_id) ?></h4>
                                                <div class="d-block mb-2 position-relative">
                                                    <span><i class="lni lni-map-marker me-1"></i>United States</span>
                                                    <span class="ms-2"><i class="lni lni-briefcase me-1"></i><?php echo ($aplicant_job_title) ?></span>
                                                </div>
                                                <div class="ico-content">
                                                    <ul>
                                                        <li><a href="javascript:void(0);" class="px-2 py-1 medium bg-light-success rounded text-success"><i class="lni lni-download me-1"></i>Download CV</a></li>
                                                        <li><a href="#" data-bs-toggle="modal" data-bs-target="#message" class="px-2 py-1 medium bg-light-info rounded text-info"><i class="lni lni-envelope me-1"></i>Message</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="dashed-list-last">
                                        <div class="text-left">
                                            <a href="#" data-bs-toggle="modal" data-bs-target="#note" class="btn gray ft-medium apply-btn fs-sm rounded me-1"><i class="lni lni-add-files me-1"></i>Note</a>
                                            <a href="javascript:void(0);" class="btn gray ft-medium apply-btn fs-sm rounded"><i class="lni lni-heart me-1"></i>Save</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="dashed-list-footer p-3 br-top">
                                    
                                    <div class="ico-content">
                                        <ul>
                                            <li><span><i class="lni lni-calendar me-1"></i><?php echo date_i18n(get_option('date_format'), strtotime($applic_post_date)) ?></span></li>
                                            <li><span><i class="lni lni-add-files me-1"></i>Recent</span></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <?php
                                
                        endwhile;
                        wp_reset_postdata();
                        echo '</div>';
                        $no_res_found = false;
                    }
                }
                if ($no_res_found) {
                    echo '<div class="px-3 py-2 br-bottom br-top bg-white rounded mb-3"><p>' . esc_html__('No results found.', 'worplex-frame') . '</p></div>';
                }
                ?>
            </div>
        </div>
            
    </div>
    <?php
    $html = ob_get_clean();
    return $html;
}
