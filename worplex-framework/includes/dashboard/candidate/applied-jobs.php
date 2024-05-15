<?php

add_filter('worplex_dashboard_candidate_applied_jobs_html', 'worplex_dashboard_candidate_applied_jobs_html');

function worplex_dashboard_candidate_applied_jobs_html() {

    global $current_user, $worplex_framework_options;

    $user_id = $current_user->ID;
    $candidate_id = worplex_user_candidate_id($user_id);

    $account_page_name = isset($worplex_framework_options['user_dashboard_page']) ? $worplex_framework_options['user_dashboard_page'] : '';

    $account_page_id = worplex_get_page_id_from_name($account_page_name);

    $account_page_url = home_url('/');
    if ($account_page_id > 0) {
        $account_page_url = get_permalink($account_page_id);
    }

    ob_start();
    ?>
    <div class="dashboard-widg-bar d-block">
        <div class="row">
            <?php
            $args = array(
                'post_type' => 'job_applic',
                'posts_per_page' => '50',
                'post_status' => 'publish',
                'meta_query' => array(
                    array(
                        'key' => 'user_cand_id',
                        'value' => $candidate_id
                    )
                ),
                'order' => 'DESC',
                'orderby' => 'ID',
            );
    
            $posts_query = new WP_Query($args);
    
            if ($posts_query->have_posts()) {
                ?>
                <div class="col-xl-12 col-md-12 col-sm-12">
                    <div class="cl-justify">
                        
                        <div class="cl-justify-first">
                            <p class="m-0 p-0 ft-sm">You have applied <span class="text-dark ft-medium"><?php echo ($posts_query->found_posts) ?></span> jobs</p>
                        </div>
                        
                        <div class="cl-justify-last">
                            <div class="d-flex align-items-center justify-content-left">
                                <div class="dlc-list">
                                    <select class="form-control sm rounded">
                                        <option>All Jobs</option>
                                        <option>Full Time</option>
                                        <option>Part Time</option>
                                        <option>Freelancing</option>
                                        <option>Internship</option>
                                        <option>Contract</option>
                                    </select>
                                </div>
                                <div class="dlc-list ms-2">
                                    <select class="form-control sm rounded">
                                        <option>Show 20</option>
                                        <option>Show 30</option>
                                        <option>Show 40</option>
                                        <option>Show 50</option>
                                        <option>Show 100</option>
                                        <option>Show 250</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
                <div class="col-xl-12 col-lg-12 col-md-12">
                    <div class="mb-4 tbl-lg rounded overflow-hidden">
                        <div class="table-responsive bg-white">
                            <table class="table">
                                <thead class="thead-dark">
                                    <tr>
                                        <th scope="col">Job Title</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Applied Date</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    while ($posts_query->have_posts()) : $posts_query->the_post();
                                        $applic_id = get_the_id();
                                        $applic_obj = get_post($applic_id);
                                        $applic_post_date = $applic_obj->post_date;
                                        
                                        $job_id = get_post_meta($applic_id, 'applic_job_id', true);
                                        $aplicant_job_title = get_post_meta($applic_id, 'applic_job_title', true);
                                        $aplicant_email = get_post_meta($applic_id, 'applic_user_email', true);
            
                                        $img_url = Worplex_Plugin::root_url() . 'images/user.png';
                                        $img_thumb_id = get_post_thumbnail_id($job_id);
                                        if ($img_thumb_id > 0) {
                                            $img_url = wp_get_attachment_image_url($img_thumb_id, 'thumbnail');
                                        }
                                        ?>
                                        <tr>
                                            <td>
                                                <div class="cats-box rounded bg-white d-flex align-items-center">
                                                    <div class="text-center"><img src="<?php echo ($img_url) ?>" class="img-fluid" width="55" alt=""></div>
                                                    <div class="cats-box-caption px-2">
                                                        <h4 class="fs-md mb-0 ft-medium"><?php echo get_the_title($job_id) ?></h4>
                                                        <div class="d-block mb-2 position-relative">
                                                            <span class="text-muted medium"><i class="lni lni-map-marker me-1"></i>Liverpool, London</span>
                                                            <span class="muted medium ms-2 theme-cl"><i class="lni lni-briefcase me-1"></i>Full Time</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td><span class="text-info">Active</span></td>
                                            <td><?php echo date_i18n(get_option('date_format'), strtotime($applic_post_date)) ?></td>
                                            <td>
                                                <div class="dash-action">
                                                    <a href="<?php echo get_permalink($job_id) ?>" class="p-2 circle text-info bg-light-info d-inline-flex align-items-center justify-content-center me-1"><i class="lni lni-eye"></i></a>
                                                    <a href="javascript:void(0);" class="p-2 circle text-danger bg-light-danger d-inline-flex align-items-center justify-content-center ms-1"><i class="lni lni-trash-can"></i></a>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php
                                    endwhile;
                                    wp_reset_postdata();
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <?php
            } else {
                echo '<div class="col-xl-12 col-lg-12 col-md-12">';
                echo '<div class="px-3 py-2 br-bottom br-top bg-white rounded mb-3"><p>' . esc_html__('No results found.', 'worplex-frame') . '</p></div>';
                echo '</div>';
            }
            ?>
        </div>
        
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
                
            </div>
        </div>
            
    </div>
    <?php
    $html = ob_get_clean();
    return $html;
}
